<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
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
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return $this->doSendMail($user);
            }
        }

        return false;
    }

    /**
     * Performs the action of sending the mail to the user.
     * 
     * @param User $user
     * @return boolean
     */
    protected function doSendMail(User $user) {
        try {
            return Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
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
