<?php


namespace api\models;


class Common
{

    public function create__response($code, $type, $message) {
        $data = ['code' => $code, 'type' => $type, 'message' => $message, 'time' => date("Y-m-d H:i:s")];
        file_put_contents("api-response.log", json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        return $data;
    }

}