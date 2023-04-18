<?php


namespace common\models;


class StatusResponder
{

    public $code;
    public $status;
    public $message;

    public function jsResponse ($code, $status, $message) {
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
        return $this;
    }

    public function asArray () {
        return ['code' => $this->code, 'status' => $this->status, 'message' => $this->message];
    }

    public function asJson () {
        return json_encode(['code' => $this->code, 'status' => $this->status, 'message' => $this->message], JSON_UNESCAPED_UNICODE);
    }

    public static function randomJson ($object) {
        return json_encode($object, JSON_UNESCAPED_UNICODE);
    }

}