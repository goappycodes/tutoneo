<?php
/**
 * The template for displaying 403 pages (unauthorized).
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="error-403-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main">

					<section class="error-403 not-found">

						<header class="page-header text-center">

							<h1 class="page-title"><?php esc_html_e( 'Attention!', 'understrap' ); ?></h1>

						</header><!-- .page-header -->

						<div class="page-content text-center pt-5 pb-10">

					        <h2 class="page-content-title pb-5"><?php echo __('You are not authorized to visit this page.', 'understrap') ?></h2>
					        
					        <button class="btn btn-primary back-btn">
					            <?php echo __('Go Back', 'understrap'); ?>
					        </button>

						</div><!-- .page-content -->

					</section><!-- .error-403 -->

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #error-403-wrapper -->

<script>
    $(document).ready(function(e) {
        $('.back-btn').click(function(e) {
            e.preventDefault();
            window.history.back();
        });
    });
</script>

<?php get_footer(); ?>
