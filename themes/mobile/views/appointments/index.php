<?php
/* @var $this AppointmentsController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Appointments',
//);
//
//$this->menu=array(
//	array('label'=>'Create Appointments', 'url'=>array('create')),
//	array('label'=>'Manage Appointments', 'url'=>array('admin')),
//);
?>

<h1>Appointments</h1>

<?php //$this->widget('zii.widgets.CListView', array('dataProvider'=>$dataProvider,'itemView'=>'_view',)); ?>





<!--        <script type="text/javascript" 
        src="<?php //echo Yii::app()->theme->baseUrl; ?>/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>-->
        
<!--<script type="text/javascript" 
        src="<?php //echo Yii::app()->theme->baseUrl; ?>/js/backend_calendar.js"></script>-->
        


<div id='calendar'></div>


<script type="text/javascript">    

    
    $(document).ready(function() {
         $('#calendar').fullCalendar({
        // put your options and callbacks here
        'buttonText': {
            	'today': EALang['today'],
            	'day': EALang['day'],
            	'week': EALang['week'],
            	'month': EALang['month']
            },
        });
    });
</script>