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
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo plugin_dir_url( __FILE__ );?>../images/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="<?php echo plugin_dir_url( __FILE__ );?>../images/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="<?php echo plugin_dir_url( __FILE__ );?>../images/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="<?php echo plugin_dir_url( __FILE__ );?>../images/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?php echo plugin_dir_url( __FILE__ );?>../images/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo plugin_dir_url( __FILE__ );?>../images/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="&nbsp;"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?php echo plugin_dir_url( __FILE__ );?>../images/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="<?php echo plugin_dir_url( __FILE__ );?>../images/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="<?php echo plugin_dir_url( __FILE__ );?>../images/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="<?php echo plugin_dir_url( __FILE__ );?>../images/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="<?php echo plugin_dir_url( __FILE__ );?>../images/mstile-310x310.png" />

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
							<img class="animated fadeInLeft d-none d-sm-block" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/logo_cp_naranjo.svg';?>" alt="<?php bloginfo('name');?>">
							<img class="d-block d-sm-none animated fadeInTop" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/logo_cp_naranjo_movil.svg';?>" alt="<?php bloginfo('name');?>">
						</div>
						<div class="col-md-9">
							<h1 class="display-4 animated fadeInRight"><?php echo $contents['cpl_title_' . $lang];?></h1>
							<h2 class="animated fadeInBottom"><?php echo $contents['cpl_subtitle_' . $lang];?></h2>
							<p class="lead animated fadeInBottom"><?php echo $contents['cpl_date_' . $lang];?></p>
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
