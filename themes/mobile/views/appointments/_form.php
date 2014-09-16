<?php
/* @var $this AppointmentsController */
/* @var $model Appointments */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/DateTimePicker.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/DateTimePicker.min.js"></script>
<script>
     $(document).ready(function()
        {

          $("#dtBox").DateTimePicker();

        });
 
</script>
<div id="dtBox"></div>
<div class="form">

 
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointments-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'start_datetime'); ?>
		<?php echo $form->textField($model,'start_datetime',array('size'=>45,'maxlength'=>45,'data-field'=>'datetime','readonly'=>true)); ?>
		<?php echo $form->error($model,'start_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_datetime'); ?>
		<?php echo $form->textField($model,'end_datetime',array('size'=>45,'maxlength'=>45,'data-field'=>'datetime','readonly'=>true)); ?>
		<?php echo $form->error($model,'end_datetime'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'providers_id'); ?>
                <?php echo $form->DropDownList($model,'providers_id',$providers_array); ?>
		<?php echo $form->error($model,'providers_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'users_id'); ?>
                <?php echo $form->DropDownList($model,'users_id',$users_array); ?>
		<?php echo $form->error($model,'users_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'services_id'); ?>
                <?php echo $form->DropDownList($model,'services_id',$services_array); ?>
		<?php echo $form->error($model,'services_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'workers_id'); ?>
                <?php echo $form->DropDownList($model,'workers_id',$workers_array); ?>
		<?php echo $form->error($model,'workers_id'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textField($model,'comments',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tip'); ?>
		<?php echo $form->textField($model,'tip'); ?>
		<?php echo $form->error($model,'tip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_cost'); ?>
		<?php echo $form->textField($model,'total_cost'); ?>
		<?php echo $form->error($model,'total_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rating'); ?>
		<?php echo $form->textField($model,'rating'); ?>
		<?php echo $form->error($model,'rating'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'feedback'); ?>
		<?php echo $form->textArea($model,'feedback',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'feedback'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->