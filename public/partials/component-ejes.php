<div class="accordion ejes-tematicos" id="ejesAccordion">
<?php 
$ejes = get_post_meta($item->ID, 'group_fields_ejes', true);

if($ejes) {
	foreach($ejes as $key=>$eje) { ?>

		<div class="card">
			<div class="card-header" id="heading-<?php echo $key;?>">
				
					<h5 class="collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $key;?>" aria-controls="collapse-<?php echo $key;?>">
						<i class="fa fa-plus"></i> <?php echo $eje['titulo_eje_' . $lang];?>
					</h5>
				
			</div>

			<div id="collapse-<?php echo $key;?>" class="collapse" aria-labelledby="heading-<?php echo $key;?>" data-parent="#ejesAccordion">
				<div class="card-body">
					<?php echo apply_filters( 'the_content', $eje['desc_eje_' . $lang] );?>
				</div>
			</div>
		</div>

		<?php
	}
}
?>
</div>