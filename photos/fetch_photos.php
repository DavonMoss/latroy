<!-- @CLEANUP: more unsafe php -->
<?php
  $db_connection = mysqli_connect("127.0.0.1", "latroy_admin", "admin", "latroy_net", "3306");

  if(!$db_connection) {
    die("mission failed: " . mysqli_connect_error());
  } else {
    $pictures_query = mysqli_query($db_connection, "SELECT * FROM photos ORDER BY RAND() LIMIT 7");

    while($pic = mysqli_fetch_assoc($pictures_query)) {
      echo '<img class="photo" src="';
      echo $pic['photo_file_path'];
      echo '" alt="picture" width=25% height=auto style="top:';
      echo (rand(0, 200));
      echo 'px;left:';
      echo (rand(-75,150));
      echo 'px;">';
    }
  }
?>
