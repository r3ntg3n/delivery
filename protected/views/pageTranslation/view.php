<?php
/* @var $this PageTranslationController */
/* @var $model PageTranslation */

$this->breadcrumbs=array(
	'Page Translations'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List PageTranslation', 'url'=>array('index')),
	array('label'=>'Create PageTranslation', 'url'=>array('create')),
	array('label'=>'Update PageTranslation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PageTranslation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PageTranslation', 'url'=>array('admin')),
);
?>

<h1>View PageTranslation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lang_id',
		'title',
		'content',
		'page_id',
		'sef_title',
	),
)); ?>
