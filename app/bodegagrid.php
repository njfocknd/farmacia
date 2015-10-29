<?php

// Create page object
if (!isset($bodega_grid)) $bodega_grid = new cbodega_grid();

// Page init
$bodega_grid->Page_Init();

// Page main
$bodega_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bodega_grid->Page_Render();
?>
<?php if ($bodega->Export == "") { ?>
<script type="text/javascript">

// Page object
var bodega_grid = new ew_Page("bodega_grid");
bodega_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = bodega_grid.PageID; // For backward compatibility

// Form object
var fbodegagrid = new ew_Form("fbodegagrid");
fbodegagrid.FormKeyCountName = '<?php echo $bodega_grid->FormKeyCountName ?>';

// Validate form
fbodegagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bodega->idsucursal->FldCaption(), $bodega->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idtipo_bodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $bodega->idtipo_bodega->FldCaption(), $bodega->idtipo_bodega->ReqErrMsg)) ?>");

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
fbodegagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "descripcion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idtipo_bodega", false)) return false;
	return true;
}

// Form_CustomValidate event
fbodegagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbodegagrid.ValidateRequired = true;
<?php } else { ?>
fbodegagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbodegagrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fbodegagrid.Lists["x_idtipo_bodega"] = {"LinkField":"x_idtipo_bodega","Ajax":null,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($bodega->CurrentAction == "gridadd") {
	if ($bodega->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$bodega_grid->TotalRecs = $bodega->SelectRecordCount();
			$bodega_grid->Recordset = $bodega_grid->LoadRecordset($bodega_grid->StartRec-1, $bodega_grid->DisplayRecs);
		} else {
			if ($bodega_grid->Recordset = $bodega_grid->LoadRecordset())
				$bodega_grid->TotalRecs = $bodega_grid->Recordset->RecordCount();
		}
		$bodega_grid->StartRec = 1;
		$bodega_grid->DisplayRecs = $bodega_grid->TotalRecs;
	} else {
		$bodega->CurrentFilter = "0=1";
		$bodega_grid->StartRec = 1;
		$bodega_grid->DisplayRecs = $bodega->GridAddRowCount;
	}
	$bodega_grid->TotalRecs = $bodega_grid->DisplayRecs;
	$bodega_grid->StopRec = $bodega_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$bodega_grid->TotalRecs = $bodega->SelectRecordCount();
	} else {
		if ($bodega_grid->Recordset = $bodega_grid->LoadRecordset())
			$bodega_grid->TotalRecs = $bodega_grid->Recordset->RecordCount();
	}
	$bodega_grid->StartRec = 1;
	$bodega_grid->DisplayRecs = $bodega_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$bodega_grid->Recordset = $bodega_grid->LoadRecordset($bodega_grid->StartRec-1, $bodega_grid->DisplayRecs);

	// Set no record found message
	if ($bodega->CurrentAction == "" && $bodega_grid->TotalRecs == 0) {
		if ($bodega_grid->SearchWhere == "0=101")
			$bodega_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$bodega_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$bodega_grid->RenderOtherOptions();
?>
<?php $bodega_grid->ShowPageHeader(); ?>
<?php
$bodega_grid->ShowMessage();
?>
<?php if ($bodega_grid->TotalRecs > 0 || $bodega->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fbodegagrid" class="ewForm form-inline">
<div id="gmp_bodega" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_bodegagrid" class="table ewTable">
<?php echo $bodega->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$bodega_grid->RenderListOptions();

// Render list options (header, left)
$bodega_grid->ListOptions->Render("header", "left");
?>
<?php if ($bodega->descripcion->Visible) { // descripcion ?>
	<?php if ($bodega->SortUrl($bodega->descripcion) == "") { ?>
		<th data-name="descripcion"><div id="elh_bodega_descripcion" class="bodega_descripcion"><div class="ewTableHeaderCaption"><?php echo $bodega->descripcion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descripcion"><div><div id="elh_bodega_descripcion" class="bodega_descripcion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bodega->descripcion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bodega->descripcion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bodega->descripcion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bodega->idsucursal->Visible) { // idsucursal ?>
	<?php if ($bodega->SortUrl($bodega->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_bodega_idsucursal" class="bodega_idsucursal"><div class="ewTableHeaderCaption"><?php echo $bodega->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_bodega_idsucursal" class="bodega_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bodega->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bodega->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bodega->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bodega->idtipo_bodega->Visible) { // idtipo_bodega ?>
	<?php if ($bodega->SortUrl($bodega->idtipo_bodega) == "") { ?>
		<th data-name="idtipo_bodega"><div id="elh_bodega_idtipo_bodega" class="bodega_idtipo_bodega"><div class="ewTableHeaderCaption"><?php echo $bodega->idtipo_bodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_bodega"><div><div id="elh_bodega_idtipo_bodega" class="bodega_idtipo_bodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bodega->idtipo_bodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bodega->idtipo_bodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($bodega->idtipo_bodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$bodega_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$bodega_grid->StartRec = 1;
$bodega_grid->StopRec = $bodega_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($bodega_grid->FormKeyCountName) && ($bodega->CurrentAction == "gridadd" || $bodega->CurrentAction == "gridedit" || $bodega->CurrentAction == "F")) {
		$bodega_grid->KeyCount = $objForm->GetValue($bodega_grid->FormKeyCountName);
		$bodega_grid->StopRec = $bodega_grid->StartRec + $bodega_grid->KeyCount - 1;
	}
}
$bodega_grid->RecCnt = $bodega_grid->StartRec - 1;
if ($bodega_grid->Recordset && !$bodega_grid->Recordset->EOF) {
	$bodega_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $bodega_grid->StartRec > 1)
		$bodega_grid->Recordset->Move($bodega_grid->StartRec - 1);
} elseif (!$bodega->AllowAddDeleteRow && $bodega_grid->StopRec == 0) {
	$bodega_grid->StopRec = $bodega->GridAddRowCount;
}

// Initialize aggregate
$bodega->RowType = EW_ROWTYPE_AGGREGATEINIT;
$bodega->ResetAttrs();
$bodega_grid->RenderRow();
if ($bodega->CurrentAction == "gridadd")
	$bodega_grid->RowIndex = 0;
if ($bodega->CurrentAction == "gridedit")
	$bodega_grid->RowIndex = 0;
while ($bodega_grid->RecCnt < $bodega_grid->StopRec) {
	$bodega_grid->RecCnt++;
	if (intval($bodega_grid->RecCnt) >= intval($bodega_grid->StartRec)) {
		$bodega_grid->RowCnt++;
		if ($bodega->CurrentAction == "gridadd" || $bodega->CurrentAction == "gridedit" || $bodega->CurrentAction == "F") {
			$bodega_grid->RowIndex++;
			$objForm->Index = $bodega_grid->RowIndex;
			if ($objForm->HasValue($bodega_grid->FormActionName))
				$bodega_grid->RowAction = strval($objForm->GetValue($bodega_grid->FormActionName));
			elseif ($bodega->CurrentAction == "gridadd")
				$bodega_grid->RowAction = "insert";
			else
				$bodega_grid->RowAction = "";
		}

		// Set up key count
		$bodega_grid->KeyCount = $bodega_grid->RowIndex;

		// Init row class and style
		$bodega->ResetAttrs();
		$bodega->CssClass = "";
		if ($bodega->CurrentAction == "gridadd") {
			if ($bodega->CurrentMode == "copy") {
				$bodega_grid->LoadRowValues($bodega_grid->Recordset); // Load row values
				$bodega_grid->SetRecordKey($bodega_grid->RowOldKey, $bodega_grid->Recordset); // Set old record key
			} else {
				$bodega_grid->LoadDefaultValues(); // Load default values
				$bodega_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$bodega_grid->LoadRowValues($bodega_grid->Recordset); // Load row values
		}
		$bodega->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($bodega->CurrentAction == "gridadd") // Grid add
			$bodega->RowType = EW_ROWTYPE_ADD; // Render add
		if ($bodega->CurrentAction == "gridadd" && $bodega->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$bodega_grid->RestoreCurrentRowFormValues($bodega_grid->RowIndex); // Restore form values
		if ($bodega->CurrentAction == "gridedit") { // Grid edit
			if ($bodega->EventCancelled) {
				$bodega_grid->RestoreCurrentRowFormValues($bodega_grid->RowIndex); // Restore form values
			}
			if ($bodega_grid->RowAction == "insert")
				$bodega->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$bodega->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($bodega->CurrentAction == "gridedit" && ($bodega->RowType == EW_ROWTYPE_EDIT || $bodega->RowType == EW_ROWTYPE_ADD) && $bodega->EventCancelled) // Update failed
			$bodega_grid->RestoreCurrentRowFormValues($bodega_grid->RowIndex); // Restore form values
		if ($bodega->RowType == EW_ROWTYPE_EDIT) // Edit row
			$bodega_grid->EditRowCnt++;
		if ($bodega->CurrentAction == "F") // Confirm row
			$bodega_grid->RestoreCurrentRowFormValues($bodega_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$bodega->RowAttrs = array_merge($bodega->RowAttrs, array('data-rowindex'=>$bodega_grid->RowCnt, 'id'=>'r' . $bodega_grid->RowCnt . '_bodega', 'data-rowtype'=>$bodega->RowType));

		// Render row
		$bodega_grid->RenderRow();

		// Render list options
		$bodega_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($bodega_grid->RowAction <> "delete" && $bodega_grid->RowAction <> "insertdelete" && !($bodega_grid->RowAction == "insert" && $bodega->CurrentAction == "F" && $bodega_grid->EmptyRow())) {
?>
	<tr<?php echo $bodega->RowAttributes() ?>>
<?php

// Render list options (body, left)
$bodega_grid->ListOptions->Render("body", "left", $bodega_grid->RowCnt);
?>
	<?php if ($bodega->descripcion->Visible) { // descripcion ?>
		<td data-name="descripcion"<?php echo $bodega->descripcion->CellAttributes() ?>>
<?php if ($bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_descripcion" class="form-group bodega_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $bodega_grid->RowIndex ?>_descripcion" id="x<?php echo $bodega_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($bodega->descripcion->PlaceHolder) ?>" value="<?php echo $bodega->descripcion->EditValue ?>"<?php echo $bodega->descripcion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $bodega_grid->RowIndex ?>_descripcion" id="o<?php echo $bodega_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($bodega->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_descripcion" class="form-group bodega_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $bodega_grid->RowIndex ?>_descripcion" id="x<?php echo $bodega_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($bodega->descripcion->PlaceHolder) ?>" value="<?php echo $bodega->descripcion->EditValue ?>"<?php echo $bodega->descripcion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $bodega->descripcion->ViewAttributes() ?>>
<?php echo $bodega->descripcion->ListViewValue() ?></span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $bodega_grid->RowIndex ?>_descripcion" id="x<?php echo $bodega_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($bodega->descripcion->FormValue) ?>">
<input type="hidden" data-field="x_descripcion" name="o<?php echo $bodega_grid->RowIndex ?>_descripcion" id="o<?php echo $bodega_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($bodega->descripcion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $bodega_grid->PageObjName . "_row_" . $bodega_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $bodega_grid->RowIndex ?>_idbodega" id="x<?php echo $bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($bodega->idbodega->CurrentValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $bodega_grid->RowIndex ?>_idbodega" id="o<?php echo $bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($bodega->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_EDIT || $bodega->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $bodega_grid->RowIndex ?>_idbodega" id="x<?php echo $bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($bodega->idbodega->CurrentValue) ?>">
<?php } ?>
	<?php if ($bodega->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $bodega->idsucursal->CellAttributes() ?>>
<?php if ($bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($bodega->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idsucursal" class="form-group bodega_idsucursal">
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idsucursal" class="form-group bodega_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal"<?php echo $bodega->idsucursal->EditAttributes() ?>>
<?php
if (is_array($bodega->idsucursal->EditValue)) {
	$arwrk = $bodega->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idsucursal->OldValue = "";
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
 $bodega->Lookup_Selecting($bodega->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($bodega->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idsucursal" class="form-group bodega_idsucursal">
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idsucursal" class="form-group bodega_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal"<?php echo $bodega->idsucursal->EditAttributes() ?>>
<?php
if (is_array($bodega->idsucursal->EditValue)) {
	$arwrk = $bodega->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idsucursal->OldValue = "";
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
 $bodega->Lookup_Selecting($bodega->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<?php echo $bodega->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($bodega->idtipo_bodega->Visible) { // idtipo_bodega ?>
		<td data-name="idtipo_bodega"<?php echo $bodega->idtipo_bodega->CellAttributes() ?>>
<?php if ($bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($bodega->idtipo_bodega->getSessionValue() <> "") { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idtipo_bodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<select data-field="x_idtipo_bodega" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega"<?php echo $bodega->idtipo_bodega->EditAttributes() ?>>
<?php
if (is_array($bodega->idtipo_bodega->EditValue)) {
	$arwrk = $bodega->idtipo_bodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idtipo_bodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idtipo_bodega->OldValue = "";
?>
</select>
<script type="text/javascript">
fbodegagrid.Lists["x_idtipo_bodega"].Options = <?php echo (is_array($bodega->idtipo_bodega->EditValue)) ? ew_ArrayToJson($bodega->idtipo_bodega->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<input type="hidden" data-field="x_idtipo_bodega" name="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" id="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->OldValue) ?>">
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($bodega->idtipo_bodega->getSessionValue() <> "") { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idtipo_bodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $bodega_grid->RowCnt ?>_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<select data-field="x_idtipo_bodega" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega"<?php echo $bodega->idtipo_bodega->EditAttributes() ?>>
<?php
if (is_array($bodega->idtipo_bodega->EditValue)) {
	$arwrk = $bodega->idtipo_bodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idtipo_bodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idtipo_bodega->OldValue = "";
?>
</select>
<script type="text/javascript">
fbodegagrid.Lists["x_idtipo_bodega"].Options = <?php echo (is_array($bodega->idtipo_bodega->EditValue)) ? ew_ArrayToJson($bodega->idtipo_bodega->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<?php echo $bodega->idtipo_bodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->FormValue) ?>">
<input type="hidden" data-field="x_idtipo_bodega" name="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" id="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$bodega_grid->ListOptions->Render("body", "right", $bodega_grid->RowCnt);
?>
	</tr>
<?php if ($bodega->RowType == EW_ROWTYPE_ADD || $bodega->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbodegagrid.UpdateOpts(<?php echo $bodega_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($bodega->CurrentAction <> "gridadd" || $bodega->CurrentMode == "copy")
		if (!$bodega_grid->Recordset->EOF) $bodega_grid->Recordset->MoveNext();
}
?>
<?php
	if ($bodega->CurrentMode == "add" || $bodega->CurrentMode == "copy" || $bodega->CurrentMode == "edit") {
		$bodega_grid->RowIndex = '$rowindex$';
		$bodega_grid->LoadDefaultValues();

		// Set row properties
		$bodega->ResetAttrs();
		$bodega->RowAttrs = array_merge($bodega->RowAttrs, array('data-rowindex'=>$bodega_grid->RowIndex, 'id'=>'r0_bodega', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($bodega->RowAttrs["class"], "ewTemplate");
		$bodega->RowType = EW_ROWTYPE_ADD;

		// Render row
		$bodega_grid->RenderRow();

		// Render list options
		$bodega_grid->RenderListOptions();
		$bodega_grid->StartRowCnt = 0;
?>
	<tr<?php echo $bodega->RowAttributes() ?>>
<?php

// Render list options (body, left)
$bodega_grid->ListOptions->Render("body", "left", $bodega_grid->RowIndex);
?>
	<?php if ($bodega->descripcion->Visible) { // descripcion ?>
		<td>
<?php if ($bodega->CurrentAction <> "F") { ?>
<span id="el$rowindex$_bodega_descripcion" class="form-group bodega_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $bodega_grid->RowIndex ?>_descripcion" id="x<?php echo $bodega_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($bodega->descripcion->PlaceHolder) ?>" value="<?php echo $bodega->descripcion->EditValue ?>"<?php echo $bodega->descripcion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_bodega_descripcion" class="form-group bodega_descripcion">
<span<?php echo $bodega->descripcion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->descripcion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $bodega_grid->RowIndex ?>_descripcion" id="x<?php echo $bodega_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($bodega->descripcion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $bodega_grid->RowIndex ?>_descripcion" id="o<?php echo $bodega_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($bodega->descripcion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($bodega->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($bodega->CurrentAction <> "F") { ?>
<?php if ($bodega->idsucursal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_bodega_idsucursal" class="form-group bodega_idsucursal">
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_bodega_idsucursal" class="form-group bodega_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal"<?php echo $bodega->idsucursal->EditAttributes() ?>>
<?php
if (is_array($bodega->idsucursal->EditValue)) {
	$arwrk = $bodega->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idsucursal->OldValue = "";
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
 $bodega->Lookup_Selecting($bodega->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_bodega_idsucursal" class="form-group bodega_idsucursal">
<span<?php echo $bodega->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="x<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" id="o<?php echo $bodega_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($bodega->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($bodega->idtipo_bodega->Visible) { // idtipo_bodega ?>
		<td>
<?php if ($bodega->CurrentAction <> "F") { ?>
<?php if ($bodega->idtipo_bodega->getSessionValue() <> "") { ?>
<span id="el$rowindex$_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idtipo_bodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<select data-field="x_idtipo_bodega" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega"<?php echo $bodega->idtipo_bodega->EditAttributes() ?>>
<?php
if (is_array($bodega->idtipo_bodega->EditValue)) {
	$arwrk = $bodega->idtipo_bodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($bodega->idtipo_bodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $bodega->idtipo_bodega->OldValue = "";
?>
</select>
<script type="text/javascript">
fbodegagrid.Lists["x_idtipo_bodega"].Options = <?php echo (is_array($bodega->idtipo_bodega->EditValue)) ? ew_ArrayToJson($bodega->idtipo_bodega->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_bodega_idtipo_bodega" class="form-group bodega_idtipo_bodega">
<span<?php echo $bodega->idtipo_bodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $bodega->idtipo_bodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idtipo_bodega" name="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" id="x<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idtipo_bodega" name="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" id="o<?php echo $bodega_grid->RowIndex ?>_idtipo_bodega" value="<?php echo ew_HtmlEncode($bodega->idtipo_bodega->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$bodega_grid->ListOptions->Render("body", "right", $bodega_grid->RowCnt);
?>
<script type="text/javascript">
fbodegagrid.UpdateOpts(<?php echo $bodega_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($bodega->CurrentMode == "add" || $bodega->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $bodega_grid->FormKeyCountName ?>" id="<?php echo $bodega_grid->FormKeyCountName ?>" value="<?php echo $bodega_grid->KeyCount ?>">
<?php echo $bodega_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($bodega->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $bodega_grid->FormKeyCountName ?>" id="<?php echo $bodega_grid->FormKeyCountName ?>" value="<?php echo $bodega_grid->KeyCount ?>">
<?php echo $bodega_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($bodega->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbodegagrid">
</div>
<?php

// Close recordset
if ($bodega_grid->Recordset)
	$bodega_grid->Recordset->Close();
?>
<?php if ($bodega_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($bodega_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($bodega_grid->TotalRecs == 0 && $bodega->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($bodega_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($bodega->Export == "") { ?>
<script type="text/javascript">
fbodegagrid.Init();
</script>
<?php } ?>
<?php
$bodega_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$bodega_grid->Page_Terminate();
?>
