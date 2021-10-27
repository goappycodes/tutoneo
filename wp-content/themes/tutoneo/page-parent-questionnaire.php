<?php
/**
* Template Name: Parent Questionnaire
*
*/

use App\Config\Config;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

echo do_shortcode('['. Config::APP_PREFIX .'parent_questionnaire]');

get_footer();