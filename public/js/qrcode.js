$(document).ready(function () {
    // Scan
    $('#scan').click(function () {
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                var cameraId = devices[0].id;

                const html5QrCode = new Html5Qrcode("reader");

                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        console.log(`QR Code detected`);

                        html5QrCode.stop().then(ignore => {
                            $(':hidden#qrcode').val(qrCodeMessage);
                            $.ajax({
                                type: "post",
                                url: $('form#attendance').attr('action'),
                                data: $('form#attendance').serialize(),
                                success: function (response, status) {
                                    if (status === 'success') {
                                        if (response.type == 'danger') {
                                            $('#message').text(response.message);
                                        }

                                        if (response.confirm) {
                                            $('#message').html(response.status);
                                            html = `<div>Nama : <strong>${response.name}</strong></div><div>Datang : <strong>${response.date}</strong></div>`
                                            $('#data').html(html);
                                        }
                                    } else {
                                        $('#error').text(status);
                                    }
                                }
                            });
                        }).catch(err => {
                            console.log("Unable to stop scanning.");
                        });
                    },
                    errorMessage => {
                        $('#message').text('QR Code tidak terdeteksi');
                    })
                    .catch(err => {
                        $('#message').text(`Unable to start scanning, error: ${err}`);
                    });
            }
        }).catch(err => {
            $('#message').text('Kamera tidak terdeteksi');
        });
    });
});