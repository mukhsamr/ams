$(document).ready(function () {

    $('#subject-search').change(() => {
        $('#type-search').val('');
    });

    function showLedger() {
        $('#ledgerTable').slideUp(100);
        $('#ledgerTable').load($('#searchLedger').attr('action'), $('#searchLedger').serializeArray(), function (response, status, request) {
            $(this).slideDown(300);
            feather.replace();
        });
    }

    // Submit search ledgers
    $('#type-search').change(function () {
        showLedger();
    });

    if ($('form#ledger-load').data('show')) showLedger();
});