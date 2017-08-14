#!/bin/bash
FILES=/Applications/MAMP/htdocs/test/dashboard/upload/iis_logs/*.log
for f in $FILES
do
  echo "Processing $f file..."
  php /Applications/MAMP/htdocs/test/dashboard/index.php /cron importiisdir
done

if [ $1 = ''
ssconvert -S myexcel.xlsx myexcel.csv