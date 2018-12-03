<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://apie.cl
 * @since      1.0.0
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/admin
 * @author     Pablo Selín Carrasco Armijo <pablo@apie.cl>
 */
class Landing_culturapopular_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Landing_culturapopular_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Landing_culturapopular_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/landing_culturapopular-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Landing_culturapopular_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Landing_culturapopular_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/landing_culturapopular-admin.js', array( 'jquery' ), $this->version, false );

	}

	public static function get_propuestas() {
		global $wpdb;

		$tbname = $wpdb->prefix . 'landing';

		$consultas = $wpdb->get_results("SELECT * FROM $tbname");
		return $consultas;
	}

	public function consultas_admin() {
		//$this->plugin_screen_hook_suffix = add_options_page( 'Propuestas enviadas', 'Propuestas Enviadas', 'manage_options', $this->plugin_name, array($this, 'fpost_doadminpropuestas'));
		$this->plugin_screen_hoook_suffix = add_submenu_page( 'edit.php?post_type=landing', 'Propuestas Enviadas', 'Propuestas Enviadas', 'manage_options', $this->plugin_name, array($this, 'fpost_doadminpropuestas') );
	}

	public function fpost_doadminpropuestas() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('No tienes permisos suficientes para ver esta página.') );
	}
	global $wpdb;
	//Llamando a los inscritos
	$propuestas = Landing_culturapopular_Admin::get_propuestas();
	?>
	<div class="wrap">
		<h2>propuestas</h2>
		<table class="widefat wp-list-table fspmlist">
			<thead>
				<th>ID</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Nombre</th>
				<th>E-Mail</th>
				<th>Institución</th>
				<th>País</th>
				<th>Tipo propuesta</th>
				<th>Ejes</th>
				<th>Título Propuesta</th>
				<th>Propuesta</th>
				<th>Idioma</th>
			</thead>
		
		<?php
			foreach($propuestas as $key=>$propuesta) {
				$datos = unserialize($propuesta->data);
				?>
				<?php if($key %2 == 0):?>
					<tr class="alternate">
				<?php else:?>
					<tr>
				<?php endif;?>
					<td><?php echo $propuesta->id;?></td>
					<td><?php echo mysql2date( 'l, j \d\e F, Y ', $propuesta->time );?></td>
					<td><?php echo mysql2date( 'H:i,s', $propuesta->time );?></td>
					<td><?php echo $datos['nombre'];?></td>
					<td><?php echo $datos['email'];?></td>
					<td><?php echo $datos['institucion'];?></td>
					<td><?php echo $datos['pais'];?></td>
					<td><?php echo $datos['tipo_propuesta'];?></td>
					<td><?php echo $datos['eje'];?></td>
					<td><?php echo $datos['titulo_ponencia'];?></td>
					<td><?php echo $datos['resumen'];?></td>
					<td><?php echo $datos['language'];?></td>
				</tr>
			<?php }
		?>
		</table>
	</div>
	<?php
}

	public function cmb_show_on_meta_value( $display, $meta_box ) {
		if ( ! isset( $meta_box['show_on']['meta_key'] ) ) {
			return $display;
		}

		$post_id = 0;

	// If we're showing it based on ID, get the current ID
		if ( isset( $_GET['post'] ) ) {
			$post_id = $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		}

		if ( ! $post_id ) {
			return $display;
		}

		$value = get_post_meta( $post_id, $meta_box['show_on']['meta_key'], true );

		if ( empty( $meta_box['show_on']['meta_value'] ) ) {
			return (bool) $value;
		}

		return $value == $meta_box['show_on']['meta_value'];
	}

	// Register Custom Post Type
	public function landingcontent() {

		$labels = array(
			'name'                  => _x( 'Items Landing', 'Post Type General Name', 'landing_cp' ),
			'singular_name'         => _x( 'Landing', 'Post Type Singular Name', 'landing_cp' ),
			'menu_name'             => __( 'Landing', 'landing_cp' ),
			'name_admin_bar'        => __( 'Landing', 'landing_cp' ),
			'archives'              => __( 'Contenidos Landing', 'landing_cp' ),
			'attributes'            => __( 'Item Attributes', 'landing_cp' ),
			'parent_item_colon'     => __( 'Contenido superior', 'landing_cp' ),
			'all_items'             => __( 'Todos los contenidos', 'landing_cp' ),
			'add_new_item'          => __( 'Añadir nuevo contenido', 'landing_cp' ),
			'add_new'               => __( 'Añadir nuevo', 'landing_cp' ),
			'new_item'              => __( 'Nuevo contenido', 'landing_cp' ),
			'edit_item'             => __( 'Editar contenido', 'landing_cp' ),
			'update_item'           => __( 'Actualizar contenido', 'landing_cp' ),
			'view_item'             => __( 'Ver contenido', 'landing_cp' ),
			'view_items'            => __( 'Ver contenidos', 'landing_cp' ),
			'search_items'          => __( 'Buscar contenidos', 'landing_cp' ),
			'not_found'             => __( 'No encontrado', 'landing_cp' ),
			'not_found_in_trash'    => __( 'No encontrado en papelera', 'landing_cp' ),
			'featured_image'        => __( 'Imagen destacada', 'landing_cp' ),
			'set_featured_image'    => __( 'Asignar imagen destacada', 'landing_cp' ),
			'remove_featured_image' => __( 'Quitar imagen destacada', 'landing_cp' ),
			'use_featured_image'    => __( 'Usar como imagen destacada', 'landing_cp' ),
			'insert_into_item'      => __( 'Insertar en contenido', 'landing_cp' ),
			'uploaded_to_this_item' => __( 'Subido a este contenido', 'landing_cp' ),
			'items_list'            => __( 'Lista de contenidos', 'landing_cp' ),
			'items_list_navigation' => __( 'Navegación por lista de items', 'landing_cp' ),
			'filter_items_list'     => __( 'Filtrar lista de items', 'landing_cp' ),
		);

		$rewrite = array(
			'slug' 					=> 'conferencia-internacional-comunicacion-cultura-popular',
			'with_front'			=> true,
			'pages'					=> true,
			'feeds'					=> false
		);
		$args = array(
			'label'                 => __( 'Landing', 'landing_cp' ),
			'description'           => __( 'Contenidos Landing', 'landing_cp' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'custom-fields', 'page-attributes' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'conferencia-internacional-comunicacion-cultura-popular',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'rewrite'				=> $rewrite,
			'show_in_rest'          => true
		);
		register_post_type( 'landing', $args );

	}

/**
 * Hook in and register a submenu options page for the Page post-type menu.
 */
public function cp_register_options_submenu_for_landing_post_type() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb = new_cmb2_box( array(
		'id'           => 'cp_options_submenu_page',
		'title'        => esc_html__( 'Opciones Landing', 'cmb2' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'cp_page_options', // The option key and admin menu page slug.
		// 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		'parent_slug'     => 'edit.php?post_type=landing', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'cp_options_page_message_callback',
	) );

	$cmb->add_field( array(
		'name' => 'Idiomas',
		'type' => 'title',
		'id'   => 'title_checkidiomas'
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Activar cambiador de idiomas', 'cmb2' ),
		'id'      => 'langswitcher',
		'type'    => 'checkbox'
	) );

	$cmb->add_field( array(
		'name' => 'Secciones',
		'desc' => 'Orden de secciones',
		'type' => 'title',
		'id'   => 'title_ordersection'
	) );

	$args = array(
		'post_type' => 'landing',
		'numberposts' => -1,
		'post_status' => 'publish'
	);

	$items = get_posts($args);

	if($items) {
		$items_landing_options = array();
		foreach($items as $item) {
			$items_landing_options[$item->ID] = $item->post_title;
		}

		$cmb->add_field( array(
			'name'    => esc_html__( 'Orden de las secciones', 'cmb2' ),
			'desc'    => esc_html__( 'Arrastrar para reordenar secciones', 'cmb2' ),
			'id'      => 'order_sections_landing',
			'type'    => 'order',
			'options' =>  $items_landing_options
		) );
	}

	$cmb->add_field( array(
		'name'    => esc_html__( 'Textos del formulario Español', 'cmb2' ),
		'desc'    => esc_html__( 'Textos descriptivos de los campos del formulario en Español', 'cmb2' ),
		'id'      => 'title_formtexts_es',
		'type'    => 'title',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'E-mail', 'cmb2' ),
		'id'      => 'cpl_formtext_email_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Nombre', 'cmb2' ),
		'id'      => 'cpl_formtext_nombre_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Abstract', 'cmb2' ),
		'id'      => 'cpl_formtext_abstract_es',
		'type'    => 'text',
	) );



	$cmb->add_field( array(
		'name'    => esc_html__( 'Textos del formulario Portugués', 'cmb2' ),
		'desc'    => esc_html__( 'Textos descriptivos de los campos del formulario en Portugués', 'cmb2' ),
		'id'      => 'title_formtexts_pt',
		'type'    => 'title',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'E-mail', 'cmb2' ),
		'id'      => 'cpl_formtext_email_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Nombre', 'cmb2' ),
		'id'      => 'cpl_formtext_nombre_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Abstract', 'cmb2' ),
		'id'      => 'cpl_formtext_abstract_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Configuración Formulario', 'cmb2' ),
		'desc'    => esc_html__( 'Configuración Formulario', 'cmb2' ),
		'id'      => 'title_form_conf',
		'type'    => 'title',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Correos que reciben el formulario', 'cmb2' ),
		'desc'    => esc_html__( 'Lista de correos, separados por coma y espacio.', 'cmb2' ),
		'id'      => 'cpl_correos',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Asunto del correo en español', 'cmb2' ),
		'id'      => 'cpl_subject_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Asunto del correo en portugués', 'cmb2' ),
		'id'      => 'cpl_subject_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name' => esc_html__('Ejes temáticos en español', 'cmb2'),
		'id'   => 'cpl_ejes_es',
		'type' => 'text',
		'repeatable' => true
	) );

	$cmb->add_field( array(
		'name' => esc_html__('Ejes temáticos en portugués', 'cmb2'),
		'id'   => 'cpl_ejes_pt',
		'type' => 'text',
		'repeatable' => true
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Texto de confirmación de recepción del envío en español', 'cmb2' ),
		'desc'    => esc_html__( 'El contenido del email que confirma la recepción del correo.', 'cmb2' ),
		'id'      => 'cpl_mailcontent_es',
		'type'    => 'wysiwyg',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Texto de confirmación de recepción del envío en portugués', 'cmb2' ),
		'desc'    => esc_html__( 'El contenido del email que confirma la recepción del correo.', 'cmb2' ),
		'id'      => 'cpl_mailcontent_pt',
		'type'    => 'wysiwyg',
	) );


	$cmb->add_field( array(
		'name' => 'Cabecera',
		'desc' => 'Datos de cabecera',
		'type' => 'title',
		'id'   => 'title_header'
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Imagen de cabecera', 'cmb2' ),
		'desc'    => esc_html__( 'Imagen para usar en cabecera, formato apaisado, PNG o JPG.', 'cmb2' ),
		'id'      => 'cpl_header',
		'type'    => 'file',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Título Español', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para el título de cabecera en español.', 'cmb2' ),
		'id'      => 'cpl_title_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Título Portugués', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para el título de cabecera en portugués.', 'cmb2' ),
		'id'      => 'cpl_title_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Fecha Español', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para la fecha del evento en español.', 'cmb2' ),
		'id'      => 'cpl_date_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Fecha Portugués', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para la fecha del evento en portugués.', 'cmb2' ),
		'id'      => 'cpl_date_pt',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name' => 'SEO',
		'desc' => 'Configuraciones de SEO y otros',
		'type' => 'title',
		'id'   => 'title_seo'
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Título Español para el HTML', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para el título de navegador en español.', 'cmb2' ),
		'id'      => 'cpl_titlehtml_es',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Título Portugués para el HTML', 'cmb2' ),
		'desc'    => esc_html__( 'Texto para el título de navegador en portugués.', 'cmb2' ),
		'id'      => 'cpl_titlehtml_pt',
		'type'    => 'text',
	) );
}

