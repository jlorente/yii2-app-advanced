<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace frontend\models\web;

use custom\web\View as BaseView;
use yii\helpers\Url;
use Yii;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class View extends BaseView {

    public $locale = 'es_ES';
    public $type = 'website';
    public $siteName;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->locale = 'es_ES';
        $this->type = 'website';
        $this->siteName = Yii::$app->name;

        $this->description = '';
        $this->title = '';

        $this->on(self::EVENT_END_BODY, function($event) {
            $this->loadDefaults();
        });
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function loadDefaults() {
        if (empty($this->ogImages)) {
            $this->ogImages = [
            ];
        }
        if (empty($this->twitter)) {
            $this->twitter = [
                'card' => '',
                'site' => '',
                'creator' => '',
                'image:src' => Url::toRoute('', true)
            ];
        }
    }

}
