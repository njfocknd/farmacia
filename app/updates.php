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
		if(isset($_POST["nit_cliente"])&&isset($_POST["nombre_cliente"])&&isset($_POST["direccion_cliente"])&&isset($_POST["inputIdCliente"])&&isset($_POST["inputIdDocumento"])&&isset($_POST["inputCodigo"])&&isset($_POST["inputDescripcion"])&&isset($_POST["inputPrecio"])&&isset($_POST["inputCantidad"])&&isset($_POST["inputTotalCompra"])&&isset($_POST["creaDocumentoDetalle"]))
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
						$y=0;
						$detalleVendido='';
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
									<td><button type="submit" class="btn btn-danger" onclick="fncQuitarProducto();"><span class="glyphicon glyphicon-minus-sign"></span></button></td>
									<td>'.$row["id3"].'</td>
									<td>'.$row["nombre"].'</td>
									<td>'.$row["precio"].'</td>
									<td>'.$row["cantidad"].'</td>
									<td>'.$row["monto"].'</td>
								</tr>';
							}
						}
						else
						{
				$detalleVendido.='<tr>
									<td colspan=6><center><p class="text-info">  No ha registrado ningún producto a la compra.</p></center></td>
								</tr>';
						}
						echo $detalleVendido;
						//echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('inputIdDocumento').value = '".$idDetalle."';</SCRIPT>";
					}
						
				}
			}
			else
			{
				$queryDetalle = "INSERT INTO detalle_documento_debito (iddocumento_debito,idproducto,idbodega,cantidad,precio,monto,fecha_insercion) 
								VALUES (".$idDocumentoDebito.",".$_POST["inputCodigo"].",1,'".$_POST["inputCantidad"]."','".$_POST["inputPrecio"]."','".$_POST["inputTotalCompra"]."',now());";
					if ($MyOps->insert_to_db($queryDetalle))
					{
						echo "<SCRIPT LANGUAGE=\"JavaScript\">document.getElementById('inputIdDocumento').value = '".$_POST["inputIdDocumento"]."';</SCRIPT>";
					}
			}
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