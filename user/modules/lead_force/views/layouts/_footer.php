<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<footer class="footer">
  <div class="container container--body">
    <a href="<?= Url::to(['usermanual']) ?>" class="footer__link">
      Руководство пользователя
    </a>
    <a href="<?= Url::to(['support']) ?>" class="footer__link">
      Тех.поддержка
    </a>
  </div>
</footer>