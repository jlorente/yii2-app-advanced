<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\core\ar\Account;

/**
 * Password reset form
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ResetPasswordForm extends Model {

    public $password;

    /**
     * @var Account
     */
    private $_account;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_account = Account::findByPasswordResetToken($token);
        if (!$this->_account) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword() {
        $account = $this->_account;
        $account->setPassword($this->password);
        $account->removePasswordResetToken();

        return $account->save(false);
    }

}
