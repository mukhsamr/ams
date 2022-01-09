$(document).ready(function () {
    $(':checkbox').change(function () {
        const data = $(this).data('id');
        const id = $(this).attr('id');
        const prop = $(this).prop('checked');

        $(`#sel-${data}`).val('');
        $(`#sel-${data} > #opt-${id}`).attr('hidden', prop);
    });
});