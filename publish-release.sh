#!/bin/sh
docker login -u $DOCKER_USER -p $DOCKER_PASS
docker push esmartit/smartpoke-dashboard:"$1"
docker push esmartit/smartpoke-dashboard:latest
helm package smartpoke-dashboard --version "$1" --app-version "$1"
touch version.txt
echo "$1" >> version.txt
exit