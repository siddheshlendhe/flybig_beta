<?php

namespace Travelpayouts\components\rest;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts;
use Travelpayouts\components\Model;
use Travelpayouts\components\shortcodes\ShortcodeFactory;
use WP_Error;
use WP_REST_Response;

/**
 * Class FrontModel
 * @package Travelpayouts\components\rest
 */
abstract class FrontModel extends Model
{
    public $current_table;
    /**
     * @var Dot
     */
    protected $data;

    public function rules()
    {
        return [
            [
                ['current_table'],
                'required',
            ],
            [
                [
                    'data',
                    'campaign',
                ],
                'safe',
            ],
        ];
    }

    abstract protected function getFields();

    /**
     * @param array $data
     * @return mixed|WP_REST_Response
     */
    protected function response($data)
    {
        return rest_ensure_response($data);
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed|null
     */
    protected function getValue($key, $default = '')
    {
        if (!$this->data) {
            return null;
        }

        $value = $this->data->get($key, $default);
        // width и height параметры в redux сохраняются так - 500px,
        // а должны быть integer для поля input-number
        if (preg_match('/.*\.(width|height)/', $key)) {
            return (int)$value;
        }

        return $value;
    }

    /**
     * @param $defaults
     * @param $params
     * @return array
     */
    protected function getShortcodeAttributes($defaults, $params)
    {
        $defaultAttributes = [];
        $attributes = [];

        /**
         * Есть radio button с опциями он такой 1 (было принято костыльное решение)
         * из getFrontData получаем опции и их дефолтные значения
         * если есть метод getRadioOptionsFieldName получаем в зависимости от того какая опция выбрана поля
         * то есть если выбран false берем те поля которые доступны в варианте false если true - другие поля
         */
        if (method_exists($this, 'getRadioOptionsFieldName')) {
            $optionName = $this->getRadioOptionsFieldName();

            if (isset($defaults[$optionName]['options'][$params[$optionName]]['values'])) {
                foreach ($defaults[$optionName]['options'][$params[$optionName]]['values'] as $optionFields) {
                    $defaults = array_merge($defaults, $optionFields);
                }
            }
        }

        foreach ($defaults as $key => $value) {
            if (isset($value['default']) && isset($value['type'])) {
                $defaultAttributes[$key] = [
                    'default' => $value['default'],
                    'type' => $value['type'],
                ];
            }
        }

        foreach ($params as $key => $value) {
            if (isset($defaultAttributes[$key]) && $value !== '') {
                $attributes[$key] = $value;
            }
        }

        if (method_exists($this, 'getDefaultAttributes')) {
            $attributes = array_merge($this->getDefaultAttributes(), $attributes);
        }

        return $attributes;
    }

    /**
     * @return WP_Error
     */
    public function validationError()
    {
        $errors = array_merge(
            [
                'status' => 400,
            ],
            $this->getErrors()
        );

        return new WP_Error(
            'rest_model_validation_error',
            Travelpayouts::__('Validation failed'),
            $errors
        );
    }

    /**
     * @return array
     */
    public function args()
    {
        if (method_exists($this, 'get')) {
            $args = [];
            $fields = $this->get();
            if (!empty($fields->data)) {
                foreach ($fields->data as $key => $value) {
                    $argsArray = [];
                    if (isset($value['required'])) {
                        $argsArray['required'] = $value['required'];
                    } else {
                        $argsArray['required'] = false;
                    }

                    if (isset($value['default'])) {
                        $argsArray['default'] = $value['default'];
                    }

                    if (isset($value['type']) && FrontFields::isArg($value['type'])) {
                        $args[$key] = $argsArray;
                    }
                }
            }

            return $args;
        }
    }

    /**
     * Отдаем название шорткода
     * @return string
     */
    abstract public function shortcodeName();

    public function extraData()
    {
        return [];
    }

    /**
     * @return mixed|WP_REST_Response
     */
    public function get()
    {
        return $this->response([
            'fields' => $this->getFields(),
            'name' => $this->shortcodeName(),
            'extraData' => $this->extraData(),
        ]);
    }

    /**
     * @param \WP_REST_Request $request
     * @return mixed|WP_Error|WP_REST_Response
     * @throws \Exception
     */
    public function post($request)
    {
        $requestParams = $request->get_params();

        $this->attributes = $requestParams;
        if (!$this->validate()) {
            return $this->validationError();
        }


        $shortcodeAttributes = $this->getShortcodeAttributes(
            $this->getFields(),
            $requestParams
        );

        $shortcode = ShortcodeFactory::getShortcode($this->current_table, $shortcodeAttributes);

        return $this->response([
            'id' => $this->current_table,
            'parameters' => $shortcodeAttributes,
            'shortcode' => $shortcode->generate(),
        ]);
    }

    /**
     * Проверка дополнительного условия для отображения
     * Если метода нет вернет true
     *
     * @return bool
     */
    public static function isValid()
    {
        return true;
    }

    /**
     * Доступна ли модель шорткода в rest
     * @return bool
     */
    public static function isActive()
    {
        return !TRAVELPAYOUTS_DEBUG
            ? Travelpayouts::getInstance()->currentUserCan('publish_posts') && static::isValid()
            : true;
    }

    abstract public function setData($value);
}
