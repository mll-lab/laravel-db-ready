FROM php:8.0-cli

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        git \
        libzip-dev \
        zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        zip \
        mysqli \
        pdo_mysql \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

ARG USER
ARG USER_ID
ARG GROUP_ID

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    groupadd --force --gid ${GROUP_ID} ${USER} &&\
    useradd --no-log-init --uid ${USER_ID} --gid ${GROUP_ID} ${USER} \
;fi

USER ${USER}
