<?php
/* @var $this AppsettingsController */
/* @var $data Appsettings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('termandcondition')); ?>:</b>
	<?php echo CHtml::encode($data->termandcondition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('policy')); ?>:</b>
	<?php echo CHtml::encode($data->policy); ?>
	<br />


</div>