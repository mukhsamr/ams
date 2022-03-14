$(document).ready(function () {
    // Ajax modal
    $('a.load-modal-spiritual').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show');

            // Filter checkbox
            $(':checkbox').change(function () {
                const id = $(this).attr('id');
                const prop = $(this).prop('checked');

                $(`#sel`).val('');
                $(`#sel > #opt-${id}`).attr('hidden', prop);
            });
        });
    });
});