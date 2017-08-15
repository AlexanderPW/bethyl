#!/bin/bash
FILES=$(php -f /Applications/MAMP/htdocs/test/dashboard/index.php cron getMaraPath)
PUT=$(php -f /Applications/MAMP/htdocs/test/dashboard/index.php cron putMaraPath)
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  mv $f $PUT$filename
  php /Applications/MAMP/htdocs/test/dashboard/index.php cron importMaraDir
done

