<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($sucursal_grid)) $sucursal_grid = new csucursal_grid();

// Page init
$sucursal_grid->Page_Init();

// Page main
$sucursal_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sucursal_grid->Page_Render();
?>
<?php if ($sucursal->Export == "") { ?>
<script type="text/javascript">

// Page object
var sucursal_grid = new ew_Page("sucursal_grid");
sucursal_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = sucursal_grid.PageID; // For backward compatibility

// Form object
var fsucursalgrid = new ew_Form("fsucursalgrid");
fsucursalgrid.FormKeyCountName = '<?php echo $sucursal_grid->FormKeyCountName ?>';

// Validate form
fsucursalgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idmunicipio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idmunicipio->FldCaption(), $sucursal->idmunicipio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idempresa->FldCaption(), $sucursal->idempresa->ReqErrMsg)) ?>");

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
fsucursalgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idmunicipio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	return true;
}

// Form_CustomValidate event
fsucursalgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsucursalgrid.ValidateRequired = true;
<?php } else { ?>
fsucursalgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsucursalgrid.Lists["x_idmunicipio"] = {"LinkField":"x_idmunicipio","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fsucursalgrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($sucursal->CurrentAction == "gridadd") {
	if ($sucursal->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$sucursal_grid->TotalRecs = $sucursal->SelectRecordCount();
			$sucursal_grid->Recordset = $sucursal_grid->LoadRecordset($sucursal_grid->StartRec-1, $sucursal_grid->DisplayRecs);
		} else {
			if ($sucursal_grid->Recordset = $sucursal_grid->LoadRecordset())
				$sucursal_grid->TotalRecs = $sucursal_grid->Recordset->RecordCount();
		}
		$sucursal_grid->StartRec = 1;
		$sucursal_grid->DisplayRecs = $sucursal_grid->TotalRecs;
	} else {
		$sucursal->CurrentFilter = "0=1";
		$sucursal_grid->StartRec = 1;
		$sucursal_grid->DisplayRecs = $sucursal->GridAddRowCount;
	}
	$sucursal_grid->TotalRecs = $sucursal_grid->DisplayRecs;
	$sucursal_grid->StopRec = $sucursal_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$sucursal_grid->TotalRecs = $sucursal->SelectRecordCount();
	} else {
		if ($sucursal_grid->Recordset = $sucursal_grid->LoadRecordset())
			$sucursal_grid->TotalRecs = $sucursal_grid->Recordset->RecordCount();
	}
	$sucursal_grid->StartRec = 1;
	$sucursal_grid->DisplayRecs = $sucursal_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$sucursal_grid->Recordset = $sucursal_grid->LoadRecordset($sucursal_grid->StartRec-1, $sucursal_grid->DisplayRecs);

	// Set no record found message
	if ($sucursal->CurrentAction == "" && $sucursal_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$sucursal_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($sucursal_grid->SearchWhere == "0=101")
			$sucursal_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$sucursal_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$sucursal_grid->RenderOtherOptions();
?>
<?php $sucursal_grid->ShowPageHeader(); ?>
<?php
$sucursal_grid->ShowMessage();
?>
<?php if ($sucursal_grid->TotalRecs > 0 || $sucursal->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fsucursalgrid" class="ewForm form-inline">
<div id="gmp_sucursal" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_sucursalgrid" class="table ewTable">
<?php echo $sucursal->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$sucursal_grid->RenderListOptions();

// Render list options (header, left)
$sucursal_grid->ListOptions->Render("header", "left");
?>
<?php if ($sucursal->nombre->Visible) { // nombre ?>
	<?php if ($sucursal->SortUrl($sucursal->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_sucursal_nombre" class="sucursal_nombre"><div class="ewTableHeaderCaption"><?php echo $sucursal->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_sucursal_nombre" class="sucursal_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($sucursal->idmunicipio->Visible) { // idmunicipio ?>
	<?php if ($sucursal->SortUrl($sucursal->idmunicipio) == "") { ?>
		<th data-name="idmunicipio"><div id="elh_sucursal_idmunicipio" class="sucursal_idmunicipio"><div class="ewTableHeaderCaption"><?php echo $sucursal->idmunicipio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idmunicipio"><div><div id="elh_sucursal_idmunicipio" class="sucursal_idmunicipio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->idmunicipio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->idmunicipio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->idmunicipio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
	<?php if ($sucursal->SortUrl($sucursal->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_sucursal_idempresa" class="sucursal_idempresa"><div class="ewTableHeaderCaption"><?php echo $sucursal->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_sucursal_idempresa" class="sucursal_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$sucursal_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$sucursal_grid->StartRec = 1;
$sucursal_grid->StopRec = $sucursal_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($sucursal_grid->FormKeyCountName) && ($sucursal->CurrentAction == "gridadd" || $sucursal->CurrentAction == "gridedit" || $sucursal->CurrentAction == "F")) {
		$sucursal_grid->KeyCount = $objForm->GetValue($sucursal_grid->FormKeyCountName);
		$sucursal_grid->StopRec = $sucursal_grid->StartRec + $sucursal_grid->KeyCount - 1;
	}
}
$sucursal_grid->RecCnt = $sucursal_grid->StartRec - 1;
if ($sucursal_grid->Recordset && !$sucursal_grid->Recordset->EOF) {
	$sucursal_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $sucursal_grid->StartRec > 1)
		$sucursal_grid->Recordset->Move($sucursal_grid->StartRec - 1);
} elseif (!$sucursal->AllowAddDeleteRow && $sucursal_grid->StopRec == 0) {
	$sucursal_grid->StopRec = $sucursal->GridAddRowCount;
}

// Initialize aggregate
$sucursal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$sucursal->ResetAttrs();
$sucursal_grid->RenderRow();
if ($sucursal->CurrentAction == "gridadd")
	$sucursal_grid->RowIndex = 0;
if ($sucursal->CurrentAction == "gridedit")
	$sucursal_grid->RowIndex = 0;
while ($sucursal_grid->RecCnt < $sucursal_grid->StopRec) {
	$sucursal_grid->RecCnt++;
	if (intval($sucursal_grid->RecCnt) >= intval($sucursal_grid->StartRec)) {
		$sucursal_grid->RowCnt++;
		if ($sucursal->CurrentAction == "gridadd" || $sucursal->CurrentAction == "gridedit" || $sucursal->CurrentAction == "F") {
			$sucursal_grid->RowIndex++;
			$objForm->Index = $sucursal_grid->RowIndex;
			if ($objForm->HasValue($sucursal_grid->FormActionName))
				$sucursal_grid->RowAction = strval($objForm->GetValue($sucursal_grid->FormActionName));
			elseif ($sucursal->CurrentAction == "gridadd")
				$sucursal_grid->RowAction = "insert";
			else
				$sucursal_grid->RowAction = "";
		}

		// Set up key count
		$sucursal_grid->KeyCount = $sucursal_grid->RowIndex;

		// Init row class and style
		$sucursal->ResetAttrs();
		$sucursal->CssClass = "";
		if ($sucursal->CurrentAction == "gridadd") {
			if ($sucursal->CurrentMode == "copy") {
				$sucursal_grid->LoadRowValues($sucursal_grid->Recordset); // Load row values
				$sucursal_grid->SetRecordKey($sucursal_grid->RowOldKey, $sucursal_grid->Recordset); // Set old record key
			} else {
				$sucursal_grid->LoadDefaultValues(); // Load default values
				$sucursal_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$sucursal_grid->LoadRowValues($sucursal_grid->Recordset); // Load row values
		}
		$sucursal->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($sucursal->CurrentAction == "gridadd") // Grid add
			$sucursal->RowType = EW_ROWTYPE_ADD; // Render add
		if ($sucursal->CurrentAction == "gridadd" && $sucursal->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
		if ($sucursal->CurrentAction == "gridedit") { // Grid edit
			if ($sucursal->EventCancelled) {
				$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
			}
			if ($sucursal_grid->RowAction == "insert")
				$sucursal->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$sucursal->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($sucursal->CurrentAction == "gridedit" && ($sucursal->RowType == EW_ROWTYPE_EDIT || $sucursal->RowType == EW_ROWTYPE_ADD) && $sucursal->EventCancelled) // Update failed
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
		if ($sucursal->RowType == EW_ROWTYPE_EDIT) // Edit row
			$sucursal_grid->EditRowCnt++;
		if ($sucursal->CurrentAction == "F") // Confirm row
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$sucursal->RowAttrs = array_merge($sucursal->RowAttrs, array('data-rowindex'=>$sucursal_grid->RowCnt, 'id'=>'r' . $sucursal_grid->RowCnt . '_sucursal', 'data-rowtype'=>$sucursal->RowType));

		// Render row
		$sucursal_grid->RenderRow();

		// Render list options
		$sucursal_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($sucursal_grid->RowAction <> "delete" && $sucursal_grid->RowAction <> "insertdelete" && !($sucursal_grid->RowAction == "insert" && $sucursal->CurrentAction == "F" && $sucursal_grid->EmptyRow())) {
?>
	<tr<?php echo $sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sucursal_grid->ListOptions->Render("body", "left", $sucursal_grid->RowCnt);
?>
	<?php if ($sucursal->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $sucursal->nombre->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->PlaceHolder) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->PlaceHolder) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $sucursal->nombre->ViewAttributes() ?>>
<?php echo $sucursal->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $sucursal_grid->PageObjName . "_row_" . $sucursal_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->CurrentValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="o<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT || $sucursal->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->CurrentValue) ?>">
<?php } ?>
	<?php if ($sucursal->idmunicipio->Visible) { // idmunicipio ?>
		<td data-name="idmunicipio"<?php echo $sucursal->idmunicipio->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idmunicipio" class="form-group sucursal_idmunicipio">
<select data-field="x_idmunicipio" id="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" name="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio"<?php echo $sucursal->idmunicipio->EditAttributes() ?>>
<?php
if (is_array($sucursal->idmunicipio->EditValue)) {
	$arwrk = $sucursal->idmunicipio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idmunicipio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idmunicipio->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmunicipio`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `municipio`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $sucursal->Lookup_Selecting($sucursal->idmunicipio, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmunicipio` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idmunicipio" name="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="<?php echo ew_HtmlEncode($sucursal->idmunicipio->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idmunicipio" class="form-group sucursal_idmunicipio">
<select data-field="x_idmunicipio" id="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" name="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio"<?php echo $sucursal->idmunicipio->EditAttributes() ?>>
<?php
if (is_array($sucursal->idmunicipio->EditValue)) {
	$arwrk = $sucursal->idmunicipio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idmunicipio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idmunicipio->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmunicipio`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `municipio`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $sucursal->Lookup_Selecting($sucursal->idmunicipio, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmunicipio` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $sucursal->idmunicipio->ViewAttributes() ?>>
<?php echo $sucursal->idmunicipio->ListViewValue() ?></span>
<input type="hidden" data-field="x_idmunicipio" name="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="<?php echo ew_HtmlEncode($sucursal->idmunicipio->FormValue) ?>">
<input type="hidden" data-field="x_idmunicipio" name="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="<?php echo ew_HtmlEncode($sucursal->idmunicipio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $sucursal->idempresa->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-field="x_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
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
 $sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-field="x_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
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
 $sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<?php echo $sucursal->idempresa->ListViewValue() ?></span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->FormValue) ?>">
<input type="hidden" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sucursal_grid->ListOptions->Render("body", "right", $sucursal_grid->RowCnt);
?>
	</tr>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD || $sucursal->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsucursalgrid.UpdateOpts(<?php echo $sucursal_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($sucursal->CurrentAction <> "gridadd" || $sucursal->CurrentMode == "copy")
		if (!$sucursal_grid->Recordset->EOF) $sucursal_grid->Recordset->MoveNext();
}
?>
<?php
	if ($sucursal->CurrentMode == "add" || $sucursal->CurrentMode == "copy" || $sucursal->CurrentMode == "edit") {
		$sucursal_grid->RowIndex = '$rowindex$';
		$sucursal_grid->LoadDefaultValues();

		// Set row properties
		$sucursal->ResetAttrs();
		$sucursal->RowAttrs = array_merge($sucursal->RowAttrs, array('data-rowindex'=>$sucursal_grid->RowIndex, 'id'=>'r0_sucursal', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($sucursal->RowAttrs["class"], "ewTemplate");
		$sucursal->RowType = EW_ROWTYPE_ADD;

		// Render row
		$sucursal_grid->RenderRow();

		// Render list options
		$sucursal_grid->RenderListOptions();
		$sucursal_grid->StartRowCnt = 0;
?>
	<tr<?php echo $sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sucursal_grid->ListOptions->Render("body", "left", $sucursal_grid->RowIndex);
?>
	<?php if ($sucursal->nombre->Visible) { // nombre ?>
		<td>
<?php if ($sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->PlaceHolder) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_sucursal_nombre" class="form-group sucursal_nombre">
<span<?php echo $sucursal->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sucursal->idmunicipio->Visible) { // idmunicipio ?>
		<td>
<?php if ($sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sucursal_idmunicipio" class="form-group sucursal_idmunicipio">
<select data-field="x_idmunicipio" id="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" name="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio"<?php echo $sucursal->idmunicipio->EditAttributes() ?>>
<?php
if (is_array($sucursal->idmunicipio->EditValue)) {
	$arwrk = $sucursal->idmunicipio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idmunicipio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idmunicipio->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmunicipio`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `municipio`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $sucursal->Lookup_Selecting($sucursal->idmunicipio, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmunicipio` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_sucursal_idmunicipio" class="form-group sucursal_idmunicipio">
<span<?php echo $sucursal->idmunicipio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idmunicipio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idmunicipio" name="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="x<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="<?php echo ew_HtmlEncode($sucursal->idmunicipio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idmunicipio" name="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" id="o<?php echo $sucursal_grid->RowIndex ?>_idmunicipio" value="<?php echo ew_HtmlEncode($sucursal->idmunicipio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
		<td>
<?php if ($sucursal->CurrentAction <> "F") { ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-field="x_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($sucursal->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
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
 $sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sucursal_grid->ListOptions->Render("body", "right", $sucursal_grid->RowCnt);
?>
<script type="text/javascript">
fsucursalgrid.UpdateOpts(<?php echo $sucursal_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($sucursal->CurrentMode == "add" || $sucursal->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $sucursal_grid->FormKeyCountName ?>" id="<?php echo $sucursal_grid->FormKeyCountName ?>" value="<?php echo $sucursal_grid->KeyCount ?>">
<?php echo $sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sucursal->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $sucursal_grid->FormKeyCountName ?>" id="<?php echo $sucursal_grid->FormKeyCountName ?>" value="<?php echo $sucursal_grid->KeyCount ?>">
<?php echo $sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sucursal->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsucursalgrid">
</div>
<?php

// Close recordset
if ($sucursal_grid->Recordset)
	$sucursal_grid->Recordset->Close();
?>
<?php if ($sucursal_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($sucursal_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($sucursal_grid->TotalRecs == 0 && $sucursal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($sucursal_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($sucursal->Export == "") { ?>
<script type="text/javascript">
fsucursalgrid.Init();
</script>
<?php } ?>
<?php
$sucursal_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$sucursal_grid->Page_Terminate();
?>
