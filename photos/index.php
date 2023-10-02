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
      <div class="pics">
        <?php
          $db_connection = mysqli_connect("127.0.0.1", "latroy_admin", "admin", "latroy_net", "3306");

          if(!$db_connection) {
            die("mission failed: " . mysqli_connect_error());
          } else {
            $pictures_query = mysqli_query($db_connection, "select * from photos");
            #generate 5 random numbers within the range of the PIDs and pick them out to display
            #echo out img tags with those photos as the src

            while($pic = mysqli_fetch_assoc($pictures_query)) {
              echo '<img src="';
              echo $pic['photo_file_path'];
              echo '" alt="picture">';
            }
          }
        ?>
      </div>
    </div>

  </body>
</html>
