<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

/**
 * Trait to be used in ActiveRecord classes that create objects that can be 
 * related to different type of resources.
 * 
 * @property mixed $resource The resource to which the object is attached.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait AttachableResourceTrait {

    /**
     * Gets the attached resource.
     * 
     * @return mixed The resource attached to this object.
     */
    public function getResource() {
        $class = $this->{$this->getResourceClassFieldName()};
        return $this->hasOne($class::className(), [$this->getResourceForeignKeyName() => $this->getResourceIdFieldName()]);
    }

    /**
     * Returns the name of the field that stores the resource class that owns 
     * the current object.
     * Override this method in order to provide your custom field name.
     * 
     * @return string
     */
    protected function getResourceClassFieldName() {
        return 'resource_class';
    }

    /**
     * Returns the name of the field that stores the resource id that owns 
     * the current object.
     * Override this method in order to provide your custom field name.
     * 
     * @return string
     */
    protected function getResourceIdFieldName() {
        return 'resource_id';
    }

    /**
     * Returns the name of the resource foreign key name.
     * Override this method in order to provide your custom field name.
     * 
     * @return string
     */
    protected function getResourceForeignKeyName() {
        return 'id';
    }

}
