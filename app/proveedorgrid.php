<?php

// Create page object
if (!isset($proveedor_grid)) $proveedor_grid = new cproveedor_grid();

// Page init
$proveedor_grid->Page_Init();

// Page main
$proveedor_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$proveedor_grid->Page_Render();
?>
<?php if ($proveedor->Export == "") { ?>
<script type="text/javascript">

// Page object
var proveedor_grid = new ew_Page("proveedor_grid");
proveedor_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = proveedor_grid.PageID; // For backward compatibility

// Form object
var fproveedorgrid = new ew_Form("fproveedorgrid");
fproveedorgrid.FormKeyCountName = '<?php echo $proveedor_grid->FormKeyCountName ?>';

// Validate form
fproveedorgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($proveedor->_email->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fproveedorgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre_factura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "direccion_factura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	return true;
}

// Form_CustomValidate event
fproveedorgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproveedorgrid.ValidateRequired = true;
<?php } else { ?>
fproveedorgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($proveedor->CurrentAction == "gridadd") {
	if ($proveedor->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$proveedor_grid->TotalRecs = $proveedor->SelectRecordCount();
			$proveedor_grid->Recordset = $proveedor_grid->LoadRecordset($proveedor_grid->StartRec-1, $proveedor_grid->DisplayRecs);
		} else {
			if ($proveedor_grid->Recordset = $proveedor_grid->LoadRecordset())
				$proveedor_grid->TotalRecs = $proveedor_grid->Recordset->RecordCount();
		}
		$proveedor_grid->StartRec = 1;
		$proveedor_grid->DisplayRecs = $proveedor_grid->TotalRecs;
	} else {
		$proveedor->CurrentFilter = "0=1";
		$proveedor_grid->StartRec = 1;
		$proveedor_grid->DisplayRecs = $proveedor->GridAddRowCount;
	}
	$proveedor_grid->TotalRecs = $proveedor_grid->DisplayRecs;
	$proveedor_grid->StopRec = $proveedor_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$proveedor_grid->TotalRecs = $proveedor->SelectRecordCount();
	} else {
		if ($proveedor_grid->Recordset = $proveedor_grid->LoadRecordset())
			$proveedor_grid->TotalRecs = $proveedor_grid->Recordset->RecordCount();
	}
	$proveedor_grid->StartRec = 1;
	$proveedor_grid->DisplayRecs = $proveedor_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$proveedor_grid->Recordset = $proveedor_grid->LoadRecordset($proveedor_grid->StartRec-1, $proveedor_grid->DisplayRecs);

	// Set no record found message
	if ($proveedor->CurrentAction == "" && $proveedor_grid->TotalRecs == 0) {
		if ($proveedor_grid->SearchWhere == "0=101")
			$proveedor_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$proveedor_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$proveedor_grid->RenderOtherOptions();
?>
<?php $proveedor_grid->ShowPageHeader(); ?>
<?php
$proveedor_grid->ShowMessage();
?>
<?php if ($proveedor_grid->TotalRecs > 0 || $proveedor->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproveedorgrid" class="ewForm form-inline">
<div id="gmp_proveedor" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_proveedorgrid" class="table ewTable">
<?php echo $proveedor->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$proveedor_grid->RenderListOptions();

// Render list options (header, left)
$proveedor_grid->ListOptions->Render("header", "left");
?>
<?php if ($proveedor->nit->Visible) { // nit ?>
	<?php if ($proveedor->SortUrl($proveedor->nit) == "") { ?>
		<th data-name="nit"><div id="elh_proveedor_nit" class="proveedor_nit"><div class="ewTableHeaderCaption"><?php echo $proveedor->nit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nit"><div><div id="elh_proveedor_nit" class="proveedor_nit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->nit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->nit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->nit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
	<?php if ($proveedor->SortUrl($proveedor->nombre_factura) == "") { ?>
		<th data-name="nombre_factura"><div id="elh_proveedor_nombre_factura" class="proveedor_nombre_factura"><div class="ewTableHeaderCaption"><?php echo $proveedor->nombre_factura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre_factura"><div><div id="elh_proveedor_nombre_factura" class="proveedor_nombre_factura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->nombre_factura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->nombre_factura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->nombre_factura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
	<?php if ($proveedor->SortUrl($proveedor->direccion_factura) == "") { ?>
		<th data-name="direccion_factura"><div id="elh_proveedor_direccion_factura" class="proveedor_direccion_factura"><div class="ewTableHeaderCaption"><?php echo $proveedor->direccion_factura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion_factura"><div><div id="elh_proveedor_direccion_factura" class="proveedor_direccion_factura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->direccion_factura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->direccion_factura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->direccion_factura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->_email->Visible) { // email ?>
	<?php if ($proveedor->SortUrl($proveedor->_email) == "") { ?>
		<th data-name="_email"><div id="elh_proveedor__email" class="proveedor__email"><div class="ewTableHeaderCaption"><?php echo $proveedor->_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_email"><div><div id="elh_proveedor__email" class="proveedor__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$proveedor_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$proveedor_grid->StartRec = 1;
$proveedor_grid->StopRec = $proveedor_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($proveedor_grid->FormKeyCountName) && ($proveedor->CurrentAction == "gridadd" || $proveedor->CurrentAction == "gridedit" || $proveedor->CurrentAction == "F")) {
		$proveedor_grid->KeyCount = $objForm->GetValue($proveedor_grid->FormKeyCountName);
		$proveedor_grid->StopRec = $proveedor_grid->StartRec + $proveedor_grid->KeyCount - 1;
	}
}
$proveedor_grid->RecCnt = $proveedor_grid->StartRec - 1;
if ($proveedor_grid->Recordset && !$proveedor_grid->Recordset->EOF) {
	$proveedor_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $proveedor_grid->StartRec > 1)
		$proveedor_grid->Recordset->Move($proveedor_grid->StartRec - 1);
} elseif (!$proveedor->AllowAddDeleteRow && $proveedor_grid->StopRec == 0) {
	$proveedor_grid->StopRec = $proveedor->GridAddRowCount;
}

// Initialize aggregate
$proveedor->RowType = EW_ROWTYPE_AGGREGATEINIT;
$proveedor->ResetAttrs();
$proveedor_grid->RenderRow();
if ($proveedor->CurrentAction == "gridadd")
	$proveedor_grid->RowIndex = 0;
if ($proveedor->CurrentAction == "gridedit")
	$proveedor_grid->RowIndex = 0;
while ($proveedor_grid->RecCnt < $proveedor_grid->StopRec) {
	$proveedor_grid->RecCnt++;
	if (intval($proveedor_grid->RecCnt) >= intval($proveedor_grid->StartRec)) {
		$proveedor_grid->RowCnt++;
		if ($proveedor->CurrentAction == "gridadd" || $proveedor->CurrentAction == "gridedit" || $proveedor->CurrentAction == "F") {
			$proveedor_grid->RowIndex++;
			$objForm->Index = $proveedor_grid->RowIndex;
			if ($objForm->HasValue($proveedor_grid->FormActionName))
				$proveedor_grid->RowAction = strval($objForm->GetValue($proveedor_grid->FormActionName));
			elseif ($proveedor->CurrentAction == "gridadd")
				$proveedor_grid->RowAction = "insert";
			else
				$proveedor_grid->RowAction = "";
		}

		// Set up key count
		$proveedor_grid->KeyCount = $proveedor_grid->RowIndex;

		// Init row class and style
		$proveedor->ResetAttrs();
		$proveedor->CssClass = "";
		if ($proveedor->CurrentAction == "gridadd") {
			if ($proveedor->CurrentMode == "copy") {
				$proveedor_grid->LoadRowValues($proveedor_grid->Recordset); // Load row values
				$proveedor_grid->SetRecordKey($proveedor_grid->RowOldKey, $proveedor_grid->Recordset); // Set old record key
			} else {
				$proveedor_grid->LoadDefaultValues(); // Load default values
				$proveedor_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$proveedor_grid->LoadRowValues($proveedor_grid->Recordset); // Load row values
		}
		$proveedor->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($proveedor->CurrentAction == "gridadd") // Grid add
			$proveedor->RowType = EW_ROWTYPE_ADD; // Render add
		if ($proveedor->CurrentAction == "gridadd" && $proveedor->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
		if ($proveedor->CurrentAction == "gridedit") { // Grid edit
			if ($proveedor->EventCancelled) {
				$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
			}
			if ($proveedor_grid->RowAction == "insert")
				$proveedor->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$proveedor->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($proveedor->CurrentAction == "gridedit" && ($proveedor->RowType == EW_ROWTYPE_EDIT || $proveedor->RowType == EW_ROWTYPE_ADD) && $proveedor->EventCancelled) // Update failed
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
		if ($proveedor->RowType == EW_ROWTYPE_EDIT) // Edit row
			$proveedor_grid->EditRowCnt++;
		if ($proveedor->CurrentAction == "F") // Confirm row
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$proveedor->RowAttrs = array_merge($proveedor->RowAttrs, array('data-rowindex'=>$proveedor_grid->RowCnt, 'id'=>'r' . $proveedor_grid->RowCnt . '_proveedor', 'data-rowtype'=>$proveedor->RowType));

		// Render row
		$proveedor_grid->RenderRow();

		// Render list options
		$proveedor_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($proveedor_grid->RowAction <> "delete" && $proveedor_grid->RowAction <> "insertdelete" && !($proveedor_grid->RowAction == "insert" && $proveedor->CurrentAction == "F" && $proveedor_grid->EmptyRow())) {
?>
	<tr<?php echo $proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$proveedor_grid->ListOptions->Render("body", "left", $proveedor_grid->RowCnt);
?>
	<?php if ($proveedor->nit->Visible) { // nit ?>
		<td data-name="nit"<?php echo $proveedor->nit->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->PlaceHolder) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->PlaceHolder) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<?php echo $proveedor->nit->ListViewValue() ?></span>
<input type="hidden" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->FormValue) ?>">
<input type="hidden" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
<?php } ?>
<a id="<?php echo $proveedor_grid->PageObjName . "_row_" . $proveedor_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproveedor" name="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->CurrentValue) ?>">
<input type="hidden" data-field="x_idproveedor" name="o<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="o<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT || $proveedor->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproveedor" name="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->CurrentValue) ?>">
<?php } ?>
	<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
		<td data-name="nombre_factura"<?php echo $proveedor->nombre_factura->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nombre_factura" class="form-group proveedor_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre_factura->PlaceHolder) ?>" value="<?php echo $proveedor->nombre_factura->EditValue ?>"<?php echo $proveedor->nombre_factura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($proveedor->nombre_factura->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nombre_factura" class="form-group proveedor_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre_factura->PlaceHolder) ?>" value="<?php echo $proveedor->nombre_factura->EditValue ?>"<?php echo $proveedor->nombre_factura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $proveedor->nombre_factura->ViewAttributes() ?>>
<?php echo $proveedor->nombre_factura->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($proveedor->nombre_factura->FormValue) ?>">
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($proveedor->nombre_factura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
		<td data-name="direccion_factura"<?php echo $proveedor->direccion_factura->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_direccion_factura" class="form-group proveedor_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion_factura->PlaceHolder) ?>" value="<?php echo $proveedor->direccion_factura->EditValue ?>"<?php echo $proveedor->direccion_factura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($proveedor->direccion_factura->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_direccion_factura" class="form-group proveedor_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion_factura->PlaceHolder) ?>" value="<?php echo $proveedor->direccion_factura->EditValue ?>"<?php echo $proveedor->direccion_factura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $proveedor->direccion_factura->ViewAttributes() ?>>
<?php echo $proveedor->direccion_factura->ListViewValue() ?></span>
<input type="hidden" data-field="x_direccion_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($proveedor->direccion_factura->FormValue) ?>">
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($proveedor->direccion_factura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->_email->Visible) { // email ?>
		<td data-name="_email"<?php echo $proveedor->_email->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor__email" class="form-group proveedor__email">
<input type="text" data-field="x__email" name="x<?php echo $proveedor_grid->RowIndex ?>__email" id="x<?php echo $proveedor_grid->RowIndex ?>__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->_email->PlaceHolder) ?>" value="<?php echo $proveedor->_email->EditValue ?>"<?php echo $proveedor->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $proveedor_grid->RowIndex ?>__email" id="o<?php echo $proveedor_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($proveedor->_email->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor__email" class="form-group proveedor__email">
<input type="text" data-field="x__email" name="x<?php echo $proveedor_grid->RowIndex ?>__email" id="x<?php echo $proveedor_grid->RowIndex ?>__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->_email->PlaceHolder) ?>" value="<?php echo $proveedor->_email->EditValue ?>"<?php echo $proveedor->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $proveedor->_email->ViewAttributes() ?>>
<?php echo $proveedor->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $proveedor_grid->RowIndex ?>__email" id="x<?php echo $proveedor_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($proveedor->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $proveedor_grid->RowIndex ?>__email" id="o<?php echo $proveedor_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($proveedor->_email->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$proveedor_grid->ListOptions->Render("body", "right", $proveedor_grid->RowCnt);
?>
	</tr>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD || $proveedor->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproveedorgrid.UpdateOpts(<?php echo $proveedor_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($proveedor->CurrentAction <> "gridadd" || $proveedor->CurrentMode == "copy")
		if (!$proveedor_grid->Recordset->EOF) $proveedor_grid->Recordset->MoveNext();
}
?>
<?php
	if ($proveedor->CurrentMode == "add" || $proveedor->CurrentMode == "copy" || $proveedor->CurrentMode == "edit") {
		$proveedor_grid->RowIndex = '$rowindex$';
		$proveedor_grid->LoadDefaultValues();

		// Set row properties
		$proveedor->ResetAttrs();
		$proveedor->RowAttrs = array_merge($proveedor->RowAttrs, array('data-rowindex'=>$proveedor_grid->RowIndex, 'id'=>'r0_proveedor', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($proveedor->RowAttrs["class"], "ewTemplate");
		$proveedor->RowType = EW_ROWTYPE_ADD;

		// Render row
		$proveedor_grid->RenderRow();

		// Render list options
		$proveedor_grid->RenderListOptions();
		$proveedor_grid->StartRowCnt = 0;
?>
	<tr<?php echo $proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$proveedor_grid->ListOptions->Render("body", "left", $proveedor_grid->RowIndex);
?>
	<?php if ($proveedor->nit->Visible) { // nit ?>
		<td>
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->PlaceHolder) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_nit" class="form-group proveedor_nit">
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->nit->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
		<td>
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_nombre_factura" class="form-group proveedor_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre_factura->PlaceHolder) ?>" value="<?php echo $proveedor->nombre_factura->EditValue ?>"<?php echo $proveedor->nombre_factura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_nombre_factura" class="form-group proveedor_nombre_factura">
<span<?php echo $proveedor->nombre_factura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->nombre_factura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($proveedor->nombre_factura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($proveedor->nombre_factura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
		<td>
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_direccion_factura" class="form-group proveedor_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion_factura->PlaceHolder) ?>" value="<?php echo $proveedor->direccion_factura->EditValue ?>"<?php echo $proveedor->direccion_factura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_direccion_factura" class="form-group proveedor_direccion_factura">
<span<?php echo $proveedor->direccion_factura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->direccion_factura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_direccion_factura" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($proveedor->direccion_factura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($proveedor->direccion_factura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->_email->Visible) { // email ?>
		<td>
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor__email" class="form-group proveedor__email">
<input type="text" data-field="x__email" name="x<?php echo $proveedor_grid->RowIndex ?>__email" id="x<?php echo $proveedor_grid->RowIndex ?>__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->_email->PlaceHolder) ?>" value="<?php echo $proveedor->_email->EditValue ?>"<?php echo $proveedor->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor__email" class="form-group proveedor__email">
<span<?php echo $proveedor->_email->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->_email->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $proveedor_grid->RowIndex ?>__email" id="x<?php echo $proveedor_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($proveedor->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $proveedor_grid->RowIndex ?>__email" id="o<?php echo $proveedor_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($proveedor->_email->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$proveedor_grid->ListOptions->Render("body", "right", $proveedor_grid->RowCnt);
?>
<script type="text/javascript">
fproveedorgrid.UpdateOpts(<?php echo $proveedor_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($proveedor->CurrentMode == "add" || $proveedor->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $proveedor_grid->FormKeyCountName ?>" id="<?php echo $proveedor_grid->FormKeyCountName ?>" value="<?php echo $proveedor_grid->KeyCount ?>">
<?php echo $proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($proveedor->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $proveedor_grid->FormKeyCountName ?>" id="<?php echo $proveedor_grid->FormKeyCountName ?>" value="<?php echo $proveedor_grid->KeyCount ?>">
<?php echo $proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($proveedor->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproveedorgrid">
</div>
<?php

// Close recordset
if ($proveedor_grid->Recordset)
	$proveedor_grid->Recordset->Close();
?>
<?php if ($proveedor_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($proveedor_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($proveedor_grid->TotalRecs == 0 && $proveedor->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($proveedor_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($proveedor->Export == "") { ?>
<script type="text/javascript">
fproveedorgrid.Init();
</script>
<?php } ?>
<?php
$proveedor_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$proveedor_grid->Page_Terminate();
?>
