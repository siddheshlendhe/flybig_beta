<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;

use Exception;
use Travelpayouts\Vendor\Symfony\Component\Translation\Loader\YamlFileLoader;
use Travelpayouts\Vendor\Symfony\Component\Translation\Translator as SymfonyTranslator;
use Travelpayouts\Vendor\Symfony\Component\Yaml\Yaml;
use Travelpayouts;

/**
 * Class Translator
 * @package Travelpayouts\components
 * @property-read SymfonyTranslator $translator
 * @property string $locale
 */
class Translator extends BaseObject
{
	const DEFAULT_TRANSLATION = self::ENGLISH;

	const CZECH = 'cs';
	const DANISH = 'da';
	const GERMAN = 'de';
	const GREEK = 'el';
	const ENGLISH = 'en';
	const SPANISH = 'es-ES';
	const FINNISH = 'fi';
	const FRENCH = 'fr';
	const HEBREW = 'he';
	const HUNGARIAN = 'hu';
	const ITALIAN = 'it';
	const JAPANESE = 'ja';
	const KOREAN = 'ko';
	const DUTCH = 'nl';
	const NORWEGIAN = 'no';
	const POLISH = 'pl';
	const PORTUGUESE_BRAZILIAN = 'pt-BR';
	const PORTUGUESE = 'pt-PT';
	const ROMANIAN = 'ro';
	const RUSSIAN = 'ru';
	const SWEDISH = 'sv-SE';
	const TURKISH = 'tr';
	const UKRAINIAN = 'uk';
	const VIETNAMESE = 'vi';
	const CHINESE_SIMPLIFIED = 'zh-CN';
	const CHINESE_TRADITIONAL = 'zh-TW';
	const THAI = 'th';

	const TAJIK = 'tg';
	const CATALAN = 'ca';
	const BELARUSIAN = 'be';
	const BOSNIAN = 'bs';
	const KAZAKH = 'kk';
	const UZBEK = 'uz';
	const CHECHEN = 'ce';
	const MONTENEGRIN = 'me';
	const SERBIAN_LATIN = 'sr-CS';
	const CROATIAN = 'hr';
	const ARABIC = 'ar';
	const GEORGIAN = 'ka';
	const LATVIAN = 'lv';
	const LITHUANIAN = 'lt';
	const SLOVENIAN = 'sl';
	const BULGARIAN = 'bg';
	const MALAY = 'ms';
	const SLOVAK = 'sk';

	public $defaultLocale;
	public $translationsFolder;

	protected $supportedLocales = [
		self::CZECH,
		self::DANISH,
		self::GERMAN,
		self::GREEK,
		self::ENGLISH,
		self::SPANISH,
		self::FINNISH,
		self::FRENCH,
//        self::HEBREW,
		self::HUNGARIAN,
		self::ITALIAN,
		self::JAPANESE,
		self::KOREAN,
		self::DUTCH,
		self::NORWEGIAN,
		self::POLISH,
		self::PORTUGUESE_BRAZILIAN,
		self::PORTUGUESE,
		self::ROMANIAN,
		self::RUSSIAN,
		self::SWEDISH,
		self::TURKISH,
		self::UKRAINIAN,
		self::VIETNAMESE,
		//self::BELARUSIAN,
		self::GEORGIAN,
		//self::LATVIAN,
		//self::LITHUANIAN,
		//self::SLOVENIAN,
		self::SLOVAK,
		self::BULGARIAN,
		self::CHINESE_SIMPLIFIED,
		self::CHINESE_TRADITIONAL,
		self::MALAY,
		self::SERBIAN_LATIN,
	];
	// right-to-left
	protected $rtlLocales = [self::ARABIC, self::HEBREW];
	protected $fallbackLocales = [
		self::TAJIK => self::RUSSIAN,
		self::CATALAN => self::SPANISH,
		self::BOSNIAN => self::CROATIAN,
		self::CHECHEN => self::RUSSIAN,
		self::KAZAKH => self::RUSSIAN,
		self::UZBEK => self::RUSSIAN,
		self::MONTENEGRIN => self::SERBIAN_LATIN,
		self::THAI => self::ENGLISH,
	];

	protected $_translator;

	public function init()
	{
		$translator = new SymfonyTranslator($this->defaultLocale);
		$translator->addLoader('yaml', new YamlFileLoader());
		$translator->setFallbackLocales(['en']);
		$this->_translator = $translator;
		$this->translationsFolder = Travelpayouts::getAlias($this->translationsFolder);
		$this->addTranslations();
		$this->setLocale($this->defaultLocale);
	}

	public function setLocale($locale)
	{
		$this->translator->setLocale($locale);
	}

	/**
	 * @param bool $fallbackLocale - возвращает оригинальный код локали или код фоллбек языка
	 * @return string
	 */
	public function getLocale($fallbackLocale = true)
	{
		$locale = $this->translator->getLocale();
		return !$fallbackLocale && array_key_exists($locale, $this->fallbackLocales) ?
			$this->fallbackLocales[$locale] :
			$locale;
	}

	protected function getLocaleKeys()
	{
		return array_merge($this->supportedLocales, array_keys($this->fallbackLocales));
	}

	public function getSupportedLocales()
	{
		try {
			$crowdinLocaleList = Yaml::parseFile(Travelpayouts::getAlias('@data/translations/localeList.yml'));
			if (is_array($crowdinLocaleList) && isset($crowdinLocaleList['data'])) {
				$localeList = $crowdinLocaleList['data'];
				$locales = array_reduce($this->getLocaleKeys(), function ($accumulator, $locale) use ($localeList) {
					$foundLocaleIndex = array_search($locale, array_column($localeList, 'code'), true);
					if ($foundLocaleIndex !== false) {
						$foundValue = $localeList[$foundLocaleIndex];
						$accumulator[$locale] = $foundValue['name'];
					}
					return $accumulator;
				}, []);

				asort($locales);

				return $locales;
			}
		} catch (Exception $e) {
			return [];
		}
		return [];
	}

	public function addTranslations()
	{
		$fallbackLocaleList = $this->fallbackLocales;
		foreach ($this->getLocaleKeys() as $locale) {
			// определяем, фоллбек или нет
			$fileName = isset($fallbackLocaleList[$locale]) ? $fallbackLocaleList[$locale] : $locale;
			$this->addTranslation($locale, $fileName);
		}

	}

	protected function addTranslation($localeName, $fallbackLocale)
	{
		$locPath = $this->translationsFolder . DIRECTORY_SEPARATOR . $fallbackLocale;
		if (file_exists($locPath)) {
			$domainsList = glob($locPath . '/*.yml');
			foreach ($domainsList as $path) {
				$domain = basename($path, '.yml');
				$this->translator->addResource('yaml', $path, $localeName, $domain);
			}
		}
	}

	/**
	 * @return SymfonyTranslator
	 */
	protected function getTranslator()
	{
		return $this->_translator;
	}

	public function trans($id, array $parameters = [], $domain = null, $locale = null)
	{
		return $this->translator->trans($id, $parameters, $domain, $locale);
	}

	public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
	{
		return $this->translator->transChoice($id, $number, $parameters, $domain, $locale);
	}

	/**
	 * Проверяем, имеет ли сообщение перевод
	 * @param string $id
	 * @param null $domain
	 * @param null $locale
	 * @return bool
	 */
	public function hasTranslation($id, $domain = null, $locale = null)
	{
		return $this->translator->getCatalogue($locale)->has((string)$id, $domain);
	}
}
