<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\modules\v1\controllers\auth;

use yii\rest\OptionsAction as BaseOptionsAction;

/**
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class OptionsAction extends BaseOptionsAction {

    /**
     * @var array the HTTP verbs that are supported by the collection URL
     */
    public $collectionOptions = [];

    /**
     * @var array the HTTP verbs that are supported by the resource URL
     */
    public $resourceOptions = ['POST', 'OPTIONS'];

}
