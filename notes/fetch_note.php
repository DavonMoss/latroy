<!-- PHP code to safely construct and execute query. NO INJECTION HERE BOY -->
<?php
  require_once("../../creds/credentials.php");

  $db_connection = mysqli_connect($servername, $dbuser, $dbpass, $dbname, $serverport);

  if(!$db_connection) {
    die("Failed to connect to db, couldn't fetch note: " . mysqli_connect_error());
  } else {
    $title = $_GET['title'];
    $note_query = mysqli_prepare($db_connection, "SELECT * FROM notes WHERE title=?");
    mysqli_stmt_bind_param($note_query, 's', $title);
    mysqli_stmt_execute($note_query);
    $note_query_result = mysqli_stmt_get_result($note_query);      

    $note = mysqli_fetch_assoc($note_query_result);
    $contents = file_get_contents($note['note_file_path']);
    echo ("<pre>");
    echo $contents;
    echo ("</pre>"); 
  }
?>
