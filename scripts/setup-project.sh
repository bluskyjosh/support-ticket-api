#!/bin/bash

# bash is the best shell ever
.  $(dirname $0)/lib/setup-functions.sh
env_file=".env"
if [ -f .env ] ; then
  . $env_file
else
  echo "Failed to load .env file!"
  exit 1
fi

# Set JWT_SECRET if not already set
if [ -z $JWT_SECRET ] ; then
  set_or_append $env_file JWT_SECRET $(pwgen -s 32 1) 1
fi

# Set JWT_DURATION if not already set
if [ -z $JWT_DURATION ] ; then
  set_or_append $env_file JWT_DURATION 21020000 1
fi

mkdir -p xdebug-profile && chmod o+rwX xdebug-profile

# Install PHP libraries required for Impact API
composer install
# Refresh the autoload cache, just for good measure
composer dump-autoload
# Migrate & seed
if [ $APP_ENV != "production" ] ; then
	php artisan migrate:refresh --seed
fi
