<?php

class Helpful_Shortcode {

    private $settings;

    public function __construct( Helpful_Settings $settings ) {
        $this->settings = $settings;
    }

    public function shortcode( $atts, $content = null ) {
        $atts = $this->get_shortcode_atts( $atts, $content );
        $template = $this->get_link_template();

        foreach ( $atts as $name => $value ) {
            $template = str_replace( "<$name>", esc_attr( $value ), $template );
        }

        // remove attributes with empty values
        foreach ( $atts as $name => $value ) {
            $template = preg_replace( sprintf( '/ data-helpful-%s=""/', preg_quote( str_replace( '_', '-', $name ) ) ), '', $template );
        }

        return wpautop( wptexturize( $template ) );
    }

    private function get_shortcode_atts( $atts, $content ) {
        $atts = shortcode_atts( $this->get_default_shortcode_atts( $content ), $atts );

        $atts['modal'] = helpful_boolval( $atts['modal'] ) ? 'on' : 'off';
        $atts['overlay'] = helpful_boolval( $atts['overlay'] ) ? 'on' : 'off';

        return $atts;
    }

    private function get_default_shortcode_atts( $content ) {
        $default_atts = $this->get_atts_from_settings( $content );
        $localized_texts = $this->get_localized_texts();

        foreach ( $localized_texts as $key => $value ) {
            if ( isset( $default_atts[ $key ] ) && empty( $default_atts[ $key ] ) ) {
                $default_atts[ $key ] = $localized_texts[ $key ];
            }
        }

        return $default_atts;
    }

    private function get_atts_from_settings( $content ) {
        return array(
            'account' =>                  $this->settings->get_option( 'account-name' ),

            'name' =>                     '',
            'email' =>                    '',

            'modal' =>                    $this->settings->get_option( 'enable-modal-widget' ),
            'overlay' =>                  $this->settings->get_option( 'enable-widget-overlay' ),

            'title' =>                    $this->settings->get_option( 'widget-title' ),
            'message_placeholder' =>      $this->settings->get_option( 'widget-message-placeholder' ),
            'next' =>                     $this->settings->get_option( 'widget-next' ),
            'contact_information' =>      $this->settings->get_option( 'widget-contact-information' ),
            'contact_information_info' => $this->settings->get_option( 'widget-contact-information-info' ),
            'name_placeholder' =>         $this->settings->get_option( 'widget-name-placeholder' ),
            'email_placeholder' =>        $this->settings->get_option( 'widget-email-placeholder' ),
            'submit' =>                   $this->settings->get_option( 'widget-submit' ),
            'thanks' =>                   $this->settings->get_option( 'widget-thanks' ),
            'thanks_message' =>           $this->settings->get_option( 'widget-thanks-message' ),
            'submit_another' =>           $this->settings->get_option( 'widget-submit-another' ),

            'content' => $content,
        );
    }

    private function get_localized_texts() {
        if ( function_exists( 'get_translations_for_domain' ) ) {
            $translations = get_translations_for_domain( 'helpful' );
        } else {
            $translations = null;
        }

        if ( is_null( $translations ) || is_a( $translations, 'NOOP_Translations') ) {
            $localized_texts = array();
        } else {
            $localized_texts = array(
                'title' =>                    _x( 'Got a question?', 'helpful-widget-texts', 'helpful' ),
                'message_placeholder' =>      _x( 'Type your message here...', 'helpful-widget-texts', 'helpful' ),
                'next' =>                     _x( 'Next', 'helpful-widget-texts', 'helpful' ),
                'contact_information' =>      _x( 'Your contact information.', 'helpful-widget-texts', 'helpful' ),
                'contact_information_info' => _x( 'So we can respond to your question.', 'helpful-widget-texts', 'helpful' ),
                'name_placeholder' =>         _x( 'Name', 'helpful-widget-texts', 'helpful' ),
                'email_placeholder' =>        _x( 'Email', 'helpful-widget-texts', 'helpful' ),
                'submit' =>                   _x( 'Submit you Question', 'helpful-widget-texts', 'helpful' ),
                'thanks' =>                   _x( 'Thanks!', 'helpful-widget-texts', 'helpful' ),
                'thanks_message' =>           _x( 'Have a wonderful day.', 'helpful-widget-texts', 'helpful' ),
                'submit_another' =>           _x( 'Submit another question?', 'helpful-widget-texts', 'helpful' ),
            );
        }

        return $localized_texts;
    }

    private function get_link_template() {
        return preg_replace( '/\n\s+/', ' ', '<a href="mailto:<account>@helpful.io"
                                                 data-helpful="<account>"
                                                 data-helpful-name="<name>"
                                                 data-helpful-email="<email>"
                                                 data-helpful-title="<title>"
                                                 data-helpful-message-placeholder="<message_placeholder>"
                                                 data-helpful-next="<next>"
                                                 data-helpful-contact-information="<contact_information>"
                                                 data-helpful-contact-information-info="<contact_information_info>"
                                                 data-helpful-name-placeholder="<name_placeholder>"
                                                 data-helpful-email-placeholder="<email_placeholder>"
                                                 data-helpful-submit="<submit>"
                                                 data-helpful-thanks="<thanks>"
                                                 data-helpful-thanks-message="<thanks_message>"
                                                 data-helpful-submit-another="<submit_another>"
                                                 data-helpful-modal="<modal>"
                                                 data-helpful-overlay="<overlay>"><content></a>' );
    }
}
