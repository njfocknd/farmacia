<?php

// nombre
// idpais
// estado
// fecha_insercion

?>
<?php if ($fabricante->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $fabricante->TableCaption() ?></h4> -->
<table id="tbl_fabricantemaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($fabricante->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $fabricante->nombre->FldCaption() ?></td>
			<td<?php echo $fabricante->nombre->CellAttributes() ?>>
<span id="el_fabricante_nombre" class="form-group">
<span<?php echo $fabricante->nombre->ViewAttributes() ?>>
<?php echo $fabricante->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fabricante->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $fabricante->idpais->FldCaption() ?></td>
			<td<?php echo $fabricante->idpais->CellAttributes() ?>>
<span id="el_fabricante_idpais" class="form-group">
<span<?php echo $fabricante->idpais->ViewAttributes() ?>>
<?php echo $fabricante->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fabricante->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $fabricante->estado->FldCaption() ?></td>
			<td<?php echo $fabricante->estado->CellAttributes() ?>>
<span id="el_fabricante_estado" class="form-group">
<span<?php echo $fabricante->estado->ViewAttributes() ?>>
<?php echo $fabricante->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($fabricante->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $fabricante->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $fabricante->fecha_insercion->CellAttributes() ?>>
<span id="el_fabricante_fecha_insercion" class="form-group">
<span<?php echo $fabricante->fecha_insercion->ViewAttributes() ?>>
<?php echo $fabricante->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
