<?php

namespace Travelpayouts\components;

use Travelpayouts;
use Travelpayouts\components\api\ApiEndpoint;
use Travelpayouts\components\httpClient\Client;
use Travelpayouts\components\notices\Notices;

/**
 * Class Platforms
 * @package Travelpayouts\components
 *
 */
class Platforms extends ApiEndpoint
{
    const CACHE_KEY = 'travelpayouts_platform_sources';
    const PLATFORMS_ENDPOINT = 'https://api.travelpayouts.com/users/v1/get_traffic_sources';

    /**
     * @return array|mixed
     */
    protected function getApiResponseData()
    {
        $client = new Client(
            [
                'timeout' => 15,
                'headers' => [
                    'X-Access-Token' => Travelpayouts::getInstance()->account->getToken()
                ]
            ]
        );
        $response = $client->get(self::PLATFORMS_ENDPOINT);
        $platformsList = [];
        if (!$response->isError &&
            $response->statusCode === 200 &&
            $response->json &&
            isset($response->json['sources'])
        ) {
            $platformsList = $response->json['sources'];
        }

        return $platformsList;
    }

    /**
     * @return array
     */
    public function getSelectOptions()
    {
        // Сброс несуществующей платформы в настройках
        if (!$this->isActivePlatformSelected()) {
            Travelpayouts::getInstance()->redux->setOption('account_platform', '0');
        }

        if (!empty($this->responseData)) {
            $options[] = Travelpayouts::__('Please select a source for your website');
        } else {
            $options[] = Travelpayouts::__("Your account doesn't have traffic sources yet");
        }
        foreach ($this->responseData as $platform) {
            $options[$platform['id']] = $platform['name'] . ' #' . $platform['id'];
        }

        return $options;
    }

    /**
     * @return bool
     */
    public function isActivePlatformSelected()
    {
        $platform = Travelpayouts::getInstance()->account->getPlatform();
        $platforms = $this->responseData;
        $platformsId = array_column($platforms, 'id');

        return !empty($platforms) && in_array($platform, $platformsId);
    }

    /**
     * @return array|mixed
     */
    public function getActivePrograms()
    {
        $selectedPlatform = Travelpayouts::getInstance()->account->getPlatform();
        foreach ($this->responseData as $platform) {
            if (!empty($selectedPlatform) && isset($platform['id']) && $platform['id'] == $selectedPlatform) {
                if (isset($platform['program_ids']['accepted']) && !empty($platform['program_ids']['accepted'])) {
                    return $platform['program_ids']['accepted'];
                }
            }
        }

        return [];
    }

    /**
     * @return bool
     */
    public function isActiveRequiredPrograms()
    {
        $selectedPlatform = Travelpayouts::getInstance()->account->getPlatform();
        if (empty($selectedPlatform)) {
            return true;
        }

        $requiredPlatforms = [Subscriptions::AVIASALES_ID, Subscriptions::HOTELLOOK_ID];

        return count(array_intersect($requiredPlatforms, $this->getActivePrograms())) == count($requiredPlatforms);
    }

    /**
     * @param $programId
     * @return bool
     */
    public function isActive($programId)
    {
        return in_array($programId, $this->getActivePrograms());
    }

    /**
     * Если от апи пришли площадки для выбора и
     * выбрана площадка или установлена кука "hide"
     * мы не показываем notice
     *
     * @return bool
     */
    public function showSelectPlatformNotice()
    {
        return !empty($this->responseData) && !$this->isActivePlatformSelected();
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return self::CACHE_KEY . '_' . Travelpayouts::getInstance()->account->getToken();
    }
}
