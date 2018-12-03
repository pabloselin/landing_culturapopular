(function($) {
	"use strict";

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
		var lang = $("html").attr("lang");
		console.log(lang);
		var form = $("#landing-submit");
		var submit = $("button#landing-send", form);
		var message = $(".message-section");
		form.on("submit", function(event) {
			event.preventDefault();
			var ejes = []
			var eje = $('select[name="eje[]"] option:selected', this).map(function(i, el) {
				ejes.push($(el).val());
			});

			console.log(ejes);

			var data = {
				action: "ajax_submit_form",
				nombre: $('input[name="nombre"]', this).val(),
				email: $('input[name="email"]', this).val(),
				institucion: $('input[name="institucion"]', this).val(),
				pais: $('select[name="pais"] option:selected', this).val(),
				tipo_propuesta: $('select[name="tipo_propuesta"] option:selected', this).val(),
				eje: ejes,
				titulo_ponencia: $('input[name="titulo_ponencia"]', this).val(),
				resumen: $('textarea[name="resumen"]', this).val(),
				lang: $('input[name="lang"]', this).val(),
				nonce: $('input[name="_landingnonce"]', this).val()
			};
			$.post(landing.ajaxurl, data, function(response) {
				form.fadeOut("slow");
				if (response.data.error === true) {
					message.append(
						'<div class="alert alert-danger">' +
							response.data.message +
							"</div>"
					);
				} else if (response.data.error === false) {
					message.append(
						'<div class="alert alert-success">' +
							response.data.message +
							"</div>"
					);
				}
			});
		});

		$.getJSON(landing.countries, function(data) {
			var options = [];
			var isolang = lang === "es" ? "spa" : "por";
			console.log(isolang);
			$.each(data, function(key, val) {
				options.push(
					'<option value="' +
						val.translations.spa.common +
						'">' +
						val.translations[isolang].common +
						"</option>"
				);
			});
			$("#pais option[value='0']", form).text("Seleccione un país");
			$("#pais", form).append(options);

			$("#resumen").on("keyup", function() {
				var words = this.value.match(/\S+/g).length;
				var max = 300;
				if (words > max) {
					// Split the string on first max words and rejoin on spaces
					var trimmed = $(this)
						.val()
						.split(/\s+/, max)
						.join(" ");
					// Add a space at the end to make sure more typing creates new words
					$(this).val(trimmed + " ");
				} else {
					//$("#display_count").text(words);					
					if(words !== null) {
						var rest = max - words;
						$("#resto .rest", form).text('/ Quedan ' + rest + ' palabras.');
					}
					
				}
			});
		});
	});
})(jQuery);
