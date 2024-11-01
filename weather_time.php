<?php 
/*
Plugin Name: Weather And Time
Plugin URI: http://w3tricks.com/weather-and-time-plug-in/
Description: Weather and Time plug-in will help you to display the current weather of your city or mutiple cities.
Version: 2.0
Author: Labeeb Mohammed
Author URI: http://w3tricks.com/about/

*/

$theme = "Google Weather And Time";
$shortname = "wpgwt";
$file_dir=plugin_dir_url( __FILE__ );

$options = array (
 
array( "name" => $theme." Options",
	"type" => "title"),
 

array( "name" => "Weather Settings",
	"type" => "section"),
array( "type" => "open"),
 
	
array( "name" => "Default City",
	"desc" => "Eg :- New York",
	"id" => $shortname."_city",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Show Forecast info ?",
	"desc" => "",
	"id" => $shortname."_forecast_info",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	
array( "name" => "Number of Days to forecast",
	"desc" => "Select count from list",
	"id" => $shortname."_forecast",
	"type" => "select",
	"options" => array(1, 2, 3,4),
	"std" => 4),
	
array( "name" => "Show Current Condition ?",
	"desc" => "",
	"id" => $shortname."_condition",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	
array( "name" => "Show Date ?",
	"desc" => "",
	"id" => $shortname."_date",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	
	
array( "name" => "Temp Unit",
	"desc" => "",
	"id" => $shortname."_unit",
	"type" => "select",
	"options" => array("Degree Celsius", "Fahrenheit","Both"),
	"std" => "Degree Celsius"),

array( "name" => "Show Humidity ?",
	"desc" => "",
	"id" => $shortname."_humidity",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	
array( "name" => "Show wind Condition ?",
	"desc" => "",
	"id" => $shortname."_wind",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	
array( "name" => "Show High And Low Temp ?",
	"desc" => "",
	"id" => $shortname."_lah",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),	

	
array( "name" => "Show Icon ?",
	"desc" => "",
	"id" => $shortname."_icon",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
	

array( "type" => "close"),
array( "name" => "Time Settings",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Show Time ?",
	"desc" => "",
	"id" => $shortname."_time",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),

array( "name" => "Default Time Zone",
	"desc" => "Eg: America/New_York",
	"id" => $shortname."_zone",
	"type" => "text",
	"std" => ""),
	

array( "type" => "close"),
array( "name" => "Documentation",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "",
	"desc" => "Please Use IANA Time zone format for the Time.Please find below examples",
	"id" => $shortname."_doc1",
	"type" => "content"),

array( "name" => "",
	"desc" => "America/Costa_Rica , America/New_York , Asia/Sakhalin , America/Bahia_Banderas , Antarctica/DumontDUrville",
	"id" => $shortname."_doc2",
	"type" => "content"),
	
array( "name" => "",
	"desc" => "Find your time zone here <a href='http://en.wikipedia.org/wiki/List_of_tz_database_time_zones'>http://en.wikipedia.org/wiki/List_of_tz_database_time_zones</a>",
	"id" => $shortname."_doc3",
	"type" => "content"),
	
	
	

array( "type" => "close")
 
);

function wpgwt_add_admin() {
 
global $theme, $shortname, $options,$file_dir;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
	if ( 'save' == $_REQUEST['action'] ) {
 
		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
	header("Location:?page=weather_time.php&saved=true");
die;
 
} 
else if( 'reset' == $_REQUEST['action'] ) {
 
	foreach ($options as $value) {
		delete_option( $value['id'] ); }
 
	header("Location:?page=weather_time.php&reset=true");
die;
 
}
}
 
add_menu_page($theme, 'Weather &amp; Time', 'activate_plugins', basename(__FILE__), 'wpgwt_admin',$file_dir.'functions/images/logo.png',61);
}

function wpgwt_add_init() {

global $file_dir;
wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");

}
function wpgwt_admin() {
 
global $theme, $shortname, $options,$file_dir;
$i=0;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$theme.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$theme.' settings reset.</strong></p></div>';
 
?>
<div class="wrap rm_wrap">
<h2><?php echo $theme; ?> Settings</h2>
<div class="rm_opts">
<form method="post">

<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
 
<?php break;
 
case "close":
?>
 
</div>
</div>
<br />

 
<?php break;
 
case "title":
?>
<p>To easily use the <?php echo $theme;?> Plug-in, you can use the menu below.</p>

 
<?php break;
 
case 'text':
?>

<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (  get_option( $value['id'] ) != "") { echo stripslashes( get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 
 </div>
<?php
break;
 
case 'textarea':
?>

<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if (  get_option( $value['id'] ) != "") { echo stripslashes( get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 
 </div>
  
<?php
break;
 
case 'select':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
		<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
</select>

	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;
 
case "checkbox":
?>

<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	
<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php break; 
case "section":

$i++;

?>

<div class="rm_section">
<div class="rm_title"><h3><img src="<?php echo $file_dir; ?>/functions/images/trans.png" class="inactive" alt="""><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
</span><div class="clearfix"></div></div>
<div class="rm_options">

 
<?php break;

case "content":
 ?>
 <div class="rm_input">
<?php echo $value['desc']; ?>
 </div>
 <?php break; ?>
<?php }
}
?>
 
<input type="hidden" name="action" value="save" />
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

<div class="donate">
<h2>You Can Donate Here!!</h2>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="labeeb1604@gmail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="w3tricks">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" 

alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div> 
 </div> 
 

<?php
}
function wpgwt_add_style() {

global $file_dir;
wp_enqueue_style("weather_style", $file_dir."/functions/weather_style.css", false, "1.0", "all");
}
add_action('admin_init', 'wpgwt_add_init');
add_action('admin_menu', 'wpgwt_add_admin');
add_action('wp_head', 'wpgwt_add_style');
  require_once('weather.php');
  require_once('weather_widget.php');

?>