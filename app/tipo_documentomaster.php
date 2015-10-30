<?php

// nombre
?>
<?php if ($tipo_documento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tipo_documento->TableCaption() ?></h4> -->
<table id="tbl_tipo_documentomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($tipo_documento->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $tipo_documento->nombre->FldCaption() ?></td>
			<td<?php echo $tipo_documento->nombre->CellAttributes() ?>>
<span id="el_tipo_documento_nombre" class="form-group">
<span<?php echo $tipo_documento->nombre->ViewAttributes() ?>>
<?php echo $tipo_documento->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
