#!/bin/sh

set -e

apt-get install -y php5-pgsql php5-mongo

pecl config-set php_ini /etc/php5/fpm/php.ini
