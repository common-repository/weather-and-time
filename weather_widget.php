<?php 
class WeatherTimeWidget extends WP_Widget
{
  function WeatherTimeWidget()
  {
    $widget_ops = array('classname' => 'WeatherTimeWidget', 'description' => 'Displays Weather and Time of your city' );
    $this->WP_Widget('WeatherTimeWidget', 'Weather &amp; Time', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'city' =>'' , 'zone' => '' ) );
    $title = $instance['title'];
	$city = $instance['city'];
	$zone = $instance['zone'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  
  <p><label for="<?php echo $this->get_field_id('city'); ?>">City: <input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>" type="text" value="<?php echo attribute_escape($city); ?>" /></label></p>
  
  <p><label for="<?php echo $this->get_field_id('zone'); ?>">Zone: <input class="widefat" id="<?php echo $this->get_field_id('zone'); ?>" name="<?php echo $this->get_field_name('zone'); ?>" type="text" value="<?php echo attribute_escape($zone); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['city'] = $new_instance['city'];
	$instance['zone'] = $new_instance['zone'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;
 
    $arg=array('city' => $instance['city'],'zone' => $instance['zone'] );
 	weather_time($arg);
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("WeatherTimeWidget");') );?>