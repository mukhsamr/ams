$(document).ready(function () {

    $('select#subject').change(() => {
        $('select#type').val('');
    });

    function showLedger() {
        $('#ledgerTable').slideUp(100);
        $('#ledgerTable').load($('#searchLedger').attr('action'), $('#searchLedger').serializeArray(), function (response, status, request) {
            $(this).slideDown(300);
            feather.replace();

            $('.deskripsi').on('click', 'a', function () {
                const cond = $(this).data('send');
                const data = $(this).parent().data(cond);
                $(this).parent().html(data);
            });
        });
    }

    // Submit search ledgers
    $('select#type').change(function () {
        showLedger();
    });

    if ($('form#ledger-load').data('show')) showLedger();
});