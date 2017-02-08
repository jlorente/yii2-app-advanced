<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\web\View;
use jlorente\helpers\Html;

/* @var $this View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <?= $code === 404 ? Html::tag('p', Yii::t('error', 'The requested URL was not found on this server. Make sure that the Web site address displayed in the address bar of your browser is spelled and formatted correctly.')) : '' ?>
    <?= Html::a(Yii::t('error', 'Return Home') . Html::font('fa fa-home'), ['/'], ['class' => 'btn btn-default btn-animated btn-lg']) ?>
</div>
