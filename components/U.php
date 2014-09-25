<?php

namespace neam\util;

/**
 * Contains shorthands for commonly used snippets of code used during debugging
 * U is shorthand for utility
 *
 * Class U
 * @package neam\util
 */
class U
{

    static function arAttributes($ars)
    {
        $return = array();
        foreach ($ars as $ar) {
            $return[] = $ar->attributes;
        }
        return $return;
    }

    /**
     * U::inspection(__METHOD__, func_get_args());
     * @param type $method
     * @param type $args
     */
    static public function inspection($method, $args)
    {
        Yii::log($method . " params: " . print_r($args, true), "inspection", $method);
    }

}