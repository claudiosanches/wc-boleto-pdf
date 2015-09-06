<?php
/**
 * Plugin Name: WooCommerce Boleto PDF
 * Plugin URI: https://claudiosmweb.com
 * Description: Gerenrate PDF files for WooCommerce Boleto
 * Author: Claudio Sanches
 * Author URI: https://claudiosmweb.com
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: woocommerce-boleto-pdf
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
		// Checks with WooCommerce Boleto is installed.
		if ( class_exists( 'WC_Boleto' ) ) {
			add_filter( 'woocommerce_boleto_url', array( $this, 'use_pdf' ) );
			add_action( 'template_redirect', array( $this, 'template_redirect' ), 9999 );
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
	 * Generate PDF with http://freehtmltopdf.com API
	 */
	public function generate_pdf() {
		global $wp_query;

		$boleto_code = $wp_query->query_vars['boleto'];
		$ref = sanitize_title( $boleto_code );
		$order_id = wc_get_order_id_by_order_key( $ref );

		if ( isset( $_GET['pdf'] ) && 'true' === $_GET['pdf'] ) {
			$boleto_url = remove_query_arg( 'pdf', WC_Boleto::get_boleto_url( $boleto_code ) );
			$data = array(
				'convert'     => $boleto_url,
				'language'    => 'pt_BR',
				'orientation' => 'portrait',
				'size'        => 'A4'
			);
			$params = array(
				'body'    => http_build_query( $data ),
				'headers' => array(
					'content-type' => 'application/x-www-form-urlencoded'
				)
			);
			$response = wp_remote_get( 'http://freehtmltopdf.com', $params );

			// Redirect just if is converted successfully!
			if ( 'Converting to PDF failed' !== substr( $response['body'], 0, 24 ) ) {
				// $filename = sanitize_title_with_dashes( get_bloginfo( 'name' ) . '-boleto-pedido-n' . $order_id ) . '.pdf';
				header( 'Content-type: application/pdf' );
				// header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
				echo $response['body'];
			} else {
				wp_redirect( $boleto_url );
			}

			exit;
		}
	}
}

/**
 * Initialize the plugin.
 */
add_action( 'plugins_loaded', array( 'WC_Boleto_PDF', 'get_instance' ) );

endif;
