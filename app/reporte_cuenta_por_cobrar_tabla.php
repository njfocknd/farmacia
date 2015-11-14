<?php include("nexthor_app.php");?>
<link rel="stylesheet" type="text/css" href="nexthor/libs/DataTables/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="nexthor/libs/DataTables/extensions/Buttons/css/buttons.dataTables.css">

<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/examples/resources/syntax/shCore.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/examples/resources/demo.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/dataTables.buttons.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/extensions/extensions/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/extensions/extensions/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/extensions/extensions/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/buttons.html5.js"></script>


<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
    var lastIdx = null;
    var table = $('#myTable').DataTable( {
        dom: 'Bfrtip',
		responsive: true,
		bFilter: false,
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		],
		scrollY:        '50vh',
		scrollCollapse: true,
		paging:         false,
		"oLanguage": 
		{
			"sLengthMenu": "Ver _MENU_ registros por pagina",
			"sZeroRecords": "Lo sentimos, la informacion que busca no ha sido encontrada",
			"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 of 0 registros",
			"sInfoFiltered": "(Filtrando de _MAX_ total registros)",
			"sSearch": "Buscar:",
			"oPaginate": 
			{
				"sFirst": "Primero",
				"sLast": "Ultimo",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			}
		},
    } );
 
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );
	</script>
<?php 

function fncSetDataToArray($row, &$arr_datos, $tipo)
	{
	switch($tipo)
		{
		case 0:
			$arr_datos['datos'][$row["iddocumento_debito"]]['serie']['valor'] = $row["serie"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['correlativo']['valor'] = $row["correlativo"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['fecha']['valor'] = $row["fecha"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['nombre']['valor'] = $row["nombre"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['direccion']['valor'] = $row["direccion"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['nit']['valor'] = $row["nit"];
			$arr_datos['datos'][$row["iddocumento_debito"]]['monto']['valor'] = number_format($row["monto"],2);
			$arr_datos['datos'][$row["iddocumento_debito"]]['monto_aplicado']['valor'] = number_format($row["monto_aplicado"],2);
			
			$arr_datos['datos'][$row["iddocumento_debito"]]['serie']['align'] = "center";
			$arr_datos['datos'][$row["iddocumento_debito"]]['correlativo']['align'] = "right";
			$arr_datos['datos'][$row["iddocumento_debito"]]['fecha']['align'] = "center";
			$arr_datos['datos'][$row["iddocumento_debito"]]['nombre']['align'] = "left";
			$arr_datos['datos'][$row["iddocumento_debito"]]['direccion']['align'] = "left";
			$arr_datos['datos'][$row["iddocumento_debito"]]['nit']['align'] = "left";
			$arr_datos['datos'][$row["iddocumento_debito"]]['monto']['align'] = "right";
			$arr_datos['datos'][$row["iddocumento_debito"]]['monto_aplicado']['align'] = "right";
			
			$arr_datos['total']['serie']['valor'] = "Totales";
			$arr_datos['total']['correlativo']['valor'] = "";
			$arr_datos['total']['fecha']['valor'] = "";
			$arr_datos['total']['nombre']['valor'] = "";
			$arr_datos['total']['direccion']['valor'] = "";
			$arr_datos['total']['nit']['valor'] = "";
			$arr_datos['total']['monto']['valor'] += $row["monto"];
			$arr_datos['total']['monto_aplicado']['valor'] += $row["monto_aplicado"];
			
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
{
	
	echo "<table id='myTable' class='table table-bordered' cellspacing='0' width='100%'>
			<thead>
				<tr>";
	$x=1;
	foreach ($arr_datos['datos'] as $key => $value) 
		{
			if($x==1)
			{
				foreach ($value as $key2 => $value2) 
				{
					echo "<th>".$key2."</th>";
				}
				echo "</tr></thead><tbody>";
			}
			echo "<tr>";
			foreach ($value as $key2 => $value2) 
				{
					echo "<td align='".$value[$key2]['align']."'>".$value[$key2]['valor']."</td>";
				}
			echo "</tr>";
			$x++;
		}
	echo "<tfoot><tr>";
	foreach ($arr_datos['total'] as $key => $value) 
				{
					echo "<td align='right'>".$value['valor']."</td>";
				}
			echo "</tr>";
	echo "</tfoot></tbody></table>";
}

require_once('nexthor/php/app_db_config.php');
require_once('nexthor/php/dbops.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
if (isset($_POST["anio"])&&isset($_POST["mes"])&&isset($_POST["reporte_cuenta_por_cobrar"]))
	{
		$arr_datos = array();
		$query="select dd.iddocumento_debito, dd.serie, dd.correlativo,  date_format(dd.fecha,'%d/%m/%Y') fecha, dd.nombre, dd.direccion, dd.nit, dd.monto, sum(ifnull(am.monto,0)) monto_aplicado
				from documento_debito dd
					inner join movimiento m on m.idrelacion = dd.iddocumento_debito and m.tabla_relacion = 'documento'
					left join aplicacion_movimiento am on am.idmovimiento_debito = m.idmovimiento and am.fecha <= last_day(".$_POST["anio"].$_POST["mes"]."01)
				where dd.fecha <= last_day(".$_POST["anio"].$_POST["mes"]."01) and dd.estado = 'Activo'
				group by m.idmovimiento
				having monto-monto_aplicado>0
				order by dd.fecha, serie, correlativo desc;";
		fncOperarQuery($MyOps, $query, $arr_datos,0);
		#print_r($arr_datos);
		fncImprimirHtml($arr_datos);
	}
	else
	{
		include ("nexthor/php/error.php");
	}

?>