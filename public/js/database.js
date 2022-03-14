$(document).ready(function () {

    // Image preview
    $(':file').change(function () {
        let Reader = new FileReader();
        Reader.readAsDataURL(this.files[0]);
        Reader.onload = (e) => {
            $('img#preview').attr('src', e.target.result);
        }
    });

    // Validation delete
    $('button.delete').click(function () {
        const user = $(this).data('user');
        let check = prompt(`Tulis ${user} untuk konfirmasi`);
        (check === user) ? $(this).parent().submit() : alert('Konfirmasi gagal');
    });

    // Placeholder filter
    $('#field').change(function () {
        let array = ['tanggal_lahir', 'mulai_bekerja'];
        if (array.includes($(this).val())) {
            $('[name = keyword]').attr('placeholder', 'yyyy-mm-dd');
        } else {
            $('[name = keyword]').attr('placeholder', '...');
        };
    });
});