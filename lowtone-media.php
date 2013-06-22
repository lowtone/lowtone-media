<?php
/*
 * Plugin Name: Lowtone Media library 
 * Plugin URI: http://wordpress.lowtone.nl/libs/media
 * Plugin Type: lib
 * Description: Support functions for media.
 * Version: 1.0
 * Author: Lowtone <info@lowtone.nl>
 * Author URI: http://lowtone.nl
 * License: http://wordpress.lowtone.nl/license
 */

namespace lowtone\media {

	use lowtone\content\packages\Package;

	// Includes
	
	if (!include_once WP_PLUGIN_DIR . "/lowtone-content/lowtone-content.php") 
		return trigger_error("Lowtone Content plugin is required", E_USER_ERROR) && false;

	$__i = Package::init(array(
			Package::INIT_PACKAGES => array("lowtone", "lowtone\\wp"),
			Package::INIT_MERGED_PATH => __NAMESPACE__,
			Package::INIT_SUCCESS => function() {

				// Load text domain
				
				$loadTextDomain = function() {
					if (is_textdomain_loaded("lowtone_media"))
						return;

					load_textdomain("lowtone_media", __DIR__ . "/assets/languages/" . get_locale() . ".mo");
				};

				add_action("plugins_loaded", $loadTextDomain);

				add_action("after_setup_theme", $loadTextDomain);

				return true;
			}
		));

	if (!$__i)
		return false;

	function addMediaType($type) {
		types\handlers\TypeHandler::__instance()->add($type);
	}

}