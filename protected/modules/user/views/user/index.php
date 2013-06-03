<?php
$this->breadcrumbs=array(
	UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h1><?php echo UserModule::t("List User"); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
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
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
	),
)); ?>
