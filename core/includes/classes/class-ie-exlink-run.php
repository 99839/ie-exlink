<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Ie_Exlink_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		IELINK
 * @subpackage	Classes/Ie_Exlink_Run
 * @author		99839
 * @since		1.0.0
 */
class Ie_Exlink_Run{

	/**
	 * Our Ie_Exlink_Run constructor
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){

		add_action( 'plugin_action_links_' . IELINK_PLUGIN_BASE, array( $this, 'add_plugin_action_link' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts_and_styles' ), 20 );
		add_filter('the_content', array( $this, 'add_class_to_external_links' ) );
		add_filter( 'comment_text', array( $this, 'add_class_to_external_links' ) );
		//add_action('init', array( $this, 'wpb_modify_jquery'), 20 );

	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	* Adds action links to the plugin list table
	*
	* @access	public
	* @since	1.0.0
	*
	* @param	array	$links An array of plugin action links.
	*
	* @return	array	An array of plugin action links.
	*/
	public function add_plugin_action_link( $links ) {

		$links['our_shop'] = sprintf( '<a href="%s" target="_blank title="ietheme" style="font-weight:700;">%s</a>', 'https://Ietheme.com', __( 'ietheme', 'ie-exlink' ) );

		return $links;
	}

	/**
	 * Enqueue the frontend related scripts and styles for this plugin.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_frontend_scripts_and_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_script( 'ielink-scripts', IELINK_PLUGIN_URL . 'core/includes/assets/js/ielink-scripts' . $suffix . '.js', array( 'jquery' ), IELINK_VERSION, true );

		$ielink_options = get_option( 'iexlink_general' );
		$message        = $ielink_options['iex-warning'];
		$linkwarning    = $ielink_options['iex-linkwarning'] == 'on' ? 'true' : 'false';
		$nofollow       = $ielink_options['iex-nofollow'] == 'on' ? 'true' : 'false';
		$showurl        = $ielink_options['iex-showurl'] == 'on' ? 'true' : 'false';
		$cancel         = $ielink_options['iex-cancel'];
		$continue       = $ielink_options['iex-continue'];
		$color          = $ielink_options['iex-external-color'];

        wp_localize_script( 'ielink-scripts', 'iexlink', array(
			'linkwarning'   => $linkwarning,
			'nofollow'      => $nofollow,
			'showurl'       => $showurl,
			'message'       => $message,
			'cancel'        => $cancel,
			'continue'      => $continue,
			'color'         => $color
		));

	}

	public function add_class_to_external_links($content) {
		return preg_replace_callback('/<a[^>]+/', array( $this, 'add_class_to_external_links_callback'), $content);
	}

	public function add_class_to_external_links_callback($matches) {
		$link = $matches[0];
		$site_link = home_url('/');
		if (strpos($link, 'class') === false) {
			$link = preg_replace("%(href=\S(?!$site_link))%i", 'class="external" $1', $link);
		} elseif (preg_match("%href=\S(?!$site_link)%i", $link)) {
			$link = preg_replace('/class\s*=\s*[\'"]([^\'"]+)[\'"]/', 'class="external $1"', $link);
		}
		return $link;
	}

}
