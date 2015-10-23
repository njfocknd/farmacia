<?php

// Create page object
if (!isset($laboratorio_grid)) $laboratorio_grid = new claboratorio_grid();

// Page init
$laboratorio_grid->Page_Init();

// Page main
$laboratorio_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$laboratorio_grid->Page_Render();
?>
<?php if ($laboratorio->Export == "") { ?>
<script type="text/javascript">

// Page object
var laboratorio_grid = new ew_Page("laboratorio_grid");
laboratorio_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = laboratorio_grid.PageID; // For backward compatibility

// Form object
var flaboratoriogrid = new ew_Form("flaboratoriogrid");
flaboratoriogrid.FormKeyCountName = '<?php echo $laboratorio_grid->FormKeyCountName ?>';

// Validate form
flaboratoriogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $laboratorio->nombre->FldCaption(), $laboratorio->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $laboratorio->idpais->FldCaption(), $laboratorio->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $laboratorio->estado->FldCaption(), $laboratorio->estado->ReqErrMsg)) ?>");

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
flaboratoriogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
flaboratoriogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flaboratoriogrid.ValidateRequired = true;
<?php } else { ?>
flaboratoriogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flaboratoriogrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($laboratorio->CurrentAction == "gridadd") {
	if ($laboratorio->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$laboratorio_grid->TotalRecs = $laboratorio->SelectRecordCount();
			$laboratorio_grid->Recordset = $laboratorio_grid->LoadRecordset($laboratorio_grid->StartRec-1, $laboratorio_grid->DisplayRecs);
		} else {
			if ($laboratorio_grid->Recordset = $laboratorio_grid->LoadRecordset())
				$laboratorio_grid->TotalRecs = $laboratorio_grid->Recordset->RecordCount();
		}
		$laboratorio_grid->StartRec = 1;
		$laboratorio_grid->DisplayRecs = $laboratorio_grid->TotalRecs;
	} else {
		$laboratorio->CurrentFilter = "0=1";
		$laboratorio_grid->StartRec = 1;
		$laboratorio_grid->DisplayRecs = $laboratorio->GridAddRowCount;
	}
	$laboratorio_grid->TotalRecs = $laboratorio_grid->DisplayRecs;
	$laboratorio_grid->StopRec = $laboratorio_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$laboratorio_grid->TotalRecs = $laboratorio->SelectRecordCount();
	} else {
		if ($laboratorio_grid->Recordset = $laboratorio_grid->LoadRecordset())
			$laboratorio_grid->TotalRecs = $laboratorio_grid->Recordset->RecordCount();
	}
	$laboratorio_grid->StartRec = 1;
	$laboratorio_grid->DisplayRecs = $laboratorio_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$laboratorio_grid->Recordset = $laboratorio_grid->LoadRecordset($laboratorio_grid->StartRec-1, $laboratorio_grid->DisplayRecs);

	// Set no record found message
	if ($laboratorio->CurrentAction == "" && $laboratorio_grid->TotalRecs == 0) {
		if ($laboratorio_grid->SearchWhere == "0=101")
			$laboratorio_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$laboratorio_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$laboratorio_grid->RenderOtherOptions();
?>
<?php $laboratorio_grid->ShowPageHeader(); ?>
<?php
$laboratorio_grid->ShowMessage();
?>
<?php if ($laboratorio_grid->TotalRecs > 0 || $laboratorio->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="flaboratoriogrid" class="ewForm form-inline">
<div id="gmp_laboratorio" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_laboratoriogrid" class="table ewTable">
<?php echo $laboratorio->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$laboratorio_grid->RenderListOptions();

// Render list options (header, left)
$laboratorio_grid->ListOptions->Render("header", "left");
?>
<?php if ($laboratorio->nombre->Visible) { // nombre ?>
	<?php if ($laboratorio->SortUrl($laboratorio->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_laboratorio_nombre" class="laboratorio_nombre"><div class="ewTableHeaderCaption"><?php echo $laboratorio->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_laboratorio_nombre" class="laboratorio_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $laboratorio->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($laboratorio->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($laboratorio->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($laboratorio->idpais->Visible) { // idpais ?>
	<?php if ($laboratorio->SortUrl($laboratorio->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_laboratorio_idpais" class="laboratorio_idpais"><div class="ewTableHeaderCaption"><?php echo $laboratorio->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_laboratorio_idpais" class="laboratorio_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $laboratorio->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($laboratorio->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($laboratorio->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($laboratorio->estado->Visible) { // estado ?>
	<?php if ($laboratorio->SortUrl($laboratorio->estado) == "") { ?>
		<th data-name="estado"><div id="elh_laboratorio_estado" class="laboratorio_estado"><div class="ewTableHeaderCaption"><?php echo $laboratorio->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_laboratorio_estado" class="laboratorio_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $laboratorio->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($laboratorio->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($laboratorio->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$laboratorio_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$laboratorio_grid->StartRec = 1;
$laboratorio_grid->StopRec = $laboratorio_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($laboratorio_grid->FormKeyCountName) && ($laboratorio->CurrentAction == "gridadd" || $laboratorio->CurrentAction == "gridedit" || $laboratorio->CurrentAction == "F")) {
		$laboratorio_grid->KeyCount = $objForm->GetValue($laboratorio_grid->FormKeyCountName);
		$laboratorio_grid->StopRec = $laboratorio_grid->StartRec + $laboratorio_grid->KeyCount - 1;
	}
}
$laboratorio_grid->RecCnt = $laboratorio_grid->StartRec - 1;
if ($laboratorio_grid->Recordset && !$laboratorio_grid->Recordset->EOF) {
	$laboratorio_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $laboratorio_grid->StartRec > 1)
		$laboratorio_grid->Recordset->Move($laboratorio_grid->StartRec - 1);
} elseif (!$laboratorio->AllowAddDeleteRow && $laboratorio_grid->StopRec == 0) {
	$laboratorio_grid->StopRec = $laboratorio->GridAddRowCount;
}

// Initialize aggregate
$laboratorio->RowType = EW_ROWTYPE_AGGREGATEINIT;
$laboratorio->ResetAttrs();
$laboratorio_grid->RenderRow();
if ($laboratorio->CurrentAction == "gridadd")
	$laboratorio_grid->RowIndex = 0;
if ($laboratorio->CurrentAction == "gridedit")
	$laboratorio_grid->RowIndex = 0;
while ($laboratorio_grid->RecCnt < $laboratorio_grid->StopRec) {
	$laboratorio_grid->RecCnt++;
	if (intval($laboratorio_grid->RecCnt) >= intval($laboratorio_grid->StartRec)) {
		$laboratorio_grid->RowCnt++;
		if ($laboratorio->CurrentAction == "gridadd" || $laboratorio->CurrentAction == "gridedit" || $laboratorio->CurrentAction == "F") {
			$laboratorio_grid->RowIndex++;
			$objForm->Index = $laboratorio_grid->RowIndex;
			if ($objForm->HasValue($laboratorio_grid->FormActionName))
				$laboratorio_grid->RowAction = strval($objForm->GetValue($laboratorio_grid->FormActionName));
			elseif ($laboratorio->CurrentAction == "gridadd")
				$laboratorio_grid->RowAction = "insert";
			else
				$laboratorio_grid->RowAction = "";
		}

		// Set up key count
		$laboratorio_grid->KeyCount = $laboratorio_grid->RowIndex;

		// Init row class and style
		$laboratorio->ResetAttrs();
		$laboratorio->CssClass = "";
		if ($laboratorio->CurrentAction == "gridadd") {
			if ($laboratorio->CurrentMode == "copy") {
				$laboratorio_grid->LoadRowValues($laboratorio_grid->Recordset); // Load row values
				$laboratorio_grid->SetRecordKey($laboratorio_grid->RowOldKey, $laboratorio_grid->Recordset); // Set old record key
			} else {
				$laboratorio_grid->LoadDefaultValues(); // Load default values
				$laboratorio_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$laboratorio_grid->LoadRowValues($laboratorio_grid->Recordset); // Load row values
		}
		$laboratorio->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($laboratorio->CurrentAction == "gridadd") // Grid add
			$laboratorio->RowType = EW_ROWTYPE_ADD; // Render add
		if ($laboratorio->CurrentAction == "gridadd" && $laboratorio->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$laboratorio_grid->RestoreCurrentRowFormValues($laboratorio_grid->RowIndex); // Restore form values
		if ($laboratorio->CurrentAction == "gridedit") { // Grid edit
			if ($laboratorio->EventCancelled) {
				$laboratorio_grid->RestoreCurrentRowFormValues($laboratorio_grid->RowIndex); // Restore form values
			}
			if ($laboratorio_grid->RowAction == "insert")
				$laboratorio->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$laboratorio->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($laboratorio->CurrentAction == "gridedit" && ($laboratorio->RowType == EW_ROWTYPE_EDIT || $laboratorio->RowType == EW_ROWTYPE_ADD) && $laboratorio->EventCancelled) // Update failed
			$laboratorio_grid->RestoreCurrentRowFormValues($laboratorio_grid->RowIndex); // Restore form values
		if ($laboratorio->RowType == EW_ROWTYPE_EDIT) // Edit row
			$laboratorio_grid->EditRowCnt++;
		if ($laboratorio->CurrentAction == "F") // Confirm row
			$laboratorio_grid->RestoreCurrentRowFormValues($laboratorio_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$laboratorio->RowAttrs = array_merge($laboratorio->RowAttrs, array('data-rowindex'=>$laboratorio_grid->RowCnt, 'id'=>'r' . $laboratorio_grid->RowCnt . '_laboratorio', 'data-rowtype'=>$laboratorio->RowType));

		// Render row
		$laboratorio_grid->RenderRow();

		// Render list options
		$laboratorio_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($laboratorio_grid->RowAction <> "delete" && $laboratorio_grid->RowAction <> "insertdelete" && !($laboratorio_grid->RowAction == "insert" && $laboratorio->CurrentAction == "F" && $laboratorio_grid->EmptyRow())) {
?>
	<tr<?php echo $laboratorio->RowAttributes() ?>>
<?php

// Render list options (body, left)
$laboratorio_grid->ListOptions->Render("body", "left", $laboratorio_grid->RowCnt);
?>
	<?php if ($laboratorio->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $laboratorio->nombre->CellAttributes() ?>>
<?php if ($laboratorio->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_nombre" class="form-group laboratorio_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($laboratorio->nombre->PlaceHolder) ?>" value="<?php echo $laboratorio->nombre->EditValue ?>"<?php echo $laboratorio->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($laboratorio->nombre->OldValue) ?>">
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_nombre" class="form-group laboratorio_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($laboratorio->nombre->PlaceHolder) ?>" value="<?php echo $laboratorio->nombre->EditValue ?>"<?php echo $laboratorio->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $laboratorio->nombre->ViewAttributes() ?>>
<?php echo $laboratorio->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($laboratorio->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($laboratorio->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $laboratorio_grid->PageObjName . "_row_" . $laboratorio_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idlaboratorio" name="x<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" id="x<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" value="<?php echo ew_HtmlEncode($laboratorio->idlaboratorio->CurrentValue) ?>">
<input type="hidden" data-field="x_idlaboratorio" name="o<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" id="o<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" value="<?php echo ew_HtmlEncode($laboratorio->idlaboratorio->OldValue) ?>">
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_EDIT || $laboratorio->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idlaboratorio" name="x<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" id="x<?php echo $laboratorio_grid->RowIndex ?>_idlaboratorio" value="<?php echo ew_HtmlEncode($laboratorio->idlaboratorio->CurrentValue) ?>">
<?php } ?>
	<?php if ($laboratorio->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $laboratorio->idpais->CellAttributes() ?>>
<?php if ($laboratorio->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($laboratorio->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_idpais" class="form-group laboratorio_idpais">
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_idpais" class="form-group laboratorio_idpais">
<select data-field="x_idpais" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais"<?php echo $laboratorio->idpais->EditAttributes() ?>>
<?php
if (is_array($laboratorio->idpais->EditValue)) {
	$arwrk = $laboratorio->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $laboratorio->Lookup_Selecting($laboratorio->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->OldValue) ?>">
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($laboratorio->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_idpais" class="form-group laboratorio_idpais">
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_idpais" class="form-group laboratorio_idpais">
<select data-field="x_idpais" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais"<?php echo $laboratorio->idpais->EditAttributes() ?>>
<?php
if (is_array($laboratorio->idpais->EditValue)) {
	$arwrk = $laboratorio->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $laboratorio->Lookup_Selecting($laboratorio->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<?php echo $laboratorio->idpais->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->FormValue) ?>">
<input type="hidden" data-field="x_idpais" name="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($laboratorio->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $laboratorio->estado->CellAttributes() ?>>
<?php if ($laboratorio->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_estado" class="form-group laboratorio_estado">
<select data-field="x_estado" id="x<?php echo $laboratorio_grid->RowIndex ?>_estado" name="x<?php echo $laboratorio_grid->RowIndex ?>_estado"<?php echo $laboratorio->estado->EditAttributes() ?>>
<?php
if (is_array($laboratorio->estado->EditValue)) {
	$arwrk = $laboratorio->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->estado->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $laboratorio_grid->RowIndex ?>_estado" id="o<?php echo $laboratorio_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($laboratorio->estado->OldValue) ?>">
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $laboratorio_grid->RowCnt ?>_laboratorio_estado" class="form-group laboratorio_estado">
<select data-field="x_estado" id="x<?php echo $laboratorio_grid->RowIndex ?>_estado" name="x<?php echo $laboratorio_grid->RowIndex ?>_estado"<?php echo $laboratorio->estado->EditAttributes() ?>>
<?php
if (is_array($laboratorio->estado->EditValue)) {
	$arwrk = $laboratorio->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->estado->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($laboratorio->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $laboratorio->estado->ViewAttributes() ?>>
<?php echo $laboratorio->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $laboratorio_grid->RowIndex ?>_estado" id="x<?php echo $laboratorio_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($laboratorio->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $laboratorio_grid->RowIndex ?>_estado" id="o<?php echo $laboratorio_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($laboratorio->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$laboratorio_grid->ListOptions->Render("body", "right", $laboratorio_grid->RowCnt);
?>
	</tr>
<?php if ($laboratorio->RowType == EW_ROWTYPE_ADD || $laboratorio->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
flaboratoriogrid.UpdateOpts(<?php echo $laboratorio_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($laboratorio->CurrentAction <> "gridadd" || $laboratorio->CurrentMode == "copy")
		if (!$laboratorio_grid->Recordset->EOF) $laboratorio_grid->Recordset->MoveNext();
}
?>
<?php
	if ($laboratorio->CurrentMode == "add" || $laboratorio->CurrentMode == "copy" || $laboratorio->CurrentMode == "edit") {
		$laboratorio_grid->RowIndex = '$rowindex$';
		$laboratorio_grid->LoadDefaultValues();

		// Set row properties
		$laboratorio->ResetAttrs();
		$laboratorio->RowAttrs = array_merge($laboratorio->RowAttrs, array('data-rowindex'=>$laboratorio_grid->RowIndex, 'id'=>'r0_laboratorio', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($laboratorio->RowAttrs["class"], "ewTemplate");
		$laboratorio->RowType = EW_ROWTYPE_ADD;

		// Render row
		$laboratorio_grid->RenderRow();

		// Render list options
		$laboratorio_grid->RenderListOptions();
		$laboratorio_grid->StartRowCnt = 0;
?>
	<tr<?php echo $laboratorio->RowAttributes() ?>>
<?php

// Render list options (body, left)
$laboratorio_grid->ListOptions->Render("body", "left", $laboratorio_grid->RowIndex);
?>
	<?php if ($laboratorio->nombre->Visible) { // nombre ?>
		<td>
<?php if ($laboratorio->CurrentAction <> "F") { ?>
<span id="el$rowindex$_laboratorio_nombre" class="form-group laboratorio_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($laboratorio->nombre->PlaceHolder) ?>" value="<?php echo $laboratorio->nombre->EditValue ?>"<?php echo $laboratorio->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_laboratorio_nombre" class="form-group laboratorio_nombre">
<span<?php echo $laboratorio->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="x<?php echo $laboratorio_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($laboratorio->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" id="o<?php echo $laboratorio_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($laboratorio->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($laboratorio->idpais->Visible) { // idpais ?>
		<td>
<?php if ($laboratorio->CurrentAction <> "F") { ?>
<?php if ($laboratorio->idpais->getSessionValue() <> "") { ?>
<span id="el$rowindex$_laboratorio_idpais" class="form-group laboratorio_idpais">
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_laboratorio_idpais" class="form-group laboratorio_idpais">
<select data-field="x_idpais" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais"<?php echo $laboratorio->idpais->EditAttributes() ?>>
<?php
if (is_array($laboratorio->idpais->EditValue)) {
	$arwrk = $laboratorio->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $laboratorio->Lookup_Selecting($laboratorio->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="s_x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_laboratorio_idpais" class="form-group laboratorio_idpais">
<span<?php echo $laboratorio->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="x<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" id="o<?php echo $laboratorio_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($laboratorio->idpais->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($laboratorio->estado->Visible) { // estado ?>
		<td>
<?php if ($laboratorio->CurrentAction <> "F") { ?>
<span id="el$rowindex$_laboratorio_estado" class="form-group laboratorio_estado">
<select data-field="x_estado" id="x<?php echo $laboratorio_grid->RowIndex ?>_estado" name="x<?php echo $laboratorio_grid->RowIndex ?>_estado"<?php echo $laboratorio->estado->EditAttributes() ?>>
<?php
if (is_array($laboratorio->estado->EditValue)) {
	$arwrk = $laboratorio->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($laboratorio->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $laboratorio->estado->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_laboratorio_estado" class="form-group laboratorio_estado">
<span<?php echo $laboratorio->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $laboratorio->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $laboratorio_grid->RowIndex ?>_estado" id="x<?php echo $laboratorio_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($laboratorio->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $laboratorio_grid->RowIndex ?>_estado" id="o<?php echo $laboratorio_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($laboratorio->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$laboratorio_grid->ListOptions->Render("body", "right", $laboratorio_grid->RowCnt);
?>
<script type="text/javascript">
flaboratoriogrid.UpdateOpts(<?php echo $laboratorio_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($laboratorio->CurrentMode == "add" || $laboratorio->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $laboratorio_grid->FormKeyCountName ?>" id="<?php echo $laboratorio_grid->FormKeyCountName ?>" value="<?php echo $laboratorio_grid->KeyCount ?>">
<?php echo $laboratorio_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($laboratorio->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $laboratorio_grid->FormKeyCountName ?>" id="<?php echo $laboratorio_grid->FormKeyCountName ?>" value="<?php echo $laboratorio_grid->KeyCount ?>">
<?php echo $laboratorio_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($laboratorio->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="flaboratoriogrid">
</div>
<?php

// Close recordset
if ($laboratorio_grid->Recordset)
	$laboratorio_grid->Recordset->Close();
?>
<?php if ($laboratorio_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($laboratorio_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($laboratorio_grid->TotalRecs == 0 && $laboratorio->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($laboratorio_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($laboratorio->Export == "") { ?>
<script type="text/javascript">
flaboratoriogrid.Init();
</script>
<?php } ?>
<?php
$laboratorio_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$laboratorio_grid->Page_Terminate();
?>
