jQuery( document ).ready( function( $ ) {
	$( '#woocommerce_boleto_pdf_api' ).on( 'change', function() {
		var current     = $( this ).val(),
			available   = [ 'html2pdfrocket' ],
			apiKeyField = $( '#woocommerce_boleto_pdf_api_key' ).closest( 'tr' );

		if ( -1 !== $.inArray( current, available ) ) {
			apiKeyField.show();
		} else {
			apiKeyField.hide();
		}

	}).change();
});
