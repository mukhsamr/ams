$(document).ready(function () {

    // Show hide password
    $('#show').change(function () {
        const prop = $(this).prop('checked');
        $('#password').attr('type', prop ? 'text' : 'password');
    });

    // Disable password
    $('#ignore').change(function () {
        const prop = $(this).prop('checked');
        $('#password').attr('disabled', prop).val('');
    });

    // Image preview
    $(':file').change(function () {
        let Reader = new FileReader();
        Reader.readAsDataURL(this.files[0]);
        Reader.onload = (e) => {
            $('img#preview').attr('src', e.target.result);
        }

        // Validasi ukuran
        if ((this.files[0].size / 1000) > 1000) {
            $('#foto').addClass('is-invalid')
        } else {
            $('#foto').removeClass('is-invalid');
        }
    });
});