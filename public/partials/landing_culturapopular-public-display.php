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
<html>
<head>
	<?php wp_head();?>
</head>
<body>
	<!-- This file should primarily consist of HTML with a little bit of PHP. -->
	<section class="header">
		<div class="jumbotron">
			<h1 class="display-4">Conferencia Cultura Popular</h1>
			<p class="lead">20 al 30 de Septiembre de 2019</p>
			<a href="#formulario" class="btn btn-primary btn-lg">Participa</a>
		</div>
	</section>

	<?php include( plugin_dir_path( __FILE__ ) . 'section-formulario.php');?>
	
	<?php wp_footer();?>
</body>
</html>