<?php

// nombre
// direccion
// idpais

?>
<?php if ($empresa->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $empresa->TableCaption() ?></h4> -->
<table id="tbl_empresamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($empresa->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $empresa->nombre->FldCaption() ?></td>
			<td<?php echo $empresa->nombre->CellAttributes() ?>>
<span id="el_empresa_nombre" class="form-group">
<span<?php echo $empresa->nombre->ViewAttributes() ?>>
<?php echo $empresa->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($empresa->direccion->Visible) { // direccion ?>
		<tr id="r_direccion">
			<td><?php echo $empresa->direccion->FldCaption() ?></td>
			<td<?php echo $empresa->direccion->CellAttributes() ?>>
<span id="el_empresa_direccion" class="form-group">
<span<?php echo $empresa->direccion->ViewAttributes() ?>>
<?php echo $empresa->direccion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($empresa->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $empresa->idpais->FldCaption() ?></td>
			<td<?php echo $empresa->idpais->CellAttributes() ?>>
<span id="el_empresa_idpais" class="form-group">
<span<?php echo $empresa->idpais->ViewAttributes() ?>>
<?php echo $empresa->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
