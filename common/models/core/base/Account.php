<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core\base;

use Yii;

/**
 * This is the model class for table "cor_account".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Account extends \custom\db\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cor_account';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['status', 'role', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['username', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('core', 'ID'),
            'username' => Yii::t('core', 'Username'),
            'auth_key' => Yii::t('core', 'Auth Key'),
            'password_hash' => Yii::t('core', 'Password Hash'),
            'password_reset_token' => Yii::t('core', 'Password Reset Token'),
            'status' => Yii::t('core', 'Status'),
            'role' => Yii::t('core', 'Role'),
            'created_at' => Yii::t('core', 'Created At'),
            'created_by' => Yii::t('core', 'Created By'),
            'updated_at' => Yii::t('core', 'Updated At'),
            'updated_by' => Yii::t('core', 'Updated By'),
        ];
    }
}
