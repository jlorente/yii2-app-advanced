<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

use yii\web\UploadedFile;
use custom\db\exceptions\SaveException;
use Exception;
use common\exceptions\FileException;
use Yii;
use Imagick;
use yii\log\Logger;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait ImageUploadTrait {

    /**
     *
     * @var UploadedFile 
     */
    public $image;

    /**
     *
     * @var int 
     */
    public $image_deleted;

    /**
     * @inheritdoc
     */
    public function imageRules() {
        return [
            ['image', 'image', 'extensions' => 'png, jpg, gif', 'maxSize' => 4 * 1024 * 1024],
            ['image_deleted', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function imageAttributeLabels() {
        return [
            'image' => Yii::t('item', 'Imagen')
        ];
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null) {
        if (parent::load($data, $formName)) {
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null) {
        $trans = $this->getDb()->beginTransaction();
        try {
            if (parent::save($runValidation, $attributeNames) === false) {
                throw new SaveException($this);
            }
            if ($this->image !== null) {
                $this->resizeAndUpload();
            } else if ($this->image_deleted) {
                $this->deleteImage();
            }

            $trans->commit();
            return true;
        } catch (Exception $ex) {
            $trans->rollback();
            Yii::getLogger()->log($ex->getMessage(), Logger::LEVEL_ERROR, 'file-upload');
            return false;
        }
    }

    /**
     * Resizes the image and uploads the image.
     * 
     * @throws FileException
     */
    protected function resizeAndUpload() {
        $this->deleteImage();
        $image = new Imagick($this->image->tempName);
        $w = $this->width();
        $h = $this->height();
        if ($w || $h) {
            $image->resizeImage($this->width(), $this->height(), Imagick::FILTER_LANCZOS, 1, !$this->width() || !$this->height() ? false : true);
        }
        $dir = Yii::getAlias(Yii::$app->params['uploadsPath'] . DIRECTORY_SEPARATOR . $this->uploadsPrefix());
        $name = $this->uploadsPrefix() . DIRECTORY_SEPARATOR . $this->getImageBaseName() . '.' . $this->image->extension;
        if (file_exists($dir) === false && @mkdir($dir, 0777, true) === false) {
            $this->addError('image', Yii::t('item', 'El directorio para crear la imagen no ha podido ser creado.'));
            throw new FileException('Error ocurred when creating the directory.');
        }
        if ($image->writeImage(Yii::getAlias(Yii::$app->params['uploadsPath'] . $name)) === false) {
            $this->addError('image', Yii::t('item', 'No se ha conseguido escribir la imagen en el disco.'));
            throw new FileException('An error has ocurred when writting the image to disk.');
        }
        $image->destroy();
        $this->img_path = $name;
        if ($this->update(['img_path']) === false) {
            throw new SaveException($this);
        }
    }

    /**
     * 
     * @return string
     */
    public function getImageUrl() {
        return empty($this->img_path) ? null : (Yii::$app->params['uploadsUrl'] . $this->img_path);
    }

    /**
     * Deletes the stored image.
     * 
     * @throws FileException
     */
    public function deleteImage() {
        if ($this->img_path !== null) {
            $path = Yii::getAlias(Yii::$app->params['uploadsPath'] . $this->img_path);
            if (@unlink($path) === false) {
                $this->addError('image', Yii::t('item', 'No se ha podido eliminar la imagen anterior.'));
                throw new FileException('An error has ocurred when deleting the last uploaded image.');
            }
            $this->img_path = null;
            if ($this->update(['img_path']) === false) {
                throw new SaveException($this);
            }
        }
    }

    /**
     * Gets the name for storing the image.
     * 
     * @return string
     */
    public function getImageBaseName() {
        return (string) md5(uniqid() . time());
    }

    /**
     * @inheritdoc
     */
    public function delete() {
        $this->deleteImage();
        return parent::delete();
    }

    /**
     * Returns the prefix where to upload the images in the uploads path.
     * 
     * @return string
     */
    abstract public function uploadsPrefix();

    /**
     * Returns the width of the image.
     * 
     * @return integer
     */
    abstract public function width();

    /**
     * Returns the height of the image.
     * 
     * @return integer
     */
    abstract public function height();
}
