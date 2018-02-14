#!/bin/bash

function set_or_append() {
  debug=0
  env_file=$1
  param=$2
  new_value=$3
  if [ ! -z $4 ] ; then
    debug=1
  fi

  if [ $debug -eq 1 ] ; then
    echo "Setting $param to $new_value"
  fi
  if $(grep -q $param $env_file) ; then
    sed -i -e "s/^\($param\)=/\1=$new_value/" $env_file
  else
    echo >> $env_file
    echo "$param=$new_value" >> $env_file
  fi
}

function countdown() {
  i=$1
  while [ $i -ge 1 ] ; do
    echo -n "$i "
    sleep 1
    i=$(expr $i - 1)
  done
  echo Go!
}

