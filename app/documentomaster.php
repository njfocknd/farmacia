<?php

// idtipo_documento
// idsucursal
// serie
// correlativo
// fecha
// nombre
// estado_documento
// monto
// fecha_insercion
// idcliente

?>
<?php if ($documento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $documento->TableCaption() ?></h4> -->
<table id="tbl_documentomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($documento->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $documento->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $documento->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_idtipo_documento" class="form-group">
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $documento->idsucursal->FldCaption() ?></td>
			<td<?php echo $documento->idsucursal->CellAttributes() ?>>
<span id="el_documento_idsucursal" class="form-group">
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<?php echo $documento->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $documento->serie->FldCaption() ?></td>
			<td<?php echo $documento->serie->CellAttributes() ?>>
<span id="el_documento_serie" class="form-group">
<span<?php echo $documento->serie->ViewAttributes() ?>>
<?php echo $documento->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->correlativo->Visible) { // correlativo ?>
		<tr id="r_correlativo">
			<td><?php echo $documento->correlativo->FldCaption() ?></td>
			<td<?php echo $documento->correlativo->CellAttributes() ?>>
<span id="el_documento_correlativo" class="form-group">
<span<?php echo $documento->correlativo->ViewAttributes() ?>>
<?php echo $documento->correlativo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $documento->fecha->FldCaption() ?></td>
			<td<?php echo $documento->fecha->CellAttributes() ?>>
<span id="el_documento_fecha" class="form-group">
<span<?php echo $documento->fecha->ViewAttributes() ?>>
<?php echo $documento->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $documento->nombre->FldCaption() ?></td>
			<td<?php echo $documento->nombre->CellAttributes() ?>>
<span id="el_documento_nombre" class="form-group">
<span<?php echo $documento->nombre->ViewAttributes() ?>>
<?php echo $documento->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->estado_documento->Visible) { // estado_documento ?>
		<tr id="r_estado_documento">
			<td><?php echo $documento->estado_documento->FldCaption() ?></td>
			<td<?php echo $documento->estado_documento->CellAttributes() ?>>
<span id="el_documento_estado_documento" class="form-group">
<span<?php echo $documento->estado_documento->ViewAttributes() ?>>
<?php echo $documento->estado_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $documento->monto->FldCaption() ?></td>
			<td<?php echo $documento->monto->CellAttributes() ?>>
<span id="el_documento_monto" class="form-group">
<span<?php echo $documento->monto->ViewAttributes() ?>>
<?php echo $documento->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $documento->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $documento->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_fecha_insercion" class="form-group">
<span<?php echo $documento->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento->idcliente->Visible) { // idcliente ?>
		<tr id="r_idcliente">
			<td><?php echo $documento->idcliente->FldCaption() ?></td>
			<td<?php echo $documento->idcliente->CellAttributes() ?>>
<span id="el_documento_idcliente" class="form-group">
<span<?php echo $documento->idcliente->ViewAttributes() ?>>
<?php echo $documento->idcliente->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
