<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\modules\v1\models;

use Yii;
use custom\base\Model;
use common\models\core\ar\Account,
    common\models\core\ar\Auth;

/**
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AuthForm extends Model {

    public $username;
    public $password;
    public $client_id;
    private $_account = false;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password', 'client_id'], 'required'],
            // password is validated by validatePassword()
            ['client_id', 'validateClientId'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the client id.
     * 
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateClientId($attribute, $params) {
        if ($this->$attribute !== Yii::$app->params['client_id']) {
            $this->addError($attribute, 'Invalid client id');
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $account = $this->getAccount();
            if (!$account || !$account->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in an account using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Auth::authorize($this->getAccount());
        } else {
            return false;
        }
    }

    /**
     * Finds an account by [[username]]
     *
     * @return Account|null
     */
    public function getAccount() {
        if ($this->_account === false) {
            $this->_account = Account::findByUsername($this->username);
        }

        return $this->_account;
    }

}
