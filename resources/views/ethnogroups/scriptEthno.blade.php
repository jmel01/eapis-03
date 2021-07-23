<script type="text/javascript">
    jQuery(document).ready(function() {
        /* To select Ethnographic Group based on selected region */
        jQuery('select[name="region"]').on('change', function() {
            var regionID = $(this).val() ?? $('#regionCode').val();
            if (regionID) {
                jQuery.ajax({
                    url: "{{ route('getEthnoGroups') }}",
                    data: {
                        regionID: regionID
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="ethnoGroup"]').empty();
                        let ethnoGroupID = $('#ethnoGroupID').val()

                        if(ethnoGroupID == ''){
                            $('select[name="ethnoGroup"]').append('<option value="" disabled selected> Select Ethnolinguistic Group </option>');
                        }

                        jQuery.each(data, function(key, value) {
                            let isSelected = ethnoGroupID == value.id ? 'selected' : ''
                            options = '<option '+isSelected+' value="' + value.id + '">' + value.ipgroup + '</option>'
                            $('select[name="ethnoGroup"]').append(options);
                        });

                    }
                });

            } else {
                $('select[name="ethnoGroup"]').empty();
            }
        });

    });
</script>
