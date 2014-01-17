<?php
/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Renders the attribute-box. Gets available options from the post-meta. Also provides
 * a hidden div used as a template for new attributes created via javascript
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-shop_Views
 * @subpackage metabox/attributes
 */
$attrMeta = new dgs_ProductAttributeMeta($this->post->ID);
$fields = $attrMeta->getIterable();
?>
<table>
    <thead>
        <tr>
            <th class="left">Name</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fields->hasNext()): $next = $fields->next(); // populate with available attributes ?>
        <tr class="attribute">
            <td class="left">
                <div class="input add_new_attribute">
                    <input type="text" name="_attrname_<?php echo $next->getKey() ?>" title="Attribute name" autocomplete="off" value="<?php echo $next->getName() ?>" />
                    <button class="button add" title="Add as new attribute" disabled="disabled" onclick="return false;">Add</button>
                    <button class="button delete" title="Delete this attribute" onclick="return false;">X</button>
                </div>
            </td>
            <td class="right">
                <div class="input add_new_value">
                    <textarea name="_attr_<?php echo $next->getKey() ?>" title="Attribute value" rows="2"><?php echo $next->getValue() ?></textarea>
                </div>
            </td>
        </tr>
        <?php endwhile;// end each ?>
        <tr id="dg_shop_new_attribute_row">
            <td colspan="2">
                <div class="attribute_new">
                    <button id="dg_shop_new_attribute" class="button" title="Add new attribute" onclick="return false;">+</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->nonce ?>
    
</div>
<!-- <![CDATA[ -->
<div class="hidden">
    <table>
        <tr id="dg_shop_attribute_template">
            <td>
                <div class="input add_new_attribute">
                    <input type="text" name="attribute_name" title="Attribute name" autocomplete="off" />
                    <button class="button add" title="Add as new attribute" disabled="disabled" onclick="return false;">Add</button>
                    <button class="button delete" title="Delete this attribute" onclick="return false;">X</button>
                </div>
            </td>
            <td>
                <div class="input add_new_value">
                    <textarea name="attribute_value" title="Attribute value" disabled="disabled" cols="50" rows="2"></textarea>
                </div>
            </td>
        </tr>
    </table>
</div>
<!-- <!]]> -->
<div class="dclear"></div>
<div /><?php // TODO: find out why it breaks without this ugly div ?>
<script type="text/javascript">
    /* <![CDATA[ */
    require(["dg-shop/ShopMetaAttributes", "dojo/domReady!"], function(ShopMetaAttributes){
        var shop = new ShopMetaAttributes("dg_shop_products_attributes");
        shop.load();
    });
    /* ]]> */
</script>
<noscript> 
<!-- <![CDATA[ -->
JavaScript must be enabled on your browser in order to use this functionality.
<!-- <!]]> -->
</noscript>