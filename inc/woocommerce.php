<?php
if (!defined('ABSPATH')) { exit; }

function bms_woocommerce_setup() {
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 480,
        'single_image_width'    => 900,
        'product_grid'          => [
            'default_rows'=>3,'min_rows'=>1,'max_rows'=>8,
            'default_columns'=>4,'min_columns'=>1,'max_columns'=>6,
        ],
    ]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme','bms_woocommerce_setup');

function bms_is_woocommerce_active() { return class_exists('WooCommerce'); }

function bms_woocommerce_layout_hooks() {
    if (!bms_is_woocommerce_active()) return;
    remove_action('woocommerce_before_main_content','woocommerce_output_content_wrapper',10);
    remove_action('woocommerce_after_main_content','woocommerce_output_content_wrapper_end',10);
    remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
    add_action('woocommerce_before_main_content','bms_wc_wrapper_start',10);
    add_action('woocommerce_after_main_content','bms_wc_wrapper_end',10);
}
add_action('wp','bms_woocommerce_layout_hooks');
function bms_wc_wrapper_start(){ echo '<div class="bms-shop-shell"><div class="container py-5"><main>'; }
function bms_wc_wrapper_end(){ echo '</main></div></div>'; }
