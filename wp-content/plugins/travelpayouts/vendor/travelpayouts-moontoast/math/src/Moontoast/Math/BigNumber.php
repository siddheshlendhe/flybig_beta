<?php

/**
 * This file is part of the moontoast/math library
 *
 * Copyright 2013-2020 Moontoast, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Travelpayouts\Vendor\Moontoast\Math;

/**
 * Represents a number for use with Binary Calculator computations
 *
 * @link http://www.php.net/bcmath
 */
class BigNumber extends AbstractBigNumber
{
    /**
     * Number value, as a string
     *
     * @var string
     */
    protected $numberValue;

    /**
     * The scale for the current number
     *
     * @var int
     */
    protected $numberScale;

    /**
     * Constructs a BigNumber object from a string, integer, float, or any
     * object that may be cast to a string, resulting in a numeric string value
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @param int $scale (optional) Specifies the default number of digits after the decimal
     *                   place to be used in operations for this BigNumber
     * @return void
     */
    public function __construct($number, $scale = null)
    {
        if ($scale) {
            $this->setScale($scale);
        }

        $this->setValue($number);
    }

    /**
     * Returns the string value of this BigNumber
     *
     * @return string String representation of the number in base 10
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

    /**
     * Sets the current number to the absolute value of itself
     *
     * @return BigNumber for fluent interface
     */
    public function abs()
    {
        $this->numberValue = \ltrim($this->numberValue, '-');

        return $this;
    }

    /**
     * Adds the given number to the current number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @link http://www.php.net/bcadd
     */
    public function add($number)
    {
        $this->numberValue = \bcadd(
            $this->numberValue,
            $this->filterNumber($number),
            $this->getScale()
        );

        return $this;
    }

    /**
     * Finds the next highest integer value by rounding up the current number
     * if necessary
     *
     * @return BigNumber for fluent interface
     * @link http://www.php.net/ceil
     */
    public function ceil()
    {
        $number = $this->getValue();

        if ($this->isPositive()) {
            // 14 is the magic precision number
            $number = \bcadd($number, '0', 14);
            if (\substr($number, -15) != '.00000000000000') {
                $number = \bcadd($number, '1', 0);
            }
        }

        $this->numberValue = \bcadd($number, '0', 0);

        return $this;
    }

    /**
     * Compares the current number with the given number
     *
     * Returns 0 if the two operands are equal, 1 if the current number is
     * larger than the given number, -1 otherwise.
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return int
     * @link http://www.php.net/bccomp
     */
    public function compareTo($number)
    {
        $number = $this->filterNumber($number);
        // http://bugs.php.net/46781 changed how bcmath compares minus zero. for BC purposes we emulate the old
        // behavior, prior to the bug fix
        if (preg_match('#^-?0\.0+?$#', $this->numberValue) || preg_match('#^-?0\.0+?$#', $number)) {
            if ($this->numberValue[0] === $number[0]) {
                return 0;
            }
            return $this->numberValue[0] === '-' ? -1 : 1;
        }
        return bccomp(
            $this->numberValue,
            $number,
            $this->getScale()
        );
    }

    /**
     * Returns the current value converted to an arbitrary base
     *
     * @param int $base The base to convert the current number to
     * @return string String representation of the number in the given base
     */
    public function convertToBase($base)
    {
        return self::convertFromBase10($this->getValue(), $base);
    }

    /**
     * Decreases the value of the current number by one
     *
     * @return BigNumber for fluent interface
     */
    public function decrement()
    {
        return $this->subtract(1);
    }

    /**
     * Divides the current number by the given number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @throws Exception\ArithmeticException if $number is zero
     * @link http://www.php.net/bcdiv
     */
    public function divide($number)
    {
        $number = $this->filterNumber($number);

        if ($number == '0') {
            throw new Exception\ArithmeticException('Division by zero');
        }

        $this->numberValue = \bcdiv(
            $this->numberValue,
            $number,
            $this->getScale()
        );

        return $this;
    }

    /**
     * Finds the next lowest integer value by rounding down the current number
     * if necessary
     *
     * @return BigNumber for fluent interface
     * @link http://www.php.net/floor
     */
    public function floor()
    {
        $number = $this->getValue();

        if ($this->isNegative()) {
            // 14 is the magic precision number
            $number = \bcadd($number, '0', 14);
            if (\substr($number, -15) != '.00000000000000') {
                $number = \bcsub($number, '1', 0);
            }
        }

        $this->numberValue = \bcadd($number, '0', 0);

        return $this;
    }

    /**
     * Returns the scale used for this BigNumber
     *
     * If no scale was set, this will default to the value of bcmath.scale
     * in php.ini.
     *
     * @return int
     */
    public function getScale()
    {
        if ($this->numberScale === null) {
            if (version_compare(PHP_VERSION, '7.3.0') >= 0 || !extension_loaded('bcmath')) {
                // @codeCoverageIgnoreStart
                return (string) bcscale();
                // @codeCoverageIgnoreEnd
            }
            return (string) max(0, strlen(bcadd('0', '0')) - 2);
        }
        return $this->numberScale;
    }

    /**
     * Returns the current raw value of this BigNumber
     *
     * @return string String representation of the number in base 10
     */
    public function getValue()
    {
        return $this->numberValue;
    }

