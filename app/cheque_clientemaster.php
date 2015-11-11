<?php

// idbanco
// numero
// propietario
// cuenta
// monto
// fecha
// cheque_estado

?>
<?php if ($cheque_cliente->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $cheque_cliente->TableCaption() ?></h4> -->
<table id="tbl_cheque_clientemaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($cheque_cliente->idbanco->Visible) { // idbanco ?>
		<tr id="r_idbanco">
			<td><?php echo $cheque_cliente->idbanco->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->idbanco->CellAttributes() ?>>
<span id="el_cheque_cliente_idbanco" class="form-group">
<span<?php echo $cheque_cliente->idbanco->ViewAttributes() ?>>
<?php echo $cheque_cliente->idbanco->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->numero->Visible) { // numero ?>
		<tr id="r_numero">
			<td><?php echo $cheque_cliente->numero->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->numero->CellAttributes() ?>>
<span id="el_cheque_cliente_numero" class="form-group">
<span<?php echo $cheque_cliente->numero->ViewAttributes() ?>>
<?php echo $cheque_cliente->numero->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->propietario->Visible) { // propietario ?>
		<tr id="r_propietario">
			<td><?php echo $cheque_cliente->propietario->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->propietario->CellAttributes() ?>>
<span id="el_cheque_cliente_propietario" class="form-group">
<span<?php echo $cheque_cliente->propietario->ViewAttributes() ?>>
<?php echo $cheque_cliente->propietario->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->cuenta->Visible) { // cuenta ?>
		<tr id="r_cuenta">
			<td><?php echo $cheque_cliente->cuenta->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->cuenta->CellAttributes() ?>>
<span id="el_cheque_cliente_cuenta" class="form-group">
<span<?php echo $cheque_cliente->cuenta->ViewAttributes() ?>>
<?php echo $cheque_cliente->cuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $cheque_cliente->monto->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->monto->CellAttributes() ?>>
<span id="el_cheque_cliente_monto" class="form-group">
<span<?php echo $cheque_cliente->monto->ViewAttributes() ?>>
<?php echo $cheque_cliente->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $cheque_cliente->fecha->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->fecha->CellAttributes() ?>>
<span id="el_cheque_cliente_fecha" class="form-group">
<span<?php echo $cheque_cliente->fecha->ViewAttributes() ?>>
<?php echo $cheque_cliente->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cheque_cliente->cheque_estado->Visible) { // cheque_estado ?>
		<tr id="r_cheque_estado">
			<td><?php echo $cheque_cliente->cheque_estado->FldCaption() ?></td>
			<td<?php echo $cheque_cliente->cheque_estado->CellAttributes() ?>>
<span id="el_cheque_cliente_cheque_estado" class="form-group">
<span<?php echo $cheque_cliente->cheque_estado->ViewAttributes() ?>>
<?php echo $cheque_cliente->cheque_estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
