<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<div class="page-header">
    <h1><?php echo UserModule::t("Registration"); ?></h1>
</div>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data', 'class' => 'form-horizontal'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo $form->errorSummary(array($model,$profile)); ?>
	
	<div class="control-group">
        <?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
	</div>
	
	<div class="control-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint">
                <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>
        </div>
	</div>
	
	<div class="control-group">
        <?php echo $form->labelEx($model,'verifyPassword',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'verifyPassword'); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>
	</div>
	
	<div class="control-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
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
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range), array('class'=>'custom-dropdown'));
		} elseif ($field->field_type=="TEXT") {
			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>50,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
        </div>
	</div>	
			<?php
			}
		}
?>
	<?php if (UserModule::doCaptcha('registration')): ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'verifyCode',array('class'=>'control-label')); ?>
		
        <div class="controls">
            <?php $this->widget('CCaptcha'); ?>
            <br/>
            <?php echo $form->textField($model,'verifyCode'); ?>
            <?php echo $form->error($model,'verifyCode'); ?>
            <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
            <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
        </div>
		
	</div>
	<?php endif; ?>
	
	<div class="well table-footer no-shadow">
		<?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn btn-orange pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>
