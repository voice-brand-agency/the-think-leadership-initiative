<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $errors ) return;
?>
<div class="met_message met_message_error">
	<ul>
		<?php foreach ( $errors as $error ) : ?>
			<li><?php echo wp_kses_post( $error ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>