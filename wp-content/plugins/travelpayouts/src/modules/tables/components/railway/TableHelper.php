<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\railway;

use  Travelpayouts\components\tables\enrichment as Enrichment;

class TableHelper extends Enrichment\BaseTableHelper
{
    public function get_origin()
    {
        $value = $this->table_data->shortcode_attributes->get('origin', '');
        return $this->dictionary_railways->getItem($value)->getName();
    }

    public function get_destination()
    {
        $value = $this->table_data->shortcode_attributes->get('destination', '');
        return $this->dictionary_railways->getItem($value)->getName();
    }
}
