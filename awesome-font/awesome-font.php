<?php
/*
Plugin Name: Awesome Font
Plugin URI: http://kyleriemensnider.com
Description: Gives the User the ability to use custom fonts in their WordPress site
Version: 1.0
Author: Kyle Riemensnider
Author URI: http://kyleriemensnider.com
License: GPLv2 or later
*/
/**
 * Add an options page for the plugin.
 *
 * @since  1.0.
 *
 * @return void
 */
function kdr_awesome_fonts(){
	// Add new page under the "Settings" tab
	add_options_page(
		__('Kyle Fonts', 'kylefont'),
		__('Kyle Fonts','kylefont'),
		'manage_options',
		'kdr_awesome_fonts_options_page',
		'kdr_awesome_fonts_render_options_page'
	);
}
add_action('admin_menu','kdr_awesome_fonts');
/**
 * Render the options page.
 *
 * @since  1.0.
 *
 * @return void
 */
function kdr_awesome_fonts_render_options_page(){
	//get fonts squirl family name
		//$api_result = wp_remote_request('http://www.fontsquirrel.com/api/fontlist/all');
		//Decode the json request
		//$fonts = json_decode($api_result["body"]); 
		?>
		<div class="wrap">
			<h1><?php _e('Awesome Fonts Options');?></h2>		
			<form action="options.php" method="post">
				<?php settings_fields( 'kdr_awesome_fonts_settings' ); ?>
				<?php do_settings_sections( 'kdr_awesome_fonts_options_page' ); ?>
				<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes' ); ?>">
			</form>
			<?php //echo $upload_dir['baseurl']; ?>
		</div>
		<?php
}
function kdr_awesome_fonts_add_settings(){
	// Add the settings section to hold the interface
	add_settings_section(
		'kdr_awesome_fonts_main_settings',
		__( 'Awesome Fonts Controls' ),
		'kdr_awesome_fonts_render_main_settings_section',
		'kdr_awesome_fonts_options_page'
	);
	// Register which font family is chosen
	register_setting(
		'kdr_awesome_fonts_settings',
		'font_family_choice',
		'absint'
	);
	// Add the settings field to define the interface
	add_settings_field(
		'font_family_choice_field',
		__( 'Font Family Choice' ),
		'kdr_awesome_fonts_font_family_choice',
		'kdr_awesome_fonts_options_page',
		'kdr_awesome_fonts_main_settings'
	);
	// Register which html tag is chosen
	register_setting(
		'kdr_awesome_fonts_settings',
		'html_tag_choice',
		'absint'
	);
	// Add the settings field to define the interface
	add_settings_field(
		'kdr_html_tag_choice_field',
		__( 'Choose a Tag Type' ),
		'kdr_html_tag_choice_input',
		'kdr_awesome_fonts_options_page',
		'kdr_awesome_fonts_main_settings'
	);
}
add_action( 'admin_init', 'kdr_awesome_fonts_add_settings' );
/**
 * Render text to be displayed in the "squake_main_settings" section.
 *
 * @since  1.0.
 *
 * @return void
 */
function kdr_awesome_fonts_render_main_settings_section() {
?>
	<h3><?php _e('Use the dropdown selector to chose a font')?></h3>
<?php
}
function kdr_awesome_fonts_font_family_choice(){	
		$font_family_input = get_option( 'font_family_choice', $default = false );
	?>
	<select name="font_family_choice">
		<!--<option value="">Select a Font</option>-->
			<?php
			$fonts = kdr_awesome_fonts_fontfamily_jsoncall();
			$i=0;
			//if the json request works render a select box for the list of the family names
			//if(isset($api_result)){
				foreach($fonts as $key => $value){
				echo "<option value='".$i."' ". selected($i, $font_family_input).">".$fonts[$key]->family_name."</option>"; 
				$i++;
				}
			//}
			?>
	</select>
	<?php
//var_dump($font_family_input);
	$font_position = kdr_postion($font_family_input);
//$items = json_encode($font_position, true); 
//var_dump($font_position);
//var_dump($items{'family_name'}); 
//echo $font_position -> family_name;
//echo $font_position -> font_filename;
	$font_position_placement = wp_remote_request('http://www.fontsquirrel.com/fontfacekit/'.$font_position -> family_urlname.'');
var_dump($font_position_placement, filename);
//echo $font_position_placement;
//echo json_decode($font_position_placement["id"], true);

$upload_dir = wp_upload_dir('FONT/'.$font_position_placement);
 //$test = json_decode($font_position_placement);
 //var_dump($test);
 //$upload_dir = wp_upload_dir($font_position_placement); 
 //echo $upload_dir['baseurl']; 
//echo "<p style='font-family:'".."' ">;arg;oawreg;aer;oga;bg;iouvasbdf;gvabs;divba;sidubviawuebdf;vaushdiuvbSD:iuvAS</p>
}
/********

function for the postion

 *********/
