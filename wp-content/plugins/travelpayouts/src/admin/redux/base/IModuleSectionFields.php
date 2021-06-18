<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux\base;
use Travelpayouts\Vendor\Adbar\Dot;

/**
 * Interface IModuleSectionFields
 * @package Travelpayouts\admin\redux\base
 * @property-read string $id
 * @property-read Dot $data
 */
interface IModuleSectionFields
{
    /**
     * @return array[]
     */
    public function fields();

    /**
     * Путь к опции текущего класса
     * @return string
     */
    public function optionPath();
}
