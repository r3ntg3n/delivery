<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lang_id'); ?>
		<?php echo $form->dropDownList(
			$model,
			'lang_id',
			CHtml::listData(Language::model()->findAll(), 'id', 'name'),
			array(
				'empty' => 'Select a language',
				'ajax' => array(
					'data' => array(
						'langId' => 'js:this.value'
					),
					'type' => 'GET',
					'url' => $this->createUrl('pageTranslation/linkOptions'),
					'update' => 'select#MenuItem_link',
				),
			)
		); ?>
		<?php echo $form->error($model,'lang_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textField($model,'caption',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'link'); ?>
		Or select a page:
		<?php echo $form->dropDownList($model, 'link',
			PageTranslation::getSelectOptions(
				((!$model->isNewRecord)
				? $model->lang_id
				: null)
			),
			array(
				'empty' => Yii::t('default', 'Select a page'),
			)
		); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->checkbox($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

<?php
    if (MenuItem::parentsExist($model->menu_id)):
?>
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',
			MenuItem::getPossibleParents($model->menu_id),
			array(
				'empty' => Yii::t('menuitem', 'Select a parent item'),
			)
		); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>
<?php
	endif;
?>

	<div class="row">
		<?php echo $form->labelEx($model,'access_level'); ?>
		<?php echo $form->textField($model,'access_level'); ?>
		<?php echo $form->error($model,'access_level'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
