<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $account common\models\core\ar\Account */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $account->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($account->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
