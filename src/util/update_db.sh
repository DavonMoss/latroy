#!/bin/bash

##################################################
####					      ####
####               DEFINITIONS                ####
####					      ####
##################################################

true_photo_dir=/var/www/latroy/content/photo_files/
true_notes_dir=/var/www/latroy/content/note_files/
true_audio_dir=/var/www/latroy/content/audio_files/
true_lyrics_dir=/var/www/latroy/content/lyrics_files/

sql_output=./generated_statements.sql

echo -n "Please enter MYSQL password for latroy_admin: "
read creds

: '
GENERATE DIFFERENCES
	Spits out some .compare files and ultimately a db_changes.compare file which will be used to generate SQL statements for all who need them. 

PARAMS:
	1: directory to work from (e.g. true_photo_dir)
	2: database table to work from (e.g. photos)
	3: database table column to check value of (e.g. photo_file_path)
        4: ADD or REMOVE
'
generate_differences() {
  for filepath in "$1"*
  do
    echo ./../content/$(basename $1)/$(basename $filepath) >> /var/www/latroy/src/util/dir_files.compare
  done
  
  mysql -u latroy_admin "-p$creds" -e "USE latroy_net; SELECT $3 INTO OUTFILE './db_files.compare' FROM $2;"
  sudo mv /var/lib/mysql/db_files.compare ./db_files.compare
  sudo chown latroy ./db_files.compare 
  diff dir_files.compare db_files.compare >> ./differences.compare

  if [ $4 == "ADD" ]
  then 
  grep '^<' differences.compare | sed s/'< '/''/g >> db_changes.compare

  elif [ $4 == "REMOVE" ]
  then
  grep '^>' differences.compare | sed s/'> '/''/g >> db_changes.compare

  else
  echo "failed to generate comparison, invalid parameter"
  fi

  echo WILL $4 $(cat db_changes.compare)
}

: '
GENERATE SQL
	Uses the db_changes.compare file to generate an sql script for execution on the db.

PARAMS:
	1: database table to work from (e.g. photos)
	2: database table column to check value of (e.g. photo_file_path)
        3: ADD or REMOVE
'
generate_sql() {
  echo "USE latroy_net;" >> $sql_output

  while read change;
  do
    if [ $3 == "ADD" ]   
    then
      case $1 in
        "notes")
           echo "INSERT INTO notes (title, note_file_path) VALUES ('$(basename $change .txt)', '$change');" >> $sql_output 
           ;;
        "photos")
           echo "INSERT INTO photos (photo_file_path) VALUES ('$change');" >> $sql_output 
           ;;
        "songs")
           song_columns='title, blurb, release_date, audio_file_path, lyrics_file_path'
           echo "Inserting $change into songs table..."
           echo -n "Title: "
           read title </dev/tty
           echo -n "Blurb (Just a handful of words): "
           read blurb </dev/tty
           echo -n "Release date (YYYY-MM-DD): "
           read date </dev/tty
           echo -n "Lyrics file: "
           read lyrics </dev/tty
           echo "INSERT INTO songs ($song_columns) VALUES ('$title', '$blurb', '$date', '$change', './../content/lyrics_files/$lyrics');" >> $sql_output 
           ;;
      esac
    elif [ $3 == "REMOVE" ]
    then
      case $1 in
        "notes")
           echo "DELETE FROM notes WHERE note_file_path = '$change';" >> $sql_output 
           ;;
        "photos")
           echo "DELETE FROM photos WHERE photo_file_path = '$change';" >> $sql_output
           ;;
        "songs")
           echo "DELETE FROM songs WHERE audio_file_path = '$change';" >> $sql_output
           ;;
      esac
    fi
  done < db_changes.compare
}

##################################################
####					      ####
####                    MAIN                  ####
####					      ####
##################################################
# notes
generate_differences $true_notes_dir "notes" "note_file_path" "ADD" 
generate_sql "notes" "note_file_path" "ADD"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output
generate_differences $true_notes_dir "notes" "note_file_path" "REMOVE" 
generate_sql "notes" "note_file_path" "REMOVE"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output

# songs
generate_differences $true_audio_dir "songs" "audio_file_path" "ADD" 
generate_sql "songs" "audio_file_path" "ADD"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output
generate_differences $true_audio_dir "songs" "audio_file_path" "REMOVE" 
generate_sql "songs" "audio_file_path" "REMOVE"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output

# photos
generate_differences $true_photo_dir "photos" "photo_file_path" "ADD" 
generate_sql "photos" "photo_file_path" "ADD"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output
generate_differences $true_photo_dir "photos" "photo_file_path" "REMOVE" 
generate_sql "photos" "photo_file_path" "REMOVE"
mysql -u latroy_admin "-p$creds" < $sql_output
rm *.compare $sql_output
