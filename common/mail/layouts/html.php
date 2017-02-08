<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use yii\helpers\Html,
    yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="margin: 0; padding: 0;">
        <?php $this->beginBody() ?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <!-- Header Top Start -->
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="580" style="border-collapse: collapse;">
                                    <tr>
                                        <td align="left"  bgcolor="#37322e">
                                            <!-- Space -->
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                                <tr><td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td></tr>
                                            </table>
                                            <table align="center">
                                                <tr>
                                                    <td width="22">
                                                    </td>
                                                    <td style="color: #fff; font-size: 12px; line-height: 18px; font-weight: normal; font-family: helvetica, Arial, sans-serif;"></td>
                                                    <td width="22"></td>
                                                    <td width="22">
                                                    </td>
                                                    <td style="color: #fff; font-size: 12px; line-height: 18px; font-weight: normal; font-family: helvetica, Arial, sans-serif;"></td>
                                                    <td width="22"></td>
                                                    <td width="22">
                                                        <?=
                                                        Html::img($message->embed(Yii::getAlias('@common/mail/images/mail-icon-white.png')), ['alt' => 'Location'])
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?=
                                                        Html::mailto(Yii::$app->params['contactEmail'], Yii::$app->params['contactEmail'], [
                                                            'style' => 'color: #fff; font-size: 12px; line-height: 18px; font-weight: normal; font-family: helvetica, Arial, sans-serif; text-decoration:none;'
                                                        ])
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Space -->
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                                <tr><td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- Header Top End -->

                    <!-- Header Start -->
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td style="padding:15px 0 0 0;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="580" style="border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="200" style="border-collapse: collapse;">
                                                <!-- logo -->
                                                <tr>
                                                    <td align="left">
                                                        <?=
                                                        Html::a(Html::img($message->embed(Yii::getAlias('@common/mail/images/logo.png')), ['alt' => Yii::$app->params['appName'], 'style' => 'display: block;']), Url::to(['/'], true))
                                                        ?>
                                                    </td>
                                                </tr>								
                                                <!-- Space -->
                                                <tr><td style="font-size: 0; line-height: 0;" height="15">&nbsp;</td></tr>
                                            </table>
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="370" style="border-collapse: collapse;">
                                                <tr>
                                                    <td height="75" style="text-align: right; vertical-align: middle;">
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- Header End -->
                    <?= $content ?>
                </td>
            </tr>
        </table>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
