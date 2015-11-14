<?php include "nexthor_header.php" ?>

<script type="text/javascript" language="javascript" src="nexthor/libs/DataTables/media/js/jquery.js"></script>

<script  type="text/javascript" charset="utf-8">//Funciones	
function show_table()
	{
	div=document.getElementById('ajaxresult');
	div.innerHTML = "Generando Reporte";
	anio=document.getElementById('anio').value;
	mes=document.getElementById('mes').value;
	idsucursal=document.getElementById('idsucursal').value;
	strparams = { 'anio': anio, 'mes': mes,  'idsucursal': idsucursal,'nexthor_velocimetro_metas_ventas': 1 };
	//$.post( "nexthor_velocimetro_metas_ventas_tabla.php", strparams, function(html){$(div).html(html);});
	}
</SCRIPT>
<?php
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$query="select idsucursal id, nombre name from sucursal  where estado = 'Activo';";
$idsucursal = "<form class='form-horizontal' role='form'><div class='form-group'><label for='idsucursal' >Sucursal </label>".fncDesignCombo($MyOps, $query,'idsucursal','class="form-control"','','',0, 'Sucursal')."</div></form>";

if(CurrentUserId()!= null)
{?>
	<ul class="nav nav-pills">
	  <li><a href="reporte_cuenta_por_cobrar.php">Cuenta por Cobrar</a></li>
	  <li class="active"><a  href="nexthor_velocimetro_metas_ventas.php">Velocímetro Metas y Ventas</a></li>
	  </ul>
	<FORM NAME="example">
		<div class="panel panel-primary">
			<div class="panel-body">
				<table class="table table-bordered">
					<tr align='center'>
					
						<td>
							<label> Mes </label>
							<select id='mes' name='mes' class='form-control'>
								<option value='01'>Enero</option>					
								<option value='02'>Febrero</option>					
								<option value='03'>Marzo</option>					
								<option value='04'>Abril</option>					
								<option value='05'>Mayo</option>					
								<option value='06'>Junio</option>					
								<option value='07'>Julio</option>					
								<option value='08'>Agosto</option>					
								<option value='09'>Septiembre</option>					
								<option value='10'>Octubre</option>					
								<option value='11'>Noviembre</option>					
								<option value='12'>Diciembre</option>					
							</select>
							
						</td>
						<td>
							<label> Año </label>
							<select id='anio' name='anio' class='form-control'>
								<option value='2015'>2015</option>
								<option value='2016'>2016</option>				
							</select>
						</td>
						<td>
							<?php echo $idsucursal; ?>
						</td>
						<td>
							<button type="button" class="btn btn-primary" onclick='show_table();' ><span class="glyphicon glyphicon-search"></span></button>
						</td>
					</tr>
				</table>
				<DIV id="ajaxresult" style="width: 100%;"></DIV>
			</div>
		</div>
	</form>
	<?php
	date_default_timezone_set("America/Guatemala");
	$mes=date("m");
	$anio=date("Y");
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('mes').value='".$mes."';</SCRIPT>";
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('anio').value=".$anio.";</SCRIPT>";
	echo "<SCRIPT LANGUAGE=\"JavaScript\">show_table();</SCRIPT>";	
} 
else 
{ 
	include ("general_repository/php/access_denied.php");
}
include "footer.php" 
?>
