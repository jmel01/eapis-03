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
                    $.get('/calendars/'+info.event.id+'/edit', function(data) {
                    var dateFrom = new Date(data.announcement.dateTimeStart);
                    dateFrom.setMinutes(dateFrom.getMinutes() - dateFrom.getTimezoneOffset());
                    var dateTo = new Date(data.announcement.dateTimeEnd);
                    dateTo.setMinutes(dateTo.getMinutes() - dateTo.getTimezoneOffset());


                $('[name="title"]').val(data.announcement.title)
                $('[name="description"]').val(data.announcement.description)
                $('[name="datestart"]').val(dateFrom.toISOString().slice(0, 16))
                $('[name="dateend"]').val(data.announcement.dateTimeEnd == null ? '' : dateTo.toISOString().slice(0, 16))
                $('[name="region"]').val(data.announcement.region)

                $('#modalShowAnnouncement').modal('show')
                })
            },
            events: [
                @foreach($data as $announcement) {
                    id: '{{ $announcement->id }}',
                    title: '{{ $announcement->title }}',
                    start: '{{ $announcement->dateTimeStart }}',
                    end: '{{ $announcement->dateTimeEnd }}',
                    @php
                    $date_now = date("Y-m-d");
                    $event_date = date($announcement -> dateTimeStart);
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