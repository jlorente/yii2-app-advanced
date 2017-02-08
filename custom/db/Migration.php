<?php

/**
 * @author      Jose Lorente <jlorente@vivocom.eu>
 * @version     1.0
 */

namespace custom\db;

use yii\db\Migration as BaseMigration;

/**
 * Custom implementation of yii\db\Migration
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Migration extends BaseMigration {

    /**
     * Add multiple columns to a table.
     * 
     * @param string $table
     * @param array $columns ["column_name"=>type]
     */
    public function addColumns($table, $columns) {
        foreach ($columns as $column => $type) {
            parent::addColumn($table, $column, $type);
        }
    }

    /**
     * Drop multiple columns to a table.
     * 
     * @param string $table
     * @param array $columns ["column_name"=>type]
     */
    public function dropColumns($table, $columns) {
        foreach ($columns as $column => $type) {
            parent::dropColumn($table, $column);
        }
    }

}
