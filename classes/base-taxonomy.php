<?php
/**
 * Базовый класс, реализующий общие функции таксономий планига
 * Class Tag
 */
namespace IN_VC_Listring;

class BaseTaxonomy
{
	/**
	 * @const Custom Post Type
	 */
	const TAXONOMY = 'in-vc-taxonomy';
	
	/**
	 * @const Custom Post Type
	 */
	const SLUG = 'taxonomy';
	
	/**
	 * Слаг таксономии
	 * @var slug
	 */
	protected $slug;
	
	/**
	 * Описание, которое выводится в редакторе
	 * @var slug
	 */
	protected $label;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->slug = ClinicList::SLUG . '/' . static::SLUG;
		$this->label = __( 'Описание', Plugin::TEXTDOMAIN );
		
		// Инициализация
		add_action('init', array( $this, 'init') );
		add_action( static::TAXONOMY . '_edit_form_fields', array( $this, 'tinyMCE' ), 10, 2);
	}
	
	/**
	 * Инициализация по хуку Init
	 */
	public function init()
	{
		// Регистрируем таксономию
		$this->registerTaxonomy();
	}	
	
	/**
	 * Регистрация таксономии
	 */
	protected function registerTaxonomy()
	{
		// Переопределяется потомками
	}
	
	public function tinyMCE( $term, $taxonomy )
	{
		?>
		<tr valign="top">
			<th scope="row"><?php esc_html( $this->label )?></th>
			<td>
				<?php wp_editor( html_entity_decode( $term->description ), 'description', array( 'media_buttons' => false ) ); ?>
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