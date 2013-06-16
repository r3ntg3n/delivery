<?php

/**
 * News ActiveRecord class extends from Page model class
 * due to that difference that News record has <code>type</code> attribute
 * equal to Page::TYPE_NEWS constant
 *
 * @package Models
 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
 * @version 1.0.0.1
 */
class News extends Page
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Set default scope SELECT queries parameters
	 * @return array scope params
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	public function defaultScope()
	{
		return array(
			'condition' => 'type='.Page::TYPE_NEWS,
		);
	}

	/**
	 * Return validation rules for model attributes
	 * @return array validation rules
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	public function rules()
	{
		return CMap::mergeArray(
			parent::rules(),
			array(
				array('type', 'default', 'value'=>Page::TYPE_NEWS, 'setOnEmpty' => true)
			)
		);
	}
}
