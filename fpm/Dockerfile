FROM ubuntu:latest

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y software-properties-common language-pack-en-base \
    && LC_ALL=en_US.UTF-8 add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php7.0 php7.0-fpm php7.0-xdebug mcrypt php7.0-gd php7.0-memcache php7.0-geoip memcached zip gzip curl \
       php7.0-curl supervisor net-tools \
    && mkdir /run/php \
    && apt-get clean && rm -rf /tmp/* /var/tmp/*

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY app /var/app

RUN sed -i -e 's/listen = \/run\/php\/php7.0-fpm.sock/listen = 0.0.0.0:9000/g' /etc/php/7.0/fpm/pool.d/www.conf \
    && sed -i -e 's/;daemonize = yes/daemonize = no/g' /etc/php/7.0/fpm/php-fpm.conf

RUN curl http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz --output GeoLiteCity.dat.gz
RUN gunzip GeoLiteCity.dat.gz
RUN mv GeoLiteCity.dat /usr/share/GeoIP/GeoIPCity.dat

RUN echo 'xdebug.idekey=PHPSTORM' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.default_enable=0' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_enable=on' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_autostart=on' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_connect_back=off' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_handler=dbgp' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.profiler_enable=off' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.profiler_output_dir="/var/app/public"' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_port=9001' >> /etc/php/7.0/mods-available/xdebug.ini
RUN echo 'xdebug.remote_host=192.168.6.51' >> /etc/php/7.0/mods-available/xdebug.ini

WORKDIR /var/app

CMD ["/usr/bin/supervisord"]