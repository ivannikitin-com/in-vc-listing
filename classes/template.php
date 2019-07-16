<?php
/**
 * Менеджер шаблонов вывода
 * Class Template
 */
namespace IN_VC_Listring;

class Template
{
	/**
	 * Конструктор
	 * Инициализация шаблонов
	 */
	public function __construct()
	{
		add_filter( 'template_include', array( $this, 'load' ) );
	}	
	
	/**
	 * Загружает и возвращает шаблон для отображения страницы автора
	 * http://wordpress.stackexchange.com/questions/155871/create-template-author-with-a-plugin
	 *
	 * @param string	$template	Имя загружаемого шаблона
	 * @return string	Имя загружаемого шаблона
	 */
	public function load( $template )
	{
		// Если это подзапрос, шаблоны не подставляем! Например, так сделано в WooCommerce
		// https://docs.woocommerce.com/wc-apidocs/source-class-WC_Template_Loader.html#7-119
        if ( is_embed() )
            return $template;
		
		// Сформированный файл шаблона
		$file = '';
		
		// Определение нужного шаблона
		if ( is_single() && get_post_type() == ClinicList::CPT ) 
		{
			$file = 'clinic.php'; 		// Шаблон одной клиники		
		}
		elseif ( is_post_type_archive( ClinicList::CPT ) )
		{
			$file = 'archive.php'; 		// Шаблон архива клиник
		}		
		elseif ( is_tax( Region::TAXONOMY ) )
		{
			$file = 'region.php'; 	// Шаблон вывода региона
		}
		elseif ( is_tax( Tag::TAXONOMY ) )
		{
			$file = 'tag.php'; 	// Шаблон вывода метки
		}
		
		// Если шаблон определен...
		if ( $file ) 
		{
			// Где искать шаблоны
			$find = array();
			//$find[] = $file;								// В текущей папке темы не ищем, поскольку имена шаблонов пересекаются с темой						
			$find[] = Plugin::TEXTDOMAIN . '/' . $file; 	// В теме, в папке с названием плагина					
			
			$template = locate_template( array_unique( $find ) );
			if ( ! $template ) 
			{ 
				// Шаблон не найден, подгружаем из плагина
				$template = Plugin::get()->dir . 'templates/' . $file;
			}
		}
		return $template;		
	}
}