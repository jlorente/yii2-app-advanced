<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace console\models\core;

use yii\base\Model;
use yii\base\InvalidParamException;
use Yii;
use jlorente\location\exceptions\SaveException;
use common\models\core\ar\File;

/**
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class FileIntegrator extends Model {

    /**
     *
     * @var Model 
     */
    public $attachTo;

    /**
     *
     * @var string 
     */
    public $name;

    /**
     *
     * @var string
     */
    public $filePath;

    /**
     * Integrates the file and attach it to the model.
     * 
     * @throws InvalidParamException
     * @throws SaveException
     */
    public function integrate() {
        $f = $this->getFullPath();
        if (file_exists($f) === false) {
            throw new InvalidParamException('File [' . $f . '] doesn\'t exist');
        }

        $f = explode('/', $this->filePath);
        end($f);
        $fName = current($f);
        if ($this->name === null) {
            list($name, $extension) = explode('.', $fName);
        } else {
            $name = $this->name;
        }
        $file = new File([
            'name' => $name,
            'mime_type' => mime_content_type($this->getFullPath()),
            'path' => $this->filePath
        ]);
        if ($file->save() === false) {
            throw new SaveException($file);
        }
        if (!empty($this->attachTo)) {
            $this->attachTo->link('files', $file);
        }
    }

    /**
     * 
     * @return string
     */
    protected function getFullPath() {
        return Yii::getAlias(Yii::$app->params['uploadsPath'] . $this->filePath);
    }

}
