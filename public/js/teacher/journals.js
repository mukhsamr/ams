$(document).ready(function () {

    // Filter by subgrade
    $('#subGrade-search').change(function () {
        this.form.submit();
    });

    // Remove subgrade
    $('#subject-search').change(function () {
        $('#subGrade-search').val('');
    });

    // Ajax modal journal
    $('a.load-modal-journal').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show')

            // Filter competences
            $('select#subject').change(function () {
                $(`select#competence`).val('');
                $(`select#competence *`).removeAttr('selected').attr('hidden', true);

                $(`select#sub_grade`).val('');
                $(`select#sub_grade *`).removeAttr('selected');

                $(`#summary`).text('');
            });

            $('select#sub_grade').change(function () {
                $(`select#competence`).val('');
                $(`select#competence *`).removeAttr('selected').attr('hidden', true);
                $(`#summary`).text('');

                const subject = $(`select#subject`).val();
                const grade = $(this).find(':selected').data('grade');

                $(`select#competence [subject = ${subject}][grade = ${grade}]`).removeAttr('hidden');
            });

            $('select#competence').change(function () {
                $(`#summary`).text($(this).find(':selected').data('summary'));
            });
        });
    });
});