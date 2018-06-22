<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\models\user;

use common\models\core\ar\Auth;
use common\models\core\ar\Account as BaseAccount;
use api\models\web\IdentityInterface;

/**
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Account extends BaseAccount implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        /* @var $auth Auth */
        $auth = $this->getAuth()->andWhere(['and', ['access_token' => $token], ['>=', 'expires_at', time()]])->one();
        return !$auth ? null : ($auth->account->status === Account::STATUS_ACTIVE ? $auth->account : null);
    }

    /**
     * @inheritdoc
     */
    public function renewAuthorization() {
        return Auth::authorize($this, true);
    }

    /**
     * @inheritdoc
     */
    public function renewExpirationTime() {
        return Auth::authorize($this, false);
    }

}
