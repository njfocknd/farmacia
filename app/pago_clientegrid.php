<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($pago_cliente_grid)) $pago_cliente_grid = new cpago_cliente_grid();

// Page init
$pago_cliente_grid->Page_Init();

// Page main
$pago_cliente_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pago_cliente_grid->Page_Render();
?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">

// Page object
var pago_cliente_grid = new ew_Page("pago_cliente_grid");
pago_cliente_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = pago_cliente_grid.PageID; // For backward compatibility

// Form object
var fpago_clientegrid = new ew_Form("fpago_clientegrid");
fpago_clientegrid.FormKeyCountName = '<?php echo $pago_cliente_grid->FormKeyCountName ?>';

// Validate form
fpago_clientegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->idcliente->FldCaption(), $pago_cliente->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->monto->FldCaption(), $pago_cliente->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_cliente->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_cliente->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->idsucursal->FldCaption(), $pago_cliente->idsucursal->ReqErrMsg)) ?>");

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
fpago_clientegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idcliente", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	return true;
}

// Form_CustomValidate event
fpago_clientegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpago_clientegrid.ValidateRequired = true;
<?php } else { ?>
fpago_clientegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpago_clientegrid.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_codigo","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientegrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($pago_cliente->CurrentAction == "gridadd") {
	if ($pago_cliente->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$pago_cliente_grid->TotalRecs = $pago_cliente->SelectRecordCount();
			$pago_cliente_grid->Recordset = $pago_cliente_grid->LoadRecordset($pago_cliente_grid->StartRec-1, $pago_cliente_grid->DisplayRecs);
		} else {
			if ($pago_cliente_grid->Recordset = $pago_cliente_grid->LoadRecordset())
				$pago_cliente_grid->TotalRecs = $pago_cliente_grid->Recordset->RecordCount();
		}
		$pago_cliente_grid->StartRec = 1;
		$pago_cliente_grid->DisplayRecs = $pago_cliente_grid->TotalRecs;
	} else {
		$pago_cliente->CurrentFilter = "0=1";
		$pago_cliente_grid->StartRec = 1;
		$pago_cliente_grid->DisplayRecs = $pago_cliente->GridAddRowCount;
	}
	$pago_cliente_grid->TotalRecs = $pago_cliente_grid->DisplayRecs;
	$pago_cliente_grid->StopRec = $pago_cliente_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$pago_cliente_grid->TotalRecs = $pago_cliente->SelectRecordCount();
	} else {
		if ($pago_cliente_grid->Recordset = $pago_cliente_grid->LoadRecordset())
			$pago_cliente_grid->TotalRecs = $pago_cliente_grid->Recordset->RecordCount();
	}
	$pago_cliente_grid->StartRec = 1;
	$pago_cliente_grid->DisplayRecs = $pago_cliente_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$pago_cliente_grid->Recordset = $pago_cliente_grid->LoadRecordset($pago_cliente_grid->StartRec-1, $pago_cliente_grid->DisplayRecs);

	// Set no record found message
	if ($pago_cliente->CurrentAction == "" && $pago_cliente_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$pago_cliente_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($pago_cliente_grid->SearchWhere == "0=101")
			$pago_cliente_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pago_cliente_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$pago_cliente_grid->RenderOtherOptions();
?>
<?php $pago_cliente_grid->ShowPageHeader(); ?>
<?php
$pago_cliente_grid->ShowMessage();
?>
<?php if ($pago_cliente_grid->TotalRecs > 0 || $pago_cliente->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fpago_clientegrid" class="ewForm form-inline">
<div id="gmp_pago_cliente" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_pago_clientegrid" class="table ewTable">
<?php echo $pago_cliente->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$pago_cliente_grid->RenderListOptions();

// Render list options (header, left)
$pago_cliente_grid->ListOptions->Render("header", "left");
?>
<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idcliente) == "") { ?>
		<th data-name="idcliente"><div id="elh_pago_cliente_idcliente" class="pago_cliente_idcliente"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idcliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcliente"><div><div id="elh_pago_cliente_idcliente" class="pago_cliente_idcliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idcliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idcliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idcliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->monto->Visible) { // monto ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->monto) == "") { ?>
		<th data-name="monto"><div id="elh_pago_cliente_monto" class="pago_cliente_monto"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_pago_cliente_monto" class="pago_cliente_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_pago_cliente_fecha" class="pago_cliente_fecha"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_pago_cliente_fecha" class="pago_cliente_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_pago_cliente_idsucursal" class="pago_cliente_idsucursal"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_pago_cliente_idsucursal" class="pago_cliente_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pago_cliente_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$pago_cliente_grid->StartRec = 1;
$pago_cliente_grid->StopRec = $pago_cliente_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($pago_cliente_grid->FormKeyCountName) && ($pago_cliente->CurrentAction == "gridadd" || $pago_cliente->CurrentAction == "gridedit" || $pago_cliente->CurrentAction == "F")) {
		$pago_cliente_grid->KeyCount = $objForm->GetValue($pago_cliente_grid->FormKeyCountName);
		$pago_cliente_grid->StopRec = $pago_cliente_grid->StartRec + $pago_cliente_grid->KeyCount - 1;
	}
}
$pago_cliente_grid->RecCnt = $pago_cliente_grid->StartRec - 1;
if ($pago_cliente_grid->Recordset && !$pago_cliente_grid->Recordset->EOF) {
	$pago_cliente_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $pago_cliente_grid->StartRec > 1)
		$pago_cliente_grid->Recordset->Move($pago_cliente_grid->StartRec - 1);
} elseif (!$pago_cliente->AllowAddDeleteRow && $pago_cliente_grid->StopRec == 0) {
	$pago_cliente_grid->StopRec = $pago_cliente->GridAddRowCount;
}

