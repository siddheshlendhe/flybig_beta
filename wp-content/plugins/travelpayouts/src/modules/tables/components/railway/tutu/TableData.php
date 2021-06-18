<?php

namespace Travelpayouts\modules\tables\components\railway\tutu;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\modules\tables\components\api\travelpayouts\TrainsSuggestApiModel;
use Travelpayouts\modules\tables\components\railway\BaseTableData;

class TableData extends BaseTableData
{
    protected function api_attributes()
    {
        return [
            'origin' => $this->shortcode_attributes->get('origin'),
            'destination' => $this->shortcode_attributes->get('destination'),
        ];
    }

    protected function columnsPriority()
    {
        return [
            'train' => 13,
            'route' => 11,
            'departure' => 10,
            'arrival' => 9,
            'duration' => 8,
            'prices' => 12,
            // dates имеет найвысший приоритет отображения, является action column (кнопкой)
            'dates' => self::MAX_PRIORITY,
            'origin' => 6,
            'destination' => 5,
            'departure_time' => 4,
            'arrival_time' => 3,
            'route_first_station' => 2,
            'route_last_station' => self::MIN_PRIORITY,
        ];
    }

    /**
     * @Inject
     * @param TrainsSuggestApiModel $value
     */
    public function setApi($value)
    {
        $this->api = $value;
    }

    /**
     * @Inject
     * @param Section $value
     */
    public function setSection($value)
    {
        $this->section = $value;
    }

    /**
     * @param $data
     * @return array
     */
    public function filterEnrichedByTrainNumber($data)
    {
        $attribute = $this->shortcode_attributes->get('filter_train_number');
        if (empty($attribute)) {
            return $data;
        }
        $trainFilters = explode(',', $attribute);
        $trainFilters = array_map('trim', $trainFilters);
        if (!empty($trainFilters)) {
            $dataFiltered = array_filter($data, function ($value) use ($trainFilters) {
                $matchTrainByNumber = isset($value['trainNumber']) && in_array($value['trainNumber'], $trainFilters);
                $matchTrainByName = isset($value['name']) && in_array($value['name'], $trainFilters);
                // Оставляем если совпадает номер поезда или название
                return $matchTrainByNumber || $matchTrainByName;
            });

            if (!empty($dataFiltered)) {
                return $dataFiltered;
            }
        }

        return $data;
    }
}
