<?php
/* @var $this PageTranslationController */
/* @var $model PageTranslation */

$this->breadcrumbs=array(
	'Page Translations'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PageTranslation', 'url'=>array('index')),
	array('label'=>'Create PageTranslation', 'url'=>array('create')),
	array('label'=>'View PageTranslation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PageTranslation', 'url'=>array('admin')),
);
?>

<h1>Update PageTranslation <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'renderFormTag' => $renderFormTag)); ?>
