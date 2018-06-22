<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\modules\v1\modules\location\controllers;

use api\rest\ActiveController;

/**
 * Location Controller API
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class LocationController extends ActiveController {

    public $modelClass = 'jlorente\location\db\Location';

}
