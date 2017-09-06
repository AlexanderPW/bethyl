#!/bin/bash
FILES=$(php -f ../index.php cron getMaraPath)
PUT=$(php -f ../index.php cron putMaraPath)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  rm $f
  php ../index.php cron importMaraDir
done

