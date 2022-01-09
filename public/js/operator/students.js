$(document).ready(function () {
    $('select#subGrade').change(function () {
        const url = $('form#search-student').attr('action');
        location.href = [url, $(this).val()].join('/');
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