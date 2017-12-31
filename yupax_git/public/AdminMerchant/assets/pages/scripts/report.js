var ChartsFlotcharts = function () {
    return {
        init: function () {
            App.addResizeHandler(function () {
                Charts.initPieCharts();
            });
        },

        initPieCharts: function () {
            var data = JSON.parse($('#products_ration_by_week').attr('data-content'));

            // GRAPH 6
            if ($('#products_ration_by_week').size() !== 0) {
                $.plot($("#products_ration_by_week"), data, {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0.5,
                            combine: {
                                color: '#999',
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }

            // GRAPH 7
            if ($('#products_ration_by_weekend').size() !== 0) {
                $.plot($("#products_ration_by_weekend"), data, {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0.5,
                            combine: {
                                color: '#999',
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }
        }
    };
}();

jQuery(document).ready(function () {
    ChartsFlotcharts.init();
    ChartsFlotcharts.initPieCharts();

    var revenueHighChartData = JSON.parse($('#revenue_highchart').attr('data-content'));
    // LINE CHART 1
    $('#revenue_highchart').highcharts({
        chart: {
            style: {
                fontFamily: 'Open Sans',
                fontSize: '12px'
            }
        },
        title: {
            text: 'DOANH THU TRONG XXX',
            x: -20,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: revenueHighChartData['categories']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
        },
        series: revenueHighChartData['series']
    });

    var transactionHighChartData = JSON.parse($('#transaction_hightchart').attr('data-content'));
    // LINE CHART 2
    $('#transaction_hightchart').highcharts({
        chart: {
            style: {
                fontFamily: 'Open Sans'
            }
        },
        title: {
            text: 'SỐ LƯỢNG GIAO DỊCH TRONG XXX',
            x: -20,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: transactionHighChartData['categories']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
        },
        series: transactionHighChartData['series']
    });

    var transactionByHours = JSON.parse($('#transaction_by_hours').attr('data-content'));
    // BAR CHART
    new Morris.Bar({
        element: 'transaction_by_hours',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: transactionByHours['data'],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: transactionByHours['labels']
    });

    var averageInvoiceByHours = JSON.parse($('#average_invoice_by_hours').attr('data-content'));

    new Morris.Bar({
        element: 'average_invoice_by_hours',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: averageInvoiceByHours['data'],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: averageInvoiceByHours['labels']
    });

    $(document).on('change', 'select[name=company], select[name=area], select[name=year], select[name=report-time]', function () {
        $('#reportForm').submit();
    });
});