<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            fixedWeekCount: false,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
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
                $.get('calendars/'+info.event.id+'/edit', function(data) {
                    var dateFrom = new Date(data.announcement.dateTimeStart);
                    dateFrom.setMinutes(dateFrom.getMinutes() - dateFrom.getTimezoneOffset());
                    var dateTo = new Date(data.announcement.dateTimeEnd);
                    dateTo.setMinutes(dateTo.getMinutes() - dateTo.getTimezoneOffset());

                    $('[name="id"]').val(data.announcement.id)
                    $('[name="user_id"]').val(data.announcement.user_id)
                    $('[name="dateTimeStart"]').val(dateFrom.toISOString().slice(0, 16))
                    $('[name="dateTimeEnd"]').val(data.announcement.dateTimeEnd == null ? '' : dateTo.toISOString().slice(0, 16))

                    $('[name="title"]').val(data.announcement.title)
                    $('[name="description"]').val(data.announcement.description)
                    $('[name="color"]').val(data.announcement.color)
                    $('[name="region"]').val(data.announcement.region)

                    $('#modalAnnouncement').modal('show')
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
                    $event_date = date($announcement->dateTimeStart);
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