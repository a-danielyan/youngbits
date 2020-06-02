$(".lead-id-select").select2({
    placeholder: "<?php _trans('lead'); ?>",
    ajax: {
        url: "<?php echo site_url('leads/ajax/name_query'); ?>",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                query: params.term,
                permissive_search_leads: $('input#input_permissive_search_leads').val(),
                page: params.page,
                _ip_csrf: Cookies.get('ip_csrf_cookie')
            };
        },
        processResults: function (data) {
            console.log(data);
            return {
                results: data
            };
        },
        cache: true
    },
    minimumInputLength: 2
});
