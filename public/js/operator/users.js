$(document).ready(function () {
    // Ajax modal
    $('a.load-modal-user').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show');

            // Password default
            $(':checkbox[types = default]').change(function () {
                const prop = $(this).prop('checked');
                $('#password').attr('disabled', prop);
            });

            // Password not change
            $(':checkbox[types = not]').change(function () {
                const prop = $(this).prop('checked');
                $('#password').attr('disabled', prop);
                $('#default').attr('disabled', prop).prop('checked', false);
            });

            // Set datalist value and make username
            // $('[name = userable_id]').val($(`option[value = '${$('#users').val()}']`).data('value'));
            // $('#users').change(function () {
            //     var value = $(this).val();

            //     // Datalist value
            //     $('[name = userable_id]').val($(`option[value = '${value}']`).data('value'));

            //     // Username
            //     const slug = value.replace(/\u00a0/g, '.').toLowerCase();
            //     $('#username').val(slug);
            // });
        });
    });

});