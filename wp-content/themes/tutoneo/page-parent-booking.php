<?php
/**
* Template Name: Parent Booking
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

echo do_shortcode('['. Config::APP_PREFIX .'parent_booking]');

get_footer(); 