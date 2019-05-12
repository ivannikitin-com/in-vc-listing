<?php
/**
 * Реализация списка клиник
 * Class ClinicList
 */
namespace IN_VC_Listring;

class ClinicList
{
	/**
	 * @const Custom Post Type
	 */
	const CPT = 'in-vc-listing';
	
	/**
	 * @const Custom Post Type
	 */
	const SLUG = 'clinic';	

	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Параметры постоянных ссылок
		add_action('init', array( $this, 'init') );
	}
	
	/**
	 * Инициализация по хуку Init
	 */
	public function init()
	{
		// Регистрируем тип данных
		$this->registerCPT();
	}	
	
	/**
	 * Регистрация CPT
	 */
	private function registerCPT()
	{
		$labels = array(
			'name'                  => _x( 'Ветеринарные клиники', 'Post Type General Name', Plugin::TEXTDOMAIN ),
			'singular_name'         => _x( 'Ветеринарная клиника', 'Post Type Singular Name', Plugin::TEXTDOMAIN ),
			'menu_name'             => __( 'Клиники', Plugin::TEXTDOMAIN ),
			'name_admin_bar'        => __( 'Клиники', Plugin::TEXTDOMAIN ),
			'archives'              => __( 'Список клиник', Plugin::TEXTDOMAIN ),
			'attributes'            => __( 'Свойства клиники', Plugin::TEXTDOMAIN ),
			'parent_item_colon'     => __( 'Головная клиника', Plugin::TEXTDOMAIN ),
			'all_items'             => __( 'Все клиники', Plugin::TEXTDOMAIN ),
			'add_new_item'          => __( 'Добавить новую клинику', Plugin::TEXTDOMAIN ),
			'add_new'               => __( 'Добавить', Plugin::TEXTDOMAIN ),
			'new_item'              => __( 'Новая клиника', Plugin::TEXTDOMAIN ),
			'edit_item'             => __( 'Редактировать клинику', Plugin::TEXTDOMAIN ),
			'update_item'           => __( 'Обновить клинику', Plugin::TEXTDOMAIN ),
			'view_item'             => __( 'Просмотр', Plugin::TEXTDOMAIN ),
			'view_items'            => __( 'Просмотр клиник', Plugin::TEXTDOMAIN ),
			'search_items'          => __( 'Поиск клиник', Plugin::TEXTDOMAIN ),
			'not_found'             => __( 'Не найдено', Plugin::TEXTDOMAIN ),
			'not_found_in_trash'    => __( 'Не найдено в корзине', Plugin::TEXTDOMAIN ),
			'featured_image'        => __( 'Фото клиники', Plugin::TEXTDOMAIN ),
			'set_featured_image'    => __( 'Установить фото клиники', Plugin::TEXTDOMAIN ),
			'remove_featured_image' => __( 'Удалить фото', Plugin::TEXTDOMAIN ),
			'use_featured_image'    => __( 'Использовать как фото', Plugin::TEXTDOMAIN ),
			'insert_into_item'      => __( 'Вставить в элемент клиники', Plugin::TEXTDOMAIN ),
			'uploaded_to_this_item' => __( 'Загружено для клиники', Plugin::TEXTDOMAIN ),
			'items_list'            => __( 'Список клиник', Plugin::TEXTDOMAIN ),
			'items_list_navigation' => __( 'Навигация по списку клиник', Plugin::TEXTDOMAIN ),
			'filter_items_list'     => __( 'Фильтр клиник', Plugin::TEXTDOMAIN ),
		);
		$rewrite = array(
			'slug'                  => self::SLUG,
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Клиника', Plugin::TEXTDOMAIN ),
			'description'           => __( 'Ветеринарные клиники', Plugin::TEXTDOMAIN ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-multisite',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
			'rest_base'             => 'in-vc-listing',
		);
		register_post_type( 'in-vc-listing', $args );		
	}

}