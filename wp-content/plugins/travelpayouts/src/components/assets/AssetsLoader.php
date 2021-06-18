<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components\assets;

use Travelpayouts;
use Travelpayouts\components\Assets;
use Travelpayouts\components\BaseInjectedObject;
use Travelpayouts\components\HtmlHelper;

class AssetsLoader extends BaseInjectedObject
{
    public $loadableChunkName = 'loadable_chunks';

    protected $_assetList = [];

    /**
     * @var Assets
     */
    protected $assets;

    /**
     * Подключаем необходимые скрипты
     */
    public function setUpHooks()
    {
        $loader = Travelpayouts::getInstance()->hooksLoader;
        /** @see AssetsLoader::renderLoadableChunkList() */
        $loader->add_action('wp_footer', $this, 'renderLoadableChunkList', 1000);
        /** @see AssetsLoader::renderLoadableChunkList() */
        $loader->add_action('admin_footer', $this, 'renderLoadableChunkList', 1000);
        /** @see AssetsLoader::enqueueLoader() */
        $loader->add_action('wp_enqueue_scripts', $this, 'enqueueLoader');
        /** @see AssetsLoader::enqueueLoader() */
        $loader->add_action('admin_enqueue_scripts', $this, 'enqueueLoader');
    }


    public function enqueueLoader()
    {
        $this->assets->getAssetByName('runtime')
            ->setInFooter(true)
            ->enqueueScript()
            ->localizeScript('travelpayouts_plugin_publicPath', [Travelpayouts::getAlias('@webroot/assets') . '/']);
        $this->assets->getAssetByName('loader')
            ->setInFooter(true)
            ->enqueueScript()
            ->enqueueStyle();
    }

    public function renderLoadableChunkList()
    {
        $assetList = array_values(array_unique($this->_assetList));
        echo HtmlHelper::script('var ' . $this->loadableChunkName . ' = ' . json_encode($assetList) . ';');
    }

    /**
     * Подключаем скрипты и стили
     * Список доступных ассетов находится тут src/js/src/loader/chunks
     * @param string $name
     * @return $this
     */
    public function registerAsset($name)
    {
        if (is_string($name)) {
            $this->_assetList = array_merge($this->_assetList, [$name]);
        }
        return $this;
    }

    /**
     * @param string[] $assetNameList
     * @return $this
     * @see AssetsLoader::registerAsset()
     */
    public function registerAssets($assetNameList)
    {
        if (is_array($assetNameList)) {
            $this->_assetList = array_merge($this->_assetList, $assetNameList);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function renderPreloader()
    {
        return HtmlHelper::tagArrayContent('div', ['class' => 'travelpayouts-chunk-preloader-wrapper'], [
            HtmlHelper::tagArrayContent('div', ['class' => 'travelpayouts-chunk-preloader'], [
                HtmlHelper::tag('div', [], ''),
                HtmlHelper::tag('div', [], ''),
                HtmlHelper::tag('div', [], ''),
                HtmlHelper::tag('div', [], ''),
            ]),
        ]);
    }
}
