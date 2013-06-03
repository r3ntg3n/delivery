<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="page-header">
    <h1><?php echo UserModule::t("Restore"); ?></h1>
</div>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<?php echo CHtml::beginForm('', 'post', array('class'=>'form-horizontal')); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($form,'login_or_email',array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo CHtml::activeTextField($form,'login_or_email') ?>
            <p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
		</div>
	</div>
	
	<div class="well table-footer no-shadow">
		<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class'=>'btn btn-orange pull-right')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
<?php endif; ?>
