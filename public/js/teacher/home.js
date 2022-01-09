$(document).ready(function () {
    // Filter
    $('select#subject').change(function () {
        $('select#subGrade').val('');
    });

    // Chart
    const canvas = $('#myChart');
    const json = canvas.data('json');
    label = [];
    success = [];
    fail = [];
    for (const key in json) {
        if (Object.hasOwnProperty.call(json, key)) {
            const element = json[key];
            label.push(element.key);
            success.push(element.data.success);
            fail.push(element.data.fail);
        }
    }

    const myChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Tuntas',
                data: success,
                backgroundColor: [...Array(label.length)].fill('rgba(168, 255, 184, 0.2)'),
                borderColor: [...Array(label.length)].fill('rgba(98, 222, 120, 1)'),
                borderWidth: 1
            }, {
                label: 'Tidak Tuntas',
                data: fail,
                backgroundColor: [...Array(label.length)].fill('rgba(255, 99, 132, 0.2)'),
                borderColor: [...Array(label.length)].fill('rgba(255, 99, 132, 1)'),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});