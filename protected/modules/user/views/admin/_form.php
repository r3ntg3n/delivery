
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
            <?php echo $form->error($model,'username'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
            <?php echo $form->error($model,'password'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
            <?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'superuser',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>'custom-dropdown')); ?>
            <?php echo $form->error($model,'superuser'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'status',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>'custom-dropdown')); ?>
            <?php echo $form->error($model,'status'); ?>
		</div>
	</div>
<?php 
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="control-group">
		<?php echo $form->labelEx($profile,$field->varname,array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
            if ($widgetEdit = $field->widgetEdit($profile)) {
                echo $widgetEdit;
            } elseif ($field->range) {
                echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
                echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
            } else {
                echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
            }
             ?>
            <?php echo $form->error($profile,$field->varname); ?>
        </div>
	</div>
			<?php
			}
		}
?>
	<div class="well table-footer no-shadow">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'),array('class'=>'btn btn-orange pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

