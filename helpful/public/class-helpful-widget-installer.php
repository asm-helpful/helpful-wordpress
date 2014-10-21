<?php

/**
 * The file that defines the class that will install the Helpful
 * widget public-facing side of the site.
 *
 * @link        http://helpful.io
 * @since       1.0.0
 *
 * @package     Helpful_Plugin
 * @subpackage  Helpful_Plugin/public
 */

class Helpful_Widget_Installer {

    public function enqueue_scripts() {
        wp_enqueue_script( 'helpful-widget' );
    }
}
