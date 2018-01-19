jQuery(document).ready(function () {
    var year = getParameterByName('year');
    var reportTime = getParameterByName('report-time');
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

    var comingOutGroup = JSON.parse($('#coming_out_group').attr('data-content'));

    new Morris.Bar({
        element: 'coming_out_group',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: comingOutGroup['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: comingOutGroup['labels']
    });

    var loyalGroup = JSON.parse($('#loyal_group').attr('data-content'));

    new Morris.Bar({
        element: 'loyal_group',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: loyalGroup['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: loyalGroup['labels']
    });

    var newGroup = JSON.parse($('#new_group').attr('data-content'));

    new Morris.Bar({
        element: 'new_group',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: newGroup['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: newGroup['labels']
    });

    var vipGroup = JSON.parse($('#vip_group').attr('data-content'));
    // BAR CHART
    new Morris.Bar({
        element: 'vip_group',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: vipGroup['data'],
        xkey: 'y',
        ykeys: ['day_in_week', 'weekend'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 0,
        labels: vipGroup['labels']
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