<?php
get_header();

// get template options
global $options;
foreach ($options as $value) {

  if (isset($value['id'], $value['std'])):
    $option_value = get_option($value['id'], $value['std']);
    if (isset($option_value)):
      if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
        ${$value['id']} = $option_value;
      } else {
        $$value['id'] = $option_value;
      }
    endif;
  endif;
}
// set variables for layout
if ($okfn_narrow_blog == "true") {
  $contentSpan = 'span6';
} else {
  $contentSpan = 'span8';
}
?>
<div class="row">
  <div class="span8">
    <div class="padder">
      <div class="row">
        <div id="content" class="<?php echo $contentSpan; ?>">
          <?php do_action('bp_before_blog_single_post') ?>

          <div class="page" id="blog-single" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                  <div class="post-content">
                    <h2 class="posttitle"><?php the_title(); ?></h2>
                    <?php if ($okfn_narrow_blog !== "true") : ?>
                      <div class="date">
                        <?php printf(__('%1$s <span>in %2$s</span>', 'buddypress'), get_the_date(), get_the_category_list(', ')); ?>
                      </div>
                    <?php endif; ?>

                    <div class="entry">
                      <?php the_content(__('Read the rest of this entry &rarr;', 'buddypress')); ?>

                      <?php wp_link_pages(array('before' => '<div class="page-link"><p>' . __('Pages: ', 'buddypress'), 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
                    </div>

                    <?php if ($okfn_narrow_blog !== "true") : ?>
                      <p class="post-utility"><?php edit_post_link(__('Edit this entry', 'buddypress')); ?></p>
                    <?php endif; ?>

                    <p class="postmetadata"><?php the_tags('<span class="tags">' . __('Tags: ', 'buddypress'), ', ', '</span>'); ?></p>

                    <div class="alignleft"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'buddypress') . '</span> %title'); ?></div>
                    <div class="alignright"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'buddypress') . '</span>'); ?></div>
                  </div>

                </div>

                <?php comments_template(); ?>

                <?php
              endwhile;
            else:
              ?>

              <p><?php _e('Sorry, no posts matched your criteria.', 'buddypress') ?></p>

            <?php endif; ?>

          </div>

          <?php do_action('bp_after_blog_single_post') ?>
        </div><!-- #content -->

        <?php if ($okfn_narrow_blog == "true") : ?>
          <div class="span2">
            <?php if ($okfn_large_avatars == "true") : ?>
              <div class="author-box">
                <?php echo get_avatar(get_the_author_meta('user_email'), '130'); ?>
                <h3><?php printf(_x('Written by %s', 'Post written by...', 'buddypress'), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?></h3>
                <p><!--Replace this with buddypress field --><?php the_author_meta('user_description'); ?></p>
              </div>
            <?php else: ?>
              <div class="author-box small">
                <div class="author-title">
                  <div class="avatar"><?php echo get_avatar(get_the_author_meta('user_email'), '50'); ?></div>
                  <h3><?php printf(_x('Written by <br /> %s', 'Post written by...', 'buddypress'), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?></h3>
                </div>
                <p><!--Replace this with buddypress field --><?php the_author_meta('user_description'); ?></p>
              </div>
            <?php endif; ?>

            <div class="date">
              <?php printf(__('%1$s <span>in %2$s</span>', 'buddypress'), get_the_date(), get_the_category_list(', ')); ?>
            </div>
            <span class="post-utility"><?php edit_post_link(__('Edit this entry', 'buddypress')); ?></span>
          </div>
        <?php endif; ?>

        <div style="clear:both;"></div>
      </div>
    </div>
  </div>
  <div id="sidebar" class="span4" role="complementary">
    <?php if ($okfn_narrow_blog !== "true") : ?>
      <div class="widget">
        <?php if ($okfn_large_avatars == "true") : ?>
          <div class="author-box">
            <?php echo get_avatar(get_the_author_meta('user_email'), '240'); ?>
            <h3><?php printf(_x('Written by %s', 'Post written by...', 'buddypress'), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?></h3>
            <p><!--Replace this with buddypress field --><?php the_author_meta('user_description'); ?></p>
          </div>
        <?php else: ?>
          <div class="author-box small">
            <div class="author-box-header">
              <div class="avatar"><?php echo get_avatar(get_the_author_meta('user_email'), '90'); ?></div>
              <?php printf('<span class="avatar-title">%s</span>', __('Written by', 'okfn')); ?>
              <?php printf('<span class="avatar-subtitle">%s</span>', get_the_author_posts_link()); ?>
            </div>
            <p><!--Replace this with buddypress field --><?php the_author_meta('user_description'); ?></p>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php get_sidebar(); ?>
  </div>
</div>
<?php
get_footer();
