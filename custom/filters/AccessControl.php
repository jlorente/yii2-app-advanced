<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\filters;

use yii\filters\AccessControl as YiiAccessControl;

/**
 * AccessControl class to extend yii AccessControl class with custom behaviors.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccessControl extends YiiAccessControl {

    /**
     * @var array the default configuration of access rules. Individual rule configurations
     * specified via [[rules]] will take precedence when the same property of the rule is configured.
     */
    public $ruleConfig = ['class' => 'custom\filters\AccessRule'];

}
