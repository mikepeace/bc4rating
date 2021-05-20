<?php
/**
 * @package BC Rating Control
 * @version 1.0.0
 */
/*
Plugin Name: BC Rating Control
Plugin URI: shreedata.com
Description: This is plugin which has option to show/hide the bigcommerce product rating.
Author: Smrutiranjan mishra
Version: 1.7.2
Author URI: https://shreedata.com
*/
function BCrating_register_settings() {
   add_option( 'BCrating_option_name', 'off');
   register_setting( 'BCrating_options_group', 'BCrating_option_name', 'BCrating_callback' );
}
add_action( 'admin_init', 'BCrating_register_settings' );
function BCrating_register_options_page() {
  add_options_page('Rating Control', 'BCratingCtrl', 'manage_options', 'BCrating', 'BCrating_options_page');
}
// Add settings link on plugin page
function BCrating_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=BCrating">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'BCrating_settings_link' );
add_action('admin_menu', 'BCrating_register_options_page');
function BCrating_options_page()
{
?>
  <div class="wrap">
  <?php screen_icon(); ?>
  <h2>BigCommerce Product Rating Control</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'BCrating_options_group' ); ?>
  <h3>Rating Options</h3>
  <p>Default is off</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="BCrating_option_name">Show/Hide</label></th>
  <td><select id="myplugin_option_name" name="BCrating_option_name">
  <?php 
	$options=array('on'=>'Show','off'=>'hide');
	foreach($options as $key=>$val){
	  if($key==get_option('BCrating_option_name')){
		  echo '<option value="'.$key.'" selected>'.$val.'</option>';
	  } else {echo '<option value="'.$key.'">'.$val.'</option>';}
	}
	?>
  </select> </td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
} 
function controlBCratingcss() {
	if(get_option('BCrating_option_name') != 'on'){
		echo "
		<style type='text/css'>
		.bc-product-quick-view__content-inner .bc-single-product__ratings,.bc-product-single .bc-single-product__ratings,.bc-single-product__reviews{display:none;}
		</style>
		";
	} else {
		echo "";
	}
}

add_action( 'wp_head', 'controlBCratingcss', 99 );
