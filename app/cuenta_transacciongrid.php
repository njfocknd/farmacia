<?php

// Create page object
if (!isset($cuenta_transaccion_grid)) $cuenta_transaccion_grid = new ccuenta_transaccion_grid();

// Page init
$cuenta_transaccion_grid->Page_Init();

// Page main
$cuenta_transaccion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_transaccion_grid->Page_Render();
?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<script type="text/javascript">

// Page object
var cuenta_transaccion_grid = new ew_Page("cuenta_transaccion_grid");
cuenta_transaccion_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cuenta_transaccion_grid.PageID; // For backward compatibility

// Form object
var fcuenta_transacciongrid = new ew_Form("fcuenta_transacciongrid");
fcuenta_transacciongrid.FormKeyCountName = '<?php echo $cuenta_transaccion_grid->FormKeyCountName ?>';

// Validate form
fcuenta_transacciongrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_transaccion->debito->FldCaption(), $cuenta_transaccion->debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->debito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_transaccion->credito->FldCaption(), $cuenta_transaccion->credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->credito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_referencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->id_referencia->FldErrMsg()) ?>");

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
fcuenta_transacciongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idcuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "descripcion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "debito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "credito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "id_referencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tabla_referencia", false)) return false;
	return true;
}

// Form_CustomValidate event
fcuenta_transacciongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_transacciongrid.ValidateRequired = true;
<?php } else { ?>
fcuenta_transacciongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_transacciongrid.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cuenta_transaccion->CurrentAction == "gridadd") {
	if ($cuenta_transaccion->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cuenta_transaccion_grid->TotalRecs = $cuenta_transaccion->SelectRecordCount();
			$cuenta_transaccion_grid->Recordset = $cuenta_transaccion_grid->LoadRecordset($cuenta_transaccion_grid->StartRec-1, $cuenta_transaccion_grid->DisplayRecs);
		} else {
			if ($cuenta_transaccion_grid->Recordset = $cuenta_transaccion_grid->LoadRecordset())
				$cuenta_transaccion_grid->TotalRecs = $cuenta_transaccion_grid->Recordset->RecordCount();
		}
		$cuenta_transaccion_grid->StartRec = 1;
		$cuenta_transaccion_grid->DisplayRecs = $cuenta_transaccion_grid->TotalRecs;
	} else {
		$cuenta_transaccion->CurrentFilter = "0=1";
		$cuenta_transaccion_grid->StartRec = 1;
		$cuenta_transaccion_grid->DisplayRecs = $cuenta_transaccion->GridAddRowCount;
	}
	$cuenta_transaccion_grid->TotalRecs = $cuenta_transaccion_grid->DisplayRecs;
	$cuenta_transaccion_grid->StopRec = $cuenta_transaccion_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cuenta_transaccion_grid->TotalRecs = $cuenta_transaccion->SelectRecordCount();
	} else {
		if ($cuenta_transaccion_grid->Recordset = $cuenta_transaccion_grid->LoadRecordset())
			$cuenta_transaccion_grid->TotalRecs = $cuenta_transaccion_grid->Recordset->RecordCount();
	}
	$cuenta_transaccion_grid->StartRec = 1;
	$cuenta_transaccion_grid->DisplayRecs = $cuenta_transaccion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cuenta_transaccion_grid->Recordset = $cuenta_transaccion_grid->LoadRecordset($cuenta_transaccion_grid->StartRec-1, $cuenta_transaccion_grid->DisplayRecs);

	// Set no record found message
	if ($cuenta_transaccion->CurrentAction == "" && $cuenta_transaccion_grid->TotalRecs == 0) {
		if ($cuenta_transaccion_grid->SearchWhere == "0=101")
			$cuenta_transaccion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cuenta_transaccion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cuenta_transaccion_grid->RenderOtherOptions();
?>
<?php $cuenta_transaccion_grid->ShowPageHeader(); ?>
<?php
$cuenta_transaccion_grid->ShowMessage();
?>
<?php if ($cuenta_transaccion_grid->TotalRecs > 0 || $cuenta_transaccion->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fcuenta_transacciongrid" class="ewForm form-inline">
<div id="gmp_cuenta_transaccion" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_cuenta_transacciongrid" class="table ewTable">
<?php echo $cuenta_transaccion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cuenta_transaccion_grid->RenderListOptions();

// Render list options (header, left)
$cuenta_transaccion_grid->ListOptions->Render("header", "left");
?>
<?php if ($cuenta_transaccion->idcuenta->Visible) { // idcuenta ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->idcuenta) == "") { ?>
		<th data-name="idcuenta"><div id="elh_cuenta_transaccion_idcuenta" class="cuenta_transaccion_idcuenta"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->idcuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta"><div><div id="elh_cuenta_transaccion_idcuenta" class="cuenta_transaccion_idcuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->idcuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->idcuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->idcuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->fecha->Visible) { // fecha ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_cuenta_transaccion_fecha" class="cuenta_transaccion_fecha"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_cuenta_transaccion_fecha" class="cuenta_transaccion_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->descripcion->Visible) { // descripcion ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->descripcion) == "") { ?>
		<th data-name="descripcion"><div id="elh_cuenta_transaccion_descripcion" class="cuenta_transaccion_descripcion"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->descripcion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descripcion"><div><div id="elh_cuenta_transaccion_descripcion" class="cuenta_transaccion_descripcion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->descripcion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->descripcion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->descripcion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->debito->Visible) { // debito ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->debito) == "") { ?>
		<th data-name="debito"><div id="elh_cuenta_transaccion_debito" class="cuenta_transaccion_debito"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->debito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="debito"><div><div id="elh_cuenta_transaccion_debito" class="cuenta_transaccion_debito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->debito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->debito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->debito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->credito->Visible) { // credito ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->credito) == "") { ?>
		<th data-name="credito"><div id="elh_cuenta_transaccion_credito" class="cuenta_transaccion_credito"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->credito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="credito"><div><div id="elh_cuenta_transaccion_credito" class="cuenta_transaccion_credito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->credito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->credito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->credito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->id_referencia->Visible) { // id_referencia ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->id_referencia) == "") { ?>
		<th data-name="id_referencia"><div id="elh_cuenta_transaccion_id_referencia" class="cuenta_transaccion_id_referencia"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->id_referencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_referencia"><div><div id="elh_cuenta_transaccion_id_referencia" class="cuenta_transaccion_id_referencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->id_referencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->id_referencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->id_referencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_transaccion->tabla_referencia->Visible) { // tabla_referencia ?>
	<?php if ($cuenta_transaccion->SortUrl($cuenta_transaccion->tabla_referencia) == "") { ?>
		<th data-name="tabla_referencia"><div id="elh_cuenta_transaccion_tabla_referencia" class="cuenta_transaccion_tabla_referencia"><div class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->tabla_referencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tabla_referencia"><div><div id="elh_cuenta_transaccion_tabla_referencia" class="cuenta_transaccion_tabla_referencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_transaccion->tabla_referencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_transaccion->tabla_referencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_transaccion->tabla_referencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cuenta_transaccion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cuenta_transaccion_grid->StartRec = 1;
$cuenta_transaccion_grid->StopRec = $cuenta_transaccion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cuenta_transaccion_grid->FormKeyCountName) && ($cuenta_transaccion->CurrentAction == "gridadd" || $cuenta_transaccion->CurrentAction == "gridedit" || $cuenta_transaccion->CurrentAction == "F")) {
		$cuenta_transaccion_grid->KeyCount = $objForm->GetValue($cuenta_transaccion_grid->FormKeyCountName);
		$cuenta_transaccion_grid->StopRec = $cuenta_transaccion_grid->StartRec + $cuenta_transaccion_grid->KeyCount - 1;
	}
}
$cuenta_transaccion_grid->RecCnt = $cuenta_transaccion_grid->StartRec - 1;
if ($cuenta_transaccion_grid->Recordset && !$cuenta_transaccion_grid->Recordset->EOF) {
	$cuenta_transaccion_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $cuenta_transaccion_grid->StartRec > 1)
		$cuenta_transaccion_grid->Recordset->Move($cuenta_transaccion_grid->StartRec - 1);
} elseif (!$cuenta_transaccion->AllowAddDeleteRow && $cuenta_transaccion_grid->StopRec == 0) {
	$cuenta_transaccion_grid->StopRec = $cuenta_transaccion->GridAddRowCount;
}

