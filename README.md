# Bethyl Dashbaord

## Package Requirements

    - PHP
    - PHP-CLI
    - MySQL
    - Composer
    - Gnumeric
    - NodeJS
    - NPM
    - NPM Bower (npm install -g bower)
    - NPM Gulp (npm install -g gulp)
    - Ruby & RubyGems
    - Sass (gem install sass)

## Steps:

    - Modify config/database.php to your credentials
    - Modify config/config.php and set your base_url
    - Install NPM dependencies (npm install)
    - Install Bower dependencies (bower install)
    - Install Composer dependencies (composer install)
    - Setup File path and directory locations in Control Panel

## Sample Apache Config

<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host.example.com
    DocumentRoot /Path/To/Root
    ServerName nameyourapp.com
    ErrorLog /Path/To/Log
        <Directory /Path/To/Root>
               SetEnv APPLICATION_ENVIRONMENT development
               DirectoryIndex index.php
               AllowOverride All
               Order allow,deny
               Allow from all
       </Directory>
</VirtualHost>

## Cronjobs:

    Located in ~/Cron/*.sh
    Assign time in cron and point job to respective files in cron folder.
