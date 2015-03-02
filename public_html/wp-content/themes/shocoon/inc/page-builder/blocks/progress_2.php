<?php
if(!class_exists('MET_Progress_Group_Two')) {
	class MET_Progress_Group_Two extends AQ_Block {

		function __construct() {
			$block_options = array(
				'name' => 'Progress Group 2',
				'size' => 'span6'
			);

			//create the widget
			parent::__construct('MET_Progress_Group_Two', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_progt_add_new', array($this, 'add_tab'));

		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' 	=> 'My Progress',
						'percent' 	=> '50'
					)
				)
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {
						$this->progt($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="progt" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
		<?php
		}

		function progt($tab = array(), $count = 0) {

			$types = array('info'=>'Info','success'=>'Success','warning'=>'Warning','danger'=>'Error');

			?>
			<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $tab['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>

				<div class="sortable-body">
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title">
							Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
						</label>
					</p>
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
							Percent<br/>
							<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-percent" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][percent]" value="<?php echo $tab['percent'] ?>" />
						</label>
					</p>
					<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>

			</li>
		<?php
		}

		function block($instance) {
			extract($instance);

?>
			<div class="row-fluid" id="met_block_progress_two_<?php echo rand(1, 100) ?>">
				<div class="span12">
					<div class="met_aboutme_skills">
						<?php
						$i = 1;
						foreach( $tabs as $tab ): ?>
							<div class="met_aboutme_skill">
								<span><?php echo $tab['title'] ?></span>
								<div class="met_custom_skill_bar">
									<div class="met_custom_skill met_bgcolor not-loaded" data-width="<?php echo $tab['percent'] ?>">
										<label><?php echo $tab['percent'] ?>%</label>
									</div>
								</div>
							</div>
						<?php $i++; endforeach; ?>
					</div>
				</div>
			</div>
<?php

		}

		/* AJAX add tab */
		function add_tab() {
			$nonce = $_POST['security'];
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' 		=> 'New Progress',
				'percent' 		=> '50',
				'type'			=> 'info'
			);

			if($count) {
				$this->progt($tab, $count);
			} else {
				die(-1);
			}

			die();
		}

		function update($new_instance, $old_instance) {
			$new_instance = aq_recursive_sanitize($new_instance);
			return $new_instance;
		}
	}
}
