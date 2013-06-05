<?php
/* @var $this PageTranslationController */
/* @var $model PageTranslation */
/* @var $form CActiveForm */
?>

<?php if (!empty($renderFormTag)): ?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'page-translation-form',
	'enableAjaxValidation' => false,
));?>
<?php endif; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lang_id'); ?>
		<?php echo $form->dropDownList(
			$model,
			'lang_id',
			CHtml::listData(Language::model()->findAll(), 'id', 'name'),
			array(
				'empty' => Yii::t('language', 'Select a Language'),
				'ajax' => (
					!$parent->isNewRecord
					? array(
						'type' => 'GET',
						'url' => $this->createUrl('pageTranslation/json'),
						'data' => array(
							'languageId' => 'js:this.value',
							'pageId' => $parent->id,
						),
						'success' => 'function(data) {
							res = jQuery.parseJSON(data);
							jQuery("input#PageTranslation_title").attr("value", res.title);
							jQuery("textarea#PageTranslation_content").html(res.content);
							jQuery("input#PageTranslation_sef_title").attr("value", res.sef_title);
						}',
					)
					: null
				),
			)
		); ?>
		<?php echo $form->error($model,'lang_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sef_title'); ?>
		<?php echo $form->textField($model,'sef_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'sef_title'); ?>
	</div>

<?php if (!empty($renderFormTag)): ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div>
<?php endif; ?>
