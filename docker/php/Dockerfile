FROM alpine:edge

RUN echo 'http://dl-cdn.alpinelinux.org/alpine/edge/testing' >> /etc/apk/repositories && \
    apk --update add \
        php7 \
        php7-dom \
        php7-curl \
        php7-fileinfo \
        php7-fpm \
        php7-gd \
        php7-iconv \
        php7-json \
        php7-session \
        php7-mbstring \
        php7-mcrypt \
        php7-mysqlnd \
        php7-opcache \
        php7-pdo \
        php7-pdo_mysql \
        php7-pdo_pgsql \
        php7-mysqli \
        php7-soap \
        php7-xml \
        php7-xmlreader \
        php7-xmlwriter \
        php7-ctype \
        php7-tokenizer \
        php7-pgsql \
        php7-redis \
        php7-zlib \
    && rm -rf /var/cache/apk/*

COPY php.ini /etc/php7/conf.d/50-setting.ini
COPY php-fpm.conf /etc/php7/php-fpm.conf

EXPOSE 8000

CMD ["php-fpm7", "-F"]

