<?php


namespace common\models\helpers;


use common\models\DbPhones;
use common\models\DbRegion;

class PhoneRegionHelper
{

    /**
     * @param $phone
     * @return DbRegion|null
     */
    public static function getValidRegion($phone) {
        $dbReg = null;
        if(strlen($phone) === 11) {
            $parsePhone = $phone;
            $first = $parsePhone[1] . $parsePhone[2] . $parsePhone[3];
            $rest = $parsePhone[4] .
                $parsePhone[5] .
                $parsePhone[6] .
                $parsePhone[7] .
                $parsePhone[8] .
                $parsePhone[9] .
                $parsePhone[10];
            $first = (int)$first;
            $rest = (int)$rest;
            $finder = DbPhones::find()
                ->where(['AND', ['first' => $first], ['<=', 'second', $rest], ['>=', 'third', $rest]])
                ->asArray()
                ->one();
            if (!empty($finder)) {
                $region = $finder['region'];
                if (mb_strpos($region, '|') !== false) {
                    $parseRegion = explode('|', $region)[1];
                } elseif(mb_strpos($region, 'Московская область') !== false) {
                    $parseRegion = "Московская обл";
                } elseif(mb_strpos($region, 'Москва') !== false) {
                    $parseRegion = "Москва";
                } elseif(mb_strpos($region, 'Ленинградская') !== false) {
                    $parseRegion = "Ленинградская обл";
                } elseif(mb_strpos($region, 'Санкт') !== false) {
                    $parseRegion = "Санкт-Петербург";
                } else {
                    $parseRegion = $region;
                }
                $parseRegion_2 = explode(' ', $parseRegion);
                if (mb_strpos($parseRegion, 'Кемер') !== false)
                    $reg = 'Кемеровская область - Кузбасс';
                elseif (mb_strpos($parseRegion, 'Ханты') !== false)
                    $reg = 'Ханты-Мансийский Автономный округ - Югра';
                elseif (mb_strpos($parseRegion, 'Москва') !== false)
                    $reg = 'Москва';
                else {
                    if ($parseRegion_2[0] === 'Республика') {
                        if ($parseRegion_2[1] === 'Марий') {
                            $reg = "Марий Эл";
                        } elseif ($parseRegion_2[1] === 'Северная') {
                            $reg = "Северная Осетия - Алания";
                        } elseif ($parseRegion_2[1] === 'Саха') {
                            $reg = "Саха /Якутия/";
                        } else {
                            $reg = $parseRegion_2[1];
                        }
                    } else {
                        if ($parseRegion_2[0] === 'Чувашская') {
                            $reg = "Чувашская Республика";
                        } else
                            $reg = $parseRegion_2[0];
                    }
                }
                $dbReg = DbRegion::findOne(['name' => $reg]);
            }
        }
        return $dbReg;
    }

}