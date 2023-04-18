<?php

$this->title = "Валидатор рабочих мест";

?>

<div>
    <h3>Валидация рабочего места</h3>
    <p style="color: <?= $response['color'] ?>"><?= $response['text'] ?></p>
    <?php if(!empty($response['success']) && $response['success']): ?>
    <p><b>Внимание:</b> в случае переустановки ОС, удаления или очистики браузера - валидация будет обнулена.</p>
    <?php endif; ?>
</div>
