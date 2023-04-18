<?php

?>

<p class="order-lid__box-title"><?= $cards['title'] ?></p>
<p class="order-lid__box-tex">
  <?= $cards['subtitle'] ?>
</p>
<?php if (!empty($cards['infoCheck'])) : ?>
  <?php foreach ($cards['infoCheck'] as $k => $v) : ?>
    <div class="check__item">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM1.38477 9.00033C1.38477 13.2062 4.79429 16.6157 9.00015 16.6157C13.206 16.6157 16.6155 13.2062 16.6155 9.00033C16.6155 4.79447 13.206 1.38495 9.00015 1.38495C4.79429 1.38495 1.38477 4.79447 1.38477 9.00033Z" fill="#278940" />
        <path d="M5.25184 8.88472C4.99206 8.58244 4.54081 8.55181 4.24392 8.81631C3.94704 9.0808 3.91695 9.54027 4.17673 9.84255L6.67673 12.7516C6.95415 13.0745 7.44431 13.0839 7.73358 12.7721L13.805 6.22664C14.0759 5.93462 14.063 5.47433 13.7762 5.19854C13.4894 4.92275 13.0373 4.9359 12.7664 5.22791L7.23446 11.1918L5.25184 8.88472Z" fill="#278940" />
      </svg>
      <?php if ($k == 'script') : ?>
        <p style="color: #009225" class="check__item-text"><?= $v ?></p>
      <?php else : ?>
        <p class="check__item-text"><?= $v ?></p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>