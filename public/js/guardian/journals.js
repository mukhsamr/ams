$(document).ready(function () {

    // Filter competences
    $('select[name = subject_id]').change(function () {
        const id = $(this).data('id');
        $(`select#competence-${id}`).val('');
        $(`select#competence-${id} *`).removeAttr('selected').attr('hidden', true);

        $(`#summary-${id}`).text('');

        const subject = $(`select#subject-${id}`).val();
        const grade = $(`select#sub_grade-${id}`).val();
        console.log(subject, grade);
        $(`select#competence-${id} [subject = ${subject}][grade = ${grade}]`).removeAttr('hidden');
    });

    $('select[name = competence_id]').change(function () {
        const id = $(this).data('id');
        $(`#summary-${id}`).text($(this).find(':selected').data('summary'));
    });

    // Filter by subject
    $('select[name = subject]').change(function () {
        const url = $('form#search-journals').attr('action');
        const subject = $(this).val();

        location.href = [url, subject].join('/');
    });
});