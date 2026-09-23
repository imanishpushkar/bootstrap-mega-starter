<?php
/**
 * BMS CORE MENU FIELDS.
 * Core mega-menu engine file. Avoid project-specific edits; use templates,
 * style.css, separate project JS, hooks/filters, or a child theme instead.
 */
if (!defined('ABSPATH')) {
    exit;
}

function bms_menu_item_fields($item_id, $item, $depth, $args, $current_object_id) {
    if ((int) $depth !== 0) {
        return;
    }

    $is_mega = (bool) get_post_meta($item_id, '_bms_is_mega', true);
    $image_id = absint(get_post_meta($item_id, '_bms_mega_image_id', true));
    $position = get_post_meta($item_id, '_bms_mega_image_position', true) ?: 'right';
    $thumb = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
    ?>
    <div class="bms-menu-options description-wide" style="margin:10px 0;padding:12px;border:1px solid #dcdcde;background:#fff;">
        <p>
            <label>
                <input type="checkbox" name="bms_is_mega[<?php echo esc_attr($item_id); ?>]" value="1" <?php checked($is_mega); ?>>
                <strong><?php esc_html_e('Enable Mega Menu', 'bootstrap-mega-starter'); ?></strong>
            </label>
        </p>

        <div class="bms-mega-extra" <?php echo $is_mega ? '' : 'style="display:none;"'; ?>>
            <p><strong><?php esc_html_e('Mega Menu Featured Image', 'bootstrap-mega-starter'); ?></strong></p>
            <div class="bms-image-preview" style="margin-bottom:8px;">
                <?php if ($thumb) : ?>
                    <img src="<?php echo esc_url($thumb); ?>" alt="" style="max-width:120px;height:auto;display:block;">
                <?php endif; ?>
            </div>
            <input type="hidden" class="bms-image-id" name="bms_mega_image_id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($image_id); ?>">
            <button type="button" class="button bms-select-image"><?php esc_html_e('Select Image', 'bootstrap-mega-starter'); ?></button>
            <button type="button" class="button bms-remove-image" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e('Remove', 'bootstrap-mega-starter'); ?></button>

            <p style="margin-top:12px;">
                <label>
                    <strong><?php esc_html_e('Image Position', 'bootstrap-mega-starter'); ?></strong><br>
                    <select name="bms_mega_image_position[<?php echo esc_attr($item_id); ?>]">
                        <?php foreach (['left' => 'Left', 'right' => 'Right', 'top' => 'Top', 'bottom' => 'Bottom'] as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php selected($position, $value); ?>><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </p>
            <p class="description"><?php esc_html_e('Columns are calculated automatically from available menu width and the number of child items.', 'bootstrap-mega-starter'); ?></p>
        </div>
    </div>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'bms_menu_item_fields', 10, 5);

function bms_save_menu_item_fields($menu_id, $menu_item_db_id) {
    if (!current_user_can('edit_theme_options')) {
        return;
    }

    update_post_meta($menu_item_db_id, '_bms_is_mega', isset($_POST['bms_is_mega'][$menu_item_db_id]) ? 1 : 0);

    if (isset($_POST['bms_mega_image_id'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_bms_mega_image_id', absint($_POST['bms_mega_image_id'][$menu_item_db_id]));
    }

    if (isset($_POST['bms_mega_image_position'][$menu_item_db_id])) {
        $allowed = ['left', 'right', 'top', 'bottom'];
        $position = sanitize_key($_POST['bms_mega_image_position'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_bms_mega_image_position', in_array($position, $allowed, true) ? $position : 'right');
    }
}
add_action('wp_update_nav_menu_item', 'bms_save_menu_item_fields', 10, 2);

function bms_admin_menu_assets($hook) {
    if ($hook !== 'nav-menus.php') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script(
        'bms-admin-menu',
        get_template_directory_uri() . '/assets/js/admin-menu.js',
        ['jquery'],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('admin_enqueue_scripts', 'bms_admin_menu_assets');
