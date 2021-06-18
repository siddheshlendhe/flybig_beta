<?php

namespace Travelpayouts\components\tables\enrichment;

class UrlHelper
{
    const TUTU_CUSTOM_URL_HOST = 'www.tutu.ru/poezda/rasp_d.php';
    const TUTU_URL_HOST = 'c45.travelpayouts.com/click';
    const TUTU_PROMO_ID = 4483;
    const MEDIA_URL = 'tp.media/r';
    const FLIGHT_P = 4462;
    const HOTELS_P = 4463;
    const LINKS_P = 4114;

    public static function get_marker($account_marker, $additional_marker, $type)
    {
        $additional = '';
        if (!empty($additional_marker)) {
            $additional .= $additional_marker . '_';
        }
        $additional .= $type;

        $marker_array = [
            $account_marker,
            $additional,
            '$69'
        ];

        return htmlspecialchars(implode('.', $marker_array));
    }

    public static function buildUrl($rawHost, $params)
    {
        $host = self::add_scheme($rawHost);

        return $host . '?' . http_build_query(array_filter($params));
    }

    public static function buildMediaUrl($params)
    {
        return self::buildUrl(self::MEDIA_URL, $params);
    }

    public static function add_scheme($url, $scheme = 'https://')
    {
        if (parse_url($url, PHP_URL_SCHEME) === null) {
            return $scheme . $url;
        } else {
            return $url;
        }
    }
}
