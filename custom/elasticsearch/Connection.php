<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\elasticsearch;

use yii\elasticsearch\Connection as BaseConnection;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Connection extends BaseConnection {

    public $indexPrefix;  //used from environment to set the index name (dev_ | pre_ | prod_)

    /**
     * @inheritdoc
     */

    public function createCommand($config = []) {
        $this->open();
        $config['db'] = $this;
        $command = new Command($config);

        return $command;
    }

}
