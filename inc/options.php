<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

if (! class_exists('X2_Theme_Options')) 
{
	class X2_Theme_Options
	{
		// Init
		public function __construct()
		{
			// We only need to register the admin panel on the back-end
			if ( is_admin() ) 
			{
				add_action( 'admin_menu', array( 'X2_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'X2_Theme_Options', 'register_settings' ) );
				//add_action( 'admin_init', array( 'X2_Theme_Options', 'remove_x2_option' ) );
			}
		}
		
		// Returns all theme options
		public static function get_theme_options() 
		{
			return get_option( 'theme_options' );
		}
		
		// Returns single theme option
		public static function get_theme_option($id)
		{
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}
		
		// Add sub menu page
		public static function add_admin_menu()
		{
			add_menu_page(
				esc_html__( 'X2 Theme Settings', 'text-domain' ),
				esc_html__( 'X2 Theme Settings', 'text-domain' ),
				'manage_options',
				'x2-theme-settings',
				array( 'X2_Theme_Options', 'create_admin_page' )
			);
		}
		
		// Register a setting and its sanitization callback. One setting with all options in array.
		public static function register_settings() 
		{
			register_setting( 'theme_options', 'theme_options', array( 'X2_Theme_Options', 'sanitize' ) );
		}
		
		public static function remove_x2_option () 
		{
			//$option_name = 'theme_mods_twentyseventeenX2';
			//$option_name = 'x2Tr';
			//$option_name = 'X2_Theme_Options';
			//$option_name = 'twentyseventeenX2';
			$option_name = 'theme_options';
			
			delete_option( $option_name );
			delete_site_option( $option_name );
			remove_theme_support( $option_name );
		}
		
		// Sanitization callback
		public static function sanitize( $options ) 
		{
			// If we have options lets sanitize them
			if ( $options ) 
			{
				// Checkbox
				if ( ! empty( $options['checkbox_example'] ) )
				{
					$options['checkbox_example'] = 'on';
				}
				else 
				{
					unset( $options['checkbox_example'] ); // Remove from options if not checked
				}

				// Input
				if ( ! empty( $options['input_example'] ) )
				{
					$options['input_example'] = sanitize_text_field( $options['input_example'] );
				}
				else
				{
					unset( $options['input_example'] ); // Remove from options if empty
				}
				// Select
				if ( ! empty( $options['select_example'] ) )
				{
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}
			}
			// Return sanitized options
			return $options;
		}
		
		// Settings page output
		public static function create_admin_page() 
		{
			?>
			<div class="wrap">

				<h1><?php esc_html_e( 'X2 Theme Options', 'text-domain' ); ?></h1>
				
				
				<div>
					Be sure to read the configuration guide. Initial Theme Settings need to be made to the Official Twenty Seventeen Child Theme Settings.<BR />
					<a style="cursor: pointer;" onclick="ShowHideReadMe();">ReadMe</a>
					<script>
						function ShowHideReadMe()
						{
							if(document.getElementById("ReadMe").style.display == "none")
							{
								document.getElementById("ReadMe").style.display = "block";
							}
							else
							{
								document.getElementById("ReadMe").style.display = "none";
							}
						}
					</script>
					<div id="ReadMe" style="display: none;">
						<div>Site Identity</div>
						<div>
							<div>Set Logo</div>
							<div>Set Title</div>
							<div>Set Tagpne</div>
							<div>Set Site Icon</div>
						</div>
						<div>Color Scheme</div>
						<div>
							<div>Set Color Scheme to Dark</div>
							<div>Set Header Text Color to White #fff</div>
						</div>
						<div>Header Media - Optional large images or YouTube Videos as Background. These are used for Parallax Effects</div>
						<div>Menus</div>
						<div>
							<div>Create Menu under Appearance or Under the Official Theme Settings</div>
							<div>Set Menu to Top</div>
						</div>
						<div>Widgets - Front Page Widgets</div>
						<div>
							<div>Create under Appearance or Under the Official Theme Settings</div>
							<div>Use only Text & Image Widgets</div>
							<div>Note for Image Widget - Use Caption and Title to add text to Image Widget</div>
						</div>
						<div>Static Front Page</div>
						<div>
							<div>Create a "Home" page then set Front Page to "Home"</div>
							<div>If you plan to use a blog then create a "Blog" page then set Posts Page to "Blog"</div>
						</div>
						<div>Theme Options</div>
						<div>
							<div>This custom theme was built around a single column layout but shodivd work fine as a 2 column.</div>
							<div>ToDo: Need to tweak for 2 columns and mod for 3</div>
							<div>Front Page Sections - Configure to display page content on home/landing page for a single page layout. Set featured image to gain parrallax effects.</div>
							<div>You can create more sections by setting the number of sections you want on this page.</div>
						</div>
					</div>
				</div><br /><br /><br />

				<form class="X2ThemeOptionsForm" method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>
					
					<div class="X2AdminSection">
						<h2>Layout</h2>
						<div class="X2AdminSectionPart X2LayoutSection">
							<?php $value = self::get_theme_option( 'site_layout' ); ?>
							<div class="X2LayoutSelector">
								<div class="X2LayoutItem">
									<img src="<?php echo url_path; ?>images/Layout1.png" /><br />
									<input type="radio" name="theme_options[site_layout]" value="1" <?php if (isset($value) && $value=="1") echo "checked";?>>
									<p>Nav pushed to top</p>
								</div>
								<div class="X2LayoutItem">
									<img src="<?php echo url_path; ?>images/Layout2.png" /><br />
									<input type="radio" name="theme_options[site_layout]" value="2" <?php if (isset($value) && $value=="2") echo "checked";?>>
									<p>Standard layout</p>
								</div>
							</div>
						</div>
					</div>
					
					<!--<div class="X2AdminSection">
						<h2>Slider</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'x2Tr' ); ?>
							<p>Slider:&nbsp;</p><input type="range" id="x2Tr" name="theme_options[x2Tr]" value="<?php echo esc_attr( $value ); ?>" min="0" max="1" step=".01" onchange="showValue(this.value)"> Value: <span id="x2TrVal"><?php echo esc_attr( $value ); ?></span>
							<script type="text/javascript">
								function showValue(newValue)
								{
									document.getElementById("x2TrVal").innerHTML=newValue;
								}
							</script>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'x2Tr' ); ?>
							<p>Slider:&nbsp;</p><input type="range" id="x2Tr" name="theme_options[x2Tr]" value="<?php echo esc_attr( $value ); ?>" min="0" max="1" step=".01" onchange="showValue(this.value)"> Value: <span id="x2TrVal"><?php echo esc_attr( $value ); ?></span>
							<input type="range" list="tickmarks">
							<datalist id="tickmarks">
							  <option value="0" label="0%">
							  <option value="10">
							  <option value="20">
							  <option value="30">
							  <option value="40">
							  <option value="50" label="50%">
							  <option value="60">
							  <option value="70">
							  <option value="80">
							  <option value="90">
							  <option value="100" label="100%">
							</datalist>
							<script type="text/javascript">
								function showValue(newValue)
								{
									document.getElementById("x2TrVal").innerHTML=newValue;
								}
							</script>
						</div>
					</div>-->
					
					
					<div class="X2AdminSection">
						<h2>Front Page</h2>
						<div class="X2AdminSectionPart">
							<?php // Number of Front Page Panels ?>
							<?php $value = self::get_theme_option( 'num_front_panels' ); ?>
							<p>Num Front Page Panels:&nbsp;</p><input type="text" name="theme_options[num_front_panels]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php // Number of Front Page Panels ?>
							<?php $value = self::get_theme_option( 'landing_page_width' ); ?>
							<p>Landing Page Width:&nbsp;</p><input type="text" name="theme_options[landing_page_width]" value="<?php echo esc_attr( $value ); ?>"><br />
							<p>Width in percent or pixels Examples: 100% or 400px</p>
						</div>
					</div>
					
					<div class="X2AdminSection">
						<h2>Site Overall</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'bkg_color' ); ?>
							<p>Background Color (Very Back):&nbsp;</p><input type="text" class="colorPicker" name="theme_options[bkg_color]" value="<?php echo $value; ?>">
						</div>
						
						<div class="X2AdminSectionPart">
<?php
	
?>
						
							<?php $value = self::get_theme_option( 'bkg_image' ); ?>
							<p>Background Image:</p><br />
							<?php
							if( intval( $value ) > 0 ) 
							{
								// Change with the image size you want to use
								$image = wp_get_attachment_image( $value, 'thumb', false, array( 'id' => 'x2-preview-image' ) );
							}
							else 
							{
								// Some default image
								$value = '';
								$image = '';
								?>
									<p id="x2-preview-image">No image defined</p>
								<?php
							}
							?>
							
							<?php echo $image; ?> <br />
							
							<input type='button' value="<?php esc_attr_e( 'Select a image', 'mytextdomain' ); ?>" id="x2_media_manager"/>
							<input type='button' value="Remove Image" onclick="x2RemoveBKGImage();" />
							<input onchange="x2bkgimgchange(this.value);" type="hidden" name="theme_options[bkg_image]" id="x2_image_id" value="<?php echo $value; ?>" class="regular-text" />
							<br />
							<?php $value = self::get_theme_option( 'bkg_image_size' ); ?>
							<p>Background Image Size:&nbsp;</p><input type="text" name="theme_options[bkg_image_size]" value="<?php echo $value; ?>">
							<br />
							
							<?php $value = self::get_theme_option( 'bkg_image_repeat' ); ?>
							<p>Background Image Repeat:&nbsp;</p>
							<select name="theme_options[bkg_image_repeat]">
							<?php
							$options = array(
									'repeat' => esc_html__( 'repeat', 'text-domain' ),
									'repeat-x' => esc_html__( 'repeat-x', 'text-domain' ),
									'repeat-y' => esc_html__( 'repeat-y', 'text-domain' ),
									'no-repeat' => esc_html__( 'no-repeat', 'text-domain' ),
								);
							foreach ( $options as $id => $label ) { ?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
										<?php echo strip_tags( $label ); ?>
									</option>
								<?php } ?>
							</select>
							<?php $value = self::get_theme_option( 'bkg_image_attachment' ); ?>
							<p>Background Image Attachment: &nbsp;</p>
							<select name="theme_options[bkg_image_attachment]">
							<?php
							$options = array(
									'scroll' => esc_html__( 'scroll', 'text-domain' ),
									'fixed' => esc_html__( 'fixed', 'text-domain' ),
									'local' => esc_html__( 'local', 'text-domain' ),
								);
							foreach ( $options as $id => $label ) { ?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
										<?php echo strip_tags( $label ); ?>
									</option>
								<?php } ?>
							</select>
						</div>
						
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'text_color' ); ?>
							<p>Text Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[text_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'link_color' ); ?>
							<p>Link Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[link_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'link_hover_color' ); ?>
							<p>Link Hover Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[link_hover_color]" value="<?php echo $value; ?>">
						</div>
						
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'site_font' ); ?>
							<p>Site Font:&nbsp;</p>
							<select name="theme_options[site_font]">
								<?php
								$options = array(
									'Arial,Arial,Helvetica,sans-serif' => esc_html__( 'Arial,Arial,Helvetica,sans-serif', 'text-domain' ),
									'Courier New,Courier New,Courier,monospace' => esc_html__( 'Courier New,Courier New,Courier,monospace', 'text-domain' ),
									'Georgia,Georgia,serif' => esc_html__( 'Georgia,Georgia,serif', 'text-domain' ),
									'Impact,Charcoal,sans-serif' => esc_html__( 'Impact,Charcoal,sans-serif', 'text-domain' ),
									'Lucida Sans Unicode,Lucida Grande,sans-serif' => esc_html__( 'Lucida Sans Unicode,Lucida Grande,sans-serif', 'text-domain' ),
									'Times New Roman,Times,serif' => esc_html__( 'Times New Roman,Times,serif', 'text-domain' ),
									'Gill Sans,Geneva,sans-serif' => esc_html__( 'Gill Sans,Geneva,sans-serif', 'text-domain' ),
								);
								foreach ( $options as $id => $label ) { ?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
										<?php echo strip_tags( $label ); ?>
									</option>
								<?php } ?>
							</select>
						</div>
						
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'h_fnt_color' ); ?>
							<p>Heading (h1, h2, h3, h4, h5) Font Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[h_fnt_color]" value="<?php echo $value; ?>">
						</div>
						
						
						
						
					</div>
					
					<div class="X2AdminSection">
						<h2>Header</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'head_bkg_color' ); ?>
							<p>Header Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[head_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="head_borders">
								<div class="brdrinput">
									<?php $value = self::get_theme_option( 'head_borders' ); ?>
									<input type="text" name="theme_options[head_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'head_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'head_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'head_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'head_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("head_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'head_border_thickness' ); ?>
							<p>Border Thickness:&nbsp;</p><input type="text" name="theme_options[head_border_thickness]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'head_border_color' ); ?>
							<p>Border Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[head_border_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'head_border_style' ); ?>
							<p>Border Style:&nbsp;</p>
							<select name="theme_options[head_border_style]">
								<?php
								$options = array(
									'none' => esc_html__( 'none', 'text-domain' ),
									'hidden' => esc_html__( 'hidden', 'text-domain' ),
									'dotted' => esc_html__( 'dotted', 'text-domain' ),
									'dashed' => esc_html__( 'dashed', 'text-domain' ),
									'solid' => esc_html__( 'solid', 'text-domain' ),
									'double' => esc_html__( 'double', 'text-domain' ),
									'groove' => esc_html__( 'groove', 'text-domain' ),
									'ridge' => esc_html__( 'ridge', 'text-domain' ),
									'inset' => esc_html__( 'inset', 'text-domain' ),
									'outset' => esc_html__( 'outset', 'text-domain' ),
									'initial' => esc_html__( 'initial', 'text-domain' ),
									'inherit' => esc_html__( 'inherit', 'text-domain' ),
								);
								foreach ( $options as $id => $label ) { ?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
										<?php echo strip_tags( $label ); ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'show_title_checkbox' ); ?>
							<p>Show Title:&nbsp;</p><input type="checkbox" name="theme_options[show_title_checkbox]" <?php checked( $value, 'on' ); ?>>
							
							<?php $value = self::get_theme_option( 'site_title_color' ); ?>
							<p>Title Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[site_title_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'show_description_checkbox' ); ?>
							<p>Show Description:&nbsp;</p><input type="checkbox" name="theme_options[show_description_checkbox]" <?php checked( $value, 'on' ); ?>>
							
							<?php $value = self::get_theme_option( 'site_description_color' ); ?>
							<p>Description Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[site_description_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'show_logo_checkbox' ); ?>
							<p>Show Logo:&nbsp;</p><input type="checkbox" name="theme_options[show_logo_checkbox]" <?php checked( $value, 'on' ); ?>>
						</div>
					</div>
					
					
					<div class="X2AdminSection">
						<h2>Navigation</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_bar_bkg_color' ); ?>
							<p>Navigation Bar Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[nav_bar_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_bkg_color' ); ?>
							<p>Navigation Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[nav_bkg_color]" value="<?php echo $value; ?>">
						</div>
						
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_sel_item_bkg_color' ); ?>
							<p>Navigation Selected Item Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[nav_sel_item_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_item_link_color' ); ?>
							<p>Navigation Item Link Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[nav_item_link_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_sel_item_link_color' ); ?>
							<p>Navigation Selected Item Link Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[nav_sel_item_link_color]" value="<?php echo $value; ?>">
						</div>
						
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="nav_bar_borders">
								<div class="brdrinput">
									<?php $value = self::get_theme_option( 'nav_bar_borders' ); ?>
									<input type="text" name="theme_options[nav_bar_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'nav_bar_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'nav_bar_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'nav_bar_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'nav_bar_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("nav_bar_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_bar_border_thick' ); ?>
							<p>Nav Bar Border Thickness:&nbsp;</p><input type="text" name="theme_options[nav_bar_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'nav_bar_border_style' ); ?>
							<p>Nav Bar Border Style:&nbsp;</p>
							<select name="theme_options[nav_bar_border_style]">
							<?php
							$options = array(
								'none' => esc_html__( 'none', 'text-domain' ),
								'hidden' => esc_html__( 'hidden', 'text-domain' ),
								'dotted' => esc_html__( 'dotted', 'text-domain' ),
								'dashed' => esc_html__( 'dashed', 'text-domain' ),
								'solid' => esc_html__( 'solid', 'text-domain' ),
								'double' => esc_html__( 'double', 'text-domain' ),
								'groove' => esc_html__( 'groove', 'text-domain' ),
								'ridge' => esc_html__( 'ridge', 'text-domain' ),
								'inset' => esc_html__( 'inset', 'text-domain' ),
								'outset' => esc_html__( 'outset', 'text-domain' ),
								'initial' => esc_html__( 'initial', 'text-domain' ),
								'inherit' => esc_html__( 'inherit', 'text-domain' ),
							);
							foreach ( $options as $id => $label ) { ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
									<?php echo strip_tags( $label ); ?>
								</option>
							<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="X2AdminSection">
						<h2>Content Body</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_body_bkg_color' ); ?>
							<p>Content Body Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[content_body_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="content_body_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'content_body_borders' );
									?>
									<input type="text" name="theme_options[content_body_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'content_body_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'content_body_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'content_body_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'content_body_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("content_body_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_body_border_thick' ); ?>
							<p>Border Thickness:&nbsp;</p><input type="text" name="theme_options[content_body_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_body_border_style' ); ?>
							<p>Border Style:&nbsp;</p>
							<select name="theme_options[content_body_border_style]">
							<?php
							$options = array(
								'none' => esc_html__( 'none', 'text-domain' ),
								'hidden' => esc_html__( 'hidden', 'text-domain' ),
								'dotted' => esc_html__( 'dotted', 'text-domain' ),
								'dashed' => esc_html__( 'dashed', 'text-domain' ),
								'solid' => esc_html__( 'solid', 'text-domain' ),
								'double' => esc_html__( 'double', 'text-domain' ),
								'groove' => esc_html__( 'groove', 'text-domain' ),
								'ridge' => esc_html__( 'ridge', 'text-domain' ),
								'inset' => esc_html__( 'inset', 'text-domain' ),
								'outset' => esc_html__( 'outset', 'text-domain' ),
								'initial' => esc_html__( 'initial', 'text-domain' ),
								'inherit' => esc_html__( 'inherit', 'text-domain' ),
							);
							foreach ( $options as $id => $label ) { ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
									<?php echo strip_tags( $label ); ?>
								</option>
							<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="X2AdminSection">
						<h2>Content Article Post Page</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_bkg_color' ); ?>
							<p>Content Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[content_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="content_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'content_borders' );
									?>
									<input type="text" name="theme_options[content_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'content_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'content_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'content_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'content_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("content_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_border_thick' ); ?>
							<p>Border Thickness:&nbsp;</p><input type="text" name="theme_options[content_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'content_border_style' ); ?>
							<p>Border Style:&nbsp;</p>
							<select name="theme_options[content_border_style]">
							<?php
							$options = array(
								'none' => esc_html__( 'none', 'text-domain' ),
								'hidden' => esc_html__( 'hidden', 'text-domain' ),
								'dotted' => esc_html__( 'dotted', 'text-domain' ),
								'dashed' => esc_html__( 'dashed', 'text-domain' ),
								'solid' => esc_html__( 'solid', 'text-domain' ),
								'double' => esc_html__( 'double', 'text-domain' ),
								'groove' => esc_html__( 'groove', 'text-domain' ),
								'ridge' => esc_html__( 'ridge', 'text-domain' ),
								'inset' => esc_html__( 'inset', 'text-domain' ),
								'outset' => esc_html__( 'outset', 'text-domain' ),
								'initial' => esc_html__( 'initial', 'text-domain' ),
								'inherit' => esc_html__( 'inherit', 'text-domain' ),
							);
							foreach ( $options as $id => $label ) { ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
									<?php echo strip_tags( $label ); ?>
								</option>
							<?php } ?>
							</select>
						</div>
						
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'show_post_date' ); ?>
							<p>Show Posted Date & Author:&nbsp;</p><input type="checkbox" name="theme_options[show_post_date]" <?php checked( $value, 'on' ); ?>>
						</div>
						
					</div>
					
					<div class="X2AdminSection">
						<h2>Form Elements Buttons Input Fields</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_bkg_color' ); ?>
							<p>Form Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[form_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_fnt_color' ); ?>
							<p>Form Font Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[form_fnt_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_input_color' ); ?>
							<p>Form Input Inside Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[form_input_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_item_bkg_color' ); ?>
							<p>Form Item Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[form_item_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'btn_bkg_color' ); ?>
							<p>Button Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[btn_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Form Borders:&nbsp;</p>
							<div class="ddlwrapper" id="form_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'form_borders' );
									?>
									<input type="text" name="theme_options[form_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'form_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'form_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'form_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'form_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("form_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_border_thick' ); ?>
							<p>Form Border Thickness:&nbsp;</p><input type="text" name="theme_options[form_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'form_border_style' ); ?>
							<p>Form Border Style:&nbsp;</p>
							<select name="theme_options[form_border_style]">
							<?php
							$options = array(
								'none' => esc_html__( 'none', 'text-domain' ),
								'hidden' => esc_html__( 'hidden', 'text-domain' ),
								'dotted' => esc_html__( 'dotted', 'text-domain' ),
								'dashed' => esc_html__( 'dashed', 'text-domain' ),
								'solid' => esc_html__( 'solid', 'text-domain' ),
								'double' => esc_html__( 'double', 'text-domain' ),
								'groove' => esc_html__( 'groove', 'text-domain' ),
								'ridge' => esc_html__( 'ridge', 'text-domain' ),
								'inset' => esc_html__( 'inset', 'text-domain' ),
								'outset' => esc_html__( 'outset', 'text-domain' ),
								'initial' => esc_html__( 'initial', 'text-domain' ),
								'inherit' => esc_html__( 'inherit', 'text-domain' ),
							);
							foreach ( $options as $id => $label ) { ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
									<?php echo strip_tags( $label ); ?>
								</option>
							<?php } ?>
							</select>
						</div>
						<div class="X2AdminSectionPart">
							<p>Form Item Borders:&nbsp;</p>
							<div class="ddlwrapper" id="form_item_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'form_item_borders' );
									?>
									<input type="text" name="theme_options[form_item_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'form_item_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'form_item_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'form_item_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'form_item_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("form_item_borders"));
								</script>
							</div>
						</div>
					</div>
					
					<div class="X2AdminSection">
						<h2>Front Page Tile Widgets</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'fptw_border_color' ); ?>
							<p>Border Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[fptw_border_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'fptw_font_color' ); ?>
							<p>Font Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[fptw_font_color]" value="<?php echo $value; ?>">
						</div>	
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'fptw_border_thick' ); ?>
							<p>Border Thickness:&nbsp;</p><input type="text" name="theme_options[fptw_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="fptw_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'fptw_borders' );
									?>
									<input type="text" name="theme_options[fptw_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'fptw_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'fptw_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'fptw_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'fptw_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("fptw_borders"));
								</script>
							</div>
						</div>
					</div>
					
					<div class="X2AdminSection">
						<h2>Footer</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'footer_fnt_color' ); ?>
							<p>Footer Font Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[footer_fnt_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'footer_bkg_color' ); ?>
							<p>Footer Background Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[footer_bkg_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<p>Borders:&nbsp;</p>
							<div class="ddlwrapper" id="footer_borders">
								<div class="brdrinput">
									<?php 
										$value = self::get_theme_option( 'footer_borders' );
									?>
									<input type="text" name="theme_options[footer_borders]" value="<?php echo $value; ?>" /><img src="<?php echo url_path; ?>images/DropDown.png" />
								</div>
								<div class="brdrwrap">
									<div class="top" status="off" onclick="X2_BorderSelect(this, 'footer_borders');" style="">T</div>
									<div class="left" status="off" onclick="X2_BorderSelect(this, 'footer_borders');" style=""><p>L</p></div>
									<div class="right" status="off" onclick="X2_BorderSelect(this, 'footer_borders');" style=""><p>R</p></div>
									<div class="bottom" status="off" onclick="X2_BorderSelect(this, 'footer_borders');" style="">B</div>
								</div>
								<script type="text/javascript">
								   x2_ParseBrdrValue(document.getElementById("footer_borders"));
								</script>
							</div>
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'footer_border_color' ); ?>
							<p>Footer Border Color:&nbsp;</p><input type="text" class="colorPicker" name="theme_options[footer_border_color]" value="<?php echo $value; ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'footer_border_thick' ); ?>
							<p>Border Thickness:&nbsp;</p><input type="text" name="theme_options[footer_border_thick]" value="<?php echo esc_attr( $value ); ?>">
						</div>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'footer_border_style' ); ?>
							<p>Border Style:&nbsp;</p>
							<select name="theme_options[footer_border_style]">
							<?php
							$options = array(
								'none' => esc_html__( 'none', 'text-domain' ),
								'hidden' => esc_html__( 'hidden', 'text-domain' ),
								'dotted' => esc_html__( 'dotted', 'text-domain' ),
								'dashed' => esc_html__( 'dashed', 'text-domain' ),
								'solid' => esc_html__( 'solid', 'text-domain' ),
								'double' => esc_html__( 'double', 'text-domain' ),
								'groove' => esc_html__( 'groove', 'text-domain' ),
								'ridge' => esc_html__( 'ridge', 'text-domain' ),
								'inset' => esc_html__( 'inset', 'text-domain' ),
								'outset' => esc_html__( 'outset', 'text-domain' ),
								'initial' => esc_html__( 'initial', 'text-domain' ),
								'inherit' => esc_html__( 'inherit', 'text-domain' ),
							);
							foreach ( $options as $id => $label ) { ?>
								<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
									<?php echo strip_tags( $label ); ?>
								</option>
							<?php } ?>
							</select>
						</div>
						<div class="X2AdminSectionPart FooterText">
							<?php $value = self::get_theme_option( 'footer_text' ); ?>
							<p>Footer Text:&nbsp;</p>
							<textarea name="theme_options[footer_text]"><?php echo $value; ?></textarea>
						</div>
					</div>
					
					
					<div class="X2AdminSection">
						<h2>Custom CSS</h2>
						<?php $value = self::get_theme_option( 'custom_css' ); ?>
						<textarea name="theme_options[custom_css]"><?php echo $value; ?></textarea>
					</div>
						
					
					
					<div class="X2AdminSection">
						<h2>Design Credits</h2>
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'show_design_credits' ); ?>
							<p>Show Design Credits:&nbsp;</p><input type="checkbox" name="theme_options[show_design_credits]" <?php checked( $value, 'on' ); ?>>
						</div>
						<br />
						<div class="X2AdminSectionPart">
							<?php $value = self::get_theme_option( 'design_credits' ); ?>
							<p>Design Credits Text:&nbsp;</p>
							<textarea class="smalltextarea" name="theme_options[design_credits]"><?php echo $value; ?></textarea>
						</div>
					</div>

						

						

					

					<?php submit_button(); ?>

				</form>
				<br />
				<br />
				Developed by <a href="http://www.x2labs.com/">Britton Scritchfield at X2 Labs</a><br />
				In collaboration with <a href="http://reinholdtechs.com/">Tab Reinhold at Reinhold Technology Solutions</a><br />
				Child theme of <a href="https://wordpress.org/themes/twentyseventeen/">Twenty Seventeen</a><br />
				Color Picker by <a href="https://github.com/bgrins/spectrum">Brian Grinstead</a>
			</div><!-- .wrap -->
			
		<?php 
		}
		
	}
}

new X2_Theme_Options();

// Helper function to use in your theme to return a theme option value
function X2_get_theme_option( $id = '' ) 
{
	return X2_Theme_Options::get_theme_option( $id );
}

//$value = X2_get_theme_option( 'select_example' );

function X2_get_theme_options() 
{
	return X2_Theme_Options::get_theme_options();
}
//$value = X2_get_theme_options()
//echo print_r(X2_get_theme_options());
//$lst = X2_get_theme_options();

//Export and Import settings
//array_walk_recursive($lst, function ($item, $key) 
//{
    //echo "$key holds $item\n";
//});



?>