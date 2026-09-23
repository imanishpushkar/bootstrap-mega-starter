<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'bootstrap-mega-starter'); ?></a>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white" aria-label="<?php esc_attr_e('Primary navigation', 'bootstrap-mega-starter'); ?>">
        <div class="container">
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php if (has_custom_logo()) { the_custom_logo(); } else { bloginfo('name'); } ?>
            </a>

            <?php if (function_exists('bms_is_woocommerce_active') && bms_is_woocommerce_active()): ?>
                <div class="bms-header-actions d-none d-lg-flex order-lg-3 ms-lg-3">
                    <?php if (get_theme_mod('bms_show_account_icon', true)): ?>
                        <a class="bms-header-action" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" aria-label="<?php esc_attr_e('My account','bootstrap-mega-starter'); ?>">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if (get_theme_mod('bms_show_cart_icon', true)): ?>
                        <a class="bms-header-action bms-cart-link" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="<?php esc_attr_e('View cart','bootstrap-mega-starter'); ?>">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.2a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6L20 8H6.1M10 20h.01M17 20h.01"/></svg>
                            <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0): ?><span class="bms-cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span><?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <button class="navbar-toggler bms-menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#bmsMobileNav" aria-controls="bmsMobileNav" aria-label="<?php esc_attr_e('Open navigation', 'bootstrap-mega-starter'); ?>">
                <span></span><span></span><span></span>
            </button>

            <div class="collapse navbar-collapse d-none d-lg-flex order-lg-2" id="primaryNavbar">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-0',
                    'fallback_cb'    => false,
                    'depth'          => 3,
                    'walker'         => new BMS_Bootstrap_5_Mega_Navwalker(),
                ]);
                ?>
            </div>
        </div>
    </nav>
</header>

<div class="offcanvas offcanvas-end bms-mobile-nav" tabindex="-1" id="bmsMobileNav" aria-labelledby="bmsMobileNavLabel">
    <div class="offcanvas-header">
        <div class="offcanvas-title" id="bmsMobileNavLabel">
            <?php if (has_custom_logo()) { the_custom_logo(); } else { bloginfo('name'); } ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Close', 'bootstrap-mega-starter'); ?>"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'navbar-nav bms-mobile-menu',
            'fallback_cb'    => false,
            'depth'          => 3,
            'walker'         => new BMS_Bootstrap_5_Mega_Navwalker(),
        ]);
        ?>
    </div>
</div>

<main id="content" class="site-content">
