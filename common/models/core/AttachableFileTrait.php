<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

use common\models\core\ar\File,
    common\models\core\ar\FileQuery;

/**
 * Trait to be used in ActiveRecord classes whose instances can be attached with 
 * files.
 * 
 * @property File[] $files The files attached to the object.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait AttachableFileTrait {

    /**
     * 
     * @return FileQuery
     */
    public function getFiles() {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
                        ->viaTable('cor_resource_file', ['resource_id' => 'id'], function($query) {
                            $query->andWhere(['cor_resource_file.class' => __CLASS__]);
                        });
    }

    /**
     * @inheritdoc
     */
    public function link($name, $model, $extraColumns = []) {
        if ($name === 'files') {
            $extraColumns['class'] = __CLASS__;
        }
        return parent::link($name, $model, $extraColumns);
    }

}
