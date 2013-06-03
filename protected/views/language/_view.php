<?php
/* @var $this LanguageController */
/* @var $data Language */
?>

<div class="view">

	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>

	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('default')); ?>:</b>
	<?php echo $data->default ? Yii::t('yii', 'Yes') : Yii::t('yii', 'No'); ?>
	<br />


</div>
