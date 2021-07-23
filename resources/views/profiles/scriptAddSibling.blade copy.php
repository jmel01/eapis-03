<script type="text/javascript">

    $("#addSibling").click(function() {
        $("#dynamicSibling").append('<tr>' +
            '<td><input type="text" name="siblingName[]" class="form-control" required></td>' +
            '<td><input type="date" name="siblingBirthdate[]" class="form-control" required></td>' +
            '<td><select name="siblingCivilStatus[]" class="form-control" required>' +
            '<option value="" disabled selected>Select Status</option>' +
            '<option value="Single" {{ old('siblingCivilStatus') ?? ($userProfile->siblingCivilStatus ?? '') =='Single' ? 'selected' : ''}}>Single</option>' +
            '<option value="Married" {{ old('siblingCivilStatus') ?? ($userProfile->siblingCivilStatus ?? '')=='Married' ? 'selected' : ''}}>Married</option>' +
            '<option value="Divorced" {{ old('siblingCivilStatus') ?? ($userProfile->siblingCivilStatus ?? '')=='Divorced' ? 'selected' : ''}}>Divorced</option>' +
            '<option value="Separated" {{ old('siblingCivilStatus') ?? ($userProfile->siblingCivilStatus ?? '')=='Separated' ? 'selected' : ''}}>Separated</option>' +
            '<option value="Widowed" {{ old('siblingCivilStatus') ?? ($userProfile->siblingCivilStatus ?? '')=='Widowed' ? 'selected' : ''}}>Widowed</option>' +
            '</select></td>' +
            '<td><input type="text" name="siblingScholarship[]" class="form-control" required></td>' +
            '<td><input type="text" name="siblingCourse[]" class="form-control" required></td>' +
            '<td><select name="siblingStatus[]" class="form-control" required>' +
            '<option value="" disabled selected>Select Status</option>' +
            '<option value="Stopped">Stopped</option>' +
            '<option value="Undergraduate">Undergraduate</option>' +
            '<option value="Graduated">Graduated</option>' +
            '</select></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm remove-tr">Remove</button></td>' +
            '</tr>');
    });

    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>
