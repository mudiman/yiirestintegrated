<?php
/* @var $this AppointmentsController */
/* @var $model Appointments */

//$this->breadcrumbs=array(
//	'Appointments'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Appointments', 'url'=>array('index')),
//	array('label'=>'Manage Appointments', 'url'=>array('admin')),
//);
//?>


<?php $this->renderPartial('_form', array('model'=>$model,
    'providers_array'=>$providers_array,
    'services_array'=>$services_array,
    'workers_array'=>$workers_array,
    'users_array'=>$users_array)); ?>