<?php

// nombre
// idpais
// idmarca
// estado

?>
<?php if ($medicamento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $medicamento->TableCaption() ?></h4> -->
<table id="tbl_medicamentomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($medicamento->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $medicamento->nombre->FldCaption() ?></td>
			<td<?php echo $medicamento->nombre->CellAttributes() ?>>
<span id="el_medicamento_nombre" class="form-group">
<span<?php echo $medicamento->nombre->ViewAttributes() ?>>
<?php echo $medicamento->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($medicamento->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $medicamento->idpais->FldCaption() ?></td>
			<td<?php echo $medicamento->idpais->CellAttributes() ?>>
<span id="el_medicamento_idpais" class="form-group">
<span<?php echo $medicamento->idpais->ViewAttributes() ?>>
<?php echo $medicamento->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($medicamento->idmarca->Visible) { // idmarca ?>
		<tr id="r_idmarca">
			<td><?php echo $medicamento->idmarca->FldCaption() ?></td>
			<td<?php echo $medicamento->idmarca->CellAttributes() ?>>
<span id="el_medicamento_idmarca" class="form-group">
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<?php echo $medicamento->idmarca->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($medicamento->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $medicamento->estado->FldCaption() ?></td>
			<td<?php echo $medicamento->estado->CellAttributes() ?>>
<span id="el_medicamento_estado" class="form-group">
<span<?php echo $medicamento->estado->ViewAttributes() ?>>
<?php echo $medicamento->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
