<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;

use Travelpayouts\modules\tables\components\api\hotelLook\LocationApiModel;

/**
 * Class Api
 * @package Travelpayouts\src\modules\tables\components\hotels\selectionsDate
 */
class Api extends LocationApiModel
{
    public $check_in;
    public $check_out;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['check_in', 'check_out'], 'required'],
        ]);
    }
}
