<?php
/**
* Template Name: Teacher Bank Details
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

echo do_shortcode('['. Config::APP_PREFIX . 'teacher_bank_details]');

get_footer(); 