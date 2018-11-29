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
$contents = get_option( 'cp_page_options' );
$secciones = $contents['order_sections_landing'];
?>
<html lang="<?php echo $lang;?>" >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head();?>
</head>
<body>
	<?php include( plugin_dir_path( __FILE__ ) . 'navbar.php');?>
	<section class="header">
		<div class="jumbotron">
			<h1 class="display-4"><?php echo $contents['cpl_title_' . $lang];?></h1>
			<p class="lead"><?php echo $contents['cpl_date_' . $lang];?></p>
			<a href="#formulario" class="btn btn-primary btn-lg"><?php echo $contents['cpl_action_' . $lang];?></a>
		</div>
	</section>

	<?php if($secciones):
		foreach($secciones as $seccion):
				$item = get_post($seccion);
				$content = get_post_meta($item->ID, 'cp_content_' . $lang, true );
				$title = ($lang == 'es')? $item->post_title : get_post_meta($item->ID, 'cp_title_' . $lang, true);
			?>

	<section id="<?php echo $item->post_name;?>">
		<div class="container">
			<div class="col">
				<h2><?php echo $title;?></h2>
				<?php echo apply_filters( 'the_content', $content );?>
			</div>
		</div>
	</section>

	<?php endforeach;endif;?>


	<?php include( plugin_dir_path( __FILE__ ) . 'section-formulario.php');?>
	
	<?php wp_footer();?>
</body>
</html>
