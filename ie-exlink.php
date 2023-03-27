<?php
/**
 * ie exLink
 *
 * @package       IELINK
 * @author        99839
 * @license       gplv3-or-later
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   ie exLink
 * Plugin URI:    https://mydomain.com
 * Description:   a plugin simplifies the task of opening external links in a new tab
 * Version:       1.0.0
 * Author:        99839
 * Author URI:    https://ietheme.com
 * Text Domain:   ie-exlink
 * Domain Path:   /languages
 * License:       GPLv3 or later
 * License URI:   https://www.gnu.org/licenses/gpl-3.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with ie exLink. If not, see <https://www.gnu.org/licenses/gpl-3.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin name
define( 'IELINK_NAME',			'ie exLink' );

// Plugin version
define( 'IELINK_VERSION',		'1.0.0' );

// Plugin Root File
define( 'IELINK_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'IELINK_PLUGIN_BASE',	plugin_basename( IELINK_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'IELINK_PLUGIN_DIR',	plugin_dir_path( IELINK_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'IELINK_PLUGIN_URL',	plugin_dir_url( IELINK_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once IELINK_PLUGIN_DIR . 'core/class-ie-exlink.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  99839
 * @since   1.0.0
 * @return  object|Ie_Exlink
 */
function IELINK() {
	return Ie_Exlink::instance();
}

IELINK();
