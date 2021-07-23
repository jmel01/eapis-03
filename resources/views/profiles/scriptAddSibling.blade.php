<script type="text/javascript">
    $("#addSibling").click(function() {
        $("#dynamicSibling").append(
            '<div class="card">' +
            '<div class="card-body">' +
            '<div class="row">' +
            '<div class="col-lg-6">' +
            '<div class="form-group">' +
            '<label>Name</label>' +
            '<input type="text" name="siblingName[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Birthdate</label>' +
            '<input type="date" name="siblingBirthdate[]" class="form-control" oninput="removeInvalidClass(this)">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Civil Status</label>' +
            '<select name="siblingCivilStatus[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '<option value="" disabled selected>Select Status</option>' +
            '<option value="Single">Single</option>' +
            '<option value="Married">Married</option>' +
            '<option value="Divorced">Divorced</option>' +
            '<option value="Separated">Separated</option>' +
            '<option value="Widowed">Widowed</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-lg-4">' +
            '<div class="form-group">' +
            '<label>Scholarship (if any)</label>' +
            '<input type="text" name="siblingScholarship[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-4">' +
            '<div class="form-group">' +
            '<label>Course/Year Level</label>' +
            '<input type="text" name="siblingCourse[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-4">' +
            '<div class="form-group">' +
            '<label>Present Status</label>' +
            '<select name="siblingStatus[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '<option value="" disabled selected>Please select one</option>' +
            '<option value="Stopped">Stopped</option>' +
            '<option value="Undergraduate">Undergraduate</option>' +
            '<option value="Graduated">Graduated</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-12">' +
            '<button type="button" class="btn btn-outline-danger btn-sm float-right remove-sibling">Remove</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');
    });

    $(document).on('click', '.remove-sibling', function() {
        var $target = $(this).closest("div.card");
        $target.hide('slow', function() {
            $target.remove();
        });
    });
</script>