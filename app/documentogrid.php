<?php

// Create page object
if (!isset($documento_grid)) $documento_grid = new cdocumento_grid();

// Page init
$documento_grid->Page_Init();

// Page main
$documento_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_grid->Page_Render();
?>
<?php if ($documento->Export == "") { ?>
<script type="text/javascript">

// Page object
var documento_grid = new ew_Page("documento_grid");
documento_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = documento_grid.PageID; // For backward compatibility

// Form object
var fdocumentogrid = new ew_Form("fdocumentogrid");
fdocumentogrid.FormKeyCountName = '<?php echo $documento_grid->FormKeyCountName ?>';

// Validate form
fdocumentogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->idtipo_documento->FldCaption(), $documento->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->idsucursal->FldCaption(), $documento->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->correlativo->FldCaption(), $documento->correlativo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento->correlativo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->estado_documento->FldCaption(), $documento->estado_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->monto->FldCaption(), $documento->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento->fecha_insercion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento->idcliente->FldCaption(), $documento->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento->idcliente->FldErrMsg()) ?>");

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
fdocumentogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idtipo_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "serie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "correlativo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcliente", false)) return false;
	return true;
}

// Form_CustomValidate event
fdocumentogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumentogrid.ValidateRequired = true;
<?php } else { ?>
fdocumentogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumentogrid.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumentogrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($documento->CurrentAction == "gridadd") {
	if ($documento->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$documento_grid->TotalRecs = $documento->SelectRecordCount();
			$documento_grid->Recordset = $documento_grid->LoadRecordset($documento_grid->StartRec-1, $documento_grid->DisplayRecs);
		} else {
			if ($documento_grid->Recordset = $documento_grid->LoadRecordset())
				$documento_grid->TotalRecs = $documento_grid->Recordset->RecordCount();
		}
		$documento_grid->StartRec = 1;
		$documento_grid->DisplayRecs = $documento_grid->TotalRecs;
	} else {
		$documento->CurrentFilter = "0=1";
		$documento_grid->StartRec = 1;
		$documento_grid->DisplayRecs = $documento->GridAddRowCount;
	}
	$documento_grid->TotalRecs = $documento_grid->DisplayRecs;
	$documento_grid->StopRec = $documento_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$documento_grid->TotalRecs = $documento->SelectRecordCount();
	} else {
		if ($documento_grid->Recordset = $documento_grid->LoadRecordset())
			$documento_grid->TotalRecs = $documento_grid->Recordset->RecordCount();
	}
	$documento_grid->StartRec = 1;
	$documento_grid->DisplayRecs = $documento_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$documento_grid->Recordset = $documento_grid->LoadRecordset($documento_grid->StartRec-1, $documento_grid->DisplayRecs);

	// Set no record found message
	if ($documento->CurrentAction == "" && $documento_grid->TotalRecs == 0) {
		if ($documento_grid->SearchWhere == "0=101")
			$documento_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$documento_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$documento_grid->RenderOtherOptions();
?>
<?php $documento_grid->ShowPageHeader(); ?>
<?php
$documento_grid->ShowMessage();
?>
<?php if ($documento_grid->TotalRecs > 0 || $documento->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdocumentogrid" class="ewForm form-inline">
<div id="gmp_documento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_documentogrid" class="table ewTable">
<?php echo $documento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$documento_grid->RenderListOptions();

// Render list options (header, left)
$documento_grid->ListOptions->Render("header", "left");
?>
<?php if ($documento->idtipo_documento->Visible) { // idtipo_documento ?>
	<?php if ($documento->SortUrl($documento->idtipo_documento) == "") { ?>
		<th data-name="idtipo_documento"><div id="elh_documento_idtipo_documento" class="documento_idtipo_documento"><div class="ewTableHeaderCaption"><?php echo $documento->idtipo_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_documento"><div><div id="elh_documento_idtipo_documento" class="documento_idtipo_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->idtipo_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->idtipo_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->idtipo_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->idsucursal->Visible) { // idsucursal ?>
	<?php if ($documento->SortUrl($documento->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_documento_idsucursal" class="documento_idsucursal"><div class="ewTableHeaderCaption"><?php echo $documento->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_documento_idsucursal" class="documento_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->serie->Visible) { // serie ?>
	<?php if ($documento->SortUrl($documento->serie) == "") { ?>
		<th data-name="serie"><div id="elh_documento_serie" class="documento_serie"><div class="ewTableHeaderCaption"><?php echo $documento->serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="serie"><div><div id="elh_documento_serie" class="documento_serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->serie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->correlativo->Visible) { // correlativo ?>
	<?php if ($documento->SortUrl($documento->correlativo) == "") { ?>
		<th data-name="correlativo"><div id="elh_documento_correlativo" class="documento_correlativo"><div class="ewTableHeaderCaption"><?php echo $documento->correlativo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="correlativo"><div><div id="elh_documento_correlativo" class="documento_correlativo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->correlativo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->correlativo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->correlativo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->fecha->Visible) { // fecha ?>
	<?php if ($documento->SortUrl($documento->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_documento_fecha" class="documento_fecha"><div class="ewTableHeaderCaption"><?php echo $documento->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_documento_fecha" class="documento_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->nombre->Visible) { // nombre ?>
	<?php if ($documento->SortUrl($documento->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_documento_nombre" class="documento_nombre"><div class="ewTableHeaderCaption"><?php echo $documento->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_documento_nombre" class="documento_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->estado_documento->Visible) { // estado_documento ?>
	<?php if ($documento->SortUrl($documento->estado_documento) == "") { ?>
		<th data-name="estado_documento"><div id="elh_documento_estado_documento" class="documento_estado_documento"><div class="ewTableHeaderCaption"><?php echo $documento->estado_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento"><div><div id="elh_documento_estado_documento" class="documento_estado_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->estado_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->estado_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->estado_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->monto->Visible) { // monto ?>
	<?php if ($documento->SortUrl($documento->monto) == "") { ?>
		<th data-name="monto"><div id="elh_documento_monto" class="documento_monto"><div class="ewTableHeaderCaption"><?php echo $documento->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_documento_monto" class="documento_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($documento->SortUrl($documento->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_documento_fecha_insercion" class="documento_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $documento->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_documento_fecha_insercion" class="documento_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento->idcliente->Visible) { // idcliente ?>
	<?php if ($documento->SortUrl($documento->idcliente) == "") { ?>
		<th data-name="idcliente"><div id="elh_documento_idcliente" class="documento_idcliente"><div class="ewTableHeaderCaption"><?php echo $documento->idcliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcliente"><div><div id="elh_documento_idcliente" class="documento_idcliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento->idcliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento->idcliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento->idcliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$documento_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$documento_grid->StartRec = 1;
$documento_grid->StopRec = $documento_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($documento_grid->FormKeyCountName) && ($documento->CurrentAction == "gridadd" || $documento->CurrentAction == "gridedit" || $documento->CurrentAction == "F")) {
		$documento_grid->KeyCount = $objForm->GetValue($documento_grid->FormKeyCountName);
		$documento_grid->StopRec = $documento_grid->StartRec + $documento_grid->KeyCount - 1;
	}
}
$documento_grid->RecCnt = $documento_grid->StartRec - 1;
if ($documento_grid->Recordset && !$documento_grid->Recordset->EOF) {
	$documento_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $documento_grid->StartRec > 1)
		$documento_grid->Recordset->Move($documento_grid->StartRec - 1);
} elseif (!$documento->AllowAddDeleteRow && $documento_grid->StopRec == 0) {
	$documento_grid->StopRec = $documento->GridAddRowCount;
}

// Initialize aggregate
$documento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$documento->ResetAttrs();
$documento_grid->RenderRow();
if ($documento->CurrentAction == "gridadd")
	$documento_grid->RowIndex = 0;
if ($documento->CurrentAction == "gridedit")
	$documento_grid->RowIndex = 0;
while ($documento_grid->RecCnt < $documento_grid->StopRec) {
	$documento_grid->RecCnt++;
	if (intval($documento_grid->RecCnt) >= intval($documento_grid->StartRec)) {
		$documento_grid->RowCnt++;
		if ($documento->CurrentAction == "gridadd" || $documento->CurrentAction == "gridedit" || $documento->CurrentAction == "F") {
			$documento_grid->RowIndex++;
			$objForm->Index = $documento_grid->RowIndex;
			if ($objForm->HasValue($documento_grid->FormActionName))
				$documento_grid->RowAction = strval($objForm->GetValue($documento_grid->FormActionName));
			elseif ($documento->CurrentAction == "gridadd")
				$documento_grid->RowAction = "insert";
			else
				$documento_grid->RowAction = "";
		}

		// Set up key count
		$documento_grid->KeyCount = $documento_grid->RowIndex;

		// Init row class and style
		$documento->ResetAttrs();
		$documento->CssClass = "";
		if ($documento->CurrentAction == "gridadd") {
			if ($documento->CurrentMode == "copy") {
				$documento_grid->LoadRowValues($documento_grid->Recordset); // Load row values
				$documento_grid->SetRecordKey($documento_grid->RowOldKey, $documento_grid->Recordset); // Set old record key
			} else {
				$documento_grid->LoadDefaultValues(); // Load default values
				$documento_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$documento_grid->LoadRowValues($documento_grid->Recordset); // Load row values
		}
		$documento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($documento->CurrentAction == "gridadd") // Grid add
			$documento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($documento->CurrentAction == "gridadd" && $documento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$documento_grid->RestoreCurrentRowFormValues($documento_grid->RowIndex); // Restore form values
		if ($documento->CurrentAction == "gridedit") { // Grid edit
			if ($documento->EventCancelled) {
				$documento_grid->RestoreCurrentRowFormValues($documento_grid->RowIndex); // Restore form values
			}
			if ($documento_grid->RowAction == "insert")
				$documento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$documento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($documento->CurrentAction == "gridedit" && ($documento->RowType == EW_ROWTYPE_EDIT || $documento->RowType == EW_ROWTYPE_ADD) && $documento->EventCancelled) // Update failed
			$documento_grid->RestoreCurrentRowFormValues($documento_grid->RowIndex); // Restore form values
		if ($documento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$documento_grid->EditRowCnt++;
		if ($documento->CurrentAction == "F") // Confirm row
			$documento_grid->RestoreCurrentRowFormValues($documento_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$documento->RowAttrs = array_merge($documento->RowAttrs, array('data-rowindex'=>$documento_grid->RowCnt, 'id'=>'r' . $documento_grid->RowCnt . '_documento', 'data-rowtype'=>$documento->RowType));

		// Render row
		$documento_grid->RenderRow();

		// Render list options
		$documento_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($documento_grid->RowAction <> "delete" && $documento_grid->RowAction <> "insertdelete" && !($documento_grid->RowAction == "insert" && $documento->CurrentAction == "F" && $documento_grid->EmptyRow())) {
?>
	<tr<?php echo $documento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_grid->ListOptions->Render("body", "left", $documento_grid->RowCnt);
?>
	<?php if ($documento->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento"<?php echo $documento->idtipo_documento->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($documento->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento"<?php echo $documento->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento->idtipo_documento->EditValue)) {
	$arwrk = $documento->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento->Lookup_Selecting($documento->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documento->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento"<?php echo $documento->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento->idtipo_documento->EditValue)) {
	$arwrk = $documento->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento->Lookup_Selecting($documento->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento->idtipo_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->FormValue) ?>">
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->OldValue) ?>">
<?php } ?>
<a id="<?php echo $documento_grid->PageObjName . "_row_" . $documento_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddocumento" name="x<?php echo $documento_grid->RowIndex ?>_iddocumento" id="x<?php echo $documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($documento->iddocumento->CurrentValue) ?>">
<input type="hidden" data-field="x_iddocumento" name="o<?php echo $documento_grid->RowIndex ?>_iddocumento" id="o<?php echo $documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($documento->iddocumento->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT || $documento->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddocumento" name="x<?php echo $documento_grid->RowIndex ?>_iddocumento" id="x<?php echo $documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($documento->iddocumento->CurrentValue) ?>">
<?php } ?>
	<?php if ($documento->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $documento->idsucursal->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($documento->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idsucursal" class="form-group documento_idsucursal">
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idsucursal" class="form-group documento_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal"<?php echo $documento->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento->idsucursal->EditValue)) {
	$arwrk = $documento->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idsucursal->OldValue = "";
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
 $documento->Lookup_Selecting($documento->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documento->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idsucursal" class="form-group documento_idsucursal">
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idsucursal" class="form-group documento_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal"<?php echo $documento->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento->idsucursal->EditValue)) {
	$arwrk = $documento->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idsucursal->OldValue = "";
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
 $documento->Lookup_Selecting($documento->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<?php echo $documento->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->serie->Visible) { // serie ?>
		<td data-name="serie"<?php echo $documento->serie->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_serie" class="form-group documento_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_grid->RowIndex ?>_serie" id="x<?php echo $documento_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->serie->PlaceHolder) ?>" value="<?php echo $documento->serie->EditValue ?>"<?php echo $documento->serie->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_grid->RowIndex ?>_serie" id="o<?php echo $documento_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento->serie->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_serie" class="form-group documento_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_grid->RowIndex ?>_serie" id="x<?php echo $documento_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->serie->PlaceHolder) ?>" value="<?php echo $documento->serie->EditValue ?>"<?php echo $documento->serie->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->serie->ViewAttributes() ?>>
<?php echo $documento->serie->ListViewValue() ?></span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_grid->RowIndex ?>_serie" id="x<?php echo $documento_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento->serie->FormValue) ?>">
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_grid->RowIndex ?>_serie" id="o<?php echo $documento_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento->serie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->correlativo->Visible) { // correlativo ?>
		<td data-name="correlativo"<?php echo $documento->correlativo->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_correlativo" class="form-group documento_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento->correlativo->PlaceHolder) ?>" value="<?php echo $documento->correlativo->EditValue ?>"<?php echo $documento->correlativo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento->correlativo->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_correlativo" class="form-group documento_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento->correlativo->PlaceHolder) ?>" value="<?php echo $documento->correlativo->EditValue ?>"<?php echo $documento->correlativo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->correlativo->ViewAttributes() ?>>
<?php echo $documento->correlativo->ListViewValue() ?></span>
<input type="hidden" data-field="x_correlativo" name="x<?php echo $documento_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento->correlativo->FormValue) ?>">
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento->correlativo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $documento->fecha->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_fecha" class="form-group documento_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_grid->RowIndex ?>_fecha" id="x<?php echo $documento_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento->fecha->PlaceHolder) ?>" value="<?php echo $documento->fecha->EditValue ?>"<?php echo $documento->fecha->EditAttributes() ?>>
<?php if (!$documento->fecha->ReadOnly && !$documento->fecha->Disabled && @$documento->fecha->EditAttrs["readonly"] == "" && @$documento->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumentogrid", "x<?php echo $documento_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_grid->RowIndex ?>_fecha" id="o<?php echo $documento_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento->fecha->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_fecha" class="form-group documento_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_grid->RowIndex ?>_fecha" id="x<?php echo $documento_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento->fecha->PlaceHolder) ?>" value="<?php echo $documento->fecha->EditValue ?>"<?php echo $documento->fecha->EditAttributes() ?>>
<?php if (!$documento->fecha->ReadOnly && !$documento->fecha->Disabled && @$documento->fecha->EditAttrs["readonly"] == "" && @$documento->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumentogrid", "x<?php echo $documento_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->fecha->ViewAttributes() ?>>
<?php echo $documento->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_grid->RowIndex ?>_fecha" id="x<?php echo $documento_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_grid->RowIndex ?>_fecha" id="o<?php echo $documento_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $documento->nombre->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_nombre" class="form-group documento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_grid->RowIndex ?>_nombre" id="x<?php echo $documento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->nombre->PlaceHolder) ?>" value="<?php echo $documento->nombre->EditValue ?>"<?php echo $documento->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_grid->RowIndex ?>_nombre" id="o<?php echo $documento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento->nombre->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_nombre" class="form-group documento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_grid->RowIndex ?>_nombre" id="x<?php echo $documento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->nombre->PlaceHolder) ?>" value="<?php echo $documento->nombre->EditValue ?>"<?php echo $documento->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->nombre->ViewAttributes() ?>>
<?php echo $documento->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $documento_grid->RowIndex ?>_nombre" id="x<?php echo $documento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_grid->RowIndex ?>_nombre" id="o<?php echo $documento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->estado_documento->Visible) { // estado_documento ?>
		<td data-name="estado_documento"<?php echo $documento->estado_documento->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_estado_documento" class="form-group documento_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_grid->RowIndex ?>_estado_documento"<?php echo $documento->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento->estado_documento->EditValue)) {
	$arwrk = $documento->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->estado_documento->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento->estado_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_estado_documento" class="form-group documento_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_grid->RowIndex ?>_estado_documento"<?php echo $documento->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento->estado_documento->EditValue)) {
	$arwrk = $documento->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->estado_documento->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->estado_documento->ViewAttributes() ?>>
<?php echo $documento->estado_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_documento" name="x<?php echo $documento_grid->RowIndex ?>_estado_documento" id="x<?php echo $documento_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento->estado_documento->FormValue) ?>">
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento->estado_documento->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $documento->monto->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_monto" class="form-group documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_grid->RowIndex ?>_monto" id="x<?php echo $documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento->monto->PlaceHolder) ?>" value="<?php echo $documento->monto->EditValue ?>"<?php echo $documento->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_grid->RowIndex ?>_monto" id="o<?php echo $documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento->monto->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_monto" class="form-group documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_grid->RowIndex ?>_monto" id="x<?php echo $documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento->monto->PlaceHolder) ?>" value="<?php echo $documento->monto->EditValue ?>"<?php echo $documento->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->monto->ViewAttributes() ?>>
<?php echo $documento->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_grid->RowIndex ?>_monto" id="x<?php echo $documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_grid->RowIndex ?>_monto" id="o<?php echo $documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $documento->fecha_insercion->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_fecha_insercion" class="form-group documento_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento->fecha_insercion->EditValue ?>"<?php echo $documento->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_fecha_insercion" class="form-group documento_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento->fecha_insercion->EditValue ?>"<?php echo $documento->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento->fecha_insercion->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento->fecha_insercion->FormValue) ?>">
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento->idcliente->Visible) { // idcliente ?>
		<td data-name="idcliente"<?php echo $documento->idcliente->CellAttributes() ?>>
<?php if ($documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idcliente" class="form-group documento_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento->idcliente->PlaceHolder) ?>" value="<?php echo $documento->idcliente->EditValue ?>"<?php echo $documento->idcliente->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento->idcliente->OldValue) ?>">
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_grid->RowCnt ?>_documento_idcliente" class="form-group documento_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento->idcliente->PlaceHolder) ?>" value="<?php echo $documento->idcliente->EditValue ?>"<?php echo $documento->idcliente->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento->idcliente->ViewAttributes() ?>>
<?php echo $documento->idcliente->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $documento_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento->idcliente->FormValue) ?>">
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento->idcliente->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_grid->ListOptions->Render("body", "right", $documento_grid->RowCnt);
?>
	</tr>
<?php if ($documento->RowType == EW_ROWTYPE_ADD || $documento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdocumentogrid.UpdateOpts(<?php echo $documento_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($documento->CurrentAction <> "gridadd" || $documento->CurrentMode == "copy")
		if (!$documento_grid->Recordset->EOF) $documento_grid->Recordset->MoveNext();
}
?>
<?php
	if ($documento->CurrentMode == "add" || $documento->CurrentMode == "copy" || $documento->CurrentMode == "edit") {
		$documento_grid->RowIndex = '$rowindex$';
		$documento_grid->LoadDefaultValues();

		// Set row properties
		$documento->ResetAttrs();
		$documento->RowAttrs = array_merge($documento->RowAttrs, array('data-rowindex'=>$documento_grid->RowIndex, 'id'=>'r0_documento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($documento->RowAttrs["class"], "ewTemplate");
		$documento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$documento_grid->RenderRow();

		// Render list options
		$documento_grid->RenderListOptions();
		$documento_grid->StartRowCnt = 0;
?>
	<tr<?php echo $documento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_grid->ListOptions->Render("body", "left", $documento_grid->RowIndex);
?>
	<?php if ($documento->idtipo_documento->Visible) { // idtipo_documento ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<?php if ($documento->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el$rowindex$_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento"<?php echo $documento->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento->idtipo_documento->EditValue)) {
	$arwrk = $documento->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento->Lookup_Selecting($documento->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documento_idtipo_documento" class="form-group documento_idtipo_documento">
<span<?php echo $documento->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento->idtipo_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<?php if ($documento->idsucursal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_documento_idsucursal" class="form-group documento_idsucursal">
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documento_idsucursal" class="form-group documento_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal"<?php echo $documento->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento->idsucursal->EditValue)) {
	$arwrk = $documento->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->idsucursal->OldValue = "";
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
 $documento->Lookup_Selecting($documento->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documento_idsucursal" class="form-group documento_idsucursal">
<span<?php echo $documento->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $documento_grid->RowIndex ?>_idsucursal" id="x<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->serie->Visible) { // serie ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_serie" class="form-group documento_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_grid->RowIndex ?>_serie" id="x<?php echo $documento_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->serie->PlaceHolder) ?>" value="<?php echo $documento->serie->EditValue ?>"<?php echo $documento->serie->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_serie" class="form-group documento_serie">
<span<?php echo $documento->serie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->serie->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_grid->RowIndex ?>_serie" id="x<?php echo $documento_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento->serie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_grid->RowIndex ?>_serie" id="o<?php echo $documento_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento->serie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->correlativo->Visible) { // correlativo ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_correlativo" class="form-group documento_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento->correlativo->PlaceHolder) ?>" value="<?php echo $documento->correlativo->EditValue ?>"<?php echo $documento->correlativo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_correlativo" class="form-group documento_correlativo">
<span<?php echo $documento->correlativo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->correlativo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_correlativo" name="x<?php echo $documento_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento->correlativo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento->correlativo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->fecha->Visible) { // fecha ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_fecha" class="form-group documento_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_grid->RowIndex ?>_fecha" id="x<?php echo $documento_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento->fecha->PlaceHolder) ?>" value="<?php echo $documento->fecha->EditValue ?>"<?php echo $documento->fecha->EditAttributes() ?>>
<?php if (!$documento->fecha->ReadOnly && !$documento->fecha->Disabled && @$documento->fecha->EditAttrs["readonly"] == "" && @$documento->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumentogrid", "x<?php echo $documento_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_fecha" class="form-group documento_fecha">
<span<?php echo $documento->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_grid->RowIndex ?>_fecha" id="x<?php echo $documento_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_grid->RowIndex ?>_fecha" id="o<?php echo $documento_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->nombre->Visible) { // nombre ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_nombre" class="form-group documento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_grid->RowIndex ?>_nombre" id="x<?php echo $documento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento->nombre->PlaceHolder) ?>" value="<?php echo $documento->nombre->EditValue ?>"<?php echo $documento->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_nombre" class="form-group documento_nombre">
<span<?php echo $documento->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $documento_grid->RowIndex ?>_nombre" id="x<?php echo $documento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_grid->RowIndex ?>_nombre" id="o<?php echo $documento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->estado_documento->Visible) { // estado_documento ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_estado_documento" class="form-group documento_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_grid->RowIndex ?>_estado_documento"<?php echo $documento->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento->estado_documento->EditValue)) {
	$arwrk = $documento->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento->estado_documento->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_estado_documento" class="form-group documento_estado_documento">
<span<?php echo $documento->estado_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->estado_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_documento" name="x<?php echo $documento_grid->RowIndex ?>_estado_documento" id="x<?php echo $documento_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento->estado_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento->estado_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->monto->Visible) { // monto ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_monto" class="form-group documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_grid->RowIndex ?>_monto" id="x<?php echo $documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento->monto->PlaceHolder) ?>" value="<?php echo $documento->monto->EditValue ?>"<?php echo $documento->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_monto" class="form-group documento_monto">
<span<?php echo $documento->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_grid->RowIndex ?>_monto" id="x<?php echo $documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_grid->RowIndex ?>_monto" id="o<?php echo $documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->fecha_insercion->Visible) { // fecha_insercion ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_fecha_insercion" class="form-group documento_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento->fecha_insercion->EditValue ?>"<?php echo $documento->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_fecha_insercion" class="form-group documento_fecha_insercion">
<span<?php echo $documento->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento->idcliente->Visible) { // idcliente ?>
		<td>
<?php if ($documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_idcliente" class="form-group documento_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento->idcliente->PlaceHolder) ?>" value="<?php echo $documento->idcliente->EditValue ?>"<?php echo $documento->idcliente->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_idcliente" class="form-group documento_idcliente">
<span<?php echo $documento->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $documento_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento->idcliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento->idcliente->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_grid->ListOptions->Render("body", "right", $documento_grid->RowCnt);
?>
<script type="text/javascript">
fdocumentogrid.UpdateOpts(<?php echo $documento_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($documento->CurrentMode == "add" || $documento->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $documento_grid->FormKeyCountName ?>" id="<?php echo $documento_grid->FormKeyCountName ?>" value="<?php echo $documento_grid->KeyCount ?>">
<?php echo $documento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $documento_grid->FormKeyCountName ?>" id="<?php echo $documento_grid->FormKeyCountName ?>" value="<?php echo $documento_grid->KeyCount ?>">
<?php echo $documento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdocumentogrid">
</div>
<?php

// Close recordset
if ($documento_grid->Recordset)
	$documento_grid->Recordset->Close();
?>
<?php if ($documento_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($documento_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($documento_grid->TotalRecs == 0 && $documento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($documento_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($documento->Export == "") { ?>
<script type="text/javascript">
fdocumentogrid.Init();
</script>
<?php } ?>
<?php
$documento_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$documento_grid->Page_Terminate();
?>
