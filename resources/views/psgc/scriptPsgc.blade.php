<script type="text/javascript">
    jQuery(document).ready(function() {
        /* To select provinces/district based on selected region */
        jQuery('select[name="region"]').on('change', function() {
            var regionID = $('#region').val();
            if (regionID) {
                jQuery.ajax({
                    url: "{{ route('getProvinces') }}",
                    data: {
                        regionID: regionID
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="province"]').empty();
                        jQuery('select[name="city"]').empty();
                        jQuery('select[name="barangay"]').empty();
                        let provinceCode = $('#provinceCode').val()

                        if(provinceCode == ''){
                            $('select[name="province"]').append('<option disabled selected> Select Province/District </option>');
                        }

                        jQuery.each(data, function(key, value) {
                            let isSelected = provinceCode == value.code ? 'selected' : ''
                            options = '<option '+isSelected+' value="' + value.code + '">' + value.name + '</option>'
                            $('select[name="province"]').append(options);
                            if(isSelected == 'selected'){
                                $('#province').trigger("change")
                            }
                        });

                    }
                });

            } else {
                $('select[name="province"]').empty();
            }
        });

        /* To select cities/municipalities/sub-municipalities based on selected province */
        jQuery('select[name="province"]').on('change', function() {
            var provinceID = $(this).val();
            if (provinceID) {
                jQuery.ajax({
                    url: "{{ route('getCities') }}",
                    data: {
                        provinceID: provinceID
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="city"]').empty();
                        jQuery('select[name="barangay"]').empty();
                        let cityCode = $('#cityCode').val()
                        if(cityCode == ''){
                            $('select[name="city"]').append('<option disabled selected>Select City/Municipality/Sub-Municipality</option>');
                        }
                        jQuery.each(data, function(key, value) {
                            let isSelected = cityCode == value.code ? 'selected' : ''
                            options = '<option '+isSelected+' value="' + value.code + '">' + value.name + '</option>'
                            $('select[name="city"]').append(options);

                            if(isSelected == 'selected'){
                                $('#city').trigger("change")
                            }
                        });
                    }
                });
            } else {
                $('select[name="city"]').empty();
            }
        });

        /* To select barangay based on selected city */
        jQuery('select[name="city"]').on('change', function() {
            var cityID = jQuery(this).val();
            if (cityID) {
                jQuery.ajax({
                    url: "{{ route('getBrgy') }}",
                    data: {
                        cityID: cityID
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="barangay"]').empty();
                        let brgyCode = $('#barangayCode').val()
                        if(brgyCode == ''){
                            $('select[name="barangay"]').append('<option disabled selected>Select Barangay</option>');
                        }
                        jQuery.each(data, function(key, value) {
                            let isSelected = brgyCode == value.code ? 'selected' : ''
                            options = '<option '+isSelected+' value="' + value.code + '">' + value.name + '</option>'
                            $('select[name="barangay"]').append(options);
                        });
                    }
                });
            } else {
                $('select[name="barangay"]').empty();
            }
        });
    });
</script>
