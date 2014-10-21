#!/usr/bin/env bash

if [ "$HOME_URL" = "" ]; then
  echo "Please define HOME_URL as the Preview URL of this box."
  return
fi

export BLOG_NAME="WordPress Plugin for Helpful"
export ADMIN_EMAIL=helpful-wordpress-admin@sharklasers.com

# setup path
mkdir -p /home/action/bin
export PATH="/home/action/bin:$PATH"

export USER=action
export SU_COMMAND=bash

export PHP_INI_PATH=/home/action/.parts/etc/php5/php.ini
export APACHE_CONF_PATH=/home/action/.parts/etc/apache2/httpd.conf
export APACHE_CONF_DIR=/home/action/.parts/etc/apache2/config

export WP_CLI_PATH=/home/action/bin/wp

export SOURCE_DIR=/home/action/workspace/helpful-wordpress
export INSTALL_DIR=/home/action/workspace/www
export DOCUMENT_ROOT=/home/action/workspace/www

(source install-wp-cli.sh)
(source configure-php.sh)

parts start mysql

(source configure-mysql.sh)
(source create-htaccess.sh)
(source install-wordpress.sh)
(source symlink-plugin-dir.sh)

cd $HOME
