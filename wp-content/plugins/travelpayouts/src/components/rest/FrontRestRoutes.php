<?php

namespace Travelpayouts\components\rest;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\BaseInjectedObject;

class FrontRestRoutes extends BaseInjectedObject
{
    const ROUTE_TYPE = 'front';
    public $namespace;
    public $currentUser;

    /**
     * @Inject
     * @var FrontApiModel
     */
    public $frontApiModel;

    /**
     * @param string $value
     * @Inject({"name"})
     */
    public function setPluginName($value)
    {
        $this->namespace = $value . '/' . self::ROUTE_TYPE;
    }

    public function setUpHooks()
    {
        /** @see FrontRestRoutes::travelpayoutsRegisterRoute() */
        Travelpayouts::getInstance()->hooksLoader->add_action('rest_api_init', $this, 'travelpayoutsRegisterRoute');
    }

    public function travelpayoutsRegisterRoute()
    {
        $this->currentUser = wp_get_current_user();
        $this->registerHomeRoute();
        $this->registerModuleRoutes();
    }

    protected function registerModuleRoutes()
    {
        foreach ($this->frontApiModel->getRestModules() as $module) {
            foreach ($module->routeList as $route) {
                register_rest_route(
                    $this->namespace,
                    $route->path,
                    $route->options
                );
            }
        }
    }

    /**
     * @return bool
     */
    public function getPermissionsCheck()
    {
        return !TRAVELPAYOUTS_DEBUG
            ? user_can($this->currentUser, 'publish_posts')
            : true;
    }

    public function homeRoute()
    {
        return rest_ensure_response($this->frontApiModel->renderHome());
    }

    private function registerHomeRoute()
    {
        register_rest_route($this->namespace, 'home', [
            'methods' => 'GET',
            'callback' => [
                $this,
                'homeRoute',
            ],
            'permission_callback' => [
                $this,
                'getPermissionsCheck',
            ],
        ]);
    }
}
