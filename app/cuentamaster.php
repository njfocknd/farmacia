<?php

// idbanco
// idsucursal
// numero
// nombre
// idmoneda
// saldo

?>
<?php if ($cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $cuenta->TableCaption() ?></h4> -->
<table id="tbl_cuentamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($cuenta->idbanco->Visible) { // idbanco ?>
		<tr id="r_idbanco">
			<td><?php echo $cuenta->idbanco->FldCaption() ?></td>
			<td<?php echo $cuenta->idbanco->CellAttributes() ?>>
<span id="el_cuenta_idbanco" class="form-group">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<?php echo $cuenta->idbanco->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $cuenta->idsucursal->FldCaption() ?></td>
			<td<?php echo $cuenta->idsucursal->CellAttributes() ?>>
<span id="el_cuenta_idsucursal" class="form-group">
<span<?php echo $cuenta->idsucursal->ViewAttributes() ?>>
<?php echo $cuenta->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta->numero->Visible) { // numero ?>
		<tr id="r_numero">
			<td><?php echo $cuenta->numero->FldCaption() ?></td>
			<td<?php echo $cuenta->numero->CellAttributes() ?>>
<span id="el_cuenta_numero" class="form-group">
<span<?php echo $cuenta->numero->ViewAttributes() ?>>
<?php echo $cuenta->numero->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $cuenta->nombre->CellAttributes() ?>>
<span id="el_cuenta_nombre" class="form-group">
<span<?php echo $cuenta->nombre->ViewAttributes() ?>>
<?php echo $cuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta->idmoneda->Visible) { // idmoneda ?>
		<tr id="r_idmoneda">
			<td><?php echo $cuenta->idmoneda->FldCaption() ?></td>
			<td<?php echo $cuenta->idmoneda->CellAttributes() ?>>
<span id="el_cuenta_idmoneda" class="form-group">
<span<?php echo $cuenta->idmoneda->ViewAttributes() ?>>
<?php echo $cuenta->idmoneda->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta->saldo->Visible) { // saldo ?>
		<tr id="r_saldo">
			<td><?php echo $cuenta->saldo->FldCaption() ?></td>
			<td<?php echo $cuenta->saldo->CellAttributes() ?>>
<span id="el_cuenta_saldo" class="form-group">
<span<?php echo $cuenta->saldo->ViewAttributes() ?>>
<?php echo $cuenta->saldo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
