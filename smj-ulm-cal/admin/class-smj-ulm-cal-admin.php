<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Smj_Ulm_Cal
 * @subpackage Smj_Ulm_Cal/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smj_Ulm_Cal
 * @subpackage Smj_Ulm_Cal/admin
 * @author     Your Name <email@example.com>
 */
class Smj_Ulm_Cal_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $smj_ulm_cal    The ID of this plugin.
	 */
	private $smj_ulm_cal;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $smj_ulm_cal       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $smj_ulm_cal, $version ) {

		$this->smj_ulm_cal = $smj_ulm_cal;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smj_Ulm_Cal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smj_Ulm_Cal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->smj_ulm_cal, plugin_dir_url( __FILE__ ) . 'css/smj-ulm-cal-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Smj_Ulm_Cal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smj_Ulm_Cal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->smj_ulm_cal, plugin_dir_url( __FILE__ ) . 'js/smj-ulm-cal-admin.js', array( 'jquery' ), $this->version, false );

	}

}

//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_options_page
//!
//! Description:	add options page for smj_ulm_page
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
add_action( 'admin_menu', 'smj_ulm_cal_options_page' );
function smj_ulm_cal_options_page() {

	//The icon in Base64 format
	$icon_base64 = 'data:image/svg+xml;base64,PHN2ZyBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjIiIHZpZXdCb3g9IjAgMCAyMzMgMjU3IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Im0xNTEuODA1IDIzLjI3M2gtNzIuODMydi05LjMwOWMwLTcuNzA3LTYuMjU3LTEzLjk2NC0xMy45NjQtMTMuOTY0cy0xMy45NjMgNi4yNTctMTMuOTYzIDEzLjk2NHY5Ljc0M2MtMjguNzQ5IDMuNTIxLTUxLjA0NiAyOC4wNTEtNTEuMDQ2IDU3Ljc0OHYxMTYuMzYzYzAgMzIuMTEyIDI2LjA3MSA1OC4xODIgNTguMTgyIDU4LjE4MmgxMTYuMzY0YzMyLjExMSAwIDU4LjE4Mi0yNi4wNyA1OC4xODItNTguMTgydi0xMTYuMzYzYzAtMzAuMzY1LTIzLjMxMS01NS4zMjgtNTIuOTk2LTU3Ljk1NHYtOS41MzdjMC03LjcwNy02LjI1Ny0xMy45NjQtMTMuOTYzLTEzLjk2NC03LjcwNyAwLTEzLjk2NCA2LjI1Ny0xMy45NjQgMTMuOTY0em0tMTI5LjUwNyAxNzIuNjEzYzAgMjAuMzMzIDE2LjUwOCAzNi44NDIgMzYuODQxIDM2Ljg0MmgxMTIuNDk5YzIwLjMzNCAwIDM2Ljg0Mi0xNi41MDkgMzYuODQyLTM2Ljg0MnYtMTAyLjc5M2gtMTg2LjE4MnptMTQxLjM4OCAxNi4yNDZjMTUuMDY5IDAgMjkuMTg4LTcuNDY3IDI5LjE4OC0yMy4yMTUgMC0yNS42NTgtMzcuMDYyLTE5LjI3OC0zNy4wNjItMjcuOTY2IDAtMi40NDQgMi44NTEtNC43NTIgNy43MzgtNC43NTIgNC40OCAwIDcuODc0IDIuMDM3IDcuODc0IDUuNDMxdjEuMzU3aDIwLjA5MnYtMS4zNTdjMC0xMy4xNjktMTEuMjY3LTIyLjgwOC0yNy44My0yMi44MDgtMTYuNDI3IDAtMjcuOTY2IDkuNTAzLTI3Ljk2NiAyMy40ODcgMCAyNS4xMTUgMzYuOTI2IDE4LjE5MSAzNi45MjYgMjcuODMgMCAyLjg1MS0zLjM5NCA0LjYxNi04LjE0NSA0LjYxNi01LjE1OSAwLTkuNTAzLTIuMTcyLTkuNTAzLTYuMTA5di0xLjYzaC0yMC4yMjh2MS42M2MwIDEzLjU3NSAxMS41MzkgMjMuNDg2IDI4LjkxNiAyMy40ODZ6bS02My45NDIgMGMxOC4xOTEgMCAzMC4xMzgtMTEuNDA0IDMwLjEzOC0yOC43ODF2LTIuMDM2aC0yMC41djIuNTc5YzAgNi4yNDUtMy45MzYgOS45MS05LjYzOCA5LjkxLTcuMTk1IDAtMTAuNzI1LTQuMDcyLTEwLjcyNS0xMS44MTF2LTEzLjAzMmMwLTcuNzM5IDMuNjY1LTExLjgxMSAxMC43MjUtMTEuODExIDUuNzAyIDAgOS42MzggMy42NjUgOS42MzggOS45MXYyLjU3OWgyMC41di0yLjAzNmMwLTE3LjM3Ny0xMS45NDctMjguNzgxLTMwLjI3NC0yOC43ODEtMTkuMjc4IDAtMzAuOTUzIDExLjY3Ni0zMC45NTMgMzAuMDAzdjEzLjMwNGMwIDE4LjMyOCAxMS42NzUgMzAuMDAzIDMxLjA4OSAzMC4wMDN6bS02MC40MTMtMi4wMzdoMjAuMzY0di02OS4yMzZoLTIwLjM2NHptMC03Ni41NjdoMjAuMzY0di0xOS44MjFoLTIwLjM2NHoiIGZpbGw9IiNhN2FhYWQiLz48L3N2Zz4=';
			
	//The icon in the data URI scheme
	$icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

    add_menu_page(
        'SMJ Ulm Kalender',
        'SMJ Ulm Kalender',
        'manage_options',
        'smj_ulm_cal_options',
        'smj_ulm_cal_options_page_html',
		$icon_data_uri, //todo icon
        20
    );
}

