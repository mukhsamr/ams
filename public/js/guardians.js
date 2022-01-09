$(document).ready(function () {

    // Img preview
    $(':file').change(function () {
        const id = $(this).data('preview');

        let Reader = new FileReader();
        Reader.readAsDataURL(this.files[0]);
        Reader.onload = (e) => {
            $(`img#${id}`).attr('src', e.target.result);
        }
    });
});