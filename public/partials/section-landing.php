<?php $tipo = get_post_meta($item->ID, 'cp_content_type', true) ? get_post_meta($item->ID, 'cp_content_type', true) : 'sub';?>

<section class="section-landing <?php echo $tipo;?>" id="<?php echo $item->post_name;?>" style="background-color:<?php echo get_post_meta($item->ID, 'cp_content_bgcolor', true);?>" >
		<div class="container">
			<div class="row justify-content-center">
			<div class="col">
				<h2 class="section-landing-title <?php echo $tipo;?>"><?php echo $title;?></h2>
				<div class="the-content-section">
				<?php echo Landing_culturapopular_Public::readmore(apply_filters('the_content', $content), $item->ID);?>
				<?php //echo apply_filters( 'the_content', $content );?>
				</div>

				<?php $component = get_post_meta($item->ID, 'cp_content_function', true);

					if(isset($component)) {
						if(file_exists( plugin_dir_path( __FILE__ ) . 'component-' . $component . '.php')) {
							include( plugin_dir_path( __FILE__) . 'component-' . $component . '.php');
						}	
					}
				?>
			</div>
			</div>
		</div>
	</section>