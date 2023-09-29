<!DOCTYPE html>

<html>
  <head>
    <title>latroy/notes</title>
    <link href="./styles.css" rel="stylesheet"/>
  </head>

  <body>
    <!-- Importing jQuery. -->
    <script src="./../libs/jquery-3.7.1.js"></script>


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
      <div id="notes-list">
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
            $notes = mysqli_query($db_connection, "select * from notes");
          }
        ?>

        <!-- Generate card for each note.  -->
        <?php while($note = mysqli_fetch_assoc($notes)) { ?>
          <div class="note-title"><?php echo $note['title']; ?>.txt</div>
        <?php } ?>
        <div class="note-content">
          <!-- this is what it all hinges on, jquery to dynamically create this query on click? -->

          <!-- so this is wrong due to nature of server/client side. by the time we're executing js
               the php is long gone. so i cant use db queries to load the shit dynamically. maybe i can
               load it all at once and just hide/unhide it? other option if i DID want to do db queries
	       based on client input is AJAX apparently. will look into it.  -->
 
          <script>
            $(document).ready(function() {
              $(".note-title").on("click", function(event) {
                let $query = "SELECT * FROM notes WHERE title='" + $(this).html + "'";

                event.preventDefault();
              });
            });
          </script>
          <?php
            $note_query = mysqli_query($db_connection, "SELECT * FROM notes WHERE title='my_first_note'");
       
            $note = mysqli_fetch_assoc($note_query);
            $contents = file_get_contents($note['note_file_path']);
            echo ("<pre>");
            echo $contents;
            echo ("</pre>"); 
          ?>
        </div>
      </div>


    </div>
  </body>
</html>
