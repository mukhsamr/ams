$(document).ready(function () {
    // Remove value datalist
    $('#student').focus(function () {
        $(this).val('');
    });

    // Send id student datalist
    $('#student').change(function () {
        const val = $(this).val();
        const id = $(`#listNama option[value = "${val}"]`).data('id');
        $('#nama').val(id);
    });

});