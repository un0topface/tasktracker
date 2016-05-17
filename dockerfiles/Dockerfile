FROM romeoz/docker-nginx-php:5.6

ENV OS_LOCALE="ru_RU.UTF-8"
RUN locale-gen ${OS_LOCALE}
ENV LANG=${OS_LOCALE} \
	LANGUAGE=ru_RU:en \
	LC_ALL=${OS_LOCALE}
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime \
    && echo Europe/Moscow > /etc/timezone

RUN chsh -s /bin/bash www-data

ADD ./build /build

RUN cp /build/config/www.profile /var/www/.profile
RUN rm -rf /etc/nginx/sites-enabled/app.conf
RUN cp /build/config/tasktracker.nginx.conf /etc/nginx/sites-enabled

RUN apt-get update \
    && /build/php.sh \
    && apt-get install -y wget realpath git mc rsync vim \
    && /build/ssh.sh \
    && rm -rf /build

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown www-data:www-data -R /var/www/

WORKDIR /var/www/app/

COPY ./build/docker-entrypoint.sh /

EXPOSE 22 80 433
ENTRYPOINT ["/docker-entrypoint.sh"]
