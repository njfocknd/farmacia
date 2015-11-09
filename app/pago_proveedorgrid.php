<?php

// Create page object
if (!isset($pago_proveedor_grid)) $pago_proveedor_grid = new cpago_proveedor_grid();

// Page init
$pago_proveedor_grid->Page_Init();

// Page main
$pago_proveedor_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pago_proveedor_grid->Page_Render();
?>
<?php if ($pago_proveedor->Export == "") { ?>
<script type="text/javascript">

// Page object
var pago_proveedor_grid = new ew_Page("pago_proveedor_grid");
pago_proveedor_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = pago_proveedor_grid.PageID; // For backward compatibility

// Form object
var fpago_proveedorgrid = new ew_Form("fpago_proveedorgrid");
fpago_proveedorgrid.FormKeyCountName = '<?php echo $pago_proveedor_grid->FormKeyCountName ?>';

// Validate form
fpago_proveedorgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_proveedor->idsucursal->FldCaption(), $pago_proveedor->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproveedor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_proveedor->idproveedor->FldCaption(), $pago_proveedor->idproveedor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_proveedor->monto->FldCaption(), $pago_proveedor->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_proveedor->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_proveedor->fecha->FldErrMsg()) ?>");

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
fpago_proveedorgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproveedor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	return true;
}

