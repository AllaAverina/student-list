<?php

namespace StudentList\Helpers;

class Marker
{
    public static function mark(string $str, string $pattern): string
    {
        return preg_replace("/$pattern/ui", "<mark>$0</mark>", $str);
    }
}
