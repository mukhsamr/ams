$(document).ready(function () {

    function showCompetence() {
        const subject = $('select#subject').find(':selected').data('subject');
        const subgrade = $('select#subGrade').find(':selected').data('subgrade');
        $(`select#competence [subject = ${subject}][subgrade = ${subgrade}]`).removeAttr('hidden');
    }

    function showSubGrade() {
        const subject = $('select#subject').find(':selected').data('subject');
        $(`select#subGrade [subject = ${subject}]`).removeAttr('hidden');
    }

    // Filter select score
    $('select#subject').change(function () {
        $('select#subGrade').val('')
        $('select#competence').val('')

        $('select#competence *').removeAttr('selected').attr('hidden', true);
        $('select#subGrade *').removeAttr('selected').attr('hidden', true);

        showSubGrade();
    });

    $('select#subGrade').change(function () {
        $('select#competence').val('')
        $('select#competence *').removeAttr('selected').attr('hidden', true);

        showCompetence();
    });

    showSubGrade();
    showCompetence();

    // ===

    // Submit score table
    $('select#competence').change(function () {
        $('form#search-score').submit();
    });

    // ===

    // Ajax modal
    $('a.modal-competence').click(function (e) {
        e.preventDefault();
        const id = $(this).data('target');

        $('#modal').load($(this).attr('href'), $(this).serialize(), function (response, status, request) {
            $(id).modal('show');

            // Filter select score
            $('select#add-subject').change(function () {
                $('select#add-subGrade').val('')
                $('select#add-competence').val('')
                $('select#add-competence *').removeAttr('selected').attr('hidden', true);
            });

            $('select#add-subGrade').change(function () {
                $('select#add-competence').val('')
                $('select#add-competence *').removeAttr('selected').attr('hidden', true);

                const subject = $('select#add-subject').find(':selected').data('subject');
                const grade = $('select#add-subGrade').find(':selected').data('grade');
                $(`select#add-competence [subject = ${subject}][grade = ${grade}]`).removeAttr('hidden');
            });

            $('select#add-competence').change(function () {
                const summary = $(this).find(':selected').data('summary');
                $('#summary').text(summary);
            });
        });
    });


    // ===

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