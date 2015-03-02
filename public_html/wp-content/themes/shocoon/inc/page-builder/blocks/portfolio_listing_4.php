<?php
if(!class_exists('MET_Portfolio_4')) {
	class MET_Portfolio_4 extends AQ_Block {

		function __construct() {
			$block_options = array(
				'name' => 'Portfolio Listing 4',
				'size' => 'span12'
			);

			parent::__construct('MET_Portfolio_4', $block_options);
		}

		function form($instance) {

			$defaults = array(
				'item_per_page' 		=> '9',
				'show_pagination'		=> 'true',
				'show_categories'		=> 'true',
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$bool_options		= array('true'=>'True','false'=>'False');

			?>


			<p class="description">
				<label for="<?php echo $this->get_field_id('item_per_page') ?>">
					Item Per Page<br/>
					<?php echo aq_field_input('item_per_page', $block_id, $item_per_page) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('show_pagination') ?>">
					Show Pagination<br/>
					<?php echo aq_field_select('show_pagination', $block_id, $bool_options, $show_pagination) ?>
				</label>
			</p>

			<p class="description">
				<label for="<?php echo $this->get_field_id('show_categories') ?>">
					Category Filter Bar<br/>
					<?php echo aq_field_select('show_categories', $block_id, $bool_options, $show_categories) ?>
				</label>
			</p>
		<?php
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script('metcreative-isotope');
			$gallery_id = uniqid('portfolio_listing_');

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$the_query = new WP_Query( 'post_type=portfolio&posts_per_page='.$item_per_page.'&paged='.$paged );

			$portfolioFilters = '';
			?>

			<?php if($show_categories):
				$portfolioFilters = '
						<div class="clearfix"><ul id="'.$gallery_id.'filters" class="met_filters_no_bg pull-left met_one_column_portfolio_filters">';

							$args = array( 'orderby' => 'name', 'order' => 'ASC', 'taxonomy' => 'portfolio_category' );
							$categories = get_categories($args);
							foreach($categories as $category) {
								$portfolioFilters .= '<li><a href="#" data-filter=".'.$category->slug.'">'.$category->name.'</a></li>';
							}

				$portfolioFilters .= '<li><a href="#" data-filter="*" class="met_color3">'.__('show all','metcreative').'</a></li>

				</ul></div>';
			endif; ?>


			<div class="row-fluid">
				<div class="span12">
					<?php echo $portfolioFilters; ?>

					<div id="<?php echo $gallery_id ?>" class="met_one_column_portfolio clearfix">
						<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<?php
							$terms = get_the_terms( get_the_ID(), 'portfolio_category' );
							if ( $terms && ! is_wp_error( $terms ) ){
								$portfolioCats = array();
								$portfolioCatSlugs = array();

								foreach ( $terms as $term ) {
									$portfolioCats[] = $term->name;
									$portfolioCatSlugs[] = $term->slug;
								}

								$portfolioCatList = join(", ", $portfolioCats );
								$portfolioSlugList = join(" ", $portfolioCatSlugs );
							}

							$thumbnail_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_url( $thumbnail_id,'full');

							$resized_thumb = aq_resize($image_url,570,400,true);
							if($resized_thumb){
								$image_url	= $resized_thumb;
							}else{
								$image_url	= $image_url;
							}



							$ga = $vi = false;
							$content_media_option = rwmb_meta( 'met_content_media', array(), get_the_ID() );
							if($content_media_option == 'gallery'){
								$gallery_images = rwmb_meta( 'met_gallery_images', $args = array('type'=>'plupload_image','size'=>'thumbnail'), get_the_ID() );
								if(count($gallery_images) > 0){
									$ga = true;

									$gallery_first = array_shift(array_values($gallery_images));
									$gallery_keys = array_keys($gallery_images);

									wp_enqueue_style('metcreative-magnific-popup');
									wp_enqueue_script('metcreative-magnific-popup');

									wp_enqueue_script('metcreative-caroufredsel');
								}
							}

							if($content_media_option == 'video'){
								$vi = true;
								$video_url = rwmb_meta( 'met_video_link', array(), get_the_ID() );
								wp_enqueue_style('metcreative-magnific-popup');
								wp_enqueue_script('metcreative-magnific-popup');
							}

							$portfolio_option['show_categories'] 		= rwmb_meta( 'met_show_categories', array(), get_the_ID() );
							$portfolio_option['category_list_title'] 	= rwmb_meta( 'met_category_list_title', array(), get_the_ID() );
						?>

						<div class="met_one_column_portfolio_item clearfix <?php echo $portfolioSlugList ?>">

							<div class="met_one_column_portfolio_item_preview">
								<?php if( !$ga AND !$vi ): ?>
									<a href="<?php the_permalink() ?>"><img src="<?php echo $image_url ?>" alt="<?php esc_attr(get_the_title()) ?>" /></a>
								<?php endif; ?>


								<?php if( $vi ): ?>
									<iframe src="<?php echo video_url_to_embed($video_url) ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="width: 100%; height: 400px"></iframe>
								<?php endif; ?>

								<?php if( $ga ): ?>
									<div class="met_one_column_slider_wrap clearfix">
										<div class="met_one_column_slider">
											<?php unset($gallery_images[$gallery_keys[0]]); foreach($gallery_images as $gallery_image): ?>
												<a href="<?php echo $gallery_image['full_url'] ?>" rel="lb_<?php the_ID()?>"><img src="<?php echo aq_resize($gallery_image['full_url'],570,400) ?>" alt="<?php esc_attr(get_the_title()) ?>"/></a>
											<?php endforeach; ?>
										</div>
										<a href="#" class="met_blog_slider_nav_prev"><i class="icon-chevron-left"></i></a>
										<a href="#" class="met_blog_slider_nav_next"><i class="icon-chevron-right"></i></a>
									</div>
								<?php endif; ?>
							</div>

							<div class="met_one_column_portfolio_item_details">
								<h2><a href="<?php the_permalink() ?>" class="met_color_transition"><?php the_title() ?></a></h2>
								<div class="met_sidebyside_text_wrapper">
									<span class="met_sidebyside_texts"><?php echo get_the_date() ?></span>
									<?php
										if ( $terms && ! is_wp_error( $terms ) ){
											echo '<span class="met_sidebyside_texts"><a href="' . get_category_link( $terms[key($terms)]->term_id ) . '" title="' . sprintf( __( "View all items in %s" ), $terms[key($terms)]->name ) . '" ' . '>' . $terms[key($terms)]->name.'</a></span> ';
										}
									?>
									<span class="met_sidebyside_texts"><?php comments_number( 'no comments', 'one comment', '% comments' ); ?></span>
								</div>

								<div class="met_one_column_portfolio_item_descr"><?php the_excerpt() ?></div>

								<?php if($portfolio_option['show_categories'] == 'true'): ?>
								<span class="met_sidebyside_text_title"><?php echo $portfolio_option['category_list_title'] ?></span>
								<div class="met_sidebyside_texts_skills">
									<?php
									if($terms){
										foreach($terms as $term) {
											echo '<span class="met_sidebyside_texts">'.$term->name.'</span>';
										}
									}
									?>
								</div>
								<?php endif; ?>

								<div class="met_one_column_portfolio_item_read_more"><a class="btn btn-primary" href="<?php the_permalink() ?>">READ MORE</a></div>
							</div>
						</div>

						<?php endwhile; endif; ?>
					</div>
				</div>
			</div>

			<script>
				jQuery().ready(function(){
					var oneColumnSlider = jQuery(".met_one_column_slider");
					oneColumnSlider.carouFredSel({
						responsive: true,
						prev: {
							button : function(){
								return jQuery(this).parents('.met_one_column_slider_wrap').find('.met_blog_slider_nav_prev')
							}
						},
						next:{
							button : function(){
								return jQuery(this).parents('.met_one_column_slider_wrap').find('.met_blog_slider_nav_next')
							}
						},
						circular: false,
						infinite: true,
						items: {
							visible: {
								min: 1,
								max: 1,
								height: 'variable'
							}
						},
						width: "100%",
						height: "variable",
						swipe : {
							onTouch : true
						},
						onCreate : function () {
							jQuery(window).on('resize', function(){
								oneColumnSlider.parent().add(oneColumnSlider).css('height', oneColumnSlider.children().first().height() + 'px');
							}).trigger('resize');
						}
					});
					jQuery(window).load(function(){
						oneColumnSlider.trigger('updateSizes').trigger('resize');
					});
				})
			</script>

			<?php if($the_query->max_num_pages > 1 AND $show_pagination == 'true'): ?>
			<div class="pagination n_pagination">
				<ul>
					<li><?php next_posts_link(_('Older'),$the_query->max_num_pages); ?></li>
					<li><?php previous_posts_link(_('Newest'),$the_query->max_num_pages); ?></li>
				</ul>
			</div>
			<?php endif; ?>

			<?php
			wp_reset_postdata();
		}
	}
}
