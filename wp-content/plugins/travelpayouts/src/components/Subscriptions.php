<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\components;

use Exception;
use Travelpayouts;
use Travelpayouts\components\api\ApiEndpoint;
use Travelpayouts\components\httpClient\Client;

/**
 * Class Subscriptions
 * @package Travelpayouts\components
 */
class Subscriptions extends ApiEndpoint
{
    const CACHE_PREFIX = 'travelpayouts_subscriptions_ids';
    const SUBSCRIPTIONS_CHECKER_ENDPOINT = 'https://www.travelpayouts.com/campaigns/get_campaigns_subscriptions';

    const TP_TUTU_ID = 45;
    const HOTELLOOK_ID = 101;
    const AVIASALES_ID = 100;

    /**
     * @return array|mixed
     */
    public function getApiResponseData()
    {
        $client = new Client(
            [
                'timeout' => 15,
            ]
        );
        $response = $client->get(self::SUBSCRIPTIONS_CHECKER_ENDPOINT, [
            'params' => [
                'marker' => $this->getMarker(),
            ],
        ]);
        $subscriptionsList = [];
        if (!$response->isError &&
            $response->statusCode === 200 &&
            $response->json &&
            isset($response->json['subscriptions'])
        ) {
            $subscriptionsList = $response->json['subscriptions'];
        }

        return $subscriptionsList;
    }

    /**
     * Проверяем доступность сервиса
     * @param $id
     * @return bool
     */
    public function isActive($id)
    {
        if ((is_string($id) || is_int($id)) && preg_match('/^(\d*)$/', $id)) {
            $id = (int)$id;
            $subscriptionsList = $this->responseData;
            return in_array($id, $subscriptionsList, true);
        }
        return false;
    }

    /**
     * @return string|null
     */
    protected function getCacheKey()
    {
        return $this->getMarker()
            ? self::CACHE_PREFIX . $this->getMarker()
            : null;
    }

    /**
     * Получаем маркер напрямую, минуя travelPayouts DI
     * @return string|null
     */
    protected function getMarker()
    {
        try {
            $redux = Travelpayouts::getInstance()->redux;
            $options = $redux->get_options();
            return isset($options['account_api_marker']) && !empty($options['account_api_marker'])
                ? $options['account_api_marker']
                : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
