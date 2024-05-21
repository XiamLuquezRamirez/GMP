<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>amCharts V4 Example - simple-3D-pie-chart</title>
        <link rel="stylesheet" href="index.css" />
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                background-color: #ffffff;
                overflow: hidden;
                margin: 0;
            }

            #chartdiv {
                width: 100%;
                max-height: 600px;
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div id="chartdiv"></div>
        <script src="Js/amchart/core.js"></script>
        <script src="Js/amchart/charts.js"></script>
        <script src="Js/amchart/themes/animated.js"></script>
        <script src="index.js"></script>
        <script>
            am4core.useTheme(am4themes_animated);

            var chart = am4core.createFromConfig({
                "data": [{
                        "country": "Lithuania",
                        "litres": 501.9
                    }, {
                        "country": "Czech Republic",
                        "litres": 301.9
                    }, {
                        "country": "Ireland",
                        "litres": 201.1
                    }],
                "legend": {},
                "innerRadius": "40%",
                "series": [{
                        "type": "PieSeries3D",
                        "dataFields": {
                            "value": "litres",
                            "category": "country"
                        }
                    }]
            }, "chartdiv", "PieChart3D");

        </script>
    </body>

</html>