<?php
/* @var $this AppsettingsController */
/* @var $model Appsettings */

$this->breadcrumbs=array(
	'Appsettings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Appsettings', 'url'=>array('index')),
	array('label'=>'Create Appsettings', 'url'=>array('create')),
	array('label'=>'View Appsettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Appsettings', 'url'=>array('admin')),
);
?>

<h1>Update Appsettings <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>