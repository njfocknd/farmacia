<?php

// Create page object
if (!isset($moneda_grid)) $moneda_grid = new cmoneda_grid();

// Page init
$moneda_grid->Page_Init();

// Page main
$moneda_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$moneda_grid->Page_Render();
?>
<?php if ($moneda->Export == "") { ?>
<script type="text/javascript">

// Page object
var moneda_grid = new ew_Page("moneda_grid");
moneda_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = moneda_grid.PageID; // For backward compatibility

// Form object
var fmonedagrid = new ew_Form("fmonedagrid");
fmonedagrid.FormKeyCountName = '<?php echo $moneda_grid->FormKeyCountName ?>';

// Validate form
fmonedagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tasa_cambio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $moneda->tasa_cambio->FldCaption(), $moneda->tasa_cambio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tasa_cambio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($moneda->tasa_cambio->FldErrMsg()) ?>");

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
fmonedagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "simbolo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tasa_cambio", false)) return false;
	return true;
}

// Form_CustomValidate event
fmonedagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmonedagrid.ValidateRequired = true;
<?php } else { ?>
fmonedagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmonedagrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($moneda->CurrentAction == "gridadd") {
	if ($moneda->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$moneda_grid->TotalRecs = $moneda->SelectRecordCount();
			$moneda_grid->Recordset = $moneda_grid->LoadRecordset($moneda_grid->StartRec-1, $moneda_grid->DisplayRecs);
		} else {
			if ($moneda_grid->Recordset = $moneda_grid->LoadRecordset())
				$moneda_grid->TotalRecs = $moneda_grid->Recordset->RecordCount();
		}
		$moneda_grid->StartRec = 1;
		$moneda_grid->DisplayRecs = $moneda_grid->TotalRecs;
	} else {
		$moneda->CurrentFilter = "0=1";
		$moneda_grid->StartRec = 1;
		$moneda_grid->DisplayRecs = $moneda->GridAddRowCount;
	}
	$moneda_grid->TotalRecs = $moneda_grid->DisplayRecs;
	$moneda_grid->StopRec = $moneda_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$moneda_grid->TotalRecs = $moneda->SelectRecordCount();
	} else {
		if ($moneda_grid->Recordset = $moneda_grid->LoadRecordset())
			$moneda_grid->TotalRecs = $moneda_grid->Recordset->RecordCount();
	}
	$moneda_grid->StartRec = 1;
	$moneda_grid->DisplayRecs = $moneda_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$moneda_grid->Recordset = $moneda_grid->LoadRecordset($moneda_grid->StartRec-1, $moneda_grid->DisplayRecs);

	// Set no record found message
	if ($moneda->CurrentAction == "" && $moneda_grid->TotalRecs == 0) {
		if ($moneda_grid->SearchWhere == "0=101")
			$moneda_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$moneda_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$moneda_grid->RenderOtherOptions();
?>
<?php $moneda_grid->ShowPageHeader(); ?>
<?php
$moneda_grid->ShowMessage();
?>
<?php if ($moneda_grid->TotalRecs > 0 || $moneda->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fmonedagrid" class="ewForm form-inline">
<div id="gmp_moneda" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_monedagrid" class="table ewTable">
<?php echo $moneda->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$moneda_grid->RenderListOptions();

// Render list options (header, left)
$moneda_grid->ListOptions->Render("header", "left");
?>
<?php if ($moneda->nombre->Visible) { // nombre ?>
	<?php if ($moneda->SortUrl($moneda->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_moneda_nombre" class="moneda_nombre"><div class="ewTableHeaderCaption"><?php echo $moneda->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_moneda_nombre" class="moneda_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $moneda->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($moneda->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($moneda->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($moneda->simbolo->Visible) { // simbolo ?>
	<?php if ($moneda->SortUrl($moneda->simbolo) == "") { ?>
		<th data-name="simbolo"><div id="elh_moneda_simbolo" class="moneda_simbolo"><div class="ewTableHeaderCaption"><?php echo $moneda->simbolo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="simbolo"><div><div id="elh_moneda_simbolo" class="moneda_simbolo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $moneda->simbolo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($moneda->simbolo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($moneda->simbolo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($moneda->idpais->Visible) { // idpais ?>
	<?php if ($moneda->SortUrl($moneda->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_moneda_idpais" class="moneda_idpais"><div class="ewTableHeaderCaption"><?php echo $moneda->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_moneda_idpais" class="moneda_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $moneda->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($moneda->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($moneda->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($moneda->tasa_cambio->Visible) { // tasa_cambio ?>
	<?php if ($moneda->SortUrl($moneda->tasa_cambio) == "") { ?>
		<th data-name="tasa_cambio"><div id="elh_moneda_tasa_cambio" class="moneda_tasa_cambio"><div class="ewTableHeaderCaption"><?php echo $moneda->tasa_cambio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tasa_cambio"><div><div id="elh_moneda_tasa_cambio" class="moneda_tasa_cambio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $moneda->tasa_cambio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($moneda->tasa_cambio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($moneda->tasa_cambio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$moneda_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$moneda_grid->StartRec = 1;
$moneda_grid->StopRec = $moneda_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($moneda_grid->FormKeyCountName) && ($moneda->CurrentAction == "gridadd" || $moneda->CurrentAction == "gridedit" || $moneda->CurrentAction == "F")) {
		$moneda_grid->KeyCount = $objForm->GetValue($moneda_grid->FormKeyCountName);
		$moneda_grid->StopRec = $moneda_grid->StartRec + $moneda_grid->KeyCount - 1;
	}
}
$moneda_grid->RecCnt = $moneda_grid->StartRec - 1;
if ($moneda_grid->Recordset && !$moneda_grid->Recordset->EOF) {
	$moneda_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $moneda_grid->StartRec > 1)
		$moneda_grid->Recordset->Move($moneda_grid->StartRec - 1);
} elseif (!$moneda->AllowAddDeleteRow && $moneda_grid->StopRec == 0) {
	$moneda_grid->StopRec = $moneda->GridAddRowCount;
}

// Initialize aggregate
$moneda->RowType = EW_ROWTYPE_AGGREGATEINIT;
$moneda->ResetAttrs();
$moneda_grid->RenderRow();
if ($moneda->CurrentAction == "gridadd")
	$moneda_grid->RowIndex = 0;
if ($moneda->CurrentAction == "gridedit")
	$moneda_grid->RowIndex = 0;
while ($moneda_grid->RecCnt < $moneda_grid->StopRec) {
	$moneda_grid->RecCnt++;
	if (intval($moneda_grid->RecCnt) >= intval($moneda_grid->StartRec)) {
		$moneda_grid->RowCnt++;
		if ($moneda->CurrentAction == "gridadd" || $moneda->CurrentAction == "gridedit" || $moneda->CurrentAction == "F") {
			$moneda_grid->RowIndex++;
			$objForm->Index = $moneda_grid->RowIndex;
			if ($objForm->HasValue($moneda_grid->FormActionName))
				$moneda_grid->RowAction = strval($objForm->GetValue($moneda_grid->FormActionName));
			elseif ($moneda->CurrentAction == "gridadd")
				$moneda_grid->RowAction = "insert";
			else
				$moneda_grid->RowAction = "";
		}

		// Set up key count
		$moneda_grid->KeyCount = $moneda_grid->RowIndex;

		// Init row class and style
		$moneda->ResetAttrs();
		$moneda->CssClass = "";
		if ($moneda->CurrentAction == "gridadd") {
			if ($moneda->CurrentMode == "copy") {
				$moneda_grid->LoadRowValues($moneda_grid->Recordset); // Load row values
				$moneda_grid->SetRecordKey($moneda_grid->RowOldKey, $moneda_grid->Recordset); // Set old record key
			} else {
				$moneda_grid->LoadDefaultValues(); // Load default values
				$moneda_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$moneda_grid->LoadRowValues($moneda_grid->Recordset); // Load row values
		}
		$moneda->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($moneda->CurrentAction == "gridadd") // Grid add
			$moneda->RowType = EW_ROWTYPE_ADD; // Render add
		if ($moneda->CurrentAction == "gridadd" && $moneda->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$moneda_grid->RestoreCurrentRowFormValues($moneda_grid->RowIndex); // Restore form values
		if ($moneda->CurrentAction == "gridedit") { // Grid edit
			if ($moneda->EventCancelled) {
				$moneda_grid->RestoreCurrentRowFormValues($moneda_grid->RowIndex); // Restore form values
			}
			if ($moneda_grid->RowAction == "insert")
				$moneda->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$moneda->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($moneda->CurrentAction == "gridedit" && ($moneda->RowType == EW_ROWTYPE_EDIT || $moneda->RowType == EW_ROWTYPE_ADD) && $moneda->EventCancelled) // Update failed
			$moneda_grid->RestoreCurrentRowFormValues($moneda_grid->RowIndex); // Restore form values
		if ($moneda->RowType == EW_ROWTYPE_EDIT) // Edit row
			$moneda_grid->EditRowCnt++;
		if ($moneda->CurrentAction == "F") // Confirm row
			$moneda_grid->RestoreCurrentRowFormValues($moneda_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$moneda->RowAttrs = array_merge($moneda->RowAttrs, array('data-rowindex'=>$moneda_grid->RowCnt, 'id'=>'r' . $moneda_grid->RowCnt . '_moneda', 'data-rowtype'=>$moneda->RowType));

		// Render row
		$moneda_grid->RenderRow();

		// Render list options
		$moneda_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($moneda_grid->RowAction <> "delete" && $moneda_grid->RowAction <> "insertdelete" && !($moneda_grid->RowAction == "insert" && $moneda->CurrentAction == "F" && $moneda_grid->EmptyRow())) {
?>
	<tr<?php echo $moneda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$moneda_grid->ListOptions->Render("body", "left", $moneda_grid->RowCnt);
?>
	<?php if ($moneda->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $moneda->nombre->CellAttributes() ?>>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_nombre" class="form-group moneda_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $moneda_grid->RowIndex ?>_nombre" id="x<?php echo $moneda_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->nombre->PlaceHolder) ?>" value="<?php echo $moneda->nombre->EditValue ?>"<?php echo $moneda->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $moneda_grid->RowIndex ?>_nombre" id="o<?php echo $moneda_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($moneda->nombre->OldValue) ?>">
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_nombre" class="form-group moneda_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $moneda_grid->RowIndex ?>_nombre" id="x<?php echo $moneda_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->nombre->PlaceHolder) ?>" value="<?php echo $moneda->nombre->EditValue ?>"<?php echo $moneda->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $moneda->nombre->ViewAttributes() ?>>
<?php echo $moneda->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $moneda_grid->RowIndex ?>_nombre" id="x<?php echo $moneda_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($moneda->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $moneda_grid->RowIndex ?>_nombre" id="o<?php echo $moneda_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($moneda->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $moneda_grid->PageObjName . "_row_" . $moneda_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idmoneda" name="x<?php echo $moneda_grid->RowIndex ?>_idmoneda" id="x<?php echo $moneda_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($moneda->idmoneda->CurrentValue) ?>">
<input type="hidden" data-field="x_idmoneda" name="o<?php echo $moneda_grid->RowIndex ?>_idmoneda" id="o<?php echo $moneda_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($moneda->idmoneda->OldValue) ?>">
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_EDIT || $moneda->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idmoneda" name="x<?php echo $moneda_grid->RowIndex ?>_idmoneda" id="x<?php echo $moneda_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($moneda->idmoneda->CurrentValue) ?>">
<?php } ?>
	<?php if ($moneda->simbolo->Visible) { // simbolo ?>
		<td data-name="simbolo"<?php echo $moneda->simbolo->CellAttributes() ?>>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_simbolo" class="form-group moneda_simbolo">
<input type="text" data-field="x_simbolo" name="x<?php echo $moneda_grid->RowIndex ?>_simbolo" id="x<?php echo $moneda_grid->RowIndex ?>_simbolo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->simbolo->PlaceHolder) ?>" value="<?php echo $moneda->simbolo->EditValue ?>"<?php echo $moneda->simbolo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_simbolo" name="o<?php echo $moneda_grid->RowIndex ?>_simbolo" id="o<?php echo $moneda_grid->RowIndex ?>_simbolo" value="<?php echo ew_HtmlEncode($moneda->simbolo->OldValue) ?>">
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_simbolo" class="form-group moneda_simbolo">
<input type="text" data-field="x_simbolo" name="x<?php echo $moneda_grid->RowIndex ?>_simbolo" id="x<?php echo $moneda_grid->RowIndex ?>_simbolo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->simbolo->PlaceHolder) ?>" value="<?php echo $moneda->simbolo->EditValue ?>"<?php echo $moneda->simbolo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $moneda->simbolo->ViewAttributes() ?>>
<?php echo $moneda->simbolo->ListViewValue() ?></span>
<input type="hidden" data-field="x_simbolo" name="x<?php echo $moneda_grid->RowIndex ?>_simbolo" id="x<?php echo $moneda_grid->RowIndex ?>_simbolo" value="<?php echo ew_HtmlEncode($moneda->simbolo->FormValue) ?>">
<input type="hidden" data-field="x_simbolo" name="o<?php echo $moneda_grid->RowIndex ?>_simbolo" id="o<?php echo $moneda_grid->RowIndex ?>_simbolo" value="<?php echo ew_HtmlEncode($moneda->simbolo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($moneda->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $moneda->idpais->CellAttributes() ?>>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($moneda->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_idpais" class="form-group moneda_idpais">
<span<?php echo $moneda->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_idpais" class="form-group moneda_idpais">
<select data-field="x_idpais" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais"<?php echo $moneda->idpais->EditAttributes() ?>>
<?php
if (is_array($moneda->idpais->EditValue)) {
	$arwrk = $moneda->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($moneda->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $moneda->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $moneda->Lookup_Selecting($moneda->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" id="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $moneda_grid->RowIndex ?>_idpais" id="o<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->OldValue) ?>">
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($moneda->idpais->getSessionValue() <> "") { ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_idpais" class="form-group moneda_idpais">
<span<?php echo $moneda->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_idpais" class="form-group moneda_idpais">
<select data-field="x_idpais" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais"<?php echo $moneda->idpais->EditAttributes() ?>>
<?php
if (is_array($moneda->idpais->EditValue)) {
	$arwrk = $moneda->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($moneda->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $moneda->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $moneda->Lookup_Selecting($moneda->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" id="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $moneda->idpais->ViewAttributes() ?>>
<?php echo $moneda->idpais->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->FormValue) ?>">
<input type="hidden" data-field="x_idpais" name="o<?php echo $moneda_grid->RowIndex ?>_idpais" id="o<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($moneda->tasa_cambio->Visible) { // tasa_cambio ?>
		<td data-name="tasa_cambio"<?php echo $moneda->tasa_cambio->CellAttributes() ?>>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_tasa_cambio" class="form-group moneda_tasa_cambio">
<input type="text" data-field="x_tasa_cambio" name="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" size="30" placeholder="<?php echo ew_HtmlEncode($moneda->tasa_cambio->PlaceHolder) ?>" value="<?php echo $moneda->tasa_cambio->EditValue ?>"<?php echo $moneda->tasa_cambio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_tasa_cambio" name="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" value="<?php echo ew_HtmlEncode($moneda->tasa_cambio->OldValue) ?>">
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $moneda_grid->RowCnt ?>_moneda_tasa_cambio" class="form-group moneda_tasa_cambio">
<input type="text" data-field="x_tasa_cambio" name="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" size="30" placeholder="<?php echo ew_HtmlEncode($moneda->tasa_cambio->PlaceHolder) ?>" value="<?php echo $moneda->tasa_cambio->EditValue ?>"<?php echo $moneda->tasa_cambio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($moneda->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $moneda->tasa_cambio->ViewAttributes() ?>>
<?php echo $moneda->tasa_cambio->ListViewValue() ?></span>
<input type="hidden" data-field="x_tasa_cambio" name="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" value="<?php echo ew_HtmlEncode($moneda->tasa_cambio->FormValue) ?>">
<input type="hidden" data-field="x_tasa_cambio" name="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" value="<?php echo ew_HtmlEncode($moneda->tasa_cambio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$moneda_grid->ListOptions->Render("body", "right", $moneda_grid->RowCnt);
?>
	</tr>
<?php if ($moneda->RowType == EW_ROWTYPE_ADD || $moneda->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmonedagrid.UpdateOpts(<?php echo $moneda_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($moneda->CurrentAction <> "gridadd" || $moneda->CurrentMode == "copy")
		if (!$moneda_grid->Recordset->EOF) $moneda_grid->Recordset->MoveNext();
}
?>
<?php
	if ($moneda->CurrentMode == "add" || $moneda->CurrentMode == "copy" || $moneda->CurrentMode == "edit") {
		$moneda_grid->RowIndex = '$rowindex$';
		$moneda_grid->LoadDefaultValues();

		// Set row properties
		$moneda->ResetAttrs();
		$moneda->RowAttrs = array_merge($moneda->RowAttrs, array('data-rowindex'=>$moneda_grid->RowIndex, 'id'=>'r0_moneda', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($moneda->RowAttrs["class"], "ewTemplate");
		$moneda->RowType = EW_ROWTYPE_ADD;

		// Render row
		$moneda_grid->RenderRow();

		// Render list options
		$moneda_grid->RenderListOptions();
		$moneda_grid->StartRowCnt = 0;
?>
	<tr<?php echo $moneda->RowAttributes() ?>>
<?php

// Render list options (body, left)
$moneda_grid->ListOptions->Render("body", "left", $moneda_grid->RowIndex);
?>
	<?php if ($moneda->nombre->Visible) { // nombre ?>
		<td>
<?php if ($moneda->CurrentAction <> "F") { ?>
<span id="el$rowindex$_moneda_nombre" class="form-group moneda_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $moneda_grid->RowIndex ?>_nombre" id="x<?php echo $moneda_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->nombre->PlaceHolder) ?>" value="<?php echo $moneda->nombre->EditValue ?>"<?php echo $moneda->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_moneda_nombre" class="form-group moneda_nombre">
<span<?php echo $moneda->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $moneda_grid->RowIndex ?>_nombre" id="x<?php echo $moneda_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($moneda->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $moneda_grid->RowIndex ?>_nombre" id="o<?php echo $moneda_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($moneda->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($moneda->simbolo->Visible) { // simbolo ?>
		<td>
<?php if ($moneda->CurrentAction <> "F") { ?>
<span id="el$rowindex$_moneda_simbolo" class="form-group moneda_simbolo">
<input type="text" data-field="x_simbolo" name="x<?php echo $moneda_grid->RowIndex ?>_simbolo" id="x<?php echo $moneda_grid->RowIndex ?>_simbolo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($moneda->simbolo->PlaceHolder) ?>" value="<?php echo $moneda->simbolo->EditValue ?>"<?php echo $moneda->simbolo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_moneda_simbolo" class="form-group moneda_simbolo">
<span<?php echo $moneda->simbolo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->simbolo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_simbolo" name="x<?php echo $moneda_grid->RowIndex ?>_simbolo" id="x<?php echo $moneda_grid->RowIndex ?>_simbolo" value="<?php echo ew_HtmlEncode($moneda->simbolo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_simbolo" name="o<?php echo $moneda_grid->RowIndex ?>_simbolo" id="o<?php echo $moneda_grid->RowIndex ?>_simbolo" value="<?php echo ew_HtmlEncode($moneda->simbolo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($moneda->idpais->Visible) { // idpais ?>
		<td>
<?php if ($moneda->CurrentAction <> "F") { ?>
<?php if ($moneda->idpais->getSessionValue() <> "") { ?>
<span id="el$rowindex$_moneda_idpais" class="form-group moneda_idpais">
<span<?php echo $moneda->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_moneda_idpais" class="form-group moneda_idpais">
<select data-field="x_idpais" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais"<?php echo $moneda->idpais->EditAttributes() ?>>
<?php
if (is_array($moneda->idpais->EditValue)) {
	$arwrk = $moneda->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($moneda->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $moneda->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $moneda->Lookup_Selecting($moneda->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" id="s_x<?php echo $moneda_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_moneda_idpais" class="form-group moneda_idpais">
<span<?php echo $moneda->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $moneda_grid->RowIndex ?>_idpais" id="x<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $moneda_grid->RowIndex ?>_idpais" id="o<?php echo $moneda_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($moneda->idpais->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($moneda->tasa_cambio->Visible) { // tasa_cambio ?>
		<td>
<?php if ($moneda->CurrentAction <> "F") { ?>
<span id="el$rowindex$_moneda_tasa_cambio" class="form-group moneda_tasa_cambio">
<input type="text" data-field="x_tasa_cambio" name="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" size="30" placeholder="<?php echo ew_HtmlEncode($moneda->tasa_cambio->PlaceHolder) ?>" value="<?php echo $moneda->tasa_cambio->EditValue ?>"<?php echo $moneda->tasa_cambio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_moneda_tasa_cambio" class="form-group moneda_tasa_cambio">
<span<?php echo $moneda->tasa_cambio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $moneda->tasa_cambio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_tasa_cambio" name="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="x<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" value="<?php echo ew_HtmlEncode($moneda->tasa_cambio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_tasa_cambio" name="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" id="o<?php echo $moneda_grid->RowIndex ?>_tasa_cambio" value="<?php echo ew_HtmlEncode($moneda->tasa_cambio->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$moneda_grid->ListOptions->Render("body", "right", $moneda_grid->RowCnt);
?>
<script type="text/javascript">
fmonedagrid.UpdateOpts(<?php echo $moneda_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($moneda->CurrentMode == "add" || $moneda->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $moneda_grid->FormKeyCountName ?>" id="<?php echo $moneda_grid->FormKeyCountName ?>" value="<?php echo $moneda_grid->KeyCount ?>">
<?php echo $moneda_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($moneda->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $moneda_grid->FormKeyCountName ?>" id="<?php echo $moneda_grid->FormKeyCountName ?>" value="<?php echo $moneda_grid->KeyCount ?>">
<?php echo $moneda_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($moneda->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmonedagrid">
</div>
<?php

// Close recordset
if ($moneda_grid->Recordset)
	$moneda_grid->Recordset->Close();
?>
<?php if ($moneda_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($moneda_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($moneda_grid->TotalRecs == 0 && $moneda->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($moneda_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($moneda->Export == "") { ?>
<script type="text/javascript">
fmonedagrid.Init();
</script>
<?php } ?>
<?php
$moneda_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$moneda_grid->Page_Terminate();
?>
