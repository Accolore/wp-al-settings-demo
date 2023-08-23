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
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (! class_exists('WP_Accolore_Settings')){ 
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
										'default' => $field['default']['family'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['color'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_color',
									array(
										'default' => $field['default']['color'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['size'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_size',
									array(
										'default' => $field['default']['size'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['weight'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_weight',
									array(
										'default' => $field['default']['weight'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;
						case 'spacing':
							if ($field['default']['top'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_top',
									array(
										'default' => $field['default']['top'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['right'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_right',
									array(
										'default' => $field['default']['right'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['bottom'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_bottom',
									array(
										'default' => $field['default']['bottom'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							if ($field['default']['left'] !== false) {
								register_setting(
									$config_prefix . '_' . $section['id'] . '_settings',
									$config_prefix . '_' . $field['id'] . '_left',
									array(
										'default' => $field['default']['left'],
										'sanitize_callback' => array($this, 'sanitize_settings'),
									)
								);
							}
							break;
						case 'raw':
							break;
						default:
							register_setting(
								$config_prefix . '_' . $section['id'] . '_settings',
								$config_prefix . '_' . $field['id'],
								array(
									'default' => $field['default'],
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
			$element_id    = $config_prefix . '_' . str_replace("-", "_", $arguments['id']);

			?>
			<div id="<?php echo esc_attr($element_id); ?>-wrapper">
			<?php
			// Element Rendering
			switch ($arguments['type']) {
				case 'reset':
					?>
					<input type="hidden" name="<?php echo esc_attr($arguments['id']) ?>" id="<?php echo esc_attr($arguments['id']) ?>" value="">
					<?php
					break;
				case 'image':
					$element_value = get_option($element_id, $arguments['default']);
					if ($element_value == '') {
						$element_url = $arguments['default'];
					} elseif(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $element_value)) { // check if element_value is an URL
						$element_url = $element_value;
						$element_value = '';
					} else {
						$tmp = wp_get_attachment_image_src( $element_value, 'thumbnail');
						$element_url = $tmp[0];
					}
					wp_enqueue_media();
					?>
					<div class="image-preview-wrapper">
						<img id="<?php echo $element_id; ?>_image_preview" src="<?php echo $element_url; ?>" height="100" style="max-height: 100px;">
					</div>
					<button id="<?php echo $element_id; ?>_upload_image_button" title="<?php _e( 'Upload image', $text_domain ); ?>"><span class="dashicons dashicons-plus-alt"></span></button>
					<button id="<?php echo $element_id; ?>_remove_image_button" title="<?php _e( 'Remove image', $text_domain ); ?>"><span class="dashicons dashicons-trash"></span></button>
					<input type="hidden" name="<?php echo $element_id; ?>" id="<?php echo $element_id; ?>" value="<?php echo $element_value; ?>">
					<script>
						jQuery(document).ready(function() {
							console.log('<?php echo $element_value; ?>');

							var file_frame;
							var wp_media_post_id = wp.media.model.settings.post.id;
							var set_to_post_id = '<?php echo $element_value; ?>';
							var mime_allowed = [<?php echo $arguments['allowed_mime']; ?>];

							jQuery('#<?php echo $element_id; ?>_upload_image_button').on('click', function( event ){
								event.preventDefault();

								if (file_frame) {
									file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
									file_frame.open();
									return;
								} else {
									wp.media.model.settings.post.id = set_to_post_id;
								}

								file_frame = wp.media.frames.file_frame = wp.media({
									title: '<?php echo _e('Select a image to upload', $text_domain); ?>',
									button: {
										text: '<?php echo _e('Use this image', $text_domain); ?>',
									},
									library : {
                                        type: mime_allowed,
                                    },
									multiple: false
								});

								file_frame.on( 'select', function() {
									attachment = file_frame.state().get('selection').first().toJSON();

									jQuery('#<?php echo $element_id; ?>_image_preview').attr('src', attachment.sizes.thumbnail.url).css('width', 'auto');
									jQuery('#<?php echo $element_id; ?>').val(attachment.id);

									wp.media.model.settings.post.id = wp_media_post_id;
								});

								file_frame.open();
							});

							jQuery('#<?php echo $element_id; ?>_remove_image_button').on('click', function( event ) {
								event.preventDefault();

								jQuery('#<?php echo $element_id; ?>_image_preview').attr('src', '<?php echo $arguments['default']; ?>').css('width', 'auto');
								jQuery('#<?php echo $element_id; ?>').val('');

								wp.media.model.settings.post.id = set_to_post_id;
							});

							jQuery('a.add_media').on('click', function() {
								wp.media.model.settings.post.id = wp_media_post_id;
							});
						});
					</script>
					<?php
					break;
				case 'text':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<input type="text" name="<?php echo esc_attr($element_id) ?>" id="<?php echo esc_attr($element_id) ?>" value="<?php echo $element_value; ?>" class="regular-text">
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'textarea':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<textarea name="<?php echo esc_attr($element_id) ?>" id="<?php echo esc_attr($element_id) ?>" class="large-text" rows="5"><?php echo $element_value ?></textarea>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php 
					break;
				case 'raw':
					echo $arguments['content'];
					break;
				case 'select':
					$element_value   = get_option($element_id, $arguments['default']);
					$element_options = $arguments['options'];
					?>
					<select id="<?php echo esc_attr($element_id); ?>" name="<?php echo esc_attr($element_id); ?>">
					<?php foreach($element_options as $key => $value) :?>
						<option value="<?php echo $key ?>" <?php echo ($key == $element_value ? "selected" : "") ?>><?php echo $value; ?></option>
					<?php endforeach; ?>
					</select>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;					
				case 'switch':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<select id="<?php echo esc_attr($element_id); ?>" name="<?php echo esc_attr($element_id); ?>">
						<option value="0" <?php echo ($element_value != 1 ? "selected" : "") ?>><?php echo $arguments['off'] ?></option>
						<option value="1" <?php echo ($element_value == 1 ? "selected" : "") ?>><?php echo $arguments['on'] ?></option>
					</select>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'slider':
					$element_value = get_option($element_id, $arguments['default']);
					?>
					<input type="range" min="<?php echo $arguments['min'] ?>" max="<?php echo $arguments['max'] ?>" step="<?php echo $arguments['step'] ?>" value="<?php echo $element_value ?>" class="slider" id="<?php echo esc_attr($element_id); ?>" name="<?php echo esc_attr($element_id); ?>">
					<span id="<?php echo esc_attr($element_id); ?>-label">ND</span>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<script>
						document.getElementById("<?php echo esc_attr($element_id); ?>").addEventListener('input', function (event) {
							document.getElementById("<?php echo esc_attr($element_id); ?>-label").textContent = event.target.value;
						});
						document.getElementById("<?php echo esc_attr($element_id); ?>-label").textContent = document.getElementById("<?php echo esc_attr($element_id); ?>").value;
					</script>
					<?php				
					break;
				case 'spacing':
					$top    = get_option($element_id . '_top', $arguments['default']['top']);
					$right  = get_option($element_id . '_right', $arguments['default']['right']);
					$bottom = get_option($element_id . '_bottom', $arguments['default']['bottom']);
					$left   = get_option($element_id . '_left', $arguments['default']['left']);
					?>
					<table>
						<tr>
							<td><input type="text" name="<?php echo esc_attr($element_id) ?>_top" id="<?php echo esc_attr($element_id) ?>_top" value="<?php echo $top; ?>" class="small-text" title="<?php _e("Top", $text_domain) ?>" /><span class="dashicons dashicons-arrow-up-alt" title="<?php _e("Top", $text_domain) ?>"></span></td>
							<td><input type="text" name="<?php echo esc_attr($element_id) ?>_right" id="<?php echo esc_attr($element_id) ?>_right" value="<?php echo $right; ?>" class="small-text" title="<?php _e("Right", $text_domain) ?>" /><span class="dashicons dashicons-arrow-right-alt" title="<?php _e("Right", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo esc_attr($element_id) ?>_bottom" id="<?php echo esc_attr($element_id) ?>_bottom" value="<?php echo $bottom; ?>" class="small-text" title="<?php _e("Bottom", $text_domain) ?>" /><span class="dashicons dashicons-arrow-down-alt" title="<?php _e("Bottom", $text_domain) ?>"></span><br/></td>
							<td><input type="text" name="<?php echo esc_attr($element_id) ?>_left" id="<?php echo esc_attr($element_id) ?>_left" value="<?php echo $left; ?>" class="small-text" title="<?php _e("Left", $text_domain) ?>" /><span class="dashicons dashicons-arrow-left-alt" title="<?php _e("Left", $text_domain) ?>"></span></td>
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
							<div class="color-picker-wrapper">
								<label for="<?php echo esc_attr($element_id) . '_' . $selector_key ?>"><?php _e(ucfirst($selector_key), $this->plugin_name)?></label>
								<div id="<?php echo esc_attr($element_id) .'_' . $selector_key . '_picker'; ?>" class="color-picker"></div>
								<input type="hidden" name="<?php echo esc_attr($element_id) . '_' . $selector_key ?>" id="<?php echo esc_attr($element_id) . '_' . $selector_key ?>" value="<?php echo $element_value; ?>">
							</div>
							<script>
								var target_<?php echo esc_attr($element_id) . '_' . $selector_key; ?> = document.querySelector("#<?php echo esc_attr($element_id) . '_' . $selector_key . '_picker'; ?>");
								var input_<?php echo esc_attr($element_id) . '_' . $selector_key; ?> = document.querySelector("#<?php echo esc_attr($element_id) . '_' . $selector_key; ?>");
								var picker_<?php echo esc_attr($element_id) . '_' . $selector_key; ?> = new Picker({
									parent      : target_<?php echo esc_attr($element_id) . '_' . $selector_key; ?>,
									color       : '<?php echo $element_value; ?>',
									alpha       : false,
									editorFormat: 'hex',
									onDone      : function(color) {
										target_<?php echo esc_attr($element_id) . '_' . $selector_key; ?>.style.background = color.hex;
										input_<?php echo esc_attr($element_id) . '_' . $selector_key; ?>.value = color.hex;
									}
								});
								target_<?php echo esc_attr($element_id) . '_' . $selector_key; ?>.style.backgroundColor = "<?php echo $element_value; ?>";
								input_<?php echo esc_attr($element_id) . '_' . $selector_key; ?>.value = "<?php echo $element_value; ?>";
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
					<div id="<?php echo esc_attr($element_id) . '_picker'; ?>" class="color-picker-boxed"></div>
					<input type="hidden" name="<?php echo esc_attr($element_id) ?>" id="<?php echo esc_attr($element_id) ?>" value="<?php echo $element_value ?>">
					<script>
						var target_<?php echo esc_attr($element_id); ?> = document.querySelector("#<?php echo esc_attr($element_id) . '_picker'; ?>");
						var input_<?php echo esc_attr($element_id); ?> = document.querySelector("#<?php echo esc_attr($element_id); ?>");
						var picker_<?php echo esc_attr($element_id); ?> = new Picker({
							parent      : target_<?php echo esc_attr($element_id); ?>,
							color       : "<?php echo $element_value; ?>",
							alpha       : false,
							editorFormat: "hex",
							onDone      : function(color) {
								target_<?php echo esc_attr($element_id); ?>.style.background = color.hex;
								input_<?php echo esc_attr($element_id); ?>.value = color.hex;
							}
						});
						target_<?php echo esc_attr($element_id); ?>.style.backgroundColor = "<?php echo $element_value ?>";
						input_<?php echo esc_attr($element_id); ?>.value = "<?php echo $element_value ?>";
					</script>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'color':
					$element_value = get_option($element_id, $arguments['default']);			
					?>
					<div id="<?php echo esc_attr($element_id) . '_picker'; ?>" class="color-picker-boxed"></div>
					
					<input type="hidden" name="<?php echo esc_attr($element_id) ?>" id="<?php echo esc_attr($element_id) ?>" value="<?php echo $element_value ?>">
					<script>
						var target_<?php echo esc_attr($element_id); ?> = document.querySelector("#<?php echo esc_attr($element_id) . '_picker'; ?>");
						var input_<?php echo esc_attr($element_id); ?> = document.querySelector("#<?php echo esc_attr($element_id); ?>");
						var picker_<?php echo esc_attr($element_id); ?> = new Picker({
							parent      : target_<?php echo esc_attr($element_id); ?>,
							color       : '<?php echo $element_value; ?>',
							editorFormat: 'hex',
							onDone      : function(color) {
								target_<?php echo esc_attr($element_id); ?>.style.background = color.rgbaString;
								input_<?php echo esc_attr($element_id); ?>.value = color.rgbaString;
							},
							<?php echo $arguments['alpha'] ? 'alpha : true' : 'alpha : false';?>,
						});

						target_<?php echo esc_attr($element_id); ?>.style.backgroundColor = "<?php echo $element_value ?>";
						input_<?php echo esc_attr($element_id); ?>.value = "<?php echo $element_value ?>";
					</script>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				case 'typography':
					$element_value_family = get_option($element_id . '_family', $arguments['default']['family']); 
					$picker_uid = uniqid();
					?>
					<?php if ($element_value_family !== false) : ?>
						<div class="font-picker-wrapper">
							<label for="<?php echo esc_attr($element_id) . '_family' ?>"><?php _e('Font family', $this->plugin_name)?></label>
							<div id="font-picker-<?php echo $picker_uid; ?>"></div>
							<input type="hidden" id="<?php echo esc_attr($element_id); ?>_family" name="<?php echo esc_attr($element_id); ?>_family" value="<?php echo $element_value_family ?>">
						</div>
						<script>
							var input_<?php echo esc_attr($element_id); ?>_family = document.querySelector("#<?php echo esc_attr($element_id); ?>_family");

							const fontPicker_<?php echo esc_attr($element_id); ?> = new FontPicker(
								"<?php echo $arguments['google_api_key']; ?>", // Google API key
								"<?php echo $element_value_family; ?>",
								{
									pickerId : "<?php echo $picker_uid; ?>",
									limit : 30,
								},
								function(font) {
									input_<?php echo esc_attr($element_id); ?>_family.value = font.family;
								}
							);
						</script>
					<?php endif; ?>
					<?php $element_value_color  = get_option($element_id . '_color', $arguments['default']['color']); ?>
					<?php if ($element_value_color !== false) : ?>
						<div class="color-picker-wrapper">
							<label for="<?php echo esc_attr($element_id) . '_color' ?>"><?php _e('Color', $this->plugin_name)?></label>
							<div id="<?php echo esc_attr($element_id) . '_picker'; ?>" class="color-picker"></div>
							<input type="hidden" name="<?php echo esc_attr($element_id) ?>_color" id="<?php echo esc_attr($element_id) ?>_color" value="<?php echo $element_value_color ?>">
						</div>
						<script>
							var target_<?php echo esc_attr($element_id); ?>_color = document.querySelector("#<?php echo esc_attr($element_id) . '_picker'; ?>");
							var input_<?php echo esc_attr($element_id); ?>_color = document.querySelector("#<?php echo esc_attr($element_id); ?>_color");
							var picker_<?php echo esc_attr($element_id); ?> = new Picker({
								parent      : target_<?php echo esc_attr($element_id); ?>_color,
								color       : '<?php echo $element_value_color; ?>',
								alpha       : false,
								editorFormat: 'hex',
								onDone      : function(color) {
									target_<?php echo esc_attr($element_id); ?>_color.style.background = color.hex;
									input_<?php echo esc_attr($element_id); ?>_color.value = color.hex;
								}
							});

							target_<?php echo esc_attr($element_id); ?>_color.style.backgroundColor = "<?php echo $element_value_color ?>";
							input_<?php echo esc_attr($element_id); ?>_color.value = "<?php echo $element_value_color ?>";
						</script>
					<?php endif; ?>
					<?php $element_value_size = get_option($element_id . '_size', $arguments['default']['size']); ?>
					<?php if ($element_value_size !== false) : ?>
						<div class="font-picker-wrapper">
							<label for="<?php echo esc_attr($element_id) . '_size' ?>"><?php _e('Size', $this->plugin_name)?></label>
							<input type="text" name="<?php echo esc_attr($element_id) ?>_size" id="<?php echo esc_attr($element_id) ?>_size" value="<?php echo $element_value_size; ?>">
						</div>
					<?php endif; ?>
					<?php $element_value_weight = get_option($element_id . '_weight', $arguments['default']['weight']); ?>
					<?php if ($element_value_weight !== false) : ?>
						<div class="font-picker-wrapper">
							<label for="<?php echo esc_attr($element_id) . '_weight' ?>"><?php _e('Font weight', $this->plugin_name)?></label>
							<select id="<?php echo esc_attr($element_id); ?>_weight" name="<?php echo esc_attr($element_id); ?>_weight">
								<option value="400" <?php echo ($element_value_weight == '400' ? "selected" : "") ?>><?php _e('Regular' , $this->plugin_name) ?></option>
								<option value="700" <?php echo ($element_value_weight == '700' ? "selected" : "") ?>><?php _e('Bold' , $this->plugin_name) ?></option>
							</select>
						</div>
					<?php endif; ?>
					<?php if (isset($arguments['subtitle'])) echo '<p>' . $arguments['subtitle'] . '</p>'; ?>
					<?php if (isset($arguments['desc'])) echo '<p>' . $arguments['desc'] . '</p>'; ?>
					<?php
					break;
				default:
					print_r($arguments);
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
					wrapper.classList.remove('wrapper-hide');
				} else {
					wrapper.classList.add('wrapper-hide');
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
							wrapper.classList.remove('wrapper-hide');
						} else {
							wrapper.classList.add('wrapper-hide');
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
				<h2><?php echo $config_menu['page_title'] ?> Settings <span class="version-label">V<?php echo $config_version; ?></span></h2>
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
		 * Handle settings value sanitization and reset button
		 *
		 * @since    1.0.0
		 * @param   $input		<mixed>		Input value for the setting to sanitize
		 */
		public function sanitize_settings ( $input ) {
			if (isset($_POST['reset'])) {
				$default_values = $this->get_settings_values(false);

				foreach($default_values as $key => $value) {
					delete_option($key);
				}
				return false;
			}
			if (is_string($input)) $input= esc_html($input);
			return $input;
		}

		/**
		 * Return an array of settings values or the defaults setting values
		 *
		 * @since    1.0.0
		 * @param 	$defaults 	boolean		If true, return the settings default values, if false return the saved setting values
		 * @return 				<array>		An array that contain the default values for the settings fields
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
						case 'color':
						case 'background_color':
						case 'switch':
						case 'select':
						case 'slider':
						case 'text':
						case 'textarea':
							if ($defaults) {
								$result[$element_id]  = $field['default'];
							} else {
								$result[$element_id]  = get_option($element_id, $field['default']);
							}				
							break;
						case 'raw':
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
										echo $output . ' { ' . $field['subtype'] . ': ' . $top . 'px ' , $right . 'px ' . $bottom . 'px ' . $left . 'px; } ';
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
    }

}