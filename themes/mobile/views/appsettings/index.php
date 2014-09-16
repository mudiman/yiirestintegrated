<?php
/* @var $this AppsettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Appsettings',
);

$this->menu=array(
	array('label'=>'Create Appsettings', 'url'=>array('create')),
	array('label'=>'Manage Appsettings', 'url'=>array('admin')),
);
?>

<h1>Appsettings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
