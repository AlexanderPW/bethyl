Initial commit for Dashbaord
CI 3.1.5
Bower
Gulp

Package Installation Requirements:

MySQL
PHP 5.4+
Composer
Bower
NPM
- NPM Bower (npm install -g bower)
Gnumeric

Package Installation Instructions:


# Solutions/TSC

https://account.wmsolutions.com

https://tsc.wmsolutions.com

## Software:
    - Composer
    - Ghostscript
    - ImageMagick
    - LibMemcached
    - Memcached
    - NFS-Utils
    - NodeJS
    - NPM
    - NPM Bower (npm install -g bower)
    - NPM Grunt (npm install -g grunt-cli)
    - Ruby & RubyGems
    - Sass (gem install sass)
    - Capistrano (gem install capistrano)

## PHP Modules:
    - apc
    - apcu
    - bcmath
    - curl
    - gmp
    - imagick
    - intl
    - libxml
    - memcache/memcached
    - mbstring
    - mcrypt
    - openssl
    - pcntl
    - pcre
    - pdo_mysql
    - soap
    - SPL
    - SPL_Types
    - xml
    - xsl
    - zlib

##  Apache Configs:
#### Solutions
    DocumentRoot /home/developer/wmsolutions/public
    ServerName developer.tsc.dev.lan
    SetEnv APPLICATION_ENVIRONMENT development
    SetEnv APPLICATION tsc
    SetEnv WMSOLUTIONS_URL pdf.windows.dev.lan
    SetEnv TSC_URL developer.tsc.dev.lan
    SetEnv ACCOUNT_URL developer.account.dev.lan
    ErrorLog logs/developer_error_log
#### TSC
    DocumentRoot /home/developer/wmsolutions/public
    ServerName developer.account.dev.lan
    SetEnv APPLICATION_ENVIRONMENT development
    SetEnv APPLICATION solutions
    SetEnv WMSOLUTIONS_URL pdf.windows.dev.lan
    SetEnv TSC_URL developer.tsc.dev.lan
    SetEnv ACCOUNT_URL developer.account.dev.lan
    ErrorLog logs/developer_error_log

## Application Configs:
    - config/global.ini: Used to define global application settings
    - config/env/*.php: Used to define application environment settings

## Steps:
    - Modify config/env/*.php to your needs
    - Copy config/satis/.ssh/config to ~/.ssh/config, change the IdentifyFile value, and then ensure the file has correct permissions (chmod 600 ~/.ssh/config)
    - Install NPM dependencies (npm install)
    - Install Bower dependencies (bower install)
    - Install Composer dependencies (composer install)
    - Mount the filesystem (mkdir files && cd bin && ./dev_mount_files.sh) (the hostname and path in this script will most likely be incorrect)
    - Run Grunt (grunt)
    - Visit http://developer.tsc.dev.lan or http://developer.account.dev.lan

## DB Notes:
    Make sure to create a `dbadmin` user in the DB with create permissions, otherwise views, triggers and functions will not be created when you do the database import. (dbadmin is the 'definer' for these items)

## Cronjobs:
    APPLICATION_ENVIRONMENT=production
    APPLICATION_ENV=production
    
    # WM Fastlane/Hazlane
    30 03 * * * cd /var/www/tsc.wmsolutions.com/library/Fastlane && php ./FastlaneParser.php && php ./FastlaneMover.php && php ./SuperFastlaneMover.php
    30 04 * * * cd /var/www/tsc.wmsolutions.com/library/Fastlane && php ./HazlaneParser.php && php ./HazlaneMover.php && php ./SuperHazlaneMover.php
    19 05 * * * cd /var/www/tsc.wmsolutions.com/library/Utilities && php ./FasHazReport.php
    
    # WM ROI
    00 07 * * * cd /var/www/tsc.wmsolutions.com/bin/&& sh roi_report.sh
    
    # WM Cronjob emails
    00 02 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=clear_expired_advanced_edits
    00 03 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=sync_mail_chimp
    15 03 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=send_profile_archival_notices
    00 05 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=send_periodic_testing_notices
    00 09 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=send_profile_expiring_notices
    30 05 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=send_profile_price_increase_notices
    45 05 1 * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=send_profile_periodic_requirement_reminders
    15 06 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=archive_expired_profiles
    30 06 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=delete_expired_forgot_passwords
    30 02 * * * cd /var/www/tsc.wmsolutions.com/bin && php ./cronjob.php --e=production --j=sync_tcoo
    
## Deployment:
In order to deploy to the webserver(s) with zero downtime, this application has been setup with Capistrano.

Environments:
- production
- staging

For the following command to work, the webserver's user account (defined in config/deploy/production.rb) must have its SSH key added to the wmsolutions Github repository

      cap <environment> deploy

