<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components;

use Travelpayouts;
use Travelpayouts\components\tables\TableModel;

abstract class BaseTableShortcodeModel extends TableModel
{
    /**
     * @inheritdoc
     */
    public static function render_shortcode_static($attributes = [], $content = null, $tag = '')
    {
        $shortcodeModel = new static();
        $shortcodeModel->tag = $tag;
        $shortcodeModel->attributes = [
            'shortcodeName' => $tag,
            'linkMarker' => $shortcodeModel->linkMarker(),
            'table_wrapper_class' => $shortcodeModel->table_wrapper_class,
        ];
        $shortcodeModel->shortcode_attributes = $attributes;
        return $shortcodeModel->render();
    }
}
