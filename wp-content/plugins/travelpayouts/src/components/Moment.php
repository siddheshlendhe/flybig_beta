<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;
use Travelpayouts\Vendor\Moment\FormatsInterface;
use Travelpayouts\Vendor\Moment\MomentException;

class Moment extends \Travelpayouts\Vendor\Moment\Moment
{
	private static $locale = 'en_US';

	/**
	 * Форматируем с явным указанием локали, по завершению делаем возврат к изначальной локали
	 * @param string $locale
	 * @param null|string $format
	 * @param null|FormatsInterface $formatsInterface
	 * @return string
	 * @throws MomentException
	 */
	public function formatWithLocale($locale, $format = null, $formatsInterface = null)
	{
		$currentLocale = self::$locale;
		self::setLocale($locale);
		$result = $this->format($format, $formatsInterface);
		self::setLocale($currentLocale);
		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public static function setLocale($locale, $findSimilar = false)
	{
		$fallbackLocale = self::getFallbackLocaleName($locale);
		self::$locale = $fallbackLocale;
		parent::setLocale($fallbackLocale, $findSimilar);
	}


	protected static function getFallbackLocaleName($locale)
	{
		switch ($locale) {
			case Translator::ARABIC:
			case 'ar_TN':
				return 'ar_TN';
			case Translator::CATALAN:
			case 'ca_ES':
				return 'ca_ES';
			case Translator::CHINESE_SIMPLIFIED:
			case 'zh_CN':
				return 'zh_CN';
			case Translator::CHINESE_TRADITIONAL:
			case 'zh_TW':
				return 'zh_TW';
			case Translator::CZECH:
				return 'cs_CZ';
			case Translator::DANISH:
			case 'da_DK':
				return 'da_DK';
			case Translator::DUTCH:
			case 'nl_NL':
				return 'nl_NL';
			case Translator::FINNISH:
			case 'fi_FI':
				return 'fi_FI';
			case Translator::FRENCH:
			case 'fr_FR':
				return 'fr_FR';
			case Translator::GERMAN:
			case 'de_DE':
				return 'de_DE';
			case Translator::HUNGARIAN:
			case 'hu_HU':
				return 'hu_HU';
			case Translator::ITALIAN:
			case 'it_IT':
				return 'it_IT';
			case Translator::JAPANESE:
			case 'ja_JP':
				return 'ja_JP';
			case Translator::LATVIAN:
			case 'lv_LV':
				return 'lv_LV';
			case Translator::POLISH:
			case 'pl_PL':
				return 'pl_PL';
			case Translator::PORTUGUESE:
			case 'pt_PT':
				return 'pt_PT';
			case Translator::RUSSIAN:
			case 'ru_RU':
				return 'ru_RU';
			case Translator::SPANISH:
			case 'es_ES':
				return 'es_ES';
			case Translator::SWEDISH:
			case 'sv_SE':
				return 'sv_SE';
			case Translator::UKRAINIAN:
			case 'uk_UA':
				return 'uk_UA';
			case Translator::THAI:
			case 'th_TH':
				return 'th_TH';
			case Translator::TURKISH:
			case 'tr_TR':
				return 'tr_TR';
			case Translator::VIETNAMESE:
			case 'vi_VN':
				return 'vi_VN';
			case Translator::GEORGIAN:
			case 'ka_GE':
				return 'ka_GE';
			default:
				return 'en_US';
		}
	}

	public function create($dateTime = 'now', $timezone = null, $immutableMode = false)
	{
		return new self($dateTime, $timezone, $immutableMode);
	}
}
