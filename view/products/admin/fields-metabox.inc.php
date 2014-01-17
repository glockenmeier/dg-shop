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
$fieldMeta = new dgs_ProductFieldMeta($this->post->ID);
?>
<table>
    <tbody>
        <tr class="attribute">
            <td class="left">
                <div class="input add_new_attribute">
                    Stock
                </div>
            </td>
            <td class="right">
                <div class="input add_new_value">
                    <input type="number" name="_field_stock" title="Stock value" autocomplete="off" value="<?php echo $fieldMeta->get("stock") ?>">
                </div>
            </td>
        </tr>
        <tr class="attribute">
            <td class="left">
                <div class="input add_new_attribute">
                    Weight
                </div>
            </td>
            <td class="right">
                <div class="input add_new_value">
                    <input type="text" name="_field_weight" title="Stock value" autocomplete="off" value="<?php echo $fieldMeta->get("weight") ?>">
                </div>
            </td>
        </tr>
        <tr class="attribute">
            <td class="left">
                <div class="input add_new_attribute">
                    Price
                </div>
            </td>
            <td class="right">
                <div class="input add_new_value">
                    <input type="text" name="_field_price" title="Price" autocomplete="off" value="<?php echo $fieldMeta->get("price") ?>">
                </div>
            </td>
        </tr>
    </tbody>
</table>
<?php echo $this->nonce ?>
    
</div>

<div class="dclear"></div>
<div /><?php // TODO: find out why it breaks without this ugly div ?>