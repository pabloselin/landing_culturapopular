(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(function() {
	 	var form = $('#landing-submit');
	 	var submit = $('button#landing-send', form);
	 	var message = $('.message-section');
	 	form.on('submit', function(event) {
	 		event.preventDefault();
	 		var data = {
	 			action: 'ajax_submit_form',
	 			email: $('input[name="email"]', this).val(),
	 			nombre: $('input[name="nombre"]', this).val(),
	 			abstract: $('textarea[name="abstract"]', this).val(),
	 			lang: $('input[name="lang"]', this).val(),
	 			nonce: $('input[name="_landingnonce"]', this).val()
	 		}
	 		$.post(landing.ajaxurl, data, function(response) {
	 			form.fadeOut('slow');
	 			if(response.data.error === true) {
	 				message.append('<div class="alert alert-danger">' + response.data.message + '</div>')
	 			} else if(response.data.error === false) {
	 				message.append('<div class="alert alert-success">' + response.data.message + '</div>');
	 			}
	 			
	 		});
	 	})
	 });

})( jQuery );
