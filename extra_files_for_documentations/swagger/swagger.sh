#!/bin/bash

SCRIPT=$(readlink -f "$0")
SCRIPTPATH=$(dirname "$SCRIPT")

mkdir -p /application/public/swagger

/application/vendor/bin/openapi --format json --bootstrap $SCRIPTPATH/swagger-variables.php --output /application/public/swagger/swagger.json /application/app

