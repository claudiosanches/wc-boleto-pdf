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
				'title'       => __( 'API Integration', 'woocommerce-boleto' ),
				'type'        => 'select',
				'desc_tip'    => true,
				'description' => __( 'Choose the integration that will generate the PDFs files.', 'woocommerce-boleto' ),
				'class'       => 'wc-enhanced-select',
				'default'     => 'freehtmltopdf',
				'options'     => array(
					'freehtmltopdf' => 'Free Convert HTML to PDF'
				)
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
}

new WC_Boleto_PDF_Admin();