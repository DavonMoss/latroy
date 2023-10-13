let slide_speed = 500;			// SPEED TO REVEAL LYRICS AT
let slider_lock = false;		// LOCK FLAG FOR PLAYBAR SLIDING LOGIC
let mouse_percentage = 0;		// POSITION OF MOUSE WITHIN PLAYBAR LENGTH [0 to 1]

$(document).ready(function() {

  function fetch_duration(player) {
    let audios = player.find(".song-player");
    let times = player.find(".time-stamp");

    for (let i = 0; i < times.length; i++) {
      times[i].innerText = format_time(audios[i].duration);
    }
  }

  $(window).on("load", function(){
    fetch_duration($(".custom-audio-player"));
  });


  // Helper function to convert time in seconds into HH:MM:SS format for song duration.
  function format_time(time) {
    // @CONSIDER: something in my heart is telling me that this is a weird way to do this but i dont know why
    let hours = Math.floor(time/3600);
    let minutes = Math.floor((time % 3600)/60);
    let seconds = Math.floor(time - (hours * 3600) - (minutes * 60));

    return hours.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0'); 
  }

  // Callback function to update custom playbar components based on state of currently playing song.
  function update_playbar (custom_audio_player) {
    let audio = custom_audio_player.find(".song-player");
    let time = custom_audio_player.find(".time-stamp");
    let progress = custom_audio_player.find(".progress-bar");      
    let bg_bar = custom_audio_player.find(".background-bar")
    let play_button = custom_audio_player.find(".custom-play-button");

    // update time stamp 
    time.html(format_time(audio[0].currentTime));
    time.css('color', 'grey');

    // animate progress bar
    let percentage = audio[0].currentTime / audio[0].duration;
    progress.width(percentage * bg_bar.width());
    progress.height(bg_bar.height());

    // switch to pause button if song is over
    if(audio[0].currentTime == audio[0].duration) {
      play_button.attr('src', "./../src/images/play_button.png");        
    }
  }

  // Function to handle clicking on the playbar to scroll/adjust the song position.
  function move_song_position(playbar) {
    let audio = playbar.parent().find(".song-player");
    let time = playbar.parent().find(".time-stamp");
    let progress = playbar.find(".progress-bar");
    let bg_bar = playbar.find(".background-bar");
   
    let percentage = (event.pageX - bg_bar.offset().left)/bg_bar.width();

    if(percentage >= 0 && percentage <= 1) {
      progress.width(percentage * bg_bar.width());
      progress.height(bg_bar.height());

      audio[0].currentTime = percentage * audio[0].duration;
      time.html(format_time(audio[0].currentTime)); 
      time.css('color', 'grey');
    } 
  }

  // Handling playbar inputs
  $(".song-card").on("mousedown", ".playbar", function(event) {
    event.preventDefault();
    slider_lock = true;
    move_song_position($(this));
  });

  $(".song-card").on("mousemove", ".playbar", function(event) {
    event.preventDefault();
    
    if(slider_lock) {
      move_song_position($(this));
    }
  });

  $(".song-card").on("mouseup mouseexit mouseenter", ".playbar", function(event) {
    event.preventDefault();
    if(slider_lock) {
      slider_lock = false;
    }
  });

  // show and hide lyrics functionality
  $(".song-card").on("click", ".lyrics-button", function(event) {
    let $lyrics = $(this).parent().find(".song-lyrics");
    let $lyrics_button = $(this);

    if($lyrics.is(':visible')) {
      $lyrics_button.html("show lyrics");
      $lyrics.slideUp(slide_speed);
    } else {
      $lyrics_button.html("hide lyrics");
      $lyrics.slideDown(slide_speed);
    }

    event.preventDefault();
  });

  // play/pause button functionality
  $(".song-card").on("click", ".custom-play-button", function(event) {
    let audio = $(this).parent().parent().find(".song-player");
    
    audio[0].ontimeupdate = function() {update_playbar($(this).parent())};

    if (audio[0].paused) {
      audio.trigger('play');
      $(this).attr('src', "./../src/images/pause_button.png");
    } else {
      audio.trigger('pause');
      $(this).attr('src', "./../src/images/play_button.png");        
    }
  });
});
