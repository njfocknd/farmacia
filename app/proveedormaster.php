<?php

// nit
// nombre_factura
// direccion_factura
// email

?>
<?php if ($proveedor->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $proveedor->TableCaption() ?></h4> -->
<table id="tbl_proveedormaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($proveedor->nit->Visible) { // nit ?>
		<tr id="r_nit">
			<td><?php echo $proveedor->nit->FldCaption() ?></td>
			<td<?php echo $proveedor->nit->CellAttributes() ?>>
<span id="el_proveedor_nit" class="form-group">
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<?php echo $proveedor->nit->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
		<tr id="r_nombre_factura">
			<td><?php echo $proveedor->nombre_factura->FldCaption() ?></td>
			<td<?php echo $proveedor->nombre_factura->CellAttributes() ?>>
<span id="el_proveedor_nombre_factura" class="form-group">
<span<?php echo $proveedor->nombre_factura->ViewAttributes() ?>>
<?php echo $proveedor->nombre_factura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
		<tr id="r_direccion_factura">
			<td><?php echo $proveedor->direccion_factura->FldCaption() ?></td>
			<td<?php echo $proveedor->direccion_factura->CellAttributes() ?>>
<span id="el_proveedor_direccion_factura" class="form-group">
<span<?php echo $proveedor->direccion_factura->ViewAttributes() ?>>
<?php echo $proveedor->direccion_factura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($proveedor->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $proveedor->_email->FldCaption() ?></td>
			<td<?php echo $proveedor->_email->CellAttributes() ?>>
<span id="el_proveedor__email" class="form-group">
<span<?php echo $proveedor->_email->ViewAttributes() ?>>
<?php echo $proveedor->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
