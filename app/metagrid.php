<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($meta_grid)) $meta_grid = new cmeta_grid();

// Page init
$meta_grid->Page_Init();

// Page main
$meta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$meta_grid->Page_Render();
?>
<?php if ($meta->Export == "") { ?>
<script type="text/javascript">

// Page object
var meta_grid = new ew_Page("meta_grid");
meta_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = meta_grid.PageID; // For backward compatibility

// Form object
var fmetagrid = new ew_Form("fmetagrid");
fmetagrid.FormKeyCountName = '<?php echo $meta_grid->FormKeyCountName ?>';

// Validate form
fmetagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->idsucursal->FldCaption(), $meta->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->idperiodo_contable->FldCaption(), $meta->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->monto->FldCaption(), $meta->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($meta->monto->FldErrMsg()) ?>");

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
fmetagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idperiodo_contable", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fmetagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmetagrid.ValidateRequired = true;
<?php } else { ?>
fmetagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmetagrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fmetagrid.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($meta->CurrentAction == "gridadd") {
	if ($meta->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$meta_grid->TotalRecs = $meta->SelectRecordCount();
			$meta_grid->Recordset = $meta_grid->LoadRecordset($meta_grid->StartRec-1, $meta_grid->DisplayRecs);
		} else {
			if ($meta_grid->Recordset = $meta_grid->LoadRecordset())
				$meta_grid->TotalRecs = $meta_grid->Recordset->RecordCount();
		}
		$meta_grid->StartRec = 1;
		$meta_grid->DisplayRecs = $meta_grid->TotalRecs;
	} else {
		$meta->CurrentFilter = "0=1";
		$meta_grid->StartRec = 1;
		$meta_grid->DisplayRecs = $meta->GridAddRowCount;
	}
	$meta_grid->TotalRecs = $meta_grid->DisplayRecs;
	$meta_grid->StopRec = $meta_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$meta_grid->TotalRecs = $meta->SelectRecordCount();
	} else {
		if ($meta_grid->Recordset = $meta_grid->LoadRecordset())
			$meta_grid->TotalRecs = $meta_grid->Recordset->RecordCount();
	}
	$meta_grid->StartRec = 1;
	$meta_grid->DisplayRecs = $meta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$meta_grid->Recordset = $meta_grid->LoadRecordset($meta_grid->StartRec-1, $meta_grid->DisplayRecs);

	// Set no record found message
	if ($meta->CurrentAction == "" && $meta_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$meta_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($meta_grid->SearchWhere == "0=101")
			$meta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$meta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$meta_grid->RenderOtherOptions();
?>
<?php $meta_grid->ShowPageHeader(); ?>
<?php
$meta_grid->ShowMessage();
?>
<?php if ($meta_grid->TotalRecs > 0 || $meta->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fmetagrid" class="ewForm form-inline">
<div id="gmp_meta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_metagrid" class="table ewTable">
<?php echo $meta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$meta_grid->RenderListOptions();

// Render list options (header, left)
$meta_grid->ListOptions->Render("header", "left");
?>
<?php if ($meta->idsucursal->Visible) { // idsucursal ?>
	<?php if ($meta->SortUrl($meta->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_meta_idsucursal" class="meta_idsucursal"><div class="ewTableHeaderCaption"><?php echo $meta->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_meta_idsucursal" class="meta_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $meta->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($meta->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($meta->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($meta->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<?php if ($meta->SortUrl($meta->idperiodo_contable) == "") { ?>
		<th data-name="idperiodo_contable"><div id="elh_meta_idperiodo_contable" class="meta_idperiodo_contable"><div class="ewTableHeaderCaption"><?php echo $meta->idperiodo_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperiodo_contable"><div><div id="elh_meta_idperiodo_contable" class="meta_idperiodo_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $meta->idperiodo_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($meta->idperiodo_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($meta->idperiodo_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($meta->monto->Visible) { // monto ?>
	<?php if ($meta->SortUrl($meta->monto) == "") { ?>
		<th data-name="monto"><div id="elh_meta_monto" class="meta_monto"><div class="ewTableHeaderCaption"><?php echo $meta->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_meta_monto" class="meta_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $meta->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($meta->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($meta->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$meta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$meta_grid->StartRec = 1;
$meta_grid->StopRec = $meta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($meta_grid->FormKeyCountName) && ($meta->CurrentAction == "gridadd" || $meta->CurrentAction == "gridedit" || $meta->CurrentAction == "F")) {
		$meta_grid->KeyCount = $objForm->GetValue($meta_grid->FormKeyCountName);
		$meta_grid->StopRec = $meta_grid->StartRec + $meta_grid->KeyCount - 1;
	}
}
$meta_grid->RecCnt = $meta_grid->StartRec - 1;
if ($meta_grid->Recordset && !$meta_grid->Recordset->EOF) {
	$meta_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $meta_grid->StartRec > 1)
		$meta_grid->Recordset->Move($meta_grid->StartRec - 1);
} elseif (!$meta->AllowAddDeleteRow && $meta_grid->StopRec == 0) {
	$meta_grid->StopRec = $meta->GridAddRowCount;
}

// Initialize aggregate
$meta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$meta->ResetAttrs();
$meta_grid->RenderRow();
if ($meta->CurrentAction == "gridadd")
	$meta_grid->RowIndex = 0;
if ($meta->CurrentAction == "gridedit")
	$meta_grid->RowIndex = 0;
while ($meta_grid->RecCnt < $meta_grid->StopRec) {
	$meta_grid->RecCnt++;
	if (intval($meta_grid->RecCnt) >= intval($meta_grid->StartRec)) {
		$meta_grid->RowCnt++;
		if ($meta->CurrentAction == "gridadd" || $meta->CurrentAction == "gridedit" || $meta->CurrentAction == "F") {
			$meta_grid->RowIndex++;
			$objForm->Index = $meta_grid->RowIndex;
			if ($objForm->HasValue($meta_grid->FormActionName))
				$meta_grid->RowAction = strval($objForm->GetValue($meta_grid->FormActionName));
			elseif ($meta->CurrentAction == "gridadd")
				$meta_grid->RowAction = "insert";
			else
				$meta_grid->RowAction = "";
		}

		// Set up key count
		$meta_grid->KeyCount = $meta_grid->RowIndex;

		// Init row class and style
		$meta->ResetAttrs();
		$meta->CssClass = "";
		if ($meta->CurrentAction == "gridadd") {
			if ($meta->CurrentMode == "copy") {
				$meta_grid->LoadRowValues($meta_grid->Recordset); // Load row values
				$meta_grid->SetRecordKey($meta_grid->RowOldKey, $meta_grid->Recordset); // Set old record key
			} else {
				$meta_grid->LoadDefaultValues(); // Load default values
				$meta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$meta_grid->LoadRowValues($meta_grid->Recordset); // Load row values
		}
		$meta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($meta->CurrentAction == "gridadd") // Grid add
			$meta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($meta->CurrentAction == "gridadd" && $meta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$meta_grid->RestoreCurrentRowFormValues($meta_grid->RowIndex); // Restore form values
		if ($meta->CurrentAction == "gridedit") { // Grid edit
			if ($meta->EventCancelled) {
				$meta_grid->RestoreCurrentRowFormValues($meta_grid->RowIndex); // Restore form values
			}
			if ($meta_grid->RowAction == "insert")
				$meta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$meta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($meta->CurrentAction == "gridedit" && ($meta->RowType == EW_ROWTYPE_EDIT || $meta->RowType == EW_ROWTYPE_ADD) && $meta->EventCancelled) // Update failed
			$meta_grid->RestoreCurrentRowFormValues($meta_grid->RowIndex); // Restore form values
		if ($meta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$meta_grid->EditRowCnt++;
		if ($meta->CurrentAction == "F") // Confirm row
			$meta_grid->RestoreCurrentRowFormValues($meta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$meta->RowAttrs = array_merge($meta->RowAttrs, array('data-rowindex'=>$meta_grid->RowCnt, 'id'=>'r' . $meta_grid->RowCnt . '_meta', 'data-rowtype'=>$meta->RowType));

		// Render row
		$meta_grid->RenderRow();

		// Render list options
		$meta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($meta_grid->RowAction <> "delete" && $meta_grid->RowAction <> "insertdelete" && !($meta_grid->RowAction == "insert" && $meta->CurrentAction == "F" && $meta_grid->EmptyRow())) {
?>
	<tr<?php echo $meta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$meta_grid->ListOptions->Render("body", "left", $meta_grid->RowCnt);
?>
	<?php if ($meta->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $meta->idsucursal->CellAttributes() ?>>
<?php if ($meta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idsucursal" class="form-group meta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $meta_grid->RowIndex ?>_idsucursal" name="x<?php echo $meta_grid->RowIndex ?>_idsucursal"<?php echo $meta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($meta->idsucursal->EditValue)) {
	$arwrk = $meta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idsucursal->OldValue = "";
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
 $meta->Lookup_Selecting($meta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $meta_grid->RowIndex ?>_idsucursal" id="o<?php echo $meta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($meta->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idsucursal" class="form-group meta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $meta_grid->RowIndex ?>_idsucursal" name="x<?php echo $meta_grid->RowIndex ?>_idsucursal"<?php echo $meta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($meta->idsucursal->EditValue)) {
	$arwrk = $meta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idsucursal->OldValue = "";
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
 $meta->Lookup_Selecting($meta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $meta->idsucursal->ViewAttributes() ?>>
<?php echo $meta->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $meta_grid->RowIndex ?>_idsucursal" id="x<?php echo $meta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($meta->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $meta_grid->RowIndex ?>_idsucursal" id="o<?php echo $meta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($meta->idsucursal->OldValue) ?>">
<?php } ?>
<a id="<?php echo $meta_grid->PageObjName . "_row_" . $meta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idmeta" name="x<?php echo $meta_grid->RowIndex ?>_idmeta" id="x<?php echo $meta_grid->RowIndex ?>_idmeta" value="<?php echo ew_HtmlEncode($meta->idmeta->CurrentValue) ?>">
<input type="hidden" data-field="x_idmeta" name="o<?php echo $meta_grid->RowIndex ?>_idmeta" id="o<?php echo $meta_grid->RowIndex ?>_idmeta" value="<?php echo ew_HtmlEncode($meta->idmeta->OldValue) ?>">
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_EDIT || $meta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idmeta" name="x<?php echo $meta_grid->RowIndex ?>_idmeta" id="x<?php echo $meta_grid->RowIndex ?>_idmeta" value="<?php echo ew_HtmlEncode($meta->idmeta->CurrentValue) ?>">
<?php } ?>
	<?php if ($meta->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable"<?php echo $meta->idperiodo_contable->CellAttributes() ?>>
<?php if ($meta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($meta->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable"<?php echo $meta->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($meta->idperiodo_contable->EditValue)) {
	$arwrk = $meta->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$meta->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $meta->Lookup_Selecting($meta->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->OldValue) ?>">
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($meta->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable"<?php echo $meta->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($meta->idperiodo_contable->EditValue)) {
	$arwrk = $meta->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$meta->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $meta->Lookup_Selecting($meta->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<?php echo $meta->idperiodo_contable->ListViewValue() ?></span>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->FormValue) ?>">
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($meta->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $meta->monto->CellAttributes() ?>>
<?php if ($meta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_monto" class="form-group meta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $meta_grid->RowIndex ?>_monto" id="x<?php echo $meta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($meta->monto->PlaceHolder) ?>" value="<?php echo $meta->monto->EditValue ?>"<?php echo $meta->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $meta_grid->RowIndex ?>_monto" id="o<?php echo $meta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($meta->monto->OldValue) ?>">
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $meta_grid->RowCnt ?>_meta_monto" class="form-group meta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $meta_grid->RowIndex ?>_monto" id="x<?php echo $meta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($meta->monto->PlaceHolder) ?>" value="<?php echo $meta->monto->EditValue ?>"<?php echo $meta->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($meta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $meta->monto->ViewAttributes() ?>>
<?php echo $meta->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $meta_grid->RowIndex ?>_monto" id="x<?php echo $meta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($meta->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $meta_grid->RowIndex ?>_monto" id="o<?php echo $meta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($meta->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$meta_grid->ListOptions->Render("body", "right", $meta_grid->RowCnt);
?>
	</tr>
<?php if ($meta->RowType == EW_ROWTYPE_ADD || $meta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmetagrid.UpdateOpts(<?php echo $meta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($meta->CurrentAction <> "gridadd" || $meta->CurrentMode == "copy")
		if (!$meta_grid->Recordset->EOF) $meta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($meta->CurrentMode == "add" || $meta->CurrentMode == "copy" || $meta->CurrentMode == "edit") {
		$meta_grid->RowIndex = '$rowindex$';
		$meta_grid->LoadDefaultValues();

		// Set row properties
		$meta->ResetAttrs();
		$meta->RowAttrs = array_merge($meta->RowAttrs, array('data-rowindex'=>$meta_grid->RowIndex, 'id'=>'r0_meta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($meta->RowAttrs["class"], "ewTemplate");
		$meta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$meta_grid->RenderRow();

		// Render list options
		$meta_grid->RenderListOptions();
		$meta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $meta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$meta_grid->ListOptions->Render("body", "left", $meta_grid->RowIndex);
?>
	<?php if ($meta->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($meta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_meta_idsucursal" class="form-group meta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $meta_grid->RowIndex ?>_idsucursal" name="x<?php echo $meta_grid->RowIndex ?>_idsucursal"<?php echo $meta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($meta->idsucursal->EditValue)) {
	$arwrk = $meta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idsucursal->OldValue = "";
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
 $meta->Lookup_Selecting($meta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $meta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_meta_idsucursal" class="form-group meta_idsucursal">
<span<?php echo $meta->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $meta_grid->RowIndex ?>_idsucursal" id="x<?php echo $meta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($meta->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $meta_grid->RowIndex ?>_idsucursal" id="o<?php echo $meta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($meta->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($meta->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td>
<?php if ($meta->CurrentAction <> "F") { ?>
<?php if ($meta->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el$rowindex$_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable"<?php echo $meta->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($meta->idperiodo_contable->EditValue)) {
	$arwrk = $meta->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$meta->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $meta->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $meta->Lookup_Selecting($meta->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_meta_idperiodo_contable" class="form-group meta_idperiodo_contable">
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $meta_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($meta->monto->Visible) { // monto ?>
		<td>
<?php if ($meta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_meta_monto" class="form-group meta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $meta_grid->RowIndex ?>_monto" id="x<?php echo $meta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($meta->monto->PlaceHolder) ?>" value="<?php echo $meta->monto->EditValue ?>"<?php echo $meta->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_meta_monto" class="form-group meta_monto">
<span<?php echo $meta->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $meta_grid->RowIndex ?>_monto" id="x<?php echo $meta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($meta->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $meta_grid->RowIndex ?>_monto" id="o<?php echo $meta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($meta->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$meta_grid->ListOptions->Render("body", "right", $meta_grid->RowCnt);
?>
<script type="text/javascript">
fmetagrid.UpdateOpts(<?php echo $meta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($meta->CurrentMode == "add" || $meta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $meta_grid->FormKeyCountName ?>" id="<?php echo $meta_grid->FormKeyCountName ?>" value="<?php echo $meta_grid->KeyCount ?>">
<?php echo $meta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($meta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $meta_grid->FormKeyCountName ?>" id="<?php echo $meta_grid->FormKeyCountName ?>" value="<?php echo $meta_grid->KeyCount ?>">
<?php echo $meta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($meta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmetagrid">
</div>
<?php

// Close recordset
if ($meta_grid->Recordset)
	$meta_grid->Recordset->Close();
?>
<?php if ($meta_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($meta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($meta_grid->TotalRecs == 0 && $meta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($meta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($meta->Export == "") { ?>
<script type="text/javascript">
fmetagrid.Init();
</script>
<?php } ?>
<?php
$meta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$meta_grid->Page_Terminate();
?>
