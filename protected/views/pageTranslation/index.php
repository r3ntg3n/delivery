<?php
/* @var $this PageTranslationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Page Translations',
);

$this->menu=array(
	array('label'=>'Create PageTranslation', 'url'=>array('create')),
	array('label'=>'Manage PageTranslation', 'url'=>array('admin')),
);
?>

<h1>Page Translations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
