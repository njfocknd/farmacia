<?php

// nombre
// idmunicipio
// idempresa

?>
<?php if ($sucursal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $sucursal->TableCaption() ?></h4> -->
<table id="tbl_sucursalmaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($sucursal->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $sucursal->nombre->FldCaption() ?></td>
			<td<?php echo $sucursal->nombre->CellAttributes() ?>>
<span id="el_sucursal_nombre" class="form-group">
<span<?php echo $sucursal->nombre->ViewAttributes() ?>>
<?php echo $sucursal->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($sucursal->idmunicipio->Visible) { // idmunicipio ?>
		<tr id="r_idmunicipio">
			<td><?php echo $sucursal->idmunicipio->FldCaption() ?></td>
			<td<?php echo $sucursal->idmunicipio->CellAttributes() ?>>
<span id="el_sucursal_idmunicipio" class="form-group">
<span<?php echo $sucursal->idmunicipio->ViewAttributes() ?>>
<?php echo $sucursal->idmunicipio->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $sucursal->idempresa->FldCaption() ?></td>
			<td<?php echo $sucursal->idempresa->CellAttributes() ?>>
<span id="el_sucursal_idempresa" class="form-group">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<?php echo $sucursal->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
