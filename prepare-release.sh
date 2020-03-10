#!/bin/sh
#docker build -t esmartit/smartpoke-dashboard:"$1" -t esmartit/smartpoke-dashboard:latest .
#docker login -u $DOCKER_USER -p $DOCKER_PASS
#docker push esmartit/smartpoke-dashboard:"$1"
#docker push esmartit/smartpoke-dashboard:latest
sed -i "s/x.x.x/$1/g" "${PWD}/smartpoke-dashboard/Chart.yaml"
helm package smartpoke-dashboard
exit