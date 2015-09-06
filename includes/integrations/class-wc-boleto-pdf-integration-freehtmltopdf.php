<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC Boleto PDF Integration freehtmltopdf.
 *
 * @package  WC_Boleto_PDF/Freehtmltopdf
 * @category Abstract
 * @author   Claudio Sanches
 */
class WC_Boleto_PDF_Integration_Freehtmltopdf extends WC_Boleto_PDF_Integration {

	/**
	 * Integration ID.
	 *
	 * @var string
	 */
	public $id = 'freehtmltopdf';

	/**
	 * API URL.
	 *
	 * @var int
	 */
	protected $api_url = 'http://freehtmltopdf.com';

	/**
	 * Get PDF URL.
	 *
	 * @return string
	 */
	public function get_pdf_url() {
		$data = array(
			'convert'     => $this->boleto_url,
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
		$response = wp_remote_get( $this->api_url, $params );

		if (
			! is_wp_error( $response )
			&& 200 === $response['response']['code']
			&& 'Converting to PDF failed' !== substr( $response['body'], 0, 24 )
		) {
			$this->logger( 'PDF generated successfully!' );
			return $response['body'];
		}

		$this->logger( 'Error while generating PDF: ' . print_r( $response, true ) );

		return '';
	}
}
