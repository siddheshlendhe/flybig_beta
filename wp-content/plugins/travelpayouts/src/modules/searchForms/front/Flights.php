<?php

namespace Travelpayouts\modules\searchForms\front;

use Travelpayouts;
use Travelpayouts\components\rest\FrontFields;
use Travelpayouts\components\rest\FrontModel;
use Travelpayouts\modules\searchForms\components\models\SearchForm;
use Travelpayouts\modules\searchForms\components\SearchFormShortcode;

class Flights extends FrontModel
{
    public $id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['id'],
                'required',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function shortcodeName()
    {
        return Travelpayouts::__('Flights search form');
    }

    /**
     * @inheritDoc
     */
    public function extraData()
    {
        return [
            'image' => Travelpayouts::getAlias('@webImages/rest/search_form.png'),
        ];
    }

    public function getFields()
    {
        return array_merge(
            FrontFields::searchForm(true, SearchFormShortcode::TYPE_AVIA),
            FrontFields::origin(false),
            FrontFields::destination(false),
			FrontFields::checkbox('applyParamsFromCode', Travelpayouts::__('Apply settings (origin, destination, etc.) from generated widget code '), false, true),
            FrontFields::additionalMarker('')
        );
    }

    public function setData($value)
    {
        return false;
    }

    public static function isValid()
    {
        return SearchForm::getInstance()->isActiveFlights();
    }
}
