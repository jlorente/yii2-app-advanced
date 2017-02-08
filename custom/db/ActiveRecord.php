<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\db;

use yii\db\ActiveRecord as BaseActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Custom implementation of ActiveRecord
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ActiveRecord extends BaseActiveRecord {

    /**
     * Attachs the TimestampBehavior to the ActiveRecord.
     * 
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className()
        ]);
    }

}
