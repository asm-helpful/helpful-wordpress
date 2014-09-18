<?php

/**
 * The file that defines the core plugin class
 *
 * @link        http://helpful.io
 * @since       1.0.0
 *
 * @package     Helpful_Plugin
 * @subpackage  Helpful_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * @since       1.0.0
 * @package     Helpful_PLugin
 * @subpackage  Helpful_Plugin/includes
 * @author      Willington Vega <wvega@wvega.com>
 */
class Helpful_Plugin {

    protected $name;
    protected $version;

    public function __construct() {
        $this->name = 'helpful';
        $this->version = '1.0.0-dev-1';
    }

    public function get_version() {
        return $this->version;
    }

    public function setup() {
        $this->load_dependencies();
        $this->setup_common_hooks();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            // $this->setup_ajax_hooks();
        } else if ( is_admin() ) {
            // $this->setup_admin_hooks();
        } else {
            $this->setup_public_hooks();
        }
    }

    private function load_dependencies() {
        /**
         * The clas responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once HELPFUL_DIR . '/public/class-helpful-widget-installer.php';
    }

    private function setup_common_hooks() {
        add_action( 'init', array( $this, 'register_scripts' ) );
    }

    public function register_scripts() {
        wp_register_script( 'helpful-widget', '//assets.helpful.io/assets/widget.js', array(), $this->get_version(), true );
    }

    private function setup_public_hooks() {
        $widget_installer = new Helpful_Widget_Installer();
        add_action( 'wp_enqueue_scripts', array( $widget_installer, 'enqueue_scripts' ) );
    }
}
