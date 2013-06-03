<div class="well filter">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'htmlOptions' => array(
        'class' => 'form-grid stripe-background',
    ),
)); ?>

    <table>
        <tr>
            <td>
                <?php echo $form->label($model,'varname'); ?>
                <?php echo $form->textField($model,'varname',array('size'=>20,'maxlength'=>50)); ?>
            </td>
    
            <td>
                <?php echo $form->label($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('size'=>20,'maxlength'=>255)); ?>
            </td>
    
            <td>
                <?php echo $form->label($model,'field_type'); ?>
                <?php echo $form->dropDownList($model,'field_type',ProfileField::itemAlias('field_type'), array('class'=>'custom-dropdown')); ?>
            </td>
            <td>
                <?php echo $form->label($model,'field_size'); ?>
                <?php echo $form->textField($model,'field_size'); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $form->label($model,'field_size_min'); ?>
                <?php echo $form->textField($model,'field_size_min'); ?>
            </td>
    
            <td>
                <?php echo $form->label($model,'required'); ?>
                <?php echo $form->dropDownList($model,'required',ProfileField::itemAlias('required'), array('class'=>'custom-dropdown')); ?>
            </td>
    
            <td>
                <?php echo $form->label($model,'visible'); ?>
                <?php echo $form->dropDownList($model,'visible',ProfileField::itemAlias('visible'), array('class'=>'custom-dropdown')); ?>
            </td>
        </tr>
</table>

    <div class="button-group pull-right">
        <?php echo CHtml::resetButton(Yii::t('default','Reset filter'), array('class'=>'btn')); ?>
        <?php echo CHtml::submitButton(UserModule::t('Search'), array('class'=>'btn btn-orange')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form --> 
