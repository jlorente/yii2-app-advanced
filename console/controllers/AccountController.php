<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @copyright	Participae <https://participae.com>
 * @version     1.0
 */

namespace console\controllers;

use custom\console\Controller;
use console\models\user\CreateForm;
use Yii;
use common\models\core\PasswordSetForm;

/**
 * Console controller with actions related to accounts and users.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccountController extends Controller {

    /**
     * Action used to create a user. You will be prompted step by step to 
     * introduce the params of the new user.
     */
    public function actionCreate() {
        $model = new CreateForm();

        $emailValidator = function($input, &$error) use ($model) {
            $model->email = $input;
            if ($model->validate(['email']) === false) {
                $error = $model->getFirstError('email');
                $model->clearErrors('email');
                return false;
            } else {
                return true;
            }
        };
        $usernameValidator = function($input, &$error) use ($model) {
            $model->username = $input;
            if ($model->validate(['username']) === false) {
                $error = $model->getFirstError('username');
                $model->clearErrors('username');
                return false;
            } else {
                return true;
            }
        };
        $this->prompt(Yii::t('user_creation', 'Please enter the user email: '), [
            'required' => true,
            'validator' => $emailValidator
        ]);
        $this->prompt(Yii::t('user_creation', 'Please enter the username: '), [
            'required' => true,
            'validator' => $usernameValidator
        ]);
        while (true) {
            $model->password = $this->prompt(Yii::t('user_creation', 'Enter a password: '), [
                'required' => true,
            ]);
            $model->password_check = $this->prompt(Yii::t('user_creation', 'Retype the password: '), [
                'required' => true,
            ]);

            if ($model->validate(['password']) === false) {
                echo $model->getFirstError('password') . PHP_EOL;
                continue;
            }
            if ($model->validate(['password_check']) === false) {
                echo $model->getFirstError('password_check') . PHP_EOL;
                continue;
            }
            break;
        }

        $roleValidator = function($input, &$error) use ($model) {
            $model->role = $input;
            if ($model->validate(['role']) === false) {
                $error = $model->getFirstError('role');
                return false;
            } else {
                return true;
            }
        };
        $this->prompt(Yii::t('user_creation', 'Please enter the user role [1 => User, 2 => Moderator, 4 => Admin]: '), [
            'required' => true,
            'validator' => $roleValidator
        ]);

        if ($model->save() === false) {
            echo Yii::t('user_creation', 'A problem ocurred creating the user');
        } else {
            echo Yii::t('user_creation', 'User created successfully');
        }
        echo PHP_EOL;
    }

    /**
     * Use this action to change the password of an account.
     * The id of the account must be provided on call.
     * 
     * @param int $id
     */
    public function actionChangePass($id) {
        $model = new PasswordSetForm();
        if ($model->loadAccount($id) === false) {
            return 'Account with id[' . $id . '] doesn\'t exist';
        }
        $this->prompPasswords($model);
        if ($model->save() === false) {
            echo Yii::t('user_creation', 'A problem ocurred while changing the user password');
        } else {
            echo Yii::t('user_creation', 'Account password changed successfully');
        }
        echo PHP_EOL;
    }

    /**
     * Use this action to change all of the account passwords. This method MUST 
     * NOT be used in the production environment.
     */
    public function actionChangeAllPasswords() {
        $model = new PasswordSetForm();
        $this->prompPasswords($model);

        if ($model->saveMassive()) {
            echo Yii::t('user_creation', 'Accounts passwords changed successfully');
        } else {
            echo Yii::t('user_creation', 'A problem ocurred while changing passwords');
        }
        echo PHP_EOL;
    }

    /**
     * Prompts the console user to enter the passwords.
     * 
     * @param PasswordSetForm $model
     */
    protected function prompPasswords(PasswordSetForm $model) {
        while (true) {
            $model->password = $this->prompt(Yii::t('user_creation', 'Enter a password: '), [
                'required' => true,
            ]);
            $model->password_check = $this->prompt(Yii::t('user_creation', 'Retype the password: '), [
                'required' => true,
            ]);

            if ($model->validate(['password']) === false) {
                echo $model->getFirstError('password') . PHP_EOL;
                continue;
            }
            if ($model->validate(['password_check']) === false) {
                echo $model->getFirstError('password_check') . PHP_EOL;
                continue;
            }
            break;
        }
    }

}
