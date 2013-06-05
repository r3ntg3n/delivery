<?php
/* @var $this PageTranslationController */
/* @var $model PageTranslation */

$this->breadcrumbs=array(
	'Page Translations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PageTranslation', 'url'=>array('index')),
	array('label'=>'Manage PageTranslation', 'url'=>array('admin')),
);
?>

<h1>Create PageTranslation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'renderFormTag' => $renderFormTag)); ?>
