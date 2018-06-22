<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace common\models\core\ar;

use Yii;
use common\exceptions\SaveException;

/**
 * 
 * @property Account $account Gets the related Account model. 
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Auth extends base\Auth {

    /**
     * Generates a new access token.
     */
    public function generateAccessToken() {
        $this->access_token = unpack('H*', Yii::$app->security->generateRandomKey(32))[1];
    }

    /**
     * Renews the expiration time.
     */
    public function generateExpirationTime() {
        $this->expires_at = time() + Yii::$app->params['access_token_maxlifetime'];
    }

    /**
     * 
     * @return AccountQuery
     */
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'id']);
    }

    /**
     * Authorizes a user to enter the api.
     * 
     * @param Account $account
     * @param bool $renew
     * @return string The authorized access token.
     * @throws SaveException
     */
    public static function authorize(Account $account, $renew = false) {
        $auth = static::findOne(['id' => $account->id]);
        if ($auth === null) {
            $auth = new static(['id' => $account->id]);
            $auth->generateAccessToken();
        } elseif ($renew === true) {
            $auth->generateAccessToken();
        }
        $auth->generateExpirationTime();
        if ($auth->save() === false) {
            throw new SaveException($auth);
        }
        return $auth;
    }

}

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AuthQuery extends ActiveQuery {
    
}
