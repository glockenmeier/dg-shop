<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Fair-trade single-product template
 *
  Template Name: Fair-trade product
 *
 * @file           single-fair_trade_products.php
 * @package        Responsive DG
 * @author         Darius Glockenmeier
 * @copyright      2012 Darius Glockenmeier
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-dg/single_fair_trade_products.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

<?php
global $more;
$more = 0;
?>
<div id="primary" <?php echo $this->content_class ?>>
    <div id="content">
        <?php query_posts($this->posts_query); ?>    
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
        <h2><a href="../">Products</a> &Gt; <?php echo the_title(); ?></h2>
                <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
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
                            <span class="round">
                            <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
                            <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
                            <div class="mini-thumb"><div class="the-mini-thumb"></div></div>
                            </span>
                        </div><!-- end of .post-thumb -->
                    <?php endif; ?>
                    <div class="post-entry">
                        <div class="post-desc">
                            <?php //the_excerpt(); ?>
                            <?php the_content(__('Read more &#8250;', 'dg-shop')); ?>
                            <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'dg-shop'), 'after' => '</div>')); ?>
                        </div>
                        <div class="post-data">
                            post data<br />
                            <?php the_tags(__('Tagged with:', 'dg-shop') . ' ', ', ', '<br />'); ?> 
                            <?php printf(__('Posted in %s', 'dg-shop'), get_the_category_list(', ')); ?> 
                        </div><!-- end of .post-data -->             
                        <div class="post-meta">
                            post meta
                            <?php //echo the_meta(); ?>
                            <?php echo $this->meta; ?>
                        </div><!-- end of .post-meta -->
                    </div><!-- end of .post-entry -->
                    
                    <div class="post-edit"><span class="edit-link"><?php edit_post_link(__('Edit', 'dg-shop'), '', '&nbsp;|&nbsp;'); ?></span></div>
                    <div class="back-link"><a href="<?php printf('../#product-%s', get_the_ID()); ?>" rel="prev" title="Back to products list">Back</a></div>
                    <div class="post-cart">
                            <button name="cart" title="Add to cart">Add to cart</button>
                        </div>
                    <div class="dclear"></div>
                </div><!-- end of #post-<?php the_ID(); ?> -->

            <?php endwhile; ?> 
            <?php global $wp_query; ?>
            <?php if ($wp_query->max_num_pages > 1) : ?>
                <div class="navigation">
                    <div class="previous"><?php next_posts_link(__('&#8249; Older posts', 'dg-shop')); ?></div>
                    <div class="next"><?php previous_posts_link(__('Newer posts &#8250;', 'dg-shop')); ?></div>
                </div><!-- end of .navigation -->
            <?php endif; ?>

        <?php else : ?>

            <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'dg-shop'); ?></h1>
            <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'dg-shop'); ?></p>
            <h6><?php _e('You can return', 'dg-shop'); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e('Home', 'dg-shop'); ?>"><?php _e('&larr; Home', 'dg-shop'); ?></a> <?php _e('or search for the page you were looking for', 'dg-shop'); ?></h6>
            <?php get_search_form(); ?>

        <?php endif; ?>  
    </div>
</div><!-- end of #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
