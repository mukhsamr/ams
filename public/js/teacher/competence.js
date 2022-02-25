$(document).ready(function () {
    // Remove value
    $('select#subject').change(function () {
        $('select#grade').val('');
    });

    // Filter
    $('select#grade').change(function () {
        $('#search-competences').submit();
    });
});