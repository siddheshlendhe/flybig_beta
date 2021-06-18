<?php
/**
 * The template for the panel footer area.
 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
 *
 * @author        Redux Framework
 * @package       TravelpayoutsSettingsFramework/Templates
 * @version:      4.0.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

?>
<div id="redux-sticky-padder" style="display: none;">&nbsp;</div>
<div id="redux-footer-sticky">
    <div id="redux-footer">
        <div class="redux-action_bar">
            <span class="spinner"></span>
            <?php
            if (false === $this->parent->args['hide_save']) {
                submit_button(Travelpayouts::esc_html__('Save Changes'), 'primary', 'redux_save', false, ['id' => 'redux_bottom_save']);
            }
            /*
                        if ( false === $this->parent->args['hide_reset'] ) {
                            submit_button( esc_html__( 'Reset Section', 'redux-framework' ), 'secondary', $this->parent->args['opt_name'] . '[defaults-section]', false, array( 'id' => 'redux-defaults-section-bottom' ) );
                            submit_button( esc_html__( 'Reset All', 'redux-framework' ), 'secondary', $this->parent->args['opt_name'] . '[defaults]', false, array( 'id' => 'redux-defaults-bottom' ) );
                        }
            */
            ?>
        </div>
        <div class="redux-ajax-loading" alt="<?php Travelpayouts::esc_html__('Working...'); ?>">&nbsp;</div>
        <div class="clear"></div>
    </div>
</div>
