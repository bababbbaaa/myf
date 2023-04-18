<?php


namespace common\models\helpers;


class UrlHelper
{



    private const METHOD = 'https';
    private const SERVER = 'myforce.ru';
    private const ADMIN = 'admin';

    public static function admin($path) {
        /*if (strpos($_SERVER['REMOTE_ADDR'], '172.18.0') !== false)
            return "http://" . self::ADMIN . "." . "myforce" . $path;
        else*/
            return self::METHOD . "://" . self::ADMIN . "." . self::SERVER . $path;
    }


}