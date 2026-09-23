<?php
/**
 * BMS CORE NAVWALKER.
 * Core mega-menu engine file. Avoid project-specific edits; use templates,
 * style.css, separate project JS, hooks/filters, or a child theme instead.
 */
if (!defined('ABSPATH')) {
    exit;
}

class BMS_Bootstrap_5_Mega_Navwalker extends Walker_Nav_Menu {
    private $current_parent_is_mega = false;
    private $mega_meta = [];
    private $depth_one_count = 0;

    public function walk($elements, $max_depth, ...$args) {
        $this->depth_one_count = 0;
        return parent::walk($elements, $max_depth, ...$args);
    }

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0 && $this->current_parent_is_mega) {
            $position = $this->mega_meta['image_position'] ?? 'right';
            $image_id = absint($this->mega_meta['image_id'] ?? 0);
            $image = $image_id ? wp_get_attachment_image($image_id, 'large', false, [
                'class' => 'bms-mega-image img-fluid',
                'loading' => 'lazy',
            ]) : '';

            $layout_class = 'bms-mega-layout bms-image-' . sanitize_html_class($position);
            $output .= "\n{$indent}<div class=\"dropdown-menu bms-mega-menu\" data-bms-mega=\"1\">";
            $output .= '<div class="container"><div class="' . esc_attr($layout_class) . '">';

            if ($image && in_array($position, ['left', 'top'], true)) {
                $output .= '<div class="bms-mega-media">' . $image . '</div>';
            }

            $output .= '<ul class="bms-mega-grid list-unstyled mb-0">';
            return;
        }

        $classes = ($depth === 0 || !$this->current_parent_is_mega) ? 'dropdown-menu' : 'dropdown-menu submenu';
        $output .= "\n{$indent}<ul class=\"{$classes}\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0 && $this->current_parent_is_mega) {
            $position = $this->mega_meta['image_position'] ?? 'right';
            $image_id = absint($this->mega_meta['image_id'] ?? 0);
            $image = $image_id ? wp_get_attachment_image($image_id, 'large', false, [
                'class' => 'bms-mega-image img-fluid',
                'loading' => 'lazy',
            ]) : '';

            $output .= '</ul>';
            if ($image && in_array($position, ['right', 'bottom'], true)) {
                $output .= '<div class="bms-mega-media">' . $image . '</div>';
            }
            $output .= "</div></div></div>\n";
            return;
        }

        $output .= "{$indent}</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = $depth ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);

        $is_mega = $depth === 0 && (bool) get_post_meta($item->ID, '_bms_is_mega', true);
        if ($depth === 0) {
            $this->current_parent_is_mega = $is_mega;
            $this->mega_meta = [
                'image_id'       => get_post_meta($item->ID, '_bms_mega_image_id', true),
                'image_position' => get_post_meta($item->ID, '_bms_mega_image_position', true) ?: 'right',
            ];
        }

        $li_classes = ['nav-item'];
        if ($has_children) {
            $li_classes[] = 'dropdown';
        }
        if (in_array('current-menu-item', $classes, true)) { $li_classes[] = 'current-menu-item'; }
        if (in_array('current-menu-ancestor', $classes, true) || in_array('current-menu-parent', $classes, true)) { $li_classes[] = 'current-menu-ancestor'; }
        if ($is_mega) {
            $li_classes[] = 'bms-mega-parent';
            $li_classes[] = 'position-static';
        }
        if ($depth > 0) {
            $li_classes = ['bms-menu-item'];
            if ($has_children) {
                $li_classes[] = 'dropdown-submenu';
            }
        }

        $output .= $indent . '<li class="' . esc_attr(implode(' ', array_filter($li_classes))) . '">';

        $atts = [
            'title'  => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel'    => !empty($item->xfn) ? $item->xfn : '',
            'href'   => !empty($item->url) ? $item->url : '#',
        ];

        $link_classes = $depth === 0 ? ['nav-link'] : ['dropdown-item'];
        if ($has_children) {
            $link_classes[] = 'bms-submenu-toggle';
            $atts['aria-expanded'] = 'false';
            $atts['aria-haspopup'] = 'true';
            if ($depth === 0) {
                $link_classes[] = 'dropdown-toggle';
                $atts['data-bs-toggle'] = 'dropdown';
            }
        }
        if ($depth > 0 && $this->current_parent_is_mega) {
            $link_classes = ['bms-mega-link'];
            if ($has_children) {
                $link_classes[] = 'bms-mega-heading';
                $link_classes[] = 'bms-submenu-toggle';
                $atts['aria-haspopup'] = 'true';
                $atts['aria-expanded'] = 'false';
            }
        }

        $atts['class'] = implode(' ', $link_classes);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if ($value === '') {
                continue;
            }
            $value = $attr === 'href' ? esc_url($value) : esc_attr($value);
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = ($args->before ?? '') . '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . esc_html($title) . ($args->link_after ?? '');
        $item_output .= '</a>';
        // A dedicated mobile accordion control keeps navigation links usable and
        // avoids Bootstrap's desktop dropdown handler competing with offcanvas clicks.
        // Mega-menu parents also need a mobile accordion control. WordPress can omit
        // menu-item-has-children from the item classes in some menu states, while the
        // mega panel is still rendered from the saved mega-menu setting.
        if ($has_children || $is_mega) {
            $item_output .= '<button type="button" class="bms-mobile-accordion-toggle" aria-expanded="false" aria-label="' . esc_attr(sprintf(__('Toggle submenu for %s', 'bootstrap-mega-starter'), $title)) . '"><span aria-hidden="true"></span></button>';
        }
        $item_output .= ($args->after ?? '');

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
        if ($depth === 0) {
            $this->current_parent_is_mega = false;
            $this->mega_meta = [];
        }
    }
}
