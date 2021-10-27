<?php

add_filter( 'fep_form_fields', function( $fields ) {
    unset( $fields['message_title']['minlength'] );
    return $fields;
});

add_filter( 'fep_menu_buttons', 'fep_cus_fep_menu_buttons', 99 );

function fep_cus_fep_menu_buttons( $menu ) {
	// return false;
    unset( $menu['settings'] );
    unset( $menu['announcements'] );
    unset( $menu['directory'] );
    unset( $menu['newmessage'] );
    return $menu;
}

//Remove Gutenberg Block Library CSS from loading on the frontend

function tutoneo_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 

add_action( 'wp_enqueue_scripts', 'tutoneo_remove_wp_block_library_css', 100 );
add_filter('use_block_editor_for_post', '__return_false', 10);

function tutoneo_scripts_enqueue() {



    /* Libs CSS */

    wp_enqueue_style( 'tn-feather', get_stylesheet_directory_uri().'/ui/assets/fonts/Feather/feather.css' );
    wp_enqueue_style( 'tn-fancybox', get_stylesheet_directory_uri().'/ui/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.css' );
    wp_enqueue_style( 'tn-aos', get_stylesheet_directory_uri().'/ui/assets/libs/aos/dist/aos.css' );
    wp_enqueue_style( 'tn-choices', get_stylesheet_directory_uri().'/ui/assets/libs/choices.js/public/assets/styles/choices.min.css' );
    wp_enqueue_style( 'tn-flickity-fade', get_stylesheet_directory_uri().'/ui/assets/libs/flickity-fade/flickity-fade.css' );
    wp_enqueue_style( 'tn-flickity', get_stylesheet_directory_uri().'/ui/assets/libs/flickity/dist/flickity.min.css' );

	// Not sure if used - Very high file size so commented out - Ritesh
    // wp_enqueue_style( 'tn-highlights', get_stylesheet_directory_uri().'/ui/assets/libs/highlightjs/styles/vs2015.css' );
    wp_enqueue_style( 'tn-jarallax', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax.css' );
    wp_enqueue_style( 'tn-quill', get_stylesheet_directory_uri().'/ui/assets/libs/quill/dist/quill.core.css' );

    /* Libs CSS */
	// Not sure if used - Very high file size so commented out - Ritesh
    // wp_enqueue_style( 'tn-mapbox', 'https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css' );

    /* Theme CSS */
    wp_enqueue_style( 'tutoneo-css', get_stylesheet_directory_uri().'/ui/assets/css/theme.min.css' );


    // jQuery -->
    wp_deregister_script('jquery');
    wp_enqueue_script( 'jquery', get_stylesheet_directory_uri().'/ui/assets/libs/jquery/dist/jquery.min.js');

    // Libs JS -->
    
    wp_enqueue_script( 'tn-bootstrap', get_stylesheet_directory_uri().'/ui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-fancybox', get_stylesheet_directory_uri().'/ui/assets/libs/@fancyapps/fancybox/dist/jquery.fancybox.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-aos', get_stylesheet_directory_uri().'/ui/assets/libs/aos/dist/aos.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-choices', get_stylesheet_directory_uri().'/ui/assets/libs/choices.js/public/assets/scripts/choices.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-countUp', get_stylesheet_directory_uri().'/ui/assets/libs/countup.js/dist/countUp.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-dropzone', get_stylesheet_directory_uri().'/ui/assets/libs/dropzone/dist/min/dropzone.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-flickity', get_stylesheet_directory_uri().'/ui/assets/libs/flickity/dist/flickity.pkgd.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-flickity-fade', get_stylesheet_directory_uri().'/ui/assets/libs/flickity-fade/flickity-fade.js', array(), '1.0.0.', true);
	// Not sure if used - Very high file size so commented out - Ritesh
    // wp_enqueue_script( 'tn-highlight', get_stylesheet_directory_uri().'/ui/assets/libs/highlightjs/highlight.pack.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-imagesloaded', get_stylesheet_directory_uri().'/ui/assets/libs/imagesloaded/imagesloaded.pkgd.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-isotope', get_stylesheet_directory_uri().'/ui/assets/libs/isotope-layout/dist/isotope.pkgd.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-jarallax', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-jarallax-video', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax-video.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-jarallax-element', get_stylesheet_directory_uri().'/ui/assets/libs/jarallax/dist/jarallax-element.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-quill', get_stylesheet_directory_uri().'/ui/assets/libs/quill/dist/quill.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-smooth-scroll', get_stylesheet_directory_uri().'/ui/assets/libs/smooth-scroll/dist/smooth-scroll.min.js', array(), '1.0.0.', true);
    wp_enqueue_script( 'tn-typed', get_stylesheet_directory_uri().'/ui/assets/libs/typed.js/lib/typed.min.js', array(), '1.0.0.', true);

    // Map -->
	// Not sure if used - Very high file size so commented out - Ritesh
    // wp_enqueue_script( 'tn-mapbox', 'https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js', array(), '1.0.0.', true);

    // Theme JS -->
    wp_enqueue_script( 'tn-theme', get_stylesheet_directory_uri().'/ui/assets/js/theme.min.js', array(), '1.0.0.', true);
}


add_action( 'wp_enqueue_scripts', 'tutoneo_scripts_enqueue' );


// Remove gravity forms nag
function remove_gravity_forms_nag() {
    update_option( 'rg_gforms_message', '' );
    remove_action( 'after_plugin_row_gravityforms/gravityforms.php', array( 'GFForms', 'plugin_row' ) );
}
add_action( 'admin_init', 'remove_gravity_forms_nag' );