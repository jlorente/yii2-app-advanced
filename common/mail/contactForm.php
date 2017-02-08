<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
use jlorente\helpers\Html;
?>
<!-- Banner Start -->
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="580" style="border-collapse: collapse;">
                <tr>
                    <td>
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td>
                                    <!-- Space -->
                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                        <tr><td style="font-size: 0; line-height: 0;" height="20">&nbsp;</td></tr>
                                    </table>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse: collapse;">
                                        <tr>
                                            <td>
                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td width="40%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Yii::t('email', 'Name') ?>
                                                        </td>
                                                        <td width="60%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Html::encode($model->name) ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td width="40%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Yii::t('email', 'Email') ?>
                                                        </td>
                                                        <td width="60%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Html::encode($model->email) ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <tr>
                                                        <td width="40%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Yii::t('email', 'Phone') ?>
                                                        </td>
                                                        <td width="60%" align="left" style="font-size: 16px; line-height: 34px; font-family:helvetica, Arial, sans-serif; color:#343434;">
                                                            <?= Html::encode($model->phone) ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                                    <!-- Space -->
                                                    <tr><td style="font-size: 0; line-height: 10px;" height="20">&nbsp;</td><td></td></tr>
                                                    <tr>
                                                        <td width="100%" align="left" style="font-size: 15px; line-height: 22px; font-family:helvetica, Arial, sans-serif; color:#777777;">
                                                            <?= Html::encode($model->body) ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Space -->
                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                        <tr><td style="font-size: 0; line-height: 0;" height="30">&nbsp;</td></tr>				
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Banner End -->