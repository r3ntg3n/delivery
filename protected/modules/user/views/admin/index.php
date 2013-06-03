<?php

?>

<div class="page-header">
    <h1 class="pull-left"><?php echo Yii::t('user', 'Users'); ?></h1>
    <?php echo CHtml::link(Yii::t('user', 'New User'), array('create'), array('class'=>'pull-right btn btn-orange')); ?>
</div>

<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
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
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
