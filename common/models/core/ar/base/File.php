<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core\ar\base;

use Yii;

/**
 * This is the model class for table "cor_file".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $mime_type
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class File extends \custom\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cor_file';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['path', 'mime_type'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path', 'mime_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('file', 'ID'),
            'name' => Yii::t('file', 'Name'),
            'path' => Yii::t('file', 'Path'),
            'mime_type' => Yii::t('file', 'Mime Type'),
            'created_at' => Yii::t('file', 'Created At'),
            'created_by' => Yii::t('file', 'Created By'),
            'updated_at' => Yii::t('file', 'Updated At'),
            'updated_by' => Yii::t('file', 'Updated By'),
        ];
    }

}
