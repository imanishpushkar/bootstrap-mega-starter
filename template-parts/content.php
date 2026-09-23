<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
<?php if(has_post_thumbnail()): ?><div class="mb-3"><?php the_post_thumbnail('large',['class'=>'img-fluid rounded']); ?></div><?php endif; ?>
<header class="entry-header mb-3"><?php the_title(is_singular()?'<h1 class="entry-title">':'<h2 class="entry-title h3"><a href="'.esc_url(get_permalink()).'">',is_singular()?'</h1>':'</a></h2>'); ?><?php if('post'===get_post_type()): ?><div class="entry-meta mt-2"><?php bms_posted_on(); bms_posted_by(); ?></div><?php endif; ?></header>
<div class="entry-content"><?php if(is_singular()){the_content();wp_link_pages(['before'=>'<nav class="page-links">'.esc_html__('Pages:','bootstrap-mega-starter'),'after'=>'</nav>']);}else{the_excerpt();} ?></div>
<footer class="entry-footer"><?php bms_entry_footer(); ?></footer>
</article>
