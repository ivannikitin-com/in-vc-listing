<?php
/**
 * Plugin Name: IN VC Listing
 * Plugin URI:  https://ivannikitin-com.github.io/inbi4wp/
 * Description: Список ветеринарных клиник и их систематизация
 * Version:     1.0
 * Author:      Ivan Nikitin & Co.
 * Author URI:  https://ivannikitin.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: in-vc-listing
 * Domain Path: /languages
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Pligin files */
require( 'classes/plugin.php' );
require( 'classes/clinic-list.php' );

/* Run plugin */
\IN_VC_Listring\Plugin::get(  __FILE__ );