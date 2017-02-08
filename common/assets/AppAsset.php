<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Common asset of the application.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AppAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/assets/app';

    /**
     * @inheritdoc
     */
    public $css = [
        'custom.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'custom.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset'
        , 'yii\bootstrap\BootstrapPluginAsset'
    ];

}
