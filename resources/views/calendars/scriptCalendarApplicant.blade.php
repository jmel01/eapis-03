<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            fixedWeekCount: false,
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            footerToolbar: {
                left: '',
                center: '',
                right: 'today,dayGridMonth,listMonth'
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
                $('[name="datestart"]').val(eventObj.start)
                $('[name="dateend"]').val(eventObj.end)
                $('[name="region"]').val(eventObj.extendedProps.region)

                $('#modalShowAnnouncement').modal('show')
            },
            events: [
                @foreach($data as $announcement) {
                    title: '{{ $announcement->title }}',
                    start: '{{ $announcement->dateTimeStart }}',
                    end: '{{ $announcement->dateTimeEnd }}',
                    description: '{{ $announcement->description }}',
                    region: '{{ $announcement->regionname->name }}',
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