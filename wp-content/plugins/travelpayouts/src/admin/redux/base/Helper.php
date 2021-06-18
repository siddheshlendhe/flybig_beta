<?php
/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 */

namespace Travelpayouts\admin\redux\base;


class Helper
{
    /**
     * Добавляем префикс опции к id поля для корректной работы с TravelpayoutsSettingsFramework
     * @param array $fields
     * @param string $prefix
     * @return array
     */
    public static function addPrefixToFields($fields, $prefix)
    {
        return array_map(static function ($field) use ($prefix) {
            return isset($field['id']) ?
                array_merge($field, ['id' => $prefix . '_' . $field['id']])
                : null;
        }, $fields);
    }

    /**
     * @param $prefix
     * @param $options
     * @return array
     */
    public static function getDataFromReduxOption($options, $prefix)
    {
        if ($options) {
            $fieldsWithPrefix = preg_grep('/^' . $prefix . '/', array_keys($options));

            $filteredOptions = array_filter($options, function ($option_name) use ($fieldsWithPrefix) {
                return in_array($option_name, $fieldsWithPrefix, true);
            }, ARRAY_FILTER_USE_KEY);

            return array_reduce(array_keys($filteredOptions), function ($accumulator, $key) use ($filteredOptions, $prefix) {
                $value = $filteredOptions[$key];
                $keyWithoutPrefix = preg_replace('/^' . $prefix . '_/', '', $key);
                return array_merge($accumulator, [
                    $keyWithoutPrefix => $value,
                ]);
            }, []);
        }
        return [];
    }
}
