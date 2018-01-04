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
                            label: {
                                show: true,
                                formatter: function(label, series) {
                                    return '<span style="font-size:14px; text-align:center; color: inherit;">' + label + '<br/>' + Math.round(series.percent) + '%</span>';
                                },
                            },
                            combine: {
                                color: '#999',
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: true
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
                            label: {
                                show: true,
                                formatter: function(label, series) {
                                    return '<span style="font-size:14px; text-align:center; color: inherit;">' + label + '<br/>' + Math.round(series.percent) + '%</span>';
                                },
                            },
                            combine: {
                                color: '#999',
                                threshold: 0.1,
                            }
                        }
                    },
                    legend: {
                        show: true
                    }
                });
            }
        }
    };
}();

jQuery(document).ready(function () {
    ChartsFlotcharts.init();
    ChartsFlotcharts.initPieCharts();
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

    var revenueHighChartData = JSON.parse($('#revenue_highchart').attr('data-content'));
    // LINE CHART 1
    $('#revenue_highchart').highcharts({
        chart: {
            style: {
                fontFamily: 'Open Sans',
                fontSize: '12px',
                fontSize: '14px'
            }
        },
        title: {
            text: 'DOANH THU TRONG ' + reportTime + ' - ' +  year,
            align: 'center',
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: revenueHighChartData['categories'],
            labels: {
                style: {
                    fontSize: '14px'
                }
            },
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)',
            },
            labels: {
                style: {
                    fontSize: '14px'
                }
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
                fontFamily: 'Open Sans',
                fontSize: '14px'
            }
        },
        title: {
            text: 'SỐ LƯỢNG GIAO DỊCH TRONG ' + reportTime + ' - ' +  year,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: transactionHighChartData['categories'],
            labels: {
                style: {
                    fontSize: '14px'
                }
            },
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            labels: {
                style: {
                    fontSize: '14px'
                }
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
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 60,
        labels: transactionByHours['labels']
    });

    var averageInvoiceByHours = JSON.parse($('#average_invoice_by_hours').attr('data-content'));

    new Morris.Bar({
        element: 'average_invoice_by_hours',
        barColors: ['#0b62a4', '#cb4b4b'],
        data: averageInvoiceByHours['data'],
        xkey: 'y',
        ykeys: ['a', 'b'],
        resize: true,
        gridTextSize: 14,
        xLabelAngle: 60,
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