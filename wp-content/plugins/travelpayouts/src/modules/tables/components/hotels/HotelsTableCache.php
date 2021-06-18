<?php

namespace Travelpayouts\modules\tables\components\hotels;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts;
use Travelpayouts\admin\redux\ReduxOptions;
use Travelpayouts\components\tables\BaseTableCache;
use Travelpayouts\modules\tables\components\settings\HotelSettingsSection;

class HotelsTableCache extends BaseTableCache
{
    /**
     * @Inject
     * @var HotelSettingsSection
     */
    public $hotelSettings;
    protected $_additionalSettings = [
        'hotels_source',
        'hotels_after_url',
        'use_booking_com',
    ];

    protected function cacheDataSources()
    {
        return array_merge(parent::cacheDataSources(), [
            $this->hotelSettings->data->all(),
        ]);
    }

    /**
     * Можно получать cache_time для отелей и перелетов в BaseTableCache но
     * возможно предстоит брать значение не из settings а из настроек отелей или другого раздела
     * тут спорно возможно стоит сделать параметр и передавать в нем cache_time_key
     */
    protected function setTime()
    {
        $cacheTime = Travelpayouts::getInstance()->settings->section->data->get(
            ReduxOptions::cache_time_key_hotels()
        );

        $this->time = $cacheTime * 60 * 60;
    }
}
