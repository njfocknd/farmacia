<?php

// nombre
?>
<?php if ($tipo_pago->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tipo_pago->TableCaption() ?></h4> -->
<table id="tbl_tipo_pagomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($tipo_pago->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $tipo_pago->nombre->FldCaption() ?></td>
			<td<?php echo $tipo_pago->nombre->CellAttributes() ?>>
<span id="el_tipo_pago_nombre" class="form-group">
<span<?php echo $tipo_pago->nombre->ViewAttributes() ?>>
<?php echo $tipo_pago->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
