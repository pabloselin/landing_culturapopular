	<?php 
	global $wp_query;
	$lang = isset($wp_query->query_vars['lang']) ? $wp_query->query_vars['lang'] : 'es';
	?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php 
			wp_nav_menu( array(
				'theme_location'  => 'landing_' . $lang,
					'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'bs-example-navbar-collapse-1',
					'menu_class'      => 'navbar-nav mr-auto',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap4_Navwalker(),
				) );
				?>
				<?php if($contents['langswitcher']):?>
					<div class="langswitcher btn-group">
						<?php 
						$url = get_post_type_archive_link( 'landing' );
						$es = $url . 'es/';
						$pt = $url . 'pt/';
						?>
						<a class="btn btn-outline-dark es <?php echo ($lang == 'es' ? 'active': '');?>" href="<?php echo $es;?>" title="Español">ES</a>
						<a class="btn btn-outline-dark pt <?php echo ($lang == 'pt' ? 'active': '');?>" href="<?php echo $pt;?>" title="Portugues">PT</a>
					</div>
				<?php endif;?>
			</div>
		</nav>