<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Smj_Ulm_Cal
 *
 * @wordpress-plugin
 * Plugin Name:       SMJ Ulm/Alb/Donau Kalender
 * Plugin URI:        https://smj-ulm.de
 * Description:       Abonnieren eines .ics feeds und Darstellung auf Wordpress Seite
 * Version:           0.0.1
 * Author:            Felix Betz
 * Author URI:        https://github.com/FelixBetz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smj-ulm-cal
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SMJ_ULM_CAL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smj-ulm-cal-activator.php
 */
function activate_smj_ulm_cal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal-activator.php';
	Smj_Ulm_Cal_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smj-ulm-cal-deactivator.php
 */
function deactivate_smj_ulm_cal() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal-deactivator.php';
	Smj_Ulm_Cal_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_smj_ulm_cal' );
register_deactivation_hook( __FILE__, 'deactivate_smj_ulm_cal' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-smj-ulm-cal.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smj_ulm_cal() {

	$plugin = new Smj_Ulm_Cal();
	$plugin->run();

}
run_smj_ulm_cal();


require_once  (plugin_dir_path(__FILE__) ."ICal/ICal.php");
require_once  (plugin_dir_path(__FILE__) ."ICal/Event.php");
use ICal\ICal;

//------------------------------------------------------------------------------
//!
//! Function: 		replaceMonthWithString
//!
//! Description:	replaceMonthWithString
//!
//! Parameter: 		$arg_month_num: expected num 1 to 612
//!
//! Return: 		returns german month string by given weeknum
//------------------------------------------------------------------------------
function replaceMonthWithString($arg_month_num){
	$WEEKDAYS = array(  "Jan","Feb","Mär","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez");
	if($arg_month_num < 1 ||$arg_month_num > 12){
		return "";
	}
	return $WEEKDAYS[$arg_month_num-1];
}

//------------------------------------------------------------------------------
//!
//! Function: 		replaceWeekdayWithString
//!
//! Description:	replaceWeekdayWithString
//!
//! Parameter: 		$arg_weekday_num: expected num 0 to 6
//!
//! Return: 		returns german weekday string by given weeknum
//------------------------------------------------------------------------------
function replaceWeekdayWithString($arg_weekday_num){
	$WEEKDAYS = array(  "Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
	if($arg_weekday_num < 0 ||$arg_weekday_num > 6){
		return "";
	}
	return $WEEKDAYS[$arg_weekday_num];
}

//------------------------------------------------------------------------------
//!
//! Function: 		repeatStringToGerman
//!
//! Description:	repeatStringToGerman
//!
//! Parameter: 		$arg_weekday_num: expected num 0 to 6
//!
//! Return: 		returns germand weekday string by givne weeknum
//------------------------------------------------------------------------------
function repeatStringToGerman($repeat_str) {
	if ($repeat_str == "DAILY") {
	  return "täglich";
	}
	if ($repeat_str == "WEEKLY") {
	  return "wöchentlich";
	}
	if ($repeat_str == "MONTHLY") {
	  return "monatlich";
	}
	if ($repeat_str == "YEARLY") {
	  return "jährlich";
	}
  
	return "";
  }

//------------------------------------------------------------------------------
//!
//! Function: 		shortcode_smj_ulm_cal_fulllist
//!
//! Description:	register shortcode, which displays 
//!
//! Parameter: 		$atts
//!
//! Return: 		returns <div> with the id for the svelte frontend
//------------------------------------------------------------------------------
function shortcode_smj_ulm_cal_fulllist( $atts ){
	$file_name  = "calender.ics";
	$dir_path = plugin_dir_path(__FILE__) ."data/";
	try {
		$ical = new ICal($dir_path.$file_name, array(
			'defaultSpan'                 => 2,     // Default value
			'defaultTimeZone'             => 'UTC',
			'defaultWeekStart'            => 'MO',  // Default value
			'disableCharacterReplacement' => false, // Default value
			'filterDaysAfter'             => null,  // Default value
			'filterDaysBefore'            => null,  // Default value
			'httpUserAgent'               => null,  // Default value
			'skipRecurrence'              => true, // Default value
		));
		// $ical->initFile('ICal.ics');
		// $ical->initUrl('https://raw.githubusercontent.com/u01jmg3/ics-parser/master/examples/ICal.ics', $username = null, $password = null, $userAgent = null);
	} catch (\Exception $e) {
		die($e);
	}

	//parse attributes
	$startDate= null;
	$endDate=null;
	$categories_filter = array();
	
	if (is_array($atts)){
		if (array_key_exists("startdate", $atts) 	) {
			$startDate = $atts["startdate"];
		}
		if (array_key_exists("enddate", $atts) 	) {
			$endDate = $atts["enddate"];
		}
		if (array_key_exists("categories", $atts) 	) {
			$splitted_categories = explode(',',$atts["categories"]);
            foreach($splitted_categories as &$category){
                array_push($categories_filter,$category);
            }
		}
	}
	
	$ret_string ="";

	//take events from startDate to endDate
	//check if dates != null
	if($startDate != null && $endDate != null){
		$events = array();
		$isStartDateValid =strtotime($startDate);
		$isEndDateValid = strtotime( $endDate);

		//check if valid start date
		if ($isStartDateValid !== false && $isEndDateValid !==false){
			$events = $ical->eventsFromRange($startDate, $endDate );
		}
		else{
			$events = array();
			if(!$isStartDateValid){
				$ret_string .= "<div><strong>[SMJ Ulm Kalender Plugin]:</strong> Ungültiges Start Datum: 	&quot;" .$startDate."&quot;</em></div>";
			}
			if(!$isEndDateValid){
				$ret_string .= "<em><div><strong>[SMJ Ulm Kalender Plugin]:</strong> Ungültiges End Datum: 	&quot;" .$endDate."&quot;</em></div>";
			}	
		}
	}
	// if dates are not valid => take all events of the calender
	else{
		$events =  $ical->events();
		$events = $ical->sortEventsWithOrder($events);
	}


	//filter events
	if(count($categories_filter)>0){
			$events = array_filter($events,
			function ($pEvent) use($ret_string,$categories_filter){		
				foreach($categories_filter as &$category){
					if( in_array(trim($category),$pEvent->get_categories() ) ){
						return true;
					}
				}
				return false;
			}
		);
	}


	//insert div for svelte app
	foreach ($events as &$event) {
		//parse allday
		$isAllDay =  false;

	
		if (array_key_exists("VALUE", $event->dtstart_array[0])) {
			$isAllDay =  $event->dtstart_array[0]["VALUE"] =="DATE";
		}

		//parse multiday
		if($isAllDay){
			$timestamp_diff= $event->dtend_array[2]  - $event->dtstart_array[2];
			$isMulitday = $timestamp_diff > (3600*24);
		}
		else{
			$start_string = explode("T",$event->dtstart)[0];
			$end_string = explode("T",$event->dtend)[0];
			$isMulitday =  $start_string != $end_string;
		}


		$repeat_str =  "";

		if(isset($event->rrule_array[1])){

			$rrule_explode = explode(";",$event->rrule_array[1])[0];
			$freq_explode = explode("=",$rrule_explode)[1];
			$repeat_str = repeatStringToGerman($freq_explode );
		}

		//pretty print calender event
		/*$ret_string .=  '<div class="row">';
		$ret_string .="<pre>".print_r(get_object_vars($event),true)."</pre>";
		$ret_string .=  '</div>';*/

		//row
		$ret_string .=  '<div class="row">';

		//event col
		$ret_string .=  '<div class="col-sm-3">';
        $ret_string .=  '<strong>'. $event->summary.'</strong>';
		if(count($event->get_categories())>0){
			$ret_string .= '<div>'. $event->get_categories_string() .'</div>';
		}
		$ret_string .=  '</div>';

		//////////////////////////////////////////////////////////////////////////////
		//date column
		$dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
		$dtend = $ical->iCalDateToDateTime($event->dtend_array[3]);
		$ret_string .=  '<div class="col-sm-3">';

		//date start
        $ret_string .=  '<strong>'. $dtstart->format('d.m.Y') .'</strong>, ';
		$ret_string .=  replaceWeekdayWithString($dtstart->format('w'));

		if( $isMulitday){
			$ret_string .=" -<br />";
			
			if($isAllDay){
				//substract 1 day
				$dtend = $dtend->modify("-1 day");
			}
		
			$ret_string .='<strong>'. $dtend->format('d.m.Y').'</strong>, ';
			$ret_string .=  replaceWeekdayWithString($dtend->format('w'));
		}
		if($repeat_str !=""){
			$ret_string .= "<br /><i>(findet ".$repeat_str." statt)</i>";
		}
		$ret_string .=  '</div>';
		//date column end
		//////////////////////////////////////////////////////////////////////////////

		//////////////////////////////////////////////////////////////////////////////
		//time column
		$ret_string .=  '<div class="col-sm-2">';
		if($isAllDay)
        {
			$ret_string .=  ' Ganztägig';
		}
		elseif($isMulitday){
			$ret_string .=  'Beginn: '.$dtstart->format('H:i') .' Uhr <br />';
			$ret_string .=  'Ende: '.$dtend->format('H:i') .' Uhr';
		}
		else{
			$ret_string .=  $dtstart->format('H:i') .' Uhr - ';
			$ret_string .=  $dtend->format('H:i') .' Uhr';
		}
		
		$ret_string .=  '</div>';
		//date column end
		//////////////////////////////////////////////////////////////////////////////

		//description row
		$ret_string .= '<div class="col-sm-4">';
        $ret_string .= $event->description;
		if($event->location != ""){
			if($event->description != ""){
				$ret_string .=",<br>";
			}
			$ret_string .=  "<i>(Ort: ".$event->location . ")</i>";
		}
		$ret_string .= '</div>';


	  	//row end
		$ret_string .=  '</div>';

		//hr line
		$ret_string .='<hr />';
	}


	return $ret_string;
}
add_shortcode( 'smj-ulm-cal_fulllist', 'shortcode_smj_ulm_cal_fulllist' );

//------------------------------------------------------------------------------
//!
//! Function: 		shortcode_smj_ulm_cal
//!
//! Description:	register hook which downloads .ics calender
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
if (!wp_next_scheduled('smj_ulm_cal__get_calender_hook')) {
	wp_schedule_event(time(), 'hourly', 'smj_ulm_cal__get_calender_hook');
}

add_action('smj_ulm_cal__get_calender_hook', 'smj_ulm_cal__get_calender');
  
function smj_ulm_cal__get_calender() {
	$url = "";
	$log_text = current_datetime()->format("Y-m-d H:i:s");
	$file_name  = "calender.ics";
	$dir_path = plugin_dir_path(__FILE__) ."data/";

	if(isset(get_option('smj_ulm_cal_options')['smj_ulm_cal__master_url'])){
		$url = get_option('smj_ulm_cal_options')['smj_ulm_cal__master_url'];
	}

	//create data directory if not exist
	mkdir($dir_path);

	// Use file_get_contents() function to get the file
	// from url and use file_put_contents() function to
	// save the file by using base name
	if ($url !="" && file_put_contents($dir_path.$file_name, file_get_contents($url)))
	{
		$log_text .="\tdownload ok";
	}
	else
	{
		$log_text .= "\tdownload failed";
	}
	//log status
	file_put_contents( $dir_path. 'logs.txt', $log_text.PHP_EOL , FILE_APPEND | LOCK_EX);


	//parse categories
	$file_name  = "calender.ics";
	$dir_path = plugin_dir_path(__FILE__) ."data/";
	try {
		$ical = new ICal($dir_path.$file_name, array(
			'defaultSpan'                 => 2,     // Default value
			'defaultTimeZone'             => 'UTC',
			'defaultWeekStart'            => 'MO',  // Default value
			'disableCharacterReplacement' => false, // Default value
			'filterDaysAfter'             => null,  // Default value
			'filterDaysBefore'            => null,  // Default value
			'httpUserAgent'               => null,  // Default value
			'skipRecurrence'              => true, // Default value
		));
		// $ical->initFile('ICal.ics');
		// $ical->initUrl('https://raw.githubusercontent.com/u01jmg3/ics-parser/master/examples/ICal.ics', $username = null, $password = null, $userAgent = null);
	} catch (\Exception $e) {
		die($e);
	}

	$events =  $ical->events();

	$categories = array();
	foreach ($events as &$event) {
		foreach($event->get_categories() as &$category){
			array_push($categories,$category);
		}
	}

	// Count occurrences of each string
	$occurrences = array_count_values($categories);
	// log to categories file,
	file_put_contents($dir_path. 'categories.txt', ""); //clear content
	foreach ($occurrences as $key => $value) {
		$log_text = $key.";".$value;
		file_put_contents( $dir_path. 'categories.txt', $log_text.PHP_EOL , FILE_APPEND | LOCK_EX);
	}

}


//------------------------------------------------------------------------------
//!
//! Function: 		shortcode_smj_ulm_cal_nextevents
//!
//! Description:	register shortcode, which displays 
//!
//! Parameter: 		$atts
//!
//! Return: 		returns <div> with the id for the svelte frontend
//------------------------------------------------------------------------------
function shortcode_smj_ulm_cal_nextevents( $atts ){
	$file_name  = "calender.ics";
	$dir_path = plugin_dir_path(__FILE__) ."data/";
	try {
		$ical = new ICal($dir_path.$file_name, array(
			'defaultSpan'                 => 2,     // Default value
			'defaultTimeZone'             => 'UTC',
			'defaultWeekStart'            => 'MO',  // Default value
			'disableCharacterReplacement' => false, // Default value
			'filterDaysAfter'             => null,  // Default value
			'filterDaysBefore'            => null,  // Default value
			'httpUserAgent'               => null,  // Default value
			'skipRecurrence'              => false, // Default value
		));
		// $ical->initFile('ICal.ics');
		// $ical->initUrl('https://raw.githubusercontent.com/u01jmg3/ics-parser/master/examples/ICal.ics', $username = null, $password = null, $userAgent = null);
	} catch (\Exception $e) {
		die($e);
	}


	$num_max_events = 5; //default: 5 events
	$num_months = 12; //default: 12 months
	$categories_filter = array();

	if (is_array($atts)){
		if (array_key_exists("num_max_events", $atts) 	) {
			$num_max_events = intval($atts["num_max_events"]);
		}
		if (array_key_exists("num_months", $atts) 	) {
			$num_months = intval($atts["num_months"]);
		}

		if (array_key_exists("categories", $atts) 	) {
			$splitted_categories = explode(',',$atts["categories"]);
            foreach($splitted_categories as &$category){
                array_push($categories_filter,$category);
            }
		}
	}
	$ret_string ="";
	if(!is_int($num_max_events) || $num_max_events <= 0){
		
		$ret_string .= "<div><strong>[SMJ Ulm Kalender Plugin]:</strong> Ungültiges Konfiguration fuer 	&quot;num_max_events	&quot;: 	&quot;" .$atts["num_max_events"]."&quot;</em></div>";
	}

	if(!is_int($num_months) ||  $num_months <= 0){
		$ret_string .= "<div><strong>[SMJ Ulm Kalender Plugin]:</strong> Ungültiges Konfiguration für 	&quot;num_months&quot;: 	&quot;" .$atts["num_months"]."&quot;</em></div>";
	}
	

	if($ret_string !== ""){
		return $ret_string;
	}

	$events = $ical->eventsFromInterval($num_months.' month');


	//filter events
	if(count($categories_filter)>0){
		$events = array_filter($events,
			function ($pEvent) use($categories_filter){		
				foreach($categories_filter as &$category){
					if( in_array(trim($category),$pEvent->get_categories() ) ){
						return true;
					}
				}
				return false;
			}
		);
	}
	//fix array indices
	$events = array_values($events);

	$event_index = 0;
	while ($event_index < $num_max_events && $event_index < count($events) ){
		$event = $events[$event_index++];
		//parse allday
		?>
		<style>

		.event-header {
			display: flex;
			flex-direction: row;
			flex-wrap: nowrap;
			justify-content: space-between;
			color: white;
			font-weight: bold;
		}
		.event-body {
			
			text-align: center;

		}
		</style>



		<?php
		
	//parse allday
	if (isset($event->dtstart_array[0]["VALUE"])){
		$isAllDay = $event->dtstart_array[0]["VALUE"] =="DATE";
	}
	else{
		$isAllDay = NULL;
	}

	//parse multiday
	if($isAllDay){
		$timestamp_diff= $event->dtend_array[2]  - $event->dtstart_array[2];
		$isMulitday = $timestamp_diff > (3600*24);
	}
	else{
		$start_string = explode("T",$event->dtstart)[0];
		$end_string = explode("T",$event->dtend)[0];
		$isMulitday =  $start_string != $end_string;
	}

	//outter div
	$ret_string .=  '<div class="border border-secondary border-5 bg-secondary m-0 mt-4 mb-4 rounded rounded-3">';

	$dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
	$dtend = $ical->iCalDateToDateTime($event->dtend_array[3]);

	//header
	$ret_string .=  '<div class="event-header">';
	$ret_string .=  '<div style="text-align: left; padding-left: 5px;">'. $dtstart->format('d') .'</div>';
	$ret_string .=  '<div style="text-align: center;">'.$event->summary .'</div>';
	$ret_string .=  '<div style="text-align: right;  padding-right: 5px;">'. replaceMonthWithString($dtstart->format('n')) .'</div>';
	$ret_string .=  '</div>';

	//body
	$ret_string .=  '<div class="event-body rounded m-2 p-2 border border-2 border-white bg-white"  style="text-align: center;">';

	$ret_string .=  '<div>';

	//date start
	$ret_string .=  '<strong>'.replaceWeekdayWithString($dtstart->format('w')) .', ';
	$ret_string .=   $dtstart->format('d.m.Y') .'</strong> ';

	if( $isMulitday){
		$ret_string .=" <em> bis </em><br>";
		
		if($isAllDay){
			//substract 1 day
			$dtend = $dtend->modify("-1 day");
		}

		$ret_string .=  '<strong>'.replaceWeekdayWithString($dtend->format('w')) .', ';
		$ret_string .=   $dtend->format('d.m.Y') .'</strong> ';
	}
	
	$ret_string .=  '</div>'; //date start div

	//display time if not allday
	if(!$isAllDay)
	{
		$ret_string .=  '<div>';
		$ret_string .=  '<strong>Beginn:</strong> '.$dtstart->format('H:i') .' Uhr ';
		$ret_string .=  '<strong>Ende:</strong> '.$dtend->format('H:i') .' Uhr';
		$ret_string .=  '</div>';
	}

	//location
	if($event->location != ""){
		$ret_string .=  '<div><strong>Ort: </strong>'.$event->location .'</div> ';
	}

	//description
	if($event->description){
		$ret_string .=  '<em>'.$event->description .'</em>';
	}

	//event body content
	$ret_string .=  '</div>';

	//outter div end
	$ret_string .=  '</div>';



	} //while loop end

	return $ret_string;
}
add_shortcode( 'smj-ulm-cal_nextevents', 'shortcode_smj_ulm_cal_nextevents' );