function kdr_postion($postion){
	$fonts = kdr_awesome_fonts_fontfamily_jsoncall();
	return $fonts[$postion];
}
function kdr_awesome_fonts_fontfamily_jsoncall(){
		//get fonts squirl family name
		$api_result = wp_remote_request('http://www.fontsquirrel.com/api/fontlist/all');
		//Decode the json request
		return json_decode($api_result["body"]); 
}
function kdr_fontkit_call(){
	$font_position_placement = wp_remote_request('http://www.fontsquirrel.com/fontfacekit/'.$fonts_position.'');
}
//http://www.fontsquirrel.com/fontfacekit/{family_urlname}
/**
 * Render the input for the type of html tag.
 *
 * @since  1.0.
 *
 * @return void
 */
function kdr_html_tag_choice_input() {
	// Get the current number of buttons
	$html_tag_input = get_option( 'html_tag_choice', 2 );
?>
	<select name="html_tag_choice">
		<option value="1" <?php selected( 1, $html_tag_input ); ?>>p</option>
		<option value="2" <?php selected( 2, $html_tag_input ); ?>>h1</option>
		<option value="3" <?php selected( 3, $html_tag_input ); ?>>h2</option>
		<option value="4" <?php selected( 4, $html_tag_input ); ?>>h3</option>
		<option value="5" <?php selected( 5, $html_tag_input ); ?>>h4</option>
		<option value="6" <?php selected( 6, $html_tag_input ); ?>>h5</option>
		<option value="7" <?php selected( 7, $html_tag_input ); ?>>h6</option>
		<option value="8" <?php selected( 8, $html_tag_input ); ?>>ol</option>
		<option value="9" <?php selected( 9, $html_tag_input ); ?>>ul</option>
		<option value="10" <?php selected( 10, $html_tag_input ); ?>>link</option>
	</select>
<?php
// var_dump($html_tag_input);
// echo $html_tag_input;
 ?>
 <div class="" >
			<?php
				echo "<h2>Select a tag to assign to your font</h2>";			
//			var_dump($html_tag_input);
			$divs = array();
			$divs[1] = "<div><p>This is what a p tag looks like</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tempus porttitor tincidunt. In vel faucibus ligula, ut consectetur purus. In sagittis, dolor eu vestibulum sodales, magna ligula fermentum odio, in euismod mi eros non augue. Nunc id lacus et tellus pharetra cursus eu sed purus. Aliquam erat volutpat. Mauris mollis dolor nibh, et mollis ante auctor at. Praesent placerat massa et tortor ultricies placerat. Sed adipiscing est a neque imperdiet, id facilisis purus feugiat. Duis tincidunt mi est, nec imperdiet erat rhoncus non.</p></div>";
			$divs[2] = "<div><h1>This is what a h1 tag looks like</div>";
			$divs[3] = "<div><h2>This is what a h2 tag looks like</div>";
			$divs[4] = "<div><h3>This is what a h3 tag looks like</div>";
			$divs[5] = "<div><h4>This is what a h4 tag looks like</div>";
			$divs[6] = "<div><h5>This is what a h5 tag looks like</div>";
			$divs[7] = "<div><h6>This is what a h6 tag looks like</div>";
			$divs[8] = "<div><ol><li>This is what a ordered list looks like</li><li>This is what a ordered list looks like</li><li>This is what a ordered list looks like</li><li>This is what a ordered list looks like</li></ol></div>";
			$divs[9] = "<div><ul><li>This is what a unordered list looks like</li><li>This is what a unordered list looks like</li><li>This is what a unordered list looks like</li><li>This is what a unordered list looks like</li></ul></div>";
			$divs[10] = "<div><a>This is what a link tag looks like</a></div>";
			?>
		<?php
			$divsToDisplay = (int) $html_tag_input;
			if($divsToDisplay<1 || $divsToDisplay> 10)
			{
			    //Invalid value - add error handling or set default value
			    $divsToDisplay = 1;
			}
			for($divIdx=1; $divIdx<=$divsToDisplay; $divIdx++){
			if($divsToDisplay === $divIdx){
			    echo $divs[$divIdx];
			}
		}
		?>
	</div>
	<?php
}