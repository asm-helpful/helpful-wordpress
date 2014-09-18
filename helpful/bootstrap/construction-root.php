<?php

function helpful_singleton( $constructor_function ) {
    static $container = array();

    if ( ! isset( $container[ $constructor_function ] ) ) {
        $container[ $constructor_function ] = call_user_func( $constructor_function );
    }

    return $container[ $constructor_function ];
}

function helpful_plugin() {
    return new Helpful_Plugin();
}

function helpful_options_admin_page() {
    return new Helpful_Options_Admin_Page( helpful_singleton( 'helpful_settings' ) );
}

function helpful_settings() {
    return new Helpful_Settings();
}

function helpful_settings_renderer() {
    return new Helpful_Settings_Renderer( helpful_singleton( 'helpful_settings' ) );
}

function helpful_settings_manager() {
    return new Helpful_Settings_Manager( helpful_singleton( 'helpful_settings' ), helpful_singleton( 'helpful_settings_renderer' ) );
}

function helpful_shortcode() {
    return new Helpful_Shortcode( helpful_singleton( 'helpful_settings' ) );
}
