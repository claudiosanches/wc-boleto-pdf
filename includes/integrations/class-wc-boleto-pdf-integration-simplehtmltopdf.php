<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC Boleto PDF Integration simplehtmltopdf.
 *
 * @package  WC_Boleto_PDF/Simplehtmltopdf
 * @category Abstract
 * @author   Claudio Sanches
 */
class WC_Boleto_PDF_Integration_Simplehtmltopdf extends WC_Boleto_PDF_Integration {

	/**
	 * Integration ID.
	 *
	 * @var string
	 */
	public $id = 'simplehtmltopdf';

	/**
	 * API URL.
	 *
	 * @var int
	 */
	protected $api_url = 'http://api.simplehtmltopdf.com/';

	/**
	 * Get PDF URL.
	 *
	 * @return string
	 */
	public function get_pdf_url() {
		$data = array(
			'link'     => $this->boleto_url,
			'orientation' => 'Portrait',
			'language'    => 'pt_BR',
			'mtop'        => '10',
			'mright'      => '10',
			'mleft'       => '10',
			'mbot'        => '10'
		);
		$params = array(
			'timeout' => 60,
			'headers' => array(
				'content-type' => 'application/x-www-form-urlencoded'
			)
		);
		$response = wp_remote_get( $this->api_url . '?' . http_build_query( $data ), $params );

		if ( ! is_wp_error( $response ) && 200 === $response['response']['code'] ) {
			$this->logger( 'PDF generated successfully!' );
			return $response['body'];
		}

		$this->logger( 'Error while generating PDF: ' . print_r( $response, true ) );

		return '';
	}
}
