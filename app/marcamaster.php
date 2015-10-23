<?php

// nombre
// idlaboratorio
// estado

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
<?php if ($marca->idlaboratorio->Visible) { // idlaboratorio ?>
		<tr id="r_idlaboratorio">
			<td><?php echo $marca->idlaboratorio->FldCaption() ?></td>
			<td<?php echo $marca->idlaboratorio->CellAttributes() ?>>
<span id="el_marca_idlaboratorio" class="form-group">
<span<?php echo $marca->idlaboratorio->ViewAttributes() ?>>
<?php echo $marca->idlaboratorio->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($marca->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $marca->estado->FldCaption() ?></td>
			<td<?php echo $marca->estado->CellAttributes() ?>>
<span id="el_marca_estado" class="form-group">
<span<?php echo $marca->estado->ViewAttributes() ?>>
<?php echo $marca->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
