<?php
/**
 * Список ветеринарных клиник и их систематизация
 * Class Plugin
 */
namespace IN_VC_Listring;

class Plugin
{
	/**
	 * @const VERSION Версия плагина
	 */
	const VERSION = '1.4';
	
	/**
	 * @const TEXTDOMAIN Text domain
	 */
	const TEXTDOMAIN = 'in-vc-listing';
	
	/**
	 * @const LANG Translations folder
	 */
	const LANG = '/lang';
	
    /**
     * @var Plugin
     */
    private static $instance;	
	
	/**
	 * Plugin folder
	 * @var string
	 */
	public $dir = '';
	
	/**
	 * Plugin folder URL
	 * @var string
	 */
	public $url = '';	
	
	/**
	 * Plugin file
	 * @var string
	 */
	private $file = '';	
	
	/**
	 * Список клиник
	 * @var clinicList
	 */
	private $clinicList;		
	
	/**
	 * Теги клиник
	 * @var tag
	 */
	private $tag;
	
	/**
	 * Регионы клиник
	 * @var region
	 */
	private $region;

	/**
	 * Менеджер шаблонов
	 * @var template
	 */
	private $template;

	/**
	 * Карты клиник
	 * @var map
	 */
	private $map;
	
	/**
	 * Выборка клиник по тегам в регионах
	 * @var region
	 */
	private $regionTags;	
	
    /**
     * Gets the instance via lazy initialization (created on first usage)
	 * @param string $pluginDir	plugin folder. Must be specified at the first call ! 
     */
    public static function get( $pluginDir = '' ): Plugin
    {
        if (null === static::$instance) {
            static::$instance = new static( $pluginDir );
        }

        return static::$instance;
    }
	
	/**
	 * Constructor
	 * @param string	$pluginFile	Plugin File
	 */
	private function __construct( $pluginFile )
	{
		$this->file = $pluginFile;
		$this->dir = plugin_dir_path( $pluginFile );
		$this->url = plugin_dir_url( $pluginFile );
		
		$this->tag = new Tag();			// ВАЖНО! Таксономия использует слаг CPT, поэтому она должна регистироваться ДО CPT
		$this->tag = new Region();
		$this->tag = new RegionTags();
		$this->clinicList = new ClinicList();
		$this->template = new Template();
		$this->map = new Map();
		
		add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
	}
	
	/**
	 * Load textdomain
	 */
	public function loadTextDomain()
	{
		load_plugin_textdomain( self::TEXTDOMAIN, false, basename( dirname( $this->file ) ) . self::LANG );
	}
}