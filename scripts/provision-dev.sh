#!/bin/bash

export APP_ENV=dev
export APP_DEBUG=true
export APP_NAME=support-ticket-api
export APP_DIR=/srv/$APP_NAME

bash $APP_DIR/scripts/provision.sh
