FROM php:7.2.6-apache

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pgsql

COPY smartpoke.es/ /var/www/html/
RUN mkdir -p /var/www/html/smartpoke/datatables
RUN chown www-data:www-data /var/www/html/smartpoke/datatables

ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN echo date.timezone = $TZ > /usr/local/etc/php/conf.d/tzone.ini