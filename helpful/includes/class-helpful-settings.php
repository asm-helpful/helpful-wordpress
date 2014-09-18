<?php

class Helpful_Settings {

    private $groups = array();

    private $loaded_options = array();
    private $default_values = array();

    public function get_option_name() {
        return 'helpful-options';
    }

    public function get_groups() {
        return $this->groups;
    }

    public function add_group( $name, $slug, $priority ) {
        $new_slug = "helpful-$slug";

        $this->groups[ $new_slug ] = array(
            'slug' => $new_slug,
            'name' => $name,
            'priority' => $priority,
            'sections' => array(),
        );

        return $new_slug;
    }

    public function add_section( $group, $name, $slug, $priority ) {
        $this->groups[ $group ]['sections'][ $slug ] = array(
            'slug' => $slug,
            'name' => $name,
            'priority' => $priority,
            'settings' => array(),
        );

        return "$group:$slug";
    }

    public function add_setting( $section, $name, $label, $type, $default, $helptext, $args = array() ) {
        list( $group, $section ) = explode( ':', $section );

        if ( empty( $group ) || empty( $section ) ) {
            return false;
        }

        if ( ! isset( $this->groups[ $group ] ) ) {
            return false;
        }

        if ( ! isset( $this->groups[ $group ]['sections'][ $section ] ) ) {
            return false;
        }

        $this->groups[ $group ]['sections'][ $section ]['settings'][ $name ] = array(
            'name' => $name,
            'label' => $label,
            'type' => $type,
            'default' => $default,
            'helptext' => $helptext,
            'args' => $args,
        );

        if ( ! isset( $this->loaded_options[ $name ] ) ) {
            $this->loaded_options[ $name ] = $default;
        }

        $this->default_values[ $name ] = $default;

        return true;
    }

    public function set_options( $options ) {
        $this->loaded_options = $options;
    }

    public function load_options() {
        $this->loaded_options = get_option( $this->get_option_name(), array() );
    }

    public function save_options() {
        update_option( $this->get_option_name(), $this->loaded_options );
    }

    public function get_option( $name, $default = '' ) {
        if ( isset( $this->loaded_options[ $name ] ) ) {
            $value = $this->loaded_options[ $name ];
        } else {
            $value = $default;
        }

        return is_array( $value ) ? $value : trim( $value );
    }
}
