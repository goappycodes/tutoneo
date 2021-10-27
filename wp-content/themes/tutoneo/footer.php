<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<!-- Theme footer to be disabled -->
<div style="display:none!important" class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

						<?php understrap_site_info(); ?>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->


<!-- FOOTER-->

<div class="position-relative">
    <div class="shape shape-bottom shape-fluid-x svg-shim text-dark">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor" /></svg>
    </div>
</div>

<footer class="py-8 py-md-11 bg-light-grey">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 col-lg-3">
    
        <!-- Brand -->
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/brand.svg" alt="..." class="footer-brand img-fluid mb-2">

        <!-- Text -->
        <p class="text-gray-700 mb-2">
          A better way to build.
        </p>

        <!-- Social -->
        <ul class="list-unstyled list-inline list-social mb-6 mb-md-0">
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
          <li class="list-inline-item list-social-item">
            <a href="#!" class="text-decoration-none">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/ui/assets/img/icons/social/pinterest.svg" class="list-social-icon" alt="...">
            </a>
          </li>
        </ul>

      </div>
      <div class="col-6 col-md-4 col-lg-3">
    
        <!-- Heading -->
        <!--<h6 class="font-weight-bold text-uppercase text-gray-700">-->
        <!--  Products-->
        <!--</h6>-->

        <!-- List -->
        <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
          <li class="mb-3">
            <a href="#!" class="text-reset">
              Student
            </a>
          </li>
          <li class="mb-3">
            <a href="#!" class="text-reset">
              Parent
            </a>
          </li>
          <li class="mb-3">
            <a href="#!" class="text-reset">
             Teacher
            </a>
          </li>
          
        </ul>

      </div>
      <div class="col-6 col-md-4 col-lg-3">
    
        <!-- Heading -->
        <!--<h6 class="font-weight-bold text-uppercase text-gray-700">-->
        <!--  Services-->
        <!--</h6>-->

        <!-- List -->
        <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
          <li class="mb-3">
            <a href="#!" class="text-reset">
              FAQs
            </a>
          </li>
          <li class="mb-3">
            <a href="#!" class="text-reset">
              Blogs
            </a>
          </li>
          <li class="mb-3">
            <a href="#!" class="text-reset">
             Contact Us
            </a>
          </li>
          
        </ul>

      </div>
      <div class="col-6 col-md-4  col-lg-3">
    
        <!-- Heading -->
        <!--<h6 class="font-weight-bold text-uppercase text-gray-700">-->
        <!--  Connect-->
        <!--</h6>-->

        <!-- List -->
        <ul class="list-unstyled text-muted mb-0">
          <li class="mb-3">
            <a href="#!" class="text-reset">
             Terms & Conditions
            </a>
          </li>
          <li class="mb-3">
            <a href="#!" class="text-reset">
              Privacy Policy
            </a>
          </li>
        </ul>

      </div>
     
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</footer>

<?php wp_footer(); ?>

<?php include_once('core/resources/views/public/partials/partial-ajax-loading.php'); ?>
</body>
</html>