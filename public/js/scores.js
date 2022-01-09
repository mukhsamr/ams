$(document).ready(function () {

    // Filter select score
    $(`select#sub_grade [data-subject = ${$('select#subject').find(':selected').data('send')}]`).removeAttr('hidden');

    $('select#subject').change(function () {
        $('select#sub_grade').val('')
        $('select#competence').val('')
        $('select#sub_grade *').removeAttr('selected').attr('hidden', true);
        $('select#competence *').removeAttr('selected').attr('hidden', true);

        const send = $(this).find(':selected').data('send');
        $(`select#sub_grade [data-subject = ${send}]`).removeAttr('hidden');
    });

    $(`select#competence [data-subject_sub_grade = ${$('select#sub_grade').find(':selected').data('send')}]`).removeAttr('hidden');

    $('select#sub_grade').change(function () {
        $('select#competence').val('')
        $('select#competence *').removeAttr('selected').attr('hidden', true);

        const send = $(this).find(':selected').data('send');
        $(`select#competence [data-subject_sub_grade = ${send}]`).removeAttr('hidden');
    });

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

    // ==============

    // Add table select filter
    $('select#add-subject').change(function () {
        $('select#add-subGrade').val('');
        $('select#add-competence').val('');
        $('select#add-competence *').removeAttr('selected').attr('hidden', true);
        $('#summary').text('');
    });

    $('select#add-subGrade').change(function () {
        $('select#add-competence').val('');
        $('select#add-competence *').removeAttr('selected').attr('hidden', true);
        $('#summary').text('');

        const subject = $('select#add-subject').find(':selected').data('send');
        const subgrade = $(this).find(':selected').data('send');
        $(`select#add-competence [data-grade=${subject}-${subgrade}]`).removeAttr('hidden');
    });

    $('select#add-competence').change(function () {
        const summary = $(this).find(':selected').data('summary');
        $('#summary').text(summary);
    });
});