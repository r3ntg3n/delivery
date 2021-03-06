<?php

/**
 * This is the model class for table "language".
 *
 * The followings are the available columns in table 'language':
 * @property integer $id
 * @property string $code
 * @property string $name
 */
class Language extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Language the static model class
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
		return 'language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('code', 'length', 'max'=>2),
			array('name', 'length', 'max'=>40),
            array('default', 'boolean'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, default', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'name' => 'Name',
            'default' => 'System\'s default',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('default',$this->default,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns language ID from two leters code
	 * @param string language two letter code
	 * @return integer language ID
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 0.1.alpha
	 */
	public static function getLanguageIdByCode($code)
	{
		$res = self::model()
			->findByAttributes(array('code'=>$code))
			->getAttributes(array('id'));
		return $res['id'];
	}

	/**
	 * Returns default language model
	 * @return object Language model instance
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 0.1.alpha
	 */
	public static function getDefaultLanguage()
	{
		return self::model()->findByAttributes(array('default'=>1));
	}
}
