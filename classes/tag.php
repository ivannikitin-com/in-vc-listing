<?php
/**
 * Реализация таксономии клиник
 * Class Tag
 */
namespace IN_VC_Listring;

class Tag
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
	 * Теги клиник
	 * @var tag
	 */
	private $slug;	

	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->slug = ClinicList::SLUG . '/' . self::SLUG;
		//$this->slug = self::SLUG;
		
		// Инициализация
		add_action('init', array( $this, 'init') );
		add_action( self::TAXONOMY . '_edit_form_fields', array( $this, 'tinyMCE' ), 10, 2);
	}
	
	/**
	 * Инициализация по хуку Init
	 */
	public function init()
	{
		// Регистрируем тип данных
		$this->registerTaxonomy();
	}	
	
	/**
	 * Регистрация CPT
	 */
	private function registerTaxonomy()
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
			'query_var'					 => self::TAXONOMY,
			'rewrite'                    => $rewrite,
			'show_in_rest'               => true,
		);
		register_taxonomy( self::TAXONOMY, array( ClinicList::CPT ), $args );
	}
	
	public function tinyMCE( $term, $taxonomy )
	{
    ?>
    <tr valign="top">
        <th scope="row"><?php esc_html_e( 'Описание тега', Plugin::TEXTDOMAIN )?></th>
        <td>
            <?php wp_editor(html_entity_decode($term->description), 'description', array('media_buttons' => false)); ?>
            <script>
                jQuery(window).ready(function(){
                    jQuery('label[for=description]').parent().parent().remove();
                });
            </script>
        </td>
    </tr>
    <?php		
	}
}