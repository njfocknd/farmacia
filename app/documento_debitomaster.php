<?php

// idtipo_documento
// idsucursal
// serie
// correlativo
// fecha
// idcliente
// nombre
// estado_documento
// idmoneda
// monto

?>
<?php if ($documento_debito->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $documento_debito->TableCaption() ?></h4> -->
<table id="tbl_documento_debitomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $documento_debito->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $documento_debito->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_debito_idtipo_documento" class="form-group">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_debito->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $documento_debito->idsucursal->FldCaption() ?></td>
			<td<?php echo $documento_debito->idsucursal->CellAttributes() ?>>
<span id="el_documento_debito_idsucursal" class="form-group">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<?php echo $documento_debito->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $documento_debito->serie->FldCaption() ?></td>
			<td<?php echo $documento_debito->serie->CellAttributes() ?>>
<span id="el_documento_debito_serie" class="form-group">
<span<?php echo $documento_debito->serie->ViewAttributes() ?>>
<?php echo $documento_debito->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->correlativo->Visible) { // correlativo ?>
		<tr id="r_correlativo">
			<td><?php echo $documento_debito->correlativo->FldCaption() ?></td>
			<td<?php echo $documento_debito->correlativo->CellAttributes() ?>>
<span id="el_documento_debito_correlativo" class="form-group">
<span<?php echo $documento_debito->correlativo->ViewAttributes() ?>>
<?php echo $documento_debito->correlativo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $documento_debito->fecha->FldCaption() ?></td>
			<td<?php echo $documento_debito->fecha->CellAttributes() ?>>
<span id="el_documento_debito_fecha" class="form-group">
<span<?php echo $documento_debito->fecha->ViewAttributes() ?>>
<?php echo $documento_debito->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
		<tr id="r_idcliente">
			<td><?php echo $documento_debito->idcliente->FldCaption() ?></td>
			<td<?php echo $documento_debito->idcliente->CellAttributes() ?>>
<span id="el_documento_debito_idcliente" class="form-group">
<span<?php echo $documento_debito->idcliente->ViewAttributes() ?>>
<?php echo $documento_debito->idcliente->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $documento_debito->nombre->FldCaption() ?></td>
			<td<?php echo $documento_debito->nombre->CellAttributes() ?>>
<span id="el_documento_debito_nombre" class="form-group">
<span<?php echo $documento_debito->nombre->ViewAttributes() ?>>
<?php echo $documento_debito->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
		<tr id="r_estado_documento">
			<td><?php echo $documento_debito->estado_documento->FldCaption() ?></td>
			<td<?php echo $documento_debito->estado_documento->CellAttributes() ?>>
<span id="el_documento_debito_estado_documento" class="form-group">
<span<?php echo $documento_debito->estado_documento->ViewAttributes() ?>>
<?php echo $documento_debito->estado_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->idmoneda->Visible) { // idmoneda ?>
		<tr id="r_idmoneda">
			<td><?php echo $documento_debito->idmoneda->FldCaption() ?></td>
			<td<?php echo $documento_debito->idmoneda->CellAttributes() ?>>
<span id="el_documento_debito_idmoneda" class="form-group">
<span<?php echo $documento_debito->idmoneda->ViewAttributes() ?>>
<?php echo $documento_debito->idmoneda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($documento_debito->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $documento_debito->monto->FldCaption() ?></td>
			<td<?php echo $documento_debito->monto->CellAttributes() ?>>
<span id="el_documento_debito_monto" class="form-group">
<span<?php echo $documento_debito->monto->ViewAttributes() ?>>
<?php echo $documento_debito->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
