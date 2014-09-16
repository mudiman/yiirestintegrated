<?php
/* @var $this AppointmentsController */
/* @var $dataProvider CActiveDataProvider */


$this->menu = array(
    array('label' => 'Create Appointments', 'url' => array('create')),
    array('label' => 'Manage Appointments', 'url' => array('admin')),
);
?>

<?php //$this->widget('zii.widgets.CListView', array('dataProvider'=>$dataProvider,'itemView'=>'_view',));  ?>
<script type='text/javascript' src='<?php echo Yii::app()->baseUrl ?>/js/moment.min.js'></script>
<link rel="stylesheet" type="text/css"
      href="<?php echo Yii::app()->baseUrl; ?>/css/fullcalendar.css" />
<script type='text/javascript' src='<?php echo Yii::app()->baseUrl ?>/js/fullcalendar.min.js'></script>




<!--        <script type="text/javascript" 
        src="<?php //echo Yii::app()->theme->baseUrl;  ?>/js/libs/jquery/jquery-ui-timepicker-addon.js"></script>-->

<!--<script type="text/javascript" 
src="<?php //echo Yii::app()->theme->baseUrl;  ?>/js/backend_calendar.js"></script>-->



<div id='calendar'></div>


<script type="text/javascript">

    $(document).ready(function() {
        $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
                        dayClick: function(date, jsEvent, view) {
                              //alert('Clicked on: ' + date.format());
//                            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//                            alert('Current view: ' + view.name);
                            window.location=window.BASEURL+"/appointments/create?appointmentdate="+date.format();
//                            // change the day's background color just for fun
//                            $(this).css('background-color', 'red');

                        },
                        eventClick: function(calEvent, jsEvent, view) {

                            alert('Event: ' + calEvent.title);
                            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                            alert('View: ' + view.name);

                            // change the border color just for fun
                            $(this).css('border-color', 'red');

                        },
			defaultDate: '2014-08-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2014-08-01'
				},
				{
					title: 'Long Event',
					start: '2014-08-07',
					end: '2014-08-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2014-08-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2014-08-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2014-08-11',
					end: '2014-08-13'
				},
				{
					title: 'Meeting',
					start: '2014-08-12T10:30:00',
					end: '2014-08-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2014-08-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2014-08-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2014-08-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2014-08-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2014-08-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2014-08-28'
				}
			]
		});
    });
</script>