// Form_CustomValidate event
fpago_proveedorgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpago_proveedorgrid.ValidateRequired = true;
<?php } else { ?>
fpago_proveedorgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpago_proveedorgrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_proveedorgrid.Lists["x_idproveedor"] = {"LinkField":"x_idproveedor","Ajax":true,"AutoFill":false,"DisplayFields":["x_codigo","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($pago_proveedor->CurrentAction == "gridadd") {
	if ($pago_proveedor->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$pago_proveedor_grid->TotalRecs = $pago_proveedor->SelectRecordCount();
			$pago_proveedor_grid->Recordset = $pago_proveedor_grid->LoadRecordset($pago_proveedor_grid->StartRec-1, $pago_proveedor_grid->DisplayRecs);
		} else {
			if ($pago_proveedor_grid->Recordset = $pago_proveedor_grid->LoadRecordset())
				$pago_proveedor_grid->TotalRecs = $pago_proveedor_grid->Recordset->RecordCount();
		}
		$pago_proveedor_grid->StartRec = 1;
		$pago_proveedor_grid->DisplayRecs = $pago_proveedor_grid->TotalRecs;
	} else {
		$pago_proveedor->CurrentFilter = "0=1";
		$pago_proveedor_grid->StartRec = 1;
		$pago_proveedor_grid->DisplayRecs = $pago_proveedor->GridAddRowCount;
	}
	$pago_proveedor_grid->TotalRecs = $pago_proveedor_grid->DisplayRecs;
	$pago_proveedor_grid->StopRec = $pago_proveedor_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$pago_proveedor_grid->TotalRecs = $pago_proveedor->SelectRecordCount();
	} else {
		if ($pago_proveedor_grid->Recordset = $pago_proveedor_grid->LoadRecordset())
			$pago_proveedor_grid->TotalRecs = $pago_proveedor_grid->Recordset->RecordCount();
	}
	$pago_proveedor_grid->StartRec = 1;
	$pago_proveedor_grid->DisplayRecs = $pago_proveedor_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$pago_proveedor_grid->Recordset = $pago_proveedor_grid->LoadRecordset($pago_proveedor_grid->StartRec-1, $pago_proveedor_grid->DisplayRecs);

	// Set no record found message
	if ($pago_proveedor->CurrentAction == "" && $pago_proveedor_grid->TotalRecs == 0) {
		if ($pago_proveedor_grid->SearchWhere == "0=101")
			$pago_proveedor_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pago_proveedor_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$pago_proveedor_grid->RenderOtherOptions();
?>
<?php $pago_proveedor_grid->ShowPageHeader(); ?>
<?php
$pago_proveedor_grid->ShowMessage();
?>
<?php if ($pago_proveedor_grid->TotalRecs > 0 || $pago_proveedor->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fpago_proveedorgrid" class="ewForm form-inline">
<div id="gmp_pago_proveedor" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_pago_proveedorgrid" class="table ewTable">
<?php echo $pago_proveedor->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$pago_proveedor_grid->RenderListOptions();

// Render list options (header, left)
$pago_proveedor_grid->ListOptions->Render("header", "left");
?>
<?php if ($pago_proveedor->idsucursal->Visible) { // idsucursal ?>
	<?php if ($pago_proveedor->SortUrl($pago_proveedor->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_pago_proveedor_idsucursal" class="pago_proveedor_idsucursal"><div class="ewTableHeaderCaption"><?php echo $pago_proveedor->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_pago_proveedor_idsucursal" class="pago_proveedor_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_proveedor->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_proveedor->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_proveedor->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_proveedor->idproveedor->Visible) { // idproveedor ?>
	<?php if ($pago_proveedor->SortUrl($pago_proveedor->idproveedor) == "") { ?>
		<th data-name="idproveedor"><div id="elh_pago_proveedor_idproveedor" class="pago_proveedor_idproveedor"><div class="ewTableHeaderCaption"><?php echo $pago_proveedor->idproveedor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproveedor"><div><div id="elh_pago_proveedor_idproveedor" class="pago_proveedor_idproveedor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_proveedor->idproveedor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_proveedor->idproveedor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_proveedor->idproveedor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_proveedor->monto->Visible) { // monto ?>
	<?php if ($pago_proveedor->SortUrl($pago_proveedor->monto) == "") { ?>
		<th data-name="monto"><div id="elh_pago_proveedor_monto" class="pago_proveedor_monto"><div class="ewTableHeaderCaption"><?php echo $pago_proveedor->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_pago_proveedor_monto" class="pago_proveedor_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_proveedor->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_proveedor->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_proveedor->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_proveedor->fecha->Visible) { // fecha ?>
	<?php if ($pago_proveedor->SortUrl($pago_proveedor->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_pago_proveedor_fecha" class="pago_proveedor_fecha"><div class="ewTableHeaderCaption"><?php echo $pago_proveedor->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_pago_proveedor_fecha" class="pago_proveedor_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_proveedor->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_proveedor->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_proveedor->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pago_proveedor_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$pago_proveedor_grid->StartRec = 1;
$pago_proveedor_grid->StopRec = $pago_proveedor_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($pago_proveedor_grid->FormKeyCountName) && ($pago_proveedor->CurrentAction == "gridadd" || $pago_proveedor->CurrentAction == "gridedit" || $pago_proveedor->CurrentAction == "F")) {
		$pago_proveedor_grid->KeyCount = $objForm->GetValue($pago_proveedor_grid->FormKeyCountName);
		$pago_proveedor_grid->StopRec = $pago_proveedor_grid->StartRec + $pago_proveedor_grid->KeyCount - 1;
	}
}
$pago_proveedor_grid->RecCnt = $pago_proveedor_grid->StartRec - 1;
if ($pago_proveedor_grid->Recordset && !$pago_proveedor_grid->Recordset->EOF) {
	$pago_proveedor_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $pago_proveedor_grid->StartRec > 1)
		$pago_proveedor_grid->Recordset->Move($pago_proveedor_grid->StartRec - 1);
} elseif (!$pago_proveedor->AllowAddDeleteRow && $pago_proveedor_grid->StopRec == 0) {
	$pago_proveedor_grid->StopRec = $pago_proveedor->GridAddRowCount;
}

// Initialize aggregate
$pago_proveedor->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pago_proveedor->ResetAttrs();
$pago_proveedor_grid->RenderRow();
if ($pago_proveedor->CurrentAction == "gridadd")
	$pago_proveedor_grid->RowIndex = 0;
if ($pago_proveedor->CurrentAction == "gridedit")
	$pago_proveedor_grid->RowIndex = 0;
while ($pago_proveedor_grid->RecCnt < $pago_proveedor_grid->StopRec) {
	$pago_proveedor_grid->RecCnt++;
	if (intval($pago_proveedor_grid->RecCnt) >= intval($pago_proveedor_grid->StartRec)) {
		$pago_proveedor_grid->RowCnt++;
		if ($pago_proveedor->CurrentAction == "gridadd" || $pago_proveedor->CurrentAction == "gridedit" || $pago_proveedor->CurrentAction == "F") {
			$pago_proveedor_grid->RowIndex++;
			$objForm->Index = $pago_proveedor_grid->RowIndex;
			if ($objForm->HasValue($pago_proveedor_grid->FormActionName))
				$pago_proveedor_grid->RowAction = strval($objForm->GetValue($pago_proveedor_grid->FormActionName));
			elseif ($pago_proveedor->CurrentAction == "gridadd")
				$pago_proveedor_grid->RowAction = "insert";
			else
				$pago_proveedor_grid->RowAction = "";
		}

		// Set up key count
		$pago_proveedor_grid->KeyCount = $pago_proveedor_grid->RowIndex;

		// Init row class and style
		$pago_proveedor->ResetAttrs();
		$pago_proveedor->CssClass = "";
		if ($pago_proveedor->CurrentAction == "gridadd") {
			if ($pago_proveedor->CurrentMode == "copy") {
				$pago_proveedor_grid->LoadRowValues($pago_proveedor_grid->Recordset); // Load row values
				$pago_proveedor_grid->SetRecordKey($pago_proveedor_grid->RowOldKey, $pago_proveedor_grid->Recordset); // Set old record key
			} else {
				$pago_proveedor_grid->LoadDefaultValues(); // Load default values
				$pago_proveedor_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$pago_proveedor_grid->LoadRowValues($pago_proveedor_grid->Recordset); // Load row values
		}
		$pago_proveedor->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($pago_proveedor->CurrentAction == "gridadd") // Grid add
			$pago_proveedor->RowType = EW_ROWTYPE_ADD; // Render add
		if ($pago_proveedor->CurrentAction == "gridadd" && $pago_proveedor->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$pago_proveedor_grid->RestoreCurrentRowFormValues($pago_proveedor_grid->RowIndex); // Restore form values
		if ($pago_proveedor->CurrentAction == "gridedit") { // Grid edit
			if ($pago_proveedor->EventCancelled) {
				$pago_proveedor_grid->RestoreCurrentRowFormValues($pago_proveedor_grid->RowIndex); // Restore form values
			}
			if ($pago_proveedor_grid->RowAction == "insert")
				$pago_proveedor->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$pago_proveedor->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($pago_proveedor->CurrentAction == "gridedit" && ($pago_proveedor->RowType == EW_ROWTYPE_EDIT || $pago_proveedor->RowType == EW_ROWTYPE_ADD) && $pago_proveedor->EventCancelled) // Update failed
			$pago_proveedor_grid->RestoreCurrentRowFormValues($pago_proveedor_grid->RowIndex); // Restore form values
		if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT) // Edit row
			$pago_proveedor_grid->EditRowCnt++;
		if ($pago_proveedor->CurrentAction == "F") // Confirm row
			$pago_proveedor_grid->RestoreCurrentRowFormValues($pago_proveedor_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$pago_proveedor->RowAttrs = array_merge($pago_proveedor->RowAttrs, array('data-rowindex'=>$pago_proveedor_grid->RowCnt, 'id'=>'r' . $pago_proveedor_grid->RowCnt . '_pago_proveedor', 'data-rowtype'=>$pago_proveedor->RowType));

		// Render row
		$pago_proveedor_grid->RenderRow();

		// Render list options
		$pago_proveedor_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pago_proveedor_grid->RowAction <> "delete" && $pago_proveedor_grid->RowAction <> "insertdelete" && !($pago_proveedor_grid->RowAction == "insert" && $pago_proveedor->CurrentAction == "F" && $pago_proveedor_grid->EmptyRow())) {
?>
	<tr<?php echo $pago_proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pago_proveedor_grid->ListOptions->Render("body", "left", $pago_proveedor_grid->RowCnt);
?>
	<?php if ($pago_proveedor->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $pago_proveedor->idsucursal->CellAttributes() ?>>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idsucursal" class="form-group pago_proveedor_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal"<?php echo $pago_proveedor->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idsucursal->EditValue)) {
	$arwrk = $pago_proveedor->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idsucursal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_proveedor->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idsucursal" class="form-group pago_proveedor_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal"<?php echo $pago_proveedor->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idsucursal->EditValue)) {
	$arwrk = $pago_proveedor->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idsucursal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_proveedor->idsucursal->ViewAttributes() ?>>
<?php echo $pago_proveedor->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_proveedor->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_proveedor->idsucursal->OldValue) ?>">
<?php } ?>
<a id="<?php echo $pago_proveedor_grid->PageObjName . "_row_" . $pago_proveedor_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idpago_proveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idpago_proveedor->CurrentValue) ?>">
<input type="hidden" data-field="x_idpago_proveedor" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idpago_proveedor->OldValue) ?>">
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT || $pago_proveedor->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idpago_proveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idpago_proveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idpago_proveedor->CurrentValue) ?>">
<?php } ?>
	<?php if ($pago_proveedor->idproveedor->Visible) { // idproveedor ?>
		<td data-name="idproveedor"<?php echo $pago_proveedor->idproveedor->CellAttributes() ?>>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($pago_proveedor->idproveedor->getSessionValue() <> "") { ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<span<?php echo $pago_proveedor->idproveedor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->idproveedor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<select data-field="x_idproveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor"<?php echo $pago_proveedor->idproveedor->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idproveedor->EditValue)) {
	$arwrk = $pago_proveedor->idproveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idproveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_proveedor->idproveedor) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idproveedor->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproveedor`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedor`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idproveedor, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproveedor` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idproveedor" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->OldValue) ?>">
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($pago_proveedor->idproveedor->getSessionValue() <> "") { ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<span<?php echo $pago_proveedor->idproveedor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->idproveedor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<select data-field="x_idproveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor"<?php echo $pago_proveedor->idproveedor->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idproveedor->EditValue)) {
	$arwrk = $pago_proveedor->idproveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idproveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_proveedor->idproveedor) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idproveedor->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproveedor`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedor`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idproveedor, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproveedor` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_proveedor->idproveedor->ViewAttributes() ?>>
<?php echo $pago_proveedor->idproveedor->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->FormValue) ?>">
<input type="hidden" data-field="x_idproveedor" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pago_proveedor->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $pago_proveedor->monto->CellAttributes() ?>>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_monto" class="form-group pago_proveedor_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->monto->PlaceHolder) ?>" value="<?php echo $pago_proveedor->monto->EditValue ?>"<?php echo $pago_proveedor->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_proveedor->monto->OldValue) ?>">
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_monto" class="form-group pago_proveedor_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->monto->PlaceHolder) ?>" value="<?php echo $pago_proveedor->monto->EditValue ?>"<?php echo $pago_proveedor->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_proveedor->monto->ViewAttributes() ?>>
<?php echo $pago_proveedor->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_proveedor->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_proveedor->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pago_proveedor->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $pago_proveedor->fecha->CellAttributes() ?>>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_fecha" class="form-group pago_proveedor_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->fecha->PlaceHolder) ?>" value="<?php echo $pago_proveedor->fecha->EditValue ?>"<?php echo $pago_proveedor->fecha->EditAttributes() ?>>
<?php if (!$pago_proveedor->fecha->ReadOnly && !$pago_proveedor->fecha->Disabled && @$pago_proveedor->fecha->EditAttrs["readonly"] == "" && @$pago_proveedor->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_proveedorgrid", "x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_proveedor->fecha->OldValue) ?>">
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_proveedor_grid->RowCnt ?>_pago_proveedor_fecha" class="form-group pago_proveedor_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->fecha->PlaceHolder) ?>" value="<?php echo $pago_proveedor->fecha->EditValue ?>"<?php echo $pago_proveedor->fecha->EditAttributes() ?>>
<?php if (!$pago_proveedor->fecha->ReadOnly && !$pago_proveedor->fecha->Disabled && @$pago_proveedor->fecha->EditAttrs["readonly"] == "" && @$pago_proveedor->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_proveedorgrid", "x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_proveedor->fecha->ViewAttributes() ?>>
<?php echo $pago_proveedor->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_proveedor->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_proveedor->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pago_proveedor_grid->ListOptions->Render("body", "right", $pago_proveedor_grid->RowCnt);
?>
	</tr>
<?php if ($pago_proveedor->RowType == EW_ROWTYPE_ADD || $pago_proveedor->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpago_proveedorgrid.UpdateOpts(<?php echo $pago_proveedor_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($pago_proveedor->CurrentAction <> "gridadd" || $pago_proveedor->CurrentMode == "copy")
		if (!$pago_proveedor_grid->Recordset->EOF) $pago_proveedor_grid->Recordset->MoveNext();
}
?>
<?php
	if ($pago_proveedor->CurrentMode == "add" || $pago_proveedor->CurrentMode == "copy" || $pago_proveedor->CurrentMode == "edit") {
		$pago_proveedor_grid->RowIndex = '$rowindex$';
		$pago_proveedor_grid->LoadDefaultValues();

		// Set row properties
		$pago_proveedor->ResetAttrs();
		$pago_proveedor->RowAttrs = array_merge($pago_proveedor->RowAttrs, array('data-rowindex'=>$pago_proveedor_grid->RowIndex, 'id'=>'r0_pago_proveedor', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($pago_proveedor->RowAttrs["class"], "ewTemplate");
		$pago_proveedor->RowType = EW_ROWTYPE_ADD;

		// Render row
		$pago_proveedor_grid->RenderRow();

		// Render list options
		$pago_proveedor_grid->RenderListOptions();
		$pago_proveedor_grid->StartRowCnt = 0;
?>
	<tr<?php echo $pago_proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pago_proveedor_grid->ListOptions->Render("body", "left", $pago_proveedor_grid->RowIndex);
?>
	<?php if ($pago_proveedor->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($pago_proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_proveedor_idsucursal" class="form-group pago_proveedor_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal"<?php echo $pago_proveedor->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idsucursal->EditValue)) {
	$arwrk = $pago_proveedor->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idsucursal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_proveedor_idsucursal" class="form-group pago_proveedor_idsucursal">
<span<?php echo $pago_proveedor->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_proveedor->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_proveedor->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_proveedor->idproveedor->Visible) { // idproveedor ?>
		<td>
<?php if ($pago_proveedor->CurrentAction <> "F") { ?>
<?php if ($pago_proveedor->idproveedor->getSessionValue() <> "") { ?>
<span id="el$rowindex$_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<span<?php echo $pago_proveedor->idproveedor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->idproveedor->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<select data-field="x_idproveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor"<?php echo $pago_proveedor->idproveedor->EditAttributes() ?>>
<?php
if (is_array($pago_proveedor->idproveedor->EditValue)) {
	$arwrk = $pago_proveedor->idproveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_proveedor->idproveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_proveedor->idproveedor) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_proveedor->idproveedor->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproveedor`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedor`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_proveedor->Lookup_Selecting($pago_proveedor->idproveedor, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="s_x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproveedor` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pago_proveedor_idproveedor" class="form-group pago_proveedor_idproveedor">
<span<?php echo $pago_proveedor->idproveedor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->idproveedor->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproveedor" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproveedor" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($pago_proveedor->idproveedor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_proveedor->monto->Visible) { // monto ?>
		<td>
<?php if ($pago_proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_proveedor_monto" class="form-group pago_proveedor_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->monto->PlaceHolder) ?>" value="<?php echo $pago_proveedor->monto->EditValue ?>"<?php echo $pago_proveedor->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_proveedor_monto" class="form-group pago_proveedor_monto">
<span<?php echo $pago_proveedor->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_proveedor->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_proveedor->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_proveedor->fecha->Visible) { // fecha ?>
		<td>
<?php if ($pago_proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_proveedor_fecha" class="form-group pago_proveedor_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_proveedor->fecha->PlaceHolder) ?>" value="<?php echo $pago_proveedor->fecha->EditValue ?>"<?php echo $pago_proveedor->fecha->EditAttributes() ?>>
<?php if (!$pago_proveedor->fecha->ReadOnly && !$pago_proveedor->fecha->Disabled && @$pago_proveedor->fecha->EditAttrs["readonly"] == "" && @$pago_proveedor->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_proveedorgrid", "x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_proveedor_fecha" class="form-group pago_proveedor_fecha">
<span<?php echo $pago_proveedor->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_proveedor->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="x<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_proveedor->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" id="o<?php echo $pago_proveedor_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_proveedor->fecha->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pago_proveedor_grid->ListOptions->Render("body", "right", $pago_proveedor_grid->RowCnt);
?>
<script type="text/javascript">
fpago_proveedorgrid.UpdateOpts(<?php echo $pago_proveedor_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($pago_proveedor->CurrentMode == "add" || $pago_proveedor->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $pago_proveedor_grid->FormKeyCountName ?>" id="<?php echo $pago_proveedor_grid->FormKeyCountName ?>" value="<?php echo $pago_proveedor_grid->KeyCount ?>">
<?php echo $pago_proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pago_proveedor->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $pago_proveedor_grid->FormKeyCountName ?>" id="<?php echo $pago_proveedor_grid->FormKeyCountName ?>" value="<?php echo $pago_proveedor_grid->KeyCount ?>">
<?php echo $pago_proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pago_proveedor->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpago_proveedorgrid">
</div>
<?php

// Close recordset
if ($pago_proveedor_grid->Recordset)
	$pago_proveedor_grid->Recordset->Close();
?>
<?php if ($pago_proveedor_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($pago_proveedor_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($pago_proveedor_grid->TotalRecs == 0 && $pago_proveedor->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pago_proveedor_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pago_proveedor->Export == "") { ?>
<script type="text/javascript">
fpago_proveedorgrid.Init();
</script>
<?php } ?>
<?php
$pago_proveedor_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$pago_proveedor_grid->Page_Terminate();
?>
