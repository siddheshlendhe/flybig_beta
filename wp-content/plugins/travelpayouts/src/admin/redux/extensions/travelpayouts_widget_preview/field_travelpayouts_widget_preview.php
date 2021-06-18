<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

use Travelpayouts\admin\redux\base\ExtensionField;
use Travelpayouts\components\HtmlHelper;

if (!class_exists('TravelpayoutsSettingsFramework_Travelpayouts_Widget_Preview')) {
    /**
     * Class TravelpayoutsSettingsFramework_Travelpayouts_Widget_Preview
     * @property-read string $preview_url
     * @property-read array $script_attributes
     */
    class TravelpayoutsSettingsFramework_Travelpayouts_Widget_Preview extends ExtensionField
    {
        const WIDGET_ID = 'TravelpayoutsWidgetPreview';
        const WIDGET_PREVIEW_TYPE_IFRAME = 'iframe';
        const WIDGET_PREVIEW_TYPE_SCRIPT = 'iframe_script';

        protected $_assets = ['reduxWidgets'];

        public $attributes;
        public $previewText;
        public $element;
        public $fieldsPrefix;

        public function init()
        {
            $this->previewText = Travelpayouts::__('Widget preview');
        }

        protected function get_preview_url()
        {
                $query = http_build_query([
                    'action' => 'travelpayouts_widget_render',
                    'externalUrl' => '',
                ]);
                return admin_url('admin-ajax.php') . '?' . $query;
        }

        public function rules()
        {
            return [
                [
                    ['element', 'fieldsPrefix'], 'required'
                ],
                [
                    ['attributes'],
                    'is_array_validator'
                ],
                [
                    ['attributes'],
                    'attribute_src_validator'
                ],
            ];
        }

        public function is_array_validator($attribute, $params = [])
        {
            if (!$this->$attribute || !is_array($this->$attribute)) {
                $this->add_error($attribute, "$attribute must be an array");
            }
        }

        public function attribute_src_validator($attribute, $params = [])
        {
            if ($this->$attribute && is_array($this->$attribute)) {
                $attributeValue = $this->$attribute;
                if (!isset($attributeValue['src'])) {
                    $errorTemplate = Travelpayouts::__('Attribute attributes.src cannot be blank.');
                    $this->add_error($attribute, $errorTemplate);
                }
            }
        }

        public function get_script_attributes()
        {
            if ($this->attributes) {
                $attributes = $this->attributes;
                if ($this->element === self::WIDGET_PREVIEW_TYPE_SCRIPT) {
                    $attributes = array_merge($attributes, ['src' => urldecode($attributes['src'])]);
                }
                return $attributes;
            }
            return [];
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         * @since 1.0.0
         */
        public function render()
        {
            $this->set_attributes($this->field);
            if ($this->validate()) {
                $widgetProps = [
                    'attributes' => $this->script_attributes,
                    'type' => $this->element,
                    'previewEndpoint' => $this->preview_url,
                    'previewText' => $this->previewText,
                    'fieldPrefix' => $this->fieldsPrefix,
                    'formSelector'=> '.redux-form-wrapper',
                ];
                echo HtmlHelper::reactWidget(self::WIDGET_ID, $widgetProps);
            } else {
                var_dump($this->getErrors());
            }
        }
    }
}
