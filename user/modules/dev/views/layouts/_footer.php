<?php

use yii\helpers\Url;

?>
<footer class="footer">
    <div class="container container--body">
        <a href="<?= Url::to(['manual']) ?>" class="footer__link">
            Руководство пользователя
        </a>
        <a href="<?= Url::to(['support']) ?>" class="footer__link">
            Тех.поддержка
        </a>
    </div>
</footer>