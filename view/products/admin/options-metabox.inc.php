<?php
/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Renders the option-box. Gets available options from the post-meta. Also provides
 * a hidden div used as a template for new options created via javascript
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package Views
 * @subpackage meta-options
 */
?>

<?php foreach ($this->options as $option): /* populate with available options */ ?>
    <div class="option">
        <div class="input add_new_option">
            <input type="text" name="option_name" title="Option name" autocomplete="off" value="<?php echo $option->name; ?>" />
            <button class="button delete" title="Delete this option" style="color: red;">X</button>
        </div>
        <div class="input input add_new_value">
            <input type="text" name="option_value" title="Option value" autocomplete="off" disabled="disabled" />
            <button class="button add_new_value" title="Add value to the list of available options" disabled="disabled">Add</button>
        </div>
        <select name="options" size="5" multiple="multiple">
            <?php foreach ($option->values as $value): ?>
                <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
        <div class="dg_shop_values">
            <input type="hidden" name="_optionname_<?php echo $option->key ?>" value="<?php echo $option->name /* readable option name */ ?>" />
            <?php foreach ($option->values as $value): ?>
                <input type="hidden" name="_option_<?php echo $option->key ?>[]" value="<?php echo $value ?>" />
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
<?php echo $this->nonce ?>

<div class="option_new">
    <button id="dg_shop_new_option" class="button" title="Add new option">+</button>
</div>

<div id="dg_shop_option_template" class="hidden">
    <div class="input add_new_option">
        <input type="text" name="option_name" title="Option name" autocomplete="off" />
        <button class="button add" title="Add as new option" disabled="disabled" >Add</button>
        <button class="button delete" title="Delete this option">X</button>
    </div>
    <div class="input input add_new_value">
        <input type="text" name="option_value" title="Option value" disabled="disabled" autocomplete="off" />
        <button class="button add_new_value" title="Add value to the list of available options" disabled="disabled">Add</button>
    </div>
    <select name="options" size="5" multiple="multiple">

    </select>
    <div class="dg_shop_values">

    </div>
</div>

<div style="clear: both;"></div>
<script type="text/javascript">
    /* <![CDATA[ */
    require(["dg-shop/ShopMeta", "dojo/domReady!"], function(ShopMeta){
        var shop = new ShopMeta("dg_shop_products_option");
        shop.load();
    });
    /* ]]> */
</script>
<noscript> 
<!-- <![CDATA[ -->
JavaScript must be enabled on your browser in order to use this functionality.
<!-- <!]]> -->
</noscript>