// Initialize aggregate
$cuenta_transaccion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cuenta_transaccion->ResetAttrs();
$cuenta_transaccion_grid->RenderRow();
if ($cuenta_transaccion->CurrentAction == "gridadd")
	$cuenta_transaccion_grid->RowIndex = 0;
if ($cuenta_transaccion->CurrentAction == "gridedit")
	$cuenta_transaccion_grid->RowIndex = 0;
while ($cuenta_transaccion_grid->RecCnt < $cuenta_transaccion_grid->StopRec) {
	$cuenta_transaccion_grid->RecCnt++;
	if (intval($cuenta_transaccion_grid->RecCnt) >= intval($cuenta_transaccion_grid->StartRec)) {
		$cuenta_transaccion_grid->RowCnt++;
		if ($cuenta_transaccion->CurrentAction == "gridadd" || $cuenta_transaccion->CurrentAction == "gridedit" || $cuenta_transaccion->CurrentAction == "F") {
			$cuenta_transaccion_grid->RowIndex++;
			$objForm->Index = $cuenta_transaccion_grid->RowIndex;
			if ($objForm->HasValue($cuenta_transaccion_grid->FormActionName))
				$cuenta_transaccion_grid->RowAction = strval($objForm->GetValue($cuenta_transaccion_grid->FormActionName));
			elseif ($cuenta_transaccion->CurrentAction == "gridadd")
				$cuenta_transaccion_grid->RowAction = "insert";
			else
				$cuenta_transaccion_grid->RowAction = "";
		}

		// Set up key count
		$cuenta_transaccion_grid->KeyCount = $cuenta_transaccion_grid->RowIndex;

		// Init row class and style
		$cuenta_transaccion->ResetAttrs();
		$cuenta_transaccion->CssClass = "";
		if ($cuenta_transaccion->CurrentAction == "gridadd") {
			if ($cuenta_transaccion->CurrentMode == "copy") {
				$cuenta_transaccion_grid->LoadRowValues($cuenta_transaccion_grid->Recordset); // Load row values
				$cuenta_transaccion_grid->SetRecordKey($cuenta_transaccion_grid->RowOldKey, $cuenta_transaccion_grid->Recordset); // Set old record key
			} else {
				$cuenta_transaccion_grid->LoadDefaultValues(); // Load default values
				$cuenta_transaccion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cuenta_transaccion_grid->LoadRowValues($cuenta_transaccion_grid->Recordset); // Load row values
		}
		$cuenta_transaccion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cuenta_transaccion->CurrentAction == "gridadd") // Grid add
			$cuenta_transaccion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cuenta_transaccion->CurrentAction == "gridadd" && $cuenta_transaccion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cuenta_transaccion_grid->RestoreCurrentRowFormValues($cuenta_transaccion_grid->RowIndex); // Restore form values
		if ($cuenta_transaccion->CurrentAction == "gridedit") { // Grid edit
			if ($cuenta_transaccion->EventCancelled) {
				$cuenta_transaccion_grid->RestoreCurrentRowFormValues($cuenta_transaccion_grid->RowIndex); // Restore form values
			}
			if ($cuenta_transaccion_grid->RowAction == "insert")
				$cuenta_transaccion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cuenta_transaccion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cuenta_transaccion->CurrentAction == "gridedit" && ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT || $cuenta_transaccion->RowType == EW_ROWTYPE_ADD) && $cuenta_transaccion->EventCancelled) // Update failed
			$cuenta_transaccion_grid->RestoreCurrentRowFormValues($cuenta_transaccion_grid->RowIndex); // Restore form values
		if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cuenta_transaccion_grid->EditRowCnt++;
		if ($cuenta_transaccion->CurrentAction == "F") // Confirm row
			$cuenta_transaccion_grid->RestoreCurrentRowFormValues($cuenta_transaccion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cuenta_transaccion->RowAttrs = array_merge($cuenta_transaccion->RowAttrs, array('data-rowindex'=>$cuenta_transaccion_grid->RowCnt, 'id'=>'r' . $cuenta_transaccion_grid->RowCnt . '_cuenta_transaccion', 'data-rowtype'=>$cuenta_transaccion->RowType));

		// Render row
		$cuenta_transaccion_grid->RenderRow();

		// Render list options
		$cuenta_transaccion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cuenta_transaccion_grid->RowAction <> "delete" && $cuenta_transaccion_grid->RowAction <> "insertdelete" && !($cuenta_transaccion_grid->RowAction == "insert" && $cuenta_transaccion->CurrentAction == "F" && $cuenta_transaccion_grid->EmptyRow())) {
?>
	<tr<?php echo $cuenta_transaccion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_transaccion_grid->ListOptions->Render("body", "left", $cuenta_transaccion_grid->RowCnt);
?>
	<?php if ($cuenta_transaccion->idcuenta->Visible) { // idcuenta ?>
		<td data-name="idcuenta"<?php echo $cuenta_transaccion->idcuenta->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cuenta_transaccion->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta"<?php echo $cuenta_transaccion->idcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_transaccion->idcuenta->EditValue)) {
	$arwrk = $cuenta_transaccion->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_transaccion->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta_transaccion->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_transaccion->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta_transaccion->Lookup_Selecting($cuenta_transaccion->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cuenta_transaccion->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta"<?php echo $cuenta_transaccion->idcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_transaccion->idcuenta->EditValue)) {
	$arwrk = $cuenta_transaccion->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_transaccion->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta_transaccion->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_transaccion->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta_transaccion->Lookup_Selecting($cuenta_transaccion->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->idcuenta->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->FormValue) ?>">
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cuenta_transaccion_grid->PageObjName . "_row_" . $cuenta_transaccion_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcuenta_transaccion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta_transaccion->CurrentValue) ?>">
<input type="hidden" data-field="x_idcuenta_transaccion" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta_transaccion->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT || $cuenta_transaccion->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcuenta_transaccion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta_transaccion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta_transaccion->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta_transaccion->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $cuenta_transaccion->fecha->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_fecha" class="form-group cuenta_transaccion_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->fecha->EditValue ?>"<?php echo $cuenta_transaccion->fecha->EditAttributes() ?>>
<?php if (!$cuenta_transaccion->fecha->ReadOnly && !$cuenta_transaccion->fecha->Disabled && @$cuenta_transaccion->fecha->EditAttrs["readonly"] == "" && @$cuenta_transaccion->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcuenta_transacciongrid", "x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_fecha" class="form-group cuenta_transaccion_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->fecha->EditValue ?>"<?php echo $cuenta_transaccion->fecha->EditAttributes() ?>>
<?php if (!$cuenta_transaccion->fecha->ReadOnly && !$cuenta_transaccion->fecha->Disabled && @$cuenta_transaccion->fecha->EditAttrs["readonly"] == "" && @$cuenta_transaccion->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcuenta_transacciongrid", "x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->fecha->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->descripcion->Visible) { // descripcion ?>
		<td data-name="descripcion"<?php echo $cuenta_transaccion->descripcion->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_descripcion" class="form-group cuenta_transaccion_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->descripcion->EditValue ?>"<?php echo $cuenta_transaccion->descripcion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_descripcion" class="form-group cuenta_transaccion_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->descripcion->EditValue ?>"<?php echo $cuenta_transaccion->descripcion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->descripcion->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->descripcion->ListViewValue() ?></span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->FormValue) ?>">
<input type="hidden" data-field="x_descripcion" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->debito->Visible) { // debito ?>
		<td data-name="debito"<?php echo $cuenta_transaccion->debito->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_debito" class="form-group cuenta_transaccion_debito">
<input type="text" data-field="x_debito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->debito->EditValue ?>"<?php echo $cuenta_transaccion->debito->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_debito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_debito" class="form-group cuenta_transaccion_debito">
<input type="text" data-field="x_debito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->debito->EditValue ?>"<?php echo $cuenta_transaccion->debito->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->debito->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->debito->ListViewValue() ?></span>
<input type="hidden" data-field="x_debito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->FormValue) ?>">
<input type="hidden" data-field="x_debito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->credito->Visible) { // credito ?>
		<td data-name="credito"<?php echo $cuenta_transaccion->credito->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_credito" class="form-group cuenta_transaccion_credito">
<input type="text" data-field="x_credito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->credito->EditValue ?>"<?php echo $cuenta_transaccion->credito->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_credito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_credito" class="form-group cuenta_transaccion_credito">
<input type="text" data-field="x_credito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->credito->EditValue ?>"<?php echo $cuenta_transaccion->credito->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->credito->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->credito->ListViewValue() ?></span>
<input type="hidden" data-field="x_credito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->FormValue) ?>">
<input type="hidden" data-field="x_credito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->id_referencia->Visible) { // id_referencia ?>
		<td data-name="id_referencia"<?php echo $cuenta_transaccion->id_referencia->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_id_referencia" class="form-group cuenta_transaccion_id_referencia">
<input type="text" data-field="x_id_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->id_referencia->EditValue ?>"<?php echo $cuenta_transaccion->id_referencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_id_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_id_referencia" class="form-group cuenta_transaccion_id_referencia">
<input type="text" data-field="x_id_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->id_referencia->EditValue ?>"<?php echo $cuenta_transaccion->id_referencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->id_referencia->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->id_referencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_id_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->FormValue) ?>">
<input type="hidden" data-field="x_id_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->tabla_referencia->Visible) { // tabla_referencia ?>
		<td data-name="tabla_referencia"<?php echo $cuenta_transaccion->tabla_referencia->CellAttributes() ?>>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_tabla_referencia" class="form-group cuenta_transaccion_tabla_referencia">
<input type="text" data-field="x_tabla_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->tabla_referencia->EditValue ?>"<?php echo $cuenta_transaccion->tabla_referencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_tabla_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_transaccion_grid->RowCnt ?>_cuenta_transaccion_tabla_referencia" class="form-group cuenta_transaccion_tabla_referencia">
<input type="text" data-field="x_tabla_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->tabla_referencia->EditValue ?>"<?php echo $cuenta_transaccion->tabla_referencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_transaccion->tabla_referencia->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->tabla_referencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_tabla_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->FormValue) ?>">
<input type="hidden" data-field="x_tabla_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_transaccion_grid->ListOptions->Render("body", "right", $cuenta_transaccion_grid->RowCnt);
?>
	</tr>
<?php if ($cuenta_transaccion->RowType == EW_ROWTYPE_ADD || $cuenta_transaccion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcuenta_transacciongrid.UpdateOpts(<?php echo $cuenta_transaccion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cuenta_transaccion->CurrentAction <> "gridadd" || $cuenta_transaccion->CurrentMode == "copy")
		if (!$cuenta_transaccion_grid->Recordset->EOF) $cuenta_transaccion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cuenta_transaccion->CurrentMode == "add" || $cuenta_transaccion->CurrentMode == "copy" || $cuenta_transaccion->CurrentMode == "edit") {
		$cuenta_transaccion_grid->RowIndex = '$rowindex$';
		$cuenta_transaccion_grid->LoadDefaultValues();

		// Set row properties
		$cuenta_transaccion->ResetAttrs();
		$cuenta_transaccion->RowAttrs = array_merge($cuenta_transaccion->RowAttrs, array('data-rowindex'=>$cuenta_transaccion_grid->RowIndex, 'id'=>'r0_cuenta_transaccion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cuenta_transaccion->RowAttrs["class"], "ewTemplate");
		$cuenta_transaccion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cuenta_transaccion_grid->RenderRow();

		// Render list options
		$cuenta_transaccion_grid->RenderListOptions();
		$cuenta_transaccion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cuenta_transaccion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_transaccion_grid->ListOptions->Render("body", "left", $cuenta_transaccion_grid->RowIndex);
?>
	<?php if ($cuenta_transaccion->idcuenta->Visible) { // idcuenta ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<?php if ($cuenta_transaccion->idcuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta"<?php echo $cuenta_transaccion->idcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_transaccion->idcuenta->EditValue)) {
	$arwrk = $cuenta_transaccion->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_transaccion->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta_transaccion->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_transaccion->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cuenta_transaccion->Lookup_Selecting($cuenta_transaccion->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_idcuenta" class="form-group cuenta_transaccion_idcuenta">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->fecha->Visible) { // fecha ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_fecha" class="form-group cuenta_transaccion_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->fecha->EditValue ?>"<?php echo $cuenta_transaccion->fecha->EditAttributes() ?>>
<?php if (!$cuenta_transaccion->fecha->ReadOnly && !$cuenta_transaccion->fecha->Disabled && @$cuenta_transaccion->fecha->EditAttrs["readonly"] == "" && @$cuenta_transaccion->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcuenta_transacciongrid", "x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_fecha" class="form-group cuenta_transaccion_fecha">
<span<?php echo $cuenta_transaccion->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->descripcion->Visible) { // descripcion ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_descripcion" class="form-group cuenta_transaccion_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->descripcion->EditValue ?>"<?php echo $cuenta_transaccion->descripcion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_descripcion" class="form-group cuenta_transaccion_descripcion">
<span<?php echo $cuenta_transaccion->descripcion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->descripcion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->debito->Visible) { // debito ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_debito" class="form-group cuenta_transaccion_debito">
<input type="text" data-field="x_debito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->debito->EditValue ?>"<?php echo $cuenta_transaccion->debito->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_debito" class="form-group cuenta_transaccion_debito">
<span<?php echo $cuenta_transaccion->debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->debito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_debito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_debito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_debito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->credito->Visible) { // credito ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_credito" class="form-group cuenta_transaccion_credito">
<input type="text" data-field="x_credito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->credito->EditValue ?>"<?php echo $cuenta_transaccion->credito->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_credito" class="form-group cuenta_transaccion_credito">
<span<?php echo $cuenta_transaccion->credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->credito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_credito" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_credito" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_credito" value="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->id_referencia->Visible) { // id_referencia ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_id_referencia" class="form-group cuenta_transaccion_id_referencia">
<input type="text" data-field="x_id_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->id_referencia->EditValue ?>"<?php echo $cuenta_transaccion->id_referencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_id_referencia" class="form-group cuenta_transaccion_id_referencia">
<span<?php echo $cuenta_transaccion->id_referencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->id_referencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_id_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_id_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->id_referencia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_transaccion->tabla_referencia->Visible) { // tabla_referencia ?>
		<td>
<?php if ($cuenta_transaccion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_transaccion_tabla_referencia" class="form-group cuenta_transaccion_tabla_referencia">
<input type="text" data-field="x_tabla_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->tabla_referencia->EditValue ?>"<?php echo $cuenta_transaccion->tabla_referencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_transaccion_tabla_referencia" class="form-group cuenta_transaccion_tabla_referencia">
<span<?php echo $cuenta_transaccion->tabla_referencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->tabla_referencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_tabla_referencia" name="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_tabla_referencia" name="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $cuenta_transaccion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($cuenta_transaccion->tabla_referencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_transaccion_grid->ListOptions->Render("body", "right", $cuenta_transaccion_grid->RowCnt);
?>
<script type="text/javascript">
fcuenta_transacciongrid.UpdateOpts(<?php echo $cuenta_transaccion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cuenta_transaccion->CurrentMode == "add" || $cuenta_transaccion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cuenta_transaccion_grid->FormKeyCountName ?>" id="<?php echo $cuenta_transaccion_grid->FormKeyCountName ?>" value="<?php echo $cuenta_transaccion_grid->KeyCount ?>">
<?php echo $cuenta_transaccion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_transaccion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cuenta_transaccion_grid->FormKeyCountName ?>" id="<?php echo $cuenta_transaccion_grid->FormKeyCountName ?>" value="<?php echo $cuenta_transaccion_grid->KeyCount ?>">
<?php echo $cuenta_transaccion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_transaccion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcuenta_transacciongrid">
</div>
<?php

// Close recordset
if ($cuenta_transaccion_grid->Recordset)
	$cuenta_transaccion_grid->Recordset->Close();
?>
<?php if ($cuenta_transaccion_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($cuenta_transaccion_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cuenta_transaccion_grid->TotalRecs == 0 && $cuenta_transaccion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_transaccion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<script type="text/javascript">
fcuenta_transacciongrid.Init();
</script>
<?php } ?>
<?php
$cuenta_transaccion_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cuenta_transaccion_grid->Page_Terminate();
?>
