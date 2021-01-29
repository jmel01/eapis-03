<script type="text/javascript">

    $("#addSibling").click(function() {
        $("#dynamicSibling").append('<tr>' +
            '<td><input type="text" name="siblingName[]" class="form-control" /></td>' +
            '<td><input type="date" name="siblingBirthdate[]" class="form-control" /></td>' +
            '<td><input type="text" name="siblingScholarship[]" class="form-control" /></td>' +
            '<td><input type="text" name="siblingCourse[]" class="form-control" /></td>' +
            '<td><select name="siblingStatus[]" class="form-control">' +
            '<option disabled selected>Select Status</option>' +
            '<option value="Stopped/undergraduate">Stopped/undergraduate</option>' +
            '<option value="Undergraduate/married">Undergraduate/married</option>' +
            '<option value="Graduated/married">Graduated/married</option>' +
            '<option value="Graduated/working(Single)">Graduated/working(Single)</option>' +
            '</select></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm remove-tr">Remove</button></td>' +
            '</tr>');
    });

    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>
