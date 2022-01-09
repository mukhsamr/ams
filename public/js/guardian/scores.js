$(document).ready(function () {

    // Filter select score

    $('select#subject').change(function () {
        $('select#competence').val('')
        $('select#competence *').removeAttr('selected').attr('hidden', true);

        const send = $(this).find(':selected').data('send');
        $(`select#competence [data-subject = ${send}]`).removeAttr('hidden');
        console.log(send);
    });

    $(`select#competence [data-subject = ${$('select#subject').find(':selected').data('send')}]`).removeAttr('hidden');

    // Submit score table
    $('select#competence').change(function () {
        $('form#search-score').submit();
    });

    if ($('form#score-show').data('show')) showScore();

    function showScore() {
        $('#score-table').slideUp(100);
        $('#score-table').load($('form#score-show').attr('action'), $('form#score-show').serializeArray(), function (response, status, request) {
            $(this).slideDown(300);
            feather.replace();

            // Give disabled attr on select index
            $('select#column').change(function () {
                let opt = $(this).find(':selected').parent().attr('label');
                opt === 'DailyTest' ? $('select#index').attr('disabled', true) : $('select#index').removeAttr('disabled')
            });

            // Get scores by field 
            $('form#score-edit').submit(function (e) {
                e.preventDefault();

                $('#table-edit').slideUp(500);
                $('#table-edit').load($(this).attr('action'), $(this).serializeArray(), function (response, status, request) {
                    $(this).slideDown(500);
                    $('#btn-submit').removeAttr('disabled');
                });
            });

        });
    }
});