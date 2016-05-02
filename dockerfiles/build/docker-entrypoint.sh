#!/bin/sh

echo "${DEV_SSH_PUBKEY}" >> /var/www/.ssh/authorized_keys
echo "${DEV_SSH_PUBKEY}" >> /root/.ssh/authorized_keys

service ssh restart
/usr/bin/supervisord
