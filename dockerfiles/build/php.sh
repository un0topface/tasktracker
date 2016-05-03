#!/bin/sh

set -e

apt-get install -y php5-pgsql

apt-get install -y php5-dev make pkg-php-tools libpcre3-dev g++
pecl config-set php_ini /etc/php5/fpm/php.ini

# blitz
curl -s http://alexeyrybak.com/blitz/all-releases/blitz-0.8.12.tar.gz | tar zx -C /tmp
cd /tmp/blitz-0.8.12
phpize
./configure
make
make install
echo 'extension=blitz.so' > /etc/php5/mods-available/blitz.ini
echo 'blitz.disable_include = true' >> /etc/php5/mods-available/blitz.ini
echo 'blitz.remove_spaces_around_context_tags = true' >> /etc/php5/mods-available/blitz.ini
ln -s /etc/php5/mods-available/blitz.ini /etc/php5/fpm/conf.d/20-blitz.ini
ln -s /etc/php5/mods-available/blitz.ini /etc/php5/cli/conf.d/20-blitz.ini

# remove dev
apt-get remove -y php5-dev make pkg-php-tools libpcre3-dev g++
