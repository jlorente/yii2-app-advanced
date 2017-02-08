<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

use yii\db\ActiveQuery;
use Yii;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class File extends base\File {

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['name', 'path', 'mime_type'], 'trim']
        ]);
    }

    /**
     * 
     * @return string
     */
    public function getUrl() {
        return empty($this->path) ? null : (Yii::$app->params['uploadsUrl'] . $this->path);
    }

    /**
     * 
     * @return FileQuery
     */
    public static function find() {
        return Yii::createObject(FileQuery::className(), [get_called_class()]);
    }

}

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class FileQuery extends ActiveQuery {
    
}
