<div class="well filter">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'htmlOptions'=>array(
        'class'=>'form-grid stripe-background',
    ),
)); ?>

    <table>
        <tr>
            <td>
                <?php echo $form->label($model,'username'); ?>
                <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
            </td>

            <td>
                <?php echo $form->label($model,'email'); ?>
                <?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>128)); ?>
            </td>

            <td>
                <?php echo $form->label($model,'superuser'); ?>
                <?php echo $form->dropDownList($model,'superuser',$model->itemAlias('AdminStatus'), array('class'=>'custom-dropdown')); ?>
            </td>

            <td>
                <?php echo $form->label($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status',$model->itemAlias('UserStatus'), array('class'=>'custom-dropdown')); ?>
            </td>
        </tr>
    </table>

    <div class="button-group pull-right">
        <?php echo CHtml::resetButton(Yii::t('default','Reset fitler'), array('class'=>'btn')); ?>
        <?php echo CHtml::submitButton(UserModule::t('Search'), array('class'=>'btn btn-orange')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
