<?php

namespace Travelpayouts\modules\links;

use Travelpayouts;
use Travelpayouts\components\ErrorHelper;
use Travelpayouts\components\links\LinkFlightsModel;
use Travelpayouts\components\links\LinkHotelsModel;
use Travelpayouts\components\links\LinkModel;
use Travelpayouts\components\shortcodes\ShortcodeModel;

/**
 * Class Link
 * @package Travelpayouts\src\modules\links
 */
class Link extends ShortcodeModel
{
    /**
     * Получение класса в зависимости от атрибута type
     * @param $attributes
     * @return LinkModel
     */
    private static function get_link_model($attributes)
    {
        if (isset($attributes['type'])) {
            $type = $attributes['type'];
        } else {
            return null;
        }

        switch ($type) {
            case LinkModel::TYPE_FLIGHTS:
                $model = new LinkFlightsModel();
                break;
            case LinkModel::TYPE_HOTELS:
                $model = new LinkHotelsModel();
                break;
            default:
                return null;
        }

        return $model;
    }

    /**
     * @inheritDoc
     */
    public static function shortcodeTags()
    {
        return [
            'tp_link',
            'tp_link_test',
        ];
    }

    public function render()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritDoc
     */
    public static function render_shortcode_static($attributes = [], $content = null, $tag = '')
    {
        $model = self::get_link_model($attributes);
        if ($model === null) {
            return ErrorHelper::render_errors($tag,
                [
                    'type' => [Travelpayouts::__('Please select valid link type')],
                ]
            );
        }
        $model->attributes = $attributes;
        $model->shortcode_name = $tag;

        return $model->render();
    }
}
