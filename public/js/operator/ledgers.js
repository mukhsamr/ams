$(document).ready(function () {

    // Filter ledger
    function send(selector) {
        return $(selector).find(':selected').data('send');
    }

    $(`select#subGrade [data-subject = ${send('select#subject')}]`).removeAttr('hidden');;
    $('select#subject').change(() => {
        $('select#subGrade').val('');
        $('select#type').val('');
        $('select#subGrade *').attr('hidden', true);
        $(`select#subGrade [data-subject = ${send(this)}]`).removeAttr('hidden');
    });

    $('select#subGrade').change(function () {
        $('select#type *').removeAttr('selected');
    });

    function showLedger() {
        $('#ledgerTable').slideUp(100);
        $('#ledgerTable').load($('#searchLedger').attr('action'), $('#searchLedger').serializeArray(), function (response, status, request) {
            $(this).slideDown(300);
            feather.replace();
            $.getScript("/js/helper.js", function (script, textStatus, jqXHR) {
            });
        });
    }

    // Submit search ledgers
    $('select#type').change(function () {
        showLedger();
    });

    if ($('form#ledger-load').data('show')) showLedger();
});