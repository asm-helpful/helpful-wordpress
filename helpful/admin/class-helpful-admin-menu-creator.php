<?php

/**
 * The file that defines the class that will create the admin
 * menu entries.
 *
 * @since       1.0.0
 *
 * @package     Helpful_Plugin
 * @subpackage  Helpful_Plugin/admin
 */

class Helpful_Admin_Menu_Creator {

    public function create_admin_menu() {
        $page = helpful_options_admin_page();
        add_options_page( $page->title, $page->menu_title, 'install_plugins', $page->menu_slug, array( $page, 'get' ) );
    }
}
