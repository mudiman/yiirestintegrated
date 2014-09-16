<?php
/* @var $this AppointmentsController */
/* @var $model Appointments */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Appointments', 'url'=>array('index')),
	array('label'=>'Create Appointments', 'url'=>array('create')),
	array('label'=>'Update Appointments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Appointments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Appointments', 'url'=>array('admin')),
);
?>

<h1>View Appointments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'book_datetime',
		'start_datetime',
		'end_datetime',
		'comments',
		'users_id',
		'providers_id',
		'services_id',
		'workers_id',
		'status',
		'cost',
		'tip',
		'total_cost',
		'rating',
		'feedback',
	),
)); ?>
