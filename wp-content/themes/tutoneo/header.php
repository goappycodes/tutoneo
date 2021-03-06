<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

use App\Config\Config;
use App\Models\Page;

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
	
	<!--Start of Tawk.to Script-->
	<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/602e29b5918aa26127400bda/1euq55rfu';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
	</script>
	<!--End of Tawk.to Script-->

</head>

<body <?php body_class(); ?>>
    <?php do_action('wp_body_open'); ?>
    <div class="site" id="page">

        <!-- ******************* The Navbar Area ******************* -->
        <div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

            <a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e('Skip to content', 'understrap'); ?></a>

            <!-- NAVBAR
        ================================================== -->
            <?php if (!is_front_page()) { ?>
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <?php } else { ?>
                    <nav class="navbar navbar-expand-lg navbar-dark navbar-togglable fixed-top">
                    <?php } ?>
                    <div class="container">

                        <!-- Brand -->
                        <a class="navbar-brand" href="<?php echo home_url(); ?>">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/brand.svg" class="navbar-brand-img" alt="...">
                        </a>

                        <!-- Toggler -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Collapse -->
                        <div class="collapse navbar-collapse" id="navbarCollapse">

                            <!-- Toggler -->
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fe fe-x"></i>
                            </button>

                            <!-- Navigation -->
                            <ul class="navbar-nav ml-auto">
                                
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarPages"  href="<?php echo home_url(); ?>" >
                                        Home
                                    </a>
                                  
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarAccount"  href="<?php echo get_page_url(Page::STUDENT_QUESTIONNAIRE) ?>">
                                        Student
                                    </a>
                                   
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarDocumentation"  href="<?php echo get_page_url(Page::PARENT_QUESTIONNAIRE) ?>" >
                                        Parent
                                    </a>
                                  
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarDocumentation"  href="<?php echo get_page_url(Page::TEACHER_REGISTRATION) ?>">
                                       Teacher
                                    </a>
                                  
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarDocumentation"  href="#" >
                                       FAQs
                                    </a>
                                  
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="navbarDocumentation"  href="<?php echo home_url(); ?>/home/contact/">
                                       Contact Us
                                    </a>
                                  
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="navbarDocumentation"  href="<?php echo home_url(); ?>/blog/">
                                       Blog
                                    </a>
                                </li>
                            </ul>

                            <?php include_once(Config::PUBLIC_VIEWS_DIR . '/partials/partial-header-right-navigation.php') ?>
                        </div>

                    </div>
                    </nav>



                    <!-- This is the original WP Theme menu - to be removed -->
                    <nav style="display:none!important" class="navbar navbar-expand-md navbar-dark bg-primary">

                        <?php if ('container' == $container) : ?>
                            <div class="container">
                            <?php endif; ?>

                            <!-- Your site title as branding in the menu -->
                            <?php if (!has_custom_logo()) { ?>

                                <?php if (is_front_page() && is_home()) : ?>

                                    <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" itemprop="url"><?php bloginfo('name'); ?></a></h1>

                                <?php else : ?>

                                    <a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" itemprop="url"><?php bloginfo('name'); ?></a>

                                <?php endif; ?>


                            <?php } else {
                                the_custom_logo();
                            } ?>
                            <!-- end custom logo -->

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'understrap'); ?>">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <!-- The WordPress Menu goes here -->
                            <?php wp_nav_menu(
                                array(
                                    'theme_location'  => 'primary',
                                    'container_class' => 'collapse navbar-collapse',
                                    'container_id'    => 'navbarNavDropdown',
                                    'menu_class'      => 'navbar-nav ml-auto',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'main-menu',
                                    'depth'           => 2,
                                    'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                                )
                            ); ?>
                            <?php if ('container' == $container) : ?>
                            </div><!-- .container -->
                        <?php endif; ?>

                    </nav><!-- .site-navigation -->

        </div><!-- #wrapper-navbar end -->