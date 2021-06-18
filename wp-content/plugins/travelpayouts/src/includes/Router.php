<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\includes;

use Exception;
use Travelpayouts\Vendor\FastRoute\Dispatcher;
use Travelpayouts\Vendor\FastRoute\RouteCollector;
use Travelpayouts\components\BaseObject;
use function Travelpayouts\Vendor\FastRoute\simpleDispatcher;

class Router extends BaseObject
{
    public $actionParam = 's';
    public $routeParam = 'page';

    protected $_routes = [];

    public function init()
    {
        if ($this->actionParam) {
            /** @see Router::run() */
            add_action($this->actionParam, [
                $this,
                'run',
            ]);
        } else {
            throw new Exception('property $actionParam must be set');
        }
    }


    public function addRoute($httpMethod, $route, $callback)
    {
        $validationList = [
            is_string($httpMethod) && in_array($httpMethod, [
                'GET',
                'POST',
                'PUT',
                'PATCH',
                'DELETE',
            ]),
            is_string($route),
            is_callable($callback),
        ];

        if (!in_array(false, $validationList, true)) {
            $this->_routes[] = [
                'httpMethod' => $httpMethod,
                'route' => $route,
                'callback' => $callback,
            ];
        }
    }

    public function addRoutes($routeList)
    {
        if (is_array($routeList)) {
            foreach ($routeList as $route) {
                $this->addRoute(...$route);
            }
        }
    }

    public function run()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->_routes as $route) {
                $r->addRoute($route['httpMethod'], $route['route'], $route['callback']);
            }
        });
        if (isset($_GET[$this->routeParam])) {
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            $routeInfo = $dispatcher->dispatch($httpMethod, $_GET[$this->routeParam]);
            switch ($routeInfo[0]) {
                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $handler(...array_values($routeInfo[2]));
                    break;
            }
        }
    }
}
