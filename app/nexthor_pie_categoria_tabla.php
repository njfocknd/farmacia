<?php include("nexthor_app.php");?>

<?php 

function fncSetDataToArray($row, &$arr_datos, $tipo)
	{
	switch($tipo)
		{
		case 0:
			$arr_datos[$row['idsucursal']]['nombre'] = $row["nombre"];
			$arr_datos[$row['idsucursal']]['monto'] = $row["monto"];
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
        <script src="nexthor/libs/amcharts/pie.js" type="text/javascript"></script>

        <script>
            var chart;
            var legend;
			<?php
			$myString = 'var chartData = [';
			foreach ($arr_datos as $key => $value) 
			{
				$myString =$myString.'{country: "'.$value['nombre'].'",
						litres: '.$value['monto'].'},';
			}
			echo $myString.'];';
			?>
			
			 

            function fncIniciarGrafica() {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "litres";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;

                // WRITE
                chart.write("chartdiv");
            }
        </script>
		<div id="chartdiv" style="width:700px; height:500px;"></div>
		
<script>fncIniciarGrafica();</script>
</center>
        
<?php
}

require_once('nexthor/php/app_db_config.php');
require_once('nexthor/php/dbops.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
if (isset($_POST["nexthor_pie_categoria"]))
	{
		$arr_datos = array();
		date_default_timezone_set("America/Guatemala");
		$mes=date("m");
		$anio=date("Y");
		$query="select s.nombre, sum(dd.monto) monto,  s.idsucursal
				from sucursal s
				inner join documento_debito dd on dd.idsucursal = s.idsucursal
				where dd.estado = 'Activo'
				and dd.fecha between '".$_POST["anio"]."".$_POST["mes"]."01' and last_day('".$_POST["anio"]."".$_POST["mes"]."01')
				group by s.idsucursal
				order by sum(dd.monto) desc
				limit 10;";
		fncOperarQuery($MyOps, $query, $arr_datos,0); 
		fncImprimirHtml($arr_datos);
	}
else
	{
		include ("nexthor/php/error.php");
	}

?>