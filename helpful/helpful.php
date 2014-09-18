<?php

/**
 * @link              https://helpful.io
 * @since             1.0.0
 * @package           Helpful_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Helpful
 * Plugin URI:        https://helpful.io/
 * Description:       We redesigned the support tool to get out of the way, so you focus on being a helpful human. Helping your customers with good answers and thoughtful direction should be a breeze, focused 100% on support – and nothing else.
 * Version:           1.0.0
 * Author:            Helpful
 * Author URI:        https://helpful.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       helpful
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'HELPFUL_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'HELPFUL_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function setup_helpful_plugin() {
    load_helpful_dependencies();
    helpful_plugin()->start();
}

add_action( 'plugins_loaded', 'setup_helpful_plugin' );

/**
 * @since 1.0.0
 */
function load_helpful_dependencies() {
    require_once HELPFUL_DIR . '/bootstrap/construction-root.php';

    require_once HELPFUL_DIR . '/includes/functions.php';
    require_once HELPFUL_DIR . '/includes/class-helpful-plugin.php';
    require_once HELPFUL_DIR . '/includes/class-helpful-settings.php';
    require_once HELPFUL_DIR . '/includes/class-helpful-settings-manager.php';
    require_once HELPFUL_DIR . '/includes/class-helpful-settings-renderer.php';

    require_once HELPFUL_DIR . '/admin/class-helpful-admin-menu-creator.php';
    require_once HELPFUL_DIR . '/admin/class-helpful-options-admin-page.php';

    require_once HELPFUL_DIR . '/public/class-helpful-widget-installer.php';
    require_once HELPFUL_DIR . '/public/class-helpful-shortcode.php';
}
