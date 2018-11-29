<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://apie.cl
 * @since      1.0.0
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Landing_culturapopular
 * @subpackage Landing_culturapopular/public
 * @author     Pablo Selín Carrasco Armijo <pablo@apie.cl>
 */
class Landing_culturapopular_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		if(get_post_type() == 'landing') {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/landing_culturapopular-public.css', array(), $this->version, 'all' );
		}

	}

	public function dequeue_styles() {
		global $post;
		if( is_singular('landing') || is_post_type_archive( 'landing' ) == true ) {
			wp_dequeue_style( 'twentyseventeen-fonts' );
			wp_dequeue_style( 'twentyseventeen-style' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		if(get_post_type() == 'landing' || is_post_type_archive( 'landing' ) == true) {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/landing-culturapopular.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( 'landing_culturapopular', 'landing', array('ajaxurl' => admin_url( 'admin-ajax.php' )) );

		}

	}

	public function dequeue_scripts() {
		global $post;
		if( is_singular('landing') || is_post_type_archive( 'landing') == true ) {
			wp_dequeue_script( 'jquery.bootstrap.min' );
		}
	}

	public function replace_single_template( $single_template ) {
		/* Reemplaza todos los singles relacionados con el evento */
		if( get_post_type() == 'landing' || is_post_type_archive( 'landing' ) == true ) {
			
			$single_template = plugin_dir_path( __FILE__ ) . 'partials/landing_culturapopular-public-display.php';
			
		}

		return $single_template;
	}

	public static function ajax_submit_form() {
		$data = $_POST;
		$sanedata = array();
		$response = array(
			'error' => false
		);

		if(check_ajax_referer( 'ajax_submit_form', 'nonce', false ) == false) {
			wp_send_json_error( );
		}

		$sanedata['email'] = sanitize_email( $data['email'] );
		$sanedata['nombre'] = sanitize_text_field( $data['nombre'] );
		$sanedata['abstract'] = sanitize_text_field( $data['abstract'] );
		
		$putdata = Landing_culturapopular_Public::put_data($sanedata);

		if($putdata) {
			$sendmail = Landing_culturapopular_Public::send_confirmation($putdata);
			
			if($sendmail) {
				$response['error'] = false;
				$response['success'] = 'Gracias!';
			} else {
				$response['error'] = 'Error enviando mail';
			}
		} else {
			return $response['error'] = 'Error almacenando la respuesta';
		}

		wp_send_json_success( $response );
	}

	public static function put_data($data) {
		global $wpdb;
		$tbname = $wpdb->prefix . LANDING_TABLENAME;
		$timestamp = current_time('mysql');
		$insert = $wpdb->insert($tbname, array(
									'time' => $timestamp,
									'data'	=> serialize($data),
									'confirmed' => false
								));

		$insertid = $wpdb->insert_id;

		$data['id'] = $insertid;
		$data['timestamp'] = $timestamp;

		if($insertid) {
			return $data;
		} else {
			return false;
		}
	}

	public static function send_confirmation($msgid) {
		return true;
	}

	public function lang_rewrite_tag() {
		add_rewrite_tag('%lang%', '([^&]+)');
	}

	public function lang_rewrite_rule() {
		 add_rewrite_rule('^conferencia-internacional-culturas-populares-latinoamericanas/([^/]*)/?','index.php?post_type=landing&lang=$matches[1]','top');
	}
}
