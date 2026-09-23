<?php
if (!defined('ABSPATH')) { exit; }
function bms_pingback_header() { if (is_singular() && pings_open()) echo '<link rel="pingback" href="' . esc_url(get_bloginfo('pingback_url')) . '">' . "\n"; }
add_action('wp_head','bms_pingback_header');
function bms_excerpt_more() { return '&hellip;'; }
add_filter('excerpt_more','bms_excerpt_more');
function bms_body_classes($classes) {
    $classes[]='bms-theme';
    if (get_theme_mod('bms_sticky_header', false)) $classes[]='bms-sticky-header';
    if (!is_singular()) $classes[]='hfeed';
    return $classes;
}
add_filter('body_class','bms_body_classes');
