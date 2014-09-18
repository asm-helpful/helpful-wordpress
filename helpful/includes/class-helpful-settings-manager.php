<?php

class Helpful_Settings_Manager {

    private $settings;
    private $settings_renderer;

    public function __construct( Helpful_Settings $settings, Helpful_Settings_Renderer $settings_renderer ) {
        $this->settings = $settings;
        $this->settings_renderer = $settings_renderer;
    }

    public function register_settings() {
        $this->settings->load_options();
        $this->register_plugin_settings();
        $this->settings->save_options();
    }

    private function register_plugin_settings() {
        $group = $this->settings->add_group( __( 'General', 'helpful' ), 'general', 10 );

        $section = $this->settings->add_section( $group, __( 'General Settings', 'helpful' ), 'general-settings', 10 );
        $this->settings->add_setting( $section, 'account-name', __( 'Helpful Account', 'helpful' ), 'textfield', '', __( 'The name of your Helpful account.', 'helpful' ) );

        $section = $this->settings->add_section( $group, __( 'Widget', 'helpful' ), 'widget-settings', 20 );
        $this->settings->add_setting( $section, 'enable-modal-widget', __( 'Enable Modal Widget', 'helpful' ), 'checkbox', 0, __( 'By the default the widget pops up next to the element that was clicked to open it. If you rather have it open in the middle of the screen, you can enable the modal option.', 'helpful' ) );
        $this->settings->add_setting( $section, 'enable-widget-overlay', __( 'Enable Widget Overlay', 'helpful' ), 'checkbox', 1, __( 'By the default a 70% transparent overlay is shown behind the widget. Use the overlay option to disable it. (Example is in combination with the modal option.)', 'helpful' ) );

        $section = $this->settings->add_section( $group, __( 'Widget Texts', 'helpful' ), 'widget-texts-settings', 30 );
        $this->settings->add_setting( $section, 'widget-title', __( 'Title', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-message-placeholder', __( 'Message Placeholder', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-next', __( 'Next', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-contact-information', __( 'Contact Information', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-contact-information-info', __( 'Contact Information Info', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-name-placeholder', __( 'Name Placeholder', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-email-placeholder', __( 'Email Placeholder', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-submit', __( 'Submit', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-thanks', __( 'Thanks', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-thanks-message', __( 'Thanks Message', 'helpful' ), 'textfield', '', '' );
        $this->settings->add_setting( $section, 'widget-submit-another', __( 'Submit Another', 'helpful' ), 'textfield', '', '' );
    }

    public function register_settings_in_wordpress() {
        register_setting( $this->settings->get_option_name(), $this->settings->get_option_name(), array( $this, 'sanitize_settings' ) );

        $groups = $this->settings->get_groups();
        uasort( $groups, create_function( '$a, $b', 'return $a["priority"] - $b["priority"];' ) );
        foreach ( $groups as $group ) {
            uasort( $group['sections'], create_function( '$a, $b', 'return $a["priority"] - $b["priority"];' ) );
            foreach ( $group['sections'] as $section ) {
                add_settings_section( $section['slug'], $section['name'], array( $this->settings_renderer, 'render_settings_section' ), $group['slug'] );
                foreach ( $section['settings'] as $setting ) {
                    $callback = array( $this->settings_renderer, "render_{$setting['type']}" );
                    $args = array_merge( array( 'label_for' => $setting['name'], 'setting' => $setting ), $setting['args'] );
                    add_settings_field( $setting['name'], $setting['label'], $callback, $group['slug'], $section['slug'], $args );
                }
            }
        }
    }

    public function sanitize_settings( $options ) {
        $this->settings->set_options( $options );
        return $options;
    }
}
