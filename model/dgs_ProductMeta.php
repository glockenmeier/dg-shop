<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of dgs_ProductMeta
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
class dgs_ProductMeta extends DopePostMeta {
    
    public function __construct($post_id) {
        parent::__construct($post_id, "_dg-shop");
    }
    
    
}
