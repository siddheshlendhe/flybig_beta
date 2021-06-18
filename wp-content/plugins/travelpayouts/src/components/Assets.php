<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;

use Travelpayouts;
use Travelpayouts\components\assets\AssetsLoader;

/**
 * Class Assets
 * @package Travelpayouts\components
 * @property-read AssetsLoader $loader
 */
class Assets extends Travelpayouts\components\assets\WebpackAssets
{
    /**
     * @var AssetsLoader
     */
    protected $_loader;

    /**
     * @return AssetsLoader
     */
    public function getLoader()
    {
        if (!$this->_loader) {
            $this->_loader = new AssetsLoader([
                'assets' => $this,
                'loadableChunkName' => 'travelpayous_loadable_chunks',
            ]);
        }
        return $this->_loader;
    }

    protected function assetsPath()
    {
        return Travelpayouts::getAlias('@root/assets/assets.json');
    }

    public function prefix()
    {
        return TRAVELPAYOUTS_PLUGIN_NAME . '-assets';
    }
}
