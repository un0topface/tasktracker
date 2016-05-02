#!/bin/sh

set -e

apt-get install -y ssh

echo "www-data ALL=(ALL:ALL) NOPASSWD: ALL" >> /etc/sudoers

mkdir -m 700 -p /var/www/.ssh
mkdir -m 700 -p /root/.ssh

mv /build/config/ssh_host_rsa_key /etc/ssh/ssh_host_rsa_key
chmod 644 /etc/ssh/ssh_host_rsa_key
