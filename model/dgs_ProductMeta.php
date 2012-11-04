<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductMeta
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop
 * @subpackage model
 */
class dgs_ProductMeta extends DopePostMeta {

    public function __construct($post_id, $meta_prefix = '') {
        if ($meta_prefix !== '') {
            $meta_prefix = '-' . $meta_prefix;
        }
        parent::__construct($post_id, "_dg-shop" . $meta_prefix);
    }

}
