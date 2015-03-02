<?php
if(!class_exists('MET_Blog_List_Masonary')) {
	class MET_Blog_List_Masonary extends AQ_Block {

		function __construct() {
			$block_options = array(
				'name' => 'Blog List Masonary',
				'size' => 'span12',
			);

			parent::__construct('MET_Blog_List_Masonary', $block_options);
		}

		function form($instance) {

			$defaults = array(
				'item_limit' 			=> '8',
				'excerpt_limit'			=> '10',
				'excerpt_more'			=> '…',
				'widget_title'			=> 'Latest Posts',
				'read_more_text'		=> 'READ MORE',
				'categories'			=> '',
				'ex_categories'			=> ''
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$bool_options = array('false' => 'FALSE' , 'true' => 'TRUE');

			?>

			<p class="description">
				<label for="<?php echo $this->get_field_id('item_limit') ?>">
					Item Limit (required)<br/>
					<?php echo aq_field_input('item_limit', $block_id, $item_limit) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('excerpt_limit') ?>">
					Excerpt Word Limit<br/>
					<?php echo aq_field_input('excerpt_limit', $block_id, $excerpt_limit) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('excerpt_more') ?>">
					Excerpt More Text<br/>
					<?php echo aq_field_input('excerpt_more', $block_id, $excerpt_more) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('read_more_text') ?>">
					Read More Text<br/>
					<?php echo aq_field_input('read_more_text', $block_id, $read_more_text) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('categories') ?>">
					Category IDs (Ex: 1,2,3)<br/>
					<?php echo aq_field_input('categories', $block_id, $categories) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('ex_categories') ?>">
					Exclude Category IDs (Ex: 1,2,3)<br/>
					<?php echo aq_field_input('ex_categories', $block_id, $ex_categories) ?>
				</label>
			</p>

		<?php

		}

		function block($instance) {
			extract($instance);
			if(empty($item_limit)){
				$item_limit = 8;
			}

			$widgetID = uniqid('met_blog_list_masonary_');

			$query_filter = array();
			$query_filter['posts_per_page'] = $item_limit;

			if(!empty($categories)){
				$query_filter['category__and'] = array($categories);
			}

			if(!empty($ex_categories)){
				$category_IDs = explode(',',$ex_categories);
				$ex_category_list = '';
				foreach($category_IDs as $category_ID){
					$ex_category_list .= '-'.$category_ID.',';
				}
				$ex_category_list = substr($ex_category_list,0,-1);

				$query_filter['cat'] = $ex_category_list;
			}
?>

			<div class="row-fluid">
				<div class="span12">
					<div class="met_masonry_blog">
						<?php query_posts($query_filter); ?>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php
								$pfx_date = get_the_date();

								$thumb_id = get_post_thumbnail_id();
								$thumb_url = wp_get_attachment_image_src($thumb_id,'medium', true);
								$thumb_url = $thumb_url[0];

								$category = get_the_category();
								if($category) {
									$first_category = '<a class="met_masonry_blog_item_category" href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
								}
							?>
							<div class="met_masonry_blog_item">
								<a class="met_masonry_blog_preview" href="<?php echo get_permalink( get_the_ID() ); ?>"><img src="<?php echo $thumb_url ?>" alt="<?php echo esc_attr(get_the_title()) ?>" /></a>

								<h2 class="met_masonry_blog_item_title"><a href="<?php echo get_permalink( get_the_ID() ); ?>" class="met_color_transition"><?php the_title() ?></a></h2>

								<span class="met_masonry_blog_item_author"><?php echo $pfx_date ?></span>

								<?php echo $first_category ?>

								<div class="met_masonry_item_descr"><?php echo wp_trim_words( get_the_excerpt(),  $excerpt_limit, $excerpt_more ); ?></div>

								<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="btn btn-primary btn-mini"><?php echo $read_more_text ?></a>

								<span class="met_masonry_blog_item_comments"><?php comments_number( '0 Comment', '1 Comment', '% Comments' ); ?></span>
							</div>
						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>

			<script>

				jQuery(window).load(function(){
					var mainpage_portfolio = jQuery('.met_masonry_blog');
					mainpage_portfolio.isotope({
						resizable: false,
						gutterWidth: 30,
						columnWidth: 270
					});

					jQuery(window).smartresize(function(){masonrySizing(mainpage_portfolio,4);}).smartresize();
				});

			</script>

<?php
			wp_reset_query();
		}

	}
}