<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC Boleto PDF Admin.
 *
 * @package  WC_Boleto_PDF/Admin
 * @category Abstract
 * @author   Claudio Sanches
 */
class WC_Boleto_PDF_Admin extends WC_Settings_API {

	/**
	 * Initialize admin actions.
	 */
	public function __construct() {
		$this->id = 'boleto_pdf';

		$this->init_form_fields();

		add_action( 'woocommerce_boleto_admin_settings', array( $this, 'admin_settings' ) );
		add_action( 'woocommerce_update_options_payment_gateways_boleto', array( $this, 'process_admin_options' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Initiaize form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'settings' => array(
				'title'       => __( 'PDF Settings', 'wc-boleto-pdf' ),
				'type'        => 'title',
				'description' => ''
			),
			'api' => array(
				'title'       => __( 'Integration API', 'wc-boleto-pdf' ),
				'type'        => 'select',
				'desc_tip'    => true,
				'description' => __( 'Choose the integration that will generate the PDFs files.', 'wc-boleto-pdf' ),
				'class'       => 'wc-enhanced-select',
				'default'     => 'freehtmltopdf',
				'options'     => array(
					'freehtmltopdf'   => 'Free Convert HTML to PDF - freehtmltopdf.com',
					'html2pdfrocket'  => 'HTML 2 PDF Rocket - html2pdfrocket.com',
					'simplehtmltopdf' => 'Convert HTML to PDF online - simplehtmltopdf.com',
				),
			),
			'api_key' => array(
				'title'       => __( 'API Key', 'wc-boleto-pdf' ),
				'type'        => 'text',
				'desc_tip'    => true,
				'description' => __( 'Please enter your Integration API Key', 'wc-boleto-pdf' ),
				'default'     => ''
			),
			'debug' => array(
				'title'       => __( 'Debug Log', 'wc-boleto-pdf' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable logging', 'wc-boleto-pdf' ),
				'default'     => 'no',
				'description' => sprintf( __( 'Log events, such as API requests, inside %s', 'wc-boleto-pdf' ), '<a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs&log_file=' . esc_attr( $this->id ) . '-' . sanitize_file_name( wp_hash( $this->id ) ) . '.log' ) ) . '">' . __( 'System Status &gt; Logs', 'wc-boleto-pdf' ) . '</a>' )
			)
		);
	}

	/**
	 * Settings.
	 */
	public function admin_settings() {
		echo '<table class="form-table">';
		$this->generate_settings_html();
		echo '</table>';
	}

	/**
	 * Admin scripts.
	 *
	 * @param string $hook Page slug.
	 */
	public function scripts( $hook ) {
		if ( 'woocommerce_page_wc-settings' === $hook && ( isset( $_GET['section'] ) && 'wc_boleto_gateway' == strtolower( $_GET['section'] ) ) ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_script( 'wc-boleto-pdf-admin', plugins_url( 'assets/js/admin' . $suffix . '.js', plugin_dir_path( dirname( __FILE__ ) ) ), array( 'jquery' ), WC_Boleto_PDF::VERSION, true );
		}
	}
}

new WC_Boleto_PDF_Admin();
