<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($cuenta_grid)) $cuenta_grid = new ccuenta_grid();

// Page init
$cuenta_grid->Page_Init();

// Page main
$cuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_grid->Page_Render();
?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">

// Page object
var cuenta_grid = new ew_Page("cuenta_grid");
cuenta_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cuenta_grid.PageID; // For backward compatibility

// Form object
var fcuentagrid = new ew_Form("fcuentagrid");
fcuentagrid.FormKeyCountName = '<?php echo $cuenta_grid->FormKeyCountName ?>';

// Validate form
fcuentagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idbanco->FldCaption(), $cuenta->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idsucursal->FldCaption(), $cuenta->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmoneda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idmoneda->FldCaption(), $cuenta->idmoneda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->saldo->FldCaption(), $cuenta->saldo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->saldo->FldErrMsg()) ?>");

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
fcuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idbanco", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idmoneda", false)) return false;
	if (ew_ValueChanged(fobj, infix, "saldo", false)) return false;
	return true;
}

// Form_CustomValidate event
fcuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuentagrid.ValidateRequired = true;
<?php } else { ?>
fcuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuentagrid.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcuentagrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcuentagrid.Lists["x_idmoneda"] = {"LinkField":"x_idmoneda","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","x_simbolo","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cuenta->CurrentAction == "gridadd") {
	if ($cuenta->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cuenta_grid->TotalRecs = $cuenta->SelectRecordCount();
			$cuenta_grid->Recordset = $cuenta_grid->LoadRecordset($cuenta_grid->StartRec-1, $cuenta_grid->DisplayRecs);
		} else {
			if ($cuenta_grid->Recordset = $cuenta_grid->LoadRecordset())
				$cuenta_grid->TotalRecs = $cuenta_grid->Recordset->RecordCount();
		}
		$cuenta_grid->StartRec = 1;
		$cuenta_grid->DisplayRecs = $cuenta_grid->TotalRecs;
	} else {
		$cuenta->CurrentFilter = "0=1";
		$cuenta_grid->StartRec = 1;
		$cuenta_grid->DisplayRecs = $cuenta->GridAddRowCount;
	}
	$cuenta_grid->TotalRecs = $cuenta_grid->DisplayRecs;
	$cuenta_grid->StopRec = $cuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cuenta_grid->TotalRecs = $cuenta->SelectRecordCount();
	} else {
		if ($cuenta_grid->Recordset = $cuenta_grid->LoadRecordset())
			$cuenta_grid->TotalRecs = $cuenta_grid->Recordset->RecordCount();
	}
	$cuenta_grid->StartRec = 1;
	$cuenta_grid->DisplayRecs = $cuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cuenta_grid->Recordset = $cuenta_grid->LoadRecordset($cuenta_grid->StartRec-1, $cuenta_grid->DisplayRecs);

	// Set no record found message
	if ($cuenta->CurrentAction == "" && $cuenta_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cuenta_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($cuenta_grid->SearchWhere == "0=101")
			$cuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cuenta_grid->RenderOtherOptions();
?>
<?php $cuenta_grid->ShowPageHeader(); ?>
<?php
$cuenta_grid->ShowMessage();
?>
<?php if ($cuenta_grid->TotalRecs > 0 || $cuenta->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fcuentagrid" class="ewForm form-inline">
<div id="gmp_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_cuentagrid" class="table ewTable">
<?php echo $cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cuenta_grid->RenderListOptions();

// Render list options (header, left)
$cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($cuenta->idbanco->Visible) { // idbanco ?>
	<?php if ($cuenta->SortUrl($cuenta->idbanco) == "") { ?>
		<th data-name="idbanco"><div id="elh_cuenta_idbanco" class="cuenta_idbanco"><div class="ewTableHeaderCaption"><?php echo $cuenta->idbanco->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco"><div><div id="elh_cuenta_idbanco" class="cuenta_idbanco">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->idbanco->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->idbanco->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->idbanco->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->idsucursal->Visible) { // idsucursal ?>
	<?php if ($cuenta->SortUrl($cuenta->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_cuenta_idsucursal" class="cuenta_idsucursal"><div class="ewTableHeaderCaption"><?php echo $cuenta->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_cuenta_idsucursal" class="cuenta_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->numero->Visible) { // numero ?>
	<?php if ($cuenta->SortUrl($cuenta->numero) == "") { ?>
		<th data-name="numero"><div id="elh_cuenta_numero" class="cuenta_numero"><div class="ewTableHeaderCaption"><?php echo $cuenta->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_cuenta_numero" class="cuenta_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->nombre->Visible) { // nombre ?>
	<?php if ($cuenta->SortUrl($cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_cuenta_nombre" class="cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_cuenta_nombre" class="cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->idmoneda->Visible) { // idmoneda ?>
	<?php if ($cuenta->SortUrl($cuenta->idmoneda) == "") { ?>
		<th data-name="idmoneda"><div id="elh_cuenta_idmoneda" class="cuenta_idmoneda"><div class="ewTableHeaderCaption"><?php echo $cuenta->idmoneda->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idmoneda"><div><div id="elh_cuenta_idmoneda" class="cuenta_idmoneda">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->idmoneda->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->idmoneda->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->idmoneda->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->saldo->Visible) { // saldo ?>
	<?php if ($cuenta->SortUrl($cuenta->saldo) == "") { ?>
		<th data-name="saldo"><div id="elh_cuenta_saldo" class="cuenta_saldo"><div class="ewTableHeaderCaption"><?php echo $cuenta->saldo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="saldo"><div><div id="elh_cuenta_saldo" class="cuenta_saldo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->saldo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->saldo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->saldo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cuenta_grid->StartRec = 1;
$cuenta_grid->StopRec = $cuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cuenta_grid->FormKeyCountName) && ($cuenta->CurrentAction == "gridadd" || $cuenta->CurrentAction == "gridedit" || $cuenta->CurrentAction == "F")) {
		$cuenta_grid->KeyCount = $objForm->GetValue($cuenta_grid->FormKeyCountName);
		$cuenta_grid->StopRec = $cuenta_grid->StartRec + $cuenta_grid->KeyCount - 1;
	}
}
$cuenta_grid->RecCnt = $cuenta_grid->StartRec - 1;
if ($cuenta_grid->Recordset && !$cuenta_grid->Recordset->EOF) {
	$cuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $cuenta_grid->StartRec > 1)
		$cuenta_grid->Recordset->Move($cuenta_grid->StartRec - 1);
} elseif (!$cuenta->AllowAddDeleteRow && $cuenta_grid->StopRec == 0) {
	$cuenta_grid->StopRec = $cuenta->GridAddRowCount;
}

// Initialize aggregate
$cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cuenta->ResetAttrs();
$cuenta_grid->RenderRow();
if ($cuenta->CurrentAction == "gridadd")
	$cuenta_grid->RowIndex = 0;
if ($cuenta->CurrentAction == "gridedit")
	$cuenta_grid->RowIndex = 0;
while ($cuenta_grid->RecCnt < $cuenta_grid->StopRec) {
	$cuenta_grid->RecCnt++;
	if (intval($cuenta_grid->RecCnt) >= intval($cuenta_grid->StartRec)) {
		$cuenta_grid->RowCnt++;
		if ($cuenta->CurrentAction == "gridadd" || $cuenta->CurrentAction == "gridedit" || $cuenta->CurrentAction == "F") {
			$cuenta_grid->RowIndex++;
			$objForm->Index = $cuenta_grid->RowIndex;
			if ($objForm->HasValue($cuenta_grid->FormActionName))
				$cuenta_grid->RowAction = strval($objForm->GetValue($cuenta_grid->FormActionName));
			elseif ($cuenta->CurrentAction == "gridadd")
				$cuenta_grid->RowAction = "insert";
			else
				$cuenta_grid->RowAction = "";
		}

		// Set up key count
		$cuenta_grid->KeyCount = $cuenta_grid->RowIndex;

		// Init row class and style
		$cuenta->ResetAttrs();
		$cuenta->CssClass = "";
		if ($cuenta->CurrentAction == "gridadd") {
			if ($cuenta->CurrentMode == "copy") {
				$cuenta_grid->LoadRowValues($cuenta_grid->Recordset); // Load row values
				$cuenta_grid->SetRecordKey($cuenta_grid->RowOldKey, $cuenta_grid->Recordset); // Set old record key
			} else {
				$cuenta_grid->LoadDefaultValues(); // Load default values
				$cuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cuenta_grid->LoadRowValues($cuenta_grid->Recordset); // Load row values
		}
		$cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cuenta->CurrentAction == "gridadd") // Grid add
			$cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cuenta->CurrentAction == "gridadd" && $cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
		if ($cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($cuenta->EventCancelled) {
				$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
			}
			if ($cuenta_grid->RowAction == "insert")
				$cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cuenta->CurrentAction == "gridedit" && ($cuenta->RowType == EW_ROWTYPE_EDIT || $cuenta->RowType == EW_ROWTYPE_ADD) && $cuenta->EventCancelled) // Update failed
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
		if ($cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cuenta_grid->EditRowCnt++;
		if ($cuenta->CurrentAction == "F") // Confirm row
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cuenta->RowAttrs = array_merge($cuenta->RowAttrs, array('data-rowindex'=>$cuenta_grid->RowCnt, 'id'=>'r' . $cuenta_grid->RowCnt . '_cuenta', 'data-rowtype'=>$cuenta->RowType));

		// Render row
		$cuenta_grid->RenderRow();

		// Render list options
		$cuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cuenta_grid->RowAction <> "delete" && $cuenta_grid->RowAction <> "insertdelete" && !($cuenta_grid->RowAction == "insert" && $cuenta->CurrentAction == "F" && $cuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_grid->ListOptions->Render("body", "left", $cuenta_grid->RowCnt);
?>
	<?php if ($cuenta->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco"<?php echo $cuenta->idbanco->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idbanco" class="form-group cuenta_idbanco">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idbanco" class="form-group cuenta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco"<?php echo $cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($cuenta->idbanco->EditValue)) {
	$arwrk = $cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idbanco->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idbanco" class="form-group cuenta_idbanco">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idbanco" class="form-group cuenta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco"<?php echo $cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($cuenta->idbanco->EditValue)) {
	$arwrk = $cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idbanco->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<?php echo $cuenta->idbanco->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->FormValue) ?>">
<input type="hidden" data-field="x_idbanco" name="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cuenta_grid->PageObjName . "_row_" . $cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->CurrentValue) ?>">
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="o<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT || $cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $cuenta->idsucursal->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsucursal" class="form-group cuenta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" name="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal"<?php echo $cuenta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsucursal->EditValue)) {
	$arwrk = $cuenta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idsucursal->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($cuenta->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsucursal" class="form-group cuenta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" name="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal"<?php echo $cuenta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsucursal->EditValue)) {
	$arwrk = $cuenta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idsucursal->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->idsucursal->ViewAttributes() ?>>
<?php echo $cuenta->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($cuenta->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($cuenta->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $cuenta->numero->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_numero" class="form-group cuenta_numero">
<input type="text" data-field="x_numero" name="x<?php echo $cuenta_grid->RowIndex ?>_numero" id="x<?php echo $cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->numero->PlaceHolder) ?>" value="<?php echo $cuenta->numero->EditValue ?>"<?php echo $cuenta->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_numero" name="o<?php echo $cuenta_grid->RowIndex ?>_numero" id="o<?php echo $cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($cuenta->numero->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_numero" class="form-group cuenta_numero">
<input type="text" data-field="x_numero" name="x<?php echo $cuenta_grid->RowIndex ?>_numero" id="x<?php echo $cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->numero->PlaceHolder) ?>" value="<?php echo $cuenta->numero->EditValue ?>"<?php echo $cuenta->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->numero->ViewAttributes() ?>>
<?php echo $cuenta->numero->ListViewValue() ?></span>
<input type="hidden" data-field="x_numero" name="x<?php echo $cuenta_grid->RowIndex ?>_numero" id="x<?php echo $cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($cuenta->numero->FormValue) ?>">
<input type="hidden" data-field="x_numero" name="o<?php echo $cuenta_grid->RowIndex ?>_numero" id="o<?php echo $cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($cuenta->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $cuenta->nombre->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->PlaceHolder) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->PlaceHolder) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->nombre->ViewAttributes() ?>>
<?php echo $cuenta->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta->idmoneda->Visible) { // idmoneda ?>
		<td data-name="idmoneda"<?php echo $cuenta->idmoneda->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idmoneda" class="form-group cuenta_idmoneda">
<select data-field="x_idmoneda" id="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" name="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda"<?php echo $cuenta->idmoneda->EditAttributes() ?>>
<?php
if (is_array($cuenta->idmoneda->EditValue)) {
	$arwrk = $cuenta->idmoneda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idmoneda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta->idmoneda) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idmoneda->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmoneda`, `nombre` AS `DispFld`, `simbolo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta->Lookup_Selecting($cuenta->idmoneda, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmoneda` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idmoneda" name="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($cuenta->idmoneda->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idmoneda" class="form-group cuenta_idmoneda">
<select data-field="x_idmoneda" id="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" name="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda"<?php echo $cuenta->idmoneda->EditAttributes() ?>>
<?php
if (is_array($cuenta->idmoneda->EditValue)) {
	$arwrk = $cuenta->idmoneda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idmoneda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta->idmoneda) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idmoneda->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmoneda`, `nombre` AS `DispFld`, `simbolo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta->Lookup_Selecting($cuenta->idmoneda, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmoneda` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->idmoneda->ViewAttributes() ?>>
<?php echo $cuenta->idmoneda->ListViewValue() ?></span>
<input type="hidden" data-field="x_idmoneda" name="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($cuenta->idmoneda->FormValue) ?>">
<input type="hidden" data-field="x_idmoneda" name="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($cuenta->idmoneda->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta->saldo->Visible) { // saldo ?>
		<td data-name="saldo"<?php echo $cuenta->saldo->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_saldo" class="form-group cuenta_saldo">
<input type="text" data-field="x_saldo" name="x<?php echo $cuenta_grid->RowIndex ?>_saldo" id="x<?php echo $cuenta_grid->RowIndex ?>_saldo" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->saldo->PlaceHolder) ?>" value="<?php echo $cuenta->saldo->EditValue ?>"<?php echo $cuenta->saldo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_saldo" name="o<?php echo $cuenta_grid->RowIndex ?>_saldo" id="o<?php echo $cuenta_grid->RowIndex ?>_saldo" value="<?php echo ew_HtmlEncode($cuenta->saldo->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_saldo" class="form-group cuenta_saldo">
<input type="text" data-field="x_saldo" name="x<?php echo $cuenta_grid->RowIndex ?>_saldo" id="x<?php echo $cuenta_grid->RowIndex ?>_saldo" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->saldo->PlaceHolder) ?>" value="<?php echo $cuenta->saldo->EditValue ?>"<?php echo $cuenta->saldo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta->saldo->ViewAttributes() ?>>
<?php echo $cuenta->saldo->ListViewValue() ?></span>
<input type="hidden" data-field="x_saldo" name="x<?php echo $cuenta_grid->RowIndex ?>_saldo" id="x<?php echo $cuenta_grid->RowIndex ?>_saldo" value="<?php echo ew_HtmlEncode($cuenta->saldo->FormValue) ?>">
<input type="hidden" data-field="x_saldo" name="o<?php echo $cuenta_grid->RowIndex ?>_saldo" id="o<?php echo $cuenta_grid->RowIndex ?>_saldo" value="<?php echo ew_HtmlEncode($cuenta->saldo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_grid->ListOptions->Render("body", "right", $cuenta_grid->RowCnt);
?>
	</tr>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD || $cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcuentagrid.UpdateOpts(<?php echo $cuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cuenta->CurrentAction <> "gridadd" || $cuenta->CurrentMode == "copy")
		if (!$cuenta_grid->Recordset->EOF) $cuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cuenta->CurrentMode == "add" || $cuenta->CurrentMode == "copy" || $cuenta->CurrentMode == "edit") {
		$cuenta_grid->RowIndex = '$rowindex$';
		$cuenta_grid->LoadDefaultValues();

		// Set row properties
		$cuenta->ResetAttrs();
		$cuenta->RowAttrs = array_merge($cuenta->RowAttrs, array('data-rowindex'=>$cuenta_grid->RowIndex, 'id'=>'r0_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cuenta->RowAttrs["class"], "ewTemplate");
		$cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cuenta_grid->RenderRow();

		// Render list options
		$cuenta_grid->RenderListOptions();
		$cuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_grid->ListOptions->Render("body", "left", $cuenta_grid->RowIndex);
?>
	<?php if ($cuenta->idbanco->Visible) { // idbanco ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<?php if ($cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_idbanco" class="form-group cuenta_idbanco">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_idbanco" class="form-group cuenta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco"<?php echo $cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($cuenta->idbanco->EditValue)) {
	$arwrk = $cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idbanco->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cuenta_idbanco" class="form-group cuenta_idbanco">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="x<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_idsucursal" class="form-group cuenta_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" name="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal"<?php echo $cuenta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsucursal->EditValue)) {
	$arwrk = $cuenta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idsucursal->OldValue = "";
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
 $cuenta->Lookup_Selecting($cuenta->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_idsucursal" class="form-group cuenta_idsucursal">
<span<?php echo $cuenta->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="x<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($cuenta->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" id="o<?php echo $cuenta_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($cuenta->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->numero->Visible) { // numero ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_numero" class="form-group cuenta_numero">
<input type="text" data-field="x_numero" name="x<?php echo $cuenta_grid->RowIndex ?>_numero" id="x<?php echo $cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->numero->PlaceHolder) ?>" value="<?php echo $cuenta->numero->EditValue ?>"<?php echo $cuenta->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_numero" class="form-group cuenta_numero">
<span<?php echo $cuenta->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_numero" name="x<?php echo $cuenta_grid->RowIndex ?>_numero" id="x<?php echo $cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($cuenta->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_numero" name="o<?php echo $cuenta_grid->RowIndex ?>_numero" id="o<?php echo $cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($cuenta->numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->nombre->Visible) { // nombre ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->PlaceHolder) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_nombre" class="form-group cuenta_nombre">
<span<?php echo $cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->idmoneda->Visible) { // idmoneda ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_idmoneda" class="form-group cuenta_idmoneda">
<select data-field="x_idmoneda" id="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" name="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda"<?php echo $cuenta->idmoneda->EditAttributes() ?>>
<?php
if (is_array($cuenta->idmoneda->EditValue)) {
	$arwrk = $cuenta->idmoneda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->idmoneda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta->idmoneda) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta->idmoneda->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmoneda`, `nombre` AS `DispFld`, `simbolo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta->Lookup_Selecting($cuenta->idmoneda, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmoneda` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_idmoneda" class="form-group cuenta_idmoneda">
<span<?php echo $cuenta->idmoneda->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idmoneda->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idmoneda" name="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="x<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($cuenta->idmoneda->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idmoneda" name="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" id="o<?php echo $cuenta_grid->RowIndex ?>_idmoneda" value="<?php echo ew_HtmlEncode($cuenta->idmoneda->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->saldo->Visible) { // saldo ?>
		<td>
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_saldo" class="form-group cuenta_saldo">
<input type="text" data-field="x_saldo" name="x<?php echo $cuenta_grid->RowIndex ?>_saldo" id="x<?php echo $cuenta_grid->RowIndex ?>_saldo" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->saldo->PlaceHolder) ?>" value="<?php echo $cuenta->saldo->EditValue ?>"<?php echo $cuenta->saldo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_saldo" class="form-group cuenta_saldo">
<span<?php echo $cuenta->saldo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->saldo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_saldo" name="x<?php echo $cuenta_grid->RowIndex ?>_saldo" id="x<?php echo $cuenta_grid->RowIndex ?>_saldo" value="<?php echo ew_HtmlEncode($cuenta->saldo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_saldo" name="o<?php echo $cuenta_grid->RowIndex ?>_saldo" id="o<?php echo $cuenta_grid->RowIndex ?>_saldo" value="<?php echo ew_HtmlEncode($cuenta->saldo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_grid->ListOptions->Render("body", "right", $cuenta_grid->RowCnt);
?>
<script type="text/javascript">
fcuentagrid.UpdateOpts(<?php echo $cuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cuenta->CurrentMode == "add" || $cuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cuenta_grid->FormKeyCountName ?>" id="<?php echo $cuenta_grid->FormKeyCountName ?>" value="<?php echo $cuenta_grid->KeyCount ?>">
<?php echo $cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cuenta_grid->FormKeyCountName ?>" id="<?php echo $cuenta_grid->FormKeyCountName ?>" value="<?php echo $cuenta_grid->KeyCount ?>">
<?php echo $cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcuentagrid">
</div>
<?php

// Close recordset
if ($cuenta_grid->Recordset)
	$cuenta_grid->Recordset->Close();
?>
<?php if ($cuenta_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($cuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cuenta_grid->TotalRecs == 0 && $cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">
fcuentagrid.Init();
</script>
<?php } ?>
<?php
$cuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cuenta_grid->Page_Terminate();
?>
