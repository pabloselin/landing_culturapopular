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
							<textarea name="abstract" id="abstract" cols="30" rows="10"></textarea>
						</div>
						<button name="landing-send" id="landing-send" type="submit" class="btn btn-primary">Enviar</button>
					</form>
				</div>
			</div>
		</div>
	</section>