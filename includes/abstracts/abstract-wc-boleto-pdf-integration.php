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
	 * Boleto URL
	 *
	 * @var string
	 */
	protected $boleto_url = '';

	/**
	 * Settings.
	 *
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Debug.
	 *
	 * @var string
	 */
	private $_debug = '';

	/**
	 * Logger.
	 *
	 * @var WC_Logger
	 */
	private $_log = '';

	/**
	 * Initialize integration.
	 */
	public function __construct( $boleto_url, $settings = array() ) {
		$this->boleto_url = $boleto_url;
		$this->settings   = $settings;
		$this->_debug     = isset( $this->settings['debug'] ) && 'yes' === $this->settings['debug'];

		if ( $this->_debug ) {
			$this->_log = new WC_Logger();
		}
	}

	/**
	 * Register logs.
	 *
	 * @param string $message
	 */
	protected function logger( $message ) {
		if ( $this->_debug ) {
			$this->_log->add( 'boleto_pdf', strtoupper( $this->id ) . ': ' . $message );
		}
	}

	/**
	 * Get PDF URL.
	 *
	 * @param  string $boleto_url
	 * @param  array  $settings
	 *
	 * @return string
	 */
	public function get_pdf_url() {
		return '';
	}
}
