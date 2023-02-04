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
    add_menu_page(
        'SMJ Ulm Kalender',
        'SMJ Ulm Kalender',
        'manage_options',
        'smj_ulm_cal_options',
        'smj_ulm_cal_options_page_html',
        plugin_dir_url(__FILE__) . 'assets/ics-calendar-icon-2021.svg', //todo icon
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


		<h4>Vollständige Liste einfügen:</h4>
		<div >
			<code style="vertical-align:middle; font-size: 1.2rem;" id="smj_full_list_copy">[smj-ulm-cal_fulllist]</code>
			<button class="button button-primary" style="vertical-align:middle;"  onclick="copyContent('smj_full_list_copy')">Shortcode in Zwischenablage kopieren</button>
		</div>
		<p><i>(Fügen den Shortcode auf deiner Seite/Beitrag ein)</i></p>

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

	<!--Log Section-->
	<div class="log_file ">
		<h2> Die letzten 10 Einträge in der Log Datei:</h2>
		<?php
		$log_file_path = plugin_dir_path(__FILE__) ."../data/logs.txt";
		$file = file($log_file_path);
		for ($i = max(0, count($file)-10); $i < count($file); $i++) {
			$splitted = explode("\t",$file[$i]);
			echo "<div><strong>".$splitted[0]."</strong>: " .$splitted[1] . "</div>";
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

    add_settings_section('smj_ulm_cal_main', 'Einstellungen', 'smj_ulm_cal_section_text', 'smj_ulm_cal');
						//id (slug)				//title				//callback print		   //page				//sections
    add_settings_field('smj_ulm_cal_url', 	'URL zum .ics Kalender', 	'smj_ulm_cal_setting_url', 	'smj_ulm_cal', 'smj_ulm_cal_main');
    add_settings_field('smj_ulm_cal_name', 	'Name des Kalenders: ', 	'smj_ulm_cal_setting_name', 'smj_ulm_cal', 'smj_ulm_cal_main');


}


function smj_ulm_cal_options_validate( $input ) {
	return $input; //$new_input todo
    $new_input = array();
    
    if( isset( $input['setting_1'] ) )
        $new_input['setting_1'] = sanitize_text_field( $input['setting_1'] );
    
    if( isset( $input['setting_2'] ) )
        $new_input['setting_2'] = absint( $input['setting_2'] );
    
    return $new_input;
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

