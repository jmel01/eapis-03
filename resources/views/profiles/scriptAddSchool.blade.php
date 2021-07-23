<script type="text/javascript">
    $("#addSchool").click(function() {

        $("#dynamicSchool").append(
            '<div class="card">' +
            '<div class="card-body">' +
            '<div class="row">' +
            '<div class="col-lg-5">' +
            '<div class="form-group">' +
            '<label>School</label>' +
            '<input name="schName[]" type="text" class="form-control"  oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-5">' +
            '<div class="form-group">' +
            '<label>Address</label>' +
            '<input name="schAddress[]" type="text" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-2">' +
            '<div class="form-group">' +
            '<label>Level</label>' +
            '<select name="schLevel[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '<option value="" disabled selected>Please select one</option>' +
            '<option value="Elementary">Elementary</option>' +
            '<option value="High School">High School</option>' +
            '<option value="Vocational">Vocational</option>' +
            '<option value="College">College</option>' +
            '<option value="Masteral">Masteral</option>' +
            '<option value="Doctorate">Doctorate</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Type</label>' +
            '<select name="schType[]" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '<option value="" disabled selected>Please select one</option>' +
            '<option value="Private">Private</option>' +
            '<option value="Public">Public</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Year Graduated</label>' +
            '<input name="schYear[]" type="text" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Average</label>' +
            '<input name="schAve[]" type="text" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-3">' +
            '<div class="form-group">' +
            '<label>Rank</label>' +
            '<input name="schRank[]" type="text" class="form-control" oninput="removeInvalidClass(this)" required>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-12">' +
            '<button type="button" class="btn btn-outline-danger btn-sm float-right remove-school">Remove</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');
    });

    $(document).on('click', '.remove-school', function() {
        var $target = $(this).closest("div.card");
        $target.hide('slow', function() {
            $target.remove();
        });
    });
</script>