public function cp_register_landing_content_fields() {
	$cmb_content = new_cmb2_box( array(
		'id'           => 'cp_fields_landing_content',
		'title'        => esc_html__( 'Contenido', 'cmb2' ),
		'object_types' => array( 'landing' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		//'option_key'      => 'cp_page_options', // The option key and admin menu page slug.
		// 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		//'parent_slug'     => 'edit.php?post_type=landing', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'cp_options_page_message_callback',
	) );

	$cmb_content->add_field( array(
		'name'    => esc_html__( 'Contenido en Español', 'cmb2' ),
		'id'      => 'cp_content_es',
		'type'    => 'wysiwyg',
	) );

	$cmb_content->add_field( array(
		'name'    => esc_html__( 'Título en Portugués', 'cmb2' ),
		'id'      => 'cp_title_pt',
		'type'    => 'text',
	) );

	$cmb_content->add_field( array(
		'name'    => esc_html__( 'Contenido en Portugués', 'cmb2' ),
		'id'      => 'cp_content_pt',
		'type'    => 'wysiwyg',
	) );

	$cmb_content->add_field( array(
		'name' => esc_html__('Color de fondo de sección', 'cmb2'),
		'id'   => 'cp_content_bgcolor',
		'type' => 'colorpicker'
	));

	$cmb_content->add_field( array(
		'name' 	=> esc_html__( 'Funcionalidad adicional', 'cmb2' ),
		'id'  	=> 'cp_content_function',
		'type'	=> 'select',
		'show_option_none' => true,
		'options' => array(
			'invitados' 	=> 'Invitados',
			'documentos' 	=> 'Documentos',
			'formulario' 	=> 'Formulario',
			'avisos'	 	=> 'Avisos',
			'calendario'    => 'Calendario'
		)
	) );
}

public function cp_register_optional_boxes() {
	$optbox = new_cmb2_box( array(
		'id'           => 'cp_fields_landing_extracontent',
		'title'        => esc_html__( 'Información invitados', 'cmb2' ),
		'object_types' => array( 'landing' ),
		'show_on'	   => array( 'meta_key' => 'cp_content_function', 'meta_value' => 'invitados')
		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		//'option_key'      => 'cp_page_options', // The option key and admin menu page slug.
		// 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
		//'parent_slug'     => 'edit.php?post_type=landing', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
		// 'message_cb'      => 'cp_options_page_message_callback',
	) );

	$invitados = $optbox->add_field( array(
		'id'   => 'group_fields_invitados',
		'name' => 'Invitado',
		'type' => 'group',
		'description' => 'Información invitado',
		'options'     => array(
			'group_title'   => __( 'Invitado {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
			'add_button'    => __( 'Añadir otro invitado', 'cmb2' ),
			'remove_button' => __( 'Quitar invitado', 'cmb2' ),
			'sortable'      => true, // beta
	)
	));

	$optbox->add_group_field($invitados, array(
		'name' 	=> 'Nombre invitado',
		'id'	=> 'nombre_invitado',
		'type'  => 'text'
	));

	$optbox->add_group_field($invitados, array(
		'name'  => 'Texto invitado',
		'id'	=> 'bio_invitado',
		'type'	=> 'wysiwyg'
	));

	$optbox->add_group_field($invitados, array(
		'name' => 'Foto invitado',
		'id'   => 'foto_invitado',
		'type' => 'file'
	));
}

}
