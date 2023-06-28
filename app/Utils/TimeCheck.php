<?php
namespace App\Utils;

class TimeCheck {

    static function checkExpiredDate($expiredDate){
        return !(strtotime($expiredDate) < time());
    }
}