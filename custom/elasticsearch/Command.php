<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\elasticsearch;

use yii\elasticsearch\Command as BaseCommand;
use yii\helpers\Json;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Command extends BaseCommand {

    /**
     * 
     * @inheritdoc
     */
    public function search($options = []) {
        $query = $this->queryParts;
        if (empty($query)) {
            $query = '{}';
        }
        if (is_array($query)) {
            $query = Json::encode($query);
        }

        $url = [$this->index !== null ? $this->index : '_all'];
        if ($this->type !== null) {
            $url[] = $this->type;
        }
        $url[] = '_search';

        return $this->db->get($url, array_merge($this->options, $options), $query);
    }

}