// Initialize aggregate
$pago_cliente->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pago_cliente->ResetAttrs();
$pago_cliente_grid->RenderRow();
if ($pago_cliente->CurrentAction == "gridadd")
	$pago_cliente_grid->RowIndex = 0;
if ($pago_cliente->CurrentAction == "gridedit")
	$pago_cliente_grid->RowIndex = 0;
while ($pago_cliente_grid->RecCnt < $pago_cliente_grid->StopRec) {
	$pago_cliente_grid->RecCnt++;
	if (intval($pago_cliente_grid->RecCnt) >= intval($pago_cliente_grid->StartRec)) {
		$pago_cliente_grid->RowCnt++;
		if ($pago_cliente->CurrentAction == "gridadd" || $pago_cliente->CurrentAction == "gridedit" || $pago_cliente->CurrentAction == "F") {
			$pago_cliente_grid->RowIndex++;
			$objForm->Index = $pago_cliente_grid->RowIndex;
			if ($objForm->HasValue($pago_cliente_grid->FormActionName))
				$pago_cliente_grid->RowAction = strval($objForm->GetValue($pago_cliente_grid->FormActionName));
			elseif ($pago_cliente->CurrentAction == "gridadd")
				$pago_cliente_grid->RowAction = "insert";
			else
				$pago_cliente_grid->RowAction = "";
		}

		// Set up key count
		$pago_cliente_grid->KeyCount = $pago_cliente_grid->RowIndex;

		// Init row class and style
		$pago_cliente->ResetAttrs();
		$pago_cliente->CssClass = "";
		if ($pago_cliente->CurrentAction == "gridadd") {
			if ($pago_cliente->CurrentMode == "copy") {
				$pago_cliente_grid->LoadRowValues($pago_cliente_grid->Recordset); // Load row values
				$pago_cliente_grid->SetRecordKey($pago_cliente_grid->RowOldKey, $pago_cliente_grid->Recordset); // Set old record key
			} else {
				$pago_cliente_grid->LoadDefaultValues(); // Load default values
				$pago_cliente_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$pago_cliente_grid->LoadRowValues($pago_cliente_grid->Recordset); // Load row values
		}
		$pago_cliente->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($pago_cliente->CurrentAction == "gridadd") // Grid add
			$pago_cliente->RowType = EW_ROWTYPE_ADD; // Render add
		if ($pago_cliente->CurrentAction == "gridadd" && $pago_cliente->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$pago_cliente_grid->RestoreCurrentRowFormValues($pago_cliente_grid->RowIndex); // Restore form values
		if ($pago_cliente->CurrentAction == "gridedit") { // Grid edit
			if ($pago_cliente->EventCancelled) {
				$pago_cliente_grid->RestoreCurrentRowFormValues($pago_cliente_grid->RowIndex); // Restore form values
			}
			if ($pago_cliente_grid->RowAction == "insert")
				$pago_cliente->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$pago_cliente->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($pago_cliente->CurrentAction == "gridedit" && ($pago_cliente->RowType == EW_ROWTYPE_EDIT || $pago_cliente->RowType == EW_ROWTYPE_ADD) && $pago_cliente->EventCancelled) // Update failed
			$pago_cliente_grid->RestoreCurrentRowFormValues($pago_cliente_grid->RowIndex); // Restore form values
		if ($pago_cliente->RowType == EW_ROWTYPE_EDIT) // Edit row
			$pago_cliente_grid->EditRowCnt++;
		if ($pago_cliente->CurrentAction == "F") // Confirm row
			$pago_cliente_grid->RestoreCurrentRowFormValues($pago_cliente_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$pago_cliente->RowAttrs = array_merge($pago_cliente->RowAttrs, array('data-rowindex'=>$pago_cliente_grid->RowCnt, 'id'=>'r' . $pago_cliente_grid->RowCnt . '_pago_cliente', 'data-rowtype'=>$pago_cliente->RowType));

		// Render row
		$pago_cliente_grid->RenderRow();

		// Render list options
		$pago_cliente_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($pago_cliente_grid->RowAction <> "delete" && $pago_cliente_grid->RowAction <> "insertdelete" && !($pago_cliente_grid->RowAction == "insert" && $pago_cliente->CurrentAction == "F" && $pago_cliente_grid->EmptyRow())) {
?>
	<tr<?php echo $pago_cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pago_cliente_grid->ListOptions->Render("body", "left", $pago_cliente_grid->RowCnt);
?>
	<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
		<td data-name="idcliente"<?php echo $pago_cliente->idcliente->CellAttributes() ?>>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($pago_cliente->idcliente->getSessionValue() <> "") { ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<select data-field="x_idcliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente"<?php echo $pago_cliente->idcliente->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idcliente->EditValue)) {
	$arwrk = $pago_cliente->idcliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idcliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_cliente->idcliente) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idcliente->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_cliente->Lookup_Selecting($pago_cliente->idcliente, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `codigo`";
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcliente` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->OldValue) ?>">
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($pago_cliente->idcliente->getSessionValue() <> "") { ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<select data-field="x_idcliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente"<?php echo $pago_cliente->idcliente->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idcliente->EditValue)) {
	$arwrk = $pago_cliente->idcliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idcliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_cliente->idcliente) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idcliente->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_cliente->Lookup_Selecting($pago_cliente->idcliente, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `codigo`";
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcliente` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<?php echo $pago_cliente->idcliente->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->FormValue) ?>">
<input type="hidden" data-field="x_idcliente" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->OldValue) ?>">
<?php } ?>
<a id="<?php echo $pago_cliente_grid->PageObjName . "_row_" . $pago_cliente_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idpago_cliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" value="<?php echo ew_HtmlEncode($pago_cliente->idpago_cliente->CurrentValue) ?>">
<input type="hidden" data-field="x_idpago_cliente" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" value="<?php echo ew_HtmlEncode($pago_cliente->idpago_cliente->OldValue) ?>">
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_EDIT || $pago_cliente->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idpago_cliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idpago_cliente" value="<?php echo ew_HtmlEncode($pago_cliente->idpago_cliente->CurrentValue) ?>">
<?php } ?>
	<?php if ($pago_cliente->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $pago_cliente->monto->CellAttributes() ?>>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_monto" class="form-group pago_cliente_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_cliente->monto->PlaceHolder) ?>" value="<?php echo $pago_cliente->monto->EditValue ?>"<?php echo $pago_cliente->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_cliente->monto->OldValue) ?>">
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_monto" class="form-group pago_cliente_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_cliente->monto->PlaceHolder) ?>" value="<?php echo $pago_cliente->monto->EditValue ?>"<?php echo $pago_cliente->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_cliente->monto->ViewAttributes() ?>>
<?php echo $pago_cliente->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_cliente->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_cliente->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $pago_cliente->fecha->CellAttributes() ?>>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_fecha" class="form-group pago_cliente_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_cliente->fecha->PlaceHolder) ?>" value="<?php echo $pago_cliente->fecha->EditValue ?>"<?php echo $pago_cliente->fecha->EditAttributes() ?>>
<?php if (!$pago_cliente->fecha->ReadOnly && !$pago_cliente->fecha->Disabled && @$pago_cliente->fecha->EditAttrs["readonly"] == "" && @$pago_cliente->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_clientegrid", "x<?php echo $pago_cliente_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_cliente->fecha->OldValue) ?>">
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_fecha" class="form-group pago_cliente_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_cliente->fecha->PlaceHolder) ?>" value="<?php echo $pago_cliente->fecha->EditValue ?>"<?php echo $pago_cliente->fecha->EditAttributes() ?>>
<?php if (!$pago_cliente->fecha->ReadOnly && !$pago_cliente->fecha->Disabled && @$pago_cliente->fecha->EditAttrs["readonly"] == "" && @$pago_cliente->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_clientegrid", "x<?php echo $pago_cliente_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_cliente->fecha->ViewAttributes() ?>>
<?php echo $pago_cliente->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_cliente->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_cliente->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $pago_cliente->idsucursal->CellAttributes() ?>>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idsucursal" class="form-group pago_cliente_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal"<?php echo $pago_cliente->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idsucursal->EditValue)) {
	$arwrk = $pago_cliente->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idsucursal->OldValue = "";
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
 $pago_cliente->Lookup_Selecting($pago_cliente->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_cliente->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $pago_cliente_grid->RowCnt ?>_pago_cliente_idsucursal" class="form-group pago_cliente_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal"<?php echo $pago_cliente->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idsucursal->EditValue)) {
	$arwrk = $pago_cliente->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idsucursal->OldValue = "";
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
 $pago_cliente->Lookup_Selecting($pago_cliente->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $pago_cliente->idsucursal->ViewAttributes() ?>>
<?php echo $pago_cliente->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_cliente->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_cliente->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pago_cliente_grid->ListOptions->Render("body", "right", $pago_cliente_grid->RowCnt);
?>
	</tr>
<?php if ($pago_cliente->RowType == EW_ROWTYPE_ADD || $pago_cliente->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpago_clientegrid.UpdateOpts(<?php echo $pago_cliente_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($pago_cliente->CurrentAction <> "gridadd" || $pago_cliente->CurrentMode == "copy")
		if (!$pago_cliente_grid->Recordset->EOF) $pago_cliente_grid->Recordset->MoveNext();
}
?>
<?php
	if ($pago_cliente->CurrentMode == "add" || $pago_cliente->CurrentMode == "copy" || $pago_cliente->CurrentMode == "edit") {
		$pago_cliente_grid->RowIndex = '$rowindex$';
		$pago_cliente_grid->LoadDefaultValues();

		// Set row properties
		$pago_cliente->ResetAttrs();
		$pago_cliente->RowAttrs = array_merge($pago_cliente->RowAttrs, array('data-rowindex'=>$pago_cliente_grid->RowIndex, 'id'=>'r0_pago_cliente', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($pago_cliente->RowAttrs["class"], "ewTemplate");
		$pago_cliente->RowType = EW_ROWTYPE_ADD;

		// Render row
		$pago_cliente_grid->RenderRow();

		// Render list options
		$pago_cliente_grid->RenderListOptions();
		$pago_cliente_grid->StartRowCnt = 0;
?>
	<tr<?php echo $pago_cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pago_cliente_grid->ListOptions->Render("body", "left", $pago_cliente_grid->RowIndex);
?>
	<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
		<td>
<?php if ($pago_cliente->CurrentAction <> "F") { ?>
<?php if ($pago_cliente->idcliente->getSessionValue() <> "") { ?>
<span id="el$rowindex$_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<select data-field="x_idcliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente"<?php echo $pago_cliente->idcliente->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idcliente->EditValue)) {
	$arwrk = $pago_cliente->idcliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idcliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_cliente->idcliente) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idcliente->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $pago_cliente->Lookup_Selecting($pago_cliente->idcliente, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `codigo`";
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcliente` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pago_cliente_idcliente" class="form-group pago_cliente_idcliente">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_cliente->monto->Visible) { // monto ?>
		<td>
<?php if ($pago_cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_cliente_monto" class="form-group pago_cliente_monto">
<input type="text" data-field="x_monto" name="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_cliente->monto->PlaceHolder) ?>" value="<?php echo $pago_cliente->monto->EditValue ?>"<?php echo $pago_cliente->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_cliente_monto" class="form-group pago_cliente_monto">
<span<?php echo $pago_cliente->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="x<?php echo $pago_cliente_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_cliente->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" id="o<?php echo $pago_cliente_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($pago_cliente->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
		<td>
<?php if ($pago_cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_cliente_fecha" class="form-group pago_cliente_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($pago_cliente->fecha->PlaceHolder) ?>" value="<?php echo $pago_cliente->fecha->EditValue ?>"<?php echo $pago_cliente->fecha->EditAttributes() ?>>
<?php if (!$pago_cliente->fecha->ReadOnly && !$pago_cliente->fecha->Disabled && @$pago_cliente->fecha->EditAttrs["readonly"] == "" && @$pago_cliente->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_clientegrid", "x<?php echo $pago_cliente_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_cliente_fecha" class="form-group pago_cliente_fecha">
<span<?php echo $pago_cliente->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="x<?php echo $pago_cliente_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_cliente->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" id="o<?php echo $pago_cliente_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($pago_cliente->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($pago_cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_pago_cliente_idsucursal" class="form-group pago_cliente_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal"<?php echo $pago_cliente->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idsucursal->EditValue)) {
	$arwrk = $pago_cliente->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $pago_cliente->idsucursal->OldValue = "";
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
 $pago_cliente->Lookup_Selecting($pago_cliente->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_pago_cliente_idsucursal" class="form-group pago_cliente_idsucursal">
<span<?php echo $pago_cliente->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="x<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_cliente->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" id="o<?php echo $pago_cliente_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($pago_cliente->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pago_cliente_grid->ListOptions->Render("body", "right", $pago_cliente_grid->RowCnt);
?>
<script type="text/javascript">
fpago_clientegrid.UpdateOpts(<?php echo $pago_cliente_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($pago_cliente->CurrentMode == "add" || $pago_cliente->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $pago_cliente_grid->FormKeyCountName ?>" id="<?php echo $pago_cliente_grid->FormKeyCountName ?>" value="<?php echo $pago_cliente_grid->KeyCount ?>">
<?php echo $pago_cliente_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pago_cliente->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $pago_cliente_grid->FormKeyCountName ?>" id="<?php echo $pago_cliente_grid->FormKeyCountName ?>" value="<?php echo $pago_cliente_grid->KeyCount ?>">
<?php echo $pago_cliente_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($pago_cliente->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpago_clientegrid">
</div>
<?php

// Close recordset
if ($pago_cliente_grid->Recordset)
	$pago_cliente_grid->Recordset->Close();
?>
<?php if ($pago_cliente_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($pago_cliente_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($pago_cliente_grid->TotalRecs == 0 && $pago_cliente->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pago_cliente_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">
fpago_clientegrid.Init();
</script>
<?php } ?>
<?php
$pago_cliente_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$pago_cliente_grid->Page_Terminate();
?>
