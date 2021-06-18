<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\api\hotelLook;

/**
 * Class LocationApiModel
 * @property $city
 * @property string $check_in
 * @property string $check_out
 * @property string $language
 */
class LocationApiModel extends BaseHotelLookApiModel
{
    const DATE_INPUT_FORMAT = 'd-m-Y';
    const DATE_OUTPUT_FORMAT = 'Y-m-d';

    public $currency;
    /**
     * @var string|int
     * id of the city
     */
    public $id;
    /**
     * @var string|int
     * limitation of output results from 1 to 100, default - 10;
     */
    public $limit = 10;

    /**
     * @var string
     * type of hotels from request /tp/public/available_selections.json
     */
    public $type;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'limit', 'language', 'type', 'currency'], 'required'],
            [['currency'], 'string', 'length' => 3],
            [['city', 'check_in', 'check_out'], 'safe'],
        ]);
    }

    protected function request()
    {
        return $this->fetchApi();
    }

    public function afterRequest()
    {
        parent::afterRequest();
        $response = $this->response;
        if (is_array($response)) {
            $this->response = array_reduce(array_keys($response), $this->mapResponse($response), []);
        }
    }

    protected function mapResponse($response)
    {
        return static function ($accumulator, $categoryName) use ($response) {
            $hotelsList = array_map(self::mapHotel($categoryName), $response[$categoryName]);
            return array_merge($accumulator, $hotelsList);
        };
    }

    protected static function mapHotel($categoryName)
    {
        return static function ($hotelData) use ($categoryName) {
            $mappedData = ['category_id' => $categoryName, 'price' => null, 'discount' => null];
            if (isset($hotelData['last_price_info'])) {
                $priceInfo = $hotelData['last_price_info'];
                $mappedData = array_merge($mappedData, [
                    'price' => $priceInfo['price'],
                    'discount' => isset($priceInfo['discount']) ? $priceInfo['discount'] : null,
                ]);
            }
            return array_merge($hotelData, $mappedData);
        };
    }

    /**
     * @inheritDoc
     */
    public function endpointUrl()
    {
        return 'https://yasen.hotellook.com/tp/v1/widget_location_dump.json';
    }

    /**
     * @inheritdoc
     */
    public function extraAttributes()
    {
        return ['language'];
    }
}
