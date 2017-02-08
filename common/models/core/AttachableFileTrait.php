<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

/**
 * 
 */
trait AttachableFileTrait {

    /**
     * 
     * @return FileQuery
     */
    public function getFiles() {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
                        ->viaTable('cor_resource_file', ['resource_id' => 'id'], function($query) {
                            $query->andWhere(['cor_resource_file.class' => get_called_class()]);
                        });
    }

    /**
     * @inheritdoc
     */
    public function link($name, $model, $extraColumns = []) {
        if ($name === 'files') {
            $extraColumns['class'] = get_called_class();
        }
        return parent::link($name, $model, $extraColumns);
    }

}
