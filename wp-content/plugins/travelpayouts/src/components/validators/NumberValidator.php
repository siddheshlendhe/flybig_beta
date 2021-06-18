<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Travelpayouts\components\validators;

/**
 * NumberValidator validates that the attribute value is a number.
 * The format of the number must match the regular expression specified in [[integerPattern]] or [[numberPattern]].
 * Optionally, you may configure the [[max]] and [[min]] properties to ensure the number
 * is within certain range.
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NumberValidator extends ValidatorRule
{
    /**
     * @var bool whether the attribute value can only be an integer. Defaults to false.
     */
    public $integerOnly = false;
    /**
     * @var int|float upper limit of the number. Defaults to null, meaning no upper limit.
     * @see tooBig for the customized message used when the number is too big.
     */
    public $max;
    /**
     * @var int|float lower limit of the number. Defaults to null, meaning no lower limit.
     * @see tooSmall for the customized message used when the number is too small.
     */
    public $min;
    /**
     * @var string user-defined error message used when the value is bigger than [[max]].
     */
    public $tooBig;
    /**
     * @var string user-defined error message used when the value is smaller than [[min]].
     */
    public $tooSmall;
    /**
     * @var string the regular expression for matching integers.
     */
    public $integerPattern = '/^\s*[+-]?\d+\s*$/';
    /**
     * @var string the regular expression for matching numbers. It defaults to a pattern
     * that matches floating numbers with optional exponential part (e.g. -1.23e-10).
     */
    public $numberPattern = '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/';


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = $this->integerOnly ? '{attribute} must be an integer.'
                : '{attribute} must be a number.';
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = '{attribute} must be no less than {min}.';
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = '{attribute} must be no greater than {max}.';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate_attribute($model, $attribute)
    {
        $value = $model->$attribute;
        if ($this->is_not_number($value)) {
            $this->add_error($model, $attribute, $this->message);
            return;
        }
        $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;

        if (!preg_match($pattern, $this->normalize_number($value))) {
            $this->add_error($model, $attribute, $this->message);
        }
        if ($this->min !== null && $value < $this->min) {
            $this->add_error($model, $attribute, $this->tooSmall, ['min' => $this->min]);
        }
        if ($this->max !== null && $value > $this->max) {
            $this->add_error($model, $attribute, $this->tooBig, ['max' => $this->max]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validate_value($value)
    {
        if ($this->is_not_number($value)) {
            return ['{attribute} is invalid.', []];
        }
        $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;
        if (!preg_match($pattern, $this->normalize_number($value))) {
            return [$this->message, []];
        } elseif ($this->min !== null && $value < $this->min) {
            return [$this->tooSmall, ['min' => $this->min]];
        } elseif ($this->max !== null && $value > $this->max) {
            return [$this->tooBig, ['max' => $this->max]];
        }

        return null;
    }

    /*
     * @param mixed $value the data value to be checked.
     */
    private function is_not_number($value)
    {
        return is_array($value)
            || is_bool($value)
            || (is_object($value) && !method_exists($value, '__toString'))
            || (!is_object($value) && !is_scalar($value) && $value !== null);
    }


    /**
     * Returns string representation of number value with replaced commas to dots, if decimal point
     * of current locale is comma.
     * @param int|float|string $value
     * @return string
     * @since 2.0.11
     */
    public function normalize_number($value)
    {
        $value = (string)$value;

        $localeInfo = localeconv();
        $decimalSeparator = isset($localeInfo['decimal_point']) ? $localeInfo['decimal_point'] : null;

        if ($decimalSeparator !== null && $decimalSeparator !== '.') {
            $value = str_replace($decimalSeparator, '.', $value);
        }

        return $value;
    }
}
