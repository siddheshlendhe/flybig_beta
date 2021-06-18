<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('TravelpayoutsSettingsFramework_Travelpayouts_Settings_Import')) {

    class TravelpayoutsSettingsFramework_Travelpayouts_Settings_Import
    {
        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @return      void
         * @since       1.0.0
         * @access      public
         */
        public function __construct($field = [], $value = '', $parent = '')
        {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @return      void
         * @since       1.0.0
         * @access      public
         */
        public function render()
        {
            $html = '<div>';
            $html .= '<input type="file" id="travelpayouts_import_settings_file" />';
            $html .= '<span id="travelpayouts_import_settings_button" class="button button-primary" style="margin: 0 0 0 5px;">' . Travelpayouts::__('Import') . '</span>';
            $html .= '</div>';
            echo $html;
        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @throws Exception
         */
        public function enqueue()
        {
            wp_enqueue_script(
                'redux-field-travelpayouts-settings-import-js',
                Travelpayouts::getAlias('@webadmin/redux/extensions/travelpayouts_settings_import/field_travelpayouts_settings_import.min.js'),
                ['jquery'],
                time(),
                true
            );
        }
    }
}
