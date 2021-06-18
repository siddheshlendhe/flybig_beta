<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\modules\tables\components\flights;
use Travelpayouts\Vendor\DI\Annotation\Inject;
use Travelpayouts\components\rest\BaseRestCampaignModule;
use Travelpayouts\components\Subscriptions;

class RestCampaign extends BaseRestCampaignModule
{
    /**
     * @Inject
     * @var cheapestFlights\Front
     */
    public $tp_cheapest_flights_shortcodes;
    /**
     * @Inject
     * @var cheapestTicketEachDayMonth\Front
     */
    public $tp_cheapest_ticket_each_day_month_shortcodes;
    /**
     * @Inject
     * @var cheapestTicketsEachMonth\Front
     */
    public $tp_cheapest_tickets_each_month_shortcodes;
    /**
     * @Inject
     * @var directFlights\Front
     */
    public $tp_direct_flights_shortcodes;
    /**
     * @Inject
     * @var directFlightsRoute\Front
     */
    public $tp_direct_flights_route_shortcodes;
    /**
     * @Inject
     * @var fromOurCityFly\Front
     */
    public $tp_from_our_city_fly_shortcodes;
    /**
     * @Inject
     * @var inOurCityFly\Front
     */
    public $tp_in_our_city_fly_shortcodes;
    /**
     * @Inject
     * @var ourSiteSearch\Front
     */
    public $tp_our_site_search_shortcodes;
    /**
     * @Inject
     * @var popularDestinationsAirlines\Front
     */
    public $tp_popular_destinations_airlines_shortcodes;
    /**
     * @Inject
     * @var popularRoutesFromCity\Front
     */
    public $tp_popular_routes_from_city_shortcodes;
    /**
     * @Inject
     * @var priceCalendarMonth\Front
     */
    public $tp_price_calendar_month_shortcodes;
    /**
     * @Inject
     * @var priceCalendarWeek\Front
     */
    public $tp_price_calendar_week_shortcodes;

    /**
     * @inheritDoc
     */
    protected function campaignId()
    {
        return Subscriptions::AVIASALES_ID;
    }
}
