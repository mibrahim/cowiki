#!/usr/bin/env bash
SUDO="sudo"
uNameOut="$(uname -s)"
case "${uNameOut}" in
    CYGWIN*)    
        SUDO=""
        ;;
    MINGW*)     
        SUDO=""
        ;;
esac

./stop.sh
${SUDO} docker rm --force cowiki-app
${SUDO} docker pull m0brhm/php-apache
${SUDO} docker run -d -p 8245:80 -p4022:22 --name cowiki-app -v "$PWD/web/":/var/www/html php:7.2-apache
