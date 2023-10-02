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
            <audio class="song-player" controls src="<?php echo $song['audio_file_path'] ?>"></audio>
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
