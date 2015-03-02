<?php
class MET_Avatar_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Avatar',
			'size' => 'span3'
		);

		parent::__construct('MET_Avatar_Block', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'title' 		=> '',
			'photo'		=> '',
			'text'		=> '<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-facebook"></i></a>
				<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-twitter"></i></a>
				<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-skype"></i></a>
				<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-youtube"></i></a>
				<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-google-plus"></i></a>
				<a href="#YOUR_LINK_GOES_HERE" class="met_color_transition met_color3"><i class="icon-dribbble"></i></a>'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>

		<p class="description">
			<label for="<?php echo $this->get_field_id('photo') ?>">
				Photo
				<?php echo aq_field_upload('photo', $block_id, $photo) ?>
			</label>
			<?php if($photo) { ?>
				<div class="screenshot">
					<img src="<?php echo $photo ?>" />
				</div>
				<div style="clear: both"></div>
			<?php } ?>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Name
				<?php echo aq_field_input('title', $block_id, $title) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Social Codes (HTML)
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>

	<?php
	}

	function block($instance) {
		extract($instance);
?>
		<div class="row-fluid">
			<div class="span12">
				<div class="met_cacoon_sidebar met_color2 met_bgcolor3 clearfix met_right_triangle text_center">
					<img src="<?php echo $photo ?>" alt="<?php echo esc_attr($title) ?>">
				</div>
				<div class="met_bgcolor met_color2 met_aboutme_name"><?php echo $title ?></div>
				<?php if( !empty($text) ): ?>
					<div class="met_aboutme_socials">
						<?php echo htmlspecialchars_decode($text) ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
<?php
	}

}