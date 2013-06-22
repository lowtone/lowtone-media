<?php
namespace lowtone\media\types\handlers;
use lowtone\types\singletons\Singleton,
	lowtone\wp\admin\menus\Menu,
	lowtone\media\types\Type;

class TypeHandler extends Singleton {

	protected $itsTypes = array();

	protected function __construct() {
		$handler = $this;

		$this->add(new Type(array(
				Type::PROPERTY_TITLE => __("Upload", "lowtone_media"),
				Type::PROPERTY_NEW_FILE_TEXT => __("Upload a new file"),
				Type::PROPERTY_SLUG => admin_url("media-new.php"),
				Type::PROPERTY_IMAGE => LIB_URL . "/lowtone-media/assets/images/upload-icon.png",
			)));

		add_action("admin_menu", function() use ($handler) {
			if (count($types = $handler->types()) < 2)
				return;

			if ($oldPage = remove_submenu_page("upload.php", "media-new.php")) {

				add_action("load-media-new.php", function() {
					$GLOBALS["submenu_file"] = "lowtone_media_new";
				});

				add_media_page(
						$oldPage[0],
						$oldPage[0],
						$oldPage[1],
						"lowtone_media_new",
						function() use ($handler, $types) {
							if (isset($_REQUEST["type"])) {

								if (false === ($type = $handler->type($_REQUEST["type"])))
									throw new \ErrorException(sprintf("%s is not a valid media type", $_REQUEST["type"]));

								if (!is_callable($callback = $type->{Type::PROPERTY_NEW_FILE_CALLBACK}))
									throw new \ErrorException(sprintf("No new file callback defined for media type %", $type->{Type::PROPERTY_SLUG}));

								return call_user_func($callback);
							}

							wp_enqueue_style("lowtone_media_new", LIB_URL . "/lowtone-media/assets/styles/media-new.css");

							echo '<div class="wrap">' . 
								get_screen_icon() . 
								'<h2>' . __("Add a new file", "lowtone_media") . '</h2>' . 
								'<p>' . __("Select how you want to add a new file:", "lowtone_media") . '</p>' .
								'<ul class="lowtone media type select">';

							foreach ($types as $type) {
								echo '<li class="lowtone media type">' . 
									sprintf('<a href="%s">', esc_attr($type->url()));

								if ($type->{Type::PROPERTY_IMAGE})
									echo sprintf('<img src="%s" alt="" />', esc_attr($type->{Type::PROPERTY_IMAGE}));

								echo '<h3>' . esc_html($type->{Type::PROPERTY_TITLE}) . '</h3>' . 
									'<p>' . esc_html($type->{Type::PROPERTY_NEW_FILE_TEXT})  . '</p>' .
									'</a>' .
									'</li>';
							}

							echo '</ul>' . 
								'</div>';
						}
					);
			}
		}, 0);

	}

	public function add($type) {
		$this->itsTypes[] = $type;

		return $this;
	}

	public function types() {
		return $this->itsTypes;
	}

	public function type($slug) {
		foreach ($this->itsTypes as $type) {
			if ($type->{Type::PROPERTY_SLUG} != $slug)
				continue;

			return $type;
		}

		return false;
	}

}