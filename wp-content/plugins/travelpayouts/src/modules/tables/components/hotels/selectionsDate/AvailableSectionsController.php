<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\hotels\selectionsDate;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\base\cache\Cache;
use Travelpayouts\components\Controller;
use Travelpayouts\components\httpClient\Client;
use Travelpayouts\components\Translator;

class AvailableSectionsController extends Controller
{
    /**
     * @Inject
     * @var Cache
     */
    protected $cache;
    /**
     * @Inject
     * @var Client
     */
    protected $client;

    /**
     * @Inject
     * @var Translator
     */
    protected $translator;

    public function actionGetAvailableSelections($id)
    {
        $availableSectionKeys = $this->fetchAvailableSections($id);

        $availableSections = [];

        foreach ($availableSectionKeys as $availableSectionKey) {
            $availableSections[] = [
                'id' => $availableSectionKey,
                'label' => $this->translateSectionName($availableSectionKey),
            ];
        }

        $this->response(true, ['data' => $availableSections]);
    }

    protected function translateSectionName($key)
    {
        $baseSections = [
            'tophotels' => 'Top hotels',
            'popularity' => 'Popularity',
            'price' => 'Cheap',
            'distance' => 'Distance',
            'rating' => 'Rating',
            '0stars' => '0 stars',
            '1stars' => '1 star',
            '2stars' => '2 stars',
            '3stars' => '3 stars',
            '4stars' => '4 stars',
            '5stars' => '5 stars',
            '0-stars' => '0 stars',
            '1-stars' => '1 star',
            '2-stars' => '2 stars',
            '3-stars' => '3 stars',
            '4-stars' => '4 stars',
            '5-stars' => '5 stars',
            'luxury' => 'Luxury',
            'highprice' => 'Expensive',
            'center' => 'Hotels in the center',
            'pool' => 'Pool',
            'gay' => 'Gay friendly',
            'smoke' => 'Smoking friendly',
            'restaurant' => 'Restaurant',
            'pets' => 'Pet friendly',
            'russians' => 'Russian guests',
            'sea_view' => 'Sea view',
            'lake_view' => 'Lake view',
            'river_view' => 'River view',
            'panoramic_view' => 'Panoramic view',
        ];

        if (array_key_exists($key, $baseSections)) {
            $translationPath =  'hotel.selections.' .  $baseSections[$key];
            if ($this->translator->hasTranslation($translationPath, 'tables')) {
               return $this->translator->trans($translationPath,[],'tables');
            }
        }

        return $key;
    }

    /**
     * @param $id
     * @return array|false|null
     */
    protected function fetchAvailableSections($id)
    {
        $requestUrl = "http://yasen.hotellook.com/tp/v1/available_selections.json?id=$id";
        $cacheKey = "getAvailableSelections_$requestUrl";
        /** @var false|array $data */
        $data = $this->cache->get($cacheKey);

        if ($data === false) {
            $response = $this->client->get($requestUrl);
            if (!$response->isError && $data = $response->json) {
                $this->cache->set($cacheKey, $data, 60 * 60 * 24);
            }
        }
        return $data;
    }

}
