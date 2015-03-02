<?php
class MET_Twitter_Ticker extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Twitter',
			'size' => 'span6'
		);

		parent::__construct('MET_Twitter_Ticker', $block_options);
	}

	function form($instance) {

		$defaults = array(
			'username' 			=> 'met_creative',
			'consumerkey'		=> '',
			'consumersecret'	=> '',
			'accesstoken'		=> '',
			'accesstokensecret'	=> '',
			'auto_play'				=> 'true',
			'circular'				=> 'true',
			'infinite'				=> 'true',
			'pauseduration'			=> '0',
			'duration'				=> '2000',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$bool_options = array('false' => 'FALSE' , 'true' => 'TRUE');

		?>

		<p class="description">
			<label for="<?php echo $this->get_field_id('username') ?>">
				Twitter Username
				<?php echo aq_field_input('username', $block_id, $username) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('consumerkey') ?>">
				Consumer Key
				<?php echo aq_field_input('consumerkey', $block_id, $consumerkey) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('consumersecret') ?>">
				Consumer Secret
				<?php echo aq_field_input('consumersecret', $block_id, $consumersecret) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('accesstoken') ?>">
				Access Token
				<?php echo aq_field_input('accesstoken', $block_id, $accesstoken) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('accesstokensecret') ?>">
				Access Token Secret
				<?php echo aq_field_input('accesstokensecret', $block_id, $accesstokensecret) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('auto_play') ?>">
				Auto Play<br/>
				<?php echo aq_field_select('auto_play', $block_id, $bool_options, $auto_play) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('duration') ?>">
				Auto Play (Duration)<br/>
				<?php echo aq_field_input('duration', $block_id, $duration) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('pauseduration') ?>">
				Auto Play (Pause Duration)<br/>
				<?php echo aq_field_input('pauseduration', $block_id, $pauseduration) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('circular') ?>">
				Circular<br/>
				<?php echo aq_field_select('circular', $block_id, $bool_options, $circular) ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('infinite') ?>">
				Infinite<br/>
				<?php echo aq_field_select('infinite', $block_id, $bool_options, $infinite) ?>
			</label>
		</p>

	<?php
	}

	function block($instance) {
		extract($instance);

		wp_enqueue_script('metcreative-caroufredsel');
		wp_enqueue_style('metcreative-caroufredsel');

		$widgetID = uniqid('met_twitter_ticker_');

		$instance['cachetime'] = 2;

		if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
			echo '<div>Please fill all widget settings!</div>';
		}else{

			if($username != get_option('pb_twitter_plugin_username')){
				delete_option('pb_twitter_plugin_last_cache_time');
			}

			//check if cache needs update
			$tp_twitter_plugin_last_cache_time = get_option('pb_twitter_plugin_last_cache_time');
			$diff = time() - $tp_twitter_plugin_last_cache_time;
			$crt = $instance['cachetime'] * 3600;

			//	yes, it needs update
			if($diff >= $crt || empty($tp_twitter_plugin_last_cache_time)){

				if(!class_exists('TwitterOAuth')){
					if(!require_once(get_template_directory() . '/inc/twitteroauth.php')){
						echo '<div><strong>Couldn\'t find twitteroauth.php!</strong></div>';
					}
				}


				$connection = getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
				$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=10") or die('Couldn\'t retrieve tweets! Wrong username?');


				if(!empty($tweets->errors)){
					if($tweets->errors[0]->message == 'Invalid or expired token'){
						echo '<div><strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!</div>';
					}else{
						echo '<div><strong>'.$tweets->errors[0]->message.'</strong></div>';
					}
					return;
				}

				for($i = 0;$i <= count($tweets); $i++){
					if(!empty($tweets[$i])){
						$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
						$tweets_array[$i]['text'] = $tweets[$i]->text;
						$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
					}
				}

				//save tweets to wp option
				update_option('pb_twitter_plugin_tweets',serialize($tweets_array));
				update_option('pb_twitter_plugin_last_cache_time',time());
				update_option('pb_twitter_plugin_username',$username);

				echo '<!-- twitter cache has been updated! -->';
			}
		}

		$tp_twitter_plugin_tweets = maybe_unserialize(get_option('pb_twitter_plugin_tweets'));
		if(!empty($tp_twitter_plugin_tweets)):
?>

		<div class="row-fluid">
			<div class="span12">
				<div class="met_twitter_widget met_color2 met_bgcolor clearfix">
					<h2 class="met_title_stack">LATEST</h2>
					<h3 class="met_title_stack met_bold_one">TWEETS</h3>

					<div id="<?php echo $widgetID ?>" class="met_twitter_wrapper">
						<?php $fctr = 1; foreach($tp_twitter_plugin_tweets as $tweet): ?>
						<div class="met_twitter_item clearfix">
							<i class="icon-twitter"></i>
							<p><?php echo convert_links($tweet['text']) ?></p>
						</div>
						<?php if($fctr == 10){ break; } $fctr++; endforeach; ?>
					</div>

				</div>
			</div>
		</div><!-- Twitter Ticker Ends -->
		<script>
			jQuery(document).ready(function(){
				jQuery("#<?php echo $widgetID ?>").carouFredSel({
					responsive: true,
					circular: <?php echo $circular ?>,
					infinite: <?php echo $infinite ?>,
					auto: {
						play : <?php echo $auto_play ?>,
						pauseDuration: <?php echo $pauseduration ?>,
						duration: <?php echo $duration ?>
					},
					scroll: {
						duration: 400,
						wipe: true,
						pauseOnHover: true
					},
					items: {
						visible: {
							min: 2,
							max: 3},
						height: 'auto'
					},
					direction: 'up',
					onCreate: function(){
						jQuery(window).trigger('resize');
					}
				});
			})
		</script>
<?php
		endif;
	}

}