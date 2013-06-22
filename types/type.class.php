<?php
namespace lowtone\media\types;
use lowtone\db\records\Record,
	lowtone\net\URL;

class Type extends Record {
	
	const PROPERTY_TITLE = "title",
		PROPERTY_NEW_FILE_TEXT = "new_file_text",
		PROPERTY_NEW_FILE_CALLBACK = "new_file_callback",
		PROPERTY_SLUG = "slug",
		PROPERTY_IMAGE = "image";

	public function url() {
		if (preg_match("/\.php$/i", $this->{self::PROPERTY_SLUG}))
			return $this->{self::PROPERTY_SLUG};
								
		return (string) URL::fromString(admin_url("upload.php"))
			->query(array(
				"page" => "lowtone_media_new",
				"type" => $this->{self::PROPERTY_SLUG}
			));
	}

}