<?php

namespace Travelpayouts\components\tables\enrichment;


use Travelpayouts\components\dictionary\TravelpayoutsApiData;
use Travelpayouts;
use Travelpayouts\components\Translator;

class CaseHelper
{
    const TYPE_ORIGIN = 'origin';
    const TYPE_DESTINATION = 'destination';

    public static function __callStatic($name, $arguments)
    {
        return self::getDefaultCases();
    }

    public static function getDefaultCases()
    {
        $originCase = TravelpayoutsApiData::CASE_GENITIVE;
        $destinationCase = TravelpayoutsApiData::CASE_ACCUSATIVE;

        $settings = Travelpayouts::getInstance()->settings->data;
        if ($settings->get('language') == Translator::RUSSIAN) {
            $originCase = $settings->get('origin_case');
            $destinationCase = $settings->get('destination_case');
        }

        return [
            self::TYPE_ORIGIN => $originCase,
            self::TYPE_DESTINATION => $destinationCase
        ];
    }

    public static function getCasesList()
    {
        return [
            TravelpayoutsApiData::CASE_NOMINATIVE => Travelpayouts::__('Nominative'),
            TravelpayoutsApiData::CASE_GENITIVE => Travelpayouts::__('Genitive'),
            TravelpayoutsApiData::CASE_ACCUSATIVE => Travelpayouts::__('Accusative'),
            TravelpayoutsApiData::CASE_DATIVE => Travelpayouts::__('Dative'),
            TravelpayoutsApiData::CASE_INSTRUMENTAL => Travelpayouts::__('Instrumental'),
            TravelpayoutsApiData::CASE_PREPOSITIONAL => Travelpayouts::__('Prepositional'),
        ];
    }
}
