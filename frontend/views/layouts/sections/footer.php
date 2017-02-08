<?php
/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */
?>
<!-- footer start -->
<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <?=
            Yii::t('general', 'Copyright {symbol} {date} {appName}. All Rights Reserved.', [
                'symbol' => '&copy;'
                , 'date' => date('Y')
                , 'appName' => Yii::$app->name
            ])
            ?>
        </p>
    </div>
</footer>
<!-- footer end -->
