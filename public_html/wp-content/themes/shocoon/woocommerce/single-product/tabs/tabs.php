<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs">

		<ul class="nav nav-tabs met_tab_nav met_bgcolor">
			<?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>

				<li <?php echo (($i == 0) ? 'class="active"' : '') ?>>
					<a href="#tab-<?php echo $key ?>"  data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php $i++; endforeach; ?>
		</ul>

		<div class="tab-content met_tab_content">
		<?php $i = 0; foreach ( $tabs as $key => $tab ) : ?>

			<div class="tab-pane fade <?php echo (($i == 0) ? 'active in' : '') ?>" id="tab-<?php echo $key ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php $i++; endforeach; ?>
		</div>

	</div>

<?php endif; ?>