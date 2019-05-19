<?php
/**
 * Реализация таксономии клиник
 * Class Tag
 */
namespace IN_VC_Listring;

class Region extends BaseTaxonomy
{
	/**
	 * @const Custom Post Type
	 */
	const TAXONOMY = 'in-vc-region';
	
	/**
	 * @const Custom Post Type
	 */
	const SLUG = 'region';
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->label = __( 'Описание региона', Plugin::TEXTDOMAIN );
	}
	
	/**
	 * Регистрация таксономии
	 */
	protected function registerTaxonomy()
	{
		$labels = array(
			'name'                       => _x( 'Регионы', 'Taxonomy General Name', Plugin::TEXTDOMAIN ),
			'singular_name'              => _x( 'Регион', 'Taxonomy Singular Name', Plugin::TEXTDOMAIN ),
			'menu_name'                  => __( 'Регионы', Plugin::TEXTDOMAIN ),
			'all_items'                  => __( 'Все регионы', Plugin::TEXTDOMAIN ),
			'parent_item'                => __( 'Родительский регион', Plugin::TEXTDOMAIN ),
			'parent_item_colon'          => __( 'Родительский регион:', Plugin::TEXTDOMAIN ),
			'new_item_name'              => __( 'Название нового региона', Plugin::TEXTDOMAIN ),
			'add_new_item'               => __( 'Добавить новый регион', Plugin::TEXTDOMAIN ),
			'edit_item'                  => __( 'Редактировать', Plugin::TEXTDOMAIN ),
			'update_item'                => __( 'Обновить', Plugin::TEXTDOMAIN ),
			'view_item'                  => __( 'Просмотр', Plugin::TEXTDOMAIN ),
			'separate_items_with_commas' => __( 'Разделите регионы запятыми', Plugin::TEXTDOMAIN ),
			'add_or_remove_items'        => __( 'Добавить или удалить регионы', Plugin::TEXTDOMAIN ),
			'choose_from_most_used'      => __( 'Выберите из списка часто используемых регионов', Plugin::TEXTDOMAIN ),
			'popular_items'              => __( 'Популярные регионы', Plugin::TEXTDOMAIN ),
			'search_items'               => __( 'Поиск регионов', Plugin::TEXTDOMAIN ),
			'not_found'                  => __( 'Не найдено', Plugin::TEXTDOMAIN ),
			'no_terms'                   => __( 'Нет регионов', Plugin::TEXTDOMAIN ),
			'items_list'                 => __( 'Список регионов', Plugin::TEXTDOMAIN ),
			'items_list_navigation'      => __( 'Навигация по списку регионов', Plugin::TEXTDOMAIN ),
		);
		
		$rewrite = array(
			'slug'                       => $this->slug,
			'with_front'                 => true,
			'hierarchical'               => true,
		);
		
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite,
			'query_var'					 => static::TAXONOMY,			
			'show_in_rest'               => true,
		);
		
		register_taxonomy( static::TAXONOMY, array( ClinicList::CPT ), $args );
	}
}