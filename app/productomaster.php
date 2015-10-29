<?php

// idmarca
// nombre
// idpais
// existencia
// estado

?>
<?php if ($producto->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $producto->TableCaption() ?></h4> -->
<table id="tbl_productomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($producto->idmarca->Visible) { // idmarca ?>
		<tr id="r_idmarca">
			<td><?php echo $producto->idmarca->FldCaption() ?></td>
			<td<?php echo $producto->idmarca->CellAttributes() ?>>
<span id="el_producto_idmarca" class="form-group">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<?php echo $producto->idmarca->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $producto->nombre->FldCaption() ?></td>
			<td<?php echo $producto->nombre->CellAttributes() ?>>
<span id="el_producto_nombre" class="form-group">
<span<?php echo $producto->nombre->ViewAttributes() ?>>
<?php echo $producto->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $producto->idpais->FldCaption() ?></td>
			<td<?php echo $producto->idpais->CellAttributes() ?>>
<span id="el_producto_idpais" class="form-group">
<span<?php echo $producto->idpais->ViewAttributes() ?>>
<?php echo $producto->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->existencia->Visible) { // existencia ?>
		<tr id="r_existencia">
			<td><?php echo $producto->existencia->FldCaption() ?></td>
			<td<?php echo $producto->existencia->CellAttributes() ?>>
<span id="el_producto_existencia" class="form-group">
<span<?php echo $producto->existencia->ViewAttributes() ?>>
<?php echo $producto->existencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $producto->estado->FldCaption() ?></td>
			<td<?php echo $producto->estado->CellAttributes() ?>>
<span id="el_producto_estado" class="form-group">
<span<?php echo $producto->estado->ViewAttributes() ?>>
<?php echo $producto->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
