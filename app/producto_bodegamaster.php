<?php

// idproducto
// idbodega
// existencia

?>
<?php if ($producto_bodega->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $producto_bodega->TableCaption() ?></h4> -->
<table id="tbl_producto_bodegamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($producto_bodega->idproducto->Visible) { // idproducto ?>
		<tr id="r_idproducto">
			<td><?php echo $producto_bodega->idproducto->FldCaption() ?></td>
			<td<?php echo $producto_bodega->idproducto->CellAttributes() ?>>
<span id="el_producto_bodega_idproducto" class="form-group">
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<?php echo $producto_bodega->idproducto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto_bodega->idbodega->Visible) { // idbodega ?>
		<tr id="r_idbodega">
			<td><?php echo $producto_bodega->idbodega->FldCaption() ?></td>
			<td<?php echo $producto_bodega->idbodega->CellAttributes() ?>>
<span id="el_producto_bodega_idbodega" class="form-group">
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<?php echo $producto_bodega->idbodega->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto_bodega->existencia->Visible) { // existencia ?>
		<tr id="r_existencia">
			<td><?php echo $producto_bodega->existencia->FldCaption() ?></td>
			<td<?php echo $producto_bodega->existencia->CellAttributes() ?>>
<span id="el_producto_bodega_existencia" class="form-group">
<span<?php echo $producto_bodega->existencia->ViewAttributes() ?>>
<?php echo $producto_bodega->existencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
