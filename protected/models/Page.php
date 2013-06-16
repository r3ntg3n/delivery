<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $author
 * @property integer $type
 */
class Page extends BaseActiveRecord
{
    /**
     * @const integer record type PAGE
     */
    const TYPE_PAGE = 1;

    /**
     * @const integer record type NEWS
     */
    const TYPE_NEWS = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Page the static model class
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
		return 'page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'default', 'value'=>self::TYPE_PAGE, 'setOnEmpty'=>true),
			array('date_created, date_updated, author, type', 'required'),
			array('author, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_created, date_updated, author, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.

		$languageId = Language::getLanguageIdByCode(Yii::app()->language);
		return array(
			'translation' => array(self::HAS_ONE, 'PageTranslation', 'page_id', 'on' => "lang_id='{$languageId}'"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'author' => 'Author',
			'type' => 'Type',
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
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('author',$this->author);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	/**
	 * Prepares a PageTranslation model for the page
	 * @param integer language id
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 0.1.1
	 */
	public function prepareTranslation($language = null)
	{
		$language = ($language === null)
			? Language::getLanguageIdByCode(Yii::app()->language) 
			: $language;
		if ($this->isNewRecord)
		{
			$this->buildNewTranslation($language);
		}
		else
		{
			$this->loadTranslation($language);
		}
	}

	/**
	 * Builds a new page translation for selected language
	 * @param integer language ID to build translation for
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 0.1.alpha
	 */
	private function buildNewTranslation($language)
	{
		$this->translation = new PageTranslation;
		$this->translation->lang_id = $language;
	}

	/**
	 * Loads a page translation for seleted language
	 * @param integer language id
	 * @author Ievgenii Dytyniuk<i.dytyniuk@gmail.com>
	 * @version 0.1.alpha
	 */
	private function loadTranslation($language)
	{
		$this->translation = PageTranslation::model()->findByAttributes(array(
			'lang_id' => $language,
			'page_id' => $this->id,
		));
		if ($this->translation === null)
		{
			$this->buildNewTranslation($language);
			$this->translation->page_id = $this->id;
		}
	}

    /**
     * Returns supported page types
     *
     * @return array page types
     */
    public static function getSupportedPageTypes()
    {
        return array(
            self::TYPE_PAGE => Yii::t('page', 'Page'),
            self::TYPE_NEWS => Yii::t('page', 'News'),
        );
    }

	/**
	 * Override parent method to fill findAll and similat methods results with proper models
	 *
	 * @param array $attributes
	 * @return Page object
	 *
	 * @author Ievgenii Dytyniuk<i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	protected function instantiate($attributes)
	{
		switch ($attributes['type'])
		{
		case self::TYPE_NEWS:
			$class = 'News';
			break;
		default:
			$class = get_class($this);
		}
		$model = new $class(null);
		return $model;
	}

	/**
	 * Set defaultScope query params
	 * to select only records with type=self::TYPE_PAGE
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 */
	public function defaultScope()
	{
		return array(
			'condition' => 'type='.self::TYPE_PAGE,
		);
	}
}
