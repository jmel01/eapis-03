<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            fixedWeekCount: false,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            slotMinTime: "8:00:00",
            slotMaxTime: "18:00:00",
            businessHours: {
                // days of week. an array of zero-based day of week integers (0=Sunday)
                daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday

                startTime: '8:00', // a start time
                endTime: '17:00', // an end time
            },
            //eventMouseEnter: function(info) {
            eventClick: function(info) {

                var eventObj = info.event;

                $('[name="title"]').val(eventObj.title)
                $('[name="description"]').val(eventObj.extendedProps.description)
                $('[name="date"]').val(eventObj.start.toDateString())

                $('#modalShowAnnouncement').modal('show')
            },
            events: [
                @foreach($data as $announcement) {
                    title: '{{ $announcement->title }}',
                    start: '{{ $announcement->dateTimeStart }}',
                    end: '{{ $announcement->dateTimeEnd }}',
                    description: '{{ $announcement->description }}',
                    @php
                    $date_now = date("Y-m-d");
                    $event_date = date($announcement -> dateTimeEnd);
                    if ($date_now > $event_date) {
                        echo "color:'red'";
                    } else {
                        echo "color:'$announcement->color'";
                    }
                    @endphp
                },
                @endforeach
            ]
        });
        calendar.render();
    });
</script>