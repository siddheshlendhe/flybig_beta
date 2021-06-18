<?php

namespace Travelpayouts\modules\tables\components\flights;

/**
 * Trait FlightsFilterLimit
 * @package Travelpayouts\src\modules\tables\components\flights
 */
trait FlightsFilterLimitTrait
{
    protected function filterEnrichedByLimit($data)
    {
        $limit = $this->shortcode_attributes->get('limit', 10);

        if(count($data) >= $limit) {
            $data = array_slice($data, 0, $limit);
        }

        return $data;
    }
}
