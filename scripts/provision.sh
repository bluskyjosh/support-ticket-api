#!/bin/bash

if [ "x$APP_DIR" != "x"  ] && [ -f $APP_DIR/.env ] ; then
  has_env=true
  . $APP_DIR/.env
elif [ -f /vagrant/.env ] ; then
  APP_DIR=/vagrant
  has_env=true
  . .env
elif [ -f $HOME/.env ] ; then
  has_env=true
  . $HOME/.env
else
  echo .env missing
  exit 1
fi

# Config
conf_dir=$APP_DIR/scripts/conf
random_pw=false
restore_db=$APP_NAME.sql
nginx_conf=$APP_NAME.conf
packages="mariadb-server mariadb-client nginx-full php-fpm php-mysql php-xdebug php-mcrypt php-mbstring php-zip php-pear php-dev pwgen"
php_mods_dir=/etc/php/7.0/mods-available
xdebug_remote_host=$(ip route get 8.8.8.8 | head -n1 | cut -d' ' -f3)

# Doing the work
cd $APP_DIR

if which pwgen && $random_pw ; then
  root_pw=$(pwgen -s 16 1)
else
  root_pw=eixohdoh # This is arbitrary.
fi

debconf-set-selections <<< "mysql-server mysql-server/root_password password $root_pw"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $root_pw"
apt-get update && apt-get install -y $packages

# If we have a .env, create the database it has info for
if [ $has_env = true ] ; then
	mysql -u"root" -p"$root_pw" << EOF
CREATE USER $DB_USERNAME IDENTIFIED BY '$DB_PASSWORD';
CREATE DATABASE $DB_DATABASE;
GRANT ALL ON $DB_DATABASE.* to $DB_USERNAME;
EOF
  echo "Created $DB_DATABASE"
fi

# If $conf_dir/$restore_db exists, load it up as our sample database
if [ -e $conf_dir/$restore_db ] && [ $has_env = true ] ; then
	mysql -u"root" -p"$root_pw" $DB_DATABASE < $conf_dir/$restore_db
  echo "Restored db: $restore_db"
fi

# If $conf_dir/$nginx_confexists, add it to the NGINX config and do PHP setup as well
if [ ! -z $conf_dir/$nginx_conf ] ; then
  conf=$conf_dir/$nginx_conf
  if [ -f $conf.template ] ; then
    sed -e "s|%APP_DIR%|$APP_DIR|g" $conf.template > /etc/nginx/sites-available/$APP_NAME.conf
  elif [ -f $conf ] ; then
    cp $conf /etc/nginx/sites-available/$APP_NAME.conf
  fi
  rm /etc/nginx/sites-enabled/default
  ln -s ../sites-available/$APP_NAME.conf /etc/nginx/sites-enabled/$APP_NAME.conf
  service nginx force-reload
  echo "Setup nginx with $nginx_conf"
fi

# PHP
if $APP_DEBUG ; then
  cat << EOF > $php_mods_dir/xdebug.ini
; configuration for php xdebug module
; priority=20
zend_extension=xdebug.so
xdebug.remote_enable=true
xdebug.remote_host=$xdebug_remote_host
xdebug.remote_port=9000
xdebug.idekey=phpstorm
xdebug.profiler_enable_trigger=1
xdebug.profiler_output_dir=/vagrant/xdebug-profile
; For debugging xdebug connection issues
;xdebug.remote_log="/tmp/xdebug-remote.log"
EOF
  phpenmod xdebug
  service php7.0-fpm force-reload
  echo "Setup PHP XDebug"
fi

wget --quiet https://getcomposer.org/installer && php installer
sudo cp composer.phar /usr/local/bin/composer
rm installer composer.phar
if [ -d ~$SUDO_USER/.composer ] ; then
  chown -R $SUDO_USER:$SUDO_USER ~$SUDO_USER/.composer
fi
echo "Setup composer"

echo Machine is up with IP address: $(ip -4 -o addr show enp0s3 | cut -d' ' -f7 | cut -d'/' -f1)
