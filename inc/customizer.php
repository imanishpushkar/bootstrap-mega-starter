<?php
if (!defined('ABSPATH')) { exit; }
function bms_customize_register($wp_customize) {
    $wp_customize->add_section('bms_theme_options', ['title'=>__('Starter Theme Options','bootstrap-mega-starter'),'priority'=>160]);
    $wp_customize->add_setting('bms_container_width', ['default'=>1320,'sanitize_callback'=>'absint','transport'=>'refresh']);
    $wp_customize->add_control('bms_container_width', ['label'=>__('Maximum container width (px)','bootstrap-mega-starter'),'section'=>'bms_theme_options','type'=>'number','input_attrs'=>['min'=>960,'max'=>1600,'step'=>10]]);
    $wp_customize->add_setting('bms_sticky_header', ['default'=>false,'sanitize_callback'=>'bms_sanitize_checkbox']);
    $wp_customize->add_control('bms_sticky_header', ['label'=>__('Sticky header','bootstrap-mega-starter'),'section'=>'bms_theme_options','type'=>'checkbox']);
    $wp_customize->add_setting('bms_back_to_top', ['default'=>true,'sanitize_callback'=>'bms_sanitize_checkbox']);
    $wp_customize->add_control('bms_back_to_top', ['label'=>__('Show back-to-top button','bootstrap-mega-starter'),'section'=>'bms_theme_options','type'=>'checkbox']);
    $wp_customize->add_setting('bms_footer_text', ['default'=>'','sanitize_callback'=>'sanitize_text_field']);
    $wp_customize->add_control('bms_footer_text', ['label'=>__('Footer copyright text','bootstrap-mega-starter'),'section'=>'bms_theme_options','type'=>'text','description'=>__('Leave blank for automatic year + site name.','bootstrap-mega-starter')]);
}
function bms_sanitize_checkbox($checked) { return (bool) $checked; }
add_action('customize_register','bms_customize_register');

function bms_customize_woocommerce_header($wp_customize) {
    if (!class_exists('WooCommerce')) return;
    $wp_customize->add_section('bms_woocommerce_header', ['title'=>__('WooCommerce Header','bootstrap-mega-starter'),'priority'=>161]);
    $wp_customize->add_setting('bms_show_cart_icon', ['default'=>true,'sanitize_callback'=>'bms_sanitize_checkbox']);
    $wp_customize->add_control('bms_show_cart_icon', ['label'=>__('Show cart icon in header','bootstrap-mega-starter'),'section'=>'bms_woocommerce_header','type'=>'checkbox']);
    $wp_customize->add_setting('bms_show_account_icon', ['default'=>true,'sanitize_callback'=>'bms_sanitize_checkbox']);
    $wp_customize->add_control('bms_show_account_icon', ['label'=>__('Show account icon in header','bootstrap-mega-starter'),'section'=>'bms_woocommerce_header','type'=>'checkbox']);
}
add_action('customize_register','bms_customize_woocommerce_header',20);
