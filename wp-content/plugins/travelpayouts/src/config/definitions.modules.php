<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

use Travelpayouts\modules;
use function Travelpayouts\Vendor\DI\object;

return [
	modules\tables\Tables::class => object(),
	modules\widgets\Widgets::class => object(),
	modules\searchForms\Search::class => object(),
	modules\account\Account::class => object(),
	modules\settings\Settings::class => object(),
	modules\links\Links::class => object(),
	modules\help\HelpModule::class => object(),
];
