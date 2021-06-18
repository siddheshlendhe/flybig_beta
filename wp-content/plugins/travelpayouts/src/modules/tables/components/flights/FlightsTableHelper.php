<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights;

use Travelpayouts\components\tables\enrichment as Enrichment;

class FlightsTableHelper extends Enrichment\BaseTableHelper
{
    protected $title_prefix = 'flights.title';

    public function get_origin()
    {
        $case = $this->get_route_name_case('origin');

        $value = $this->table_data->shortcode_attributes->get('origin', '');
        return $this->dictionary_cities->getItem($value)->getName($case);
    }

    public function get_destination()
    {
        $case = $this->get_route_name_case('destination');
        $value = $this->table_data->shortcode_attributes->get('destination', '');
        return $this->dictionary_cities->getItem($value)->getName($case);
    }

    public function get_airline()
    {
        $value = $this->table_data->shortcode_attributes->get('airline', '');
        return $this->dictionary_airlines->getItem($value)->getName();
    }
}
