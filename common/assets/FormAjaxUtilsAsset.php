<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace common\assets\formAjaxUtils;

use yii\web\AssetBundle;

/**
 * Description of FormDataGetterAsset
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class FormAjaxUtilsAsset extends AssetBundle {

    public $sourcePath = '@custom/assets/formAjaxUtils';
    public $js = [
        'FormAjaxUtils.js',
    ];

}
