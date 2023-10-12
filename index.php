<!DOCTYPE html>

<html>
  <head>
    <title>latroy</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>

  <body>
    <div id="container">
      <div id="top-part">
        <div id="latroy">latroy</div>
        <div id="welcome-message">
          <?php
            echo ">: Welcome to latroy.net. Created by Davon Moss. Stay awhile."; 
          ?>
        </div>
      </div>

      <!-- FOLDERS -->
      <div id="folders">
        <div id="photos-folder">
          <a href="./photos/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Photos</div>
        </div>

        <div id="music-folder">
          <a href="./music/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Music</div>
        </div>

        <div id="notes-folder">
          <a href="./notes/">
            <img src="./images/win95folderopen.png" alt="bruh where the folder at" width=100 height=100>
          </a>
          <div id="folder-names">Notes</div>
        </div>
      </div>

      <!-- SOCIALS -->
      <div class="socials">
        <div>
          <a href="https://github.com/DavonMoss" target="_blank">
            <img src="./images/github.svg" alt="github_icon" width=80 height=80>
          </a>
          <div id="folder-names">Code</div>
        </div>
        <div>
          <a href="https://www.linkedin.com/in/davonmoss/" target="_blank">
            <img src="./images/linkedin.svg" alt="linkedin_icon" width=80px height=80px>
          </a>
          <div id="folder-names">LinkedIn</div>
        </div>
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
