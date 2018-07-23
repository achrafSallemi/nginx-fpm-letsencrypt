FROM nginx

RUN   echo deb http://ftp.debian.org/debian stretch-backports main >> /etc/apt/sources.list \
  &&  apt-get update -qq \
  &&  apt-get install -y python-certbot-nginx -t stretch-backports

ENV   DOMAIN informative-widget.xcellerate.plista.se

COPY  default.conf /etc/nginx/conf.d/default.conf
COPY  index.html /var/www/

VOLUME  /mnt
COPY    configure_letsencrypt /configure_letsencrypt
CMD     ["bash", "-c", "/configure_letsencrypt ${DOMAIN} 1>&2"]

# we are lacking certificate renewal. the created certificate will be valid
# for 2 months after the start of the container.