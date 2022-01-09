$(document).ready(function () {
    $('select#subject').change(function () {
        $('select#grade').val('');
        const url = $('form#search-competences').attr('action');
        const subject = $('#subject').val();
        location.href = [url, subject].join('/');
    });
});