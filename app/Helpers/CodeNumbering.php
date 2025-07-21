<?php

namespace App\Helpers;

class CodeNumbering
{
    public static function custom_code($table, $field)
    {
        $month = date('m');
        $year = date('y');
        $format = "{$month}{$year}";

        $count = $table::select("{$field}")->where("{$field}", 'like', "%{$format}%")->count() + 1;
        if (strlen($count) <= 1) {
            $format .= "000" . $count;
        } else if (strlen($count) <= 2) {
            $format .= "00" . $count;
        } else if (strlen($count) <= 3) {
            $format .= "0" . $count;
        } else {
            $format .= (string)$count;
        }

        return $format;
    }
}