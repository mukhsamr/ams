$(document).ready(function () {
    // Search
    $('#search').keyup(function (e) {
        const value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Password default
    $(':checkbox[types = default]').change(function () {
        const prop = $(this).prop('checked');
        const id = $(this).data('id');
        $('#password-' + id).attr('disabled', prop);
    });

    // Password not change
    $(':checkbox[types = not]').change(function () {
        const prop = $(this).prop('checked');
        const id = $(this).data('id');
        $('#password-' + id).attr('disabled', prop);
        $('#default-' + id).attr('disabled', prop).prop('checked', false);
    });

    // Set datalist value and make username
    $('[name = userable_id]').val($(`option[value = '${$('#users').val()}']`).data('value'));
    $('#users').change(function () {
        var value = $(this).val();

        // Datalist value
        $('[name = userable_id]').val($(`option[value = '${value}']`).data('value'));

        // Username
        const slug = value.replace(/\u00a0/g, '.').toLowerCase();
        $('#username').val(slug);
    });
});