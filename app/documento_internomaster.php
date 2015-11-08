<?php

// idtipo_documento
// serie
// correlativo
// fecha
// estado_documento
// idsucursal_ingreso
// idsucursal_egreso
// monto

?>
<?php if ($documento_interno->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $documento_interno->TableCaption() ?></h4> -->
<table id="tbl_documento_internomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($documento_interno->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $documento_interno->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $documento_interno->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_interno_idtipo_documento" class="form-group">
<span<?php echo $documento_interno->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_interno->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $documento_interno->serie->FldCaption() ?></td>
			<td<?php echo $documento_interno->serie->CellAttributes() ?>>
<span id="el_documento_interno_serie" class="form-group">
<span<?php echo $documento_interno->serie->ViewAttributes() ?>>
<?php echo $documento_interno->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->correlativo->Visible) { // correlativo ?>
		<tr id="r_correlativo">
			<td><?php echo $documento_interno->correlativo->FldCaption() ?></td>
			<td<?php echo $documento_interno->correlativo->CellAttributes() ?>>
<span id="el_documento_interno_correlativo" class="form-group">
<span<?php echo $documento_interno->correlativo->ViewAttributes() ?>>
<?php echo $documento_interno->correlativo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $documento_interno->fecha->FldCaption() ?></td>
			<td<?php echo $documento_interno->fecha->CellAttributes() ?>>
<span id="el_documento_interno_fecha" class="form-group">
<span<?php echo $documento_interno->fecha->ViewAttributes() ?>>
<?php echo $documento_interno->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->estado_documento->Visible) { // estado_documento ?>
		<tr id="r_estado_documento">
			<td><?php echo $documento_interno->estado_documento->FldCaption() ?></td>
			<td<?php echo $documento_interno->estado_documento->CellAttributes() ?>>
<span id="el_documento_interno_estado_documento" class="form-group">
<span<?php echo $documento_interno->estado_documento->ViewAttributes() ?>>
<?php echo $documento_interno->estado_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->idsucursal_ingreso->Visible) { // idsucursal_ingreso ?>
		<tr id="r_idsucursal_ingreso">
			<td><?php echo $documento_interno->idsucursal_ingreso->FldCaption() ?></td>
			<td<?php echo $documento_interno->idsucursal_ingreso->CellAttributes() ?>>
<span id="el_documento_interno_idsucursal_ingreso" class="form-group">
<span<?php echo $documento_interno->idsucursal_ingreso->ViewAttributes() ?>>
<?php echo $documento_interno->idsucursal_ingreso->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->idsucursal_egreso->Visible) { // idsucursal_egreso ?>
		<tr id="r_idsucursal_egreso">
			<td><?php echo $documento_interno->idsucursal_egreso->FldCaption() ?></td>
			<td<?php echo $documento_interno->idsucursal_egreso->CellAttributes() ?>>
<span id="el_documento_interno_idsucursal_egreso" class="form-group">
<span<?php echo $documento_interno->idsucursal_egreso->ViewAttributes() ?>>
<?php echo $documento_interno->idsucursal_egreso->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_interno->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $documento_interno->monto->FldCaption() ?></td>
			<td<?php echo $documento_interno->monto->CellAttributes() ?>>
<span id="el_documento_interno_monto" class="form-group">
<span<?php echo $documento_interno->monto->ViewAttributes() ?>>
<?php echo $documento_interno->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
