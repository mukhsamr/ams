$(document).ready(function () {
    $('select#subject').change(function () {
        $('select#grade').val('');
    });
    $('select#grade').change(function () {
        const url = $('form#search-competences').attr('action');
        const subject = $('#subject').val();
        const grade = $('#grade').val();

        location.href = [url, subject, grade].join('/');
    });
});