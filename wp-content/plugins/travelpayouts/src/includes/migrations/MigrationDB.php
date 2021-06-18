<?php

namespace Travelpayouts\includes\migrations;

use Travelpayouts\components\BaseObject;

/**
 * Class MigrationDB
 * @package Travelpayouts\includes\migrations
 * @property-read \wpdb $db
 */
class MigrationDB extends BaseObject
{
    public $db;

    public function select(array $fields, $table)
    {
        $fields = implode(',', $fields);
        $tableName = $this->getTableName($table);
        $sql = 'SELECT ' . $fields . ' FROM ' . $tableName . ' LIMIT 1000';
        return $this->db->get_results($sql, ARRAY_A);
    }

    public function getTableName($name)
    {
        return $this->db->prefix . $name;
    }

    public function tableExists($table)
    {
        $tableName = $this->getTableName($table);
        if ($this->db->get_var("SHOW TABLES LIKE '{$tableName}'") == $tableName) {
            return true;
        }

        return false;
    }

    public function drop($table)
    {
        $tableName = $this->getTableName($table);
        $sql = "DROP TABLE IF EXISTS {$tableName}";
        return $this->db->query($sql);
    }
}