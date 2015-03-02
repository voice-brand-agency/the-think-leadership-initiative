<?php
class MET_Single_Image extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Single Image',
			'size' => 'span3'
		);

		parent::__construct('MET_Single_Image', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'title' 		=> '',
			'photo'			=> ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		?>

		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (Optional)
				<?php echo aq_field_input('title', $block_id, $title) ?>
			</label>
		</p>

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

	<?php
	}

	function block($instance) {
		extract($instance);
		?>
		<img src="<?php echo $photo ?>" alt="<?php echo esc_attr($title) ?>">
	<?php
	}

}