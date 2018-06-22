<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\models\web;

use yii\web\User as BaseUser;

/**
 * @inheritdoc
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends BaseUser {

    /**
     *
     * @var bool
     */
    public $renewOnHit;

    /**
     * @inheritdoc
     * @return IdentityInterface
     */
    public function loginByAccessToken($token) {
        /* @var $identity IdentityInterface */
        $identity = parent::loginByAccessToken($token);
        if ($this->renewOnHit === true && $identity) {
            $identity->renewAuthorization();
        }
        return $identity;
    }

}
