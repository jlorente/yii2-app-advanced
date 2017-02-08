<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace custom\db;

/**
 * Class util for structurals migrations.
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
abstract class StructureMigration extends Migration {

    const EVENT_AFTER_CREATE_TABLES = 1;
    const EVENT_AFTER_CREATE_COLUMNS = 2;
    const EVENT_AFTER_CREATE_PRIMARY_KEYS = 3;
    const EVENT_AFTER_CREATE_INDEXES = 4;
    const EVENT_AFTER_CREATE_FOREIGN_KEYS = 5;
    const EVENT_AFTER_DROP_TABLES = 10;
    const EVENT_AFTER_DROP_COLUMNS = 11;
    const EVENT_AFTER_DROP_PRIMARY_KEYS = 12;
    const EVENT_AFTER_DROP_INDEXES = 13;
    const EVENT_AFTER_DROP_FOREIGN_KEYS = 14;

    /**
     * @inheritdoc
     */
    public function up() {
        //Indexes drops
        foreach ($this->getDropForeignKeys() as $fKey) {
            list($name, $table) = $fKey;
            $this->dropForeignKey($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_FOREIGN_KEYS);
        foreach ($this->getDropIndexes() as $index) {
            list($name, $table) = $index;
            $this->dropIndex($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_INDEXES);
        foreach ($this->getDropPrimaryKeys() as $pK) {
            list($name, $table) = $pK;
            $this->dropPrimaryKey($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_PRIMARY_KEYS);

        //Structure generations
        foreach ($this->getTables() as $name => $columns) {
            $this->createTable($name, $columns);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_TABLES);
        foreach ($this->getColumns() as $name => $column) {
            list($table, $name, $type) = $column;
            $this->addColumn($table, $name, $type);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_COLUMNS);
        foreach ($this->getPrimaryKeys() as $pK) {
            list($name, $table, $columns) = $pK;
            $this->addPrimaryKey($name, $table, $columns);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_PRIMARY_KEYS);

        //Structure drops
        foreach ($this->getDropColumns() as $column) {
            list($table, $name) = $column;
            $this->dropColumn($table, $name);
        }
        $this->trigger(self::EVENT_AFTER_DROP_COLUMNS);
        foreach ($this->getDropTables() as $name => $columns) {
            $this->dropTable($name);
        }
        $this->trigger(self::EVENT_AFTER_DROP_TABLES);

        //Indexes generations
        foreach ($this->getIndexes() as $index) {
            list($name, $table, $columns, $unique) = $index;
            $this->createIndex($name, $table, $columns, $unique);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_INDEXES);
        foreach ($this->getForeignKeys() as $fKey) {
            list($name, $table, $columns, $refTable, $refColumns, $delete, $update) = $fKey;
            $this->addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_FOREIGN_KEYS);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        //Indexes drops
        foreach ($this->getForeignKeys() as $fKey) {
            list($name, $table) = $fKey;
            $this->dropForeignKey($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_FOREIGN_KEYS);
        foreach ($this->getIndexes() as $index) {
            list($name, $table) = $index;
            $this->dropIndex($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_INDEXES);
        foreach ($this->getPrimaryKeys() as $pK) {
            list($name, $table) = $pK;
            $this->dropPrimaryKey($name, $table);
        }
        $this->trigger(self::EVENT_AFTER_DROP_PRIMARY_KEYS);

        //Structure generations
        foreach ($this->getDropTables() as $name => $columns) {
            $this->createTable($name, $columns);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_TABLES);
        foreach ($this->getDropColumns() as $name => $column) {
            list($table, $name, $type) = $column;
            $this->addColumn($table, $name, $type);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_COLUMNS);
        foreach ($this->getDropPrimaryKeys() as $pK) {
            list($name, $table, $columns) = $pK;
            $this->addPrimaryKey($name, $table, $columns);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_PRIMARY_KEYS);

        //Structure drops
        foreach ($this->getColumns() as $column) {
            list($table, $name) = $column;
            $this->dropColumn($table, $name);
        }
        $this->trigger(self::EVENT_AFTER_DROP_COLUMNS);
        foreach ($this->getTables() as $name => $columns) {
            $this->dropTable($name);
        }
        $this->trigger(self::EVENT_AFTER_DROP_TABLES);

        //Indexes generations
        foreach ($this->getDropIndexes() as $index) {
            list($name, $table, $columns, $unique) = $index;
            $this->createIndex($name, $table, $columns, $unique);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_INDEXES);
        foreach ($this->getDropForeignKeys() as $fKey) {
            list($name, $table, $columns, $refTable, $refColumns, $delete, $update) = $fKey;
            $this->addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
        }
        $this->trigger(self::EVENT_AFTER_CREATE_FOREIGN_KEYS);
    }

    /**
     * Gets the tables array with its columns.
     * 
     * @return array
     */
    public function getTables() {
        return [];
    }

    /**
     * Gets the columns array.
     * 
     * @return array
     */
    public function getColumns() {
        return [];
    }

    /**
     * Gets the primary keys for the tables in this migration.
     * 
     * @return array
     */
    public function getPrimaryKeys() {
        return [];
    }

    /**
     * Gets the indexes for the tables in this migration.
     * 
     * @return array
     */
    public function getIndexes() {
        return [];
    }

    /**
     * Gets the foreign keys for the tables in this migration.
     * 
     * @return array
     */
    public function getForeignKeys() {
        return [];
    }

    /**
     * Gets the foreign keys to drop in the migration.
     * 
     * @return array
     */
    public function getDropForeignKeys() {
        return [];
    }

    /**
     * Gets the indexes to drop in the migration.
     * 
     * @return array
     */
    public function getDropIndexes() {
        return [];
    }

    /**
     * Gets the primary keys to drop in the migration.
     * 
     * @return array
     */
    public function getDropPrimaryKeys() {
        return [];
    }

    /**
     * Gets the columns to drop in the migration.
     * 
     * @return array
     */
    public function getDropColumns() {
        return [];
    }

    /**
     * Gets the tables to drop in the migration.
     * 
     * @return array
     */
    public function getDropTables() {
        return [];
    }

}
