<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;

use Travelpayouts;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\tables\enrichment as Enrichment;
use Travelpayouts\modules\tables\components\api\travelpayouts\CitySuggestApiModel;

class HotelsTableHelper extends Enrichment\BaseTableHelper
{
    protected $title_prefix = 'hotel.title';

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

    public function get_location()
    {
        $cityId = $this->table_data->shortcode_attributes->get('city');
        $cityModel = $this->getCityByTerm($cityId);
        return $cityModel
            ? $cityModel->cityName
            : $this->table_data->shortcode_attributes->get('city_label', '');
    }

    public function get_city()
    {
        return $this->location;
    }

    public function get_dates()
    {
        $dates = [
            $this->check_in,
            $this->check_out,
            '',
        ];

        return !in_array('', $dates, true)
            ? implode(' - ', $dates)
            : '';
    }

    /**
     * Возможно нужно будет форматировать дату
     * @return mixed
     */
    public function get_check_in()
    {
        return $this->table_data->shortcode_attributes->get('check_in', '');
    }

    public function get_check_out()
    {
        return $this->table_data->shortcode_attributes->get('check_out', '');
    }

    public function get_selection_name()
    {
        $label = $this->table_data->shortcode_attributes->get('type_selections_label');
        if (empty($label)) {
            $typeSelection = $this->table_data->shortcode_attributes->get('type_selections');

            return $this->findTranslationOrReturnInput($typeSelection, 'hotel.selections', 'tables');
        }

        return $label;
    }

    public function get_selection()
    {
        return $this->selection_name;
    }


    public function get_selection_type()
    {
        return $this->selection_name;
    }

    /**
     * @param string $term
     * @return Travelpayouts\modules\tables\components\api\travelpayouts\citySuggest\CitySuggestItem|null
     */
    protected function getCityByTerm($term)
    {
        $model = new CitySuggestApiModel;
        $model->attributes = [
            'term' => $term,
            'locale' => LanguageHelper::tableLocale(),
        ];
        $model->sendRequest();
        return $model->getFirstRecord();
    }
}
