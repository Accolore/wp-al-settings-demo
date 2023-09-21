<?php 
// Configuration array
$accolore_config['wp-al-settings-demo'] = array(
	'title'             => 'WP Accolore Settings Demo',
	'version'           => '2.0',
	'text_domain'       => 'wp-al-settings-demo',
	'prefix'            => 'wpals',
	'documentation_tab' => array(
		'title' => esc_html__( 'Documentation external link', 'wp-al-settings-demo' ),
		'url'   => esc_html__('http://www.google.com'),
	),
	'demo_page' => array(
		'title'   => 'WP Accolore Settings Demo Page',
		'name'    => 'wpals-demo-page',
		'content' => '<p>This content will be added to the page. You can use placeholders to insert images or other files.</p><img src="{{1}}" title="Image 1" /> <img src="{{2}}" title="Image 2" />',
		'media'   => array(
			1 => 'https://placehold.co/600x400',
			2 => 'https://placehold.co/200x200',
		),
	),
	'menu' => array(
		'page_title' => 'WP Accolore Settings Demo',
		'menu_title' => 'AL Settings Demo',
		'capability' => 'manage_options',
		'icon'       => 'dashicons-buddicons-replies',
		'position'   => 100,
	),
	'sections' => array(
		array(
			'id'      => 'basic',
			'title'   => esc_html__( 'Basic fields', 'wp-al-settings-demo' ),
			'default' => true,
			'fields'  => array(
				array(
					'id'       => 'raw_field',
					'type'     => 'raw',
					'title'    => esc_html__( 'Raw field', 'wp-al-settings-demo' ),
					'content'  => '<img src="https://placehold.co/400x300" />',
				),
				array(
					'id'       => 'separator_field1',
					'type'     => 'separator',
					'title'    => esc_html__( 'Separator field', 'wp-al-settings-demo' ), // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'switch_field1',
					'type'     => 'switch',
					'title'    => esc_html__( 'Switch field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Field subtitle.', 'wp-al-settings-demo' ),
					'desc'     => '<img src="https://placehold.co/48x48" />',
					'default'  => 0,
					'on'       => esc_html__( 'Yes', 'wp-al-settings-demo' ),
					'off'      => esc_html__( 'No', 'wp-al-settings-demo' ),
				),
				array(
					'id'       => 'switch_field2',
					'type'     => 'switch',
					'title'    => esc_html__( 'Switch field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Field subtitle.', 'wp-al-settings-demo' ),
					'desc'     => esc_html__( 'Field description.', 'wp-al-settings-demo' ),
					'default'  => 1,
					'on'       => esc_html__( 'Selected', 'wp-al-settings-demo' ),
					'off'      => esc_html__( 'Unselected', 'wp-al-settings-demo' ),
				),
				array(
					'id'       => 'separator_field2',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'select_field',
					'type'     => 'select',
					'subtype'  => 'select', 
					'title'    => esc_html__( 'Select field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => 'value1',
					'options'  => array(
						'value1' => esc_html__( 'Value 1', 'wp-al-settings-demo' ),
						'value2' => esc_html__( 'Value 2', 'wp-al-settings-demo' ),
						'value3' => esc_html__( 'Value 3', 'wp-al-settings-demo' ),
					),
				),
				array(
					'id'       => 'select_field_images',
					'type'     => 'select',
					'subtype'  => 'icons',
					'title'    => esc_html__( 'Select field (with images)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Display a select field with images instead of texts.', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => 'value1',
					'options'  => array(
						'value1' => plugin_dir_url( __FILE__ ) . 'admin/images/align_left.png',
						'value2' => plugin_dir_url( __FILE__ ) . 'admin/images/align_center.png',
						'value3' => plugin_dir_url( __FILE__ ) . 'admin/images/align_right.png',
						'value4' => plugin_dir_url( __FILE__ ) . 'admin/images/align_justify.png',
					),
				),
				array(
					'id'       => 'separator_field3',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'text_field1',
					'type'     => 'text',
					'subtype'  => 'text',
					'title'    => esc_html__( 'Text field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Field subtitle.', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => 'Default value',
				),
				array(
					'id'       => 'text_field2',
					'type'     => 'text',
					'subtype'  => 'text',
					'title'    => esc_html__( 'Text field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'date_field',
					'type'     => 'text',
					'subtype'  => 'date',
					'title'    => esc_html__( 'Text field (date)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'This field display an input with type date.', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => date('Y-m-d'),
					'min'      => '2023-01-01', // always in yyyy-mm-dd format
					'max'      => '2023-12-31', // always in yyyy-mm-dd format
				),
				array(
					'id'       => 'number_field',
					'type'     => 'text',
					'subtype'  => 'number',
					'title'    => esc_html__( 'Text field (number)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'This field display an input with type number.', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => 10,
					'min'      => 2,
					'max'      => 20,
				),
				array(
					'id'       => 'separator_field4',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'textarea_field',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Textarea field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => 'default value',
				),
				array(
					'id'       => 'separator_field5',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'editor_field',
					'type'     => 'editor',
					'title'    => esc_html__( 'Editor field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'An advanced editor instead of a simple textarea.', 'wp-al-settings-demo' ),
					'desc'     => '',
					'options'  => array( //see https://developer.wordpress.org/reference/classes/_wp_editors/parse_settings/
						'wpautop'          => true,  // Whether to use wpautop().
						'media_buttons'    => true,  //	Whether to show the Add Media/other media buttons. Default true
						'default_editor'   => '',    // When both TinyMCE and Quicktags are used, set which editor is shown on page load. Default empty
						'drag_drop_upload' => false, //	Whether to enable drag & drop on the editor uploading. Default false.
						'textarea_rows'    => 10,    // Number rows in the editor textarea. Default 20.					
						'teeny'            => false,  // Whether to output the minimal editor config. Examples include Press This and the Comment editor. Default false.
						'tinymce'          => true,  // Whether to load TinyMCE. Can be used to pass settings directly to TinyMCE using an array. Default true.
						'quicktags'        => true,  // Whether to load Quicktags. Can be used to pass settings directly to Quicktags using an array. Default true.
					),
					'default'  => 'This is a text',
				),
				array(
					'id'       => 'separator_field6',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'slider_field1',
					'type'     => 'slider',
					'subtype'  => 'single', // can be 'single', 'double'
					'title'    => esc_html__( 'Slider field (single)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'A numeric value managed by a linear slider: (min value 5, max value 100, step 1, default value 10)', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => 10,
					'min'      => 5,   // minimum value allowed
					'step'     => 1,   // step increment of the slider
					'max'      => 100, //  maximum value allowed
				),
				array(
					'id'       => 'slider_field2',
					'type'     => 'slider',
					'subtype'  => 'double', // can be 'single', 'double'
					'title'    => esc_html__( 'Slider field (double)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Two numberi values managed by a linear slider with two handles: (min value 5, max value 100, step 1, default value 10 an 90)', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => array(
						'left_handler'  => 10,
						'right_handler' => 90,
					),
					'min'      => 5,   // minimum value allowed
					'step'     => 1,   // step increment of the slider
					'max'      => 100, //  maximum value allowed
				),
				array(
					'id'       => 'separator_field7',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'               => 'password_field',
					'type'             => 'password',
					'title'            => esc_html__( 'Password field', 'wp-al-settings-demo' ),
					'subtitle'         => esc_html__( 'Display fields for credentials management, username and password', 'wp-al-settings-demo' ),
					'desc'             => '',
					'password_encrypt' => true, // the password will be saved on the database with MD5 encryption
					'default'          => array(
						'username' => '',
						'password' => '',
					),
					'placeholders'     => array(
						'username' => esc_html__( 'Username', 'wp-al-settings-demo' ),
						'password' => esc_html__( 'Password', 'wp-al-settings-demo' ),
					),
				),
				array(
					'id'       => 'separator_field8',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'           => 'media_image_field1',
					'type'         => 'media_image',
					'title'        => esc_html__( 'Media image field', 'wp-al-settings-demo' ),
					'subtitle'     => esc_html__( 'Contain an image selected from media library or uploaded.', 'wp-al-settings-demo' ),
					'desc'         => '',
					'default'      => plugin_dir_url( __FILE__ ) . 'admin/images/placeholder.png',
					'multiple'     => false, // true = allow to select multiple images (gallery), false = allow only single image to be selected
				),
				array(
					'id'           => 'media_image_field2',
					'type'         => 'media_image',
					'title'        => esc_html__( 'Media image field (gallery)', 'wp-al-settings-demo' ),
					'subtitle'     => esc_html__( 'Contain an image selected from media library or uploaded.', 'wp-al-settings-demo' ),
					'desc'         => '',
					'default'      => plugin_dir_url( __FILE__ ) . 'admin/images/placeholder.png',
					'multiple'     => true, // true = allow to select multiple images (gallery), false = allow only single image to be selected
				),
				array(
					'id'           => 'media_other_field',
					'type'         => 'media_other',
					'title'        => esc_html__( 'Media other field', 'wp-al-settings-demo' ),
					'subtitle'     => esc_html__( 'Contain a media (not an image) selected from media library or uploaded. When selected the media name will be displayed.', 'wp-al-settings-demo' ),
					'desc'         => '',
					'default'      => '',
					'mime_type'    => false, // "'audio','video'", set to false if all mime types are allowed
				),
				array(
					'id'       => 'separator_field9',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'reset_field',
					'type'     => 'reset',
					'title'    => '',
					'default'  => '',
				),
			),
		),
		array(
			'id'     => 'styling',
			'title'  => esc_html__( 'Styling fields', 'wp-al-settings-demo' ),
			'default' => false,
			'fields'  => array(
				array(
					'id'       => 'link_color_field',
					'type'     => 'link_color',
					'title'    => esc_html__( 'Link color field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'selector' => array(
						'regular' => true,
						'hover'   => true,
						'active'  => true,
						'visited' => true,
					),
					'default' => array(
						'regular' => '#eeeeee',
						'hover'   => '#ffffff',
						'active'  => '#ff0000',
						'visited' => '#00ffff',
					),
					'output'   => array(
						'a',
					),
				),
				array(
					'id'       => 'separator_field1',
					'type'     => 'separator',
					'title'    => esc_html__( 'Separator field', 'wp-al-settings-demo' ), // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'background_color_field',
					'type'     => 'background_color',
					'title'    => esc_html__( 'Background color field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => '#333333',
					'output'   => array(
						'a',
						'a:selected',
						'a:hover',
						'a:active',
						'a:focus',
					),
				),
				array(
					'id'       => 'separator_field2',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'             => 'typography_field1',
					'type'           => 'typography',
					'title'          => esc_html__('Typography field', 'wp-al-settings-demo'),
					'subtitle'       => '',
					'desc'           => '',
					'google_api_key' => 'AIzaSyC3nCnaCoEz6-iaMd2OQmYxw4dOCKaIlUI',
					'default'        => array(
						'family' => 'Courier New',
						'color'  => '#00f0f0',
						'size'   => '12px',
						'weight' => '400',
					),
					'output' => array(
						'p',
					),
				),
				array(
					'id'             => 'typography_field2',
					'type'           => 'typography',
					'title'          => esc_html__('Typography field', 'wp-al-settings-demo'),
					'subtitle'       => '',
					'desc'           => '',
					'google_api_key' => 'AIzaSyC3nCnaCoEz6-iaMd2OQmYxw4dOCKaIlUI',
					'default'        => array(
						'family' => 'Arial',
						'color'  => '#f0f0ff',
						'size'   => '20px',
						'weight' => '600',
					),
					'output'   => array(
						'h1',
						'h2',
						'h3',
						'h4',
						'h5',
						'h6',
					),
				),
				array(
					'id'       => 'separator_field3',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'color_field1',
					'type'     => 'color',
					'title'    => esc_html__( 'Color field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => '#2776c8',
					'output'   => array(
						'background-color' => 'p'
					),
					'alpha'    => true, // true = the color picker manage the alpha channel, false = only solid color can be selected
				),
				array(
					'id'       => 'color_field2',
					'type'     => 'color',
					'title'    => esc_html__( 'Color field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'output'   => array(
						'background-color' => 'h1'
					),
					'default'  => 'rgba(0,0,0,0.7)',
					'alpha'    => true, // true = the color picker manage the alpha channel, false = only solid color can be selected
				),
				array(
					'id'       => 'separator_field4',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'color_palette_field1',
					'type'     => 'color_palette',
					'title'    => esc_html__( 'Color Palette field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Choose a color from a preset color palette.', 'wp-al-settings-demo' ),
					'default'  => '#888888',
					'options'  => array(
						'type'   => 'hex', //can be 'hex', 'material'
						'colors' => array( // is type is 'hex' must be an array of string representing the hex values of the colors
							'#000000',
							'#222222',
							'#444444',
							'#666666',
							'#888888',
							'#aaaaaa',
							'#cccccc',
							'#eeeeee',
							'#ffffff',
						),
					),
					'output'   => array(
						'color'     => '.widget-title',
					),
				),
				array(
					'id'       => 'color_palette_field2',
					'type'     => 'color_palette',
					'title'    => esc_html__( 'Color Palette field (Material Design)', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'Choose a color from a preset color palette.', 'wp-al-settings-demo' ),
					'default'  => '',
					'options'  => array(
						'type'   => 'material', //can be 'hex', 'material'
						'colors' => 'all', // if type is 'material' must be one of the following values: 'primary','all','black','white','red','pink','purple','deep_purple','indigo','blue','light_blue','cyan' (see file /includes/wp-accolore-material.php)
					),
					'output'   => array(
						'color'     => '.widget-title',
					),
				),
				array(
					'id'       => 'separator_field5',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'spacing_field1',
					'type'     => 'spacing',
					'title'    => esc_html__( 'Spacing field (padding)', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'subtype'  => 'padding',
					'default'  => array(
						'top'    => 10,
						'right'  => 10,
						'bottom' => 10,
						'left'   => 10,
						'unit'   => '%', // can be 'px', 'em', '%', 'rem'
					),
					'output'   => array(
						'div'
					),
				),
				array(
					'id'       => 'spacing_field2',
					'type'     => 'spacing',
					'title'    => esc_html__( 'Spacing field (margin)', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'subtype'  => 'margin',
					'default'  => array(
						'top'    => 10,
						'right'  => 10,
						'bottom' => 10,
						'left'   => 10,
						'unit'   => 'px', // can be 'px', 'em', '%', 'rem'
					),
					'output'   => array(
						'div'
					),
				),
				array(
					'id'       => 'separator_field6',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'               => 'size_field',
					'type'             => 'size',
					'title'            => esc_html__( 'Size field', 'wp-al-settings-demo' ),
					'subtitle'         => '',
					'desc'             => '',
					'default'          => array(
						'width'  => 10,
						'height' => 10,
						'unit'   => 'px', // can be 'px', 'em', '%', 'rem'
					),
					'output' => array(
						'div'
					),
				),
				array(
					'id'       => 'separator_field7',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'border_field',
					'type'     => 'border',
					'title'    => esc_html__( 'Border field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => array(
						'top'    => 2, // the width is always expressend in px
						'right'  => 2,
						'bottom' => 2,
						'left'   => 2,
						'style'  => 'solid', // can be 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'outset', 'none', 'hidden'
						'color'  => '#ff0000',
					),
					'alpha'    => true, // true = the color picker manage the alpha channel, false = only solid color can be selected
					'output'   => array(
						'h1'
					),
				),
				array(
					'id'       => 'separator_field8',
					'type'     => 'separator',
					'title'    => '', // this field is mandatory. You can set to '' if not needed.
				),
				array(
					'id'       => 'reset_field',
					'type'     => 'reset',
					'title'    => '',
					'default'  => '',
				),
			),
		),
		array(
			'id'     => 'visibility',
			'title'  => esc_html__( 'Field visibility', 'wp-al-settings-demo' ),
			'default' => false,
			'fields'  => array(
				array(
					'id'       => 'switch_field_master',
					'type'     => 'switch',
					'title'    => esc_html__( 'Switch field', 'wp-al-settings-demo' ),
					'subtitle' => esc_html__( 'If this field is set to Selected, other fields will be displayed', 'wp-al-settings-demo' ),
					'desc'     => '',
					'default'  => 0,
					'on'       => esc_html__( 'Selected', 'wp-al-settings-demo' ),
					'off'      => esc_html__( 'Unselected', 'wp-al-settings-demo' ),
				),
				array(
					'id'       => 'text_field_slave',
					'type'     => 'text',
					'subtype'  => 'text',
					'title'    => esc_html__( 'Text field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => 'Default value',
					'required' => array(
						'target'   => 'switch_field_master',
						'operator' => '=', // =, <, >, !=
						'value'    => '1',
					),
				),				
				array(
					'id'       => 'slider_field_slave',
					'type'     => 'slider',
					'subtype'  => 'single', // can be 'single', 'double'
					'title'    => esc_html__( 'Slider field', 'wp-al-settings-demo' ),
					'subtitle' => '',
					'desc'     => '',
					'default'  => 10,
					'min'      => 5,   // minimum value allowed
					'step'     => 1,   // step increment of the slider
					'max'      => 100, //  maximum value allowed
					'required' => array(
						'target'   => 'switch_field_master',
						'operator' => '=', // =, <, >, !=
						'value'    => '1',
					),

				),
				array(
					'id'       => 'reset_field',
					'type'     => 'reset',
					'title'    => '',
					'default'  => '',
				),
			),
		),
		array(
			'id'     => 'dev',
			'title'  => esc_html__( 'Dev fields', 'wp-al-settings-demo' ),
			'default' => false,
			'fields'  => array(
				array(
					'id'       => 'reset_field',
					'type'     => 'reset',
					'title'    => '',
					'default'  => '',
				),
			),
		),		
	),
);