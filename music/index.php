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
  <script src="./song_card.js"></script>

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
      <!-- @CLEANUP: more unsecure php -->
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
              <audio hidden class="song-player" controls src="<?php echo $song['audio_file_path'] ?>"></audio>

              <div style="text-align: center;">
                <img class="custom-play-button unselectable" src="./../images/play_button.png" alt="play-pause-button" width=55% height=auto>
              </div>

              <div class="playbar">
                <div class="inner">
                  <img class="background-bar unselectable" src="./../images/playbar_empty.png" alt="playbar" width=100% height=25px>
                </div>
                <div class="inner">
                  <img class="progress-bar unselectable" src="./../images/playbar_full.png" alt="playbar" width=0%>
                  <img class="slider unselectable" src="./../images/play_slider.png" alt="playbar-slider" width=15px height=auto>
                </div>
              </div>

              <div class="time-stamp" style="test-align: center;">00:00:00</div>
            </div>           

            <div class="lyrics-button unselectable">show lyrics</div>
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
