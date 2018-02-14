#!/bin/bash

export APP_ENV=local
export APP_DEBUG=true
export APP_NAME=support-ticket
export APP_DIR=/vagrant

bash $APP_DIR/scripts/provision.sh
