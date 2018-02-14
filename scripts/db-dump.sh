#!/bin/sh

curdir=$(pwd)
db_dir=$curdir/database/backups
if [ -f $curdir/.env ] ; then
  . $curdir/.env
else
  echo "Couldn't find .env"
  exit 1
fi

if [ ! -z $1 ] ; then
  tag="_$1"
fi

datestring=$(date --iso-8601=minutes)
sql_file=$db_dir/$DB_DATABASE-$datestring$tag.sql

echo -n "Backing up ... "
mkdir -p $db_dir
mysqldump -u$DB_USERNAME -p$DB_PASSWORD -h$DB_HOST --add-drop-database --database $DB_DATABASE > $sql_file
exit_status=$?
if [ $exit_status -eq 0 ] ; then
  echo Done.
  echo Backuped to: $sql_file
else
  echo Failed!
  exit $exit_status
fi
