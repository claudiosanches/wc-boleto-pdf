<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC Boleto PDF Integration.
 *
 * @package  WC_Boleto_PDF/Abstracts
 * @category Abstract
 * @author   Claudio Sanches
 */
abstract class WC_Boleto_PDF_Integration {

	/**
	 * Integration ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * API URL.
	 *
	 * @var int
	 */
	protected $api_url = '';

	/**
	 * Get PDF URL.
	 *
	 * @param  string $boleto_url
	 * @param  array  $settings
	 *
	 * @return string
	 */
	public function get_pdf_url( $boleto_url, $settings = array() ) {
		return '';
	}
}
