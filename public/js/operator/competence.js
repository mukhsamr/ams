$(document).ready(function () {
    $('select#subject').change(function () {
        $('select#grade').val('');
    });
    $('select#grade').change(function () {
        this.form.submit();
    });
});