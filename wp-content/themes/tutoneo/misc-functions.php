<?php

// Frontend PM Pro functions
add_filter( 'fep_form_fields', function( $fields ) {
    unset( $fields['message_title']['minlength'] );
    return $fields;
});

add_filter( 'fep_menu_buttons', 'fep_cus_fep_menu_buttons', 99 );

function fep_cus_fep_menu_buttons( $menu ) {
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

// Remove Gravity Forms Nag
function remove_gravity_forms_nag() {
    update_option( 'rg_gforms_message', '' );
    remove_action( 'after_plugin_row_gravityforms/gravityforms.php', array( 'GFForms', 'plugin_row' ) );
}
add_action( 'admin_init', 'remove_gravity_forms_nag' );