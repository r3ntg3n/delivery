<?php
/* @var $this MenuItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Menu Items',
);

$this->menu=array(
	array('label'=>'Create MenuItem', 'url'=>array('create', 'menu'=>$menu->id)),
	array('label'=>'Manage MenuItem', 'url'=>array('admin', 'menu'=>$menu->id)),
);
?>

<h1>Menu Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
