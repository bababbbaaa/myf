<div class="banks-popup-row">
    <?php if (!empty($popupdata->incomes) && $popupdata->incomes !== '[]'): ?>
        <?php foreach (json_decode($popupdata->incomes, 1) as $k => $v): ?>
            <?php $arr = json_decode($v, 1) ?>
            <div class="banks-popup-row-item">
                <button data-id="<?= $popupdata->id ?>" data-bank="<?= $k ?>" class="banks-popup-row-item--btn incomes--remove">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z"
                              fill="red"/>
                    </svg>
                </button>
                    <p><?= $arr['name'] ?></p>
                    <p><?= $arr['summ'] ?>руб.</p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: black">Информация о доходах отсутствует</p>
    <?php endif; ?>
</div>

<div class="banks--set-card-inputs">
    <input id="bank_count" style="width: 48%;" class="input-case input-t" type="text" placeholder="Вид дохода" name="incomes_name">
    <input id="" style="width: 48%;" class="input-case input-t" type="number" placeholder="Сумма" name="incomes_summ">
</div>

<button data-id="<?= $popupdata->id ?>" class="btn--orange incomes--set-add">Добавить</button>