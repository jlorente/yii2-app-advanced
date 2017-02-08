<?php

/**
 * @author      José Lorente <jl@bytebox.es>
 * @version     1.0
 */

namespace custom\filters;

use yii\filters\AccessRule as YiiAccessRule;
use common\models\users\Role;

/**
 * AccessRule class to extend yii AccessRule class with custom behaviors.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccessRule extends YiiAccessRule {

    /**
     * @var array list of platform roles that this rule applies to.
     * @see Role
     *
     * If this property is not set or empty, it means this rule applies to all roles.
     */
    public $userRoles;

    /**
     * @see http://www.yiiframework.com/doc-2.0/yii-filters-accessrule.html#allows()-detail
     * 
     * Extends allows method with user role check
     */
    public function allows($action, $user, $request) {
        if (parent::allows($action, $user, $request) !== null && $this->matchUserRoles($user)) {
            return $this->allow ? true : false;
        }
        return null;
    }

    /**
     * Matches the web User object against the specified platform roles.
     * 
     * @param \custom\web\User $user
     * @return bool
     */
    public function matchUserRoles($user) {
        if (empty($this->userRoles)) {
            return true;
        }

        foreach ($this->userRoles as $role) {
            if ($user->identity->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

}
