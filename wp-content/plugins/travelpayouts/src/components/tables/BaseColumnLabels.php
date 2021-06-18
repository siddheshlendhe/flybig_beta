<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\tables;

use Travelpayouts\traits\SingletonTrait;

abstract class BaseColumnLabels
{
    use SingletonTrait;

    /**
     * Список колонок для админ части, для перевода используется gettext
     * @return array
     */
    public function columnLabels()
    {
        return [];
    }

    /**
     * @param $keysToFound
     * @return array
     */
    public function getColumnLabels($keysToFound)
    {
        $labelsList = $this->columnLabels();

        $columns = [];
        foreach ($keysToFound as $key) {
            $columns[$key] = array_key_exists($key, $labelsList) ? $labelsList[$key] : null;
        }

        return $columns;
    }
}
