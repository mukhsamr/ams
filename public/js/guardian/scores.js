$(document).ready(function () {

    // Filter select score
    function showCompetence() {
        const subject = $('#subject-search').find(':selected').data('subject');
        $(`#competence-search [subject = ${subject}]`).removeAttr('hidden');
    }

    showCompetence();

    $('#subject-search').change(function () {
        $('#competence-search').val('')
        $('#competence-search *').removeAttr('selected').attr('hidden', true);
        showCompetence();
    });


    // Submit score table
    $('#competence-search').change(function () {
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