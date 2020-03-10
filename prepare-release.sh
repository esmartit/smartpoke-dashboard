#!/bin/sh
#docker build -t esmartit/smartpoke-dashboard:"$1" -t esmartit/smartpoke-dashboard:latest .
#docker login -u $DOCKER_USER -p $DOCKER_PASS
#docker push esmartit/smartpoke-dashboard:"$1"
#docker push esmartit/smartpoke-dashboard:latest
#echo "${PWD}/smartpoke-dashboard/Chart.yaml"
#sed -i "s/x.x.x/$1/g" "${PWD}/smartpoke-dashboard/Chart.yaml"
#cat "${PWD}/smartpoke-dashboard/Chart.yaml"
#helm package smartpoke-dashboard
#git checkout -b gh-pages origin/gh-pages
#mv smartpoke-dashboard-0.1.0.tgz docs/
#git add docs/smartpoke-dashboard-0.1.0.tgz
#git commit -m "smartpoke-dashboard-0.1.0"
helm package smartpoke-dashboard --version "$1" --app-version "$1"
touch version.txt
echo "$1" >> version.txt
exit