<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\tables\TableDataModel;
use Travelpayouts\modules\tables\components\settings\FlightsSettingsSection;

abstract class BaseTableData extends TableDataModel
{
    /**
     * @Inject
     * @var FlightsColumnEnricher
     */
    protected $columnEnrichment;
    /**
     * @Inject
     * @var FlightsTableHelper
     */
    protected $tableHelper;
    /**
     * @Inject
     * @var FlightsSettingsSection
     */
    protected $reduxModule;
    /**
     * @Inject
     * @var FlightsTableCache
     */
    protected $tableCache;

    /**
     * @inheritdoc
     */
    public function columnsLabels($locale = null)
    {
        return [
            ColumnLabels::DEPARTURE_AT => Travelpayouts::t('flights.departure_at', [], 'tables', $locale),
            ColumnLabels::NUMBER_OF_CHANGES => Travelpayouts::t('flights.number_of_changes', [], 'tables', $locale),
            ColumnLabels::BUTTON => Travelpayouts::t('flights.button_column_title', [], 'tables', $locale),
            ColumnLabels::PRICE => Travelpayouts::t('flights.price', [], 'tables', $locale),
            ColumnLabels::TRIP_CLASS => Travelpayouts::t('flights.trip_class', [], 'tables', $locale),
            ColumnLabels::DISTANCE => Travelpayouts::t('flights.distance', [], 'tables', $locale),
            ColumnLabels::RETURN_AT => Travelpayouts::t('flights.return_at', [], 'tables', $locale),
            ColumnLabels::AIRLINE_LOGO => Travelpayouts::t('flights.airline_logo', [], 'tables', $locale),
            ColumnLabels::FLIGHT_NUMBER => Travelpayouts::t('flights.flight_number', [], 'tables', $locale),
            ColumnLabels::FLIGHT => Travelpayouts::t('flights.flight', [], 'tables', $locale),
            ColumnLabels::AIRLINE => Travelpayouts::t('flights.airline', [], 'tables', $locale),
            ColumnLabels::DESTINATION => Travelpayouts::t('flights.destination', [], 'tables', $locale),
            ColumnLabels::ORIGIN_DESTINATION => Travelpayouts::t('flights.origin_destination', [], 'tables', $locale),
            ColumnLabels::PLACE => Travelpayouts::t('flights.place', [], 'tables', $locale),
            ColumnLabels::DIRECTION => Travelpayouts::t('flights.direction', [], 'tables', $locale),
            ColumnLabels::ORIGIN => Travelpayouts::t('flights.origin', [], 'tables', $locale),
            ColumnLabels::FOUND_AT => Travelpayouts::t('flights.found_at', [], 'tables', $locale),
            ColumnLabels::PRICE_DISTANCE => Travelpayouts::t('flights.price_distance', [], 'tables', $locale),
        ];
    }
}
