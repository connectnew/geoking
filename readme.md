# REQUIRED SOFTWARE
This is only in case of manual installation. If you use docker it will organize everything for you.

0. PHP 7.2 with setting config to https://bitbucket.org/itagroup/geoking/src/master/docker/php/php.ini
1. MYSQL 8 with setting config to https://bitbucket.org/itagroup/geoking/src/master/docker/mysql/conf.d/my.cnf
2. REDIS 3.2
3. COMPOSER ( https://getcomposer.org )
4. You can always find all necessary PHP extensions at https://bitbucket.org/itagroup/geoking/src/master/docker/php/Dockerfile  But here is the list of all required PHP extensions if you need it for some reason: 
  ```
  bcmath
  calendar
  Core
  ctype
  curl
  date
  dom
  ds
  exif
  fileinfo
  filter
  ftp
  gd
  gettext
  hash
  iconv
  intl
  json
  libxml
  mbstring
  memcached
  mysqli
  mysqlnd
  openssl
  pcntl
  pcre
  PDO
  pdo_mysql
  Phar
  posix
  readline
  Reflection
  session
  SimpleXML
  sockets
  sodium
  SPL
  standard
  tokenizer
  xml
  xmlreader
  xmlwriter
  xsl
  Zend OPcache
  zip
  zlib
  Xdebug (required on development environment only)
```

  
# FRESH INSTALL WITHOUT DOCKER
0. `git clone https://evgeniysolovyev@bitbucket.org/itagroup/geoking.git && cd geoking` to pull the latest code from the repository. This will require authorization, you should provide your login/password to bitbucket
1. `composer install` to install PHP libraries
2. Create database `php artisan make:database geoking`
3. Edit environment `cp .env.example .env && php artisan key:generate && vim .env` and update db name to `geoking`
4. Run `php artisan migrate` to run all database migrations 
5. Run either `npm i` or `yarn` from the project root folder
6. Run `npm run dev` or `yarn dev` to compile assets once or `npm run watch` / `yarn watch` to run watcher
7. Make sure php has enough memory running `php -i | grep memory_limit`, recommended memory is 1024 Mb at least at the time of running geo seeds
8. Run following commands to download GEO databases
    - `mkdir storage/geo`
    - `cd storage/geo`
    - `wget http://download.geonames.org/export/dump/allCountries.zip && unzip allCountries.zip && rm allCountries.zip`
    - `wget http://download.geonames.org/export/dump/hierarchy.zip && unzip hierarchy.zip && rm hierarchy.zip`
    - `wget http://download.geonames.org/export/dump/cities15000.zip && unzip cities15000.zip -d ./cities && mv ./cities/cities15000.txt ./CITIES15000.txt && rm -rf ./cities && rm cities15000.zip`
    - `php artisan geo:seed`
    - `php artisan geo:seed-cities CITIES15000 --append`
9. Run `php artisan storage:link` fro project root folder to link storage directory and make it publicly available

# FRESH INSTALL WITH DOCKER
0. `git clone https://evgeniysolovyev@bitbucket.org/itagroup/geoking.git && cd geoking` to pull the latest code from the repository. This will require authorization, you should provide your login/password to bitbucket
1. `composer install` to install PHP libraries
2. Create database `php artisan make:database geoking`
3. Edit environment `cp .env.example .env && php artisan key:generate && vim .env` and update db name to `geoking`
4. Run docker `docker-compose up`
5. Run `docker exec -it laravel_php php artisan migrate` to run all database migrations 
6. Run either `npm i` or `yarn` from the project folder in host OS
7. Run `npm run dev` or `yarn dev` to compile assets once or `npm run watch` / `yarn watch` to run watcher
8. Make sure php has enough memory running `php -i | grep memory_limit`, recommended memory is 1024 Mb at least at the time of running geo seeds
9. From host OS run following commands to download GEO databases
    - `mkdir storage/geo`
    - `cd storage/geo`
    - `wget http://download.geonames.org/export/dump/allCountries.zip && unzip allCountries.zip && rm allCountries.zip`
    - `wget http://download.geonames.org/export/dump/hierarchy.zip && unzip hierarchy.zip && rm hierarchy.zip`
    - `wget http://download.geonames.org/export/dump/cities15000.zip && unzip cities15000.zip -d ./cities && mv ./cities/cities15000.txt ./CITIES15000.txt && rm -rf ./cities && rm cities15000.zip`
10. Run `docker exec -it laravel_php /bin/bash` and then in the docker cli run 
    - `php artisan geo:seed`
    - `php artisan geo:seed-cities CITIES15000 --append`
11. Run `php artisan storage:link` from docker bash to link storage directory and make it publicly available
12. Open http://localhost:8080

# PULLING THE LATEST CODE UPDATES ROUTINE
0. `cd <project root>`
1. `git pull origin master` this will require authorization, you should provide your login/password to bitbucket
2. `composer update` to install/update php libraries
3. `npm i && npm run dev` to install/update javascript libraries
4. `php artisan migrate` to run all database migrations
5. reload webserver, in case of php-fpm run `service php7.3-fpm reload`

# TASKTRACKER
At https://web4you2.teamwork.com/#/projects/421085/tasks

