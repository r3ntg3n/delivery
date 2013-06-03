<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
?>

<div class="well input-large dialog">

    <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
    
    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>
    
    <?php endif; ?>
    
    <div class="form">
    <?php echo CHtml::beginForm('', 'post', array('class'=>'form')); ?>
    
        <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
        
        <?php echo CHtml::errorSummary($model); ?>
        
        <div class="row">
            <?php echo CHtml::activeLabelEx($model,'username'); ?>
            <?php echo CHtml::activeTextField($model,'username') ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::activeLabelEx($model,'password'); ?>
            <?php echo CHtml::activePasswordField($model,'password') ?>
        </div>
        
        <div class="row">
            <p class="hint">
            <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>
        
        <div class="row">
            <?php echo CHtml::tag('label', array('class'=>'checkbox no-margin'),
                CHtml::activeCheckBox($model,'rememberMe', array('class'=>'custom-checkbox')) . 
                $model->getAttributeLabel('rememberMe'),
            true); ?>
        </div>
    
        <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btn-orange pull-right')); ?>
        </div>
        
    <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
    
    
    <?php
    $form = new CForm(array(
        'elements'=>array(
            'username'=>array(
                'type'=>'text',
                'maxlength'=>32,
            ),
            'password'=>array(
                'type'=>'password',
                'maxlength'=>32,
            ),
            'rememberMe'=>array(
                'type'=>'checkbox',
            )
        ),
    
        'buttons'=>array(
            'login'=>array(
                'type'=>'submit',
                'label'=>'Login',
            ),
        ),
    ), $model);
    ?>
</div>
