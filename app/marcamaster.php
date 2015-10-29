<?php

// nombre
// idfabricante

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
	</tbody>
</table>
<?php } ?>
