<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\railway;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\tables\TableDataModel;

abstract class BaseTableData extends TableDataModel
{
    /**
     * @Inject
     * @var ColumnEnricher
     */
    protected $columnEnrichment;
    /**
     * @Inject
     * @var TableHelper
     */
    protected $tableHelper;

    /**
     * @inheritdoc
     */
    public function columnsLabels($locale = 'ru')
    {
        return [
            ColumnLabels::TRAIN => Travelpayouts::t('railway.train', [], 'tables', $locale),
            ColumnLabels::ROUTE => Travelpayouts::t('railway.route', [], 'tables', $locale),
            ColumnLabels::DEPARTURE => Travelpayouts::t('railway.departure', [], 'tables', $locale),
            ColumnLabels::ARRIVAL => Travelpayouts::t('railway.arrival', [], 'tables', $locale),
            ColumnLabels::DURATION => Travelpayouts::t('railway.duration', [], 'tables', $locale),
            ColumnLabels::PRICES => Travelpayouts::t('railway.prices', [], 'tables', $locale),
            ColumnLabels::DATES => Travelpayouts::t('railway.dates', [], 'tables', $locale),
            ColumnLabels::ORIGIN => Travelpayouts::t('railway.origin', [], 'tables', $locale),
            ColumnLabels::DESTINATION => Travelpayouts::t('railway.destination', [], 'tables', $locale),
            ColumnLabels::DEPARTURE_TIME => Travelpayouts::t('railway.departure_time', [], 'tables', $locale),
            ColumnLabels::ARRIVAL_TIME => Travelpayouts::t('railway.arrival_time', [], 'tables', $locale),
            ColumnLabels::ROUTE_FIRST_STATION => Travelpayouts::t('railway.route_first_station', [], 'tables', $locale),
            ColumnLabels::ROUTE_LAST_STATION => Travelpayouts::t('railway.route_last_station', [], 'tables', $locale),
        ];
    }
}
