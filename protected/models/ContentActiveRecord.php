<?php

class ContentActiveRecord extends BaseActiveRecord
{
	protected function beforeValidate()
	{
		if (array_key_exists('sef_title', $this->attributes) && array_key_exists('title', $this->attributes))
		{
			$this->sef_title = empty($this->sef_title)
				? UrlTransliterate::cleanString($this->title)
				: $this->sef_title;
		}

		return parent::beforeValidate();
	}
}
