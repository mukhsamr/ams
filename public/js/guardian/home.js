$(document).ready(function () {

    // Chart
    const canvas = $('#myChart');
    const json = canvas.data('json');

    label = [];
    kd3 = [];
    kd4 = [];
    json.forEach(el => {
        label.push(el.subject);
        kd3.push(el.tuntas_3);
        kd4.push(el.tuntas_4);
    });

    const myChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'KD3',
                data: kd3,
                backgroundColor: [...Array(label.length)].fill('rgba(117, 224, 112, 0.2)'),
                borderColor: [...Array(label.length)].fill('rgba(67, 179, 62, 1)'),
                borderWidth: 1
            }, {
                label: 'KD4',
                data: kd4,
                backgroundColor: [...Array(label.length)].fill('rgba(160, 89, 181, 0.2)'),
                borderColor: [...Array(label.length)].fill('rgba(116, 44, 138, 1)'),
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