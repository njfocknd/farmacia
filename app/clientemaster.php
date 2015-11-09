<?php

// idpersona
// nit
// nombre_factura
// direccion_factura

?>
<?php if ($cliente->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $cliente->TableCaption() ?></h4> -->
<table id="tbl_clientemaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($cliente->idpersona->Visible) { // idpersona ?>
		<tr id="r_idpersona">
			<td><?php echo $cliente->idpersona->FldCaption() ?></td>
			<td<?php echo $cliente->idpersona->CellAttributes() ?>>
<span id="el_cliente_idpersona" class="form-group">
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<?php echo $cliente->idpersona->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cliente->nit->Visible) { // nit ?>
		<tr id="r_nit">
			<td><?php echo $cliente->nit->FldCaption() ?></td>
			<td<?php echo $cliente->nit->CellAttributes() ?>>
<span id="el_cliente_nit" class="form-group">
<span<?php echo $cliente->nit->ViewAttributes() ?>>
<?php echo $cliente->nit->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cliente->nombre_factura->Visible) { // nombre_factura ?>
		<tr id="r_nombre_factura">
			<td><?php echo $cliente->nombre_factura->FldCaption() ?></td>
			<td<?php echo $cliente->nombre_factura->CellAttributes() ?>>
<span id="el_cliente_nombre_factura" class="form-group">
<span<?php echo $cliente->nombre_factura->ViewAttributes() ?>>
<?php echo $cliente->nombre_factura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cliente->direccion_factura->Visible) { // direccion_factura ?>
		<tr id="r_direccion_factura">
			<td><?php echo $cliente->direccion_factura->FldCaption() ?></td>
			<td<?php echo $cliente->direccion_factura->CellAttributes() ?>>
<span id="el_cliente_direccion_factura" class="form-group">
<span<?php echo $cliente->direccion_factura->ViewAttributes() ?>>
<?php echo $cliente->direccion_factura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
