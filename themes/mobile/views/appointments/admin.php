<?php
/* @var $this AppointmentsController */
/* @var $model Appointments */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Appointments', 'url'=>array('index')),
	array('label'=>'Create Appointments', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#appointments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Appointments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'appointments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'book_datetime',
		'start_datetime',
		'end_datetime',
		'comments',
		'users_id',
		/*
		'providers_id',
		'services_id',
		'workers_id',
		'status',
		'cost',
		'tip',
		'total_cost',
		'rating',
		'feedback',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
