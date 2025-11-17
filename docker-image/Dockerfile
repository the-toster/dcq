ARG PHP_VER=8.3
FROM php:${PHP_VER}-cli

SHELL ["/bin/bash", "-c"]

ADD --chmod=0755 \
    https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    /usr/local/bin/

RUN install-php-extensions opcache @composer \
    bcmath

ENV XDG_CACHE_HOME=/tmp
ENV TOOLS_PATH=/tools
ADD installer.php packages.txt  /
RUN php installer.php $TOOLS_PATH

ADD --chmod=755 entrypoint.sh /

ENTRYPOINT ["/entrypoint.sh"]