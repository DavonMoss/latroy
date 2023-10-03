<!DOCTYPE html>

<html>

<head>
  <title>latroy/music</title>
  <link href="./styles.css" rel="stylesheet"/>
</head>

<body>
  <!-- Importing jQuery. -->
  <script src="./../libs/jquery-3.7.1.js"></script>

  <!-- Song card functionality. -->
  <script>
    let slide_speed = 500;		// SPEED TO REVEAL LYRICS AT.
 
    $(document).ready(function() {
      // playbar update code
      function update_playbar (custom_audio_player) {
        let audio = custom_audio_player.find(".song-player");
        let time = custom_audio_player.find(".time-stamp");
        let progress = custom_audio_player.find(".progress-bar");      
        let bg_bar = custom_audio_player.find(".custom-play-bar")

        // update time stamp 
        time.html(audio[0].currentTime);
        

        // animate progress bar THIS SHIT IS SCUFFED
        let percentage = audio[0].currentTime / audio[0].duration;
        progress.width(percentage * bg_bar.width());
        progress.height(bg_bar.height());
      }

      // lyric reveal code
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

      // play/pause button
      $(".song-card").on("click", ".custom-play-button", function(event) {
        let audio = $(this).parent().parent().find(".song-player");
        
        audio[0].ontimeupdate = function() {update_playbar($(this).parent())};

        if (audio[0].paused) {
          audio.trigger('play');
          $(this).attr('src', "./../images/pause_button.png");
        } else {
          audio.trigger('pause');
          $(this).attr('src', "./../images/play_button.png");        
        }
      });
    });
  </script>

  <div id="container">
    <!-- Back to home page button and icons. -->
    <div id="home">
      <a id="home-clickable" href="./..">
        <img src="./../images/back_3.png" alt="arrow" width=20% height=20%>
        <img src="./../images/win95pc.png" alt="pretty computer" width=30% height=30%>
      </a>
    </div>

    <!-- Code to generate cards for each sound file, will have an audio file, title, blurb, and lyrics. -->
    <div id="songs-list">
      <!-- Establish connection with DB and pull songs. -->
      <?php
        $servername = '127.0.0.1';
        $serverport = '3306';
        $dbuser = 'latroy_admin';
        $dbpass = 'admin';
        $dbname = 'latroy_net';

        $db_connection = mysqli_connect($servername, $dbuser, $dbpass, $dbname, $serverport);

        if(!$db_connection) {
          die("mission failed: " . mysqli_connect_error());
        } else {
          $songs = mysqli_query($db_connection, "select * from songs");
        }
      ?>

      <!-- Generate card for each song.  -->
      <?php while($song = mysqli_fetch_assoc($songs)) { ?>
        <div class="song-card">
          <div style="text-align: center;">
            <img src="./../images/win95music.png" alt="yandhi" width=100px height=100px>
            <div class="song-title"><?php echo $song['title']; ?>.wav</div>
          </div>
          <div>
            <div class="song-release-date"><?php echo $song['release_date']; ?></div>
            <div class="song-blurb"><?php echo $song['blurb']; ?></div>

            <div class="custom-audio-player">
              <audio class="song-player" controls src="<?php echo $song['audio_file_path'] ?>"></audio>
              <img class="custom-play-button" src="./../images/play_button.png" alt="play-pause-button" width=100% height=auto>
              <div>
                <img class="custom-play-bar" src="./../images/playbar_empty.png" alt="playbar">
                <img class="progress-bar" src="./../images/playbar_full.png" alt="playbar" width=0%>
                <img class="slider" src="./../images/play_slider.png" alt="playbar-slider" width=5% height=auto>
              </div>
              <div class="time-stamp">0:00</div>
            </div>           

            <div class="lyrics-button">show lyrics</div>
            <div class="song-lyrics">
              <?php
                $lyrics = file_get_contents($song['lyrics_file_path']); 
                echo nl2br($lyrics); 
              ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</body>

</html>
