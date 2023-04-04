<?php

namespace StudentList\Helpers;

class LinkBuilder
{
    public static function getSortingLink(string $sort, string $order = null): string
    {
        $link = '?' . http_build_query(array_merge($_GET, ['sort' => $sort, 'order' => $order]));
        return $link;
    }

    public static function getPageLink(int $page): string
    {
        if ($_GET) {
            return '/' . $page . '?' . http_build_query($_GET);
        }
        return '/' . $page;
    }
}
