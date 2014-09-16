<?php
/* @var $this AppsettingsController */
/* @var $model Appsettings */

$this->breadcrumbs=array(
	'Appsettings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Appsettings', 'url'=>array('index')),
	array('label'=>'Manage Appsettings', 'url'=>array('admin')),
);
?>

<h1>Create Appsettings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>