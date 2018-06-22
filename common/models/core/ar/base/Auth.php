<?php

namespace common\models\core\ar\base;

use Yii;

/**
 * This is the model class for table "cor_auth".
 *
 * @property integer $id
 * @property string $access_token
 * @property integer $expires_at
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Auth extends \custom\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cor_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'access_token'], 'required'],
            [['id', 'expires_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['access_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('core', 'ID'),
            'access_token' => Yii::t('core', 'Access Token'),
            'expires_at' => Yii::t('core', 'Expires At'),
            'created_at' => Yii::t('core', 'Created At'),
            'created_by' => Yii::t('core', 'Created By'),
            'updated_at' => Yii::t('core', 'Updated At'),
            'updated_by' => Yii::t('core', 'Updated By'),
        ];
    }

}
