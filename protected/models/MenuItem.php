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
	 * @const top items level 
	 */
	const TOP_ITEMS_LEVEL = 1;

	/**
	 * @static
	 * @property int max children level to load to menu tree
	 */
	static private $maxChildrenLevel = null;

	/**
	 * @static
	 * @property string menu item caption rendering template
	 */
	static private $itemCaptionTemplate = null;

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
			array('parent_id', 'default', 'value'=>0, 'setOnEmpty'=>true),
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
	 * @static
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
				($item->level > MenuItem::TOP_ITEMS_LEVEL)
				? $item->level+2
				: $item->level
			));
			return CHtml::encode("|{$levelShift} {$item->caption}");
		});
	}

	/**
	 * Builds an items tree for specified menu
	 * @static
	 * @param stdClass params for items tree
	 * @return array menu items tree
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	public static function getMenuTree(array $params)
	{
		$menuId = isset($params['menu']) ? $params['menu'] : null;
		if ($menuId === null)
		{
			return null;
		}

		self::$maxChildrenLevel = isset($params['maxLevel']) ? $params['maxLevel'] : MenuItem::TOP_ITEMS_LEVEL;
		self::$itemCaptionTemplate = isset($params['captionTemplate']) ? $params['captionTemplate'] : null;

		$items = new CActiveDataProvider(__CLASS__, array(
			'criteria' => array(
				'order'=>'path ASC',
				'condition' => 'menu_id =:menu_id && level<=:level',
				'params' => array(
					':menu_id' => $menuId,
					':level' => self::$maxChildrenLevel,
				),
			),
		));
		$tree = self::getTreeFromProvider($items, $params);
		return $tree;
	}

	/**
	 * Builds an items tree from CActiveDataProvider instance
	 * @static
	 * @param CActiveDataProvider object
	 * @return array menu items tree from provider's data
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	private static function getTreeFromProvider(CActiveDataProvider &$items)
	{
		$tree = array();

		foreach($items->getData() as $item)
		{
			$node = array(
				'id' => "MenuItem_{$item->id}",
				'text' => (self::$itemCaptionTemplate !== null) ? self::buildItemCaptionByTemplate($item) : $item->caption,
			);

			if ($item->level < self::$maxChildrenLevel)
			{
				$children = self::getChildren($item->id);
			}
			else
			{
				$children = null;
			}
			$node['children'] = $children;
			$tree[] = $node;
		}
		return $tree;
	}

	private static function buildItemCaptionByTemplate(MenuItem &$item)
	{
		$caption = preg_replace_callback('%(?:{(\w+)})%', function($matches) use (&$item)
		{
			if ($matches[1] == 'caption')
			{
				return $item->caption;
			}

			switch ($matches[1])
			{
			case 'link':
				$label = $item->caption;
				$url = $item->link;
				break;
			default:
				$label = ($matches[1] == 'view') ? $item->caption : Yii::t('default', ucfirst($matches[1]));
				$url = Yii::app()->createUrl('menuItem/' . $matches[1], array('id' => $item->id));
				break;
			}
			return CHtml::link($label, $url);
		}, self::$itemCaptionTemplate);

		return $caption;
	}

	/**
	 * Returns child items for specified element
	 * @static
	 * @param integet root element's Id
	 * @return array of children or null if nothing found
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	public static function getChildren($rootElementId)
	{
		$items = new CActiveDataProvider(__CLASS__, array(
			'criteria' => array(
				'condition' => 'parent_id=:parent_id',
				'params' => array(
					':parent_id' => $rootElementId,
				),
				'order' => 'path ASC',
			),
		));

		if ($items->totalItemCount)
		{
			return self::getTreeFromProvider($items);
		}
		else
		{
			return null;
		}
	}
}
