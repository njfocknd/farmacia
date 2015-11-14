<meta charset="ISO-8859-1">
<?php
function fncDesignCombo($MyOps, $query,$name,$function,$prefix,$suffix,$selected,$error){
	$count=0;
	$combo="<select id ='".$name."' name ='".$name."' ".$function." class='form-control'>";
	$combo.=$prefix;
	$res = $MyOps->list_orders($query);
	if ($res){
		while ($row = mysql_fetch_assoc($res)) {
			$count++;
			if ($selected==$row['id'])
				$combo.="<option value='".$row['id']."' selected>".$row["name"]." *</option>";
			else
				$combo.="<option value='".$row['id']."'>".$row["name"]."</option>";
		}
	}
	$combo.=$suffix."</select>";
	if ($count==0){
		$alert="<SCRIPT LANGUAGE=\"JavaScript\">Alertify.dialog.labels.ok ='Aceptar';Alertify.dialog.alert('<img src=\'general_repository/image/stop_48x48.png\'><b><big>Error en  ".$error."</big></b>');</SCRIPT>";
		$combo.=$alert." <img src='general_repository/image/stop_24x24.png'> <font color =red><b>Error en el Selector</b></font>";
	}
	return $combo;
}

function operar_query ($objeto, $new_query, &$arr_datos,$option){
	$res = $objeto->list_orders($new_query);
	$allowed = false;
	if($res){
	$linea=0;		
	while ($row = mysql_fetch_assoc($res)) {
		set_data_to_array($row, $arr_datos,$option);
		}
	}
}
?>