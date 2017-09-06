#!/bin/bash
FILES=$(php -f ../index.php cron getIpPath)
PUT=$(php -f ../index.php cron putIpPath)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  rm $f
  php ../index.php cron importIpDir
done

