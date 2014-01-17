<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Products archive post template
 *
  Template Name: List of fair-trade products
 *
 * @file           fair_trade_products.php
 * @package        Responsive DG
 * @author         Darius Glockenmeier
 * @copyright      2012 Darius Glockenmeier
 * @license        license.txt
 * @version        Release: 1.0
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="primary" <?php echo $this->content_class ?>>
    <div id="content">
        <h2>Products</h2>
        <?php query_posts($this->posts_query); ?>    
        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="post-title"><h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'dg-shop'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h3></div>
                    <div class="dclear"></div>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumb">
                            <div class="the-thumb">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                                    <?php the_post_thumbnail('product-thumb', array('class' => 'alignleft')); ?>
                                </a>
                            </div>
                        </div><!-- end of .post-thumb -->
                    <?php endif; ?>
                    <div class="post-entry">
                        <div class="post-desc">
                            <?php the_excerpt(); ?>
                            <?php //the_content(__('Read more &#8250;', 'dg-shop')); ?>
                            <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'dg-shop'), 'after' => '</div>')); ?>
                        </div>
                    </div><!-- end of .post-entry -->

                    <div class="post-edit"><?php edit_post_link(__('Edit', 'dg-shop')); ?></div>
                    <div class="post-cart">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                            <button name="details" title="Click to see the product details">Details &gt;&gt;</button>
                        </a>
                    </div>
                    <div class="dclear"></div>
                </div><!-- end of #post-<?php the_ID(); ?> -->

            <?php endwhile; ?> 
            <?php if ($this->has_pages) : ?>
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
    </div> <!-- end of #content -->
</div><!-- end of #primary -->
<?php get_footer(); ?>
