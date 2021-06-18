<?php

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxFields;
use Travelpayouts\includes\Router;
use Travelpayouts\modules\tables\components\hotels\BaseFields;
use Travelpayouts\modules\tables\components\hotels\ColumnLabels;

/**
 * Class Section
 * @package Travelpayouts\src\modules\tables\components\hotels\selectionsDate
 * @property-read Api $api;
 */
class Section extends BaseFields
{
    /**
     * @Inject
     * @var Router
     */
    protected $router;

    public function columnsOptions()
    {
        return [
            'enabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::NAME,
                ColumnLabels::STARS,
                ColumnLabels::RATING,
                ColumnLabels::PRICE_PN,
                ColumnLabels::BUTTON,
            ]),
            'disabled' => ColumnLabels::getInstance()->getColumnLabels([
                ColumnLabels::DISTANCE,
            ]),
        ];
    }

    public function init()
    {
        $availableSectionsController = AvailableSectionsController::getInstance();
        $this->router->addRoute('GET', 'hotels/getAvailableSelections/{id:\d+}', [
            $availableSectionsController,
            'actionGetAvailableSelections',
        ]);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ReduxFields::table_base(
            $this->optionPath,
            Travelpayouts::__('Hotel collections for dates'),
            null,
            $this->columnsOptions(),
            [
                ReduxFields::text(
                    'subid',
                    Travelpayouts::__('Sub ID'),
                    '',
                    '',
                    'hotelsSelections'
                ),
            ],
            ReduxFields::sortByData($this->data->get('columns.enabled'), ColumnLabels::STARS),
            $this->titlePlaceholder(),
            $this->buttonPlaceholder(),
            Travelpayouts::__('Use {location} variable for city autoset')
        );
    }

    /**
     * @inheritDoc
     */
    public function optionPath()
    {
        return 'tp_hotels_selections_date_shortcodes';
    }

    /**
     * @inheritDoc
     */
    public function titlePlaceholder($locale = null)
    {
        return Travelpayouts::t('hotel.title.Hotels in {location}: {selection_name} ({dates})', [], 'tables', $locale);
    }

    /**
     * @inheritDoc
     */
    public function buttonPlaceholder($locale = null)
    {
        return Travelpayouts::t('hotel.button.View Hotel', [], 'tables', $locale);
    }
}
