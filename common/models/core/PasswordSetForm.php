<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace common\models\core;

use Yii;
use yii\base\Model;

/**
 * Model used to change user password.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class PasswordSetForm extends Model {

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $password_check;

    /**
     *
     * @var Account
     */
    protected $account;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_check', 'required'],
            ['password_check', 'string', 'min' => 6],
            ['password_check', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('signup', "Passwords don't match")],
        ];
    }

    /**
     * Loads the account model by the given id.
     * 
     * @param int $id
     * @return boolean
     */
    public function loadAccount($id) {
        $account = Account::findOne($id);
        if ($account === null) {
            return false;
        }
        $this->account = $account;
        return true;
    }

    /**
     * Persists the changed password.
     * 
     * @return boolean
     */
    public function save() {
        if ($this->validate()) {
            $this->account->setPassword($this->password);
            return $this->account->save();
        }
        return false;
    }

    /**
     * Updates all the platforms passwords.
     * 
     * @return int
     */
    public function saveMassive() {
        $this->account = Account::find()->one();
        $this->save();

        return Account::updateAll(['password_hash' => $this->account->password_hash]);
    }

    /**
     * Gets the account model.
     * 
     * @return Account
     */
    public function getAccount() {
        return $this->account;
    }

}
