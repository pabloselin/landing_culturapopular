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
		$args = array(
			'label'                 => __( 'Landing', 'landing_cp' ),
			'description'           => __( 'Contenidos Landing', 'landing_cp' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'evento',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
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
		'name'    => esc_html__( 'Correos que reciben el formulario', 'cmb2' ),
		'desc'    => esc_html__( 'Lista de correos, separados por coma y espacio.', 'cmb2' ),
		'id'      => 'cpl_correos',
		'type'    => 'text',
	) );

	$cmb->add_field( array(
		'name'    => esc_html__( 'Imagen de cabecera', 'cmb2' ),
		'desc'    => esc_html__( 'Imagen para usar en cabecera, formato apaisado, PNG o JPG.', 'cmb2' ),
		'id'      => 'cpl_header',
		'type'    => 'file',
	) );

}

}
