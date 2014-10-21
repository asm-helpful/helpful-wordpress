# Create symlink for main plugin
if [ ! -L $INSTALL_DIR/wp-content/plugins/helpful ]; then
  cd $INSTALL_DIR/wp-content/plugins
  ln -s $SOURCE_DIR/helpful .
fi
