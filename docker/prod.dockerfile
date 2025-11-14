FROM php:8.3-cli

SHELL ["/bin/bash", "-c"]

ADD --chmod=0755 \
    https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    /usr/local/bin/

RUN install-php-extensions opcache @composer \
    bcmath

ENV COMPOSER_CACHE_DIR=/tmp
ENV TOOLS_PATH=tools
ADD installer.php packages.txt  /
RUN php installer.php $TOOLS_PATH

ADD --chmod=755 entrypoint.sh /

ENTRYPOINT ["/entrypoint.sh"]