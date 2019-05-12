<?php
/**
 * Список ветеринарных клиник и их систематизация
 * Class Plugin
 */
namespace IN_VC_Listring;

class Plugin
{
	/**
	 * @const TEXTDOMAIN Text domain
	 */
	const TEXTDOMAIN = 'in-vc-listing';
	
	/**
	 * @const LANG Translations folder
	 */
	const LANG = '/languages';
	
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
		$this->clinicList = new ClinicList();
		
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