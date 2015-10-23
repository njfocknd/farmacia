<?php

// nombre
// idpais
// estado

?>
<?php if ($laboratorio->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $laboratorio->TableCaption() ?></h4> -->
<table id="tbl_laboratoriomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($laboratorio->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $laboratorio->nombre->FldCaption() ?></td>
			<td<?php echo $laboratorio->nombre->CellAttributes() ?>>
<span id="el_laboratorio_nombre" class="form-group">
<span<?php echo $laboratorio->nombre->ViewAttributes() ?>>
<?php echo $laboratorio->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($laboratorio->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $laboratorio->idpais->FldCaption() ?></td>
			<td<?php echo $laboratorio->idpais->CellAttributes() ?>>
<span id="el_laboratorio_idpais" class="form-group">
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<?php echo $laboratorio->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($laboratorio->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $laboratorio->estado->FldCaption() ?></td>
			<td<?php echo $laboratorio->estado->CellAttributes() ?>>
<span id="el_laboratorio_estado" class="form-group">
<span<?php echo $laboratorio->estado->ViewAttributes() ?>>
<?php echo $laboratorio->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
