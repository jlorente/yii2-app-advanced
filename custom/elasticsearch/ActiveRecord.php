<?php

/**
 * @author      José Lorente <jl@bytebox.es>
 * @version     1.0
 */

namespace custom\elasticsearch;

use yii\elasticsearch\ActiveRecord as BaseActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Custom implementation of elasticsearch ActiveRecord
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ActiveRecord extends BaseActiveRecord {

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function rules() {
        return [
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributes() {
        return ['created_at', 'updated_at'];
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }

}
