<?php echo CHtml::openTag($this->menuElement, array(
	'class' => isset($menuClass) ? $menuClass : $this->menuClass,
)); ?>

	<?php foreach($items as $item)
		{
			echo CHtml::openTag($this->itemElement);
			echo $item['text'];
			if ($item['children'] !== null)
			{
				$this->render('MenuWidget', array(
					'items' => $item['children'],
					'menuClass' => $this->childrenClass,
				));
			}
			echo CHtml::closeTag($this->itemElement);
		}
	?>

<?php echo CHtml::closeTag($this->menuElement); ?>
