<?php
if (!defined('ABSPATH')) { exit; }
function bms_posted_on() {
    printf('<span class="posted-on">%s <a href="%s" rel="bookmark"><time datetime="%s">%s</time></a></span>', esc_html__('Posted', 'bootstrap-mega-starter'), esc_url(get_permalink()), esc_attr(get_the_date(DATE_W3C)), esc_html(get_the_date()));
}
function bms_posted_by() {
    printf('<span class="byline">%s <a href="%s">%s</a></span>', esc_html__('by', 'bootstrap-mega-starter'), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author()));
}
function bms_entry_footer() {
    if ('post' === get_post_type()) {
        $cats = get_the_category_list(esc_html__(', ', 'bootstrap-mega-starter'));
        $tags = get_the_tag_list('', esc_html__(', ', 'bootstrap-mega-starter'));
        if ($cats) echo '<span class="cat-links">' . wp_kses_post($cats) . '</span>';
        if ($tags) echo '<span class="tags-links">' . wp_kses_post($tags) . '</span>';
    }
    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">'; comments_popup_link(); echo '</span>';
    }
}
