<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Common asset of the main application.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AppAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/assets/app';

    /**
     * @inheritdoc
     */
    public $css = [
        'app.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'common\assets\AppAsset'
    ];

}
