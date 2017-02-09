<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\core\ar\Account,
    common\models\core\ar\User;
use common\exceptions\SaveException;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => Account::className(), 'message' => Yii::t('account', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('user', 'This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $trans = Yii::$app->db->beginTransaction();
        try {
            $account = new Account();
            $account->username = $this->username;
            $account->setPassword($this->password);
            $account->generateAuthKey();
            if ($account->save() === false) {
                throw new SaveException($account);
            }

            $user = new User();
            $user->email = $this->email;
            $user->slug = $account->username;
            $user->accountId = $account->id;
            if ($user->save() === false) {
                throw new SaveException($user);
            }

            $trans->commit();
            return $user;
        } catch (\Exception $e) {
            $trans->rollBack();
            throw $e;
        }
    }

}
