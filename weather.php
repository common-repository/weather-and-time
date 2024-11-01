<?php 

function weather_time($atts)
{
	global $theme, $shortname, $options,$file_dir;
		if($atts['city']!="" ) 
			$city=$atts['city'];
		else $city=get_option($shortname."_city");
		if($atts['zone']!="") 
			$zone=$atts['zone'];
		else $zone=get_option($shortname."_zone");
		if($city=="" ): echo __('Invalid City');exit;endif;
		try {
		$url="http://www.google.com/ig/api?weather=".rawurlencode($city);
		
		$temp = @mb_convert_encoding(file_get_contents($url), 'UTF-8' );
		$xml = @simplexml_load_string($temp);
                 if(is_object($xml)) {
		$information = $xml->xpath("/xml_api_reply/weather/forecast_information");
		$current = $xml->xpath("/xml_api_reply/weather/current_conditions");
		$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");?>
		
        <ul class="weather">
        	<li class="info">
            	<span class="city"><?php print $information[0]->city['data'] ;?></span>
                
                <?php if(get_option($shortname."_date")=="yes") : ?>
            	<span class="Date"><?php print $information[0]->forecast_date['data'] ;?></span>
				 <?php endif; ?>
                 
                 <?php if(get_option($shortname."_time")=="yes")  : ?>
                        <span class="time">
                      <?php  try {
                                         $a = new DateTime('now', new DateTimeZone($zone)); 
                                                    echo ($a->format('g:i A')); }
										catch (Exception $e) {
   								 echo   __("Unknown or bad timezone ($zone). Find your Time Zone here : <a href='http://en.wikipedia.org/wiki/List_of_tz_database_time_zones'>http://en.wikipedia.org/wiki/List_of_tz_database_time_zones </a> ");exit;
								}							?>
                        </span>
				<?php endif; ?>
                
            </li>
            <li class="current">
				<?php if(get_option($shortname."_icon")=="yes")  : ?>
                    <span class="icon">
                    <img src='http://www.google.com<?php print $current[0]->icon['data']?>' alt="weather" />
                    </span>
                 <?php endif; ?>
                 <?php if(get_option($shortname."_condition")=="yes")  : ?>	           
                    <span class="conditon">
                    <?php print $current[0]->condition['data']; ?>
                    </span>
                 <?php endif; ?>
                  <?php if((get_option($shortname."_unit")=="Degree Celsius") || (get_option($shortname."_unit")=="Both"))  : ?>	 
                    <span class="celcius">
                    <?php print ", ".$current[0]->temp_c['data']."&deg;C"; ?>
                    </span>
                   <?php endif; ?>
                    <?php if((get_option($shortname."_unit")=="Fahrenheit") || (get_option($shortname."_unit")=="Both"))  : ?> 
                    <span class="Fahrenheit">
                    <?php print ", ".$current[0]->temp_f['data']."&deg;F"; ?>
                    </span>
                     <?php endif; ?>
                     <?php if(get_option($shortname."_humidity")=="yes")  : ?>	
                    <span class="humidity">
                    <?php print ", ".$current[0]->humidity['data']; ?>
                    </span>
                      <?php endif; ?>
                     <?php if(get_option($shortname."_wind")=="yes")  : ?>	
                    <span class="wind">
                    <?php print ", ".$current[0]->wind_condition['data']; ?>
                    </span>
                   <?php endif; ?>
            </li>
             <?php if(get_option($shortname."_forecast_info")=="yes")  : ?>	
        	<?php $days=get_option($shortname."_forecast");
			for($i=0;$i<$days;$i++) : ?>
            	<li class="forecast" id="forecast-<?php echo $i+1; ?>">
			 	<div class="day"><span class="label">Day :</span><span class="data"><?php print $forecast_list[$i]->day_of_week['data']; ?></span></div>
                <div class="forecast_outer">
                <?php if(get_option($shortname."_icon")=="yes")  : ?>
                <span class="forcast_icon"><img src='http://www.google.com<?php print $forecast_list[$i]->icon['data']?>' alt="weather" /></span> <?php endif; ?>
                <span class="forcast_condition"><?php print $forecast_list[$i]->condition['data']; ?></span></div>
                <?php if(get_option($shortname."_lah")=="yes")  : ?>
                <div class="low">
                <span class="label">Low Temp :</span><span class="data">
                 <?php if((get_option($shortname."_unit")=="Degree Celsius") || (get_option($shortname."_unit")=="Both"))  : ?>
                 <?php $val=intval($forecast_list[$i]->low['data']);
				 		echo round(($val-32)* (0.55))."&deg;C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				  ?>
                 <?php endif; ?>
                 <?php if((get_option($shortname."_unit")=="Fahrenheit") || (get_option($shortname."_unit")=="Both"))  : 
				  print $forecast_list[$i]->low['data']."&deg;F";
                  endif; ?>
                </span>
                </div>
                
                <div class="high">
                <span class="label">High Temp :</span><span class="data">
                 <?php if((get_option($shortname."_unit")=="Degree Celsius") || (get_option($shortname."_unit")=="Both"))  : ?>
                 <?php $val=intval($forecast_list[$i]->high['data']);
				 		echo round(($val-32)* (0.55))."&deg;C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				  ?>
                 <?php endif; ?>
                 <?php if((get_option($shortname."_unit")=="Fahrenheit") || (get_option($shortname."_unit")=="Both"))  : 
				  print $forecast_list[$i]->high['data']."&deg;F";
                  endif; ?>
                </span>
                </div>
                <?php endif; ?>
                </li>
        	<?php endfor;endif;?>
  </ul>
 <?php } else { echo __("Error In API"); } } catch (Exception $e ) { echo __("Your City is Not Valid");}
  } 
 add_shortcode( 'weather_time', 'weather_time' );
 
 ?>