    /**
     * Increases the value of the current number by one
     *
     * @return BigNumber for fluent interface
     */
    public function increment()
    {
        return $this->add(1);
    }

    /**
     * Finds the modulus of the current number divided by the given number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @throws Exception\ArithmeticException if $number is zero
     * @link http://www.php.net/bcmod
     */
    public function mod($number)
    {
        $number = $this->filterNumber($number);

        if ($number == '0') {
            throw new Exception\ArithmeticException('Division by zero');
        }

        $this->numberValue = \bcmod(
            $this->numberValue,
            $number
        );

        return $this;
    }

    /**
     * Multiplies the current number by the given number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @link http://www.php.net/bcmul
     */
    public function multiply($number)
    {
        $this->numberValue = \bcmul(
            $this->numberValue,
            $this->filterNumber($number),
            $this->getScale()
        );

        return $this;
    }

    /**
     * Sets the current number to the negative value of itself
     *
     * @return BigNumber for fluent interface
     */
    public function negate()
    {
        return $this->multiply(-1);
    }

    /**
     * Raises current number to the given number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @link http://www.php.net/bcpow
     */
    public function pow($number)
    {
        $this->numberValue = \bcpow(
            $this->numberValue,
            $this->filterNumber($number),
            $this->getScale()
        );

        return $this;
    }

    /**
     * Raises the current number to the $pow, then divides by the $mod
     * to find the modulus
     *
     * This is functionally equivalent to the following code:
     *
     * <code>
     *     $n = new BigNumber(1234);
     *     $n->mod($n->pow(32), 2);
     * </code>
     *
     * However, it uses bcpowmod(), so it is faster and can accept larger
     * parameters.
     *
     * @param mixed $pow May be of any type that can be cast to a string
     *                   representation of a base 10 number
     * @param mixed $mod May be of any type that can be cast to a string
     *                   representation of a base 10 number
     * @return BigNumber for fluent interface
     * @throws Exception\ArithmeticException if $number is zero
     * @link http://www.php.net/bcpowmod
     */
    public function powMod($pow, $mod)
    {
        $mod = $this->filterNumber($mod);

        if ($mod == '0') {
            throw new Exception\ArithmeticException('Division by zero');
        }

        $this->numberValue = \bcpowmod(
            $this->numberValue,
            $this->filterNumber($pow),
            $mod,
            $this->getScale()
        );

        return $this;
    }

    /**
     * Rounds the current number to the nearest integer
     *
     * @return BigNumber for fluent interface
     * @todo Implement precision digits
     */
    public function round()
    {
        $original = $this->getValue();
        $floored = $this->floor()->getValue();
        $diff = \bcsub($original, $floored, 20);

        if ($this->isNegative()) {
            $roundedDiff = \round($diff, 0, PHP_ROUND_HALF_DOWN);
        } else {
            $roundedDiff = \round($diff);
        }

        $this->numberValue = \bcadd(
            $floored,
            $roundedDiff,
            0
        );

        return $this;
    }

    /**
     * Sets the scale of this BigNumber
     *
     * @param int $scale Specifies the default number of digits after the decimal
     *                   place to be used in operations for this BigNumber
     * @return BigNumber for fluent interface
     */
    public function setScale($scale)
    {
        $this->numberScale = (int) $scale;

        return $this;
    }

    /**
     * Sets the value of this BigNumber to a new value
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     */
    public function setValue($number)
    {
        // Set the scale for the number to the scale value passed in
        $number = \bcadd(
            $this->filterNumber($number),
            '0',
            $this->getScale()
        );

        $this->numberValue = $number;

        return $this;
    }

    /**
     * Shifts the current number $bits to the left
     *
     * @param int $bits
     * @return BigNumber for fluent interface
     */
    public function shiftLeft($bits)
    {
        $this->numberValue = \bcmul(
            $this->numberValue,
            \bcpow('2', $bits)
        );

        return $this;
    }

    /**
     * Shifts the current number $bits to the right
     *
     * @param int $bits
     * @return BigNumber for fluent interface
     */
    public function shiftRight($bits)
    {
        $this->numberValue = \bcdiv(
            $this->numberValue,
            \bcpow('2', $bits)
        );

        return $this;
    }

    /**
     * Finds the square root of the current number
     *
     * @return BigNumber for fluent interface
     * @link http://www.php.net/bcsqrt
     */
    public function sqrt()
    {
        $this->numberValue = \bcsqrt(
            $this->numberValue,
            $this->getScale()
        );

        return $this;
    }

    /**
     * Subtracts the given number from the current number
     *
     * @param mixed $number May be of any type that can be cast to a string
     *                      representation of a base 10 number
     * @return BigNumber for fluent interface
     * @link http://www.php.net/bcsub
     */
    public function subtract($number)
    {
        $this->numberValue = \bcsub(
            $this->numberValue,
            $this->filterNumber($number),
            $this->getScale()
        );

        return $this;
    }

    /**
     * Filters a number, converting it to a string value
     *
     * @param mixed $number
     * @return string
     */
    protected function filterNumber($number)
    {
        return \filter_var(
            $number,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );
    }
}
