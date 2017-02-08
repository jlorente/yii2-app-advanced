<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@main/views/layouts/frame.php');
?>
<?= $this->render('@main/views/layouts/sections/header') ?>
<div class="container">
    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
<?= $this->render('@main/views/layouts/sections/footer') ?>
<?php
$this->endContent();
