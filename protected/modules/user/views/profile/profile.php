<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
);
?><h1><?php echo UserModule::t('Your profile'); ?></h1>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<?php 
    $attributes = array('username');
    $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
    if ($profileFields) {
        foreach($profileFields as $field) {
            array_push($attributes, array(
                'name'=>CHtml::encode($field->title),
                'type'=>'raw',
                'value'=>(
                    ($field->widgetView($profile))
                    ? $field->widgetView($profile)
                    : CHtml::encode(
                        (
                            ($field->range)
                            ? Profile::range($field->range, $profile->getAttribute($field->varname))
                            : $profile->getAttribute($field->varname)
                        )
                    )
                ),
            ));
        }
    }
    $attributes = array_merge($attributes, array(
        'email',
        'create_at',
        'lastvisit_at',
        array(
            'name' => 'status',
            'value' => User::itemAlias('UserStatus', $model->status)
        ),
    ));
?>
<?php 
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'cssFile' => '',
    'attributes' => $attributes,
)); ?>
