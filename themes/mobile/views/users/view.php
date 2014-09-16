<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
//	array('label'=>'Create Users', 'url'=>array('create')),
//	array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Users', 'url'=>array('admin')),
//);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		//'password',
		'email',
                array(        
                     'name'=>'profile_photo',
                     'type'=>'image',
                     'value'=> Yii::app()->getBaseUrl(true).str_replace("/../", "/", Yii::app()->params->userImages).$model->profile_photo,
                ),
		'created_at',
		'first_name',
		'last_name',
		'mobile_number',
		'phone_number',
		'address',
		'city',
		'zip_code',
		
		'comments',
		
	),
)); ?>
