<?php
/**
 * Реализация выборки тегов по региону
 * Class RegionTags
 */
namespace IN_VC_Listring;

class RegionTags
{
	/**
	 * @const Слаг в котором работает выборка тегов по региону
	 */
	const SLUG = 'filter';	
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Инициализация
		add_action('init', array( $this, 'addRewriteRules') );
	}
	
	/**
	 * Добавляет правила перезаписи URL
	 */
	public function addRewriteRules()
	{
		$regexp = '^' . ClinicList::SLUG . '/' . self::SLUG . '/(.?.+?)/' . Tag::SLUG . '/([^/]*)/?';
		$url = 'index.php?' . Region::TAXONOMY . '=$matches[1]&' . Tag::TAXONOMY . '=$matches[2]';
		add_rewrite_rule( $regexp, $url, 'top' );
	}
}