<?php
header('Content-Type: text/html; charset=utf8_encode');
include "nexthor_header.php";   
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
date_default_timezone_set("America/Guatemala");


?>

<script type="text/javascript" src="nexthor/my_js/factura.js"></script>

<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="repository/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="repository/libs/bootstrap/js/ie-emulation-modes-warning.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">	
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div id="divFormularioCliente">
						<form class="form-horizontal">
							  <div class="form-group" id="divNit">
								<label for="inputNit" class="col-sm-2 control-label">Nit</label>
								<div class="col-sm-4">
									<div class="input-group">
									  <input type="text" class="form-control" id="nit_cliente" placeholder="Nit" onkeyup="VerInfoCliente(event,this.id,this.value)">
									  <span class="input-group-addon" id="basic-addon2" onclick="fncVer();" style="cursor: pointer;" title="Click Para buscar">Buscar</span>
									</div>
								</div>
							  </div>
							<div id="divDatosCliente">
							  <div class="form-group">
								<label for="inputNombre" class="col-sm-2 control-label">Nombre</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="nombre_cliente" placeholder="Nombre">
								</div>
							  </div>
							  <div class="form-group">
								<label for="inputDireccion" class="col-sm-2 control-label">Direccion</label>
								<div class="col-sm-8">
									<div class="input-group">
										<input type="text" class="form-control" id="direccion_cliente" placeholder="Direccion" aria-describedby="sizing-addon2">
										<span class="input-group-addon" id="basic-addon2" style="cursor: pointer;" title="Ingrese datos y luego Click Para Crear Cliente">Crear</span>
									</div>
								</div>
							  </div>
							</div>
						</form>
						<div class="col-md-1">
							<button type="button" class="btn btn-default" disabled="disabled">
							  <span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</div>
						<div class="col-md-1"><input type="hidden" value="0" id="inputBandera" /></div>
						<div class="col-md-1" id="divIdCliente"><input type="hidden" value="0" id="inputIdCliente" /></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<button type="button" class="btn btn-default" id="button" onclick="fncCambioFormulario(2,1);">
							  <span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>
					</div>
					<div id="divFormularioDetalle">
					</div>
					<div id="divFormularioPago">
					</div>
				</div>
				<div class="panel-footer">
					@nexthor 2015 <div id="divActualizaciones"></div>
				</div>
			</div>
		</div>
	</div>
	<script src="repository/my_js/jquery-ui-1.10.1.custom.min"></script>
	<script src="repository/libs/bootstrap/js/jquery.min.js"></script>
	<script src="repository/libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="repository/libs/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>