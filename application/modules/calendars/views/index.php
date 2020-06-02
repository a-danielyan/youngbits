<div id="content" class="table-content">

    <div class="col-lg-8 m-auto" style="float: unset; margin-top: 3%">
        <div id='calendar'></div>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = <?php echo json_encode($calendar) ?>;
       console.log(events.data)
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultDate: '<?= date('Y-m-d')?>',
            navLinks: true, // can click day/week names to navigate views

            weekNumbers: true,
            weekNumbersWithinDays: true,
            weekNumberCalculation: 'ISO',

            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events : events.data
        });
        //console.log('<?php //var_dump($calendar);?>//')

        calendar.render();
    });



</script>
