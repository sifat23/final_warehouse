<!DOCTYPE HTML>
<html>
<head>
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer",
                {
                    theme: "light2",
                    title:{
                        text: "Gaming Consoles Sold in 2012"
                    },
                    data: [
                        {
                            type: "pie",
                            showInLegend: true,
                            toolTipContent: "{y} - #percent %",
                            yValueFormatString: "#,##0,,.## Million",
                            legendText: "{indexLabel}",
                            dataPoints: [
                                {  y: 4181563, indexLabel: "PlayStation 3" },
                                {  y: 2175498, indexLabel: "Wii" },
                                {  y: 3125844, indexLabel: "Xbox 360" },
                                {  y: 1176121, indexLabel: "Nintendo DS"},
                                {  y: 1727161, indexLabel: "PSP" },
                                {  y: 4303364, indexLabel: "Nintendo 3DS"},
                                {  y: 1717786, indexLabel: "PS Vita"}
                            ]
                        }
                    ]
                });
            chart.render();
        }
    </script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script></head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
</body>
</html>