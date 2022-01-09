$(document).ready(function () {

    // Filter competences
    $('select[name = subject_id]').change(function () {
        const id = $(this).data('id');
        $(`select#competence-${id}`).val('');
        $(`select#competence-${id} *`).removeAttr('selected').attr('hidden', true);

        $(`select#sub_grade-${id}`).val('');
        $(`select#sub_grade-${id} *`).removeAttr('selected');

        $(`#summary-${id}`).text('');
    });

    $('select[name = sub_grade_id]').change(function () {
        const id = $(this).data('id');
        $(`select#competence-${id}`).val('');
        $(`select#competence-${id} *`).removeAttr('selected').attr('hidden', true);
        $(`#summary-${id}`).text('');

        const subject = $(`select#subject-${id}`).val();
        const grade = $(this).find(':selected').data('grade');

        $(`select#competence-${id} [subject = ${subject}][grade = ${grade}]`).removeAttr('hidden');
    });

    $('select[name = competence_id]').change(function () {
        const id = $(this).data('id');
        $(`#summary-${id}`).text($(this).find(':selected').data('summary'));
    });

    // Filter by subject, subgrade
    $('select[name = subject]').change(function () {
        $('select[name = sub_grade]').val('');
    });

    $('select[name = sub_grade]').change(function () {
        const url = $('form#search-journals').attr('action');
        const subject = $('select[name = subject]').val();
        const subgrade = $(this).val();

        location.href = [url, subject, subgrade].join('/');
    });

    // File size
    $(':file').change(function () {
        const size = this.files[0].size + ' bytes';
        $('#size').text(size);
    });
});