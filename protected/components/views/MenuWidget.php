<?php echo CHtml::openTag('ul', array(
	'class' => $menuClass,
)); ?>

	<?php foreach($items as $item)
		{
			echo CHtml::openTag('li');
			echo $item['text'];
			echo CHtml::closeTag('li');
		}
	?>

<?php echo CHtml::closeTag('ul'); ?>
