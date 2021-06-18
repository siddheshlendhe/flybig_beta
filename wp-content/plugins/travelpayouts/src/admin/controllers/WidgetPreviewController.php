<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\controllers;

use Travelpayouts;
use Travelpayouts\components\Component;
use Travelpayouts\components\HtmlHelper;

/**
 * Class WidgetPreviewController
 * @package Travelpayouts\src\admin\controllers
 * @property-read string $scriptUrl
 */
class WidgetPreviewController extends Component
{
    const TYPE_SCRIPT = 0;
    const TYPE_IFRAME = 1;

    private static $instance;

    /**
     * @return WidgetPreviewController
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public function run()
    {
        $typeParam = isset($_GET['type'])
            ? (int)$_GET['type']
            : self::TYPE_SCRIPT;
        $type = $typeParam > 0 ? self::TYPE_IFRAME : self::TYPE_SCRIPT;
        $scriptUrl = $this->getScriptUrl();
        if ($scriptUrl) {
            echo Travelpayouts::getInstance()->template->render('admin::widgetPreview', ['src' => $scriptUrl,'type'=>$type]);
        }
        wp_die();
    }

    public function getScriptUrl()
    {
        $script = isset($_GET['externalUrl'])
            ? $_GET['externalUrl']
            : false;
        return $script
            ? base64_decode($script)
            : null;
    }
}
