<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\module;

use Travelpayouts\admin\redux\OptionsInit;

interface IModuleRedux
{
    /**
     * Добавляем секцию в Redux
     * @return void
     * @see OptionsInit::registerModuleSections()
     */
    public function registerSection();
}
