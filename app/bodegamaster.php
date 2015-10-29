<?php

// descripcion
// idsucursal
// idtipo_bodega

?>
<?php if ($bodega->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $bodega->TableCaption() ?></h4> -->
<table id="tbl_bodegamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($bodega->descripcion->Visible) { // descripcion ?>
		<tr id="r_descripcion">
			<td><?php echo $bodega->descripcion->FldCaption() ?></td>
			<td<?php echo $bodega->descripcion->CellAttributes() ?>>
<span id="el_bodega_descripcion" class="form-group">
<span<?php echo $bodega->descripcion->ViewAttributes() ?>>
<?php echo $bodega->descripcion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($bodega->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $bodega->idsucursal->FldCaption() ?></td>
			<td<?php echo $bodega->idsucursal->CellAttributes() ?>>
<span id="el_bodega_idsucursal" class="form-group">
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<?php echo $bodega->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($bodega->idtipo_bodega->Visible) { // idtipo_bodega ?>
		<tr id="r_idtipo_bodega">
			<td><?php echo $bodega->idtipo_bodega->FldCaption() ?></td>
			<td<?php echo $bodega->idtipo_bodega->CellAttributes() ?>>
<span id="el_bodega_idtipo_bodega" class="form-group">
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<?php echo $bodega->idtipo_bodega->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
