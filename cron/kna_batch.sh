#!/bin/bash
FILES=$(php -f ../index.php cron getKnaPath)
PUT=$(php -f ../index.php cron putKnaPath)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  rm $f
  php ../index.php cron importKnaDir
done

