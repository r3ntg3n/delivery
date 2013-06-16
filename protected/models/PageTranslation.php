<?php

/**
 * This is the model class for table "page_translation".
 *
 * The followings are the available columns in table 'page_translation':
 * @property integer $id
 * @property integer $lang_id
 * @property string $title
 * @property string $content
 * @property integer $page_id
 * @property string $sef_title
 */
class PageTranslation extends ContentActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PageTranslation the static model class
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
		return 'page_translation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang_id, title, sef_title', 'required'),
			array('lang_id, page_id', 'numerical', 'integerOnly'=>true),
			array('title, sef_title', 'length', 'max'=>255),
			array('content', 'safe'),
			array('lang_id', 'default', 'value'=>Language::getLanguageIdByCode(Yii::app()->language), 'setOnEmpty'=>true),
			array('lang_id', 'exist', 'className'=>'Language', 'attributeName'=>'id'),
			array('sef_title', 'unique', 'criteria' => array(
				'condition' => 'lang_id=:langId',
				'params' => array(':langId' => $this->lang_id),
			)),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lang_id, title, content, page_id, sef_title', 'safe', 'on'=>'search'),
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
			'page' => array(self::BELONGS_TO, 'Page', 'page_id',),
			'news' => array(self::BELONGS_TO, 'News', 'page_id',),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lang_id' => 'Language',
			'title' => 'Title',
			'content' => 'Content',
			'page_id' => 'Page',
			'sef_title' => 'SEF Title',
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
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('sef_title',$this->sef_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getSelectOptions($language = null, $pageType = Page::TYPE_PAGE)
	{
		$language = ($language === null) ? Language::getLanguageIdByCode(Yii::app()->language) : $language;
		$languageCode = Language::model()->findByPk($language)->code;

		$pages = new CActiveDataProvider('PageTranslation', array(
			'criteria' => array(
				'with'=> array(
					'page' => array(
						'condition' => 'type='.$pageType,
					),
				),
				'together' => true,
				'condition' => 'lang_id=:lang_id',
				'params' => array(
					':lang_id' => $language,
				),
			),
		));
		return CHtml::listData($pages->getData(), function($page) use ($languageCode)
		{
			return Yii::app()->createUrl('page/view', array(
				'title' => $page->sef_title,
				'language' => $languageCode,
			));
		}, 'title');
	}
}
