<?php

class Helpful_Options_Admin_Page {

    private $settings;

    public $title;
    public $menu_title;
    public $menu_slug;

    public function __construct( Helpful_Settings $settings ) {
        $this->title = __( 'Helpful Settings', 'helpful' );
        $this->menu_title = 'Helpful';
        $this->menu_slug = 'helpful-options';

        $this->settings = $settings;
    }

    public function get() {
        echo $this->render_template( 'admin/options-admin-page.tpl.php', array(
            'option_name' => $this->settings->get_option_name(),
            'settings_group' => 'helpful-general',
        ) );
    }

    protected function render_template( $template, $params = array() ) {
        extract( array_merge( $params, array( 'page' => $this ) ) );

        ob_start();
        include( HELPFUL_DIR . '/templates/' . $template );
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
