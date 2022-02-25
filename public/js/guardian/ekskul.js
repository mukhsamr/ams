$(document).ready(function () {
    // Ajax modal
    $('a.load-modal-ekskul').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show');

            // Filter predicate
            $(':checkbox').change(function () {
                const target = $(this).attr('id');
                const prop = $(this).prop('checked');

                $(target).attr('disabled', !prop);
            });
        });
    });
});