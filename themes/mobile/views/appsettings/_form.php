<?php
/* @var $this AppsettingsController */
/* @var $model Appsettings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appsettings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'termandcondition'); ?>
		<?php echo $form->textArea($model,'termandcondition',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'termandcondition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'policy'); ?>
		<?php echo $form->textArea($model,'policy',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'policy'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->