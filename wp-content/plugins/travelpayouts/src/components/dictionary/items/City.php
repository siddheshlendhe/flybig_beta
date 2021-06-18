<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\dictionary\items;

class City extends TravelpayoutsApiItem
{
    public function getName($case = false)
    {
        if ($case) {
            $case_path = "cases.{$case}";
            $name = $this->dataDot->get($case_path);
            if ($name !== null)
                return $name;
        }
        return $this->dataDot->get('name');
    }

}