//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_options_page_html
//!
//! Description:	returns html for the smj_ulm_cal page
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_options_page_html() {
	?>
    <div class="wrap">

	<h1>SMJ Ulm Kalender: Einstellungen</h1>

	<!--Usage-->
	<div>
		<h2>Benutzung </h2>
		<p>Der Kalender wird jede Stunde aktualisiert. Eine manuelle Aktualisierung kann mit dem Button <i>"Aktualisiere Kalender"</i> durchgeführt werden.</p>


		<h4>"Alle Termine" Liste einfügen:</h4>
		<div >
			<code style="vertical-align:middle; font-size: 1.2rem;" id="smj_full_list_copy">[smj-ulm-cal_fulllist]</code>
			<button class="button button-primary" style="vertical-align:middle;"  onclick="copyContent('smj_full_list_copy')">Shortcode in Zwischenablage kopieren</button>
		</div>
		<h4>"Nächste Termine" Liste einfügen:</h4>
		<div >
			<code style="vertical-align:middle; font-size: 1.2rem;" id="smj_next_events_list_copy">[smj-ulm-cal_nextevents]</code>
			<button class="button button-primary" style="vertical-align:middle;"  onclick="copyContent('smj_next_events_list_copy')">Shortcode in Zwischenablage kopieren</button>
		</div>
		<p><i>(Füge den Shortcode auf deiner Seite/Beitrag ein)</i></p>

		<script>
			const copyContent = async (domElement) => {
				let text = document.getElementById(domElement).innerHTML;
				await navigator.clipboard.writeText(text);
			}
		</script>
	</div>
  	<!--Usage-->

	<hr style="margin: 20px;"/>

	<!--Settings From-->
	<div>
		<h1>Einstellungen</h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg_options"
			settings_fields( 'smj_ulm_cal_options' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'smj_ulm_cal' );
			// output save settings button
			submit_button( 'Einstellungen speichern');
			?>
		</form>
	</div>
	<!--Settings From Ende-->

	<hr style="margin: 20px;"/>

	<div class="log_file ">
		<div style="display: flex;   gap: 10px;">

		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<!-- form fields go here -->
			<input type="hidden" name="action" value="smj_ulm_cal_refresh_calender">
			<input class="button button-primary" type="submit" value="Aktualisiere Kalender">
		</form>
			
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<!-- form fields go here -->
			<input type="hidden" name="action" value="smj_ulm_cal_delete_cache">
			<input class="button button-primary" type="submit" value="Lösche Kalender Cache">
		</form>

		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<!-- form fields go here -->
			<input type="hidden" name="action" value="smj_ulm_cal_delete_log">
			<input class="button button-primary" type="submit" value="Lösche Log Datei">
		</form>

		</div>	
	</div>

	<!--Log Section-->
	<div class="log_file ">
		<h2> Die letzten 10 Einträge in der Log Datei:</h2>
		<?php
		$log_file_path = plugin_dir_path(__FILE__) ."../data/logs.txt";
		if(file_exists($log_file_path)){
			$file = file($log_file_path);
			for ($i = max(0, count($file)-10); $i < count($file); $i++) {
				$splitted = explode("\t",$file[$i]);
				echo "<div><strong>".$splitted[0]."</strong>: " .$splitted[1] . "</div>";
			}
		}
		?>
	</div>
	<!--Log Section End-->

	</div>
    <?php
}

//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_options_page_html
//!
//! Description:	returns html for the smj_ulm_cal page
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------


// Register the plugin settings
add_action('admin_init', 'smj_ulm_cal_admin_init');

