<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\modules\v1\controllers;

use api\rest\ActiveController;

/**
 * User Controller API
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class UserController extends ActiveController {

    public $modelClass = 'common\models\core\ar\User';

}
