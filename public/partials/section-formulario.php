<section class="form">
		<div class="container">
			<div class="row">
				<div class="col-sm">
					<form id="landing-submit" action="<?php echo get_permalink();?>" method="POST">
						<div class="form-group">
							<label for="email">Dirección de E-mail</label>
							<input name="email" id="email" type="email" class="form-control" placeholder="Escribe tu email">
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input name="nombre" id="nombre type="text" class="form-control" placeholder="Escribe tu nombre">
						</div>
						<div class="form-group">
							<label for="abstract">Abstract</label>
							<textarea class="form-control" name="abstract" id="abstract" cols="30" rows="10"></textarea>
						</div>
						<input name="lang" id="lang" type="hidden" value=<?php echo $lang;?> >
						<?php wp_nonce_field( 'ajax_submit_form', '_landingnonce', true, true );?>
						<button name="landing-send" id="landing-send" type="submit" class="btn btn-primary">Enviar</button>
					</form>
					<div class="message-section">
						
					</div>
				</div>
			</div>
		</div>
	</section>