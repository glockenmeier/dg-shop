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
 * @subpackage metabox-options
 */
$optionMeta = new dgs_ProductOptionMeta($this->post->ID);
$options = $optionMeta->getIterable();
?>

<?php while ($options->hasNext()): $next = $options->next(); /* populate with available options */ ?>
    <div class="option">
        <div class="input add_new_option">
            <input type="text" name="option_name" title="Option name" autocomplete="off" value="<?php echo $next->getName(); ?>" />
            <button class="button delete" title="Delete this option" onclick="return false;">X</button>
        </div>
        <div class="input input add_new_value">
            <input type="text" name="option_value" title="Option value" autocomplete="off" disabled="disabled" />
            <button class="button add_new_value" title="Add value to the list of available options" disabled="disabled" onclick="return false;">Add</button>
        </div>
        <select name="options" size="5" multiple="multiple">
            <?php foreach ($next->getOptions() as $value): ?>
                <option value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
        <div class="dg_shop_values">
            <input type="hidden" name="_optionname_<?php echo $next->getKey() ?>" value="<?php echo $next->getName()/* readable option name */ ?>" />
            <?php foreach ($next->getOptions() as $value): ?>
            <input type="hidden" name="_option_<?php echo $next->getKey() ?>[]" value="<?php echo $value ?>" />
            <?php endforeach; ?>
        </div>
    </div>
<?php endwhile; ?>
<?php echo $this->nonce ?>

<div class="option_new">
    <button id="dg_shop_new_option" class="button" title="Add new option" onclick="return false;">+</button>
</div>
<!-- <![CDATA[ -->
<div id="dg_shop_option_template" class="hidden">
    <div class="input add_new_option">
        <input type="text" name="option_name" title="Option name" autocomplete="off" />
        <button class="button add" title="Add as new option" disabled="disabled" onclick="return false;">Add</button>
        <button class="button delete" title="Delete this option" onclick="return false;">X</button>
    </div>
    <div class="input add_new_value">
        <input type="text" name="option_value" title="Option value" disabled="disabled" autocomplete="off" />
        <button class="button add_new_value" title="Add value to the list of available options" disabled="disabled" onclick="return false;">Add</button>
    </div>
    <select name="options" size="5" multiple="multiple">

    </select>
    <div class="dg_shop_values">

    </div>
</div>
<!-- <!]]> -->
<div class="dclear"></div>
<script type="text/javascript">
    /* <![CDATA[ */
    require(["dg-shop/ShopMetaOptions", "dojo/domReady!"], function(Options){
        var o = new Options("dg_shop_products_option");
        o.load();
    });
    /* ]]> */
</script>
<noscript> 
<!-- <![CDATA[ -->
JavaScript must be enabled on your browser in order to use this functionality.
<!-- <!]]> -->
</noscript>