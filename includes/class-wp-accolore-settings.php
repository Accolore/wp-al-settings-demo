<?php
/**
 * Manage the settings page for the plugin
 *
 * This class defines all code necessary to display the settings page and initialise settings fieldsactivation.
 *
 * @since      1.0.0
 * @package    WP_Accolore
 * @subpackage WP_Accolore/includes
 * @author     Accolore <support@accolore.com>
 */

use function PHPSTORM_META\argumentsSet;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (! class_exists('WP_Accolore_Settings')) { 
	class WP_Accolore_Settings {

        /**
		 * The text domain of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @param    string    $plugin_name    The text domain of the plugin (used as unique ID)
		 */
        private $plugin_name;

        /**
		 * Initialize the collections used to maintain the actions and filters.
		 *
		 * @since    1.0.0
         * @param    string    $plugin_name     The name of this plugin.
		 */
		public function __construct( $plugin_name ) {
            $this->plugin_name = $plugin_name;
        }

		/**
		 * Add menu link for the settings page to Wordpress sidebar
		 *
		 * @since    1.0.0
		 */
        public function add_menu_page() {
            global $accolore_config;

			$config_menu     = $accolore_config[$this->plugin_name]['menu'];
			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];

			$default_tab_id = '';
			foreach ($config_sections as $section) {
				if ($section['default']) $default_tab_id = $section['id'];
			}
       
			add_menu_page( $config_menu['page_title'], $config_menu['menu_title'], $config_menu['capability'], $config_prefix . '_settings', array( $this, 'settings_page_content' ), $config_menu['icon'], $config_menu['position'] );
        }
		
		/**
		 * Configure the settings sections
		 *
		 * @since    1.0.0
		 */
        public function setup_sections() {
			global $accolore_config;

			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];

			foreach($config_sections as $section) {
				add_settings_section( $section['id'], $section['title'], array( $this, 'section_callback' ), $config_prefix . '_' . $section['id'] . '_settings');
			}
        }

		/**
		 * Display the sections top content (between heading and fields)
		 *
		 * @since    1.0.0
         * @param    <array>    $arguments     Array of arguments (id and title)
		 */
        public function section_callback( $arguments ) {
        }

		/**
		 * Configure the setting fields
		 *
		 * @since    1.0.0
		 */
        public function setup_fields() {
			global $accolore_config;

			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];

			foreach($config_sections as $section) {
				foreach($section['fields'] as $field) {
					add_settings_field( $field['id'], $field['title'], array( $this, 'field_callback' ), $config_prefix . '_' . $section['id'] . '_settings', $section['id'], $field );

					switch($field['type'] ) {
						case 'link_color':
							foreach ($field['selector'] as $key => $value) {
								if ($value === true) {
									register_setting(
										$config_prefix . '_' . $section['id'] . '_settings',
										$config_prefix . '_' . $field['id'] . '_' . $key,
										array(
											'default'           => $field['default'][$key],
											'sanitize_callback' => array($this, 'sanitize_settings'),
										)
									);
								}
							}
							break;
						case 'typography':
							if ($field['default']['family'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_family',
									array(
										'default'           => $field['default']['family'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['color'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_color',
									array(
										'default'           => $field['default']['color'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['size'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_size',
									array(
										'default'           => $field['default']['size'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['weight'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_weight',
									array(
										'default'           => $field['default']['weight'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;
						case 'password':
							if ($field['default']['username'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_username',
									array(
										'default'           => $field['default']['username'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['password'] !== false) {
								if ($field['password_encrypt'] == true) {
									register_setting(
										$config_prefix . '_' . $section['id'] . '_settings',
										$config_prefix . '_' . $field['id'] . '_password',
										array(
											'default'           => $field['default']['password'],
											'sanitize_callback' => array($this, 'encrypt_settings'),
										)
									);
								} else {
									register_setting(
										$config_prefix . '_' . $section['id'] . '_settings',
										$config_prefix . '_' . $field['id'] . '_password',
										array(
											'default'           => $field['default']['password'],
											'sanitize_callback' => array($this, 'sanitize_settings'),
										)
									);
								}
							}
							break;							
						case 'reset':
							register_setting(
								$config_prefix . '_' . $section['id'] . '_settings',
								$config_prefix . '_' . $field['id'],
								array(
									'default'           => $field['default'],
									'sanitize_callback' => array($this, 'reset_settings'),
								)
							);
							break;
						case 'spacing':
							if ($field['default']['top'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_top',
									array(
										'default'           => $field['default']['top'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['right'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_right',
									array(
										'default'           => $field['default']['right'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['bottom'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_bottom',
									array(
										'default'           => $field['default']['bottom'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['left'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_left',
									array(
										'default'           => $field['default']['left'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['unit'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_unit',
									array(
										'default'           => $field['default']['unit'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;
						case 'border':
							if ($field['default']['top'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_top',
									array(
										'default'           => $field['default']['top'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['right'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_right',
									array(
										'default'           => $field['default']['right'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['bottom'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_bottom',
									array(
										'default'           => $field['default']['bottom'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['left'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_left',
									array(
										'default'           => $field['default']['left'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['style'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_style',
									array(
										'default'           => $field['default']['style'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['color'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_color',
									array(
										'default'           => $field['default']['color'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;							
						case 'size':
							if ($field['default']['width'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_width',
									array(
										'default'           => $field['default']['width'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['height'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_height',
									array(
										'default'           => $field['default']['height'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['unit'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_unit',
									array(
										'default'           => $field['default']['unit'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;
						case 'slider':
							if ($field['subtype'] == 'single') {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'],
									array(
										'default'           => $field['default'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							} elseif ($field['subtype'] == 'double') {
								if ($field['default']['left_handler'] !== false) {
									register_setting(
										$config_prefix . '_' . $section['id'] . '_settings',
										$config_prefix . '_' . $field['id'] . '_left_handler',
										array(
											'default'           => $field['default']['left_handler'],
											'sanitize_callback' => array($this, 'sanitize_settings'),
										)
									);
								}
								if ($field['default']['right_handler'] !== false) {
									register_setting(
										$config_prefix . '_' . $section['id'] . '_settings',
										$config_prefix . '_' . $field['id'] . '_right_handler',
										array(
											'default'           => $field['default']['right_handler'],
											'sanitize_callback' => array($this, 'sanitize_settings'),
										)
									);
								}
							}
							break;							
						/*case 'multi_text':
							register_setting(
								$config_prefix . '_' . $section['id'] . '_settings',
								$config_prefix . '_' . $field['id'],
								array(
									'default'           => $field['default'],
									'sanitize_callback' => array($this, 'serialize_settings'),
								)
							);
							break;*/
						case 'raw':
						case 'separator':
							break;
						default:
							register_setting(
								$config_prefix . '_' . $section['id'] . '_settings',
								$config_prefix . '_' . $field['id'],
								array(
									'default'           => $field['default'],
									'sanitize_callback' => array($this, 'sanitize_settings'),
								)
							);
					}
				}
			}
		}
		
		/**
		 * Display the field
		 *
		 * @since    1.0.0
         * @param    <array>    $arguments     Array of arguments
		 */
		public function field_callback( $arguments ) {
			global $accolore_config;

			$text_domain   = $accolore_config[$this->plugin_name]['text_domain'];
			$config_prefix = $accolore_config[$this->plugin_name]['prefix'];
			$element_id    = $config_prefix . '_' . str_replace("-", "_", esc_attr($arguments['id']));
			?>
			<div id="<?php echo $element_id; ?>-wrapper">
			<?php
			// Element Rendering
			switch ($arguments['type']) {
				case 'reset':
					?>
					<input type="hidden" name="<?php echo esc_attr($arguments['id']) ?>" id="<?php echo esc_attr($arguments['id']) ?>" value="">
					<?php
					break;
				case 'media_image':
					$element_value = get_option($element_id, null);
					$element_array = explode(',', $element_value);
					$element_url   = '';
					$multiple      = ($arguments['multiple'] == true ? "'add'" : 'false');

					wp_enqueue_media();
					?>
					<div id="<?php echo $element_id; ?>-media-preview-wrapper" class="wpals-media-preview-wrapper">
						<?php foreach($element_array as $key => $value) : ?>
							<?php 
							if ($value == '') {
								$element_url = $arguments['default'];
							} else {
								$tmp = wp_get_attachment_image_src($value, 'thumbnail');
								$element_url = $tmp[0]; 
							}
							?>
							<img src="<?php echo esc_url($element_url); ?>">
						<?php endforeach ?>
					</div>
					
					<button id="<?php echo $element_id; ?>-upload-media-button" title="<?php _e( 'Select media', $text_domain ); ?>"><span class="wpals-icon-plus-circled"></span></button>
					<button id="<?php echo $element_id; ?>-remove-media-button" title="<?php _e( 'Remove media', $text_domain ); ?>"><span class="wpals-icon-trash"></span></button>
					<input type="hidden" name="<?php echo $element_id; ?>" id="<?php echo $element_id; ?>" value="<?php echo $element_value; ?>">
					<script>
						var file_frame;
						var <?php echo $element_id; ?>_selected_post_ids = [<?php echo esc_attr($element_value); ?>];

						var el_upload = document.querySelector('#<?php echo $element_id; ?>-upload-media-button');
						var el_remove = document.querySelector('#<?php echo $element_id; ?>-remove-media-button');

						el_upload.addEventListener('click', function(event) {
							event.preventDefault();

							if ( typeof file_frame != 'undefined' ) {
								file_frame.close();
							}

							file_frame = wp.media.frames.file_frame = wp.media({
								title: '<?php echo _e('Select media', $text_domain); ?>',
								button: {
									text: '<?php echo _e('Use this media', $text_domain); ?>',
								},
								multiple: <?php echo $multiple; ?>,
								library: {
									type: 'image',
								},
							});

							file_frame.on( 'open', function() {
								if (<?php echo $element_id; ?>_selected_post_ids != '') {
									<?php echo $element_id; ?>_selected_post_ids.forEach(function( value ) {
										file_frame.state().get('selection').add(wp.media.attachment(value));
									});
								}
							});

							file_frame.on( 'select', function() {
								attachment = file_frame.state().get('selection').toJSON();

								let id_array  = [];
								let url_array = [];
								
								attachment.forEach(function( el ) {
									id_array.push(el.id);
									url_array.push(el.sizes.thumbnail.url);
								});
								
								document.querySelector('#<?php echo $element_id; ?>').value = id_array.toString();
							
								let wrapper = document.querySelector('#<?php echo $element_id; ?>-media-preview-wrapper');
								wrapper.innerHTML = '';
								
								url_array.forEach(function( value ) {
									let img = document.createElement('img');
									img.src = value;
									wrapper.appendChild(img);
								});

								<?php echo $element_id; ?>_selected_post_ids = url_array;
							});

							file_frame.open();
						}, false);

						el_remove.addEventListener('click', function(event) {
							event.preventDefault();

							document.querySelector('#<?php echo $element_id; ?>').value = '';

							let wrapper = document.querySelector('#<?php echo $element_id; ?>-media-preview-wrapper');
							wrapper.innerHTML = '';
							let img = document.createElement('img');
							img.src = '<?php echo $arguments['default']; ?>';
							wrapper.appendChild(img);

							<?php echo $element_id; ?>_selected_post_id = '';
						});
					</script>
					<?php
					break;
				case 'text':
					$element_value = get_option($element_id, $arguments['default']);
					$min_tag = '';
					$max_tag = '';
					switch($arguments['subtype']) {
						case 'number':
						case 'date':
							$min_tag = 'min="' . $arguments['min'] . '"';
							$max_tag = 'max="' . $arguments['max'] . '"';
							break;
						case 'text':
							break;
					}
					?>
					<input type="<?php echo $arguments['subtype']; ?>" name="<?php echo $element_id ?>" id="<?php echo $element_id ?>" value="<?php echo $element_value; ?>" <?php echo $min_tag . ' ' . $max_tag; ?> class="regular-text">
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				/* case 'multi_text':
					$element_value = unserialize(get_option($element_id, $arguments['default']));

					echo $element_value;
					?>
					<div id="<?php echo $element_id ?>_input_wrapper">
						<?php if (is_array($element_value)) : ?>
							<?php foreach($element_value as $key => $element) : ?>
								<input type="text" name="<?php echo $element_id ?>[]" id="<?php echo $element_id ?>[]" value="<?php echo $element; ?>" class="regular-text">
								<button class="<?php echo $element_id; ?>-remove-text-button" title="<?php _e( 'Remove text', $text_domain ); ?>"><span class="wpals-icon-trash"></span></button>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<input type="text" name="<?php echo $element_id ?>_new" id="<?php echo $element_id ?>_new" value="" class="regular-text"><button id="<?php echo $element_id; ?>-add-text-button" title="<?php _e( 'Add text', $text_domain ); ?>"><span class="wpals-icon-plus-circled"></span></button>
					<input type="hidden" name="<?php echo $element_id; ?>" id="<?php echo $element_id; ?>" value="<?php echo $element_value; ?>">
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<script>
						let btn_new_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>-add-text-button');

						btn_new_<?php echo $element_id; ?>.addEventListener('click', function(event) {
								event.preventDefault();

								let el_input_new = document.querySelector('#<?php echo $element_id ?>_new');
								let el_wrapper   = document.querySelector('#<?php echo $element_id ?>_input_wrapper');

								let el_input_created = document.createElement("input");
								el_input_created.setAttribute('type', 'text');
								el_input_created.classList.add('regular-text');
								el_input_created.setAttribute('id', '<?php echo $element_id ?>[]');
								el_input_created.setAttribute('name', '<?php echo $element_id ?>[]');
								el_input_created.setAttribute('value', el_input_new.value);

								let el_button_created = document.createElement("button");
								el_button_created.classList.add('<?php echo $element_id; ?>-remove-text-button');
								el_button_created.setAttribute('title', '<?php _e( 'Remove text', $text_domain ); ?>');
								
								let el_icon_created = document.createElement('span');
								el_icon_created.classList.add('wpals-icon-trash');

								el_button_created.appendChild(el_icon_created);

								el_wrapper.appendChild(el_input_created);
								el_wrapper.appendChild(el_button_created);

								el_input_new.value = '';

								// if (palette_selected != null) {
								// 	palette_selected.classList.remove('selected');
								// }

								// var input_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>');
								// var label_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>_label');
								// var data_color = this.dataset.color;

								// input_<?php echo $element_id; ?>.value = data_color;
								// label_<?php echo $element_id; ?>.innerHTML = data_color;

								// event.target.classList.add('selected');
							});

						let btn_remove_<?php echo $element_id; ?> = document.querySelectorAll('.<?php echo $element_id; ?>-remove-text-button');
						

						btn_remove_<?php echo $element_id; ?>.forEach(function( el ) {
							el.addEventListener('click', function(event) {
								event.preventDefault();

								console.log(event.target);

								// var palette_selected = document.querySelector('#<?php echo $element_id; ?>-wrapper .wpals-color-palette.selected');

								// if (palette_selected != null) {
								// 	palette_selected.classList.remove('selected');
								// }

								// var input_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>');
								// var label_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>_label');
								// var data_color = this.dataset.color;

								// input_<?php echo $element_id; ?>.value = data_color;
								// label_<?php echo $element_id; ?>.innerHTML = data_color;

								// event.target.classList.add('selected');
							});
						});
					</script>
					<?php
					break; */					
				case 'password':
					$username = get_option($element_id . '_username', $arguments['default']['username']);
					$password = get_option($element_id . '_password', $arguments['default']['password']);
					?>
					<div class="wpals-input-icons">
						<i class="wpals-icon-user icon"></i>
						<input type="text" name="<?php echo $element_id ?>_username" id="<?php echo $element_id ?>_username" value="<?php echo $username; ?>" placeholder="<?php echo $arguments['placeholders']['username']; ?>" class="regular-text">
					</div>
					<div class="wpals-input-icons">
						<i class="wpals-icon-lock-open-alt icon"></i>
						<input type="password" name="<?php echo $element_id ?>_password" id="<?php echo $element_id ?>_password" value="<?php echo $password; ?>" placeholder="<?php echo $arguments['placeholders']['password']; ?>" class="regular-text">
					</div>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;										
				case 'textarea':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<textarea name="<?php echo $element_id ?>" id="<?php echo $element_id ?>" class="large-text" rows="5"><?php echo $element_value ?></textarea>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php 
					break;
				case 'editor':
					$element_value = get_option($element_id, $arguments['default']);
					$element_args = array();
					if (isset($arguments['options']['wpautop'])) $element_args['wpautop'] = $arguments['options']['wpautop'];
					if (isset($arguments['options']['media_buttons'])) $element_args['media_buttons'] = $arguments['options']['media_buttons'];
					if (isset($arguments['options']['default_editor'])) $element_args['default_editor'] = $arguments['options']['default_editor'];
					if (isset($arguments['options']['drag_drop_upload'])) $element_args['drag_drop_upload'] = $arguments['options']['drag_drop_upload'];
					if (isset($arguments['options']['textarea_rows'])) $element_args['textarea_rows'] = $arguments['options']['textarea_rows'];
					if (isset($arguments['options']['teeny'])) $element_args['teeny'] = $arguments['options']['teeny'];
					if (isset($arguments['options']['tinymce'])) $element_args['tinymce'] = $arguments['options']['tinymce'];
					if (isset($arguments['options']['quicktags'])) $element_args['quicktags'] = $arguments['options']['quicktags'];
					
					if (count($element_args) > 0) {
						wp_editor( $element_value, $element_id, $element_args );
					} else {
						wp_editor( $element_value, $element_id );
					}
					break;
				case 'raw':
					echo $arguments['content'];
					break;
				case 'separator':
					echo '<hr class="wpals-separator" />';
					break;					
				case 'select':
					$element_value   = get_option($element_id, $arguments['default']);
					$element_options = $arguments['options'];
					$icons           = ($arguments['subtype'] == 'icons' ? true : false);

					$hidden_class = '';
					?>
					<?php if ($icons) : ?>
						<?php $hidden_class = 'hidden'; ?>
						<div id="<?php echo $element_id; ?>_wrapper">
							<?php foreach($element_options as $key => $value) :?>
								<img id="<?php echo $element_id; ?>_icon_<?php echo $key; ?>" class="wpals-option-image <?php echo ($key == $element_value ? "selected" : "") ?>" src="<?php echo $value ?>" data-select="<?php echo $element_id; ?>" data-key="<?php echo $key ?>" alt="<?php echo $key ?>">
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
					<select id="<?php echo $element_id; ?>" name="<?php echo $element_id; ?>" class="<?php echo $hidden_class; ?>">
					<?php foreach($element_options as $key => $value) :?>
						<option value="<?php echo $key ?>" <?php echo ($key == $element_value ? "selected" : "") ?>><?php echo $value; ?></option>
					<?php endforeach; ?>
					</select>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php if ($icons) : ?>
						<script>
							var el_images = document.querySelectorAll('.wpals-option-image');

							el_images.forEach(function( el ) {
								el.addEventListener('click', function(event) {
									event.preventDefault();

									let data_select = document.querySelector("#" + this.dataset.select);
									let data_key = this.dataset.key;
									data_select.value = data_key;

									let el_wrapper_images = document.querySelectorAll('#<?php echo $element_id; ?>_wrapper img');
									el_wrapper_images.forEach(function( el ) {
										el.classList.remove('selected');
									});

									this.classList.add('selected');
								});
							});
						</script>
					<?php endif; ?>
					<?php
					break;				
				case 'switch':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<select id="<?php echo $element_id; ?>" name="<?php echo $element_id; ?>">
						<option value="0" <?php echo ($element_value != 1 ? "selected" : "") ?>><?php echo $arguments['off'] ?></option>
						<option value="1" <?php echo ($element_value == 1 ? "selected" : "") ?>><?php echo $arguments['on'] ?></option>
					</select>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'slider':
					$is_double = ($arguments['subtype'] == 'double' ? true : false);
					if ($is_double) {
						$element_value_left  = get_option($element_id . '_left_handler', $arguments['default']['left_handler']);
						$element_value_right = get_option($element_id . '_right_handler', $arguments['default']['right_handler']);
						$element_string      = $element_value_left . ',' . $element_value_right;
						$noui_connect        = '[false,true,false]';
					} else {
						$element_value  = get_option($element_id, $arguments['default']);
						$element_string = $element_value;
						$noui_connect   = '[true,false]';
					}
					?>
					<div id="<?php echo $element_id; ?>-slider" class="wpals-slider"></div>
					<?php if ($is_double) : ?>
						<input type="hidden" value="<?php echo $element_value_left; ?>" id="<?php echo $element_id; ?>_left_handler" name="<?php echo $element_id; ?>_left_handler" />
						<input type="hidden" value="<?php echo $element_value_right; ?>" id="<?php echo $element_id; ?>_right_handler" name="<?php echo $element_id; ?>_right_handler" />
					<?php else : ?>
						<input type="hidden" value="<?php echo $element_value; ?>" id="<?php echo $element_id; ?>" name="<?php echo $element_id; ?>" />
					<?php endif; ?>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<script>
						var <?php echo $element_id; ?>_el_slider = document.getElementById('<?php echo $element_id; ?>-slider');
						
						noUiSlider.create(<?php echo $element_id; ?>_el_slider, {
							start: [<?php echo $element_string; ?>],
							connect: <?php echo $noui_connect; ?>,
							tooltips: true,
							step: <?php echo $arguments['step']; ?>,
							range: {
								'min': [<?php echo $arguments['min']; ?>],
								'max': [<?php echo $arguments['max']; ?>]
							}
						});
						<?php if ($is_double) : ?>
							var <?php echo $element_id; ?>_el_input_left  = document.getElementById('<?php echo $element_id; ?>_left_handler');
							var <?php echo $element_id; ?>_el_input_right = document.getElementById('<?php echo $element_id; ?>_right_handler');
							
							<?php echo $element_id; ?>_el_slider.noUiSlider.on('update', function (values, handle) {
								<?php echo $element_id; ?>_el_input_left.value = values[0];
								<?php echo $element_id; ?>_el_input_right.value = values[1];							
							});
							<?php /* echo $element_id; ?>_el_input_left.addEventListener('change', function () {
								<?php echo $element_id; ?>_el_slider.noUiSlider.set([this.value,null]);
							});
							<?php echo $element_id; ?>_el_input_right.addEventListener('change', function () {
								<?php echo $element_id; ?>_el_slider.noUiSlider.set([null,this.value]);
							});
							<?php */ ?>
						<?php else : ?>
							var <?php echo $element_id; ?>_el_input = document.getElementById('<?php echo $element_id; ?>');
							<?php echo $element_id; ?>_el_slider.noUiSlider.on('update', function (values, handle) {
								<?php echo $element_id; ?>_el_input.value = values[handle];
							});
							<?php /* echo $element_id; ?>_el_input.addEventListener('change', function () {
								<?php echo $element_id; ?>_el_slider.noUiSlider.set(this.value);
							});
							<?php */ ?>
						<?php endif; ?>
					</script>
					<?php				
					break;
				case 'spacing':
					$top    = get_option($element_id . '_top', $arguments['default']['top']);
					$right  = get_option($element_id . '_right', $arguments['default']['right']);
					$bottom = get_option($element_id . '_bottom', $arguments['default']['bottom']);
					$left   = get_option($element_id . '_left', $arguments['default']['left']);
					$unit   = get_option($element_id . '_unit', $arguments['default']['unit']);
					?>
					<table>
						<tr>
							<td><input type="text" name="<?php echo $element_id ?>_top" id="<?php echo $element_id ?>_top" value="<?php echo $top; ?>" class="small-text" title="<?php _e("Top", $text_domain) ?>" /><span class="wpals-icon-up" title="<?php _e("Top", $text_domain) ?>"></span></td>
							<td><input type="text" name="<?php echo $element_id ?>_right" id="<?php echo $element_id ?>_right" value="<?php echo $right; ?>" class="small-text" title="<?php _e("Right", $text_domain) ?>" /><span class="wpals-icon-right" title="<?php _e("Right", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo $element_id ?>_bottom" id="<?php echo $element_id ?>_bottom" value="<?php echo $bottom; ?>" class="small-text" title="<?php _e("Bottom", $text_domain) ?>" /><span class="wpals-icon-down" title="<?php _e("Bottom", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo $element_id ?>_left" id="<?php echo $element_id ?>_left" value="<?php echo $left; ?>" class="small-text" title="<?php _e("Left", $text_domain) ?>" /><span class="wpals-icon-left" title="<?php _e("Left", $text_domain) ?>"></span></td>
							<td>
								<select name="<?php echo $element_id ?>_unit" id="<?php echo $element_id ?>_unit">
								<?php foreach(array('px', 'em', 'rem', '%') as $value) : ?>
									<option value="<?php echo $value ?>" <?php echo ($value == $unit ? "selected" : "") ?>><?php echo $value; ?></option>
								<?php endforeach; ?>
								</select>
							</td>
						</tr>
					</table>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'border':
					$top    = get_option($element_id . '_top', $arguments['default']['top']);
					$right  = get_option($element_id . '_right', $arguments['default']['right']);
					$bottom = get_option($element_id . '_bottom', $arguments['default']['bottom']);
					$left   = get_option($element_id . '_left', $arguments['default']['left']);
					$style  = get_option($element_id . '_style', $arguments['default']['style']);
					$color  = get_option($element_id . '_color', $arguments['default']['color']);
					?>
					<table>
						<tr>
							<td><input type="text" name="<?php echo $element_id ?>_top" id="<?php echo $element_id ?>_top" value="<?php echo $top; ?>" class="small-text" title="<?php _e("Top", $text_domain) ?>" /><span class="wpals-icon-up" title="<?php _e("Top", $text_domain) ?>"></span></td>
							<td><input type="text" name="<?php echo $element_id ?>_right" id="<?php echo $element_id ?>_right" value="<?php echo $right; ?>" class="small-text" title="<?php _e("Right", $text_domain) ?>" /><span class="wpals-icon-right" title="<?php _e("Right", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo $element_id ?>_bottom" id="<?php echo $element_id ?>_bottom" value="<?php echo $bottom; ?>" class="small-text" title="<?php _e("Bottom", $text_domain) ?>" /><span class="wpals-icon-down" title="<?php _e("Bottom", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo $element_id ?>_left" id="<?php echo $element_id ?>_left" value="<?php echo $left; ?>" class="small-text" title="<?php _e("Left", $text_domain) ?>" /><span class="wpals-icon-left" title="<?php _e("Left", $text_domain) ?>"></span></td>
							<td>
								<select name="<?php echo $element_id ?>_style" id="<?php echo $element_id ?>_style">
								<?php foreach(array('dotted','dashed','solid','double','groove','ridge','inset','outset','none','hidden') as $value) : ?>
									<option value="<?php echo $value ?>" <?php echo ($value == $style ? "selected" : "") ?>><?php echo $value; ?></option>
								<?php endforeach; ?>
								</select>
							</td>
							<td>
								<div id="<?php echo $element_id . '_picker'; ?>" class="wpals-color-picker-boxed"></div>
								<input type="hidden" name="<?php echo $element_id ?>_color" id="<?php echo $element_id ?>_color" value="<?php echo $color ?>">
								<script>
									var target_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id . '_picker'; ?>");
									var input_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id; ?>_color");
									var picker_<?php echo $element_id; ?> = new Picker({
										parent      : target_<?php echo $element_id; ?>,
										color       : '<?php echo $color; ?>',
										editorFormat: 'hex',
										onDone      : function(color) {
											target_<?php echo $element_id; ?>.style.background = color.rgbaString;
											input_<?php echo $element_id; ?>.value = color.rgbaString;
										},
										<?php echo $arguments['alpha'] ? 'alpha : true' : 'alpha : false';?>,
									});

									target_<?php echo $element_id; ?>.style.backgroundColor = "<?php echo $color ?>";
									input_<?php echo $element_id; ?>.value = "<?php echo $color ?>";
								</script>
							</td>
						</tr>
					</table>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;					
				case 'size':
					$width  = get_option($element_id . '_width', $arguments['default']['width']);
					$height = get_option($element_id . '_height', $arguments['default']['height']);
					$unit   = get_option($element_id . '_unit', $arguments['default']['unit']);
					?>
					<table>
						<tr>
							<td><input type="text" name="<?php echo $element_id ?>_width" id="<?php echo $element_id ?>_top" value="<?php echo $width; ?>" class="small-text" title="<?php _e("Width", $text_domain) ?>" /><span class="wpals-icon-resize-horizontal" title="<?php _e("Width", $text_domain) ?>"></span></td>
							<td><input type="text" name="<?php echo $element_id ?>_height" id="<?php echo $element_id ?>_height" value="<?php echo $height; ?>" class="small-text" title="<?php _e("Height", $text_domain) ?>" /><span class="wpals-icon-resize-vertical" title="<?php _e("Height", $text_domain) ?>"></span></td>
							<td>
								<select name="<?php echo $element_id ?>_unit" id="<?php echo $element_id ?>_unit">
								<?php foreach(array('px', 'em', 'rem', '%') as $value) : ?>
									<option value="<?php echo $value ?>" <?php echo ($value == $unit ? "selected" : "") ?>><?php echo $value; ?></option>
								<?php endforeach; ?>
								</select>
							</td>
						</tr>
					</table>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;					
				case 'link_color':
					foreach($arguments['selector'] as $selector_key => $selector_value) {
						if ($selector_value) {
							$element_value = get_option($element_id . '_' . $selector_key, $arguments['default'][$selector_key]);
							?>
							<div class="wpals-color-picker-wrapper">
								<label for="<?php echo $element_id . '_' . $selector_key ?>"><?php _e(ucfirst($selector_key), $this->plugin_name)?></label>
								<div id="<?php echo $element_id .'_' . $selector_key . '_picker'; ?>" class="wpals-color-picker"></div>
								<input type="hidden" name="<?php echo $element_id . '_' . $selector_key ?>" id="<?php echo $element_id . '_' . $selector_key ?>" value="<?php echo $element_value; ?>">
							</div>
							<script>
								var target_<?php echo $element_id . '_' . $selector_key; ?> = document.querySelector("#<?php echo $element_id . '_' . $selector_key . '_picker'; ?>");
								var input_<?php echo $element_id . '_' . $selector_key; ?> = document.querySelector("#<?php echo $element_id . '_' . $selector_key; ?>");
								var picker_<?php echo $element_id . '_' . $selector_key; ?> = new Picker({
									parent      : target_<?php echo $element_id . '_' . $selector_key; ?>,
									color       : '<?php echo $element_value; ?>',
									alpha       : false,
									editorFormat: 'hex',
									onDone      : function(color) {
										target_<?php echo $element_id . '_' . $selector_key; ?>.style.background = color.hex;
										input_<?php echo $element_id . '_' . $selector_key; ?>.value = color.hex;
									}
								});
								target_<?php echo $element_id . '_' . $selector_key; ?>.style.backgroundColor = "<?php echo $element_value; ?>";
								input_<?php echo $element_id . '_' . $selector_key; ?>.value = "<?php echo $element_value; ?>";
							</script>
						<?php }
					} ?>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'background_color':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<div id="<?php echo $element_id . '_picker'; ?>" class="wpals-color-picker-boxed"></div>
					<input type="hidden" name="<?php echo $element_id ?>" id="<?php echo $element_id ?>" value="<?php echo $element_value ?>">
					<script>
						var target_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id . '_picker'; ?>");
						var input_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id; ?>");
						var picker_<?php echo $element_id; ?> = new Picker({
							parent      : target_<?php echo $element_id; ?>,
							color       : "<?php echo $element_value; ?>",
							alpha       : false,
							editorFormat: "hex",
							onDone      : function(color) {
								target_<?php echo $element_id; ?>.style.background = color.hex;
								input_<?php echo $element_id; ?>.value = color.hex;
							}
						});
						target_<?php echo $element_id; ?>.style.backgroundColor = "<?php echo $element_value ?>";
						input_<?php echo $element_id; ?>.value = "<?php echo $element_value ?>";
					</script>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'color':
					$element_value = get_option($element_id, $arguments['default']);			
					?>
					<div id="<?php echo $element_id . '_picker'; ?>" class="wpals-color-picker-boxed"></div>
					<input type="hidden" name="<?php echo $element_id ?>" id="<?php echo $element_id ?>" value="<?php echo $element_value ?>">
					<script>
						var target_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id . '_picker'; ?>");
						var input_<?php echo $element_id; ?> = document.querySelector("#<?php echo $element_id; ?>");
						var picker_<?php echo $element_id; ?> = new Picker({
							parent      : target_<?php echo $element_id; ?>,
							color       : '<?php echo $element_value; ?>',
							editorFormat: 'hex',
							onDone      : function(color) {
								target_<?php echo $element_id; ?>.style.background = color.rgbaString;
								input_<?php echo $element_id; ?>.value = color.rgbaString;
							},
							<?php echo $arguments['alpha'] ? 'alpha : true' : 'alpha : false';?>,
						});

						target_<?php echo $element_id; ?>.style.backgroundColor = "<?php echo $element_value ?>";
						input_<?php echo $element_id; ?>.value = "<?php echo $element_value ?>";
					</script>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'color_palette':
					$element_value = get_option($element_id, $arguments['default']);

					$colors = array();
					if ($arguments['options']['type'] == 'hex') {
						$colors = $arguments['options']['colors'];
					} elseif ($arguments['options']['type'] == 'material') {
						$colors = $this->_get_settings_values($arguments['options']['colors']);
					}
					?>
					<?php foreach($colors as $color) : ?><div class="wpals-color-palette <?php echo ($element_value == $color ? 'selected' : ''); ?>" style="background-color: <?php echo $color; ?>;" title="<?php echo $color; ?>" data-color="<?php echo $color; ?>"></div><?php endforeach; 
					?>
					<input type="hidden" id="<?php echo $element_id; ?>" name="<?php echo $element_id; ?>" value="<?php echo $element_value; ?>">
					<p id="<?php echo $element_id; ?>_label"><?php echo ($element_value == '' ? esc_html__('No color selected', $text_domain) : $element_value); ?></p>
					<script>
						var palette_<?php echo $element_id; ?> = document.querySelectorAll('#<?php echo $element_id; ?>-wrapper .wpals-color-palette');

						palette_<?php echo $element_id; ?>.forEach(function( el ) {
							el.addEventListener('click', function(event) {
								event.preventDefault();

								var palette_selected = document.querySelector('#<?php echo $element_id; ?>-wrapper .wpals-color-palette.selected');

								if (palette_selected != null) {
									palette_selected.classList.remove('selected');
								}

								var input_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>');
								var label_<?php echo $element_id; ?> = document.querySelector('#<?php echo $element_id; ?>_label');
								var data_color = this.dataset.color;

								input_<?php echo $element_id; ?>.value = data_color;
								label_<?php echo $element_id; ?>.innerHTML = data_color;

								event.target.classList.add('selected');
							});
						});
					</script>
					<?php 
					break;				
				case 'typography':
					$element_value_family = get_option($element_id . '_family', $arguments['default']['family']); 
					$picker_uid = uniqid();
					?>
					<?php if ($element_value_family !== false) : ?>
						<div class="wpals-font-picker-wrapper">
							<label for="<?php echo $element_id . '_family' ?>"><?php _e('Font family', $this->plugin_name)?></label>
							<div id="font-picker-<?php echo $picker_uid; ?>"></div>
							<input type="hidden" id="<?php echo $element_id; ?>_family" name="<?php echo $element_id; ?>_family" value="<?php echo $element_value_family ?>">
						</div>
						<script>
							var input_<?php echo $element_id; ?>_family = document.querySelector("#<?php echo $element_id; ?>_family");

							const fontPicker_<?php echo $element_id; ?> = new FontPicker(
								"<?php echo $arguments['google_api_key']; ?>", // Google API key
								"<?php echo $element_value_family; ?>",
								{
									pickerId : "<?php echo $picker_uid; ?>",
									limit : 30,
								},
								function(font) {
									input_<?php echo $element_id; ?>_family.value = font.family;
								}
							);
						</script>
					<?php endif; ?>
					<?php $element_value_color  = get_option($element_id . '_color', $arguments['default']['color']); ?>
					<?php if ($element_value_color !== false) : ?>
						<div class="wpals-color-picker-wrapper">
							<label for="<?php echo $element_id . '_color' ?>"><?php _e('Color', $this->plugin_name)?></label>
							<div id="<?php echo $element_id . '_picker'; ?>" class="wpals-color-picker"></div>
							<input type="hidden" name="<?php echo $element_id ?>_color" id="<?php echo $element_id ?>_color" value="<?php echo $element_value_color ?>">
						</div>
						<script>
							var target_<?php echo $element_id; ?>_color = document.querySelector("#<?php echo $element_id . '_picker'; ?>");
							var input_<?php echo $element_id; ?>_color = document.querySelector("#<?php echo $element_id; ?>_color");
							var picker_<?php echo $element_id; ?> = new Picker({
								parent      : target_<?php echo $element_id; ?>_color,
								color       : '<?php echo $element_value_color; ?>',
								alpha       : false,
								editorFormat: 'hex',
								onDone      : function(color) {
									target_<?php echo $element_id; ?>_color.style.background = color.hex;
									input_<?php echo $element_id; ?>_color.value = color.hex;
								}
							});

							target_<?php echo $element_id; ?>_color.style.backgroundColor = "<?php echo $element_value_color ?>";
							input_<?php echo $element_id; ?>_color.value = "<?php echo $element_value_color ?>";
						</script>
					<?php endif; ?>
					<?php $element_value_size = get_option($element_id . '_size', $arguments['default']['size']); ?>
					<?php if ($element_value_size !== false) : ?>
						<div class="wpals-font-picker-wrapper">
							<label for="<?php echo $element_id . '_size' ?>"><?php _e('Size', $this->plugin_name)?></label>
							<input type="text" name="<?php echo $element_id ?>_size" id="<?php echo $element_id ?>_size" value="<?php echo $element_value_size; ?>">
						</div>
					<?php endif; ?>
					<?php $element_value_weight = get_option($element_id . '_weight', $arguments['default']['weight']); ?>
					<?php if ($element_value_weight !== false) : ?>
						<div class="wpals-font-picker-wrapper">
							<label for="<?php echo $element_id . '_weight' ?>"><?php _e('Font weight', $this->plugin_name)?></label>
							<select id="<?php echo $element_id; ?>_weight" name="<?php echo $element_id; ?>_weight">
								<option value="400" <?php echo ($element_value_weight == '400' ? "selected" : "") ?>><?php _e('Regular' , $this->plugin_name) ?></option>
								<option value="700" <?php echo ($element_value_weight == '700' ? "selected" : "") ?>><?php _e('Bold' , $this->plugin_name) ?></option>
							</select>
						</div>
					<?php endif; ?>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'media_other':
					$element_value = get_option($element_id, null);
					$element_title = wp_basename( get_attached_file( $element_value ) );
					if ($element_title == '') $element_title = __('No media selected', $text_domain);

					wp_enqueue_media();
					?>
					<p class="media-title" id="<?php echo $element_id; ?>-media-title"><?php echo $element_title; ?></p>
					<button id="<?php echo $element_id; ?>-upload-media-button" title="<?php _e( 'Select media', $text_domain ); ?>"><span class="wpals-icon-plus-circled"></span></button>
					<button id="<?php echo $element_id; ?>-remove-media-button" title="<?php _e( 'Remove media', $text_domain ); ?>"><span class="wpals-icon-trash"></span></button>
					<input type="hidden" name="<?php echo $element_id; ?>" id="<?php echo $element_id; ?>" value="<?php echo $element_value; ?>">
					<script>
						var file_frame;
						var <?php echo $element_id; ?>_selected_post_id = '<?php echo $element_value; ?>';

						var el_upload = document.querySelector('#<?php echo $element_id; ?>-upload-media-button');
						var el_remove = document.querySelector('#<?php echo $element_id; ?>-remove-media-button');

						el_upload.addEventListener('click', function(event) {
							event.preventDefault();

							if ( typeof file_frame != 'undefined' ) {
								file_frame.close();
							}

							file_frame = wp.media.frames.file_frame = wp.media({
								title: '<?php echo _e('Select media', $text_domain); ?>',
								button: {
									text: '<?php echo _e('Use this media', $text_domain); ?>',
								},
								multiple: false,
								<?php if ($arguments['mime_type'] != false) : ?>
									library: {
										type: [<?php echo $arguments['mime_type']; ?>],
									},
								<?php endif; ?>
							});

							file_frame.on( 'open', function() {
								if (<?php echo $element_id; ?>_selected_post_id != '') {
									file_frame.state().get('selection').add(wp.media.attachment(<?php echo $element_id; ?>_selected_post_id));
								}
							});

							file_frame.on( 'select', function() {
								attachment = file_frame.state().get('selection').first().toJSON();

								document.querySelector('#<?php echo $element_id; ?>').value = attachment.id;
							
								let title = document.querySelector('#<?php echo $element_id; ?>-media-title');
								title.innerHTML = attachment.filename;

								<?php echo $element_id; ?>_selected_post_id = attachment.id;
							});

							file_frame.open();
							
						}, false);

						el_remove.addEventListener('click', function(event) {
							event.preventDefault();

							document.querySelector('#<?php echo $element_id; ?>').value = '';

							let title = document.querySelector('#<?php echo $element_id; ?>-media-title');
							title.innerHTML = '<?php _e('No media selected', $text_domain); ?>';

							<?php echo $element_id; ?>_selected_post_id = '';
						});
					</script>
					<?php
					break;
				default:
					echo "<pre>";
					print_r($arguments);
					echo "</pre>";
			}
			?>
			</div><!-- element_id wrapper close -->
			<?php
			if (isset($arguments['required'])) {
				$this->_render_visibility_js($element_id, $arguments['required']);
			}
		}

		/**
		 * Render the optional visibility javascript
		 *
		 * @since    1.0.0
		 * @param   $element_id		<string>	The id of the field element to display or hide
		 * @param   $required		<array>		Array with the data required for the field visualization
		 */
		private function _render_visibility_js($element_id, $required) {
			global $accolore_config;

			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];
			$target_id       = $config_prefix . '_' . str_replace("-", "_", $required['target']);
			$global_list_var = 'wp_al_visibility_list'; //$config_prefix . '_visibility_list';
			?>
			<script>
				var wp_al_visibility_list;

				if (typeof wp_al_visibility_list === undefined) {
					wp_al_visibility_list = [];
				} 

				var target    = document.getElementById('<?php echo $target_id; ?>');
				var wrapper   = document.getElementById('<?php echo $element_id; ?>-wrapper');
				var condition = false;
				
				wrapper = wrapper.parentElement.parentElement

				switch('<?php echo $required['operator']; ?>') {
					case '<':
						condition = (target.value < '<?php echo $required['value']; ?>');
						break;
					case '>':
						condition = (target.value > '<?php echo $required['value']; ?>');
						break;
					case '!=':
						condition = (target.value != '<?php echo $required['value']; ?>');
						break;
					case '=':
					default:
						condition = (target.value == '<?php echo $required['value']; ?>');
				}
				if (condition == true) {
					wrapper.classList.remove('hidden');
				} else {
					wrapper.classList.add('hidden');
				}

				wp_al_visibility_list.push([
					'<?php echo $target_id; ?>',
					'<?php echo $required['operator']; ?>',
					'<?php echo $required['value']; ?>',
					'<?php echo $element_id; ?>-wrapper',
				]);
				
				target.addEventListener('change', function (event) {
					event.preventDefault();

					wp_al_visibility_list.forEach(element => {
						var condition = false;
						var target    = document.getElementById(element[0]);
						var operator  = element[1];
						var value     = element[2];
						var wrapper   = document.getElementById(element[3]);

						wrapper = wrapper.parentElement.parentElement

						switch(operator) {
							case '<':
								condition = (target.value < value);
								break;
							case '>':
								condition = (target.value > value);
								break;
							case '!=':
								condition = (target.value != value);
								break;
							case '=':
							default:
								condition = (target.value == value);
						}
						if (condition == true) {
							wrapper.classList.remove('hidden');
						} else {
							wrapper.classList.add('hidden');
						}
					});
				}, false);
			</script>
			<?php 
		}

		/**
		 * Create the setting configuration page content
		 *
		 * @since    1.0.0
		 */
		public function settings_page_content () {
			global $accolore_config;

			$config_menu     = $accolore_config[$this->plugin_name]['menu'];
			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];
			$config_version  = $accolore_config[$this->plugin_name]['version'];
			
			$config_doc = false;
			if ( isset($accolore_config[$this->plugin_name]['documentation_tab']) ) {
				$config_doc = $accolore_config[$this->plugin_name]['documentation_tab'];
			}

			$default_tab = '';
			$tabs = array();
			foreach ($config_sections as $section) {
				$tabs[] = array(
					'title' => __($section['title'], $this->plugin_name),
					'id'  => $section['id']
				);
				if ($section['default']) $default_tab = $section['id'];
			}
			$active_tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
			?>
			<div class="wrap">
				<h2><?php echo $config_menu['page_title'] ?> Settings <span class="wpals-version-label">V<?php echo $config_version; ?></span></h2>
				<?php settings_errors(); ?>

				<h2 class="nav-tab-wrapper">
					<?php foreach($tabs as $tab) : ?>
						<a href="?page=<?php echo $config_prefix . '_settings&tab=' . $tab['id']; ?>" class="nav-tab <?php echo $active_tab == $tab['id'] ? 'nav-tab-active' : '' ?>"><?php echo $tab['title'] ?></a>
					<?php endforeach; ?>
					<?php if ($config_doc != false) : ?>
						<a href="<?php echo $config_doc['url']; ?>" class="nav-tab" target="_blank"><?php echo $config_doc['title']; ?> &raquo;</a>
					<?php endif; ?>
				</h2>

				<form method="post" action="options.php">
				<?php
					settings_fields( $config_prefix . '_' . $active_tab . '_settings' );
					do_settings_sections( $config_prefix . '_' . $active_tab . '_settings' );
					submit_button(__('Save settings', $this->plugin_name), 'primary', 'submit', false);
					echo ' ';
					submit_button(__('Reset all settings', $this->plugin_name), 'secondary', 'reset', false);
				?>
				</form>
			</div><!-- /.wrap -->
			<?php
		}

		/**
		 * Handle settings value sanitization
		 *
		 * @since    1.0.0
		 * @param   $input		<mixed>		Input value for the setting to sanitize
		 * @return 				<mixed>		The sanitized input value
		 */
		public function sanitize_settings ( $input ) {
			if (is_string($input)) $input = wp_specialchars_decode($input);
			return $input;		
		}

		/**
		 * Handle settings value serialization
		 *
		 * @since    1.0.0
		 * @param   $input		<mixed>		Input value for the setting to sanitize
		 * @return 				<mixed>		The serialized input value
		 */
		// public function serialize_settings ( $input ) {
		// 	if (is_string($input)) {
		// 		$input = wp_specialchars_decode($input);
		// 		$input = serialize($input);
		// 	} 		
		// 	return $input;		
		// }

		/**
		 * Handle settings value reset
		 *
		 * @since    1.0.0
		 * @param   $input		<mixed>		Input value for the setting
		 * @return 				<mixed>		The input value
		 */
		public function reset_settings ( $input ) {
			if (isset($_POST['reset'])) {
				$default_values = $this->get_settings_values(false);

				foreach($default_values as $key => $value) {
					delete_option($key);
				}
				return false;
			}
			return $input;
		}

		/**
		 * Handle settings value encryption and reset button
		 *
		 * @since    1.0.0
		 * @param   $input		<mixed>		Input value for the setting to encrypt
		 * @return 				<mixed>		The encrypted input value
		 */
		public function encrypt_settings ( $input ) {
			// check if the input is populated with a value that is already an MD5 string
			if (strlen($input) == 32 && ctype_xdigit($input)) {
				return $input;
			}
			//if (is_string($input)) $input= esc_html($input);
			if ($input != '') $input = md5($input);
			return $input;
		}

		/**
		 * Return an array of settings values or the defaults setting values
		 *
		 * @since    1.0.0
		 * @param 	$defaults 	boolean		If true, return the settings default values, if false return the saved setting values
		 * @return 				<array>		An array that contain the values for the settings fields
		 */
		public function get_settings_values( $defaults = false ) {
			global $accolore_config;
			$result = [];

			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];

			foreach($config_sections as $section) {
				foreach($section['fields'] as $field) {
				
					$element_id = $config_prefix . '_' . str_replace("-", "_", $field['id']);
					switch($field['type'] ) {
						case 'link_color':
							foreach ($field['selector'] as $selector_key => $selector_value) {
								if ($selector_value) {
									if ($defaults) {
										$result[$element_id . '_' . $selector_key] = $field['default'][$selector_key];
									} else {
										$result[$element_id . '_' . $selector_key] = get_option($element_id . '_' . $selector_key, $field['default'][$selector_key]);
									}
								}
							}
							break;
						case 'typography':
							if ($defaults) {
								$result[$element_id . '_family'] = $field['default']['family'];
								$result[$element_id . '_color']  = $field['default']['color'];
								$result[$element_id . '_size']   = $field['default']['size'];
								$result[$element_id . '_weight'] = $field['default']['weight'];
							} else {
								$result[$element_id . '_family'] = get_option($element_id . '_family', $field['default']['family']);
								$result[$element_id . '_color']  = get_option($element_id . '_color', $field['default']['color']);
								$result[$element_id . '_size']   = get_option($element_id . '_size', $field['default']['size']);
								$result[$element_id . '_weight'] = get_option($element_id. '_weight', $field['default']['weight']);
							}
							break;
						case 'spacing':
							if ($defaults) {
								$result[$element_id . '_top']    = $field['default']['top'];
								$result[$element_id . '_right']  = $field['default']['right'];
								$result[$element_id . '_bottom'] = $field['default']['bottom'];
								$result[$element_id . '_left']   = $field['default']['left'];
							} else {
								$result[$element_id . '_top']    = get_option($element_id . '_top', $field['default']['top']);
								$result[$element_id . '_right']  = get_option($element_id . '_right', $field['default']['right']);
								$result[$element_id . '_bottom'] = get_option($element_id . '_bottom', $field['default']['bottom']);
								$result[$element_id . '_left']   = get_option($element_id. '_left', $field['default']['left']);
							}
							break;
						case 'border':
							if ($defaults) {
								$result[$element_id . '_top']    = $field['default']['top'];
								$result[$element_id . '_right']  = $field['default']['right'];
								$result[$element_id . '_bottom'] = $field['default']['bottom'];
								$result[$element_id . '_left']   = $field['default']['left'];
								$result[$element_id . '_style']  = $field['default']['style'];
								$result[$element_id . '_color']  = $field['default']['color'];
							} else {
								$result[$element_id . '_top']    = get_option($element_id . '_top', $field['default']['top']);
								$result[$element_id . '_right']  = get_option($element_id . '_right', $field['default']['right']);
								$result[$element_id . '_bottom'] = get_option($element_id . '_bottom', $field['default']['bottom']);
								$result[$element_id . '_left']   = get_option($element_id. '_left', $field['default']['left']);
								$result[$element_id . '_style']  = get_option($element_id. '_style', $field['default']['style']);
								$result[$element_id . '_color']  = get_option($element_id. '_color', $field['default']['color']);
							}
							break;							
						case 'password':
							if ($defaults) {
								$result[$element_id . '_username'] = $field['default']['username'];
								$result[$element_id . '_password']  = $field['default']['password'];
							} else {
								$result[$element_id . '_username'] = get_option($element_id . '_username', $field['default']['username']);
								$result[$element_id . '_password']  = get_option($element_id . '_password', $field['default']['password']);
							}
							break;
						case 'size':
							if ($defaults) {
								$result[$element_id . '_width']  = $field['default']['width'];
								$result[$element_id . '_height'] = $field['default']['height'];
							} else {
								$result[$element_id . '_width']  = get_option($element_id . '_width', $field['default']['width']);
								$result[$element_id . '_height'] = get_option($element_id . '_height', $field['default']['height']);
							}
							break;
						case 'slider':
							if ($field['subtype'] == 'single') {
								if ($defaults) {
									$result[$element_id]  = $field['default'];
								} else {
									$result[$element_id]  = get_option($element_id, $field['default']);
								}	
							} elseif ($field['subtype'] == 'double') {
								if ($defaults) {
									$result[$element_id . '_left_handler']  = $field['default']['left_handler'];
									$result[$element_id . '_right_handler'] = $field['default']['right_handler'];
								} else {
									$result[$element_id . '_left_handler']  = get_option($element_id . '_left_handler', $field['default']['left_handler']);
									$result[$element_id . '_right_handler'] = get_option($element_id . '_right_handler', $field['default']['right_handler']);
								}
							}
							break;
						case 'color':
						case 'color_palette':
						case 'background_color':
						case 'switch':
						case 'select':
						case 'text':
						case 'media_image':
						case 'media_other':
						case 'textarea':
						case 'editor':
							if ($defaults) {
								$result[$element_id]  = $field['default'];
							} else {
								$result[$element_id]  = get_option($element_id, $field['default']);
							}				
							break;
						case 'raw':
						case 'separator':
							break;
						default:
							$result[$element_id] = false;
					}
				}
			}
			return $result;
		}

		/**
		 * Generate the output dynamic CSS for the plugin settings
		 *
		 * @since    1.0.0
		 * @return 	<string>		The generated CSS file
		 */
		public function get_output_css() {
			//return '.entry-content { background-color: red !important; }';

			global $accolore_config;
			$css = '';

			$config_sections = $accolore_config[$this->plugin_name]['sections'];
			$config_prefix   = $accolore_config[$this->plugin_name]['prefix'];

			ob_start();

			foreach($config_sections as $section) {
				foreach($section['fields'] as $field) {
					$element_id = $config_prefix . '_' . str_replace("-", "_", $field['id']);
					switch($field['type'] ) {
						case 'link_color':
							foreach ($field['selector'] as $selector_key => $selector_value) {
								if ($selector_value) {
									$element_value =  get_option($element_id . '_' . $selector_key, $field['default'][$selector_key]);
									switch($selector_key) {
										case 'hover':
										case 'active':
										case 'visited':
											$suffix = ':' . $selector_key;	
											break;
										case 'regular':
										default:
											$suffix = '';	
									}
									if (isset($field['output'])) {
										foreach($field['output'] as $output) {
											echo $output . $suffix . ' { color: ' . $element_value . '} ';
										}
									}
								}
							}
							break;
						case 'typography':
							$family = get_option($element_id . '_family', $field['default']['family']);
							$color  = get_option($element_id . '_color', $field['default']['color']);
							$size   = get_option($element_id . '_size', $field['default']['size']);
							$weight = get_option($element_id. '_weight', $field['default']['weight']);
							if (isset($field['output'])) {
								foreach($field['output'] as $output) {
									echo $output . ' { font-family: ' . $family . '; font-size: ' . $size . '; font-weight: ' . $weight . '; color: ' . $color . '; } ';
								}
							}
							break;
						case 'color':
						case 'color_palette':
							$element_value  = get_option($element_id, $field['default']);
							if (isset($field['output'])) {
								foreach($field['output'] as $key => $value) {
									echo $value . ' { ' . $key . ' : ' . $element_value . '; } ';
								}
							}
							break;
						case 'background_color':
							$element_value  = get_option($element_id, $field['default']);
							if (isset($field['output'])) {
								foreach($field['output'] as $output) {
									echo $output . ' { background-color: ' . $element_value . '; } ';
								}
							}
							break;
						case 'spacing':
							$top    = get_option($element_id . '_top', $field['default']['top']);
							$right  = get_option($element_id . '_right', $field['default']['right']);
							$bottom = get_option($element_id . '_bottom', $field['default']['bottom']);
							$left   = get_option($element_id . '_left', $field['default']['left']);
							if (isset($field['output'])) {
								foreach($field['output'] as $output) {
									echo $output . ' { ' . $field['subtype'] . ': ' . $top . 'px ' . $right . 'px ' . $bottom . 'px ' . $left . 'px; } ';
								}
							}
							break;
						case 'border':
							$top    = get_option($element_id . '_top', $field['default']['top']);
							$right  = get_option($element_id . '_right', $field['default']['right']);
							$bottom = get_option($element_id . '_bottom', $field['default']['bottom']);
							$left   = get_option($element_id . '_left', $field['default']['left']);
							$style  = get_option($element_id . '_style', $field['default']['style']);
							$color  = get_option($element_id . '_color', $field['default']['color']);
							if (isset($field['output'])) {
								foreach($field['output'] as $output) {
									echo $output . ' { border-width: ' . $top . 'px ' . $type . ' ' . $coo . 'px ' . $left . 'px; } ';
									echo $output . ' { border-color: ' . $color . '; } ';
									echo $output . ' { border-style: ' . $style . '; } ';
								}
							}
							break;							
						case 'size':
							$width  = get_option($element_id . '_width', $field['default']['width']);
							$height = get_option($element_id . '_height', $field['default']['height']);
							$unit   = get_option($element_id . '_unit', $field['default']['unit']);
							if (isset($field['output'])) {
								foreach($field['output'] as $output) {
									echo $output . ' { width: ' . $width . $unit . '; height: ' . $height . $unit . '; } ';
								}
							}
							break;							
						default:
							break;
					}
				}
			}

			$css = ob_get_clean();
			return $css;
		}

		/**
		 * Return an array of Matarial Design colors for the color_palette field type.
		 *
		 * @since    1.0.0
		 * @param 	$type 		<mixed>		If false return all the Material Design colors. Can be a string or an array with multiple values.
		 * The available values are: 'primary','all','black','white','red','pink','purple','deep_purple','indigo','blue','light_blue','cyan',
		 * 'teal','green','light_green','lime','yellow','amber','orange','deep_orange','brown','gray','blue_gray'
		 * @return 				<array>		An array that contain the values of the chosen Material Desgin colors
		 */
		public function _get_settings_values( $type = false ) {
			require_once 'wp-accolore-material.php';
	
			$type = ($type == false ? 'all' : $type);

			$result = array();
	
			switch($type) {
				case 'all':
					foreach($material_colors as $color => $color_list) {
						if (is_array($color_list)) {
							foreach($color_list as $key => $value) {
								$result[] = $value;
							}
						} elseif (is_string($color_list)) {
							$result[] = $color_list;
						}
					}
					return $result;
					break;
				case 'primary':
					$result[] = $material_colors['black'];
					$result[] = $material_colors['white'];
					foreach(array('red','green','blue') as $id) {
						foreach($material_colors[$id] as $key => $value) {
							$result[] = $value;
						}
					}
					return $result;
					break;
				default:
					foreach($material_colors[$type] as $key => $value) {
						$result[] = $value;
					}
					break;
			}
			return $result;
		}
    }
}