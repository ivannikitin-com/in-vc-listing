<?php
/**
 * Карты клиник
 * Class Map
 */
namespace IN_VC_Listring;

class Map
{
	/**
	 * @const SETTINGS Параметры плагина 
	 */
	const SETTINGS = 'in_vc_listing_settings';	

	/**
	 * @const SETTINGS Параметры плагина 
	 */
	const API_KEY = 'google_map_key';
	
	/**
	 * Опции карт
	 */
	private $options;
	
	/**
	 * Конструктор
	 * Инициализация модуля карт
	 */
	public function __construct()
	{		
		
		// Параметры
		$this->options = get_option( self::SETTINGS );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_settings'  ) );
		
		// Метабокс с координатами
		if ( is_admin() ) 
		{
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}		
		
		// Загрузка карт и скриптов
		if ( $this->is_enabled() )
		{
			add_action( 'wp_enqueue_scripts', array( $this, 'loadJS' ) );
			add_filter( 'script_loader_tag', array( $this, 'add_async_defer_attribute' ), 10, 2);
			
			// Подключаем вывод карт к шаблонам
			add_action( 'in_vc_listing_clinic_after_content', array( $this, 'show' ) );
			add_action( 'in_vc_listing_archive_after_main', array( $this, 'show' ) );
			add_action( 'in_vc_listing_tag_after_main', array( $this, 'show' ) );
			add_action( 'in_vc_listing_region_after_main', array( $this, 'show' ) );
			
			// Чтение координат одной точки
			add_action( 'in_vc_listing_clinic_after_content', array( $this, 'set_point' ) );
			add_action( 'in_vc_listing_archive_after_entry', array( $this, 'set_point' ) );
			add_action( 'in_vc_listing_tag_after_entry', array( $this, 'set_point' ) );
			add_action( 'in_vc_listing_region_after_entry', array( $this, 'set_point' ) );
		}
		else
		{
			// Если не указан Google API Key выводим предупреждение
			add_action( 'admin_notices', array( $this, 'show_warning' ) );
		}
	}
	/** -------------------------- Параметры ------------------------ **/
	/**
	 * Метод проверяет доступность карт для отображения
	 */
	public function is_enabled() 
	{
		return isset( $this->options[ self::API_KEY ] ) && $this->options[ self::API_KEY ] != '';
	}	
	
	
	/**
	 * Метод добавляет админ-меню с параметрами плагина
	 */
	public function add_admin_menu() 
	{
		add_submenu_page(
			'edit.php?post_type=in-vc-listing',
			esc_html__( 'Параметры плагина', Plugin::TEXTDOMAIN ),
			esc_html__( 'Параметры', Plugin::TEXTDOMAIN ),
			'manage_options',
			'in_vc_listing_settings',
			array( $this, 'page_layout' )
		);
	}
	
	/**
	 * Метод инициализирует страницу параметров плагина
	 */
	public function init_settings() 
	{
		register_setting(
			self::SETTINGS . '_group',
			self::SETTINGS
		);

		add_settings_section(
			self::SETTINGS . '_section',
			'',
			false,
			self::SETTINGS
		);

		add_settings_field(
			'google_map_key',
			__( 'Google Map Key', Plugin::TEXTDOMAIN ),
			array( $this, 'render_google_map_key_field' ),
			self::SETTINGS,
			self::SETTINGS . '_section'
		);

	}
	
	/**
	 * Метод отрисовывает страницу параметров плагина
	 */
	public function page_layout() 
	{
		// Check required user capability
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( esc_html__( 'У вас нет разрешений на редактирование этой страницы.', Plugin::TEXTDOMAIN ) );
		}

		// Admin Page Layout
		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . get_admin_page_title() . '</h1>' . "\n";
		echo '	<form action="options.php" method="post">' . "\n";

