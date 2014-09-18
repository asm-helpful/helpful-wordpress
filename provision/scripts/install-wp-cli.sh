# install WP-CLI
if [ ! -f $WP_CLI_PATH ]; then
    wget --quiet https://raw.github.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod a+x wp-cli.phar
    mv wp-cli.phar $WP_CLI_PATH
fi
