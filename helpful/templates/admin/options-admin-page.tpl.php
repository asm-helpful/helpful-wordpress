<div class="wrap">
    <h2><?php echo $page->title; ?></h2>
    <div class="page-content">
        <form class="settings-form" action="<?php echo esc_attr( admin_url( 'options.php' ) ); ?>" method="post">
            <?php settings_fields( $option_name ); ?>

            <?php
                ob_start();
                do_settings_sections( $settings_group );
                $content = ob_get_contents();
                ob_end_clean();
            ?>

            <?php if ( $content ): ?>
            <p class="submit hidden">
                <input type="submit" value="<?php echo esc_html( __( 'Save Changes', 'helpful' ) ); ?>" class="button-primary" id="submit-top" name="submit">
            </p>

            <?php echo $content; ?>

            <p class="submit">
                <input type="submit" value="<?php echo esc_html( __( 'Save Changes', 'helpful' ) ); ?>" class="button-primary" id="submit-bottom" name="submit">
            </p>
            <?php endif; ?>
        </form>
    </div>
</div>
