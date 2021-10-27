<?php
/**
* Template Name: Top Up
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

echo do_shortcode('['. Config::APP_PREFIX . 'top_up]');

get_footer(); 