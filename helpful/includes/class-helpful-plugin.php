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

    public function start() {
        add_action( 'init', array( $this, 'setup' ) );
    }

    public function setup() {
        $this->register_scripts();

        $this->settings_manager = helpful_settings_manager();

        $this->common_setup();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            // $this->ajax_setup();
        } else if ( is_admin() ) {
            $this->admin_setup();
        } else {
            $this->public_setup();
        }
    }

    private function register_scripts() {
        wp_register_script( 'helpful-widget', '//assets.helpful.io/assets/widget.js', array(), $this->get_version(), true );
        // wp_register_script( 'helpful-widget', 'http://localhost:5000/assets/widget.js', array(), $this->get_version(), true );
    }

    private function common_setup() {
        $this->settings_manager->register_settings();
    }

    private function admin_setup() {
        add_action( 'admin_init', array( $this->settings_manager, 'register_settings_in_wordpress' ) );

        $admin_menu_creator = new Helpful_Admin_Menu_Creator();
        add_action( 'admin_menu', array( $admin_menu_creator, 'create_admin_menu' ) );
    }

    private function public_setup() {
        $widget_installer = new Helpful_Widget_Installer();
        add_action( 'wp_enqueue_scripts', array( $widget_installer, 'enqueue_scripts' ) );

        $helpful_shortcode = helpful_shortcode();
        add_shortcode( 'helpful', array( $helpful_shortcode, 'shortcode' ), 10, 2 );
    }
}
