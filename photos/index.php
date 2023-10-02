<!DOCTYPE html>

<html>
  <head>
    <title>latroy/photos</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>

  <body>
    <div id="container">
      <!-- Home button -->
      <div id="home">
        <a id="home-clickable" href="./..">
          <img src="./../images/back_3.png" alt="arrow" width=20% height=20%>
          <img src="./../images/win95pc.png" alt="pretty computer" width=30% height=30%>
        </a>
      </div>
  
      <!-- IMAGES -->
      <div class="refresh-button">
        <a href="./../photos/">REFRESH</a>
      </div>
      <div class="pics">
        <?php
          $db_connection = mysqli_connect("127.0.0.1", "latroy_admin", "admin", "latroy_net", "3306");

          if(!$db_connection) {
            die("mission failed: " . mysqli_connect_error());
          } else {
            $pictures_query = mysqli_query($db_connection, "SELECT * FROM photos ORDER BY RAND()");

            $count = 7;
            while(($pic = mysqli_fetch_assoc($pictures_query)) && $count > 0) {
              echo '<img class="photo" src="';
              echo $pic['photo_file_path'];
              echo '" alt="picture" width=25% height=auto style="top:';
              echo (rand(0, 200));
              echo 'px;left:';
              echo (rand(-75,150));
              echo 'px;">';
              $count--;
            }
          }
        ?>
      </div>
    </div>
  </body>
</html>
