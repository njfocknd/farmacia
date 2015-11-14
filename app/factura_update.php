<?php
include "nexthor_header.php";     
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$ulevel = -1;
$user_id=1;
if($user_id!= null)
{
	if($ulevel==-1)
	{
		$security=0;
		if (isset($_POST["nit"])&&isset($_POST["verDatosCliente"]))
		{
			$queryList = "SELECT idcliente,nombre_factura, direccion_factura FROM cliente WHERE nit = '".$_POST["nit"]."' limit 1;";
			$res = $MyOps->list_orders($queryList);
			$filas=mysql_num_rows($res);
			if($filas > 0)
			{
				while ($row = mysql_fetch_assoc($res)) 
				{
					echo '<div class="form-group">
								<label for="inputNombre" class="col-sm-2 control-label">Nombre</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" value="'.$row["nombre_factura"].'" id="nombre_cliente" placeholder="Nombre">
								</div>
							  </div>
							  <div class="form-group">
								<label for="inputDireccion" class="col-sm-2 control-label">Direccion</label>
								<div class="col-sm-8">
									<div class="input-group">
										<input type="text" class="form-control" id="direccion_cliente" value="'.$row["direccion_factura"].'" placeholder="Direccion" aria-describedby="sizing-addon2">
										<span class="input-group-addon" id="basic-addon2" onclick="fncH();" style="cursor: pointer;" title="Click Para buscar">Crear</span>
									</div>
								</div>
							  </div>';
					echo '<script>document.getElementById("inputIdCliente").value = "'.$row["idcliente"].'";</script>';
				}
			}
			else
			{
				echo '<div class="form-group">
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
								<span class="input-group-addon" id="basic-addon2" onclick="fncNuevoCliente();" style="cursor: pointer;" title="Click Para buscar">Crear</span>
							</div>
						</div>
					  </div>';
				echo '<script>document.getElementById("nombre_cliente").focus(); document.getElementById("divNit").className = "form-group has-warning";</script>';
			}
			
		}
		else if (isset($_POST["nit"])&&isset($_POST["nombre"])&&isset($_POST["direccion"])&&isset($_POST["insertarDatosCliente"])) //crea cliente nuevo
		{
			$query = "INSERT INTO persona (tipo_persona, nombre, apellido, direccion, idpais, fecha_insercion) 
						VALUES (1,'".$_POST["nombre"]."','".$_POST["nombre"]."','".$_POST["direccion"]."',1,now());";
			if ($MyOps->insert_to_db($query))
			{
				$idPersona=$MyOps->transac_id;
				$queryCliente = "INSERT INTO cliente (idpersona,nit,nombre_factura,direccion_factura,fecha_insercion) 
							VALUES (".$idPersona.",'".$_POST["nit"]."','".$_POST["nombre"]."','".$_POST["direccion"]."',now());";
				if ($MyOps->insert_to_db($queryCliente))
				{
					$idCliente=$MyOps->transac_id;
					echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('inputIdCliente').value = '".$idCliente."';</SCRIPT>";
				}
					
			}
			
		}
		else if(isset($_POST["bandera"])&&isset($_POST["menu"])) //detalle venta
		{
			if($_POST["menu"] == 'step2')
			{
	$agregarProducto= '<table>
						<tr>
						<td>
						<form class="form-inline">
						  <div class="form-group">
							<label class="text-muted"><small>Producto</small></label>
							<input type="text" class="form-control input-sm" style="width:100px;" id="inputCodigo" placeholder="Codigo" onchange="fncBuscaProducto(this.value);">
						  </div>
						  <div id="divDatosProducto" class="form-group">
							  <div class="form-group">
								<label class="text-muted"><small>Descripcion</small></label>
								<input type="text" class="form-control input-sm" style="width:275px;" id="inputDescripcion" placeholder="descripcion" readonly>
							  </div>
							  <div class="form-group">
								<label class="text-muted"><small>Precio</small></label>
								<div class="input-group">
									<div class="input-group-addon">Q.</div>
									<input type="text" class="form-control input-sm" style="width:75px;" id="inputPrecio" placeholder="Precio" readonly>
								</div>
							  </div>
							</div>
						  <div class="form-group">
							<label class="text-muted"><small>Cantidad</small></label>
							<input type="text" class="form-control input-sm" style="width:90px;" id="inputCantidad" placeholder="Cantidad" onchange="fncCalculaDetalleSubTotal(this.value);">
						  </div>
						  <div class="form-group" id="divTotalDetalle">
							<label class="text-muted"><small>Total</small></label>
							<input type="text" class="form-control input-sm" style="width:75px;" id="inputTotalCompra" placeholder="Total" readonly>
						  </div>
						  <button type="button" class="btn btn-default" onclick="fncAgregarProducto();"><span class="glyphicon glyphicon-shopping-cart"></span> Agregar</button>
						</form>
						</td>
						</tr>
						</table>';
			$encabezado='<div id="divDetalleVenta"><table class="table">
							<tr>
								<th></th>
								<th>Codigo</th>
								<th>Descripcion</th>
								<th>Precio</th>
								<th>Unidades</th>
								<th>Total</th>
							</tr>';
					$idDocumento=-1;
					$y=$subTotalDetalle=0;
					$detalleVendido='';
					$queryList = "SELECT d.iddetalle_documento_debito id, d.iddocumento_debito id2, d.idproducto id3, d.cantidad, d.precio, d.monto, p.nombre 
					FROM detalle_documento_debito d left join producto p on(p.idproducto = d.idproducto) WHERE d.iddocumento_debito = '".$idDocumento."';";
					$res = $MyOps->list_orders($queryList);
					$filas=mysql_num_rows($res);
					if($filas > 0)
					{
						while ($row = mysql_fetch_assoc($res)) 
						{
						$y++;
			$detalleVendido.='<tr>
								<td><button type="button" class="btn btn-danger" onclick="fncQuitarProducto();"><span class="glyphicon glyphicon-minus-sign"></span></button></td>
								<td>'.$row["id3"].'</td>
								<td>'.$row["nombre"].'</td>
								<td>'.$row["precio"].'</td>
								<td>'.$row["cantidad"].'</td>
								<td>'.$row["monto"].'</td>
							</tr>';
							$subTotalDetalle+=$row["monto"];
						}
					}
					else
					{
			$detalleVendido.='<tr>
								<td colspan=6><center><p class="text-info">  No ha registrado ningún producto a la compra.</p></center></td>
							</tr>';
					}
			$footer='</table></div>
						<div class="col-md-1">
							<button type="button" class="btn btn-default" onclick="fncCambioFormulario(1,2);">
							  <span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"><input type="hidden" value="0" id="inputIdMovimientoDocumento"></div>
						<div class="col-md-1"><input type="hidden" value="0" id="inputBanderaStep"></div>
						<div class="col-md-1"><input type="hidden" value="'.$subTotalDetalle.'" id="inputSubTotalDetalle"></div>
						<div class="col-md-1"><input type="hidden" value="0" id="inputIdDocumento"></div>
						<div class="col-md-1">
							<button type="button" class="btn btn-default" onclick="fncCambioFormulario(3,2);">
							  <span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>';
						
				echo $agregarProducto.$encabezado.$detalleVendido.$footer;
			}
			else
			{
			echo'
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					  </div>
					  <div class="modal-body">
						...
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					  </div>
					</div>
				  </div>
				</div>
				<div>
					<ul class="nav nav-pills nav-justified">
						<li><a href="#tab1" data-toggle="tab">Efectivo</a></li>
						<li><a href="#tab2" data-toggle="tab">Deposito</a></li>
						<li><a href="#tab3" data-toggle="tab">Cheque</a></li>
						<li><a href="#tab4" data-toggle="tab">Tarjeta</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane" id="tab1">
							<br/><br/>
							<form class="form-horizontal" name="formEfectivo">
							  <div class="form-group">
								<label for="inputMontoEfectivo" class="col-sm-2 control-label">Monto a Pagar</label>
								<div class="col-sm-8">
								  <input type="numeric" class="form-control" id="inputMontoEfectivo" placeholder="Total a Pagar" readonly>
								</div>
							  </div>
							  <div class="form-group" id="divMontoRecibidoEfectivo">
								<label for="inputMontoRecibidoEfectivo" class="col-sm-2 control-label">Efectivo Recibido</label>
								<div class="col-sm-8">
								  <input type="decimal" class="form-control" id="inputMontoRecibidoEfectivo" placeholder="Recibido" onchange="fncCalculaRetorno();">
								</div>
							  </div>
							  <div class="form-group">
								<label for="inputMontoVuelto" class="col-sm-2 control-label">Monto a Retornar</label>
								<div class="col-sm-8">
								  <input type="numeric" class="form-control" id="inputMontoVuelto" placeholder="Monto a Retornar" readonly>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								  <div class="checkbox">
									<label>
									  <input type="checkbox" id="checkConfirmaPago" name="checkConfirmaPago" onclick="fncConfirmaEfectivo(this.id)"> Confirme Pago
									</label>
								  </div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-3">
								  <button type="button" id="buttonPagoEfectivo" class="btn btn-success disabled" onclick="fncGuardaPago(1);">Generar Pago</button>
								</div>
							  </div>
							</form>
						</div>
						<div class="tab-pane" id="tab2">
							<br/><br/>
							<form class="form-horizontal" name="formDeposito">
							  <div class="form-group">
								<label for="inputMontoDeposito" class="col-sm-2 control-label">Monto a Pagar</label>
								<div class="col-sm-6">
								  <input type="numeric" class="form-control" id="inputMontoDeposito" value="0" placeholder="Total a Pagar" readonly>
								</div>
							  </div>
							  <div class="form-group" id="divMontoRecibidoEfectivo">
								<label for="inputBoletaPago" class="col-sm-2 control-label">Boleta de Pago</label>
								<div class="col-sm-6">
								  <input type="decimal" class="form-control" id="inputBoletaPago" placeholder="Boleta" onchange="fncBuscaBoletaPago();">
								</div>
								<div class="col-sm-3">
									<div class="btn-toolbar" role="toolbar">
										<div class="btn-group">
											 <button type="button" id="buttonAgregarBoleta" class="btn btn-default" data-toggle="tooltip" data-placement="right" data-target="#myModal" title="¿Desea insertar la Boleta?" onclick="fncAgregarBoleta();">
											  <span class="glyphicon glyphicon-plus-sign"></span>
											</button>
										</div>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-3">
								  <button type="button" id="buttonPagoDeposito" class="btn btn-success disabled" onclick="fncGuardaPago(2);">Generar Pago</button>
								</div>
							  </div>
							</form>
						</div>
						<div class="tab-pane" id="tab3">
							cheque_cliente
						</div>
						<div class="tab-pane" id="tab4">
							voucher_tarjeta
						</div>
					</div>	
				</div>
				<br/><br/>
				<div class="col-md-1">
							<button type="button" class="btn btn-default" onclick="fncCambioFormulario(2,3);">
							  <span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<button type="button" class="btn btn-default" disabled="disabled">
							  <span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>';
						
			}
		}
		// pago en Efectivo
		else if(isset($_POST["idtipo_pago"])&&isset($_POST["id_cliente"])&&isset($_POST["monto"])&&isset($_POST["idsucursal"])&&isset($_POST["documento"])&&isset($_POST["movimientoDocumento"])&&isset($_POST["pagoEfectivo"]))//crea pago para venta en efectivo
		{
			$query = "INSERT INTO pago_cliente (idtipo_pago, idcliente, monto, fecha, fecha_insercion, idsucursal) 
						VALUES (".$_POST["idtipo_pago"].",".$_POST["id_cliente"].",'".$_POST["monto"]."',now(),now(),".$_POST["idsucursal"].");";
			if ($MyOps->insert_to_db($query))
			{
				$idPago=$MyOps->transac_id;
				$queryList = "SELECT idmovimiento FROM movimiento WHERE idrelacion = '".$idPago."' and tabla_relacion = 'pago_cliente' limit 1;";
				$res = $MyOps->list_orders($queryList);
				$filas=mysql_num_rows($res);
				if($filas > 0)
				{
					while ($row = mysql_fetch_assoc($res)) 
					{
						$idMovimientoPago=$row["idmovimiento"];
					}
					$queryAplicaion = "INSERT INTO aplicacion_movimiento (idmovimiento_credito, idmovimiento_debito, monto) 
						VALUES (".$idMovimientoPago.",".$_POST["movimientoDocumento"].",'".$_POST["monto"]."');";
					if ($MyOps->insert_to_db($queryAplicaion))
					{
						echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('Se realizo completamente la venta');</SCRIPT>";
					}
				}
			}
			else
			{
				echo "<SCRIPT LANGUAGE=\"JavaScript\">alert('NO se realizo la venta no.');</SCRIPT>";
			}
		}
		else if(isset($_POST["idProducto"])&&isset($_POST["informacionProducto"])) //muestra nombre y precio de producto seleccionado
		{
			$queryList = "SELECT idproducto, nombre, existencia, precio_venta FROM producto WHERE idproducto = '".$_POST["idProducto"]."' limit 1;";
			$res = $MyOps->list_orders($queryList);
			$filas=mysql_num_rows($res);
			if($filas > 0)
			{
				while ($row = mysql_fetch_assoc($res)) 
				{
					echo'<div class="form-group">
								<label class="text-muted"><small>Descripcion</small></label>
								<input type="text" class="form-control input-sm" style="width:275px;" id="inputDescripcion" value="'.$row["nombre"].'" placeholder="descripcion" readonly>
						  </div>
						  <div class="form-group">
							<label class="text-muted"><small>Precio</small></label>
							<div class="input-group">
								<div class="input-group-addon">Q.</div>
								<input type="text" class="form-control input-sm" style="width:75px;" id="inputPrecio" value="'.$row["precio_venta"].'" placeholder="Precio" readonly>
							</div>
						  </div>';
				}
			}
		}
		else if(isset($_POST["nit_cliente"])&&isset($_POST["nombre_cliente"])&&isset($_POST["direccion_cliente"])&&isset($_POST["inputIdCliente"])&&isset($_POST["inputIdDocumento"])&&isset($_POST["inputCodigo"])&&isset($_POST["inputDescripcion"])&&isset($_POST["inputPrecio"])&&isset($_POST["inputCantidad"])&&isset($_POST["inputTotalCompra"])&&isset($_POST["creaDocumentoDetalle"]))
		{
			if($_POST["inputIdDocumento"]==0)
			{
				$query = "INSERT INTO documento_debito (idtipo_documento, idsucursal,idserie_documento,serie,fecha,nombre,direccion,nit,fecha_insercion,idcliente) 
						VALUES (1,1,1,'FP',now(),'".$_POST["nombre_cliente"]."','".$_POST["direccion_cliente"]."','".$_POST["nit_cliente"]."',now(),".$_POST["inputIdCliente"].");";
				//echo $query;
				if ($MyOps->insert_to_db($query))
				{
					$idDocumentoDebito=$MyOps->transac_id;
					$queryDetalle = "INSERT INTO detalle_documento_debito (iddocumento_debito,idproducto,idbodega,cantidad,precio,monto,fecha_insercion) 
								VALUES (".$idDocumentoDebito.",".$_POST["inputCodigo"].",1,'".$_POST["inputCantidad"]."','".$_POST["inputPrecio"]."','".$_POST["inputTotalCompra"]."',now());";
					if ($MyOps->insert_to_db($queryDetalle))
					{
						$idDetalle=$MyOps->transac_id;
						$queryMovimientoDocumento = "select idmovimiento from movimiento where idrelacion=".$idDocumentoDebito." and tabla_relacion='documento';";
						$res = $MyOps->list_orders($queryMovimientoDocumento);
						$filas=mysql_num_rows($res);
						if($filas > 0)
						{
							while ($row = mysql_fetch_assoc($res)) 
							{
								$idMovimientoDocumento=$row["idmovimiento"];
							}
							$y=$subTotalDetalle=0;
							$detalleVendido='<table class="table">
								<tr>
									<th></th>
									<th>Codigo</th>
									<th>Descripcion</th>
									<th>Precio</th>
									<th>Unidades</th>
									<th>Total</th>
								</tr>';
							$queryList = "SELECT d.iddetalle_documento_debito id, d.iddocumento_debito id2, d.idproducto id3, d.cantidad, d.precio, d.monto, p.nombre 
							FROM detalle_documento_debito d left join producto p on(p.idproducto = d.idproducto) WHERE d.iddocumento_debito = '".$idDocumentoDebito."';";
							$res = $MyOps->list_orders($queryList);
							$filas=mysql_num_rows($res);
							if($filas > 0)
							{
								while ($row = mysql_fetch_assoc($res)) 
								{
								$y++;
					$detalleVendido.='<tr>
										<td><button type="button" class="btn btn-danger" onclick="fncQuitarProducto();"><span class="glyphicon glyphicon-minus-sign"></span></button></td>
										<td>'.$row["id3"].'</td>
										<td>'.$row["nombre"].'</td>
										<td>'.$row["precio"].'</td>
										<td>'.$row["cantidad"].'</td>
										<td>'.$row["monto"].'</td>
									</tr>';
									$subTotalDetalle+=$row["monto"];
								}
							}
							else
							{
					$detalleVendido.='<tr>
										<td colspan=6><center><p class="text-info">  No ha registrado ningún producto a la compra.</p></center></td>
									</tr>';
							}
							
							$detalleVendido.='</table>';
							echo $detalleVendido;
							echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('inputIdDocumento').value = '".$idDocumentoDebito."'; document.getElementById('inputSubTotalDetalle').value = '".$subTotalDetalle."';  document.getElementById('inputIdMovimientoDocumento').value = '".$idMovimientoDocumento."';</SCRIPT>";
						}
					}
						
				}
			}
			else
			{
				$queryDetalle = "INSERT INTO detalle_documento_debito (iddocumento_debito,idproducto,idbodega,cantidad,precio,monto,fecha_insercion) 
								VALUES (".$_POST["inputIdDocumento"].",".$_POST["inputCodigo"].",1,'".$_POST["inputCantidad"]."','".$_POST["inputPrecio"]."','".$_POST["inputTotalCompra"]."',now());";
					if ($MyOps->insert_to_db($queryDetalle))
					{
						$y=$subTotalDetalle=0;
						$detalleVendido='<table class="table">
							<tr>
								<th></th>
								<th>Codigo</th>
								<th>Descripcion</th>
								<th>Precio</th>
								<th>Unidades</th>
								<th>Total</th>
							</tr>';
						$queryList = "SELECT d.iddetalle_documento_debito id, d.iddocumento_debito id2, d.idproducto id3, d.cantidad, d.precio, d.monto, p.nombre 
						FROM detalle_documento_debito d left join producto p on(p.idproducto = d.idproducto) WHERE d.iddocumento_debito = '".$_POST["inputIdDocumento"]."';";
						$res = $MyOps->list_orders($queryList);
						$filas=mysql_num_rows($res);
						if($filas > 0)
						{
							while ($row = mysql_fetch_assoc($res)) 
							{
							$y++;
				$detalleVendido.='<tr>
									<td><button type="button" class="btn btn-danger" onclick="fncQuitarProducto();"><span class="glyphicon glyphicon-minus-sign"></span></button></td>
									<td>'.$row["id3"].'</td>
									<td>'.$row["nombre"].'</td>
									<td>'.$row["precio"].'</td>
									<td>'.$row["cantidad"].'</td>
									<td>'.$row["monto"].'</td>
								</tr>';
								$subTotalDetalle+=$row["monto"];
							}
						}
						else
						{
				$detalleVendido.='<tr>
									<td colspan=6><center><p class="text-info">  No ha registrado ningún producto a la compra.</p></center></td>
								</tr>';
						}
						
						$detalleVendido.='</table>';
						echo $detalleVendido;
						echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('inputIdDocumento').value = '".$_POST["inputIdDocumento"]."';  document.getElementById('inputSubTotalDetalle').value = '".$subTotalDetalle."';</SCRIPT>";
					}
			}
			echo"<script>
					document.getElementById('inputCodigo').value='';
					document.getElementById('inputDescripcion').value='';
					document.getElementById('inputPrecio').value='';
					document.getElementById('inputCantidad').value='';
					document.getElementById('inputTotalCompra').value='';
					document.getElementById('inputCodigo').focus();
				</script>";
		}
		else
		{
			include('general_repository/php/error.php'); 
		}
	}
	else
	{
		include('general_repository/php/access_denied.php'); 
	}
	}
else
{
	include('general_repository/php/login.php'); 
}
?>