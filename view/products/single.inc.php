<?php
/**
 * Products single post template
 *
 * Template Name: products/single
 *
 * @file        single.inc.php
 * @category    Templates
 * @package     Views
 * @subpackage  products    
 * @author      Darius Glockenmeier
 * @copyright   2012 Darius Glockenmeier
 * @license     license.txt
 * @version     Release: 1.0
 * @link        http://codex.wordpress.org/Templates
 * @filesource  single.inc.php
 * @since       available since Release 1.0
 */

$dpost = DopePost::get($this->post);
$optionMeta = new dgs_ProductOptionMeta($dpost->getId());
$options = $optionMeta->getIterable();
$attrMeta = new dgs_ProductAttributeMeta($dpost->getId());
$fields = $attrMeta->getIterable();
?>

<?php get_header(); ?>

<?php get_sidebar(); ?>
<div id="primary" <?php echo $this->content_class ?>>
    <div id="content">
    <?php if ($dpost !== null) : ?>
        <h2><a href="<?php echo get_post_type_archive_link($dpost->getType()); ?>">Products</a> &GT; <?php echo the_title() ?></h2>
        <div id="product-<?php the_ID() ?>" <?php post_class(); ?>>
        <div class="post-title"><h3><?php the_title(); ?></h3></div>
        <div class="dclear"></div>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumb">
            <div class="the-thumb">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                    <?php the_post_thumbnail('product-thumb', array('class' => 'alignleft')); ?>
                </a>
            </div>
            <div class="dclear"></div>
            <div class="thumbs">
                <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
                <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
                <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
            </div>
        </div><!-- end of .post-thumb -->
    <?php endif; ?>
        <div class="post-entry">
            <div class="post-desc">
                <?php echo $dpost->getContent();//NOTE: works with preview in place of the_content(); ?>
                <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'dg-shop'), 'after' => '</div>')); ?>
            </div>
        <div class="post-data">
            post data<br />
            <?php the_tags(__('Tagged with:', 'dg-shop') . ' ', ', ', '<br />'); ?> 
            <?php printf(__('Posted in %s', 'dg-shop'), get_the_category_list(', ')); ?> 
        </div><!-- end of .post-data -->             
        </div><!-- end of .post-entry -->
        
        <div class="post-meta">
        <?php if ($options->hasNext()): ?>
            <div class="options">
                <table>
                    <caption>Options</caption>
                    <!--
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    -->
                    <tbody>
            <?php while ($options->hasNext()): $opts = $options->next() ?>
                        <tr class="option">
                            <td><label for="options"><?php echo $opts->getName(); ?></label></td>
                            <td>
                                <select name="options">
                                    <option class="select" value="" selected="selected">-- Select --</option>
                                <?php foreach ($opts->getOptions() as $val ): ?>
                                    <option value="<?php echo $val ?>"><?php echo $val ?></option>
                                <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
            <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- end of .options -->
            <?php endif; ?>
            <?php if ($fields->hasNext()): ?>
            <div class="attributes">
                <table>
                    <caption>Attributes</caption>
                    <thead>
                        <th>Name</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
            <?php while ($fields->hasNext()): $attr = $fields->next() ?>
                        <tr class="attribute">
                            <td><label for="options"><?php echo $attr->getName() ?></label></td>
                            <td>
                                <?php echo $attr->getValue(); ?>
                            </td>
                        </tr>
            <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- end of .attributes -->
            <?php endif; ?>
        </div><!-- end of .post-meta -->
        <div class="post-foot">
        <div class="post-edit"><span class="edit-link"><?php edit_post_link(__('Edit', 'dg-shop'), '', '&nbsp;|&nbsp;'); ?></span></div>
        <div class="back-link"><a href="<?php printf('../#product-%s', get_the_ID()); ?>" rel="prev" title="Back to products list">Back</a></div>
        <div class="post-cart">
            <button name="cart" title="Add to cart">Add to cart</button>
        </div>
        </div>
        <div class="dclear"></div>
        </div><!-- end of #post-<?php the_ID(); ?> -->

    <?php if ($this->has_pages) : ?>
        <div class="navigation">
            <div class="previous"><?php next_posts_link(__('&#8249; Older posts', 'dg-shop')); ?></div>
            <div class="next"><?php previous_posts_link(__('Newer posts &#8250;', 'dg-shop')); ?></div>
        </div><!-- end of .navigation -->
    <?php endif; ?>

    <?php else : // dpost is null ?>
        <h1 class="title-404"><?php _e('404 &#8212; Oops!', 'dg-shop'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'dg-shop'); ?></p>
        <h6><?php _e('You can return', 'dg-shop'); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e('Home', 'dg-shop'); ?>"><?php _e('&larr; Home', 'dg-shop'); ?></a> <?php _e('or search for the page you were looking for', 'dg-shop'); ?></h6>
        <?php get_search_form(); ?>
    <?php endif; ?>  
    </div>
</div><!-- end of #primary -->

<?php get_footer(); ?>
