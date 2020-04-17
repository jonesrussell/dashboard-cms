FROM ubuntu:18.04

LABEL maintainer="Chris Fidao"

ARG USERNAME=vessel
ARG PHPV=7.3

RUN useradd -ms /bin/bash -u 1000 ${USERNAME}
WORKDIR /var/www/html

ENV TZ=America/Toronto
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone

RUN set -x \
  && apt-get update && apt-get install -y gnupg gosu \
  && apt-get -y autoremove \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && gosu nobody true

RUN echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu bionic main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
  && echo "deb http://ppa.launchpad.net/nginx/development/ubuntu bionic main" > /etc/apt/sources.list.d/ppa_nginx_mainline.list \
  && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
  && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
  && apt-get update \
  && apt-get install -y curl zip unzip git supervisor sqlite3 zsh sudo \
  && apt-get install -y nginx php${PHPV}-fpm php${PHPV}-cli \
  php${PHPV}-pgsql php${PHPV}-sqlite3 php${PHPV}-gd \
  php${PHPV}-curl php${PHPV}-memcached \
  php${PHPV}-imap php${PHPV}-mysql php${PHPV}-mbstring \
  php${PHPV}-xml php${PHPV}-zip php${PHPV}-bcmath php${PHPV}-soap \
  php${PHPV}-intl php${PHPV}-readline php${PHPV}-xdebug \
  php${PHPV}-msgpack php${PHPV}-igbinary php${PHPV}-ldap \
  php-redis libnginx-mod-http-uploadprogress wget \
  && mkdir /run/php \
  && apt-get -y autoremove \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && sed -i "s/pm\.max_children = .*/pm.max_children = 20/" /etc/php/${PHPV}/fpm/pool.d/www.conf \
  && sed -i "s/pm\.start_servers = .*/pm.start_servers = 10/" /etc/php/${PHPV}/fpm/pool.d/www.conf \
  && sed -i "s/pm\.min_spare_servers = .*/pm.min_spare_servers = 5/" /etc/php/${PHPV}/fpm/pool.d/www.conf \
  && sed -i "s/pm\.max_spare_servers = .*/pm.max_spare_servers = 10/" /etc/php/${PHPV}/fpm/pool.d/www.conf \
  && echo "daemon off;" >> /etc/nginx/nginx.conf

RUN echo ${USERNAME} ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/${USERNAME} \
  && chmod 0440 /etc/sudoers.d/${USERNAME} \
  && ln -sf /dev/stdout /var/log/nginx/access.log \
  && ln -sf /dev/stderr /var/log/nginx/error.log

COPY default /etc/nginx/sites-available/default
COPY php-fpm.conf /etc/php/${PHPV}/fpm/php-fpm.conf
COPY xdebug.ini /etc/php/${PHPV}/mods-available/xdebug.ini
COPY vessel.ini /etc/php/${PHPV}/fpm/conf.d/99-vessel.ini

EXPOSE 80

# Install oh-my-zsh
USER ${USERNAME}
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" \
  && mkdir -p /home/${USERNAME}/.composer
USER root

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY auth.json /home/${USERNAME}/.composer/

RUN curl -L "https://github.com/docker/compose/releases/download/1.25.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
  && chmod +x /usr/local/bin/docker-compose \
  && chown ${USERNAME} /home/${USERNAME}/.composer/auth.json

# COPY --from=drush/drush /usr/local/bin/drush /usr/local/bin/drush
RUN wget -O /usr/local/bin/drush https://github.com/drush-ops/drush-launcher/releases/latest/download/drush.phar \
  && chmod +x /usr/local/bin/drush
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
