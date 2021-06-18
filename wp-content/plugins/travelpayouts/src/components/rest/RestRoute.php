<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\rest;


use Travelpayouts\components\BaseObject;

/**
 * Class RestRoute
 * @package Travelpayouts\components\rest
 * @property-read string $path
 * @property-read array $options
 */
class RestRoute extends BaseObject
{
    /**
     * @var string
     */
    protected $method = 'POST';
    /**
     * @var \Closure
     */
    protected $callback;
    /**
     * @var array
     */
    protected $args;

    /**
     * @var \Closure
     */
    protected $permission_callback;

    /**
     * @var string[]
     */
    private $routeParts = [];

    /**
     * @param $value
     */
    public function addRoutePart($value)
    {
        $this->routeParts = array_merge([$value], $this->routeParts);
    }

    public function getPath()
    {
        return implode('/', $this->routeParts);
    }

    /**
     * Список $args для register_rest_route
     * @return array
     * @see register_rest_route()
     */
    public function getOptions()
    {
        return array_filter([
            'methods' => $this->method,
            'callback' => $this->callback,
            'permission_callback' => $this->permission_callback,
            'args' => $this->args,
        ]);
    }
}
