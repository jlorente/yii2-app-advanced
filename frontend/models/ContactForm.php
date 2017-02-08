<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\log\Logger;
use jlorente\captcha\CaptchaValidator;

/**
 * ContactForm is the model behind the contact form.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ContactForm extends Model {

    public $name;
    public $email;
    public $phone;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email', 'body'], 'required']
            , [['name', 'email', 'phone'], 'string', 'max' => 100]
            , ['body', 'string', 'max' => 1000]
            , ['email', 'email']
            , ['verifyCode', CaptchaValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email) {
        try {
            return Yii::$app->mailer->compose('contactForm', ['model' => $this])
                            ->setTo($email)
                            ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::t('email', 'No Reply {appName}', [
                                    'appName' => Yii::$app->name
                        ])])
                            ->setSubject(Yii::t('contact', '{appName} contact form', [
                                        'appName' => Yii::$app->name
                            ]))
                            ->send();
        } catch (\Exception $ex) {
            Yii::getLogger()->log($ex->getMessage(), Logger::LEVEL_ERROR, 'contactMail');
            return false;
        }
    }

}
