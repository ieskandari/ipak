function filterFunction(Dropdown, myInput) {
    var input, filter, ul, li, a, i;
    input = document.getElementById(myInput);
    filter = input.value.toUpperCase();
    div = document.getElementById(Dropdown);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

var backgroundColor1 = [
    'rgba(216, 27, 96, 0.6)',
    'rgba(3, 169, 244, 0.6)',
    'rgba(255, 152, 0, 0.6)',
    'rgba(29, 233, 182, 0.6)',
    'rgba(156, 39, 176, 0.6)',
    'rgba(84, 110, 122, 0.6)'
];

var randomScalingFactor = function () {
    return Math.round(Math.random() * 100);
};
var dynamicColors = function () {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};
function drow_chart(myChartName, chartTitle, points_chart_label, points_chart_val, backgroundColor2) {
    var canvas = document.getElementById(myChartName);
    var ctx = canvas.getContext('2d');
    var backColor = [];
    var i = 0;
    for (i = 0; i < points_chart_label.length; i++) {
        backColor[backColor.length] = dynamicColors();
    }
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: points_chart_label,
            datasets: [{
                label: 'تاریخ',
                data: points_chart_val,
                backgroundColor: backColor,
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: chartTitle,
                position: 'top',
                fontSize: 16,
                padding: 20
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0
                    }
                }]
            }
        }
    });
}

function drow_chart_cyc(myChartName, chartTitle, points_chart_label, points_chart_val) {
    var canvas = document.getElementById(myChartName);
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    var backColor = [];
    var i = 0;
    for (i = 0; i < points_chart_label.length; i++) {
        backColor[backColor.length] = dynamicColors();
    }
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: points_chart_val,
                backgroundColor: backColor,
                label: chartTitle
            }],
            labels: points_chart_label
        },
        options: {
            responsive: true
        }
    });
}
