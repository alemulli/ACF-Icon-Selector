<?php
/**
 * Defines the custom field type class.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * leadpoint_digital_acf_field_icon_selector class.
 */
class leadpoint_digital_acf_field_icon_selector extends \acf_field {
	/**
	 * Controls field type visibilty in REST requests.
	 *
	 * @var bool
	 */
	public $show_in_rest = true;

	/**
	 * Environment values relating to the theme or plugin.
	 *
	 * @var array $env Plugin or theme context such as 'url' and 'version'.
	 */
	private $env;

	/**
	 * Constructor.
	 */
	public function __construct() {
		/**
		 * Field type reference used in PHP and JS code.
		 *
		 * No spaces. Underscores allowed.
		 */
		$this->name = 'icon_selector';

		/**
		 * Field type label.
		 *
		 * For public-facing UI. May contain spaces.
		 */
		$this->label = __( 'Icon Selector', 'icon-selector' );

		/**
		 * The category the field appears within in the field type picker.
		 */
		$this->category = 'basic'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

		/**
		 * Field type Description.
		 *
		 * For field descriptions. May contain spaces.
		 */
		$this->description = __( 'Allows you to see a preview of SVG Icons to select from', 'icon-selector' );

		/**
		 * Field type Doc URL.
		 *
		 * For linking to a documentation page. Displayed in the field picker modal.
		 */
		$this->doc_url = '';

		/**
		 * Field type Tutorial URL.
		 *
		 * For linking to a tutorial resource. Displayed in the field picker modal.
		 */
		$this->tutorial_url = '';

		/**
		 * Defaults for your custom user-facing settings for this field type.
		 */
		$this->defaults = array(
			'font_size'	=> 14,
		);

		/**
		 * Strings used in JavaScript code.
		 *
		 * Allows JS strings to be translated in PHP and loaded in JS via:
		 *
		 * ```js
		 * const errorMessage = acf._e("icon_selector", "error");
		 * ```
		 */
		$this->l10n = array(
			'error'	=> __( 'Error! Please enter a higher value', 'icon-selector' ),
		);

		$this->env = array(
			'url'     => site_url( str_replace( ABSPATH, '', __DIR__ ) ), // URL to the acf-icon-selector directory.
			'version' => '1.0', // Replace this with your theme or plugin version constant.
		);

		/**
		 * Field type preview image.
		 *
		 * A preview image for the field type in the picker modal.
		 */
		$this->preview_image = $this->env['url'] . '/assets/images/field-preview-custom.png';

		parent::__construct();
	}

	/**
	 * Settings to display when users configure a field of this type.
	 *
	 * These settings appear on the ACF “Edit Field Group” admin page when
	 * setting up the field.
	 *
	 * @param array $field
	 * @return void
	 */
	public function render_field_settings( $field ) {
		/*
		 * Repeat for each setting you wish to display for this field type.
		 */
		acf_render_field_setting(
			$field,
			array(
				'label'			=> __( 'Font Size','icon-selector' ),
				'instructions'	=> __( 'Customise the input font size','icon-selector' ),
				'type'			=> 'number',
				'name'			=> 'font_size',
				'append'		=> 'px',
			)
		);

		// To render field settings on other tabs in ACF 6.0+:
		// https://www.advancedcustomfields.com/resources/adding-custom-settings-fields/#moving-field-setting
	}

	/**
	 * HTML content to show when a publisher edits the field on the edit screen.
	 *
	 * @param array $field The field settings and values.
	 * @return void
	 */
	public function render_field( $field ) {
		// Debug output to show what field data is available.
		echo '<pre>';
		print_r( $field );
		echo '</pre>';

		// Display an input field that uses the 'font_size' setting.
		?>
		<input
			type="text"
			class="setting-font-size"
			name="<?php echo esc_attr($field['name']) ?>"
			value="<?php echo esc_attr($field['value']) ?>"
			style="font-size:<?php echo esc_attr( $field['font_size'] ) ?>px;"
		/>
		<?php
	}

	/**
	 * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
	 *
	 * Callback for admin_enqueue_script.
	 *
	 * @return void
	 */
	public function input_admin_enqueue_scripts() {
		$url     = trailingslashit( $this->env['url'] );
		$version = $this->env['version'];

		wp_register_script(
			'leadpoint_digital-icon-selector',
			"{$url}assets/js/field.js",
			array( 'acf-input' ),
			$version
		);

		wp_register_style(
			'leadpoint_digital-icon-selector',
			"{$url}assets/css/field.css",
			array( 'acf-input' ),
			$version
		);

		wp_enqueue_script( 'leadpoint_digital-icon-selector' );
		wp_enqueue_style( 'leadpoint_digital-icon-selector' );
	}
}
