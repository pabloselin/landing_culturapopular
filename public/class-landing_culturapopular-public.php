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
			wp_localize_script( 'landing_culturapopular', 'landing', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'countries' => plugin_dir_url( __FILE__) . 'data/countries.json',
				'formlabels' => array(
					'pais' 	=> array(
						'es' => 'Seleccione un país',
						'pt' => 'Selecione um país'
					),
					'nombre' => array(
						'es' => 'Nombre',
						'pt' => 'Nome'
					),
					'mail'	 => array(
						'es' => 'Dirección de e-mail',
						'pt' => 'Direção de e-mail'
					),
					'tipo'	 => array(
						'es' => 'Tipo de propuesta',
						'pt' => 'Tipo de proposta'
					),
					'tipo_option_1'	=> array(
						'es' => 'Ponencias',
						'pt' => 'Apresentações'
					),
					'tipo_option_2'	=> array(
						'es' => 'Intervenciones',
						'pt' => 'Intervenções'
					)
				) 
			) 
		);

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
		$sanedata['institucion'] = sanitize_text_field( $data['institucion'] );
		$sanedata['pais'] = sanitize_text_field( $data['pais'] );
		$sanedata['eje'] = sanitize_text_field( implode(', ', $data['eje']) );
		$sanedata['tipo_propuesta'] = sanitize_text_field( $data['tipo_propuesta'] );
		$sanedata['titulo_ponencia'] = sanitize_text_field( $data['titulo_ponencia'] );
		$sanedata['resumen'] = sanitize_text_field( $data['resumen'] );

		$sanedata['language'] = sanitize_text_field( $data['lang'] );
		
		$putdata = Landing_culturapopular_Public::put_data($sanedata);

		if($putdata) {
			$sendmail = Landing_culturapopular_Public::send_confirmation($sanedata);
			$sendadmin = Landing_culturapopular_Public::send_mailadmins($sanedata);
			if($sendmail == true) {
				$response['error'] = false;
				$response['message'] = 'Gracias!';
			} else {
				$response['error'] = true;
				$response['message'] = 'Error enviando mail';
			}
		} else {
			$response['error'] = true;
			$response['error'] = 'Error almacenando su envío';
			return $response;

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

	public static function send_confirmation($data) {
		$lang = $data['language'];
		$options = get_option( 'cp_page_options' );
		$correos = $options['cpl_correos'];
		
		$subject = $options['cpl_subject_' . $lang ];
		$content = $options['cpl_mailcontent_' . $lang ];

		add_filter('wp_mail_content_type', 'Landing_culturapopular_Public::set_html_content_type' );
		$mail = wp_mail( $data['email'], $subject, $content, $headers = '' );
		remove_filter('wp_mail_content_type', 'Landing_culturapopular_Public::set_html_content_type');
		
		return $mail;

	}

	public static function set_html_content_type( $content_type ) {
		return 'text/html';
	}

	public static function send_mailadmins($data) {
		$lang = $data['language'];
		$options = get_option( 'cp_page_options' );
		$correos = $options['cpl_correos'];
		$message = '<div style="font-family: sans-serif;">';
			$message .= '<h1>Recepción de propuesta para Representaciones y proyectos políticos en las culturas populares latinoamericanas hoy</h1>';
			$message .= '<p><strong>Nombre:</strong> ' . $data['nombre'] . '</p>';
			$message .= '<p><strong>Email:</strong> ' . $data['email'] . '</p>';
			$message .= '<p><strong>Institución:</strong> ' . $data['institucion'] . '</p>';
			$message .= '<p><strong>País:</strong>' . $data['pais'] . '</p>';
			$message .= '<p><strong>Tipo de propuesta:</strong> ' . $data['tipo_propuesta'] . '</p>';
			$message .= '<p><strong>Eje(s) temático(s):</strong> ' . $data['eje'] . '</p>';
			$message .= '<p><strong>Título ponencia:</strong> ' . $data['titulo_ponencia'] . '</p>';
			$message .= '<p><strong>Resumen: </strong>' . $data['resumen'] . '</p>';
		$message .= '</div>';
		
		add_filter('wp_mail_content_type', 'Landing_culturapopular_Public::set_html_content_type' );
		$mail = wp_mail( $correos, 'Recepción de formulario', $message, $headers = '' );
		remove_filter('wp_mail_content_type', 'Landing_culturapopular_Public::set_html_content_type');
		
		return $mail;
	}

	public function lang_rewrite_tag() {
		add_rewrite_tag('%lang%', '([^&]+)');
	}

	public function lang_rewrite_rule() {
		add_rewrite_rule('^conferencia-internacional-comunicacion-cultura-popular/([^/]*)/?','index.php?post_type=landing&lang=$matches[1]','top');
	}

	public function landing_title()  {
		global $post, $wp_query;
		
		if(is_post_type_archive( 'landing' ) == true) {
			$lang = isset($wp_query->query_vars['lang']) ? $wp_query->query_vars['lang'] : 'es';
			$options = get_option('cp_page_options');
			$title = $options['cpl_titlehtml_' . $lang];
			return $title;
		}
		
	}
}
