<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Manage'),
);
?>

<div class="page-header">
    <h1 class="pull-left"><?php echo UserModule::t('Manage Profile Fields'); ?></h1>
    <?php echo CHtml::link(UserModule::t('Create Profile Field'), array('create'), array('class'=>'pull-right btn btn-orange')); ?>
</div>

<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
    'cssFile' => '',
    'itemsCssClass' => 'table table-bordered table-centered no-margin',
    'summaryCssClass' => 'records pull-right',
    'pagerCssClass' => 'pagination pull-left',
    'pager'=>array(
        'cssFile' => '',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'header'=>'',
    ),
    'template' => '
        <div class="well table-header no-shadow">
            <div>
                {pager}
                {summary}
            </div>
        </div>
        {items}
        <div class="well table-footer no-shadow no-margin">
            {pager}
        </div>
    ',
	'columns'=>array(
		'id',
		array(
			'name'=>'varname',
			'type'=>'raw',
			'value'=>'UHtml::markSearch($data,"varname")',
		),
		array(
			'name'=>'title',
			'value'=>'UserModule::t($data->title)',
		),
		array(
			'name'=>'field_type',
			'value'=>'$data->field_type',
			'filter'=>ProfileField::itemAlias("field_type"),
		),
		'field_size',
		//'field_size_min',
		array(
			'name'=>'required',
			'value'=>'ProfileField::itemAlias("required",$data->required)',
			'filter'=>ProfileField::itemAlias("required"),
		),
		//'match',
		//'range',
		//'error_message',
		//'other_validator',
		//'default',
		'position',
		array(
			'name'=>'visible',
			'value'=>'ProfileField::itemAlias("visible",$data->visible)',
			'filter'=>ProfileField::itemAlias("visible"),
		),
		//*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
