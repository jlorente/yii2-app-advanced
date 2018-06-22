<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace custom\web;

use Yii;
use yii\web\ErrorAction as BaseErrorAction;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class ErrorAction extends BaseErrorAction {

    /**
     * @inheritdoc
     */
    protected function getViewRenderParams() {
        return array_merge(parent::getViewRenderParams(), [
            'code' => $this->getExceptionCode()
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function getExceptionMessage() {
        if ($this->getExceptionCode() === 404) {
            $message = Yii::t('error', 'Ooops! Page Not Found');
        } else {
            $message = parent::getExceptionMessage();
        }
        return $message;
    }

}
