<?php
/* @var $this MenuController */
/* @var $data Menu */
?>

<div class="view">

	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<?php echo ($data->active) ? CHtml::encode(Yii::t('default', 'Active')) : CHtml::encode(Yii::t('default', 'Inactive')); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>
