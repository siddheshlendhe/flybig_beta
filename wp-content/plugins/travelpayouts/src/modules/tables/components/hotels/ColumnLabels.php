<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels;

use Travelpayouts;
use Travelpayouts\components\tables\BaseColumnLabels;

/***
 * Class ColumnLabels
 * @package Travelpayouts\modules\tables\components
 */
class ColumnLabels extends BaseColumnLabels
{
    const NAME = 'name';
    const STARS = 'stars';
    const DISCOUNT = 'discount';
    const OLD_PRICE_AND_NEW_PRICE = 'old_price_and_new_price';
    const BUTTON = 'button';
    const PRICE_PN = 'price_pn';
    const OLD_PRICE_AND_DISCOUNT = 'old_price_and_discount';
    const DISTANCE = 'distance';
    const OLD_PRICE_PN = 'old_price_pn';
    const RATING = 'rating';

    /**
     * @inheritdoc
     */
    public function columnLabels()
    {
        return [
            self::NAME => Travelpayouts::__('Hotel'),
            self::STARS => Travelpayouts::__('Stars'),
            self::DISCOUNT => Travelpayouts::__('Discount'),
            self::OLD_PRICE_AND_NEW_PRICE => Travelpayouts::__('Old and new price'),
            self::BUTTON => Travelpayouts::__('Button'),
            self::PRICE_PN => Travelpayouts::__('Price per night, from'),
            self::OLD_PRICE_AND_DISCOUNT => Travelpayouts::__('Price before and discount'),
            self::DISTANCE => Travelpayouts::__('To the center'),
            self::OLD_PRICE_PN => Travelpayouts::__('Price before discount'),
            self::RATING => Travelpayouts::__('Rating'),
        ];
    }
}
