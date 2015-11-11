<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($boleta_deposito_grid)) $boleta_deposito_grid = new cboleta_deposito_grid();

// Page init
$boleta_deposito_grid->Page_Init();

// Page main
$boleta_deposito_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$boleta_deposito_grid->Page_Render();
?>
<?php if ($boleta_deposito->Export == "") { ?>
<script type="text/javascript">

// Page object
var boleta_deposito_grid = new ew_Page("boleta_deposito_grid");
boleta_deposito_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = boleta_deposito_grid.PageID; // For backward compatibility

// Form object
var fboleta_depositogrid = new ew_Form("fboleta_depositogrid");
fboleta_depositogrid.FormKeyCountName = '<?php echo $boleta_deposito_grid->FormKeyCountName ?>';

// Validate form
fboleta_depositogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->idbanco->FldCaption(), $boleta_deposito->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->idcuenta->FldCaption(), $boleta_deposito->idcuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->monto->FldCaption(), $boleta_deposito->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->monto->FldErrMsg()) ?>");

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
fboleta_depositogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idbanco", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fboleta_depositogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboleta_depositogrid.ValidateRequired = true;
<?php } else { ?>
fboleta_depositogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fboleta_depositogrid.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fboleta_depositogrid.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":["x_idbanco"],"FilterFields":["x_idbanco"],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($boleta_deposito->CurrentAction == "gridadd") {
	if ($boleta_deposito->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$boleta_deposito_grid->TotalRecs = $boleta_deposito->SelectRecordCount();
			$boleta_deposito_grid->Recordset = $boleta_deposito_grid->LoadRecordset($boleta_deposito_grid->StartRec-1, $boleta_deposito_grid->DisplayRecs);
		} else {
			if ($boleta_deposito_grid->Recordset = $boleta_deposito_grid->LoadRecordset())
				$boleta_deposito_grid->TotalRecs = $boleta_deposito_grid->Recordset->RecordCount();
		}
		$boleta_deposito_grid->StartRec = 1;
		$boleta_deposito_grid->DisplayRecs = $boleta_deposito_grid->TotalRecs;
	} else {
		$boleta_deposito->CurrentFilter = "0=1";
		$boleta_deposito_grid->StartRec = 1;
		$boleta_deposito_grid->DisplayRecs = $boleta_deposito->GridAddRowCount;
	}
	$boleta_deposito_grid->TotalRecs = $boleta_deposito_grid->DisplayRecs;
	$boleta_deposito_grid->StopRec = $boleta_deposito_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$boleta_deposito_grid->TotalRecs = $boleta_deposito->SelectRecordCount();
	} else {
		if ($boleta_deposito_grid->Recordset = $boleta_deposito_grid->LoadRecordset())
			$boleta_deposito_grid->TotalRecs = $boleta_deposito_grid->Recordset->RecordCount();
	}
	$boleta_deposito_grid->StartRec = 1;
	$boleta_deposito_grid->DisplayRecs = $boleta_deposito_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$boleta_deposito_grid->Recordset = $boleta_deposito_grid->LoadRecordset($boleta_deposito_grid->StartRec-1, $boleta_deposito_grid->DisplayRecs);

	// Set no record found message
	if ($boleta_deposito->CurrentAction == "" && $boleta_deposito_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$boleta_deposito_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($boleta_deposito_grid->SearchWhere == "0=101")
			$boleta_deposito_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$boleta_deposito_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$boleta_deposito_grid->RenderOtherOptions();
?>
<?php $boleta_deposito_grid->ShowPageHeader(); ?>
<?php
$boleta_deposito_grid->ShowMessage();
?>
<?php if ($boleta_deposito_grid->TotalRecs > 0 || $boleta_deposito->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fboleta_depositogrid" class="ewForm form-inline">
<div id="gmp_boleta_deposito" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_boleta_depositogrid" class="table ewTable">
<?php echo $boleta_deposito->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$boleta_deposito_grid->RenderListOptions();

// Render list options (header, left)
$boleta_deposito_grid->ListOptions->Render("header", "left");
?>
<?php if ($boleta_deposito->idbanco->Visible) { // idbanco ?>
	<?php if ($boleta_deposito->SortUrl($boleta_deposito->idbanco) == "") { ?>
		<th data-name="idbanco"><div id="elh_boleta_deposito_idbanco" class="boleta_deposito_idbanco"><div class="ewTableHeaderCaption"><?php echo $boleta_deposito->idbanco->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco"><div><div id="elh_boleta_deposito_idbanco" class="boleta_deposito_idbanco">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $boleta_deposito->idbanco->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($boleta_deposito->idbanco->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($boleta_deposito->idbanco->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($boleta_deposito->idcuenta->Visible) { // idcuenta ?>
	<?php if ($boleta_deposito->SortUrl($boleta_deposito->idcuenta) == "") { ?>
		<th data-name="idcuenta"><div id="elh_boleta_deposito_idcuenta" class="boleta_deposito_idcuenta"><div class="ewTableHeaderCaption"><?php echo $boleta_deposito->idcuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta"><div><div id="elh_boleta_deposito_idcuenta" class="boleta_deposito_idcuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $boleta_deposito->idcuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($boleta_deposito->idcuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($boleta_deposito->idcuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($boleta_deposito->numero->Visible) { // numero ?>
	<?php if ($boleta_deposito->SortUrl($boleta_deposito->numero) == "") { ?>
		<th data-name="numero"><div id="elh_boleta_deposito_numero" class="boleta_deposito_numero"><div class="ewTableHeaderCaption"><?php echo $boleta_deposito->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_boleta_deposito_numero" class="boleta_deposito_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $boleta_deposito->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($boleta_deposito->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($boleta_deposito->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($boleta_deposito->fecha->Visible) { // fecha ?>
	<?php if ($boleta_deposito->SortUrl($boleta_deposito->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_boleta_deposito_fecha" class="boleta_deposito_fecha"><div class="ewTableHeaderCaption"><?php echo $boleta_deposito->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_boleta_deposito_fecha" class="boleta_deposito_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $boleta_deposito->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($boleta_deposito->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($boleta_deposito->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($boleta_deposito->monto->Visible) { // monto ?>
	<?php if ($boleta_deposito->SortUrl($boleta_deposito->monto) == "") { ?>
		<th data-name="monto"><div id="elh_boleta_deposito_monto" class="boleta_deposito_monto"><div class="ewTableHeaderCaption"><?php echo $boleta_deposito->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_boleta_deposito_monto" class="boleta_deposito_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $boleta_deposito->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($boleta_deposito->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($boleta_deposito->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$boleta_deposito_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$boleta_deposito_grid->StartRec = 1;
$boleta_deposito_grid->StopRec = $boleta_deposito_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($boleta_deposito_grid->FormKeyCountName) && ($boleta_deposito->CurrentAction == "gridadd" || $boleta_deposito->CurrentAction == "gridedit" || $boleta_deposito->CurrentAction == "F")) {
		$boleta_deposito_grid->KeyCount = $objForm->GetValue($boleta_deposito_grid->FormKeyCountName);
		$boleta_deposito_grid->StopRec = $boleta_deposito_grid->StartRec + $boleta_deposito_grid->KeyCount - 1;
	}
}
$boleta_deposito_grid->RecCnt = $boleta_deposito_grid->StartRec - 1;
if ($boleta_deposito_grid->Recordset && !$boleta_deposito_grid->Recordset->EOF) {
	$boleta_deposito_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $boleta_deposito_grid->StartRec > 1)
		$boleta_deposito_grid->Recordset->Move($boleta_deposito_grid->StartRec - 1);
} elseif (!$boleta_deposito->AllowAddDeleteRow && $boleta_deposito_grid->StopRec == 0) {
	$boleta_deposito_grid->StopRec = $boleta_deposito->GridAddRowCount;
}

// Initialize aggregate
$boleta_deposito->RowType = EW_ROWTYPE_AGGREGATEINIT;
$boleta_deposito->ResetAttrs();
$boleta_deposito_grid->RenderRow();
if ($boleta_deposito->CurrentAction == "gridadd")
	$boleta_deposito_grid->RowIndex = 0;
if ($boleta_deposito->CurrentAction == "gridedit")
	$boleta_deposito_grid->RowIndex = 0;
while ($boleta_deposito_grid->RecCnt < $boleta_deposito_grid->StopRec) {
	$boleta_deposito_grid->RecCnt++;
	if (intval($boleta_deposito_grid->RecCnt) >= intval($boleta_deposito_grid->StartRec)) {
		$boleta_deposito_grid->RowCnt++;
		if ($boleta_deposito->CurrentAction == "gridadd" || $boleta_deposito->CurrentAction == "gridedit" || $boleta_deposito->CurrentAction == "F") {
			$boleta_deposito_grid->RowIndex++;
			$objForm->Index = $boleta_deposito_grid->RowIndex;
			if ($objForm->HasValue($boleta_deposito_grid->FormActionName))
				$boleta_deposito_grid->RowAction = strval($objForm->GetValue($boleta_deposito_grid->FormActionName));
			elseif ($boleta_deposito->CurrentAction == "gridadd")
				$boleta_deposito_grid->RowAction = "insert";
			else
				$boleta_deposito_grid->RowAction = "";
		}

		// Set up key count
		$boleta_deposito_grid->KeyCount = $boleta_deposito_grid->RowIndex;

		// Init row class and style
		$boleta_deposito->ResetAttrs();
		$boleta_deposito->CssClass = "";
		if ($boleta_deposito->CurrentAction == "gridadd") {
			if ($boleta_deposito->CurrentMode == "copy") {
				$boleta_deposito_grid->LoadRowValues($boleta_deposito_grid->Recordset); // Load row values
				$boleta_deposito_grid->SetRecordKey($boleta_deposito_grid->RowOldKey, $boleta_deposito_grid->Recordset); // Set old record key
			} else {
				$boleta_deposito_grid->LoadDefaultValues(); // Load default values
				$boleta_deposito_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$boleta_deposito_grid->LoadRowValues($boleta_deposito_grid->Recordset); // Load row values
		}
		$boleta_deposito->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($boleta_deposito->CurrentAction == "gridadd") // Grid add
			$boleta_deposito->RowType = EW_ROWTYPE_ADD; // Render add
		if ($boleta_deposito->CurrentAction == "gridadd" && $boleta_deposito->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$boleta_deposito_grid->RestoreCurrentRowFormValues($boleta_deposito_grid->RowIndex); // Restore form values
		if ($boleta_deposito->CurrentAction == "gridedit") { // Grid edit
			if ($boleta_deposito->EventCancelled) {
				$boleta_deposito_grid->RestoreCurrentRowFormValues($boleta_deposito_grid->RowIndex); // Restore form values
			}
			if ($boleta_deposito_grid->RowAction == "insert")
				$boleta_deposito->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$boleta_deposito->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($boleta_deposito->CurrentAction == "gridedit" && ($boleta_deposito->RowType == EW_ROWTYPE_EDIT || $boleta_deposito->RowType == EW_ROWTYPE_ADD) && $boleta_deposito->EventCancelled) // Update failed
			$boleta_deposito_grid->RestoreCurrentRowFormValues($boleta_deposito_grid->RowIndex); // Restore form values
		if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) // Edit row
			$boleta_deposito_grid->EditRowCnt++;
		if ($boleta_deposito->CurrentAction == "F") // Confirm row
			$boleta_deposito_grid->RestoreCurrentRowFormValues($boleta_deposito_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$boleta_deposito->RowAttrs = array_merge($boleta_deposito->RowAttrs, array('data-rowindex'=>$boleta_deposito_grid->RowCnt, 'id'=>'r' . $boleta_deposito_grid->RowCnt . '_boleta_deposito', 'data-rowtype'=>$boleta_deposito->RowType));

		// Render row
		$boleta_deposito_grid->RenderRow();

		// Render list options
		$boleta_deposito_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($boleta_deposito_grid->RowAction <> "delete" && $boleta_deposito_grid->RowAction <> "insertdelete" && !($boleta_deposito_grid->RowAction == "insert" && $boleta_deposito->CurrentAction == "F" && $boleta_deposito_grid->EmptyRow())) {
?>
	<tr<?php echo $boleta_deposito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$boleta_deposito_grid->ListOptions->Render("body", "left", $boleta_deposito_grid->RowCnt);
?>
	<?php if ($boleta_deposito->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco"<?php echo $boleta_deposito->idbanco->CellAttributes() ?>>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idbanco" class="form-group boleta_deposito_idbanco">
<?php $boleta_deposito->idbanco->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $boleta_deposito_grid->RowIndex . "_idcuenta']); " . @$boleta_deposito->idbanco->EditAttrs["onchange"]; ?>
<select data-field="x_idbanco" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco"<?php echo $boleta_deposito->idbanco->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idbanco->EditValue)) {
	$arwrk = $boleta_deposito->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($boleta_deposito->idbanco->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idbanco" class="form-group boleta_deposito_idbanco">
<?php $boleta_deposito->idbanco->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $boleta_deposito_grid->RowIndex . "_idcuenta']); " . @$boleta_deposito->idbanco->EditAttrs["onchange"]; ?>
<select data-field="x_idbanco" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco"<?php echo $boleta_deposito->idbanco->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idbanco->EditValue)) {
	$arwrk = $boleta_deposito->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $boleta_deposito->idbanco->ViewAttributes() ?>>
<?php echo $boleta_deposito->idbanco->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($boleta_deposito->idbanco->FormValue) ?>">
<input type="hidden" data-field="x_idbanco" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($boleta_deposito->idbanco->OldValue) ?>">
<?php } ?>
<a id="<?php echo $boleta_deposito_grid->PageObjName . "_row_" . $boleta_deposito_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idboleta_deposito" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" value="<?php echo ew_HtmlEncode($boleta_deposito->idboleta_deposito->CurrentValue) ?>">
<input type="hidden" data-field="x_idboleta_deposito" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" value="<?php echo ew_HtmlEncode($boleta_deposito->idboleta_deposito->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT || $boleta_deposito->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idboleta_deposito" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idboleta_deposito" value="<?php echo ew_HtmlEncode($boleta_deposito->idboleta_deposito->CurrentValue) ?>">
<?php } ?>
	<?php if ($boleta_deposito->idcuenta->Visible) { // idcuenta ?>
		<td data-name="idcuenta"<?php echo $boleta_deposito->idcuenta->CellAttributes() ?>>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($boleta_deposito->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta"<?php echo $boleta_deposito->idcuenta->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idcuenta->EditValue)) {
	$arwrk = $boleta_deposito->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$boleta_deposito->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "{filter}";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`idbanco` IN ({filter_value})"); ?>&amp;t1=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($boleta_deposito->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta"<?php echo $boleta_deposito->idcuenta->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idcuenta->EditValue)) {
	$arwrk = $boleta_deposito->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$boleta_deposito->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "{filter}";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`idbanco` IN ({filter_value})"); ?>&amp;t1=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<?php echo $boleta_deposito->idcuenta->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->FormValue) ?>">
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($boleta_deposito->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $boleta_deposito->numero->CellAttributes() ?>>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_numero" class="form-group boleta_deposito_numero">
<input type="text" data-field="x_numero" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->numero->PlaceHolder) ?>" value="<?php echo $boleta_deposito->numero->EditValue ?>"<?php echo $boleta_deposito->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_numero" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($boleta_deposito->numero->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_numero" class="form-group boleta_deposito_numero">
<input type="text" data-field="x_numero" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->numero->PlaceHolder) ?>" value="<?php echo $boleta_deposito->numero->EditValue ?>"<?php echo $boleta_deposito->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $boleta_deposito->numero->ViewAttributes() ?>>
<?php echo $boleta_deposito->numero->ListViewValue() ?></span>
<input type="hidden" data-field="x_numero" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($boleta_deposito->numero->FormValue) ?>">
<input type="hidden" data-field="x_numero" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($boleta_deposito->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($boleta_deposito->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $boleta_deposito->fecha->CellAttributes() ?>>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_fecha" class="form-group boleta_deposito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->fecha->PlaceHolder) ?>" value="<?php echo $boleta_deposito->fecha->EditValue ?>"<?php echo $boleta_deposito->fecha->EditAttributes() ?>>
<?php if (!$boleta_deposito->fecha->ReadOnly && !$boleta_deposito->fecha->Disabled && @$boleta_deposito->fecha->EditAttrs["readonly"] == "" && @$boleta_deposito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fboleta_depositogrid", "x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($boleta_deposito->fecha->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_fecha" class="form-group boleta_deposito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->fecha->PlaceHolder) ?>" value="<?php echo $boleta_deposito->fecha->EditValue ?>"<?php echo $boleta_deposito->fecha->EditAttributes() ?>>
<?php if (!$boleta_deposito->fecha->ReadOnly && !$boleta_deposito->fecha->Disabled && @$boleta_deposito->fecha->EditAttrs["readonly"] == "" && @$boleta_deposito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fboleta_depositogrid", "x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $boleta_deposito->fecha->ViewAttributes() ?>>
<?php echo $boleta_deposito->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($boleta_deposito->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($boleta_deposito->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($boleta_deposito->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $boleta_deposito->monto->CellAttributes() ?>>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_monto" class="form-group boleta_deposito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->monto->PlaceHolder) ?>" value="<?php echo $boleta_deposito->monto->EditValue ?>"<?php echo $boleta_deposito->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($boleta_deposito->monto->OldValue) ?>">
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $boleta_deposito_grid->RowCnt ?>_boleta_deposito_monto" class="form-group boleta_deposito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->monto->PlaceHolder) ?>" value="<?php echo $boleta_deposito->monto->EditValue ?>"<?php echo $boleta_deposito->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $boleta_deposito->monto->ViewAttributes() ?>>
<?php echo $boleta_deposito->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($boleta_deposito->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($boleta_deposito->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$boleta_deposito_grid->ListOptions->Render("body", "right", $boleta_deposito_grid->RowCnt);
?>
	</tr>
<?php if ($boleta_deposito->RowType == EW_ROWTYPE_ADD || $boleta_deposito->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fboleta_depositogrid.UpdateOpts(<?php echo $boleta_deposito_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($boleta_deposito->CurrentAction <> "gridadd" || $boleta_deposito->CurrentMode == "copy")
		if (!$boleta_deposito_grid->Recordset->EOF) $boleta_deposito_grid->Recordset->MoveNext();
}
?>
<?php
	if ($boleta_deposito->CurrentMode == "add" || $boleta_deposito->CurrentMode == "copy" || $boleta_deposito->CurrentMode == "edit") {
		$boleta_deposito_grid->RowIndex = '$rowindex$';
		$boleta_deposito_grid->LoadDefaultValues();

		// Set row properties
		$boleta_deposito->ResetAttrs();
		$boleta_deposito->RowAttrs = array_merge($boleta_deposito->RowAttrs, array('data-rowindex'=>$boleta_deposito_grid->RowIndex, 'id'=>'r0_boleta_deposito', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($boleta_deposito->RowAttrs["class"], "ewTemplate");
		$boleta_deposito->RowType = EW_ROWTYPE_ADD;

		// Render row
		$boleta_deposito_grid->RenderRow();

		// Render list options
		$boleta_deposito_grid->RenderListOptions();
		$boleta_deposito_grid->StartRowCnt = 0;
?>
	<tr<?php echo $boleta_deposito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$boleta_deposito_grid->ListOptions->Render("body", "left", $boleta_deposito_grid->RowIndex);
?>
	<?php if ($boleta_deposito->idbanco->Visible) { // idbanco ?>
		<td>
<?php if ($boleta_deposito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_boleta_deposito_idbanco" class="form-group boleta_deposito_idbanco">
<?php $boleta_deposito->idbanco->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $boleta_deposito_grid->RowIndex . "_idcuenta']); " . @$boleta_deposito->idbanco->EditAttrs["onchange"]; ?>
<select data-field="x_idbanco" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco"<?php echo $boleta_deposito->idbanco->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idbanco->EditValue)) {
	$arwrk = $boleta_deposito->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_idbanco" class="form-group boleta_deposito_idbanco">
<span<?php echo $boleta_deposito->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($boleta_deposito->idbanco->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($boleta_deposito->idbanco->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($boleta_deposito->idcuenta->Visible) { // idcuenta ?>
		<td>
<?php if ($boleta_deposito->CurrentAction <> "F") { ?>
<?php if ($boleta_deposito->idcuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta"<?php echo $boleta_deposito->idcuenta->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idcuenta->EditValue)) {
	$arwrk = $boleta_deposito->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$boleta_deposito->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $boleta_deposito->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "{filter}";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $boleta_deposito->Lookup_Selecting($boleta_deposito->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`idbanco` IN ({filter_value})"); ?>&amp;t1=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_idcuenta" class="form-group boleta_deposito_idcuenta">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($boleta_deposito->numero->Visible) { // numero ?>
		<td>
<?php if ($boleta_deposito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_boleta_deposito_numero" class="form-group boleta_deposito_numero">
<input type="text" data-field="x_numero" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->numero->PlaceHolder) ?>" value="<?php echo $boleta_deposito->numero->EditValue ?>"<?php echo $boleta_deposito->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_numero" class="form-group boleta_deposito_numero">
<span<?php echo $boleta_deposito->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_numero" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($boleta_deposito->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_numero" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($boleta_deposito->numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($boleta_deposito->fecha->Visible) { // fecha ?>
		<td>
<?php if ($boleta_deposito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_boleta_deposito_fecha" class="form-group boleta_deposito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->fecha->PlaceHolder) ?>" value="<?php echo $boleta_deposito->fecha->EditValue ?>"<?php echo $boleta_deposito->fecha->EditAttributes() ?>>
<?php if (!$boleta_deposito->fecha->ReadOnly && !$boleta_deposito->fecha->Disabled && @$boleta_deposito->fecha->EditAttrs["readonly"] == "" && @$boleta_deposito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fboleta_depositogrid", "x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_fecha" class="form-group boleta_deposito_fecha">
<span<?php echo $boleta_deposito->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($boleta_deposito->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($boleta_deposito->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($boleta_deposito->monto->Visible) { // monto ?>
		<td>
<?php if ($boleta_deposito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_boleta_deposito_monto" class="form-group boleta_deposito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->monto->PlaceHolder) ?>" value="<?php echo $boleta_deposito->monto->EditValue ?>"<?php echo $boleta_deposito->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_boleta_deposito_monto" class="form-group boleta_deposito_monto">
<span<?php echo $boleta_deposito->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="x<?php echo $boleta_deposito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($boleta_deposito->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" id="o<?php echo $boleta_deposito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($boleta_deposito->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$boleta_deposito_grid->ListOptions->Render("body", "right", $boleta_deposito_grid->RowCnt);
?>
<script type="text/javascript">
fboleta_depositogrid.UpdateOpts(<?php echo $boleta_deposito_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($boleta_deposito->CurrentMode == "add" || $boleta_deposito->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $boleta_deposito_grid->FormKeyCountName ?>" id="<?php echo $boleta_deposito_grid->FormKeyCountName ?>" value="<?php echo $boleta_deposito_grid->KeyCount ?>">
<?php echo $boleta_deposito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($boleta_deposito->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $boleta_deposito_grid->FormKeyCountName ?>" id="<?php echo $boleta_deposito_grid->FormKeyCountName ?>" value="<?php echo $boleta_deposito_grid->KeyCount ?>">
<?php echo $boleta_deposito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($boleta_deposito->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fboleta_depositogrid">
</div>
<?php

// Close recordset
if ($boleta_deposito_grid->Recordset)
	$boleta_deposito_grid->Recordset->Close();
?>
<?php if ($boleta_deposito_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($boleta_deposito_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($boleta_deposito_grid->TotalRecs == 0 && $boleta_deposito->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($boleta_deposito_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($boleta_deposito->Export == "") { ?>
<script type="text/javascript">
fboleta_depositogrid.Init();
</script>
<?php } ?>
<?php
$boleta_deposito_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$boleta_deposito_grid->Page_Terminate();
?>
