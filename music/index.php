<!DOCTYPE html>

<html>

<head>
  <title>latroy/music</title>
  <link href="./styles.css" rel="stylesheet"/>
</head>

<body>
  <div id="container">

    <!-- Back to home page button and icons. -->
    <div id="home">
      <a href="./..">
        <img src="./../images/arrow.png" alt="arrow" width=30% height=30%>
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
        <div id="song-card">
          <div id="song-release-date"><?php echo $song['release_date']; ?></div>
          <div id="song-title"><?php echo $song['title']; ?></div>
          <div id="song-blurb"><?php echo $song['blurb']; ?></div>
          <audio id-"song-player" controls src="<?php echo $song['audio_file_path'] ?>"></audio>
          <div id="song-lyrics"><?php echo $song['lyrics']; ?></div>
        </div>
      <?php } ?>
    </div>
  </div>
</body>

</html>
