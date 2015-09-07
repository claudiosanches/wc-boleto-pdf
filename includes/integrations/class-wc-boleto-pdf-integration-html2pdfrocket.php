<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC Boleto PDF Integration html2pdfrocket.
 *
 * @package  WC_Boleto_PDF/Html2pdfrocket
 * @category Abstract
 * @author   Claudio Sanches
 */
class WC_Boleto_PDF_Integration_Html2pdfrocket extends WC_Boleto_PDF_Integration {

	/**
	 * Integration ID.
	 *
	 * @var string
	 */
	public $id = 'html2pdfrocket';

	/**
	 * API URL.
	 *
	 * @var int
	 */
	protected $api_url = 'http://api.html2pdfrocket.com/pdf';

	/**
	 * Get PDF URL.
	 *
	 * @return string
	 */
	public function get_pdf_url() {
		$data = array(
			'apikey'       => $this->settings['api_key'],
			'value'        => $this->boleto_url,
			'pagesize'     => 'A4',
			'outputformat' => 'PDF',
			'marginleft'   => '10',
			'marginright'  => '10',
			'margintop'    => '10',
			'Marginbottom' => '10',
		);
		$params = array(
			'timeout' => 60,
			'headers' => array(
				'content-type' => 'application/x-www-form-urlencoded'
			)
		);
		$response = wp_remote_get( $this->api_url . '?' . http_build_query( $data ), $params );

		if ( ! is_wp_error( $response ) && 200 === $response['response']['code'] && ! empty( $response['body'] ) ) {
			$this->logger( 'PDF generated successfully!' );
			return $response['body'];
		}

		$this->logger( 'Error while generating PDF: ' . print_r( $response, true ) );

		return '';
	}
}