function smj_ulm_cal_admin_init() {
    register_setting('smj_ulm_cal_options', 'smj_ulm_cal_options', 'smj_ulm_cal_options_validate');

    add_settings_section('smj_ulm_cal_all_events', 'Alle Termine', 'smj_ulm_cal_section_text', 'smj_ulm_cal');
						//id (slug)				//title				//callback print		   //page				//sections
    add_settings_field('smj_ulm_cal_url', 	'URL zum .ics Kalender', 	'smj_ulm_cal_setting_url', 	'smj_ulm_cal', 'smj_ulm_cal_all_events');
    add_settings_field('smj_ulm_cal_name', 	'Name des Kalenders: ', 	'smj_ulm_cal_setting_name', 'smj_ulm_cal', 'smj_ulm_cal_all_events');

	add_settings_section('smj_ulm_cal_next_events', 'Nächste Termine:', 'smj_ulm_cal_section_text', 'smj_ulm_cal');
    add_settings_field('smj_ulm_next_events_num', 	'Maximale Anzahl an Events: ', 	'smj_ulm_cal_setting_next_events_num', 'smj_ulm_cal', 'smj_ulm_cal_next_events');
    add_settings_field('smj_ulm_next_events_months', 'Zeige nächste Montage;: ', 	'smj_ulm_cal_setting_next_events_months', 'smj_ulm_cal', 'smj_ulm_cal_next_events');



}
//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_options_validate
//!
//! Description:	returns html for the smj_ulm_cal page
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_options_validate( $input ) {
	return $input; //$new_input todo
    $new_input = array();
    
    if( isset( $input['setting_1'] ) )
        $new_input['setting_1'] = sanitize_text_field( $input['setting_1'] );
    
    if( isset( $input['setting_2'] ) )
        $new_input['setting_2'] = absint( $input['setting_2'] );
    
    return $new_input;
}
//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_section_text
//!
//! Description:	smj_ulm_cal_section_text
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_section_text(){
	//todo
}

// Display the "URL" setting field
function smj_ulm_cal_setting_url() {
    $options = get_option('smj_ulm_cal_options');
	
    echo "<input id='smj_ulm_cal_url' name='smj_ulm_cal_options[smj_ulm_cal_url]' size='100' type='text' value='{$options['smj_ulm_cal_url']}' />";
}


// Display the "URL" setting field
function smj_ulm_cal_setting_name() {
    $options = get_option('smj_ulm_cal_options');
    echo "<input id='smj_ulm_cal_name'   name='smj_ulm_cal_options[smj_ulm_cal_name]' size='100' type='text' value='{$options['smj_ulm_cal_name']}' />";
}

// Display the "next_events_num" field
function smj_ulm_cal_setting_next_events_num() {
    $options = get_option('smj_ulm_cal_options');
    echo "<input id='smj_ulm_next_events_num'   name='smj_ulm_cal_options[smj_ulm_next_events_num]' size='100' type='text' value='{$options['smj_ulm_next_events_num']}' />";

}
// Display smj_ulm_next_events_months
function smj_ulm_cal_setting_next_events_months() {
    $options = get_option('smj_ulm_cal_options');
    echo "<input id='smj_ulm_next_events_months'   name='smj_ulm_cal_options[smj_ulm_next_events_months]' size='100' type='text' value='{$options['smj_ulm_next_events_months']}' />";
}



//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_delete_cache
//!
//! Description:	post request: delte log file
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_delete_cache() {
	if ( is_user_logged_in() ) {
		$dir_path = plugin_dir_path(__FILE__) ."../data/calender.ics";
		unlink($dir_path);
		wp_redirect(admin_url("?page=smj_ulm_cal_options"));
	} 
}
add_action('admin_post_smj_ulm_cal_delete_cache', 'smj_ulm_cal_delete_cache');


//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_delete_log
//!
//! Description:	post request: calender cache
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_delete_log() {
	if ( is_user_logged_in() ) {
		$dir_path = plugin_dir_path(__FILE__) ."../data/logs.txt";
		unlink($dir_path);
		wp_redirect(admin_url("?page=smj_ulm_cal_options"));
	} 
}
add_action('admin_post_smj_ulm_cal_delete_log', 'smj_ulm_cal_delete_log');

//------------------------------------------------------------------------------
//!
//! Function: 		smj_ulm_cal_refresh_calender
//!
//! Description:	post request: calender cache
//!
//! Parameter: 		None
//!
//! Return: 		None
//------------------------------------------------------------------------------
function smj_ulm_cal_refresh_calender() {
	if ( is_user_logged_in() ) {
		smj_ulm_cal__get_calender();
		wp_redirect(admin_url("?page=smj_ulm_cal_options"));
	} 
}
add_action('admin_post_smj_ulm_cal_refresh_calender', 'smj_ulm_cal_refresh_calender');