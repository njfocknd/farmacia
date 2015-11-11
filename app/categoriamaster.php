<?php

// nombre
?>
<?php if ($categoria->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $categoria->TableCaption() ?></h4> -->
<table id="tbl_categoriamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($categoria->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $categoria->nombre->FldCaption() ?></td>
			<td<?php echo $categoria->nombre->CellAttributes() ?>>
<span id="el_categoria_nombre" class="form-group">
<span<?php echo $categoria->nombre->ViewAttributes() ?>>
<?php echo $categoria->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
