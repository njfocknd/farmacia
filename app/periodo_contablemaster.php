<?php

// idempresa
// mes
// anio

?>
<?php if ($periodo_contable->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $periodo_contable->TableCaption() ?></h4> -->
<table id="tbl_periodo_contablemaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($periodo_contable->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $periodo_contable->idempresa->FldCaption() ?></td>
			<td<?php echo $periodo_contable->idempresa->CellAttributes() ?>>
<span id="el_periodo_contable_idempresa" class="form-group">
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<?php echo $periodo_contable->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($periodo_contable->mes->Visible) { // mes ?>
		<tr id="r_mes">
			<td><?php echo $periodo_contable->mes->FldCaption() ?></td>
			<td<?php echo $periodo_contable->mes->CellAttributes() ?>>
<span id="el_periodo_contable_mes" class="form-group">
<span<?php echo $periodo_contable->mes->ViewAttributes() ?>>
<?php echo $periodo_contable->mes->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($periodo_contable->anio->Visible) { // anio ?>
		<tr id="r_anio">
			<td><?php echo $periodo_contable->anio->FldCaption() ?></td>
			<td<?php echo $periodo_contable->anio->CellAttributes() ?>>
<span id="el_periodo_contable_anio" class="form-group">
<span<?php echo $periodo_contable->anio->ViewAttributes() ?>>
<?php echo $periodo_contable->anio->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
