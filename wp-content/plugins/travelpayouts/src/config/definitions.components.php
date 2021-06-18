<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */
use Travelpayouts\Vendor\League\Plates\Engine;
use Travelpayouts\Vendor\Rollbar\Rollbar;
use Travelpayouts\Vendor\Rollbar\RollbarLogger;
use Travelpayouts\admin\Admin;
use Travelpayouts\components\Assets;
use Travelpayouts\components\base\cache\Cache;
use Travelpayouts\components\base\cache\CacheFromSettings;
use Travelpayouts\components\Moment;
use Travelpayouts\components\multilingual\MultiLang;
use Travelpayouts\components\rest\FrontRestRoutes;
use Travelpayouts\components\snowplow\Tracker;
use Travelpayouts\components\Translator;
use Travelpayouts\frontend\Frontend;
use Travelpayouts\includes\HooksLoader;
use Travelpayouts\includes\I18n;
use Travelpayouts\includes\ReduxConfigurator;
use Travelpayouts\includes\Router;
use function Travelpayouts\Vendor\DI\get;
use function Travelpayouts\Vendor\DI\object;

return [
	Cache::class => object(CacheFromSettings::getCacheClass()),
	FrontRestRoutes::class => object(),
	Frontend::class => object(),
	Admin::class => object(),
	MultiLang::class => object(),
	Assets::class => object(Assets::class),
	Translator::class => object()->constructor([
		'defaultLocale' => 'en',
		'translationsFolder' => '@data/translations',
	]),
	Router::class => object()->constructor([
		'actionParam' => 'wp_ajax_travelpayouts_routes',
	]),
	/** @see Engine::addFolder() */
	Engine::class => object()->method('addFolder', 'admin', Travelpayouts::getAlias('@src/admin/templates')),
	ReduxConfigurator::class => object()->constructor(TRAVELPAYOUTS_REDUX_OPTION, get('redux.config')),
	RollbarLogger::class => object(Rollbar::class)->constructor(get('rollbar.config'), false, false, false),
	Tracker::class => object()->constructor([
		'url' => TRAVELPAYOUTS_DEBUG
			? 'beta.avsplow.com'
			: 'avsplow.com',
		'protocol' => 'https',
		'post_type' => 'POST',
		'buffer_size' => 1,
		'debug' => TRAVELPAYOUTS_DEBUG,
		'namespace' => null,
		'app_id' => 'tp_wp_plugin',
	])->method('setContext', get('snowplow.context')),
	HooksLoader::class => object(),
	I18n::class => object()->constructor([
		'domain' => TRAVELPAYOUTS_TEXT_DOMAIN,
		'localePath' => Travelpayouts::getAlias('@root/languages'),
	]),
	Moment::class => object(),
];
