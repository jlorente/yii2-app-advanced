<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\web\View;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

/* @var $this View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/frame.php');
?>
<?= $this->render('@frontend/views/layouts/sections/header') ?>
<div class="container">
    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
<?= $this->render('@frontend/views/layouts/sections/footer') ?>
<?php
$this->endContent();
