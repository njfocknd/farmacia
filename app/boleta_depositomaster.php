<?php

// idbanco
// idcuenta
// numero
// fecha
// monto

?>
<?php if ($boleta_deposito->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $boleta_deposito->TableCaption() ?></h4> -->
<table id="tbl_boleta_depositomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($boleta_deposito->idbanco->Visible) { // idbanco ?>
		<tr id="r_idbanco">
			<td><?php echo $boleta_deposito->idbanco->FldCaption() ?></td>
			<td<?php echo $boleta_deposito->idbanco->CellAttributes() ?>>
<span id="el_boleta_deposito_idbanco" class="form-group">
<span<?php echo $boleta_deposito->idbanco->ViewAttributes() ?>>
<?php echo $boleta_deposito->idbanco->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($boleta_deposito->idcuenta->Visible) { // idcuenta ?>
		<tr id="r_idcuenta">
			<td><?php echo $boleta_deposito->idcuenta->FldCaption() ?></td>
			<td<?php echo $boleta_deposito->idcuenta->CellAttributes() ?>>
<span id="el_boleta_deposito_idcuenta" class="form-group">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<?php echo $boleta_deposito->idcuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($boleta_deposito->numero->Visible) { // numero ?>
		<tr id="r_numero">
			<td><?php echo $boleta_deposito->numero->FldCaption() ?></td>
			<td<?php echo $boleta_deposito->numero->CellAttributes() ?>>
<span id="el_boleta_deposito_numero" class="form-group">
<span<?php echo $boleta_deposito->numero->ViewAttributes() ?>>
<?php echo $boleta_deposito->numero->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($boleta_deposito->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $boleta_deposito->fecha->FldCaption() ?></td>
			<td<?php echo $boleta_deposito->fecha->CellAttributes() ?>>
<span id="el_boleta_deposito_fecha" class="form-group">
<span<?php echo $boleta_deposito->fecha->ViewAttributes() ?>>
<?php echo $boleta_deposito->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($boleta_deposito->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $boleta_deposito->monto->FldCaption() ?></td>
			<td<?php echo $boleta_deposito->monto->CellAttributes() ?>>
<span id="el_boleta_deposito_monto" class="form-group">
<span<?php echo $boleta_deposito->monto->ViewAttributes() ?>>
<?php echo $boleta_deposito->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
