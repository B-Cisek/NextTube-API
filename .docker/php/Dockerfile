# FROM serversideup/php:8.3-fpm-nginx as base
FROM serversideup/php:8.3-fpm-nginx

# FROM base as development
USER root

# Save the build arguments as a variable
ARG USER_ID
ARG GROUP_ID

COPY php.ini /usr/local/etc/php/conf.d/

RUN install-php-extensions intl

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo ";zend_extension=xdebug" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Use the build arguments to change the UID
# and GID of www-data while also changing
# the file permissions for NGINX
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID && \
    \
    # Update the file permissions for our NGINX service to match the new UID/GID
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx

USER www-data

# FROM base as production
# Copy our app files as www-data (33:33)
# COPY --chown=www-data:www-data . /var/www/html
