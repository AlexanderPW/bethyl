#!/bin/bash
FILES=$(php -f ../index.php cron get901Path)
PUT=$(php -f ../index.php cron put901Path)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  rm $f
  php ../index.php cron import901Dir
done

