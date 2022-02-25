$(document).ready(function () {

    $('[type = date]').change(function () {
        $('#subject').val('');
    });

    // Filter by subject
    $('select#subject').change(function () {
        $('#search-journals').submit();
    });

    // Ajax modal journal
    $('a.load-modal-journal').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show')

            // Filter competences
            $('select[name = subject_id]').change(function () {
                $(`select#competence`).val('');
                $(`select#competence *`).removeAttr('selected').attr('hidden', true);
                $(`#summary`).text('');

                $(`select#competence [subject = ${$(this).val()}]`).removeAttr('hidden');
            });

            $('select[name = competence_id]').change(function () {
                $(`#summary`).text($(this).find(':selected').data('summary'));
            });
        });
    });
});