<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\components\tables\TableDataModel;
use Travelpayouts\modules\tables\components\settings\HotelSettingsSection;

abstract class BaseTableData extends TableDataModel
{
    /**
     * @Inject
     * @var HotelsColumnEnricher
     */
    protected $columnEnrichment;
    /**
     * @Inject
     * @var HotelsTableHelper
     */
    protected $tableHelper;
    /**
     * @Inject
     * @var HotelSettingsSection
     */
    protected $reduxModule;
    /**
     * @Inject
     * @var HotelsTableCache
     */
    protected $tableCache;

    /**
     * @inheritdoc
     */
    public function columnsLabels($locale = null)
    {
        return [
            ColumnLabels::NAME => Travelpayouts::t('hotel.name', [], 'tables', $locale),
            ColumnLabels::STARS => Travelpayouts::t('hotel.stars', [], 'tables', $locale),
            ColumnLabels::DISCOUNT => Travelpayouts::t('hotel.discount', [], 'tables', $locale),
            ColumnLabels::OLD_PRICE_AND_NEW_PRICE => Travelpayouts::t('hotel.old_price_and_new_price', [], 'tables', $locale),
            ColumnLabels::BUTTON => Travelpayouts::t('hotel.button_column_title', [], 'tables', $locale),
            ColumnLabels::PRICE_PN => Travelpayouts::t('hotel.price_pn', [], 'tables', $locale),
            ColumnLabels::OLD_PRICE_AND_DISCOUNT => Travelpayouts::t('hotel.old_price_and_discount', [], 'tables', $locale),
            ColumnLabels::DISTANCE => Travelpayouts::t('hotel.distance', [], 'tables', $locale),
            ColumnLabels::OLD_PRICE_PN => Travelpayouts::t('hotel.old_price_pn', [], 'tables', $locale),
            ColumnLabels::RATING => Travelpayouts::t('hotel.rating', [], 'tables', $locale),
        ];
    }
}
