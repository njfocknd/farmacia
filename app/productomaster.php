<?php

// codigo_barra
// idcategoria
// idmarca
// nombre
// idpais
// existencia
// estado
// precio_venta
// fecha_insercion
// foto

?>
<?php if ($producto->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $producto->TableCaption() ?></h4> -->
<table id="tbl_productomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($producto->codigo_barra->Visible) { // codigo_barra ?>
		<tr id="r_codigo_barra">
			<td><?php echo $producto->codigo_barra->FldCaption() ?></td>
			<td<?php echo $producto->codigo_barra->CellAttributes() ?>>
<span id="el_producto_codigo_barra" class="form-group">
<span<?php echo $producto->codigo_barra->ViewAttributes() ?>>
<?php echo $producto->codigo_barra->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->idcategoria->Visible) { // idcategoria ?>
		<tr id="r_idcategoria">
			<td><?php echo $producto->idcategoria->FldCaption() ?></td>
			<td<?php echo $producto->idcategoria->CellAttributes() ?>>
<span id="el_producto_idcategoria" class="form-group">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<?php echo $producto->idcategoria->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
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
<?php if ($producto->precio_venta->Visible) { // precio_venta ?>
		<tr id="r_precio_venta">
			<td><?php echo $producto->precio_venta->FldCaption() ?></td>
			<td<?php echo $producto->precio_venta->CellAttributes() ?>>
<span id="el_producto_precio_venta" class="form-group">
<span<?php echo $producto->precio_venta->ViewAttributes() ?>>
<?php echo $producto->precio_venta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $producto->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $producto->fecha_insercion->CellAttributes() ?>>
<span id="el_producto_fecha_insercion" class="form-group">
<span<?php echo $producto->fecha_insercion->ViewAttributes() ?>>
<?php echo $producto->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($producto->foto->Visible) { // foto ?>
		<tr id="r_foto">
			<td><?php echo $producto->foto->FldCaption() ?></td>
			<td<?php echo $producto->foto->CellAttributes() ?>>
<span id="el_producto_foto" class="form-group">
<span>
<?php echo ew_GetFileViewTag($producto->foto, $producto->foto->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
