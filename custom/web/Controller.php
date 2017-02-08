<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\web;

use yii\web\Controller as BaseController;
use yii\web\BadRequestHttpException;
use Yii;
use yii\web\Response;

/**
 * Custom controller class to extend yii web controller with custom behaviors.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class Controller extends BaseController {

    /**
     * Filters an ajax request.
     * 
     * @throws BadRequestHttpException
     */
    public function filterAjaxRequest() {
        if (Yii::$app->request->isAjax === false) {
            throw new BadRequestHttpException('The action requested is only available for ajax requests');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

}
