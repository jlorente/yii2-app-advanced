<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\exceptions;

use yii\helpers\Json;
use yii\db\ActiveRecord;

/**
 * Exception thrown on failed saving operations.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class SaveException extends \yii\base\Exception {

    /**
     *
     * @var ActiveRecord
     */
    protected $model;

    /**
     * Constructor of the exception.
     * 
     * @param ActiveRecord $aRecord
     * @param \Exception $previous
     */
    public function __construct(ActiveRecord $aRecord, \Exception $previous = null) {
        $message = 'Unable to save ' . get_class($aRecord) . '. Errors: [' . Json::encode($aRecord->getErrors()) . ']';
        $this->model = $aRecord;
        parent::__construct($message, 1100, $previous);
    }

    /**
     * Returns the model that generated the error.
     * 
     * @return ActiveRecord
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function getName() {
        return 'SaveException';
    }

}
