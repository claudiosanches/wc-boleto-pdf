<?php
/**
 * Plugin Name: WooCommerce Boleto - PDF Add-on
 * Plugin URI: https://github.com/claudiosmweb/wc-boleto-pdf
 * Description: Generate PDF files for WooCommerce Boleto
 * Author: Claudio Sanches
 * Author URI: https://claudiosmweb.com
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: wc-boleto-pdf
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Boleto_PDF' ) ) :

/**
 * Main class.
 */
class WC_Boleto_PDF {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin actions.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks with WooCommerce Boleto is installed.
		if ( class_exists( 'WooCommerce' ) ) {
			$this->_includes();

			add_action( 'admin_init', array( $this, 'admin_includes' ) );
			add_filter( 'woocommerce_boleto_url', array( $this, 'use_pdf' ) );
			add_action( 'template_redirect', array( $this, 'template_redirect' ), 9999 );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Includes.
	 */
	private function _includes() {
		include_once 'includes/abstracts/abstract-wc-boleto-pdf-integration.php';

		// Include integrations.
		foreach ( glob( realpath( dirname( __FILE__ ) ) . '/includes/integrations/*.php' ) as $filename ) {
			include_once $filename;
		}
	}

	/**
	 * Admin includes.
	 */
	public function admin_includes() {
		include_once 'includes/admin/wc-boleto-pdf-admin.php';
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wc-boleto-pdf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Added pdf param in boleto URL.
	 *
	 * @param  string $url
	 *
	 * @return string
	 */
	public function use_pdf( $url ) {
		return add_query_arg( array( 'pdf' => 'true' ), $url );
	}

	/**
	 * Redirect boleto template for PDF version.
	 */
	public function template_redirect( $template ) {
		global $wp_query;

		if ( isset( $wp_query->query_vars['boleto'] ) && isset( $_GET['pdf'] ) && 'true' === $_GET['pdf'] ) {
			$this->generate_pdf();
		}
	}

	/**
	 * Generate PDF.
	 */
	public function generate_pdf() {
		global $wp_query;

		$boleto_code = $wp_query->query_vars['boleto'];
		$ref = sanitize_title( $boleto_code );
		$order_id = wc_get_order_id_by_order_key( $ref );

		if ( isset( $_GET['pdf'] ) && 'true' === $_GET['pdf'] ) {
			$pdf_url     = '';
			$settings    = $this->get_settings();
			$boleto_url  = remove_query_arg( 'pdf', WC_Boleto::get_boleto_url( $boleto_code ) );
			$integration = 'WC_Boleto_PDF_Integration_' . sanitize_title( $settings['api'] );

			if ( class_exists( $integration ) ) {
				$_integration = new $integration( $boleto_url, $settings );
				$pdf_url      = $_integration->get_pdf_url();
			}

			// Redirect just if is converted successfully!
			if ( ! empty( $pdf_url ) ) {
				// $filename = sanitize_title_with_dashes( get_bloginfo( 'name' ) . '-boleto-pedido-n' . $order_id ) . '.pdf';
				header( 'Content-type: application/pdf' );
				header( 'Cache-Control: no-cache' );
				header( 'Accept-Ranges: none' );
				// header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
				echo $pdf_url;
			} else {
				wp_redirect( $boleto_url );
			}

			exit;
		}
	}

	/**
	 * Get settings.
	 *
	 * @return array
	 */
	protected function get_settings() {
		$settings = get_option( 'woocommerce_boleto_pdf_settings', array() );
		$default  = array(
			'debug'   => 'no',
			'api'     => 'freehtmltopdf',
			'api_key' => '',
		);

		return array_merge( $default, $settings );
	}

	/**
	 * Action links.
	 *
	 * @param  array $links
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$plugin_links = array();

		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=wc_boleto_gateway#woocommerce_boleto_pdf_settings' ) ) . '">' . __( 'Settings', 'wc-boleto-pdf' ) . '</a>';

		return array_merge( $plugin_links, $links );
	}
}

/**
 * Initialize the plugin.
 */
add_action( 'plugins_loaded', array( 'WC_Boleto_PDF', 'get_instance' ) );

endif;
