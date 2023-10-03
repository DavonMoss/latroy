<!DOCTYPE html>

<html>
  <head>
    <title>latroy/photos</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>

  <body>
    <!-- Importing jQuery. -->
    <script src="./../libs/jquery-3.7.1.js"></script>

    <!-- Client side functionality. -->
    <script>
      $(document).ready(function() {
        

        // async http request
        $(".refresh-button").click(function(){
          $.ajax({
            url: './fetch_photos.php',
            success: function(data){
              $(".pics").html(data);
            }
          });
        });
      
        // Mouseover highlight
        $(".refresh-button").on("mouseover", function() {
          $(this).css('color', 'orange');
        });
        
        $(".refresh-button").on("mouseout", function() {
          $(this).css('color', 'grey');
        });
  
      });
    </script>

    <div id="container">
      <!-- Home button -->
      <div id="home">
        <a id="home-clickable" href="./..">
          <img src="./../images/back_3.png" alt="arrow" width=20% height=20%>
          <img src="./../images/win95pc.png" alt="pretty computer" width=30% height=30%>
        </a>
      </div>
  
      <!-- IMAGES -->
      <div class="refresh-button" unselectable="on">[ REFRESH ]</div>
      <div class="pics">
        <?php
          require './fetch_photos.php';
        ?>
      </div>
    </div>
  </body>
</html>
