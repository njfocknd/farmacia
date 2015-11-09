<?php

// idtipo_documento
// idsucursal
// serie
// correlativo
// fecha
// observaciones
// estado_documento
// estado
// monto
// fecha_insercion
// idproveedor

?>
<?php if ($documento_credito->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $documento_credito->TableCaption() ?></h4> -->
<table id="tbl_documento_creditomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($documento_credito->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $documento_credito->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $documento_credito->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_credito_idtipo_documento" class="form-group">
<span<?php echo $documento_credito->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_credito->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $documento_credito->idsucursal->FldCaption() ?></td>
			<td<?php echo $documento_credito->idsucursal->CellAttributes() ?>>
<span id="el_documento_credito_idsucursal" class="form-group">
<span<?php echo $documento_credito->idsucursal->ViewAttributes() ?>>
<?php echo $documento_credito->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $documento_credito->serie->FldCaption() ?></td>
			<td<?php echo $documento_credito->serie->CellAttributes() ?>>
<span id="el_documento_credito_serie" class="form-group">
<span<?php echo $documento_credito->serie->ViewAttributes() ?>>
<?php echo $documento_credito->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->correlativo->Visible) { // correlativo ?>
		<tr id="r_correlativo">
			<td><?php echo $documento_credito->correlativo->FldCaption() ?></td>
			<td<?php echo $documento_credito->correlativo->CellAttributes() ?>>
<span id="el_documento_credito_correlativo" class="form-group">
<span<?php echo $documento_credito->correlativo->ViewAttributes() ?>>
<?php echo $documento_credito->correlativo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $documento_credito->fecha->FldCaption() ?></td>
			<td<?php echo $documento_credito->fecha->CellAttributes() ?>>
<span id="el_documento_credito_fecha" class="form-group">
<span<?php echo $documento_credito->fecha->ViewAttributes() ?>>
<?php echo $documento_credito->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->observaciones->Visible) { // observaciones ?>
		<tr id="r_observaciones">
			<td><?php echo $documento_credito->observaciones->FldCaption() ?></td>
			<td<?php echo $documento_credito->observaciones->CellAttributes() ?>>
<span id="el_documento_credito_observaciones" class="form-group">
<span<?php echo $documento_credito->observaciones->ViewAttributes() ?>>
<?php echo $documento_credito->observaciones->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->estado_documento->Visible) { // estado_documento ?>
		<tr id="r_estado_documento">
			<td><?php echo $documento_credito->estado_documento->FldCaption() ?></td>
			<td<?php echo $documento_credito->estado_documento->CellAttributes() ?>>
<span id="el_documento_credito_estado_documento" class="form-group">
<span<?php echo $documento_credito->estado_documento->ViewAttributes() ?>>
<?php echo $documento_credito->estado_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $documento_credito->estado->FldCaption() ?></td>
			<td<?php echo $documento_credito->estado->CellAttributes() ?>>
<span id="el_documento_credito_estado" class="form-group">
<span<?php echo $documento_credito->estado->ViewAttributes() ?>>
<?php echo $documento_credito->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $documento_credito->monto->FldCaption() ?></td>
			<td<?php echo $documento_credito->monto->CellAttributes() ?>>
<span id="el_documento_credito_monto" class="form-group">
<span<?php echo $documento_credito->monto->ViewAttributes() ?>>
<?php echo $documento_credito->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $documento_credito->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $documento_credito->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_credito_fecha_insercion" class="form-group">
<span<?php echo $documento_credito->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_credito->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_credito->idproveedor->Visible) { // idproveedor ?>
		<tr id="r_idproveedor">
			<td><?php echo $documento_credito->idproveedor->FldCaption() ?></td>
			<td<?php echo $documento_credito->idproveedor->CellAttributes() ?>>
<span id="el_documento_credito_idproveedor" class="form-group">
<span<?php echo $documento_credito->idproveedor->ViewAttributes() ?>>
<?php echo $documento_credito->idproveedor->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
