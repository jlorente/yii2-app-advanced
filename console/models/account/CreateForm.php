<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @copyright   Gabinete Jurídico y de Transportes <https://portalabogados.es>
 * @version     1.0
 */

namespace console\models\user;

use yii\base\Model;
use common\models\core\ar\User,
    common\models\core\ar\Account;
use Yii;
use yii\behaviors\SluggableBehavior;
use common\exceptions\SaveException;

class CreateForm extends Model {

    public $username;
    public $password;
    public $password_check;
    public $role;

    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('signup', 'This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_check', 'required'],
            ['password_check', 'string', 'min' => 6],
            ['password_check', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('signup', 'Passwords don\'t match')],
            ['role', 'required'],
        ];
    }

    public function save() {
        if ($this->validate()) {
            $this->doSave();
        }
        return false;
    }

    /**
     * Performs the save operation.
     * 
     * @return false|Account
     * @throws SaveException
     */
    protected function doSave() {
        $trans = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->email = $this->email;
            if ($user->save(false) === false) {
                throw new SaveException($user);
            }
            $account = new Account();
            $account->id = $user->id;
            $account->username = $this->username;
            $account->setPassword($this->password);
            $account->generateAuthKey();
            if ($account->save(false) === false) {
                throw new SaveException($account);
            }
            $trans->commit();
            return $account;
        } catch (\Exception $ex) {
            $trans->rollBack();
            return false;
        }
    }

    public function attributeLabels() {
        return [
            'password' => Yii::t('signup', 'password'),
            'password_check' => Yii::t('signup', 'password_check'),
            'email' => Yii::t('signup', 'email')
        ];
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::className(),
                'slugAttribute' => 'username',
                'ensureUnique' => true,
                'immutable' => true,
                'value' => function($event) {
                    if ($event->sender->username) {
                        return $event->sender->username;
                    } else {
                        return explode('@', $event->sender->email)[0];
                    }
                },
                'uniqueValidator' => [
                    'targetClass' => User::className()
                ]
            ],
        ]);
    }

}
