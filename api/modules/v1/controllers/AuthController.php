<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use api\modules\v1\controllers\auth\OptionsAction;
use api\modules\v1\models\AuthForm;
use yii\web\UnauthorizedHttpException;

/**
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AuthController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'options' => [
                'class' => OptionsAction::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function verbs() {
        return [
            'index' => ['POST'],
        ];
    }

    /**
     * Performs the authorization.
     * 
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionCreate() {
        $model = new AuthForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $auth = $model->login();
        if ($auth === false) {
            throw new UnauthorizedHttpException('Authentication error ocurred.');
        }
        return [
            'access_token' => $auth->access_token,
            'expires_at' => $auth->expires_at
        ];
    }

}
