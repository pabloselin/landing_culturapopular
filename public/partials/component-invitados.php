<div class="container">
	<div class="row justify-content-center">
		<?php 
			$invitados = get_post_meta($item->ID, 'group_fields_invitados', true);
			foreach($invitados as $invitado) {
				?>
					
					<div class="invitado col-md-6">
						<div class="wrap">
							<h3><?php echo $invitado['nombre_invitado'];?></h3>
							<div class="invitado-content">
								<?php echo $invitado['bio_invitado'];?>
							</div>
						</div>
					</div>

				<?php
			}
		?>
	</div>
</div>