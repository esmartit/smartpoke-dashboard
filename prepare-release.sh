#!/bin/sh
docker build -t esmartit/smartpoke-dashboard:"$1" -t esmartit/smartpoke-dashboard:latest .
exit