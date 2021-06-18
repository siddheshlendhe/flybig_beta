<?php

namespace Travelpayouts\components\tables;

/**
 * Created by: Andrey Polyakov (andrey@polyakov.im)
 * Кешируем верстку таблицы, это дает двойной прирост при отображении данных
 * @property TableDataModel $tableData
 */
trait TableModelCachedTrait
{
    /**
     * @var bool Использовать систему кеширования шаблона таблицы
     */
    protected $cache_table_template = true;
    protected $cache_key;

    /**
     * @var float|int
     * @TODO Весьма неясно как выдергивать время кеширования из настроек,
     * тк нет данных о том, к какому из разделов пренадлежит данная таблица
     */
    protected $cache_time = 60 * 60;

    /**
     * Получаем значение из кеша
     * @return array|boolean
     */
    public function get_cache_value()
    {
        return $this->cache_key ? $this->cache->get($this->cache_key) : false;
    }

    /**
     * Записываем значение в кеш
     * @param $data
     */
    private function set_cache_value($data)
    {
        if ($this->cache_key) {
            $this->cache->set($this->cache_key, $data, $this->cache_time);
        }
    }

    public function render_cached()
    {
        // Если функционал отключен, возвращаем в оригинальную функцию
        if (!$this->cache_table_template) return $this->render(false);

        if ($this->tableData && $this->tableData->cache) {
            $tableCache = $this->tableData->cache;
            $tableCache->setKey(
                $this->tableData->shortcode_attributes->toJson(),
                $this->tableData->redux_section_data->toJson(),
                $this->tableData->redux_module_data->toJson()
            );
            $this->cache_key = $tableCache->key;
            $this->cache_time = $tableCache->time;
        }

        $tableData = $this->get_cache_value();
        if (!$tableData) {
            $tableData = $this->render(false);
            $this->set_cache_value($tableData);
        }
        return $tableData;
    }
}
