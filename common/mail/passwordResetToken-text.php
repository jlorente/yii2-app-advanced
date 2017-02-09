<?php
/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
/* @var $this yii\web\View */
/* @var $user common\models\ar\Account */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $account->password_reset_token]);
?>
Hello <?= $account->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
