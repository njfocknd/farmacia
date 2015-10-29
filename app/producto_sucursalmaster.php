<?php

// idproducto
// idsucursal
// existencia

?>
<?php if ($producto_sucursal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $producto_sucursal->TableCaption() ?></h4> -->
<table id="tbl_producto_sucursalmaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($producto_sucursal->idproducto->Visible) { // idproducto ?>
		<tr id="r_idproducto">
			<td><?php echo $producto_sucursal->idproducto->FldCaption() ?></td>
			<td<?php echo $producto_sucursal->idproducto->CellAttributes() ?>>
<span id="el_producto_sucursal_idproducto" class="form-group">
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<?php echo $producto_sucursal->idproducto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto_sucursal->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $producto_sucursal->idsucursal->FldCaption() ?></td>
			<td<?php echo $producto_sucursal->idsucursal->CellAttributes() ?>>
<span id="el_producto_sucursal_idsucursal" class="form-group">
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<?php echo $producto_sucursal->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto_sucursal->existencia->Visible) { // existencia ?>
		<tr id="r_existencia">
			<td><?php echo $producto_sucursal->existencia->FldCaption() ?></td>
			<td<?php echo $producto_sucursal->existencia->CellAttributes() ?>>
<span id="el_producto_sucursal_existencia" class="form-group">
<span<?php echo $producto_sucursal->existencia->ViewAttributes() ?>>
<?php echo $producto_sucursal->existencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
