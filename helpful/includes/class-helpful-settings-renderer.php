<?php

class Helpful_Settings_Renderer {

    private $settings;

    public function __construct( $settings ) {
        $this->settings = $settings;
    }

    /**
     * @param $args Array with the section's 'id', 'title' and 'callback'.
     */
    public function render_settings_section( $args ) {
        return '';
    }

    public function render_textfield( $args ) {
        $setting = $args['setting'];

        $description_length = strlen( $setting['helptext'] );
        $input_attributes = array(
            'id="' . esc_attr( $setting['name'] ) .'"',
            'class="regular-text"',
            'value="' . esc_attr( stripslashes( $this->settings->get_option( $setting['name'] ) ) ) . '"',
            'name="' . esc_attr( $this->settings->get_option_name() . '[' . $setting['name'] . ']' ) . '"',
        );

        if ( $description_length > 0 ) {
            $output = sprintf( '<input %s><br><span class="description">%s</span>', implode( ' ', $input_attributes ), $setting['helptext'] );
        } else {
            $output = sprintf( '<input %s>', implode( ' ', $input_attributes ) );
        }

        echo $output;
    }

    public function render_checkbox( $args ) {
        $setting = $args['setting'];

        $input_template = '<input %s>&nbsp;<label for="%s"><span class="description">%s</span></label>';
        $input_name = $this->settings->get_option_name() . '[' . $setting['name'] . ']';
        $input_attributes = array(
            'id="' . esc_attr( $setting['name'] ) .'"',
            'type="checkbox"',
            'value="1"',
            'name="' . esc_attr( $input_name ) . '"',
        );

        if ( $this->settings->get_option( $setting['name'] ) ) {
            $input_attributes[] = 'checked="checked"';
        }

        echo '<input type="hidden" value="0" name="' . esc_attr( $input_name ) . '" />';
        echo sprintf( $input_template, implode( ' ', $input_attributes ), $setting['name'], $setting['helptext'] );
    }
}
