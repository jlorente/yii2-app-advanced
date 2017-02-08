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

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'created_at' => Yii::t('core', 'Created At'),
            'created_by' => Yii::t('core', 'Created By'),
            'updated_at' => Yii::t('core', 'Updated At'),
            'updated_by' => Yii::t('core', 'Updated By'),
            'deleted_at' => Yii::t('core', 'Deleted At'),
            'deleted_by' => Yii::t('core', 'Deleted By')
        ];
    }

}
