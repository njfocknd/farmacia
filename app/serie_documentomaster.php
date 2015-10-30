<?php

// idtipo_documento
// idsucursal
// serie

?>
<?php if ($serie_documento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $serie_documento->TableCaption() ?></h4> -->
<table id="tbl_serie_documentomaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($serie_documento->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $serie_documento->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $serie_documento->idtipo_documento->CellAttributes() ?>>
<span id="el_serie_documento_idtipo_documento" class="form-group">
<span<?php echo $serie_documento->idtipo_documento->ViewAttributes() ?>>
<?php echo $serie_documento->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($serie_documento->idsucursal->Visible) { // idsucursal ?>
		<tr id="r_idsucursal">
			<td><?php echo $serie_documento->idsucursal->FldCaption() ?></td>
			<td<?php echo $serie_documento->idsucursal->CellAttributes() ?>>
<span id="el_serie_documento_idsucursal" class="form-group">
<span<?php echo $serie_documento->idsucursal->ViewAttributes() ?>>
<?php echo $serie_documento->idsucursal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($serie_documento->serie->Visible) { // serie ?>
		<tr id="r_serie">
			<td><?php echo $serie_documento->serie->FldCaption() ?></td>
			<td<?php echo $serie_documento->serie->CellAttributes() ?>>
<span id="el_serie_documento_serie" class="form-group">
<span<?php echo $serie_documento->serie->ViewAttributes() ?>>
<?php echo $serie_documento->serie->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
