<?php
/*
Template Name: Events 
 */

/* body class="magazine" */
add_filter('body_class','browser_body_class');
function browser_body_class($classes = '') {
  array_push($classes,"magazine events");
  return $classes;
}

  // Get options
  global $options;
  foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
   }
  // to use if custom post number is required
  if (!empty($okfn_event_posts)) {
	  $eventPostNumber = $okfn_event_posts;
	} else {
	  $eventPostNumber = '39';
	}
	// to use if custom category is required
	if (!empty($okfn_events_featured)) {
	  $featured_cat = $okfn_events_featured;
	} else {
	  $featured_cat = 'Events';
	}
?>

<?php get_header() ?>
<div class="row">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
	<?php $event_content = get_the_content(); ?>
	
	<?php $featured_event_image = get_the_post_thumbnail($page->ID, 'full'); ?>
  <?php 
		global $post;
	
		$thumbnail_id    = get_post_thumbnail_id($post->ID);
		$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
	
		if ($thumbnail_image && isset($thumbnail_image[0])) {
			$featured_event_link = $thumbnail_image[0]->post_excerpt;
		}
		else $featured_event_link = '#';

?>
      
  <?php // get custom field named GCID
    if (get_post_meta($post->ID,'GCEID')) {
      $gceid = get_post_meta($post->ID,'GCEID', true);
      } else {
      $gceid = 'notset';
      }
  ?>

<?php endwhile; endif; ?>
    
<?php // if GCEID is valid use for calendar ID, else use 1
	if (is_numeric ($gceid))  { 
		$calendar_id = $gceid; 
	} else { 
		$calendar_id = '1';  
	} ;
?>
    
  <div class="span12">
      <h1 class="pagetitle"><?php the_title(); ?></h1>
  </div>
</div>
<div class="row">
  <div id="content" class="span8">
    <div class="padder">

    <?php do_action( 'bp_before_blog_home' ) ?>

    <?php do_action( 'template_notices' ) ?>
    
    <div class="page" id="blog-latest" role="main">


    <?php 
    /* =================== */
    /* == Magazine Body == */
    /* =================== */
		
		if (switch_to_blog(37,true)) {
      $post_filter_main = array('category_name' => $featured_cat, 'posts_per_page' => 1 );

      $idsToSkip = array();
      // Print the main post
      query_posts( $post_filter_main );
      if (have_posts()) {
        the_post();
        echo_magazine_post($post, true);
        // Skip that post's ID in the remining section
        array_push($idsToSkip, $post->ID);
      }

      // Query remaining posts
      $post_filter_etc = array('category_name' => $featured_cat, 'posts_per_page' => $eventPostNumber, 'post__not_in' => $idsToSkip);

		  $counter = 1; ?>
      <div id="magCarousel" class="carousel slide">
        <!-- Carousel items -->
        <div class="carousel-inner">
          <div class="item active">
						<?php // Print the remaining posts
            query_posts( $post_filter_etc );
            while (have_posts()) {
              the_post();
              echo_magazine_post($post, false);
                
               if ($counter % 4 == 0) : ?>
                </div>
                <div class="item">
              <?php endif;
              $counter += 1;
            }
						/* =================== */
						?>
          </div><!-- close item -->
        </div>
        <div class="blog-nav">
          <a class="carousel-control left" href="#magCarousel" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#magCarousel" data-slide="next">&rsaquo;</a>
          <?php global $options;
					foreach ($options as $value) {
							if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_option( $value['id'] ); }
					}
						if (!empty($okfn_blog_link)) : ?>
						<a href="<?php echo $okfn_blog_link ?>" class="all-posts">See all posts</a>
					<?php endif; 
					restore_current_blog();
				} 
				?>
        </div>
      </div>
    </div>

    <?php do_action( 'bp_after_blog_home' ) ?>

    </div><!-- .padder -->
</div><!-- #content -->
<div id="sidebar" class="span4" role="complementary">
  
  <?php if (!empty($featured_event_image)) { ?>
  <div class="widget widget_text">
    <div class="textwidget">
     <a class="full" target="_blank" href="<?php echo $featured_event_link; ?>">
        <?php echo $featured_event_image; ?>
      </a>
    </div>
  </div>
  <?php } ?>
  
 <?php
 $events_category_id = get_cat_ID('Events');
 ?>
 <div class="widget widget_search">
   <h3 class="widgettitle">Search</h3>
     <form method="get" id="search form" action="<?php bloginfo('siteurl'); ?>">
        <div>
          <input type="text" value="" name="s" id="s" placeholder="Search <?php if ($events_category_id != '0') { echo 'Events'; } ?>" />
          <?php if ($events_category_id != '0') : ?>
          <input type="hidden" value="<?php echo $events_category_id ?>" name="cat" id="scat" />
          <?php endif ?>
          <input type="submit" id="search_submit" name="Search" value="Search"/>
        </div>
      </form>
  </div>
  
  <div class="widget widget_text">
    <div class="textwidget">
      <a class="full" target="_blank" href="https://www.google.com/calendar/b/2/embed?src=okfn.org_1v0fovp5uh4b3l88qr2c6q74o4@group.calendar.google.com&ctz=Europe/Berlin&gsessionid=6x2dZ-lGClbCnUtmhuaDeA&gt">
        <img src="http://assets.okfn.org/web/images/promo/okf-events.png">
      </a>
    </div>
  </div>
  
  <div class="widget widget_text">
    <div class="textwidget">
      <a class="full" target="_blank" href="http://www.meetup.com/OpenKnowledgeFoundation/">
        <img src="http://assets.okfn.org/web/images/promo/local-events.png">
      </a>
    </div>
  </div>
  
  <!--
  <div class="widget widget_gce_widget">
    <h3 class="widgettitle">Calendar</h3>
		<?php //echo do_shortcode( '[google-calendar-events id="'.$calendar_id.'" type="ajax" title="Events on"]' ); ?>
  </div>
  -->
  
  <div class="sidebar-content">
    <?php echo $event_content; ?>
  </div>
 </div>
  
<?php //get_sidebar() ?>
</div>
</div>
<?php get_footer() ?>


<script>
	jQuery("#magCarousel").carousel({ interval: false });
	jQuery(document).ready(function() {
				jQuery(".magazine .post.preview .text").dotdotdot({
						//  configuration goes here
				});
		});
	jQuery('#magCarousel').bind('slid', function() {
			jQuery(".magazine .post.preview .text").trigger("update");
		});
</script>
