<?php

// idbanco
// idcuenta
// marca
// nombre
// ultimos_cuatro_digitos
// referencia
// fecha
// monto

?>
<?php if ($voucher_tarjeta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $voucher_tarjeta->TableCaption() ?></h4> -->
<table id="tbl_voucher_tarjetamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($voucher_tarjeta->idbanco->Visible) { // idbanco ?>
		<tr id="r_idbanco">
			<td><?php echo $voucher_tarjeta->idbanco->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->idbanco->CellAttributes() ?>>
<span id="el_voucher_tarjeta_idbanco" class="form-group">
<span<?php echo $voucher_tarjeta->idbanco->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->idbanco->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->idcuenta->Visible) { // idcuenta ?>
		<tr id="r_idcuenta">
			<td><?php echo $voucher_tarjeta->idcuenta->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->idcuenta->CellAttributes() ?>>
<span id="el_voucher_tarjeta_idcuenta" class="form-group">
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->idcuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->marca->Visible) { // marca ?>
		<tr id="r_marca">
			<td><?php echo $voucher_tarjeta->marca->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->marca->CellAttributes() ?>>
<span id="el_voucher_tarjeta_marca" class="form-group">
<span<?php echo $voucher_tarjeta->marca->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->marca->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $voucher_tarjeta->nombre->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->nombre->CellAttributes() ?>>
<span id="el_voucher_tarjeta_nombre" class="form-group">
<span<?php echo $voucher_tarjeta->nombre->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->ultimos_cuatro_digitos->Visible) { // ultimos_cuatro_digitos ?>
		<tr id="r_ultimos_cuatro_digitos">
			<td><?php echo $voucher_tarjeta->ultimos_cuatro_digitos->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->CellAttributes() ?>>
<span id="el_voucher_tarjeta_ultimos_cuatro_digitos" class="form-group">
<span<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->referencia->Visible) { // referencia ?>
		<tr id="r_referencia">
			<td><?php echo $voucher_tarjeta->referencia->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->referencia->CellAttributes() ?>>
<span id="el_voucher_tarjeta_referencia" class="form-group">
<span<?php echo $voucher_tarjeta->referencia->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->referencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $voucher_tarjeta->fecha->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->fecha->CellAttributes() ?>>
<span id="el_voucher_tarjeta_fecha" class="form-group">
<span<?php echo $voucher_tarjeta->fecha->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($voucher_tarjeta->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $voucher_tarjeta->monto->FldCaption() ?></td>
			<td<?php echo $voucher_tarjeta->monto->CellAttributes() ?>>
<span id="el_voucher_tarjeta_monto" class="form-group">
<span<?php echo $voucher_tarjeta->monto->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
