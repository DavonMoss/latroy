<!DOCTYPE html>

<html>
  <head>
    <title>latroy/notes</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>

  <body>
    <!-- Importing jQuery. -->
    <script src="./../libs/jquery-3.7.1.js"></script>

    <!-- Client side functionality. -->
    <script>
      $(document).ready(function() {

        // Onclick ajax code using jquery, passes clicked note title in GET request to server.
        $(".note-title").click(function(){
          let note_title = $(this).html();

          if(note_title == "[ CLEAR SCREEN ]") {
            note_title = "default";
          } else {
            note_title = note_title.replace(".txt", "");
          }

          $.ajax({
            url: './fetch_note.php',
            type: "GET",
            data: ({title: note_title}),
            success: function(data){
              $(".note-content").html(data);
            }
          });
        });
      
        // Mouseover highlight
        $(".note-title").on("mouseover", function() {
          $(this).css('color', 'orange');
        });
        
        $(".note-title").on("mouseout", function() {
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

      <!-- Left column: holds list of all notes for navigation purposes. Clicking one reloads contents of right column. -->

      <!-- Right column: displays note content in stylized fashion. Displays VIM/EMACS esque buffer by default. -->
      <div class="notes-list">
        <!-- Establish connection with DB and pull notes. -->
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
            $notes = mysqli_query($db_connection, "select * from notes where not title='default'");
          }
        ?>

        <div class="titles-list">
          <!-- Generate card for each note.  -->
          <div class="note-title">[ CLEAR SCREEN ]</div>
          <?php while($note = mysqli_fetch_assoc($notes)) { ?>
            <div class="note-title"><?php echo $note['title']; ?>.txt</div>
          <?php } ?>
        </div>
        <div class="note-content">
          <!-- Default display -->
          <?php 
            $default_query = mysqli_query($db_connection, "select * from notes where title='default'");
            $default = mysqli_fetch_assoc($default_query);
            $default_contents = file_get_contents($default['note_file_path']);
            echo ("<pre>");
            echo $default_contents;
            echo ("</pre>");
          ?>
        </div>
      </div>


    </div>
  </body>
</html>
