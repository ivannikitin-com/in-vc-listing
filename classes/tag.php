<?php
/**
 * Реализация таксономии клиник
 * Class Tag
 */
namespace IN_VC_Listring;

class Tag extends BaseTaxonomy
{
	/**
	 * @const Custom Post Type
	 */
	const TAXONOMY = 'in-vc-tag';
	
	/**
	 * @const Custom Post Type
	 */
	const SLUG = 'tag';
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->label = __( 'Описание тега', Plugin::TEXTDOMAIN );
	}
	
	/**
	 * Регистрация таксономии
	 */
	protected function registerTaxonomy()
	{
		$labels = array(
			'name'                       => _x( 'Теги', 'Taxonomy General Name', Plugin::TEXTDOMAIN ),
			'singular_name'              => _x( 'Тег', 'Taxonomy Singular Name', Plugin::TEXTDOMAIN ),
			'menu_name'                  => __( 'Теги', Plugin::TEXTDOMAIN ),
			'all_items'                  => __( 'Все теги', Plugin::TEXTDOMAIN ),
			'parent_item'                => __( 'Родительский тег', Plugin::TEXTDOMAIN ),
			'parent_item_colon'          => __( 'Родительский тег:', Plugin::TEXTDOMAIN ),
			'new_item_name'              => __( 'Новый тег', Plugin::TEXTDOMAIN ),
			'add_new_item'               => __( 'Добавить тег', Plugin::TEXTDOMAIN ),
			'edit_item'                  => __( 'Редактировать тег', Plugin::TEXTDOMAIN ),
			'update_item'                => __( 'Обновить тег', Plugin::TEXTDOMAIN ),
			'view_item'                  => __( 'Просмотр', Plugin::TEXTDOMAIN ),
			'separate_items_with_commas' => __( 'Теги, разделенные запятыми', Plugin::TEXTDOMAIN ),
			'add_or_remove_items'        => __( 'Добавить или удалить теги', Plugin::TEXTDOMAIN ),
			'choose_from_most_used'      => __( 'Выберите из популярных тегов', Plugin::TEXTDOMAIN ),
			'popular_items'              => __( 'Популярные теги', Plugin::TEXTDOMAIN ),
			'search_items'               => __( 'Поиск тегов', Plugin::TEXTDOMAIN ),
			'not_found'                  => __( 'Не найдено', Plugin::TEXTDOMAIN ),
			'no_terms'                   => __( 'Нет тегов', Plugin::TEXTDOMAIN ),
			'items_list'                 => __( 'Список тегов', Plugin::TEXTDOMAIN ),
			'items_list_navigation'      => __( 'Навигация по списку тегов', Plugin::TEXTDOMAIN ),
		);
		$rewrite = array(
			'slug'                       => $this->slug,
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var'					 => static::TAXONOMY,
			'rewrite'                    => $rewrite,
			'show_in_rest'               => true,
		);
		register_taxonomy( static::TAXONOMY, array( ClinicList::CPT ), $args );
	}
}