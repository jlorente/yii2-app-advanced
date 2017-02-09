<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace frontend\controllers;

use custom\web\Controller as BaseController;

/**
 * Custom controller class to extend yii web controller with custom behaviors.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class Controller extends BaseController {

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->layout = '@frontend/views/layouts/main';
    }
}
