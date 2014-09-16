<?php
/* @var $this AppointmentsController */
/* @var $data Appointments */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('book_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->book_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->start_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->end_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_id')); ?>:</b>
	<?php echo CHtml::encode($data->users_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('providers_id')); ?>:</b>
	<?php echo CHtml::encode($data->providers_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('services_id')); ?>:</b>
	<?php echo CHtml::encode($data->services_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workers_id')); ?>:</b>
	<?php echo CHtml::encode($data->workers_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tip')); ?>:</b>
	<?php echo CHtml::encode($data->tip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_cost')); ?>:</b>
	<?php echo CHtml::encode($data->total_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php echo CHtml::encode($data->rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('feedback')); ?>:</b>
	<?php echo CHtml::encode($data->feedback); ?>
	<br />

	*/ ?>

</div>