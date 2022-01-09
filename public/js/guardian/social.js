$(document).ready(function () {
    $(':checkbox').change(function () {
        const data = $(this).data('id');
        const id = $(this).attr('id');
        const prop = $(this).prop('checked');

        console.log(data, id, prop);
        $(`#sel-${data}`).val('');
        $(`#sel-${data} > #opt-${id}`).attr('hidden', prop);
    });
});