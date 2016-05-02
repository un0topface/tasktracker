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

RUN cp /build/configDir/www.profile /var/www/.profile

RUN apt-get update \
    && apt-get install -y wget php5-pgsql realpath git mc rsync vim \
    && /build/ssh.sh \
    && rm -rf /build

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown www-data:www-data -R /var/www/

WORKDIR /var/www/app/

COPY ./build/docker-entrypoint.sh /

EXPOSE 22 80 433
CMD ["/docker-entrypoint.sh"]