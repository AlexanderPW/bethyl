#!/bin/bash
FILES=/Applications/MAMP/htdocs/test/dashboard/upload/kna_logs/*.xlsx
for f in $FILES
do
  filename=$(basename $f)
  echo "Processing $f file..."
  ssconvert $f $f.csv
  mv $f /Applications/MAMP/htdocs/test/dashboard/upload/complete/kna_logs/$filename
  php /Applications/MAMP/htdocs/test/dashboard/index.php cron importKnaDir
done

