<?php
/**
* Template Name: Student Lesson Calendar
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

echo do_shortcode('['. Config::APP_PREFIX . 'student_lesson_calendar]');

get_footer(); 