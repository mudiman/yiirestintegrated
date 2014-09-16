<?php
/* @var $this AppointmentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Appointments',
);

$this->menu = array(
    array('label' => 'Create Appointments', 'url' => array('create')),
);
?>

<h1>Appointments</h1>

<?php //$this->widget('zii.widgets.CListView', array('dataProvider'=>$dataProvider,'itemView'=>'_view',)); ?>





<!--        <script type="text/javascript" 
        src="<?php //echo Yii::app()->theme->baseUrl;  ?>/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>-->

<!--<script type="text/javascript" 
src="<?php //echo Yii::app()->theme->baseUrl;  ?>/js/backend_calendar.js"></script>-->



<div id='calendar'></div>

<script type='text/javascript' src='<?php echo Yii::app()->baseUrl ?>/js/moment.min.js'></script>
<link rel="stylesheet" type="text/css"
      href="<?php echo Yii::app()->baseUrl; ?>/css/fullcalendar.css" />
<script type='text/javascript' src='<?php echo Yii::app()->baseUrl ?>/js/fullcalendar.min.js'></script>

<script type="text/javascript">


    $(document).ready(function() {
        $('#calendar').fullCalendar({
            // put your options and callbacks here
        });
    });
</script>