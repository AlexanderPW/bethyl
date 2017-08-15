#!/bin/bash
FILES=$(php -f /Applications/MAMP/htdocs/test/dashboard/index.php cron getIisPath)
for f in $FILES
do
  echo "Processing $f file..."
  php /Applications/MAMP/htdocs/test/dashboard/index.php cron importiisdir
done

