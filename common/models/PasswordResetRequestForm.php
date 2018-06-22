<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\core\ar\Account;

/**
 * Password reset request form
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class PasswordResetRequestForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * Exists email validator.
     * 
     * @return bool
     */
    public function validateEmail() {
        if (Account::find()
                        ->filterByEmail(['email' => $this->email])
                        ->active()
                        ->exists() === false) {
            $this->addError('email', Yii::t('account', 'There is no user with this email address.'));
            return false;
        } else {
            return true;
        }
    }

    /**
     * @todo Filter by User and Account
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail() {
        $account = Account::find()
                ->filterByEmail(['email' => $this->email])
                ->active()
                ->one();

        if ($account) {
            if (!Account::isPasswordResetTokenValid($account->password_reset_token)) {
                $account->generatePasswordResetToken();
            }

            if ($account->save()) {
                return $this->doSendMail($account);
            }
        }

        return false;
    }

    /**
     * Performs the action of sending the mail to the user.
     * 
     * @param Account $account
     * @return boolean
     */
    protected function doSendMail(Account $account) {
        try {
            return Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['account' => $account])
                            ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::t('email', 'No Reply {appName}', [
                                    'appName' => Yii::$app->name
                        ])])
                            ->setTo($this->email)
                            ->setSubject(Yii::t('contact', 'Reset your password of {appName}', [
                                        'appName' => Yii::$app->name
                            ]))
                            ->send();
        } catch (\Exception $ex) {
            Yii::getLogger()->log($ex->getMessage(), Logger::LEVEL_ERROR, 'passwprdResetRequestFormMail');
            return false;
        }
    }

}
