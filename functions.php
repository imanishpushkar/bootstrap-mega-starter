<?php
/** Bootstrap Mega Starter functions. @package Bootstrap_Mega_Starter */
if (!defined('ABSPATH')) { exit; }
require_once get_template_directory() . '/inc/class-bs5-mega-navwalker.php';
require_once get_template_directory() . '/inc/menu-fields.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/extras.php';
require_once get_template_directory() . '/inc/woocommerce.php';

function bms_setup() {
    load_theme_textdomain('bootstrap-mega-starter', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links'); add_theme_support('title-tag'); add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds'); add_theme_support('align-wide'); add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles'); add_editor_style(['assets/vendor/bootstrap/css/bootstrap.min.css','assets/css/editor-style.css']);
    add_theme_support('custom-logo', ['height'=>80,'width'=>240,'flex-height'=>true,'flex-width'=>true,'unlink-homepage-logo'=>true]);
    add_theme_support('custom-background', ['default-color'=>'ffffff']);
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script','navigation-widgets']);
    register_nav_menus(['primary'=>__('Primary Menu','bootstrap-mega-starter'),'footer'=>__('Footer Menu','bootstrap-mega-starter')]);
}
add_action('after_setup_theme','bms_setup');
function bms_content_width(){ $GLOBALS['content_width']=apply_filters('bms_content_width',1200); } add_action('after_setup_theme','bms_content_width',0);
function bms_widgets_init(){
    register_sidebar(['name'=>__('Sidebar','bootstrap-mega-starter'),'id'=>'sidebar-1','description'=>__('Main widget area.','bootstrap-mega-starter'),'before_widget'=>'<section id="%1$s" class="widget %2$s mb-4">','after_widget'=>'</section>','before_title'=>'<h2 class="h5 widget-title">','after_title'=>'</h2>']);
    for($i=1;$i<=4;$i++) register_sidebar(['name'=>sprintf(__('Footer %d','bootstrap-mega-starter'),$i),'id'=>'footer-'.$i,'before_widget'=>'<section id="%1$s" class="widget %2$s mb-4">','after_widget'=>'</section>','before_title'=>'<h2 class="h6 widget-title">','after_title'=>'</h2>']);
} add_action('widgets_init','bms_widgets_init');
function bms_assets(){
    $ver=wp_get_theme()->get('Version');
    wp_enqueue_style('bootstrap-5',get_template_directory_uri().'/assets/vendor/bootstrap/css/bootstrap.min.css',[],'5.3.6');
    wp_enqueue_style('bms-style',get_stylesheet_uri(),['bootstrap-5'],$ver);
    wp_enqueue_style('bms-theme',get_template_directory_uri().'/assets/css/theme.css',['bms-style'],$ver);
    wp_enqueue_script('bootstrap-5',get_template_directory_uri().'/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',[],'5.3.6',true);
    wp_enqueue_script('bms-mega-menu',get_template_directory_uri().'/assets/js/mega-menu.js',['bootstrap-5'],$ver,true);
    if(is_singular()&&comments_open()&&get_option('thread_comments')) wp_enqueue_script('comment-reply');
} add_action('wp_enqueue_scripts','bms_assets');
function bms_custom_css(){ $width=min(1600,max(960,absint(get_theme_mod('bms_container_width',1320)))); echo '<style id="bms-customizer-css">:root{--bms-container-max:'.esc_attr($width).'px}</style>'; } add_action('wp_head','bms_custom_css',99);
