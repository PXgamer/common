<?php

namespace pxgamer\Common\Scalars;

/**
 * Class Numbers
 * @package pxgamer\Common\Scalars
 */
class Numbers
{
    /**
     * @param $num
     * @param $len
     * @return bool|string
     */
    public static function trim_num($num, $len)
    {
        if (strlen($num) <= $len) {
            return $num;
        }
        while (strlen($num) > $len) {
            $num = substr($num, 0, -1);
        }
        $num = trim($num, '.');
        return $num;
    }
}