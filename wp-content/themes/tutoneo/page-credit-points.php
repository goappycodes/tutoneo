<?php
/**
* Template Name: Credit Points
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

echo do_shortcode('['. Config::APP_PREFIX . 'credit_points]');

get_footer(); 