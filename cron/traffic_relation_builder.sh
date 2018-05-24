#!/bin/bash
echo "Building Traffic Relationships Part 1"
php ../index.php cron buildTrafficRelation
echo "Building Traffic Relationships Part 2"
php ../index.php cron buildTrafficRelationNull
echo "All Done..."