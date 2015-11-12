<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($periodo_contable_grid)) $periodo_contable_grid = new cperiodo_contable_grid();

// Page init
$periodo_contable_grid->Page_Init();

// Page main
$periodo_contable_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$periodo_contable_grid->Page_Render();
?>
<?php if ($periodo_contable->Export == "") { ?>
<script type="text/javascript">

// Page object
var periodo_contable_grid = new ew_Page("periodo_contable_grid");
periodo_contable_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = periodo_contable_grid.PageID; // For backward compatibility

// Form object
var fperiodo_contablegrid = new ew_Form("fperiodo_contablegrid");
fperiodo_contablegrid.FormKeyCountName = '<?php echo $periodo_contable_grid->FormKeyCountName ?>';

// Validate form
fperiodo_contablegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $periodo_contable->idempresa->FldCaption(), $periodo_contable->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_mes");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $periodo_contable->mes->FldCaption(), $periodo_contable->mes->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_anio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $periodo_contable->anio->FldCaption(), $periodo_contable->anio->ReqErrMsg)) ?>");

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
fperiodo_contablegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mes", false)) return false;
	if (ew_ValueChanged(fobj, infix, "anio", false)) return false;
	return true;
}

// Form_CustomValidate event
fperiodo_contablegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fperiodo_contablegrid.ValidateRequired = true;
<?php } else { ?>
fperiodo_contablegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fperiodo_contablegrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($periodo_contable->CurrentAction == "gridadd") {
	if ($periodo_contable->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$periodo_contable_grid->TotalRecs = $periodo_contable->SelectRecordCount();
			$periodo_contable_grid->Recordset = $periodo_contable_grid->LoadRecordset($periodo_contable_grid->StartRec-1, $periodo_contable_grid->DisplayRecs);
		} else {
			if ($periodo_contable_grid->Recordset = $periodo_contable_grid->LoadRecordset())
				$periodo_contable_grid->TotalRecs = $periodo_contable_grid->Recordset->RecordCount();
		}
		$periodo_contable_grid->StartRec = 1;
		$periodo_contable_grid->DisplayRecs = $periodo_contable_grid->TotalRecs;
	} else {
		$periodo_contable->CurrentFilter = "0=1";
		$periodo_contable_grid->StartRec = 1;
		$periodo_contable_grid->DisplayRecs = $periodo_contable->GridAddRowCount;
	}
	$periodo_contable_grid->TotalRecs = $periodo_contable_grid->DisplayRecs;
	$periodo_contable_grid->StopRec = $periodo_contable_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$periodo_contable_grid->TotalRecs = $periodo_contable->SelectRecordCount();
	} else {
		if ($periodo_contable_grid->Recordset = $periodo_contable_grid->LoadRecordset())
			$periodo_contable_grid->TotalRecs = $periodo_contable_grid->Recordset->RecordCount();
	}
	$periodo_contable_grid->StartRec = 1;
	$periodo_contable_grid->DisplayRecs = $periodo_contable_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$periodo_contable_grid->Recordset = $periodo_contable_grid->LoadRecordset($periodo_contable_grid->StartRec-1, $periodo_contable_grid->DisplayRecs);

	// Set no record found message
	if ($periodo_contable->CurrentAction == "" && $periodo_contable_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$periodo_contable_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($periodo_contable_grid->SearchWhere == "0=101")
			$periodo_contable_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$periodo_contable_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$periodo_contable_grid->RenderOtherOptions();
?>
<?php $periodo_contable_grid->ShowPageHeader(); ?>
<?php
$periodo_contable_grid->ShowMessage();
?>
<?php if ($periodo_contable_grid->TotalRecs > 0 || $periodo_contable->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fperiodo_contablegrid" class="ewForm form-inline">
<div id="gmp_periodo_contable" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_periodo_contablegrid" class="table ewTable">
<?php echo $periodo_contable->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$periodo_contable_grid->RenderListOptions();

// Render list options (header, left)
$periodo_contable_grid->ListOptions->Render("header", "left");
?>
<?php if ($periodo_contable->idempresa->Visible) { // idempresa ?>
	<?php if ($periodo_contable->SortUrl($periodo_contable->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_periodo_contable_idempresa" class="periodo_contable_idempresa"><div class="ewTableHeaderCaption"><?php echo $periodo_contable->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_periodo_contable_idempresa" class="periodo_contable_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $periodo_contable->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($periodo_contable->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($periodo_contable->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($periodo_contable->mes->Visible) { // mes ?>
	<?php if ($periodo_contable->SortUrl($periodo_contable->mes) == "") { ?>
		<th data-name="mes"><div id="elh_periodo_contable_mes" class="periodo_contable_mes"><div class="ewTableHeaderCaption"><?php echo $periodo_contable->mes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mes"><div><div id="elh_periodo_contable_mes" class="periodo_contable_mes">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $periodo_contable->mes->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($periodo_contable->mes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($periodo_contable->mes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($periodo_contable->anio->Visible) { // anio ?>
	<?php if ($periodo_contable->SortUrl($periodo_contable->anio) == "") { ?>
		<th data-name="anio"><div id="elh_periodo_contable_anio" class="periodo_contable_anio"><div class="ewTableHeaderCaption"><?php echo $periodo_contable->anio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="anio"><div><div id="elh_periodo_contable_anio" class="periodo_contable_anio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $periodo_contable->anio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($periodo_contable->anio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($periodo_contable->anio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$periodo_contable_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$periodo_contable_grid->StartRec = 1;
$periodo_contable_grid->StopRec = $periodo_contable_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($periodo_contable_grid->FormKeyCountName) && ($periodo_contable->CurrentAction == "gridadd" || $periodo_contable->CurrentAction == "gridedit" || $periodo_contable->CurrentAction == "F")) {
		$periodo_contable_grid->KeyCount = $objForm->GetValue($periodo_contable_grid->FormKeyCountName);
		$periodo_contable_grid->StopRec = $periodo_contable_grid->StartRec + $periodo_contable_grid->KeyCount - 1;
	}
}
$periodo_contable_grid->RecCnt = $periodo_contable_grid->StartRec - 1;
if ($periodo_contable_grid->Recordset && !$periodo_contable_grid->Recordset->EOF) {
	$periodo_contable_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $periodo_contable_grid->StartRec > 1)
		$periodo_contable_grid->Recordset->Move($periodo_contable_grid->StartRec - 1);
} elseif (!$periodo_contable->AllowAddDeleteRow && $periodo_contable_grid->StopRec == 0) {
	$periodo_contable_grid->StopRec = $periodo_contable->GridAddRowCount;
}

// Initialize aggregate
$periodo_contable->RowType = EW_ROWTYPE_AGGREGATEINIT;
$periodo_contable->ResetAttrs();
$periodo_contable_grid->RenderRow();
if ($periodo_contable->CurrentAction == "gridadd")
	$periodo_contable_grid->RowIndex = 0;
if ($periodo_contable->CurrentAction == "gridedit")
	$periodo_contable_grid->RowIndex = 0;
while ($periodo_contable_grid->RecCnt < $periodo_contable_grid->StopRec) {
	$periodo_contable_grid->RecCnt++;
	if (intval($periodo_contable_grid->RecCnt) >= intval($periodo_contable_grid->StartRec)) {
		$periodo_contable_grid->RowCnt++;
		if ($periodo_contable->CurrentAction == "gridadd" || $periodo_contable->CurrentAction == "gridedit" || $periodo_contable->CurrentAction == "F") {
			$periodo_contable_grid->RowIndex++;
			$objForm->Index = $periodo_contable_grid->RowIndex;
			if ($objForm->HasValue($periodo_contable_grid->FormActionName))
				$periodo_contable_grid->RowAction = strval($objForm->GetValue($periodo_contable_grid->FormActionName));
			elseif ($periodo_contable->CurrentAction == "gridadd")
				$periodo_contable_grid->RowAction = "insert";
			else
				$periodo_contable_grid->RowAction = "";
		}

		// Set up key count
		$periodo_contable_grid->KeyCount = $periodo_contable_grid->RowIndex;

		// Init row class and style
		$periodo_contable->ResetAttrs();
		$periodo_contable->CssClass = "";
		if ($periodo_contable->CurrentAction == "gridadd") {
			if ($periodo_contable->CurrentMode == "copy") {
				$periodo_contable_grid->LoadRowValues($periodo_contable_grid->Recordset); // Load row values
				$periodo_contable_grid->SetRecordKey($periodo_contable_grid->RowOldKey, $periodo_contable_grid->Recordset); // Set old record key
			} else {
				$periodo_contable_grid->LoadDefaultValues(); // Load default values
				$periodo_contable_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$periodo_contable_grid->LoadRowValues($periodo_contable_grid->Recordset); // Load row values
		}
		$periodo_contable->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($periodo_contable->CurrentAction == "gridadd") // Grid add
			$periodo_contable->RowType = EW_ROWTYPE_ADD; // Render add
		if ($periodo_contable->CurrentAction == "gridadd" && $periodo_contable->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$periodo_contable_grid->RestoreCurrentRowFormValues($periodo_contable_grid->RowIndex); // Restore form values
		if ($periodo_contable->CurrentAction == "gridedit") { // Grid edit
			if ($periodo_contable->EventCancelled) {
				$periodo_contable_grid->RestoreCurrentRowFormValues($periodo_contable_grid->RowIndex); // Restore form values
			}
			if ($periodo_contable_grid->RowAction == "insert")
				$periodo_contable->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$periodo_contable->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($periodo_contable->CurrentAction == "gridedit" && ($periodo_contable->RowType == EW_ROWTYPE_EDIT || $periodo_contable->RowType == EW_ROWTYPE_ADD) && $periodo_contable->EventCancelled) // Update failed
			$periodo_contable_grid->RestoreCurrentRowFormValues($periodo_contable_grid->RowIndex); // Restore form values
		if ($periodo_contable->RowType == EW_ROWTYPE_EDIT) // Edit row
			$periodo_contable_grid->EditRowCnt++;
		if ($periodo_contable->CurrentAction == "F") // Confirm row
			$periodo_contable_grid->RestoreCurrentRowFormValues($periodo_contable_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$periodo_contable->RowAttrs = array_merge($periodo_contable->RowAttrs, array('data-rowindex'=>$periodo_contable_grid->RowCnt, 'id'=>'r' . $periodo_contable_grid->RowCnt . '_periodo_contable', 'data-rowtype'=>$periodo_contable->RowType));

		// Render row
		$periodo_contable_grid->RenderRow();

		// Render list options
		$periodo_contable_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($periodo_contable_grid->RowAction <> "delete" && $periodo_contable_grid->RowAction <> "insertdelete" && !($periodo_contable_grid->RowAction == "insert" && $periodo_contable->CurrentAction == "F" && $periodo_contable_grid->EmptyRow())) {
?>
	<tr<?php echo $periodo_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$periodo_contable_grid->ListOptions->Render("body", "left", $periodo_contable_grid->RowCnt);
?>
	<?php if ($periodo_contable->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $periodo_contable->idempresa->CellAttributes() ?>>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($periodo_contable->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa"<?php echo $periodo_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->idempresa->EditValue)) {
	$arwrk = $periodo_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $periodo_contable->Lookup_Selecting($periodo_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($periodo_contable->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa"<?php echo $periodo_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->idempresa->EditValue)) {
	$arwrk = $periodo_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $periodo_contable->Lookup_Selecting($periodo_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<?php echo $periodo_contable->idempresa->ListViewValue() ?></span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->FormValue) ?>">
<input type="hidden" data-field="x_idempresa" name="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->OldValue) ?>">
<?php } ?>
<a id="<?php echo $periodo_contable_grid->PageObjName . "_row_" . $periodo_contable_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($periodo_contable->idperiodo_contable->CurrentValue) ?>">
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($periodo_contable->idperiodo_contable->OldValue) ?>">
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_EDIT || $periodo_contable->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($periodo_contable->idperiodo_contable->CurrentValue) ?>">
<?php } ?>
	<?php if ($periodo_contable->mes->Visible) { // mes ?>
		<td data-name="mes"<?php echo $periodo_contable->mes->CellAttributes() ?>>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_mes" class="form-group periodo_contable_mes">
<select data-field="x_mes" id="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" name="x<?php echo $periodo_contable_grid->RowIndex ?>_mes"<?php echo $periodo_contable->mes->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->mes->EditValue)) {
	$arwrk = $periodo_contable->mes->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->mes->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->mes->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_mes" name="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" id="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" value="<?php echo ew_HtmlEncode($periodo_contable->mes->OldValue) ?>">
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_mes" class="form-group periodo_contable_mes">
<select data-field="x_mes" id="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" name="x<?php echo $periodo_contable_grid->RowIndex ?>_mes"<?php echo $periodo_contable->mes->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->mes->EditValue)) {
	$arwrk = $periodo_contable->mes->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->mes->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->mes->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $periodo_contable->mes->ViewAttributes() ?>>
<?php echo $periodo_contable->mes->ListViewValue() ?></span>
<input type="hidden" data-field="x_mes" name="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" id="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" value="<?php echo ew_HtmlEncode($periodo_contable->mes->FormValue) ?>">
<input type="hidden" data-field="x_mes" name="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" id="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" value="<?php echo ew_HtmlEncode($periodo_contable->mes->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($periodo_contable->anio->Visible) { // anio ?>
		<td data-name="anio"<?php echo $periodo_contable->anio->CellAttributes() ?>>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_anio" class="form-group periodo_contable_anio">
<select data-field="x_anio" id="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" name="x<?php echo $periodo_contable_grid->RowIndex ?>_anio"<?php echo $periodo_contable->anio->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->anio->EditValue)) {
	$arwrk = $periodo_contable->anio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->anio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->anio->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_anio" name="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" id="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" value="<?php echo ew_HtmlEncode($periodo_contable->anio->OldValue) ?>">
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $periodo_contable_grid->RowCnt ?>_periodo_contable_anio" class="form-group periodo_contable_anio">
<select data-field="x_anio" id="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" name="x<?php echo $periodo_contable_grid->RowIndex ?>_anio"<?php echo $periodo_contable->anio->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->anio->EditValue)) {
	$arwrk = $periodo_contable->anio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->anio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->anio->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $periodo_contable->anio->ViewAttributes() ?>>
<?php echo $periodo_contable->anio->ListViewValue() ?></span>
<input type="hidden" data-field="x_anio" name="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" id="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" value="<?php echo ew_HtmlEncode($periodo_contable->anio->FormValue) ?>">
<input type="hidden" data-field="x_anio" name="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" id="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" value="<?php echo ew_HtmlEncode($periodo_contable->anio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$periodo_contable_grid->ListOptions->Render("body", "right", $periodo_contable_grid->RowCnt);
?>
	</tr>
<?php if ($periodo_contable->RowType == EW_ROWTYPE_ADD || $periodo_contable->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fperiodo_contablegrid.UpdateOpts(<?php echo $periodo_contable_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($periodo_contable->CurrentAction <> "gridadd" || $periodo_contable->CurrentMode == "copy")
		if (!$periodo_contable_grid->Recordset->EOF) $periodo_contable_grid->Recordset->MoveNext();
}
?>
<?php
	if ($periodo_contable->CurrentMode == "add" || $periodo_contable->CurrentMode == "copy" || $periodo_contable->CurrentMode == "edit") {
		$periodo_contable_grid->RowIndex = '$rowindex$';
		$periodo_contable_grid->LoadDefaultValues();

		// Set row properties
		$periodo_contable->ResetAttrs();
		$periodo_contable->RowAttrs = array_merge($periodo_contable->RowAttrs, array('data-rowindex'=>$periodo_contable_grid->RowIndex, 'id'=>'r0_periodo_contable', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($periodo_contable->RowAttrs["class"], "ewTemplate");
		$periodo_contable->RowType = EW_ROWTYPE_ADD;

		// Render row
		$periodo_contable_grid->RenderRow();

		// Render list options
		$periodo_contable_grid->RenderListOptions();
		$periodo_contable_grid->StartRowCnt = 0;
?>
	<tr<?php echo $periodo_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$periodo_contable_grid->ListOptions->Render("body", "left", $periodo_contable_grid->RowIndex);
?>
	<?php if ($periodo_contable->idempresa->Visible) { // idempresa ?>
		<td>
<?php if ($periodo_contable->CurrentAction <> "F") { ?>
<?php if ($periodo_contable->idempresa->getSessionValue() <> "") { ?>
<span id="el$rowindex$_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa"<?php echo $periodo_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->idempresa->EditValue)) {
	$arwrk = $periodo_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $periodo_contable->Lookup_Selecting($periodo_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_periodo_contable_idempresa" class="form-group periodo_contable_idempresa">
<span<?php echo $periodo_contable->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="x<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $periodo_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($periodo_contable->idempresa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($periodo_contable->mes->Visible) { // mes ?>
		<td>
<?php if ($periodo_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_periodo_contable_mes" class="form-group periodo_contable_mes">
<select data-field="x_mes" id="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" name="x<?php echo $periodo_contable_grid->RowIndex ?>_mes"<?php echo $periodo_contable->mes->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->mes->EditValue)) {
	$arwrk = $periodo_contable->mes->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->mes->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->mes->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_periodo_contable_mes" class="form-group periodo_contable_mes">
<span<?php echo $periodo_contable->mes->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->mes->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_mes" name="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" id="x<?php echo $periodo_contable_grid->RowIndex ?>_mes" value="<?php echo ew_HtmlEncode($periodo_contable->mes->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_mes" name="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" id="o<?php echo $periodo_contable_grid->RowIndex ?>_mes" value="<?php echo ew_HtmlEncode($periodo_contable->mes->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($periodo_contable->anio->Visible) { // anio ?>
		<td>
<?php if ($periodo_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_periodo_contable_anio" class="form-group periodo_contable_anio">
<select data-field="x_anio" id="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" name="x<?php echo $periodo_contable_grid->RowIndex ?>_anio"<?php echo $periodo_contable->anio->EditAttributes() ?>>
<?php
if (is_array($periodo_contable->anio->EditValue)) {
	$arwrk = $periodo_contable->anio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($periodo_contable->anio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $periodo_contable->anio->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_periodo_contable_anio" class="form-group periodo_contable_anio">
<span<?php echo $periodo_contable->anio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $periodo_contable->anio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_anio" name="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" id="x<?php echo $periodo_contable_grid->RowIndex ?>_anio" value="<?php echo ew_HtmlEncode($periodo_contable->anio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_anio" name="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" id="o<?php echo $periodo_contable_grid->RowIndex ?>_anio" value="<?php echo ew_HtmlEncode($periodo_contable->anio->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$periodo_contable_grid->ListOptions->Render("body", "right", $periodo_contable_grid->RowCnt);
?>
<script type="text/javascript">
fperiodo_contablegrid.UpdateOpts(<?php echo $periodo_contable_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($periodo_contable->CurrentMode == "add" || $periodo_contable->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $periodo_contable_grid->FormKeyCountName ?>" id="<?php echo $periodo_contable_grid->FormKeyCountName ?>" value="<?php echo $periodo_contable_grid->KeyCount ?>">
<?php echo $periodo_contable_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($periodo_contable->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $periodo_contable_grid->FormKeyCountName ?>" id="<?php echo $periodo_contable_grid->FormKeyCountName ?>" value="<?php echo $periodo_contable_grid->KeyCount ?>">
<?php echo $periodo_contable_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($periodo_contable->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fperiodo_contablegrid">
</div>
<?php

// Close recordset
if ($periodo_contable_grid->Recordset)
	$periodo_contable_grid->Recordset->Close();
?>
<?php if ($periodo_contable_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($periodo_contable_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($periodo_contable_grid->TotalRecs == 0 && $periodo_contable->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($periodo_contable_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($periodo_contable->Export == "") { ?>
<script type="text/javascript">
fperiodo_contablegrid.Init();
</script>
<?php } ?>
<?php
$periodo_contable_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$periodo_contable_grid->Page_Terminate();
?>
