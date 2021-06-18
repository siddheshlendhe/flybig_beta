<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\validators;

use Exception;
use Travelpayouts\components\Component;

class Validator extends Component
{
    protected static $validators = [
        'required' => 'ValidatorRequired',
        'safe' => 'ValidatorSafe',
        'string' => 'ValidatorString',
        'boolean' => 'ValidatorBoolean',
        'number' => 'NumberValidator',
        'each' => 'ValidatorEach',
    ];

    public static function createValidator($type, $model, $attributes, $params = [])
    {
        $params['attributes'] = $attributes;
        if (!isset(static::$validators[$type]) && method_exists($model, $type)) {
            $params['class'] = __NAMESPACE__ . '\ValidatorInline';
            $params['method'] = $type;
        }

        if (array_key_exists($type, static::$validators)) {
            $params['class'] = __NAMESPACE__ . '\\' . static::$validators[$type];
        }
        if (isset($params['class'])) {
            return new $params['class']($params);
        }
        throw new Exception('Can\'t find validator class');
    }
}
