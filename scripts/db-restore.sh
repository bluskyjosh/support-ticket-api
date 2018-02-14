#!/bin/bash

curdir=$(pwd)
db_dir=$curdir/databases/backups
source $curdir/scripts/lib/setup-functions.sh
if [ -f $curdir/.env ] ; then
  . $curdir/.env
else
  echo "Couldn't find .env"
  exit 1
fi

if [ ! -z $1 ] ; then
  sql_file=$1
else
  echo "You didn't specific a sql file to restore"
fi

if [ ! -z $2 ] && [ x$2 = xnobackup ] ; then
  echo "Restoring $sql_file without backing up. Hit ctrl-c to cancel"
  echo -n "Proceeding in: "
  countdown 3
  no_backup=1
else
  echo "Backing up db before proceeding"
  $curdir/scripts/db-dump.sh pre-restore
  if [ $? != 0 ] ; then
    echo Backup failed, bailing out
    exit 1
  fi
fi

echo -n "Restoring ... "
mysql -u$DB_USERNAME -p$DB_PASSWORD -h$DB_HOST $DB_DATABASE < $sql_file
exit_status=$?
if [ $exit_status -eq 0 ] ; then
  echo Done.
  echo Restored: $sql_file
else
  echo Failed!
  exit $exit_status
fi
