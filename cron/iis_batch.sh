#!/bin/bash
FILES=$(php -f ../index.php cron getIisPath)
for f in $FILES
do
  echo "Processing $f file..."
  php ../index.php cron importiisdir
done

