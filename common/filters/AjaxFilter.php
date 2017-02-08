<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\BadRequestHttpException;

/**
 * Grant access only to ajax requests.
 * 
 * You may use AjaxFilter filter by attaching it as a behavior to a controller 
 * or module, like the following,
 * 
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'ajaxFilter' => [
 *             'class' => \yii\filters\AjaxFilter::className(),
 *         ]
 *     ];
 * }
 * ```
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AjaxFilter extends ActionFilter {

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (Yii::$app->request->isAjax === false) {
            throw new BadRequestHttpException();
        }
        return parent::beforeAction($action);
    }

}
