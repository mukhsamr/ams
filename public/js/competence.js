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

    $('.longtext').on('click', 'a', function () {
        const cond = $(this).data('send');
        const data = $(this).parent().data(cond);
        $(this).parent().html(data);
    });

    // Get file size upload
    $(':file').change(function () {
        const size = (this.files[0].size / 1000) + ' KB';
        $('#size').text(size);
    });
});