<?php

namespace common\models\core\base;

use Yii;

/**
 * This is the model class for table "cor_user".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class User extends \custom\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cor_user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['slug'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['name', 'last_name', 'phone', 'mobile', 'email'], 'string', 'max' => 255],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('user', 'ID'),
            'slug' => Yii::t('user', 'Slug'),
            'email' => Yii::t('user', 'Email'),
            'name' => Yii::t('user', 'Name'),
            'last_name' => Yii::t('user', 'Last Name'),
            'phone' => Yii::t('user', 'Phone'),
            'mobile' => Yii::t('user', 'Mobile'),
            'created_at' => Yii::t('user', 'Created At'),
            'created_by' => Yii::t('user', 'Created By'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'updated_by' => Yii::t('user', 'Updated By'),
        ];
    }

}
