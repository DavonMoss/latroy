<!DOCTYPE html>

<html>
  <head>
    <title>latroy</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>


  <!-- I think the reason templeOS website zooms good is because things are sized with px?-->
  <body>
    <div id="container">
      <div id="top-part">
        <div id="latroy">LATROY</div>
        <div id="welcome-message">
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
                  $query_result = mysqli_query($db_connection, "select message from welcome_messages");
                  
                  echo ">:";
                  while($curr_row = mysqli_fetch_assoc($query_result)) {
                      echo $curr_row['message'];
                      echo "\n";
                  }
              }
            ?>
        </div>
      </div>

      <!-- FOLDERS -->
      <div id="folders">
        <div id="code-folder">
          <a href="./code/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Code</div>
        </div>

        <div id="toys-folder">
          <a href="./toys/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Toys</div>
        </div>

        <div id="music-folder">
          <a href="./music/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Music</div>
        </div>

        <div id="blog-folder">
          <a href="./blog/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Blog</div>
        </div>
      </div>

      <!-- SOCIALS -->
      <div class="socials">
        <a href="https://github.com/DavonMoss" target="_blank">
          <img src="./images/github.svg" alt="github_icon" width=35% height=35%>
        </a>
        <a href="https://www.linkedin.com/in/davonmoss/" target="_blank">
          <img src="./images/linkedin.svg" alt="linkedin_icon" width=35% height=35%>
        </a>
      </div>

      <div id="time">
        <script>
          let months = {
              0: "January",   
              1: "February",   
              2: "March",   
              3: "April",   
              4: "May",   
              5: "June",   
              6: "July",   
              7: "August",   
              8: "September",   
              9: "October",   
              10: "November",   
              11: "December"   
          };

          let days = {
              0: "Sunday",
              1: "Monday",
              2: "Tuesday",
              3: "Wednesday",
              4: "Thursday",
              5: "Friday",
              6: "Saturday"
          };

          function getClientTime() {
              let timestamp = new Date(Date.now());

              let time_string = months[timestamp.getMonth()] + " " +
                                timestamp.getDate() + ", " +
                                timestamp.getFullYear() + " - " +
                                days[timestamp.getDay()] + " " + 
                                timestamp.getHours().toString().padStart(2, '0') + ":" +
                                timestamp.getMinutes().toString().padStart(2, '0') + ":" +
                                timestamp.getSeconds().toString().padStart(2, '0'); 

              document.getElementById("time").innerHTML = time_string;
          }

          getClientTime(); 
          setInterval(getClientTime, 1000);
        </script>
      </div>
    </div>
  </body>
</html>
