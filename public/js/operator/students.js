$(document).ready(function () {
    $('#subGrade-search').change(function () {
        this.form.submit();
    });

    // Search
    $('#search').keyup(function (e) {
        const value = $(this).val().toLowerCase();
        $("tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });

        $('#jumlah').text($('tbody tr:visible').length);
    });

    // === Create page ===
    $(':checkbox#all').change(function () {
        const check = $(this).prop('checked');
        check ? $(':checkbox').prop('checked', true) : $(':checkbox').prop('checked', false);
    });
});