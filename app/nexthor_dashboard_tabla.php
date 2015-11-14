<?php include("nexthor_app.php");?>

<link rel="stylesheet" type="text/css" href="nexthor/libs/DataTables/media/css/dataTables.bootstrap.css">

<?php 

function fncSetDataToArray($row, &$arr_datos, $tipo)
	{
	switch($tipo)
		{
		case 0:
			$arr_datos['monto_meta'] = $row["monto_meta"];
			$arr_datos['endValue'] = $row["monto_meta"]*2;
			$arr_datos['intervalo'] = $row["monto_meta"]/5;
			$arr_datos['endValue_intervalo1'] = $row["monto_meta"]-$arr_datos['intervalo'];
		case 1:
			if ($row["monto_documento_debito"] > 0)
				$arr_datos['monto_documento_debito'] = $row["monto_documento_debito"];
		}
	}

function fncOperarQuery ($objeto, $new_query, &$arr_datos, $tipo)
{
	$res = $objeto->list_orders($new_query);
	if($res)
	{
		while ($row = mysql_fetch_assoc($res)) 
		{
		fncSetDataToArray($row, $arr_datos, $tipo);
		}
	}
}

function fncImprimirHtml($arr_datos)
{?>
		<center>
        <script src="nexthor/libs/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="nexthor/libs/amcharts/gauge.js" type="text/javascript"></script>

        <script>
			var chart;
            var arrow;
            var axis;

            function fncIniciarGrafica(){
				// create angular gauge
                chart = new AmCharts.AmAngularGauge();
                chart.addTitle("Velocímetro de Metas y Ventas");

                // create axis
                axis = new AmCharts.GaugeAxis();
                axis.startValue = 0;
				axis.axisThickness = 1;
                axis.valueInterval = <?php echo $arr_datos['intervalo'];?>;
                axis.endValue = <?php echo $arr_datos['endValue'];?>;
                // color bands
                var band1 = new AmCharts.GaugeBand();
                band1.startValue = 0;
                band1.endValue =  <?php echo $arr_datos['endValue_intervalo1'];?>;
                band1.color = "#ea3838";

                var band2 = new AmCharts.GaugeBand();
                band2.startValue = <?php echo $arr_datos['endValue_intervalo1'];?>;
                band2.endValue = <?php echo $arr_datos['monto_meta'];?>;
                band2.color = "#ffac29";

                var band3 = new AmCharts.GaugeBand();
                band3.startValue = <?php echo $arr_datos['monto_meta'];?>;
                band3.endValue = <?php echo $arr_datos['endValue'];?>;
                band3.color = "#00CC00";
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
				
				var value = <?php echo $arr_datos['monto_meta'];?>;
                arrow.setValue(value);
                axis.setBottomText(" Meta Q."+ value );
				window.setTimeout(function(){
					value = <?php echo $arr_datos['monto_documento_debito'];?>;
					arrow.setValue(value);
					axis.setBottomText(" Ventas Q."+ value );
					}, 2000);
            }

            // set random value
            function randomValue() {
				var value = <?php echo $arr_datos['monto_meta'];?>;
                arrow.setValue(value);
                axis.setBottomText(" Meta Q."+ value );
				window.setTimeout(function(){
					value = <?php echo $arr_datos['monto_documento_debito'];?>;
					arrow.setValue(value);
					axis.setBottomText(" Ventas Q."+ value );
					}, 2000);
				
            }
		
        </script>
   
        <div id="chartdiv" style="width:500px; height:400px;"></div>
		
<script>fncIniciarGrafica();</script>
</center>
        
<?php
}

require_once('nexthor/php/app_db_config.php');
require_once('nexthor/php/dbops.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
if (isset($_POST["nexthor_velocimetro_metas_ventas"]))
	{
		$arr_datos = array();
		date_default_timezone_set("America/Guatemala");
		$mes=date("m");
		$anio=date("Y");
		$arr_datos['monto_documento_debito'] = 0;
		$query="select m.idsucursal, m.idperiodo_contable, ifnull(m.monto,0) monto_meta
				from periodo_contable pc
					inner join meta m on m.idperiodo_contable = pc.idperiodo_contable
				where m.estado = 'Activo' and pc.mes = '".$_POST["mes"]."' and pc.anio = '".$_POST["anio"]."' and m.idsucursal = ".$_POST["idsucursal"]."
				group by m.idsucursal, pc.idperiodo_contable;";
		fncOperarQuery($MyOps, $query, $arr_datos,0); 
		$query="select dd.idsucursal, fc.idperiodo_contable, sum(ifnull(dd.monto,0)) monto_documento_debito
				from documento_debito dd
				inner join fecha_contable fc on fc.idfecha_contable = dd.idfecha_contable
				inner join periodo_contable pc on pc.idperiodo_contable = fc.idperiodo_contable
				where dd.estado = 'Activo' and pc.mes = '".$_POST["mes"]."' and pc.anio = '".$_POST["anio"]."' and dd.idsucursal = ".$_POST["idsucursal"]."
				group by dd.idsucursal, fc.idperiodo_contable;";
		fncOperarQuery($MyOps, $query, $arr_datos,1); 
		fncImprimirHtml($arr_datos);
	}
else
	{
		include ("nexthor/php/error.php");
	}

?>