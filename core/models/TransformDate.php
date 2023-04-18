<?php


namespace core\models;


class TransformDate
{
 public function transformDate($date)
 {
     $month = date('m', strtotime($date));
     switch ($month){
         case '1':
             $newMonth = 'января';
             break;
         case '2':
             $newMonth = 'февраля';
             break;
         case '3':
             $newMonth = 'марта';
             break;
         case '4':
             $newMonth = 'апреля';
             break;
         case '5':
             $newMonth = 'мая';
             break;
         case '6':
             $newMonth = 'июня';
             break;
         case '7':
             $newMonth = 'июля';
             break;
         case '8':
             $newMonth = 'августа';
             break;
         case '9':
             $newMonth = 'сентября';
             break;
         case '10':
             $newMonth = 'октября';
             break;
         case '11':
             $newMonth = 'ноября';
             break;
         case '12':
             $newMonth = 'декабря';
             break;
     }

     $day = date('d', strtotime($date));
     $time = date('H:i', strtotime($date));
     $newDate = "{$day} {$newMonth}, {$time} по МСК";

     return $newDate;
 }
}