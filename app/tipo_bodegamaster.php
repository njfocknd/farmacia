<?php

// nombre
?>
<?php if ($tipo_bodega->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tipo_bodega->TableCaption() ?></h4> -->
<table id="tbl_tipo_bodegamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($tipo_bodega->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $tipo_bodega->nombre->FldCaption() ?></td>
			<td<?php echo $tipo_bodega->nombre->CellAttributes() ?>>
<span id="el_tipo_bodega_nombre" class="form-group">
<span<?php echo $tipo_bodega->nombre->ViewAttributes() ?>>
<?php echo $tipo_bodega->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
