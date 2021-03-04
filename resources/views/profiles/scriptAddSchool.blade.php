<script type="text/javascript">
    $("#addSchool").click(function() {
        
        $("#dynamicSchool").append('<tr> ' +
            '<td><input name="schName[]" type="text" class="form-control" required></td>' +
            '<td><input name="schAddress[]" type="text" class="form-control" required></td>' +
            '<td><select name="schLevel[]" class="form-control" required>' +
            '<option value="" disabled selected>Please select one</option>' +
            '<option value="Elementary">Elementary</option>' +
            '<option value="High School">High School</option>' +
            '<option value="Vocational">Vocational</option>' +
            '<option value="College/Undergraduate">College/Undergraduate</option>' +
            '<option value="Post Graduate">Post Graduate</option>' +
            '<option value="Masteral">Masteral</option>' +
            '<option value="Doctorate">Doctorate</option>' +
            '</select></td>' +
            '<td><select name="schType[]" class="form-control" required>' +
            '<option value="" disabled selected>Please select one</option>' +
            '<option value="Private">Private</option>' +
            '<option value="Public">Public</option>' +
            '</select></td>' +
            '<td><input name="schYear[]" type="number" step="1" min="1980" max="2030" class="form-control"required></td>' +
            '<td><input name="schAve[]" type="number" step=".01" min="0" max="100" class="form-control" required></td>' +
            '<td><input name="schRank[]" type="text" class="form-control" required></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm remove-tr-school">Remove</button></td>' +
            '</tr>');
    });

    $(document).on('click', '.remove-tr-school', function() {
        $(this).parents('tr').remove();
    });
</script>
