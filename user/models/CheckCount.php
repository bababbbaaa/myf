<?php


namespace user\models;

use Yii;
use common\models\UsersBonuses;

class CheckCount
{
    static function CheckCount($count)
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            $bonuses = UsersBonuses::find()->where(['user_id' => $user])->asArray()->one();
            if (!empty($bonuses)) {
                $material = json_decode($bonuses['additional_materials'], true);
                if ($bonuses['cashback'] == 3 && empty($material)) {
                    switch ($count) {
                        case ($count == null || $count < 70):
                            $cards = ['title' => 'Получите <span>Скрипт продаж эффективной обработки</span>', 'subtitle' => 'Закажите 70 лидов и получите проверенный инструмент для работы ваших операторов'];
                            break;
                        case ($count >= 70 && $count < 90):
                            $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 90 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 4% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки']];
                            break;
                        case ($count >= 90 && $count < 120):
                            $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 120 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 4% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram']];
                            break;
                        case ($count >= 120 && $count < 150):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 150 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram']];
                            break;
                        case ($count >= 150 && $count < 170):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 170 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 170 && $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;

                    }
                } elseif ($bonuses['cashback'] == 3 && in_array('script', $material)){
                    switch ($count) {
                        case ($count === null || $count < 90):
                            $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 90 лидов и получите еще больше процент возрата к следующим заказам'];
                            break;
                        case ($count >= 90 && $count < 120):
                            $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 120 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 4% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram']];
                            break;
                        case ($count >= 120 && $count < 150):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 150 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram']];
                            break;
                        case ($count >= 150 && $count < 170):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 170 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 170 && $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 4 && in_array('script', $material) && !in_array('telegram', $material)){
                    switch ($count) {
                        case ($count === null || $count < 120):
                            $cards = ['title' => 'Получите <span>Автоинформирование</span> о новых лидах в Telegram', 'subtitle' => 'Закажите 120 лидов и получайте уведомления о новых лидах прямо в мессенджере'];
                            break;
                        case ($count >= 120 && $count < 150):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 150 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram']];
                            break;
                        case ($count >= 150 && $count < 170):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 170 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 170 && $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 4 && in_array('telegram', $material)){
                    switch ($count) {
                        case ($count === null || $count < 150):
                            $cards = ['title' => 'Получите <span>Автоинформирование</span> о новых лидах в Telegram', 'subtitle' => 'Закажите 150 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!']];
                            break;
                        case ($count >= 150 && $count < 170):
                            $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 170 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 170 && $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 5 && in_array('telegram', $material) && !in_array('cource', $material)){
                    switch ($count) {
                        case ($count === null || $count < 170):
                            $cards = ['title' => 'Получите <span>Курс для менеджера продаж</span> совершенно бесплатно!', 'subtitle' => 'Закажите 170 лидов и получите <span style="color: #009225">авторский Курс для менеджера продаж</span> для эффективной обработки лидов'];
                            break;
                        case ($count >= 170 && $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж']];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 5 && in_array('cource', $material)){
                    switch ($count) {
                        case ($count === null || $count < 210):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите еще больше процент возрата к следующим заказам'];
                            break;
                        case ($count >= 210 && $count < 250):
                            $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 7% на все последующие заказы!', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 6 && in_array('cource', $material) && !in_array('personal_assistant', $material)){
                    switch ($count) {
                        case ($count === null || $count < 250):
                            $cards = ['title' => '<span>Персональный маркетолог на ваш проект 24/7</span> совершенно бесплатно!', 'subtitle' => 'Закажите 250 лидов и получите персонального маркетолога для  вашего проекта, который проконсультирует вас в любое время'];
                            break;
                        case ($count >= 250 && $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 7% на все последующие заказы!', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 6 && in_array('personal_assistant', $material)){
                    switch ($count) {
                        case ($count === null || $count < 290):
                            $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите еще больше процент возрата к следующим заказам'];
                            break;
                        case ($count >= 290 && $count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                } elseif ($bonuses['cashback'] == 7 && in_array('personal_assistant', $material)){
                    switch ($count) {
                        case ($count < 350):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 350 && $count < 440):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 440 && $count < 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                        case ($count >= 500):
                            $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                            break;
                    }
                }
            } else {
                switch ($count) {
                    case ($count < 50 || $count === null):
                        $cards = ['title' => 'Получите <span>Кэшбек 3%</span> на все заказы', 'subtitle' => 'Закажите 50 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 3% на все последующие заказы!']];
                        break;
                    case ($count >= 50 && $count < 70):
                        $cards = ['title' => 'Получите <span>Кэшбек 3%</span> на все заказы', 'subtitle' => 'Закажите 70 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 3% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки']];
                        break;
                    case ($count >= 70 && $count < 90):
                        $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 90 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 4% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки']];
                        break;
                    case ($count >= 90 && $count < 120):
                        $cards = ['title' => 'Получите <span>Кэшбек 4%</span> на все заказы', 'subtitle' => 'Закажите 120 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 4% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram']];
                        break;
                    case ($count >= 120 && $count < 150):
                        $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 150 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram']];
                        break;
                    case ($count >= 150 && $count < 170):
                        $cards = ['title' => 'Получите <span>Кэшбек 5%</span> на все заказы', 'subtitle' => 'Закажите 170 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 5% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                        break;
                    case ($count >= 170 && $count < 210):
                        $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 210 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж']];
                        break;
                    case ($count >= 210 && $count < 250):
                        $cards = ['title' => 'Получите <span>Кэшбек 6%</span> на все заказы', 'subtitle' => 'Закажите 250 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                        break;
                    case ($count >= 250 && $count < 290):
                        $cards = ['title' => 'Получите <span>Кэшбек 7%</span> на все заказы', 'subtitle' => 'Закажите 290 лидов и получите:', 'infoCheck' => ['cashback' => 'кэшбек 6% на все последующие заказы!', 'script' => 'Скрипт продаж для эффективной обработки', 'telegram' => 'Автоинформирование в Telegram', 'cources' => 'Курс для менеджера продаж', 'personal_assistant' => 'Персонального маркетолога для вашего проекта']];
                        break;
                    case ($count >= 290 && $count < 350):
                        $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 350 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 2 500 баллов на баланс', 'cashback' => 'Кэшбек 7% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                        break;
                    case ($count >= 350 && $count < 440):
                        $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 440 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 5%', 'bonus_points' => '+ 3 500 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_materials' => 'Материалы для эффективной обратоки лидов', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                        break;
                    case ($count >= 440 && $count < 500):
                        $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'Закажите 500 лидов и получите:', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                        break;
                    case ($count >= 500):
                        $cards = ['title' => 'Получите <br> <b>Карту Клуба MYFORCE</b>', 'subtitle' => 'У вас будет максимальная скидка и дополнительная отпраковка 10%', 'infoCheck' => ['additional_waste' => 'Дополнительная отбраковка 10%', 'bonus_points' => '+ 5 000 баллов на баланс', 'cashback' => 'Кэшбек 8% на все следующие заказы', 'personal_assistant' => 'Персонального маркетолога', 'additional_sale' => 'Постоянная скидка 10% на все продукты MYFORCE', 'telegram' => 'Автоинформирование о новых лидах в Telegram']];
                        break;
                }
            }
        } else $cards = 'Пользователь не найден';
        return $cards;
    }
}