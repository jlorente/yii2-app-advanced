<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\helpers\Html,
    yii\helpers\Url;
use frontend\assets\AppAsset;
use cinghie\cookieconsent\widgets\CookieWidget;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->title = Yii::$app->name . ($this->title !== null ? ' - ' . $this->title : '');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" href="favicon.png">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?=
        CookieWidget::widget([
            'message' => Yii::t('general', '#cookies-policy#'),
            'dismiss' => Yii::t('general', 'Accept'),
            'learnMore' => Yii::t('general', 'More info'),
            'link' => Url::to(['/site/cookies-policy']),
            'theme' => 'light-bottom'
        ])
        ?>
        <!--Floating alert box for ajax alerts -->
        <!--=============== = -->
        <div class="ajax-notification-alert"></div>
        <!--page wrapper start -->
        <!--=============== = -->
        <div class="wrap">
            <?= $content ?>
        </div>
        <!-- page wrapper end -->
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>