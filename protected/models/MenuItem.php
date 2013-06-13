<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $id
 * @property integer $menu_id
 * @property integer $lang_id
 * @property string $caption
 * @property string $link
 * @property integer $active
 * @property integer $parent_id
 * @property integer $level
 * @property string $path
 * @property integer $access_level
 */
class MenuItem extends CActiveRecord
{
	/**
	 * @const maximum depth for adding nested menu items
	 * @todo move this to overall site's config read from database
	 */
	const MAX_PARENTING_DEPTH = 6;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenuItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id, lang_id, caption, link', 'required'),
			array('menu_id, lang_id, active, parent_id, level, access_level', 'numerical', 'integerOnly'=>true),
			array('caption', 'length', 'max'=>45),
			array('link', 'length', 'max'=>500),
			array('path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menu_id, lang_id, caption, link, active, parent_id, level, path, access_level', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_id' => 'Menu',
			'lang_id' => 'Lang',
			'caption' => 'Caption',
			'link' => 'Link',
			'active' => 'Active',
			'parent_id' => 'Parent',
			'level' => 'Level',
			'path' => 'Path',
			'access_level' => 'Access Level',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('caption',$this->caption,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('access_level',$this->access_level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Checks is there are any items assigned to menu
	 * @param integer Menu model id
	 * @return boolean
	 */
	public static function parentsExist($menuId)
	{
		$parentsCount = self::model()->countByAttributes(array(
			'menu_id' => (int)$menuId,
		));
		return ($parentsCount) ? true : false;
	}

	/**
	 * Builds a list data for parent selection list
	 * @param integer menu id
	 * @return CListData for dropDownList widget
	 */
	public static function getPossibleParents($menuId)
	{
		$models = self::model()->findAllByAttributes(
			array(
				'menu_id'=>$menuId
			),
			'level<=:maxDepth',
			array(
				':maxDepth'=>self::MAX_PARENTING_DEPTH
			)
		);

		return CHtml::listData($models, 'id', function($item) {
			$levelShift = str_repeat('-', (
				($item->level > 1)
				? $item->level+2
				: $item->level
			));
			return CHtml::encode("|{$levelShift} {$item->caption}");
		});
	}
}
