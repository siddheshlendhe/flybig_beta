<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\validators;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Travelpayouts\components\Model;

class ValidatorRule
{
    public $message;
    public $attributes;
    public $params;
    /**
     * @var callable a PHP callable that replaces the default implementation of [[isEmpty()]].
     * If not set, [[isEmpty()]] will be used to check if a value is empty. The signature
     * of the callable should be `function ($value)` which returns a boolean indicating
     * whether the value is empty.
     */
    public $isEmpty;

    /**
     * @var bool whether this validation rule should be skipped if the attribute being validated
     * already has some validation error according to some previous rules. Defaults to true.
     */
    public $skipOnError = true;
    /**
     * @var bool whether this validation rule should be skipped if the attribute value
     * is null or an empty string.
     */
    public $skipOnEmpty = true;

    /**
     * @var array|string scenarios that the validator can be applied to. For multiple scenarios,
     * please specify them as an array; for single scenario, you may use either a string or an array.
     */
    public $on = [];
    /**
     * @var array|string scenarios that the validator should not be applied to. For multiple scenarios,
     * please specify them as an array; for single scenario, you may use either a string or an array.
     */
    public $except = [];

    public $when;

    public function __construct($params = [])
    {
        $this->set_attributes($params);
        $this->init();
    }

    public function init()
    {

    }

    /**
     * Validates the specified object.
     * @param Model $model the data model being validated
     * @param array|null $attributes the list of attributes to be validated.
     * Note that if an attribute is not associated with the validator - it will be
     * ignored. If this parameter is null, every attribute listed in [[attributes]] will be validated.
     */
    public function validate_attributes($model, $attributes = null)
    {
        if (is_array($attributes)) {
            $newAttributes = [];
            $attributeNames = $this->get_attribute_names();
            foreach ($attributes as $attribute) {
                if (in_array($attribute, $attributeNames, true)) {
                    $newAttributes[] = $attribute;
                }
            }
            $attributes = $newAttributes;
        } else {
            $attributes = $this->get_attribute_names();
        }

        foreach ($attributes as $attribute) {
            $skip = ($this->skipOnError && $model->has_errors($attribute))
                || ($this->skipOnEmpty && $this->isEmpty($model->$attribute));
            if (!$skip) {
                if ($this->when === null || call_user_func($this->when, $model, $attribute)) {
                    $this->validate_attribute($model, $attribute);
                }
            }
        }
    }

    /**
     * Validates a single attribute.
     * Child classes must implement this method to provide the actual validation logic.
     * @param Model $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     * @throws Exception
     */
    public function validate_attribute($model, $attribute)
    {
        $result = $this->validate_value($model->$attribute);
        if (!empty($result)) {
            $this->add_error($model, $attribute, $result[0], $result[1]);
        }
    }

    protected function validate_value($value)
    {
        throw new Exception(get_class($this) . ' does not support validateValue().');
    }

    /**
     * Returns cleaned attribute names without the `!` character at the beginning.
     * @return array attribute names.
     * @since 2.0.12
     */
    public function get_attribute_names()
    {
        return array_map(function ($attribute) {
            return ltrim($attribute, '!');
        }, $this->attributes);
    }


    /**
     * Adds an error about the specified attribute to the model object.
     * This is a helper method that performs message selection and internationalization.
     * @param Model $model the data model being validated
     * @param string $attribute the attribute being validated
     * @param string $message the error message
     * @param array $params values for the placeholders in the error message
     */
    public function add_error($model, $attribute, $message, $params = [])
    {
        $params['attribute'] = $model->get_attribute_label($attribute);
        if (!isset($params['value'])) {
            $value = $model->$attribute;
            if (is_array($value)) {
                $params['value'] = 'array()';
            } elseif (is_object($value) && !method_exists($value, '__toString')) {
                $params['value'] = '(object)';
            } else {
                $params['value'] = $value;
            }
        }
        $model->add_error($attribute, $this->format_message($message, $params));
    }

    /**
     * Formats a mesage using the I18N, or simple strtr if `\Yii::$app` is not available.
     * @param string $message
     * @param array $params
     * @return string
     * @since 2.0.12
     */
    protected function format_message($message, $params)
    {
        $placeholders = [];
        foreach ((array)$params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }

        return ($placeholders === []) ? $message : strtr($message, $placeholders);
    }


    public function set_attributes($values)
    {
        $attributeNames = $this->attributes();

        $safeValues = array_filter($values, function ($key) use ($attributeNames) {
            return in_array($key, $attributeNames);
        }, ARRAY_FILTER_USE_KEY);

        foreach ($safeValues as $attributeKey => $attributeValue) {
            $this->$attributeKey = $attributeValue;
        }

        return true;
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed $value the value to be checked
     * @return bool whether the value is empty
     */
    public function isEmpty($value)
    {
        if ($this->isEmpty !== null) {
            return call_user_func($this->isEmpty, $value);
        }

        return $value === null || $value === [] || $value === '';
    }

    /**
     * Returns the list of attribute names.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * @return array list of attribute names.
     * @throws ReflectionException
     */
    public function attributes()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }


    /**
     * Returns attribute values.
     * @param array $names list of attributes whose value needs to be returned.
     * Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
     * If it is an array, only the attributes in the array will be returned.
     * @param array $except list of attributes whose value should NOT be returned.
     * @return array attribute values (name => value).
     * @throws ReflectionException
     */
    public function get_attributes($names = null, $except = [])
    {
        $values = [];
        if ($names === null) {
            $names = $this->attributes();
        }
        foreach ($names as $name) {
            $values[$name] = $this->$name;
        }
        foreach ($except as $name) {
            unset($values[$name]);
        }

        return $values;
    }

    /**
     * Returns a list of attributes this validator applies to.
     * @param array|string|null $attributes the list of attributes to be validated.
     *
     * - If this is `null`, the result will be equal to [[getAttributeNames()]].
     * - If this is a string or an array, the intersection of [[getAttributeNames()]]
     *   and the specified attributes will be returned.
     *
     * @return array list of attribute names.
     * @since 2.0.16
     */
    public function get_validation_attributes($attributes = null)
    {
        if ($attributes === null) {
            return $this->get_attribute_names();
        }

        if (is_string($attributes)) {
            $attributes = [$attributes];
        }

        $newAttributes = [];
        $attributeNames = $this->get_attribute_names();
        foreach ($attributes as $attribute) {
            if (in_array($attribute, $attributeNames, true)) {
                $newAttributes[] = $attribute;
            }
        }
        return $newAttributes;
    }

    /**
     * Returns a value indicating whether the validator is active for the given scenario and attribute.
     *
     * A validator is active if
     *
     * - the validator's `on` property is empty, or
     * - the validator's `on` property contains the specified scenario
     *
     * @param string $scenario scenario name
     * @return bool whether the validator applies to the specified scenario.
     */
    public function is_active($scenario)
    {
        return !in_array($scenario, $this->except, true) && (empty($this->on) || in_array($scenario, $this->on, true));
    }
}
