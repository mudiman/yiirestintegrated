<?php
/* @var $this AppsettingsController */
/* @var $model Appsettings */

$this->breadcrumbs=array(
	'Appsettings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Appsettings', 'url'=>array('index')),
	array('label'=>'Create Appsettings', 'url'=>array('create')),
	array('label'=>'Update Appsettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Appsettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Appsettings', 'url'=>array('admin')),
);
?>

<h1>View Appsettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'termandcondition',
		'policy',
	),
)); ?>
