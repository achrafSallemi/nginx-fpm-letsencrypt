# Docker-Php7-SSL-Nginx

A quick and easy way to setup your PHP application with SSL certificate using Docker. This will setup a developement environment with PHP7-fpm, SSL and Nginx.

## Usage
~~~
git clone git@github.com:achrafSallemi/docker-php7-xdebug-nginx.git
cd docker-php7-xdebug-nginx
docker-compose up -d
~~~

### Structure

~~~
├── app
│   └── public
│       └── index.php
├── docker-compose.yml
├── fpm
│   ├── Dockerfile
│   └── supervisord.conf
├── nginx
│   ├── Dockerfile
│   └── default.conf
~~~

- `app` is the directory for project files. Put your files there.
- `Nginx` config is pointing to `app/public`, which can be changed in `nginx/default.conf`
