<?php 
// Configuration array
$accolore_config['wp-al-settings-demo'] = array(
	'title'          => 'WP Accolore Settings Demo',
	'version'        => '1.0',
	'text_domain'    => 'wp-al-settings-demo',
	'prefix'         => 'wpals',
	'tgmpa_plugins'  => false,

	'demo_page' => array(
		'title'   => 'WP Accolore Settings Demo Page',
		'name'    => 'wpals-demo-page',
		'content' => '<p>This content will be added to the page. You can use placeholders to insert images or other files.</p><img src="{{1}}" title="Image 1" /> <img src="{{2}}" title="Image 2" />',
		'media'   => array(
			1 => 'https://placehold.co/600x400',
			2 => 'https://placehold.co/200x200',
		),
	),
	'settings_config' => array(
		'menu' => array(
			'page_title' => 'WP Accolore Settings Demo',
			'menu_title' => 'WP Settings Demo',
			'capability' => 'manage_options',
			'icon'       => 'dashicons-buddicons-replies',
			'position'   => 100,
		),
		'sections' => array(
			array(
				'id'      => 'control_buttons',
				'title'   => esc_html__( 'Control Buttons', 'wp-3d-thingviewer' ),
				'default' => true,
				'fields'  => array(
					array(
						'id'       => 'control_buttons_image',
						'type'     => 'raw',
						'title'    => esc_html__( 'Plugin screenshot', 'wp-3d-thingviewer' ),
						'content'  => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-canvas-screenshot.jpg" />',
					),
					array(
						'id'       => 'help_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display help window button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The help window show the keyboard keys and mouse controls to use the viewer.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-help-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'fullscreen_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display fullscreen button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The full screen switch button let the user to switch the views into full width mode.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-fullscreen-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),          
					),
					array(
						'id'       => 'info_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display info window button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The info window contain various informations about the loaded model, like volume, surface area, sizes.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-info-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'bounding_box_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display bounding box button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The bounding box is a box that highlight the boundary of the loaded model.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-bounding-box-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'model_download_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display model download button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display a button to let the user to download the 3D model.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-download-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'camera_rotation_button_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display camera auto-rotation button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The button start the camera auto-rotation around the Y axis.', 'wp-3d-thingviewer' ),
						'desc'     => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-camera-autorotation-button.jpg" />',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
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
				'id'     => 'info_window',
				'title'  => esc_html__( 'Info Window', 'wp-3d-thingviewer' ),
				'default' => false,
				'fields'  => array(
					array(
						'id'       => 'info_window_image',
						'type'     => 'raw',
						'title'    => esc_html__( 'Info window screenshot', 'wp-3d-thingviewer' ),
						'content'  => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-info-window-detail.jpg" />',
					),
					array(
						'id'       => 'file_name_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display model filename', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the filename of the loaded model into the info window.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'file_size_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display model file size', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the file size of the loaded model into the info window.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'triangles_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display triangles number', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the number of the triangles of the loaded model info the info window.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'surface_area_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display surface area', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the surface area of the loaded model into the infor window.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'volume_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display volume', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the volume of the loaded model into the info window.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'bounding_box_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display bounding box size', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the bounding box sizes of the loaded model.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
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
				'title'  => esc_html__( 'Styling', 'wp-3d-thingviewer' ),
				'default' => false,
				'fields'  => array(
					array(
						'id'       => 'buttons_color',
						'type'     => 'link_color',
						'title'    => esc_html__( 'Buttons icons color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the thingviewer buttons icons (info button, help button, fullscreen button,...).', 'wp-3d-thingviewer' ),
						'selector' => array(
							'regular' => true,
							'hover'   => true,
							'active'  => false,
							'visited' => false,
						),
						'default' => array(
							'regular' => '#ffffff',
							'hover'   => '#ffffff',
							'active'  => '',
							'visited' => '',
						),
						'output'   => array(
							'.wp3dtv-buttons li a',
						),
					),
					array(
						'id'       => 'buttons_background',
						'type'     => 'background_color',
						'title'    => esc_html__( 'Button background color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the thingviewer buttons icons background', 'wp-3d-thingviewer' ),
						'default'  => '#333333',
						'output'   => array(
							'.wp3dtv-buttons li a:link',
							'.wp3dtv-buttons li a:visited',
						),
					),
					array(
						'id'       => 'button_hover_background',
						'type'     => 'background_color',
						'title'    => esc_html__( 'Button hover background color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the thingviewer buttons background on mouse hover.', 'wp-3d-thingviewer' ),
						'default'  => '#d52f13',
						'output'   => array(
							'.wp3dtv-buttons li a.selected',
							'.wp3dtv-buttons li a:hover',
							'.wp3dtv-buttons li a:active',
							/*'.wp3dtv-buttons li a:focus',*/
						),
					),
					array(
						'id'       => 'info_help_typography',
						'type'     => 'typography',
						'title'    => esc_html__('Typography', 'wp-3d-thingviewer'),
						'subtitle' => esc_html__('Typography for info window and help window.', 'wp-3d-thingviewer'),
						'default'  => array(
							'family' => 'Courier New',
							'color'  => false,
							'size'   => '12px',
							'weight' => '400',
						),
						'output'   => array(
							'.wp3dtv-info-window',
							'.wp3dtv-help-window',
						),
					),
					array(
						'id'       => 'model_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Model color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the loaded 3d model.', 'wp-3d-thingviewer' ),
						'default'  => '#2776c8',
						'alpha'    => false,
					),
					array(
						'id'       => 'fog_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Fog color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the fog into the thingviewer.', 'wp-3d-thingviewer' ),
						'default'  => '#cccccc',
						'validate' => 'color',
						'alpha'    => false,
					),
					array(
						'id'       => 'plane_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Plane color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the base plane of the thingviewer.', 'wp-3d-thingviewer' ),
						'default'  => '#cccccc',
						'validate' => 'color',
						'alpha'    => false,
					),
					array(
						'id'       => 'wire_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Grid color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the plane grid of the thingviewer.', 'wp-3d-thingviewer' ),
						'default'  => '#ffffff',
						'validate' => 'color',
						'alpha'    => false,
					),
					array(
						'id'       => 'light_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Light color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the illuminating light of the thingviewer.', 'wp-3d-thingviewer' ),
						'default'  => '#ffffff',
						'validate' => 'color',
						'alpha'    => false,
					),
					array(
						'id'       => 'bounding_box_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Bounding box color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the model bounding box. The bounding box can be displayed with the correspondent button.', 'wp-3d-thingviewer' ),
						'default'  => '#ff0000',
						'validate' => 'color',
						'alpha'    => false,
					),
					array(
						'id'       => 'loading_background',
						'type'     => 'color',
						'title'    => esc_html__( 'Loading layer background color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the background layer displayed when the 3d model loading is in progress.', 'wp-3d-thingviewer' ),
						'output'   => array(
							'background-color' => '.wp3dtv-progress'
						),
						'default'  => 'rgba(0,0,0,0.7)',
						'alpha'    => true,
					),
					array(
						'id'       => 'loading_icon_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Loading spinner color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the spinner displayed when 3d model loading is in progress.', 'wp-3d-thingviewer' ),
						'default'  => '#ffffff',
						'output'   => array(
							'border-top-color'    => '.wp3dtv-progress .wp3dtv-spinner',
							'border-right-color'  => '.wp3dtv-progress .wp3dtv-spinner',
							'border-bottom-color' => '.wp3dtv-progress .wp3dtv-spinner',
						),
						'alpha'    => false,
					),
					array(
						'id'       => 'loading_text_typography',
						'type'     => 'typography',
						'title'    => esc_html__('Loading text typography', 'wp-3d-thingviewer'),
						'subtitle' => esc_html__('Typography for loading text (with the model loaded size).', 'wp-3d-thingviewer'),
						'default'  => array(
							'family' => 'Courier New',
							'color'  => '#ffffff',
							'size'   => '14px',
							'weight' => '400',
						),
						'output'   => array(
							'.wp3dtv-progress > span',
						),
					),
					array(
						'id'       => 'reset_field',
						'type'     => 'reset',
						'title'    => '',
						'default'  => '',
					),
					/*
					array(
						'id'       => 'loading_text_color',
						'type'     => 'color',
						'title'    => esc_html__( 'Loading text color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color of the model file size text displayed whe the 3d model loading is in progress.', 'wp-3d-thingviewer' ),
						'default'  => '#ffffff',
						'output'   => array(
							'color' => '.wp3dtv-progress > span'
						),
						'validate' => 'color',
						'alpha'    => false,
					),
					*/
				),
			),
			array(
				'id'     => 'woocommerce',
				'title'  => esc_html__( 'Woocommerce', 'wp-3d-thingviewer' ),
				'default' => false,
				'fields'  => array(
					array(
						'id'       => 'woocommerce_enabled',
						'type'     => 'switch',
						'title'    => esc_html__( 'Enable Woocommerce button', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Enable or disable the Woocommerce product page default button. You can disable if you are using the plugin shortcode to display the thingviewer into the product pages.', 'wp-3d-thingviewer' ),
						'desc'     => '',
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'woocommerce_button_position',
						'type'     => 'select',
						'title'    => esc_html__( 'Thingviewer button position', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The position in the product page where the button to display the thingviewer will be positioned.', 'wp-3d-thingviewer' ),
						'default'  => 'woocommerce_product_meta_end',
						'options'  => array(
							'woocommerce_product_meta_start'           => esc_html__( 'Before product meta', 'wp-3d-thingviewer' ),
							'woocommerce_product_meta_end'             => esc_html__( 'After product meta', 'wp-3d-thingviewer' ),
							'woocommerce_before_add_to_cart_form'      => esc_html__( 'Before add to cart form', 'wp-3d-thingviewer' ),
							'woocommerce_after_add_to_cart_form'       => esc_html__( 'After add to cart form', 'wp-3d-thingviewer' ),
							'woocommerce_after_add_to_cart_button'     => esc_html__( 'After add to cart button', 'wp-3d-thingviewer' ),
							'woocommerce_before_add_to_cart_quantity'  => esc_html__( 'Before add to cart quantity', 'wp-3d-thingviewer' ),
							'woocommerce_after_add_to_cart_quantity'   => esc_html__( 'After add to cart quantity', 'wp-3d-thingviewer' ),
							'woocommerce_before_variations_form'       => esc_html__( 'Before variations', 'wp-3d-thingviewer' ),
							'woocommerce_after_variations_form'        => esc_html__( 'After variations', 'wp-3d-thingviewer' ),
							'woocommerce_before_single_variation'      => esc_html__( 'Before single variation', 'wp-3d-thingviewer' ),
							'woocommerce_after_single_variation'       => esc_html__( 'After single variation', 'wp-3d-thingviewer' ),
							'woocommerce_after_single_product_summary' => esc_html__( 'After single product summary', 'wp-3d-thingviewer' ),
							'woocommerce_after_single_product'         => esc_html__( 'After single product', 'wp-3d-thingviewer' ),
						),
					),
					array(
						'id'       => 'woocommerce_button_position_custom',
						'type'     => 'text',
						'title'    => esc_html__( 'Custom position', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Here you can specify the hook where you want to display the Thingviewer button.', 'wp-3d-thingviewer' ),
						'default' => '',
					),
					array(
						'id'       => 'woocommerce_button_label',
						'type'     => 'text',
						'title'    => esc_html__( 'Button label', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The label for the product page button.', 'wp-3d-thingviewer' ),
						'default' => 'View 3D Model',
					),
					array(
						'id'       => 'woocommerce_button_label_color',
						'type'     => 'link_color',
						'title'    => esc_html__( 'Button text color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the product page Thingviewer button text.', 'wp-3d-thingviewer' ),
						'selector' => array(
							'regular' => true,
							'hover'   => true,
							'active'  => false,
							'visited' => false,
						),
						'default' => array(
							'regular' => '#ffffff',
							'hover'   => '#ffffff',
							'active'  => '',
							'visited' => '',
						),
						'output'   => array(
							'#wp3dtv-wc-trigger',
						),
					),
					array(
						'id'       => 'woocommerce_button_background',
						'type'     => 'background_color',
						'title'    => esc_html__( 'Button color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the product page Thingviewer button.', 'wp-3d-thingviewer' ),
						'default'  => '#333333',
						'output'   => array(
							'#wp3dtv-wc-trigger',
						),
					),
					array(
						'id'       => 'woocommerce_button_hover_background',
						'type'     => 'background_color',
						'title'    => esc_html__( 'Button hover color', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The color for the product page Thingviewer button on mouse hover.', 'wp-3d-thingviewer' ),
						'default'  => '#d52f13',
						'output'   => array(
							'#wp3dtv-wc-trigger.selected',
							'#wp3dtv-wc-trigger:hover',
							'#wp3dtv-wc-trigger:visited',
							'#wp3dtv-wc-trigger:active',
							/*'.#wp3dtv-wc-trigger:focus',*/
						),
					),
					array(
						'id'       => 'woocommerce_button_padding',
						'type'     => 'spacing',
						'title'    => esc_html__( 'Button padding', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The internal padding in pixels for the product page Thingviewer button.', 'wp-3d-thingviewer' ),
						'desc'     => '',
						'subtype'  => 'padding', // margin
						'default'  => array(
							'top'    => 10,
							'right'  => 10,
							'bottom' => 10,
							'left'   => 10,
						),
						'output'   => array(
							'#wp3dtv-wc-trigger'
						),
						//'required'      => array('camera-rotation-button-display', '=', '1'),
						//'display_value' => 'text',
					),
					/*
					array(
						'id'       => '_t_textarea',
						'type'     => 'textarea',
						'title'    => esc_html__( 'area', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The', 'wp-3d-thingviewer' ),
						'default' => 'ccc',
					),
					*/
					array(
						'id'       => 'reset_field',
						'type'     => 'reset',
						'title'    => '',
						'default'  => '',
					),
				),
			),
			array(
				'id'      => '3d_settings',
				'title'   => esc_html__( '3D Settings', 'wp-3d-thingviewer' ),
				'default' => false,
				'fields'  => array(
					array(
						'id'       => 'axis_up',
						'type'     => 'select',
						'title'    => esc_html__( 'Upward axis', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Define what of the three axis will be configured as up. Note that this configuration will affect the scene image background. If you configured a background image we suggest to put this option as Y-axis Up.', 'wp-3d-thingviewer' ),
						'desc'  => '<img src="' . plugin_dir_url( __FILE__ ) . 'admin/images/wp3dtv-axis.jpg" />',
						'default'  => 'z_up',
						'options'  => array(
							'z_up'       => esc_html__( 'Z-axis Up (like 3D Printers)', 'wp-3d-thingviewer' ),
							'y_up'       => esc_html__( 'Y-axis Up', 'wp-3d-thingviewer' ),
							'x_up'       => esc_html__( 'X-axis Up', 'wp-3d-thingviewer' ),
						),
					),
					array(
						'id'       => 'fog_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display fog', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display fog into the thingviewer (the model will not be affected by the fog, only the background', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'plane_wire_display',
						'type'     => 'switch',
						'title'    => esc_html__( 'Display plane and grid', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Display the plane and grid into the thingviewer.', 'wp-3d-thingviewer' ),
						'default'  => 1,
						'on'       => esc_html__( 'Yes', 'wp-3d-thingviewer' ),
						'off'      => esc_html__( 'No', 'wp-3d-thingviewer' ),
					),
					array(
						'id'       => 'camera_rotation_value',
						'type'     => 'slider',
						'title'    => esc_html__( 'Camera auto-rotation value', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Determine the rotation value for the camera auto-rotation.', 'wp-3d-thingviewer' ),
						'desc'     => '',
						'default'  => 10,
						'min'      => 1,
						'step'     => 1,
						'max'      => 100,
						//'required'      => array('camera-rotation-button-display', '=', '1'),
						//'display_value' => 'text',
					),
					array(
						'id'       => 'zoom_factor',
						'type'     => 'slider',
						'title'    => esc_html__( 'Zoom factor', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The multiplying factor for the camera zoom. It allows to control the camera position after the model loading.', 'wp-3d-thingviewer' ),
						'desc'     => '',
						'default'  => 1,
						'min'      => 0.1,
						'step'     => 0.1,
						'max'      => 5,
					),
					array(
						'id'       => 'ambient_light_intensity',
						'type'     => 'slider',
						'title'    => esc_html__( 'Ambient light intensity', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'The intensity for the ambient light. It allows to control the model illumination.', 'wp-3d-thingviewer' ),
						'desc'     => '',
						'default'  => 0,
						'min'      => 0,
						'step'     => 0.1,
						'max'      => 2,
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
				'id'      => 'licensing',
				'title'   => esc_html__( 'License', 'wp-3d-thingviewer' ),
				'default' => false,
				'fields'  => array(
					array(
						'id'       => 'license_instruction',
						'type'     => 'raw',
						'title'    => esc_html__( 'Instructions', 'wp-3d-thingviewer' ),
						'content' => __( '<ol><li>Insert your <strong>Envato Purchase Code</strong> in the textbox below.</li><li>Click on the <strong>Save Settings</strong> button</li><li>Wait for the validation message</li></ul>', 'wp-3d-thingviewer' ),
					),	
					array(
						'id'       => 'validation_code',
						'type'     => 'license',
						'title'    => esc_html__( 'License Validation Code', 'wp-3d-thingviewer' ),
						'subtitle' => esc_html__( 'Insert here your license validation code. Follow th instruction above to get a validation code from the licensing portal.', 'wp-3d-thingviewer' ),
						'default'  => '',
					),
					array(
						'id'       => 'reset_field',
						'type'     => 'reset',
						'title'    => '',
						'default'  => '',
					),
				),
			),
		),
	),
);