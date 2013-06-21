<?php
namespace lowtone\media\types\handlers;
use lowtone\types\singletons\Singleton,
	lowtone\wp\admin\menus\Menu,
	lowtone\media\types\Type;

class TypeHandler extends Singleton {

	protected $itsTypes = array();

	protected function __construct() {
		/*$handler = $this;

		$this->add(new Type(array(
				Type::PROPERTY_TITLE => "foo",
				Type::PROPERTY_SLUG => "bar",
				Type::PROPERTY_URL => "hello",
				Type::PROPERTY_ICON => "World!",
			)));

		add_action("admin_menu", function() use ($handler) {
			if (count($types = $handler->types()) < 2)
				return;

			$oldPage = remove_submenu_page("upload.php", "media-new.php");

			add_media_page(
					$oldPage[0],
					$oldPage[0],
					$oldPage[1],
					"lowtone_media_new",
					function() use ($types) {
						echo '<ul>';

						foreach ($types as $type) {
							echo '<li>Type</li>';
						}

						echo '</li>';
					}
				);
		}, 0);*/

	}

	public function add($type) {
		$this->itsTypes[] = $type;

		return $this;
	}

	public function types() {
		return $this->itsTypes;
	}

}