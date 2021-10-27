<?php
/**
* Template Name: Blog Details
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
                    Blogs Details
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
<section class="pt-8 pt-md-11">
    <div class="container">
           <?php $wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
        
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <h1 class="display-4 text-center">
                    <?php the_title(); ?>
                </h1>
                <div class="row align-items-center py-5 border-top border-bottom">
                    <div class="col-auto">
                        <div class="avatar avatar-lg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col ml-n5">
                        <h6 class="text-uppercase mb-0">
                            Ab Hadley
                        </h6>
                        <time class="font-size-sm text-muted" datetime="2019-05-20">
                            Published on May 20, 2019
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
        
         <?php wp_reset_postdata(); ?>
            
               
        
        
    </div>
</section>
<section class="pt-6 pt-md-8">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <figure class="figure mb-7">
                    <img class="figure-img img-fluid rounded lift lift-lg" src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/photos/photo-27.jpg" alt="...">
                </figure>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi reiciendis odio perferendis libero saepe voluptatum fugiat dolore voluptates aut, ut quas doloremque quo ad quis ipsum molestias neque pariatur commodi.
                </p>
                <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, quidem, earum! Quo fugiat voluptates similique quidem dolorem ex non quibusdam odio suscipit error, maiores, itaque blanditiis vel, sed, cum velit?
                </p>
            </div>
        </div>
    </div>
</section>
<section class="pt-8 pt-md-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <div class="row align-items-center py-5 border-top border-bottom">
                    <div class="col-auto">
                        <div class="avatar avatar-lg">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/avatars/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="col ml-n5">
                        <h6 class="text-uppercase mb-0">
                            Ab Hadley
                        </h6>
                        <time class="font-size-sm text-muted" datetime="2019-05-20">
                            Published on May 20, 2019
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
</section>


<?php get_footer(); ?>