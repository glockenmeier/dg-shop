<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Utility functions
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_Utils {

    public static function full_diff($left, $right) {
        return array_diff(array_merge($left, $right), array_intersect($left, $right));
    }

    public static function array_fast_diff($left, $right) {
        $right = array_flip($right);

        foreach ($left as $key => $value) {
            if (isset($right[$value])) {
                unset($left[$key]);
            }
        }
        return $left;
    }

}
