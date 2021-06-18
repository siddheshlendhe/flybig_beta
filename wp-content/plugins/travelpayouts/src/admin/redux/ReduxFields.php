<?php

namespace Travelpayouts\admin\redux;

use Exception;
use Travelpayouts;
use Travelpayouts\components\HtmlHelper;
use Travelpayouts\components\Platforms;
use Travelpayouts\helpers\ArrayHelper;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\modules\tables\components\flights\ColumnLabels as FlightsColumnLabels;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels as HotelsColumnLabels;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels as RailwayColumnLabels;
use Travelpayouts\modules\searchForms\components\models\SearchForm;

class ReduxFields
{
    const WIDGET_PREVIEW_TYPE_IFRAME = 'iframe';
    const WIDGET_PREVIEW_TYPE_SCRIPT = 'iframe_script';


    const RADIO_LAYOUT_DEFAULT = 'full';
    const RADIO_LAYOUT_INLINE = 'inline';

    /**
     * @param $prefix
     * @param $id
     * @return string
     */
    public static function get_ID($prefix, $id, $path = false)
    {
        $path_prefix = '';
        if ($path) {
            $path_prefix = str_replace('/', '_', $path) . '_';
        }

        return $path_prefix . $prefix . '_' . $id;
    }

    /**
     * @param $prefix
     * @param $with_default
     * @return array
     */
    public static function width_toggle($prefix, $with_default, $required = '')
    {
        return [
            self::select(
                'scalling_width_toggle',
                Travelpayouts::__('Stretch width'),
                [
                    ReduxOptions::STRETCH_WIDTH_YES => Travelpayouts::__('Yes'),
                    ReduxOptions::STRETCH_WIDTH_NO => Travelpayouts::__('No'),
                ],
                ReduxOptions::STRETCH_WIDTH_NO
            ),
            [
                'id' => 'scalling_width',
                'type' => 'dimensions',
                'select2' => self::select2Options(),
                'units' => ['px'],
                'height' => false,
                'title' => Travelpayouts::__('Width'),
                'default' => [
                    'width' => $with_default,
                ],
                'required' => [
                    $required,
                    'equals',
                    false,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function flight_directions($attributes = [])
    {
        if (empty($attributes)) {
            $attributes = [

                'url' => '//autocomplete.travelpayouts.com/places2?locale=ru&types[]=city&term={{query}}',
                'optionLabel' => '{{name}}, {{country_name}}',
                'noOptionsMessage' => Travelpayouts::__('Not found'),
                'loadingMessage' => Travelpayouts::__('Loading results'),
                'placeholder' => Travelpayouts::__('Select...'),
            ];
        }

        return [
            self::tp_autocomplete(
                'city_departure',
                $attributes,
                Travelpayouts::__('Directions'),
                '',
                Travelpayouts::__('City of departure'),
                Travelpayouts::__('Phuket')
            ),
            self::tp_autocomplete(
                'city_arrive',
                $attributes,
                '',
                '',
                Travelpayouts::__('City of arrival'),
                Travelpayouts::__('Bangkok')
            ),
        ];
    }

    /**
     * @param $id
     * @param $title
     * @param string $subtitle
     * @param string $desc
     * @param string $default
     * @return array
     */
    public static function text($id, $title, $subtitle = '', $desc = '', $default = '', $required = [])
    {
        $text = [
            'id' => $id,
            'type' => 'text',
            'title' => $title,
            'subtitle' => $subtitle,
            'desc' => $desc,
            'default' => $default,
            'required' => $required
        ];

        return $text;
    }

    /**
     * Инпут, в котором значение берется из placeholder, если значение пусто
     * @param $id
     * @param $title
     * @param string $subtitle
     * @param string $desc
     * @param string $default
     * @return array
     */
    public static function placeholderInput($id, $title, $subtitle = '', $desc = '', $default = '')
    {
        return array_merge(self::text($id, $title, $subtitle, $desc), [
            'class' => 'input-with-placeholder',
            'placeholder' => $default,
        ]);
    }

    public static function tp_suggest($id, $title, $subtitle = '', $desc = '', $default = '')
    {
        $tp_suggest = [
            'id' => $id,
            'type' => 'travelpayouts_suggest',
            'title' => $title,
            'subtitle' => $subtitle,
            'desc' => $desc,
            'default' => $default,
        ];


        return $tp_suggest;
    }

    public static function tp_autocomplete($id, $attributes, $title, $subtitle = '', $desc = '', $default = '')
    {
        $tp_suggest = [
            'id' => $id,
            'attributes' => $attributes,
            'type' => 'travelpayouts_autocomplete',
            'title' => $title,
            'subtitle' => $subtitle,
            'desc' => $desc,
            'default' => $default,
        ];
        return $tp_suggest;
    }


    public static function raw($id, $content)
    {
        $preview = [
            'id' => $id,
            'type' => 'raw',
            'content' => $content,
			'full_width'=>false,
        ];

        return $preview;
    }

    public static function get_image_url($img)
    {
        return Travelpayouts::getAlias('@webImages') . '/' . $img;
    }

    /**
     * @param $id
     * @param $title
     * @param $width
     * @param $height
     * @param string $subtitle
     * @return array
     */
    public static function dimensions($id, $title, $width, $height, $subtitle = '')
    {
        return [
            'id' => $id,
            'type' => 'dimensions',
            'units' => ['px'],
            'title' => $title,
            'subtitle' => $subtitle,
            'default' => [
                'width' => $width,
                'height' => $height,
            ],
        ];
    }

    public static function dimensionsValidationLogo($id, $title, $width, $height, $subtitle = '')
    {
        $dimensions = self::dimensions($id, $title, $width, $height, $subtitle);

        $dimensions['validate_callback'] = 'travelpayoutsValidateLogoDimensions';

        return $dimensions;
    }

    /**
     * @param $id
     * @param $title
     * @param string $subtitle
     * @param bool $default
     * @return array
     */
    public static function checkbox($id, $title, $subtitle = '', $default = false)
    {
        $checkbox = [
            'id' => $id,
            'type' => 'checkbox',
            'title' => $title,
            'subtitle' => $subtitle,
            'default' => $default,
        ];

        return $checkbox;
    }

    /**
     * @param $id
     * @param $title
     * @param $options
     * @param string $subtitle
     * @return array
     */
    public static function checkbox_list($id, $title, $options, $subtitle = '')
    {
        $checkbox_list = [
            'id' => $id,
            'type' => 'checkbox',
            'title' => $title,
            'subtitle' => $subtitle,
            'options' => $options,
        ];

        return $checkbox_list;
    }

    /**
     * @param $id
     * @param $title
     * @param string $subtitle
     * @param string $default
     * @param bool $required
     * @return array
     */
    public static function color($id, $title, $subtitle = '', $default = '#FFFFFF', $required = false)
    {
        $color = [
            'id' => $id,
            'type' => 'color',
            'title' => $title,
            'subtitle' => $subtitle,
            'default' => $default,
            'validate' => 'color',
            'required' => $required,
        ];

        return $color;
    }

    /**
     * @param $id
     * @param $title
     * @param $desc
     * @param $options
     * @param $default
     * @return array
     */
    public static function color_scheme($id, $title, $desc, $options, $default)
    {
        $scheme = [
            'id' => $id,
            'type' => 'palette',
            'title' => $title,
            'desc' => $desc,
            'default' => $default,
            'palettes' => $options,
        ];

        return $scheme;
    }

    /**
     * @param array $options
     * @param null $default
     * @return array
     */
    public static function widget_design($options, $default = null)
    {
        return self::select(
            'widget_design',
            Travelpayouts::__('Widget design'),
            $options,
            $default,
            ''
        );
    }

    /**
     * @param $id
     * @param $title
     * @param $default
     * @param $min
     * @param $max
     * @param bool $required
     * @return array
     */
    public static function simple_text_slider($id, $title, $default, $min, $max, $required = false)
    {
        $slider = [
            'id' => $id,
            'type' => 'slider',
            'title' => $title,
            'default' => $default,
            'min' => $min,
            'step' => 1,
            'max' => $max,
            'display_value' => 'text',
            'required' => $required,
        ];

        return $slider;
    }

    /**
     * @param $id
     * @param $title
     * @param $default
     * @param $min
     * @param $step
     * @param $max
     * @param $display
     * @param $handles
     * @return array
     */
    public static function slider($id, $title, $default, $min, $step, $max, $display, $handles)
    {
        $slider = [
            'id' => $id,
            'type' => 'slider',
            'title' => $title,
            'default' => $default,
            'min' => $min,
            'step' => $step,
            'max' => $max,
            'display_value' => $display,
            'handles' => $handles,
        ];

        return $slider;
    }

    /**
     * @param $id
     * @param $title
     * @param $options
     * @param bool $default
     * @param string $layout
     * @return array
     */
    public static function radio($id, $title, $options, $default = false, $layout = self::RADIO_LAYOUT_DEFAULT)
    {
        $radio = [
            'id' => $id,
            'type' => 'radio',
            'title' => $title,
            'options' => $options,
            'default' => $default,
            'multi_layout' => $layout,
        ];

        return $radio;
    }

    /**
     * @param $id
     * @param $title
     * @param $options
     * @param string $default
     * @param string $subtitle
     * @param string $desc
     * @return array
     */
    public static function select($id, $title, $options, $default = '', $subtitle = '', $desc = '')
    {
        $select = [
            'id' => $id,
            'type' => 'select',
            'title' => $title,
            'subtitle' => $subtitle,
            'desc' => $desc,
            'options' => $options,
            'select2' => self::select2Options(),
            'default' => $default,
        ];

        return $select;
    }

    public static function platformSelect()
    {
        return [
            'id' => 'platform',
            'type' => 'travelpayouts_platform_select',
            'title' => Travelpayouts::__('Traffic Source'),
            'subtitle' => Travelpayouts::__('Please select a relevant source for your website'),
            'desc' => Travelpayouts::__('To attribute your stats correctly, please select a relevant source for your website. You can edit or add new sources at <a href="https://www.travelpayouts.com/profile/sources" target="_blank">Travelpayouts.com</a>'),
            'options' => Platforms::getInstance()->getSelectOptions(),
            'default' => '0',
        ];
    }

    public static function selectRequired(
        $id,
        $title,
        $options,
        $idRequired,
        $valueRequired,
        $default = '',
        $subtitle = '',
        $desc = ''
    )
    {
        return [
            'id' => $id,
            'type' => 'select',
            'title' => $title,
            'subtitle' => $subtitle,
            'desc' => $desc,
            'options' => $options,
            'select2' => self::select2Options(),
            'default' => $default,
            'required' => [
                $idRequired,
                'equals',
                $valueRequired,
            ],
        ];
    }

    public static function selectMultiLang(
        $id,
        $title,
        $options,
        $default = '',
        $subtitle = '',
        $desc = ''
    )
    {
        return self::makeFieldMultiLang(
            $id,
            $title,
            [
                'type' => 'select',
                'subtitle' => $subtitle,
                'desc' => $desc,
                'options' => $options,
                'select2' => self::select2Options(),
                'default' => $default,
            ]
        );
    }

    private static function makeFieldMultiLang($id, $title, $other = [])
    {
        $languagesData = Travelpayouts::getInstance()->multiLang->data;

        $fields[] = array_merge(
            [
                'id' => $id,
                'title' => $title,
            ],
            $other
        );
        if (!empty($languagesData)) {
            foreach ($languagesData['languagesList'] as $language) {
                if ($language !== $languagesData['default']) {
                    $fields[] = array_merge(
                        [
                            'id' => $id . '_' . $language,
                            'title' => $title . ' ' . $language,
                        ],
                        $other
                    );
                }
            }
        }

        return $fields;
    }

    /**
     * @param $id
     * @param $title
     * @param $subtitle
     * @param $enabled_label
     * @param $disabled_label
     * @param $options
     * @return array
     */
    public static function tp_columns($id, $title, $subtitle, $enabled_label, $disabled_label, $options)
    {
        $tp_columns = [
            'id' => $id,
            'type' => 'travelpayouts_sorter',
            'title' => $title,
            'subtitle' => $subtitle,
            'columnsOptions' => [
                'enabled' => [
                    'label' => $enabled_label,
                ],
                'disabled' => [
                    'label' => $disabled_label,
                ],
            ],
            'options' => $options,
        ];

        return $tp_columns;
    }

    /**
     * @param $title
     * @param null $subtitle
     * @param bool $open
     * @return array
     */
    public static function accordion_start($title, $subtitle = null, $open = false)
    {
        $start = [
            'id' => 'ws',
            'type' => 'osc_accordion',
            'title' => $title,
            'subtitle' => $subtitle,
            'position' => 'start',
            'open' => $open,
        ];

        return $start;
    }

    /**
     * @return array
     */
    public static function accordion_end()
    {
        $end = [
            'id' => 'we',
            'type' => 'osc_accordion',
            'position' => 'end',
            'class' => 'travelpayouts-destroy',
        ];

        return $end;
    }

    /**
     * @param $prefix
     * @param $title
     * @param string $subtitle
     * @param bool $indent
     * @return array
     */
    public static function section_start($prefix, $title, $subtitle = '', $indent = false)
    {
        $start = [
            'id' => self::get_ID($prefix, 'section-start'),
            'type' => 'section',
            'title' => $title,
            'subtitle' => $subtitle,
            'indent' => $indent,
        ];

        return $start;
    }

    /**
     * @param $prefix
     * @param bool $indent
     * @return array
     */
    public static function section_end($prefix, $indent = false)
    {
        $start = [
            'id' => self::get_ID($prefix, 'section-end'),
            'type' => 'section',
            'indent' => $indent,
        ];

        return $start;
    }

    public static function sort_hotels_field($default)
    {
        return self::select(
            'sort_by',
            Travelpayouts::__('Sort by column'),
            HotelsColumnLabels::getInstance()->columnLabels(),
            $default
        );
    }

    public static function sort_railway_field($default)
    {
        return self::select(
            'sort_by',
            Travelpayouts::__('Sort by column'),
            RailwayColumnLabels::getInstance()->columnLabels(),
            $default
        );
    }

    public static function sortByField($enabled, $default = null)
    {
        if (isset($enabled['placebo'])) {
            unset($enabled['placebo']);
        }

        if (empty($default) && is_array($enabled)) {
            $enabledKeys = array_keys($enabled);
            $default = array_shift($enabledKeys);
        }

        return [
            'id' => 'sort_by',
            'type' => 'travelpayouts_sortby',
            'title' => Travelpayouts::__('Sort by column'),
            'subtitle' => '',
            'desc' => '',
            'select2' => self::select2Options(),
            'options' => $enabled,
            'default' => $default,
        ];
    }

    public static function sortByData($enabled, $default = null)
    {
        return [
            'enabled' => $enabled,
            'default' => $default,
        ];
    }

    public static function table_base(
        $prefix,
        $title,
        $description,
        $columns_options,
        $additional = [],
        $sort_data = [],
        $title_default = '',
        $button_default = '',
        $title_sub = null,
        $button_price = true
    )
    {
        if (!empty($sort_data['enabled'])) {
            $enabled_columns = $sort_data['enabled'];
        } else {
            $enabled_columns = self::sorterColumnsDefault($prefix, $columns_options);
        }

        if (empty($title_sub)) {
            $title_sub = Travelpayouts::__('Use {origin} and {destination} variables to automatically add the city.');
        }

        if ($button_price === true) {
            $button_desc = Travelpayouts::__('{price} variable can be used');
        } else {
            $button_desc = '';
        }

        $base = [
            self::accordion_start(
                $title,
                $description,
                false
            ),
            self::placeholderInput(
                'title',
                Travelpayouts::__('Table header text'),
                '',
                $title_sub,
                $title_default
            ),
            self::select(
                'title_tag',
                Travelpayouts::__('Table header text tag'),
                ReduxOptions::title_tags(),
                'h3'
            ),
            self::tp_columns(
                'columns',
                Travelpayouts::__('Table columns'),
                Travelpayouts::__('We offer a readymade combination for such a table, but you can edit the number 
                of columns and their arrangement.'),
                Travelpayouts::__('Visible'),
                Travelpayouts::__('Hidden'),
                $columns_options
            ),
            self::placeholderInput(
                'button_title',
                Travelpayouts::__('Button title'),
                '',
                $button_desc,
                $button_default
            ),
            self::sortByField($enabled_columns, $sort_data['default']),
            self::checkbox(
                'use_pagination',
                Travelpayouts::__('Paginate'),
                '',
                true
            ),
            self::simple_text_slider(
                'pagination_size',
                Travelpayouts::__('Rows per page'),
                '10',
                '1',
                '100'
            ),
        ];

        return array_merge(
            $base,
            $additional,
            [self::accordion_end()]
        );
    }

    public static function get_images_select($id, $title, $subtitle, $options, $default, $height = 250)
    {
        $img_options = [];
        foreach ($options as $key => $option) {
            $img_options[$key] = [
                'alt' => $option,
                'img' => self::get_image_url('admin/tables/flights/themes/' . $key . '.png'),
            ];
        }
        return [
            'id' => $id,
            'type' => 'image_select',
            'title' => $title,
            'height' => $height,
            'subtitle' => $subtitle,
            'options' => $img_options,
            'default' => $default,
        ];
    }

    public static function widget_preview($prefix, $type, $src, $attributes = [])
    {
        // Отключение widget_preview в настройках
        if (!TRAVELPAYOUTS_WIDGETS_PREVIEW) {
            return [];
        }

        $allowedTypes = [
            self::WIDGET_PREVIEW_TYPE_IFRAME,
            self::WIDGET_PREVIEW_TYPE_SCRIPT,
        ];

        if (!in_array($type, $allowedTypes))
            throw new Exception('Allowed types for widget_preview is ' . implode(',', $allowedTypes));
        $baseAttributes = [
            'src' => self::prepareWidgetSrc($src),
            'scrolling' => 'no',
            'frameborder' => 0,
        ];


        return [
            'id' => self::get_ID($prefix, 'widget-preview'),
            'type' => 'travelpayouts_widget_preview',
            'fieldsPrefix' => $prefix,
            'element' => $type,
            'full_width' => true,
            'attributes' => array_merge($baseAttributes, $attributes),
        ];
    }

    /**
     * @param $src
     * @return string
     */
    private static function prepareWidgetSrc($src)
    {
        $locale = LanguageHelper::tableLocale();
        $currency = Travelpayouts::getInstance()->settings->data->get(
            'currency',
            ReduxOptions::getDefaultCurrencyCode()
        );

        return str_replace(
            [
                '{locale}',
                '{currency}',
                '{scripts_locale}'
            ],
            [
                $locale,
                strtolower($currency),
                $locale == LanguageHelper::DASHBOARD_RUSSIAN ? 'scripts' : 'scripts_' . $locale
            ],
            $src
        );
    }

    public static function error_message($id_required, $default)
    {
        return [
            'id' => 'table_message_error',
            'type' => 'textarea',
            'title' => Travelpayouts::__('Error message'),
            'subtitle' => '',
            'default' => $default,
            'rows' => 6,
            'required' => [
                $id_required,
                'equals',
                ReduxOptions::SHOW_MESSAGE,
            ],
        ];
    }

    public static function search_form_select($id_required, $id)
    {
        $formsModel = new SearchForm();
        $options = $formsModel->getFormsSelect();
        $default = ArrayHelper::getFirstKey($options);

        return [
            'id' => $id,
            'type' => 'select',
            'title' => Travelpayouts::__('Select search form'),
            'subtitle' => '',
            'desc' => '',
            'options' => $options,
            'default' => $default,
            'select2' => self::select2Options(),
            'required' => [
                $id_required,
                'equals',
                ReduxOptions::SHOW_SEARCH_FROM,
            ],
        ];
    }

    public static function select2Options()
    {
        return [
            'theme' => 'travelpayouts',
            'allowClear' => false,
            'minimumResultsForSearch' => 10,
        ];
    }

    /**
     * Добавляет дефолтное значение для sorter columns
     *
     * @param $prefix
     * @param $options
     * @return array
     */
    public static function sorterColumnsDefault($prefix, $options)
    {
        Travelpayouts::getInstance()->redux->setOption(
            $prefix . '_columns',
            $options
        );

        return $options['enabled'];
    }

    public static function pre($content)
    {
        return HtmlHelper::tag('span', ['class' => 'modifiers--m-right--big  modifiers--round typography--pre'], $content);
    }

    public static function poweredBy($default = true)
    {
        return self::checkbox('powered_by', Travelpayouts::__('Add referral link (Powered by Travelpayouts)'), '', $default);
    }
}
