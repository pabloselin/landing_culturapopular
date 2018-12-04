		<div class="container component-formulario">
			<div class="row justify-content-center">
				<div class="col-sm col-md-8">
					<div class="wrap">
						<form id="landing-submit" action="<?php echo get_permalink();?>" method="POST">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input name="nombre" id="nombre type="text" class="form-control" placeholder="Escribe tu nombre">
							</div>
							<div class="form-group">
								<label for="email">Dirección de E-mail</label>
								<input name="email" id="email" type="email" class="form-control" placeholder="Escribe tu email">
							</div>
							<div class="form-group">
								<label for="institucion">Institución u organización</label>
								<input name="institucion" id="institucion" type="text" class="form-control">
							</div>
							<div class="form-group">
								<label for="pais">País</label>
								<select class="form-control" name="pais" id="pais">
									<option value="0">Cargando países ...</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tipo_propuesta">Tipo de propuesta</label>
								<select class="form-control" id="tipo_propuesta" name="tipo_propuesta">
									<option value="0">Escoja un tipo de propuesta</option>
									<option value="ponencias">Ponencias</option>
									<option value="intervenciones">Intervenciones</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tipo_propuesta">Eje temático</label>
								<select multiple class="form-control" id="eje" name="eje[]">
									<option value="0">Escoja un eje temático</option>
									<?php if(isset($contents['cpl_ejes_' . $lang])) {
										foreach($contents['cpl_ejes_' . $lang] as $eje) {
											echo "<option value='$eje'>$eje</option>";
										}
									};?>
								</select>
								<small class="form-text text-muted">Puede seleccionar más de uno dejando presionada la tecla &lt;Ctrl&gt; o &#8984; en macOS</small>
							</div>
							<div class="form-group">
								<label for="titulo_ponencia">Título de la ponencia o intervención</label>
								<input name="titulo_ponencia" id="titulo_ponencia" type="text" class="form-control">
							</div>
							<div class="form-group">
								<label for="resumen">Resumen / Descripción de la actividad</label>
								<textarea class="form-control" name="resumen" id="resumen" cols="30" rows="20"></textarea>
								<small id="resto" class="form-text text-muted">Máximo 300 palabras <span class="rest"></span></small>
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
		</div>