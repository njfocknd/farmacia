<?php

// nombre
// idfabricante
// fecha_insercion

?>
<?php if ($marca->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $marca->TableCaption() ?></h4> -->
<table id="tbl_marcamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($marca->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $marca->nombre->FldCaption() ?></td>
			<td<?php echo $marca->nombre->CellAttributes() ?>>
<span id="el_marca_nombre" class="form-group">
<span<?php echo $marca->nombre->ViewAttributes() ?>>
<?php echo $marca->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($marca->idfabricante->Visible) { // idfabricante ?>
		<tr id="r_idfabricante">
			<td><?php echo $marca->idfabricante->FldCaption() ?></td>
			<td<?php echo $marca->idfabricante->CellAttributes() ?>>
<span id="el_marca_idfabricante" class="form-group">
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<?php echo $marca->idfabricante->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($marca->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $marca->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $marca->fecha_insercion->CellAttributes() ?>>
<span id="el_marca_fecha_insercion" class="form-group">
<span<?php echo $marca->fecha_insercion->ViewAttributes() ?>>
<?php echo $marca->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
