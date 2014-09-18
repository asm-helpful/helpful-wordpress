# Install WordPress
mkdir -p $INSTALL_DIR
cd $INSTALL_DIR

if [ ! -f wp-settings.php ]; then
    $SU_COMMAND -c 'wp core download'
fi

if [ ! -f wp-config.php ]; then
    $SU_COMMAND -c "wp core config --dbname=wordpress --dbuser=root --dbpass=password --extra-php <<PHP
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SAVEQUERIES', true);
PHP"
fi

if ! $SU_COMMAND -c "wp core is-installed"; then
    $SU_COMMAND -c "wp core install --title='$BLOG_NAME' --admin_email='$ADMIN_EMAIL' --admin_user=admin --admin_password=password --url='$HOME_URL/wp-admin/install.php'"
fi

if ! ($SU_COMMAND -c "wp user list --fields=user_email" | grep john@guerrillamail.com); then
    $SU_COMMAND -c "wp user create john john@guerrillamail.com --user_pass=password --display_name='John Doe'"
fi

if ! ($SU_COMMAND -c "wp user list --fields=user_email" | grep jane@guerrillamail.com); then
    $SU_COMMAND -c "wp user create jane jane@guerrillamail.com --user_pass=password --display_name='Jane Doe'"
fi

# Create necessary directories and configure permissions
mkdir -p $INSTALL_DIR/wp-content/{uploads,upgrade,plugins}

chown $USER:$USER $INSTALL_DIR/wp-content/uploads
chmod -R 0777 $INSTALL_DIR/wp-content/uploads

chown $USER:$USER $INSTALL_DIR/wp-content/upgrade
chmod -R 0777 $INSTALL_DIR/wp-content/upgrade

chown $USER:$USER $INSTALL_DIR/wp-content/plugins
chmod -R 0777 $INSTALL_DIR/wp-content/plugins

# # Optionally install other plugins
# plugins= 'wordpress-beta-tester developer debug-bar debug-bar-cron debug-bar-extender log-deprecated-notices rewrite-rules-inspector query-monitor theme-check'

for plugin in $WORDPRESS_PLUGINS; do
  if ! ($SU_COMMAND -c "wp plugin is-installed $plugin"); then
    $SU_COMMAND -c "wp plugin install $plugin --activate"
  else
    echo "Plugin $plugin is already installed."
  fi
done

# Remove Hello Dolly
if [ -e "$INSTALL_DIR/wp-content/plugins/hello.php" ]; then
  rm $INSTALL_DIR/wp-content/plugins/hello.php
fi

# Install and activate responsive theme
if ! ( $SU_COMMAND -c "wp theme is-installed responsive" ); then
  $SU_COMMAND -c "wp theme install responsive --activate"
else
  echo "Theme responsive is already installed."
  $SU_COMMAND -c "wp theme activate responsive"
fi

# Setup permalinks
$SU_COMMAND -c "wp option update permalink_structure '/%year%/%monthnum%/%postname%/'"