		settings_fields( self::SETTINGS . '_group' );
		do_settings_sections( self::SETTINGS );
		submit_button();

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}
	
	/**
	 * Метод выводит поле ключа google
	 */
	function render_google_map_key_field() 
	{
		// Set default value.
		$value = isset( $this->options[ self::API_KEY ] ) ? $this->options[ self::API_KEY ] : '';

		// Field output.
		echo '<input type="text" name="in_vc_listing_settings[google_map_key]" class="regular-text google_map_key_field" placeholder="' . esc_attr__( '', 'in-vc-listing' ) . '" value="' . esc_attr( $value ) . '">';
		echo '<p class="description">' . __( 'Ключ Google карт', Plugin::TEXTDOMAIN ) . '</p>';
		echo '<p class="description">' . __( 'Получить ключ карт можно по инстукции:', Plugin::TEXTDOMAIN ) . 
			' <a href="https://developers.google.com/maps/documentation/embed/get-api-key">Get an API Key</a> </p>';
	}
	
	/**
	 * Метод выводит предупреждение о необходимости заполнить API Key 
	 */
	function show_warning() 
	{ ?>
		<div class="notice notice-warning">
			<p>
				<?php esc_html_e( 'Для отображения карт необходимо указать ключ', Plugin::TEXTDOMAIN ) ?> 
				<?php echo ' <a href="/wp-admin/edit.php?post_type=in-vc-listing&page=in_vc_listing_settings">API KEY</a>!'?>
			</p>
		</div>
<?php	}

	/** ---------------------- Метабокс координат ---------------------- **/
	public function init_metabox() 
	{
		add_action( 'add_meta_boxes',	array( $this, 'add_metabox' )         );
		add_action( 'save_post',		array( $this, 'save_metabox' ), 10, 2 );
	}

	public function add_metabox() 
	{
		add_meta_box(
			'in_vc_listing_coords',
			__( 'Координаты клиники', 'in_vc_listing' ),
			array( $this, 'render_metabox' ),
			ClinicList::CPT,
			'advanced',
			'default'
		);

	}

	public function render_metabox( $post ) 
	{
		// Retrieve an existing value from the database.
		$in_vc_listing_coords_lat = get_post_meta( $post->ID, 'in_vc_listing_coords_lat', true );
		$in_vc_listing_coords_long = get_post_meta( $post->ID, 'in_vc_listing_coords_long', true );

		// Set default values.
		if( empty( $in_vc_listing_coords_lat ) ) $in_vc_listing_coords_lat = '';
		if( empty( $in_vc_listing_coords_long ) ) $in_vc_listing_coords_long = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="in_vc_listing_coords_lat" class="in_vc_listing_coords_lat_label">' . __( 'Широта', 'in_vc_listing' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="in_vc_listing_coords_lat" name="in_vc_listing_coords_lat" class="in_vc_listing_coords_lat_field" placeholder="' . esc_attr__( '', 'in_vc_listing' ) . '" value="' . esc_attr( $in_vc_listing_coords_lat ) . '">';
		echo '			<p class="description">' . __( 'Широта расположения клиники', 'in_vc_listing' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="in_vc_listing_coords_long" class="in_vc_listing_coords_long_label">' . __( 'Долгота', 'in_vc_listing' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="in_vc_listing_coords_long" name="in_vc_listing_coords_long" class="in_vc_listing_coords_long_field" placeholder="' . esc_attr__( '', 'in_vc_listing' ) . '" value="' . esc_attr( $in_vc_listing_coords_long ) . '">';
		echo '			<p class="description">' . __( 'Долгота расположения клиники', 'in_vc_listing' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Sanitize user input.
		$in_vc_listing_coords_lat = isset( $_POST[ 'in_vc_listing_coords_lat' ] ) ? sanitize_text_field( $_POST[ 'in_vc_listing_coords_lat' ] ) : '';
		$in_vc_listing_coords_long = isset( $_POST[ 'in_vc_listing_coords_long' ] ) ? sanitize_text_field( $_POST[ 'in_vc_listing_coords_long' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'in_vc_listing_coords_lat', $in_vc_listing_coords_lat );
		update_post_meta( $post_id, 'in_vc_listing_coords_long', $in_vc_listing_coords_long );
	}
	
	/** ---------------------- Отображение карты ---------------------- **/	
	/** 
	 * ID Скрипта Google Maps
	 */ 
	const MAPS_JS = 'in-vc-listing-maps-googleapis';
	const LOCAL_JS = 'in-vc-listing-maps-script';
	 
	/**
	 * Регистрирует и загружает JS Google Maps
	 */	 
	public function loadJS()
	{
		
		// Регистриуем API карт
		wp_register_script( 
			self::MAPS_JS, 		// handle, 
			'https://maps.googleapis.com/maps/api/js?key=' . $this->options[ self::API_KEY ] . '&callback=initMap', // src 
			false, 				//deps 
			Plugin::VERSION,	// ver 
			true				//in_footer 
		);
		
		// Регистриуем скрипт инициализации карты
		wp_register_script( 
			self::LOCAL_JS, 					// handle, 
			Plugin::get()->url . 'js/init-map.js', // src 
			array( self::MAPS_JS ), 			// deps 
			Plugin::VERSION,					// ver 
			true								// in_footer 
		);
		
		// Загрузка скрипта
		wp_enqueue_script( self::LOCAL_JS );
	}
	
	/**
	 * Добавляет атрибуты async и defer на скрипт карт
	 */
	public function add_async_defer_attribute( $tag, $handle ) 
	{
		$async_defer_scripts = array( self::MAPS_JS );
		if ( in_array( $handle, $async_defer_scripts) )
		{
			return 
				str_replace(' src', ' async="async" src', 
				str_replace(' src', ' defer="defer" src', $tag ));
		}
		return $tag;
	}
	
	/**
	 * Отображает карту на страницах
	 */
	public function show( $id ) 
	{
		echo '<style>#in-vc-listing-map { height: 500px; }</style>'; /* Always set the map height explicitly to define the size of the div element that contains the map. */
		echo '<div id="in-vc-listing-map"></div>';
	}
	
	/**
	 * Заполняет массив точек для отображения
	 */
	public function set_point( $id ) 
	{
		$lat = (float) get_post_meta( $id, 'in_vc_listing_coords_lat', true );
		$long = (float) (float) get_post_meta( $id, 'in_vc_listing_coords_long', true );
		
		// Если координаты указаны, выводим точку на карту
		if ( $lat > 0 && $long > 0)
		{		
			echo '<script>' . PHP_EOL;
			echo 'window.in_vc_listing_map = window.in_vc_listing_map || {};';
			echo '(window.in_vc_listing_map.points = window.in_vc_listing_map.points || []).push({
				id : ' . (int) $id . ',
				title : "' . get_the_title( $id ) . '",
				lat : ' . $lat . ',
				long : ' . $long . '
			});' . PHP_EOL;
			echo '</script>' . PHP_EOL;
		}
	}
	
}