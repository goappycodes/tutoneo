<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    
    <section data-jarallax data-speed=".8" class="py-10  overlay overlay-black overlay-60 bg-cover jarallax" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/covers/cover-13.jpg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 text-center">
                <h1 class="display-2 font-weight-bold text-white">
                    <?php the_title(); ?>
                </h1>
                <!--<p class="lead mb-0 text-white-75">-->
                <!--    Keep up to date with what we're working on! Landkit is an ever evolving theme with regular updates.-->
                <!--</p>-->
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
    
<div class="container">
	 <div class="row justify-content-center pt-10">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
               <div class="row align-items-center py-5 border-top border-bottom">
                    <div class="col-auto">
                        <div class="avatar avatar-lg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col ml-n5">
                        <h6 class="text-uppercase mb-0">
                           <?php the_author(); ?>
                        </h6>
                        <time class="font-size-sm text-muted" datetime="2019-05-20">
                            Published on <span><?php the_date(); ?></span>
                        </time>
                    </div>
                    <div class="col-auto">
                        <span class="h6 text-uppercase text-muted d-none d-md-inline mr-4">
                            Share:
                        </span>
                        <ul class="d-inline list-unstyled list-inline list-social">
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/instagram.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/facebook.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/twitter.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

 <div class="pt-6">
   <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <figure class="figure mb-7">
                    <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
                </figure>
                 
            </div>
            <div class="col-12">
                <?php the_content(); ?>
            </div>
     </div>
</div>

<div class="row justify-content-center pt-10 pb-10">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
               <div class="row align-items-center py-5 border-top border-bottom">
                    <div class="col-auto">
                        <div class="avatar avatar-lg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col ml-n5">
                        <h6 class="text-uppercase mb-0">
                           <?php the_author(); ?>
                        </h6>
                        <time class="font-size-sm text-muted" datetime="2019-05-20">
                            Published on <span><?php the_date(); ?></span>
                        </time>
                    </div>
                    <div class="col-auto">
                        <span class="h6 text-uppercase text-muted d-none d-md-inline mr-4">
                            Share:
                        </span>
                        <ul class="d-inline list-unstyled list-inline list-social">
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/instagram.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/facebook.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                            <li class="list-inline-item list-social-item mr-3">
                                <a href="#!" class="text-decoration-none">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/twitter.svg" class="list-social-icon" alt="...">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>

<section class="pt-7 pb-7 pt-md-10 bg-light"">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-md">
                <h3 class="mb-0">
                    Related Post
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
$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
 
<?php if ( $wpb_all_query->have_posts() ) : ?>
 
 <div class="row">
      <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
    <div class="col-12 col-md-6 col-lg-4 d-flex">
                <div class="card mb-6 mb-lg-6 shadow-light-lg lift lift-lg custom-img">
                    <a class="card-img-top" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('full'); ?>
                      
                    
                        <div class="position-relative">
                            <div class="shape shape-bottom shape-fluid-x svg-shim text-white">
                                <svg viewBox="0 0 2880 480" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2160 0C1440 240 720 240 720 240H0v240h2880V0h-720z" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a class="card-body" href="<?php the_permalink(); ?>">
                        <h3>
                            <?php the_title(); ?>
                        </h3>
                       
                        <?php echo wp_trim_words( get_the_content(), 15 ); ?>
                    </a>
                 
                    <a class="card-meta mt-auto" href="#!">
                        <hr class="card-meta-divider">
                        <!--<div class="avatar avatar-sm mr-2">-->
                        <!--    <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">-->
                        <!--</div>-->
                        <h6 class="text-uppercase text-muted mr-2 mb-0">
                            <?php the_author(); ?>
                        </h6>
                        <p class="h6 text-uppercase text-muted mb-0 ml-auto">
                            <time> <?php the_date(); ?></time>
                        </p>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
           
          </div>
 <?php wp_reset_postdata(); ?>
 

 
<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
        
      
          
          
          
    </div>
</section>

	<footer class="entry-footer">

		<?php // understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

