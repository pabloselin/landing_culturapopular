<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://apie.cl
 * @since      1.0.0
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/public/partials
 */
?>
<!doctype html>
<?php 
global $wp_query;
$lang = isset($wp_query->query_vars['lang']) ? $wp_query->query_vars['lang'] : 'es';
$userlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$contents = get_option( 'cp_page_options' );
$secciones = $contents['order_sections_landing'];
$fondoheader = $contents['cpl_header'];
?>
<html lang="<?php echo $lang;?>" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<?php wp_head();?>
</head>
<body>
	<?php include( plugin_dir_path( __FILE__ ) . 'navbar.php');?>
	<section class="header">
		<div class="jumbotron landing-presentation" style="background-image: url(<?php echo $fondoheader;?>);">
			<div class="overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-3 logo-landing">
							<img class="d-none d-sm-block" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/logo_cp_naranjo.svg';?>" alt="<?php bloginfo('name');?>">
							<img class="d-block d-sm-none" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/logo_cp_naranjo_movil.svg';?>" alt="<?php bloginfo('name');?>">
						</div>
						<div class="col-md-9">
							<h1 class="display-4"><?php echo $contents['cpl_title_' . $lang];?></h1>
							<p class="lead"><?php echo $contents['cpl_date_' . $lang];?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if($secciones):
		foreach($secciones as $seccion):
			$item = get_post($seccion);
			$content = get_post_meta($item->ID, 'cp_content_' . $lang, true );
			$title = ($lang == 'es')? $item->post_title : get_post_meta($item->ID, 'cp_title_' . $lang, true);

			include( plugin_dir_path( __FILE__ ) . 'section-landing.php');

		endforeach;endif;

		wp_footer();?>
	</body>
	</html>
