<?php
/**
* Template Name: Student Booking
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

echo do_shortcode('['. Config::APP_PREFIX . 'student_booking]');

get_footer(); 