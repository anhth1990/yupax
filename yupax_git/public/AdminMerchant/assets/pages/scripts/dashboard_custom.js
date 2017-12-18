var Dashboard = function() {

	var initChartSample4 = function() {
        var chart = AmCharts.makeChart("chart_4", {
            "type": "serial",
            "theme": "light",


            "handDrawn": true,
            "handDrawScatter": 3,
            "legend": {
                "useGraphSettings": true,
                "markerSize": 12,
                "valueWidth": 0,
                "verticalGap": 0
            },
            "dataProvider": [{
                "year": "Hạng Bạch Kim",
                "income": 5
            }, {
                "year": "Hạng Vàng",
                "income": 70
            }, {
                "year": "Hạng Bạc",
                "income": 100
            }, {
                "year": "Hạng Đồng",
                "income": 115
            }, {
                "year": "Hạng Thường",
                "income": 200
            }],
            "valueAxes": [{
                "minorGridAlpha": 0.08,
                "minorGridEnabled": true,
                "position": "top",
                "axisAlpha": 0
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                "title": "Số lượng",
                "type": "column",
                "fillAlphas": 0.8,

                "valueField": "income"
            }],
            "rotate": true,
            "categoryField": "year",
            "categoryAxis": {
                "gridPosition": "start"
            }
        });

        $('#chart_4').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
    }

    return {
        init: function() {
            initChartSample4();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init(); // init metronic core componets
    });
}