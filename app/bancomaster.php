<?php

// nombre
// acronimo
// telefono
// idpais

?>
<?php if ($banco->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $banco->TableCaption() ?></h4> -->
<table id="tbl_bancomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($banco->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $banco->nombre->FldCaption() ?></td>
			<td<?php echo $banco->nombre->CellAttributes() ?>>
<span id="el_banco_nombre" class="form-group">
<span<?php echo $banco->nombre->ViewAttributes() ?>>
<?php echo $banco->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco->acronimo->Visible) { // acronimo ?>
		<tr id="r_acronimo">
			<td><?php echo $banco->acronimo->FldCaption() ?></td>
			<td<?php echo $banco->acronimo->CellAttributes() ?>>
<span id="el_banco_acronimo" class="form-group">
<span<?php echo $banco->acronimo->ViewAttributes() ?>>
<?php echo $banco->acronimo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco->telefono->Visible) { // telefono ?>
		<tr id="r_telefono">
			<td><?php echo $banco->telefono->FldCaption() ?></td>
			<td<?php echo $banco->telefono->CellAttributes() ?>>
<span id="el_banco_telefono" class="form-group">
<span<?php echo $banco->telefono->ViewAttributes() ?>>
<?php echo $banco->telefono->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco->idpais->Visible) { // idpais ?>
		<tr id="r_idpais">
			<td><?php echo $banco->idpais->FldCaption() ?></td>
			<td<?php echo $banco->idpais->CellAttributes() ?>>
<span id="el_banco_idpais" class="form-group">
<span<?php echo $banco->idpais->ViewAttributes() ?>>
<?php echo $banco->idpais->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
