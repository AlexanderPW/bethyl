#!/bin/bash
FILES=$(php -f /Applications/MAMP/htdocs/test/dashboard/index.php cron getKnaPath)
PUT=$(php -f /Applications/MAMP/htdocs/test/dashboard/index.php cron putKnaPath)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  mv $f $PUT$filename
  php /Applications/MAMP/htdocs/test/dashboard/index.php cron importKnaDir
done

