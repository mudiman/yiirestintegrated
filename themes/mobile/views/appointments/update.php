<?php
/* @var $this AppointmentsController */
/* @var $model Appointments */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Appointments', 'url'=>array('index')),
	array('label'=>'Create Appointments', 'url'=>array('create')),
	array('label'=>'View Appointments', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Appointments', 'url'=>array('admin')),
);
?>

<h1>Update Appointments <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>