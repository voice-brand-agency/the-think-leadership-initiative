<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package metcreative
 */
?>

<?php

if(is_woocommerce_activated()){
	dynamic_sidebar('sidebar-woocommerce');
}else{
	dynamic_sidebar('sidebar-blog');
}