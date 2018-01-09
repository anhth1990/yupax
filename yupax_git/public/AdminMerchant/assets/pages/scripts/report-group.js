jQuery(document).ready(function () {
    var year = getParameterByName('year');
    var reportTime = getParameterByName('report-time');

    console.log(year);
    if (year === null) {
        year = 2017;
    }

    if (reportTime === null || reportTime == 'quy') {
        reportTime = 'QUÝ';
    } else if (reportTime == 'nam') {
        reportTime = 'NĂM';
    } else {
        reportTime = 'THÁNG';
    }

    var transactionByHours = JSON.parse($('#transaction_by_hours').attr('data-content'));
    // BAR CHART
    new Morris.Bar({
        element: 'transaction_by_hours',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: transactionByHours['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: transactionByHours['labels']
    });

    var averageInvoiceByHours = JSON.parse($('#average_invoice_by_hours').attr('data-content'));

    new Morris.Bar({
        element: 'average_invoice_by_hours',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: averageInvoiceByHours['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: averageInvoiceByHours['labels']
    });

    $(document).on('change', 'select[name=company], select[name=area], select[name=year], select[name=report-time]', function () {
        $('#reportForm').submit();
    });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}