<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace custom\web;

use yii\web\IdentityInterface as BaseIdentityInterface;

/**
 * IdentityInterface is the interface that should be implemented by a class providing identity information.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
interface IdentityInterface extends BaseIdentityInterface {

    /**
     * Checks if the user owns the rol or not.
     * 
     * @param boolean $role
     * @return boolean True if the identity owns the given rol or false otherwise.
     */
    public function hasRol($role);
}
