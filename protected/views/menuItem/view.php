<?php
/* @var $this MenuItemController */
/* @var $model MenuItem */

$this->breadcrumbs=array(
	'Menu Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MenuItem', 'url'=>array('index', 'menu'=>$model->menu_id)),
	array('label'=>'Create MenuItem', 'url'=>array('create', 'menu'=>$model->menu_id)),
	array('label'=>'Update MenuItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenuItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Menu Items', 'url'=>array('admin', 'menu'=>$model->menu_id)),
	array('label'=>'Add Child Item', 'url'=>array('create', 'menu'=>$model->menu_id, 'parent'=>$model->id)),
);
?>

<h1>View MenuItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'menu_id',
		'lang_id',
		'caption',
		'link',
		'active',
		'parent_id',
		'level',
		'path',
		'access_level',
	),
)); ?>
