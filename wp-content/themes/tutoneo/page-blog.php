<?php
/**
* Template Name: Blog
*
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>





<section data-jarallax data-speed=".8" class="py-10  overlay overlay-black overlay-60 bg-cover jarallax" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/covers/cover-13.jpg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 text-center">
                <h1 class="display-2 font-weight-bold text-white">
                    Our Blogs
                </h1>
                <p class="lead mb-0 text-white-75">
                    Keep up to date with what we're working on! Landkit is an ever evolving theme with regular updates.
                </p>
            </div>
        </div>
    </div>
</section>
<div class="position-relative">
    <div class="shape shape-bottom shape-fluid-x svg-shim text-light">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor" />
        </svg>
    </div>
</div>
<section class="pt-7 pt-md-10">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-md">
                <h3 class="mb-0">
                    Latest Blogs
                </h3>
                <p class="mb-0 text-muted">
                    Here’s what we've been up to recently.
                </p>
            </div>
            <!--<div class="col-12 col-md-auto">-->
            <!--    <a href="#!" class="btn btn-sm btn-outline-gray-300 d-none d-md-inline">-->
            <!--        View all-->
            <!--    </a>-->
            <!--</div>-->
        </div>
        
        
        <?php 
// the query
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>16)); ?>
 
<?php if ( $wpb_all_query->have_posts() ) : ?>
 
 <div class="row">
     <?php $post_counter = 0; ?>
      <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
            <?php
                $post_counter++;
                if($post_counter == 1):
                    ?>
                        <div class="grid-view-images mb-3 mb-lg-3">
                    <?php
                elseif($post_counter == 5):
                    ?>
                        </div>
                    <?php
                endif;
                
                if($post_counter < 5):
                    
                    ?>
                        <a href="<?php the_permalink(); ?>" class="shadow-light-lg lift lift-lg custom-img">
                            <?php the_post_thumbnail('full'); ?>  
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                        </a>
                    <?php
                        else:
                    ?>
                        <div class="col-12 col-md-6 col-lg-4 d-flex blog_col_wrapper">
                            <div class="card mb-3 mb-lg-3 shadow-light-lg lift lift-lg custom-img">
                                <a class="card-img-top" href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); ?> 
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3> 
                                </a>
                            </div>
                        </div>
                    <?php
                endif;
            ?>
            
            <?php endwhile; ?>         
          </div>
         <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
        
      
          
          
          
    </div>
</section>


<?php get_footer(); ?>