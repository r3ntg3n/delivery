<?php

class BaseActiveRecord extends CActiveRecord
{
    protected function beforeValidate()
    {
        $attributes = array_intersect(
            array('date_created', 'date_updated', 'author'),
            array_keys($this->attributes)
        );

        if (count($attributes))
        {
            foreach ($attributes as $attr)
            {
                $this->setDefaultAttrValue($attr);
            }
        }

        return parent::beforeValidate();
    }

    protected function setDefaultAttrValue($attrName)
    {
        switch ($attrName)
        {
        case 'author':
            $this->$attrName = Yii::app()->user->id;
            break;
        case 'date_updated':
            $this->$attrName = new CDbExpression('NOW()');
            if ($this->isNewRecord)
            {
                $this->date_created = $this->$attrName;
            }
            break;
        }
    }

}

