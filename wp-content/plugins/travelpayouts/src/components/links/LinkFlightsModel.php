<?php

namespace Travelpayouts\components\links;
use Travelpayouts\Vendor\Adbar\Dot;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\LanguageHelper;
use Travelpayouts\components\tables\enrichment\UrlHelper;

/**
 * Class LinkFlightsModel
 */
class LinkFlightsModel extends LinkModel
{
    const ORIGIN_DEFAULT_DATE = 1;

    public $origin;
    public $destination;
    public $one_way;
    public $origin_date;
    public $destination_date;
    public $subid;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['origin', 'destination', 'origin_date'], 'required'],
            [['origin', 'destination'], 'string', 'length' => 3],
            [['one_way', 'origin_date', 'destination_date', 'subid'], 'safe'],
        ]);
    }

    /**
     * Формирования урл для авиа из параметров шорткода link
     * @return string
     */
    protected function get_url()
    {
        if (empty($this->origin_date)) {
            $this->origin_date = self::ORIGIN_DEFAULT_DATE;
        }
        $departDate = $this->date_time_add_days($this->origin_date);

        $returnDate = null;
        if (!empty($this->destination_date)) {
            $returnDate = $this->date_time_add_days($this->destination_date);
        }

        $marker = UrlHelper::get_marker(
            $this->accountModule->marker,
            $this->subid,
            self::LINK_MARKER
        );

        $flightSource = $this->settingsModule->data->get(
            LanguageHelper::optionWithLanguage('flights_source'),
            ReduxOptions::FLIGHTS_SOURCE_AVIASALES_RU
        );

        $params = array_filter([
            'origin_iata' => $this->origin,
            'destination_iata' => $this->destination,
            'currency' => $this->settingsModule->currency,
            'locale' => $this->settingsModule->language,
            'depart_date' => $departDate,
            'return_date' => $returnDate,
            'with_request' => $this->settingsModule->data->get('flights_after_url') === 'results'
                ? 'true' : null,
            'one_way' => true === filter_var(
                $this->one_way,
                FILTER_VALIDATE_BOOLEAN
            ) ? 'true' : null,
        ]);

        $rawHost = !empty($this->accountModule->whiteLabelFlights)
            ? $this->accountModule->whiteLabelFlights
            : $this->getDefaultHost($flightSource);

        return UrlHelper::buildMediaUrl([
            'p' => UrlHelper::LINKS_P,
            'marker' => $marker,
            'u' => UrlHelper::buildUrl($rawHost, $params),
        ]);
    }

    /**
     * @param $sourceCode
     * @return string|null
     */
    private function getDefaultHost($sourceCode)
    {
        $flightsSources = ReduxOptions::flight_sources();

        return isset($flightsSources[$sourceCode])
            ? $flightsSources[$sourceCode]
            : null;
    }
}
