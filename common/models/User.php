<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models;

use yii\base\Model;
use common\models\core\ar\Account;

/**
 * Represents an application user with its correspondign session id.
 * 
 * This model is used in order to avoid the use of the web User model in shared 
 * models along the different applications, including the Console application 
 * that MUST know nothing about the web User.
 * 
 * The sessionId property can be any unique identificator that identifies this 
 * user object.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends Model {

    /**
     * A unique string identificating this object.
     * 
     * @var string
     */
    public $sessionId;

    /**
     * The application Account.
     * 
     * @var Account
     */
    protected $account;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sessionId'], 'required']
            , ['sessionId', 'string']
        ];
    }

    /**
     * Sets the Account model.
     * 
     * @param Account $account
     */
    public function setAccount(Account $account = null) {
        $this->account = $account;
    }

    /**
     * Gets the Account model.
     * 
     * @return Account
     */
    public function getAccount() {
        return $this->account;
    }

    /**
     * Gets an array with the application account id and the sessionId property.
     * 
     * @return array
     */
    public function getFilterParams() {
        return [
            'account_id' => $this->account->id
            , 'session_id' => $this->sessionId
        ];
    }

}
