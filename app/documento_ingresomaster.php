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
<?php if ($documento_ingreso->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $documento_ingreso->TableCaption() ?></h4> -->
<table id="tbl_documento_ingresomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($documento_ingreso->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $documento_ingreso->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_ingreso_idtipo_documento" class="form-group">
<span<?php echo $documento_ingreso->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_ingreso->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $documento_ingreso->idsucursal->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->idsucursal->CellAttributes() ?>>
<span id="el_documento_ingreso_idsucursal" class="form-group">
<span<?php echo $documento_ingreso->idsucursal->ViewAttributes() ?>>
<?php echo $documento_ingreso->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $documento_ingreso->serie->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->serie->CellAttributes() ?>>
<span id="el_documento_ingreso_serie" class="form-group">
<span<?php echo $documento_ingreso->serie->ViewAttributes() ?>>
<?php echo $documento_ingreso->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->correlativo->Visible) { // correlativo ?>
		<tr id="r_correlativo">
			<td><?php echo $documento_ingreso->correlativo->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->correlativo->CellAttributes() ?>>
<span id="el_documento_ingreso_correlativo" class="form-group">
<span<?php echo $documento_ingreso->correlativo->ViewAttributes() ?>>
<?php echo $documento_ingreso->correlativo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $documento_ingreso->fecha->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->fecha->CellAttributes() ?>>
<span id="el_documento_ingreso_fecha" class="form-group">
<span<?php echo $documento_ingreso->fecha->ViewAttributes() ?>>
<?php echo $documento_ingreso->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->observaciones->Visible) { // observaciones ?>
		<tr id="r_observaciones">
			<td><?php echo $documento_ingreso->observaciones->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->observaciones->CellAttributes() ?>>
<span id="el_documento_ingreso_observaciones" class="form-group">
<span<?php echo $documento_ingreso->observaciones->ViewAttributes() ?>>
<?php echo $documento_ingreso->observaciones->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->estado_documento->Visible) { // estado_documento ?>
		<tr id="r_estado_documento">
			<td><?php echo $documento_ingreso->estado_documento->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->estado_documento->CellAttributes() ?>>
<span id="el_documento_ingreso_estado_documento" class="form-group">
<span<?php echo $documento_ingreso->estado_documento->ViewAttributes() ?>>
<?php echo $documento_ingreso->estado_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $documento_ingreso->estado->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->estado->CellAttributes() ?>>
<span id="el_documento_ingreso_estado" class="form-group">
<span<?php echo $documento_ingreso->estado->ViewAttributes() ?>>
<?php echo $documento_ingreso->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $documento_ingreso->monto->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->monto->CellAttributes() ?>>
<span id="el_documento_ingreso_monto" class="form-group">
<span<?php echo $documento_ingreso->monto->ViewAttributes() ?>>
<?php echo $documento_ingreso->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $documento_ingreso->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_ingreso_fecha_insercion" class="form-group">
<span<?php echo $documento_ingreso->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_ingreso->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_ingreso->idproveedor->Visible) { // idproveedor ?>
		<tr id="r_idproveedor">
			<td><?php echo $documento_ingreso->idproveedor->FldCaption() ?></td>
			<td<?php echo $documento_ingreso->idproveedor->CellAttributes() ?>>
<span id="el_documento_ingreso_idproveedor" class="form-group">
<span<?php echo $documento_ingreso->idproveedor->ViewAttributes() ?>>
<?php echo $documento_ingreso->idproveedor->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
