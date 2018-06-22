<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\rest;

use yii\rest\ActiveController as BaseActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;

/**
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ActiveController extends BaseActiveController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'authenticator' => [
                        'class' => HttpBearerAuth::className()
                    ]
        ]);
    }

}
