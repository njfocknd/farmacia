<link rel="stylesheet" href="nexthor/libs/amcharts/style.css" type="text/css">
        <script src="nexthor/libs/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="nexthor/libs/amcharts/gauge.js" type="text/javascript"></script>

        <script>
			alert(4);
            var chart;
            var arrow;
            var axis;

            function fncIniciarGrafica(){
				alert(3);
                // create angular gauge
                chart = new AmCharts.AmAngularGauge();
                chart.addTitle("Speedometer");

                // create axis
                axis = new AmCharts.GaugeAxis();
                axis.startValue = 0;
				axis.axisThickness = 1;
                axis.valueInterval = 10;
                axis.endValue = 220;
                // color bands
                var band1 = new AmCharts.GaugeBand();
                band1.startValue = 0;
                band1.endValue = 90;
                band1.color = "#00CC00";

                var band2 = new AmCharts.GaugeBand();
                band2.startValue = 90;
                band2.endValue = 130;
                band2.color = "#ffac29";

                var band3 = new AmCharts.GaugeBand();
                band3.startValue = 130;
                band3.endValue = 220;
                band3.color = "#ea3838";
                band3.innerRadius = "95%";

                axis.bands = [band1, band2, band3];

                // bottom text
                axis.bottomTextYOffset = -20;
                axis.setBottomText("0 km/h");
                chart.addAxis(axis);

                // gauge arrow
                arrow = new AmCharts.GaugeArrow();
                chart.addArrow(arrow);

                chart.write("chartdiv");
                // change value every 2 seconds
                setInterval(randomValue, 2000);
            });

            // set random value
            function randomValue() {
                var value = Math.round(Math.random() * 200);
                arrow.setValue(value);
                axis.setBottomText(value + " km/h");
            }
		
        </script>
   
        <div id="chartdiv" style="width:500px; height:400px;"></div>
		
<script>alert(1);fncIniciarGrafica();alert(2);</script>