<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($fecha_contable_grid)) $fecha_contable_grid = new cfecha_contable_grid();

// Page init
$fecha_contable_grid->Page_Init();

// Page main
$fecha_contable_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fecha_contable_grid->Page_Render();
?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">

// Page object
var fecha_contable_grid = new ew_Page("fecha_contable_grid");
fecha_contable_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = fecha_contable_grid.PageID; // For backward compatibility

// Form object
var ffecha_contablegrid = new ew_Form("ffecha_contablegrid");
ffecha_contablegrid.FormKeyCountName = '<?php echo $fecha_contable_grid->FormKeyCountName ?>';

// Validate form
ffecha_contablegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->idperiodo_contable->FldCaption(), $fecha_contable->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($fecha_contable->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_debito->FldCaption(), $fecha_contable->estado_documento_debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_credito->FldCaption(), $fecha_contable->estado_documento_credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_cliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_cliente->FldCaption(), $fecha_contable->estado_pago_cliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_proveedor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_proveedor->FldCaption(), $fecha_contable->estado_pago_proveedor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->idempresa->FldCaption(), $fecha_contable->idempresa->ReqErrMsg)) ?>");

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
ffecha_contablegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idperiodo_contable", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento_debito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento_credito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_pago_cliente", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_pago_proveedor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	return true;
}

// Form_CustomValidate event
ffecha_contablegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffecha_contablegrid.ValidateRequired = true;
<?php } else { ?>
ffecha_contablegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffecha_contablegrid.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ffecha_contablegrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($fecha_contable->CurrentAction == "gridadd") {
	if ($fecha_contable->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$fecha_contable_grid->TotalRecs = $fecha_contable->SelectRecordCount();
			$fecha_contable_grid->Recordset = $fecha_contable_grid->LoadRecordset($fecha_contable_grid->StartRec-1, $fecha_contable_grid->DisplayRecs);
		} else {
			if ($fecha_contable_grid->Recordset = $fecha_contable_grid->LoadRecordset())
				$fecha_contable_grid->TotalRecs = $fecha_contable_grid->Recordset->RecordCount();
		}
		$fecha_contable_grid->StartRec = 1;
		$fecha_contable_grid->DisplayRecs = $fecha_contable_grid->TotalRecs;
	} else {
		$fecha_contable->CurrentFilter = "0=1";
		$fecha_contable_grid->StartRec = 1;
		$fecha_contable_grid->DisplayRecs = $fecha_contable->GridAddRowCount;
	}
	$fecha_contable_grid->TotalRecs = $fecha_contable_grid->DisplayRecs;
	$fecha_contable_grid->StopRec = $fecha_contable_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$fecha_contable_grid->TotalRecs = $fecha_contable->SelectRecordCount();
	} else {
		if ($fecha_contable_grid->Recordset = $fecha_contable_grid->LoadRecordset())
			$fecha_contable_grid->TotalRecs = $fecha_contable_grid->Recordset->RecordCount();
	}
	$fecha_contable_grid->StartRec = 1;
	$fecha_contable_grid->DisplayRecs = $fecha_contable_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$fecha_contable_grid->Recordset = $fecha_contable_grid->LoadRecordset($fecha_contable_grid->StartRec-1, $fecha_contable_grid->DisplayRecs);

	// Set no record found message
	if ($fecha_contable->CurrentAction == "" && $fecha_contable_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$fecha_contable_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($fecha_contable_grid->SearchWhere == "0=101")
			$fecha_contable_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$fecha_contable_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$fecha_contable_grid->RenderOtherOptions();
?>
<?php $fecha_contable_grid->ShowPageHeader(); ?>
<?php
$fecha_contable_grid->ShowMessage();
?>
<?php if ($fecha_contable_grid->TotalRecs > 0 || $fecha_contable->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="ffecha_contablegrid" class="ewForm form-inline">
<div id="gmp_fecha_contable" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_fecha_contablegrid" class="table ewTable">
<?php echo $fecha_contable->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$fecha_contable_grid->RenderListOptions();

// Render list options (header, left)
$fecha_contable_grid->ListOptions->Render("header", "left");
?>
<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->idperiodo_contable) == "") { ?>
		<th data-name="idperiodo_contable"><div id="elh_fecha_contable_idperiodo_contable" class="fecha_contable_idperiodo_contable"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperiodo_contable"><div><div id="elh_fecha_contable_idperiodo_contable" class="fecha_contable_idperiodo_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->idperiodo_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->idperiodo_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_fecha_contable_fecha" class="fecha_contable_fecha"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_fecha_contable_fecha" class="fecha_contable_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_documento_debito) == "") { ?>
		<th data-name="estado_documento_debito"><div id="elh_fecha_contable_estado_documento_debito" class="fecha_contable_estado_documento_debito"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento_debito"><div><div id="elh_fecha_contable_estado_documento_debito" class="fecha_contable_estado_documento_debito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_documento_debito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_documento_debito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_documento_credito) == "") { ?>
		<th data-name="estado_documento_credito"><div id="elh_fecha_contable_estado_documento_credito" class="fecha_contable_estado_documento_credito"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento_credito"><div><div id="elh_fecha_contable_estado_documento_credito" class="fecha_contable_estado_documento_credito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_documento_credito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_documento_credito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_pago_cliente) == "") { ?>
		<th data-name="estado_pago_cliente"><div id="elh_fecha_contable_estado_pago_cliente" class="fecha_contable_estado_pago_cliente"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_pago_cliente"><div><div id="elh_fecha_contable_estado_pago_cliente" class="fecha_contable_estado_pago_cliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_pago_cliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_pago_cliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_pago_proveedor) == "") { ?>
		<th data-name="estado_pago_proveedor"><div id="elh_fecha_contable_estado_pago_proveedor" class="fecha_contable_estado_pago_proveedor"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_pago_proveedor"><div><div id="elh_fecha_contable_estado_pago_proveedor" class="fecha_contable_estado_pago_proveedor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_pago_proveedor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_pago_proveedor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_fecha_contable_idempresa" class="fecha_contable_idempresa"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_fecha_contable_idempresa" class="fecha_contable_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$fecha_contable_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$fecha_contable_grid->StartRec = 1;
$fecha_contable_grid->StopRec = $fecha_contable_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($fecha_contable_grid->FormKeyCountName) && ($fecha_contable->CurrentAction == "gridadd" || $fecha_contable->CurrentAction == "gridedit" || $fecha_contable->CurrentAction == "F")) {
		$fecha_contable_grid->KeyCount = $objForm->GetValue($fecha_contable_grid->FormKeyCountName);
		$fecha_contable_grid->StopRec = $fecha_contable_grid->StartRec + $fecha_contable_grid->KeyCount - 1;
	}
}
$fecha_contable_grid->RecCnt = $fecha_contable_grid->StartRec - 1;
if ($fecha_contable_grid->Recordset && !$fecha_contable_grid->Recordset->EOF) {
	$fecha_contable_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $fecha_contable_grid->StartRec > 1)
		$fecha_contable_grid->Recordset->Move($fecha_contable_grid->StartRec - 1);
} elseif (!$fecha_contable->AllowAddDeleteRow && $fecha_contable_grid->StopRec == 0) {
	$fecha_contable_grid->StopRec = $fecha_contable->GridAddRowCount;
}

// Initialize aggregate
$fecha_contable->RowType = EW_ROWTYPE_AGGREGATEINIT;
$fecha_contable->ResetAttrs();
$fecha_contable_grid->RenderRow();
if ($fecha_contable->CurrentAction == "gridadd")
	$fecha_contable_grid->RowIndex = 0;
if ($fecha_contable->CurrentAction == "gridedit")
	$fecha_contable_grid->RowIndex = 0;
while ($fecha_contable_grid->RecCnt < $fecha_contable_grid->StopRec) {
	$fecha_contable_grid->RecCnt++;
	if (intval($fecha_contable_grid->RecCnt) >= intval($fecha_contable_grid->StartRec)) {
		$fecha_contable_grid->RowCnt++;
		if ($fecha_contable->CurrentAction == "gridadd" || $fecha_contable->CurrentAction == "gridedit" || $fecha_contable->CurrentAction == "F") {
			$fecha_contable_grid->RowIndex++;
			$objForm->Index = $fecha_contable_grid->RowIndex;
			if ($objForm->HasValue($fecha_contable_grid->FormActionName))
				$fecha_contable_grid->RowAction = strval($objForm->GetValue($fecha_contable_grid->FormActionName));
			elseif ($fecha_contable->CurrentAction == "gridadd")
				$fecha_contable_grid->RowAction = "insert";
			else
				$fecha_contable_grid->RowAction = "";
		}

		// Set up key count
		$fecha_contable_grid->KeyCount = $fecha_contable_grid->RowIndex;

		// Init row class and style
		$fecha_contable->ResetAttrs();
		$fecha_contable->CssClass = "";
		if ($fecha_contable->CurrentAction == "gridadd") {
			if ($fecha_contable->CurrentMode == "copy") {
				$fecha_contable_grid->LoadRowValues($fecha_contable_grid->Recordset); // Load row values
				$fecha_contable_grid->SetRecordKey($fecha_contable_grid->RowOldKey, $fecha_contable_grid->Recordset); // Set old record key
			} else {
				$fecha_contable_grid->LoadDefaultValues(); // Load default values
				$fecha_contable_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$fecha_contable_grid->LoadRowValues($fecha_contable_grid->Recordset); // Load row values
		}
		$fecha_contable->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($fecha_contable->CurrentAction == "gridadd") // Grid add
			$fecha_contable->RowType = EW_ROWTYPE_ADD; // Render add
		if ($fecha_contable->CurrentAction == "gridadd" && $fecha_contable->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$fecha_contable_grid->RestoreCurrentRowFormValues($fecha_contable_grid->RowIndex); // Restore form values
		if ($fecha_contable->CurrentAction == "gridedit") { // Grid edit
			if ($fecha_contable->EventCancelled) {
				$fecha_contable_grid->RestoreCurrentRowFormValues($fecha_contable_grid->RowIndex); // Restore form values
			}
			if ($fecha_contable_grid->RowAction == "insert")
				$fecha_contable->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$fecha_contable->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($fecha_contable->CurrentAction == "gridedit" && ($fecha_contable->RowType == EW_ROWTYPE_EDIT || $fecha_contable->RowType == EW_ROWTYPE_ADD) && $fecha_contable->EventCancelled) // Update failed
			$fecha_contable_grid->RestoreCurrentRowFormValues($fecha_contable_grid->RowIndex); // Restore form values
		if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) // Edit row
			$fecha_contable_grid->EditRowCnt++;
		if ($fecha_contable->CurrentAction == "F") // Confirm row
			$fecha_contable_grid->RestoreCurrentRowFormValues($fecha_contable_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$fecha_contable->RowAttrs = array_merge($fecha_contable->RowAttrs, array('data-rowindex'=>$fecha_contable_grid->RowCnt, 'id'=>'r' . $fecha_contable_grid->RowCnt . '_fecha_contable', 'data-rowtype'=>$fecha_contable->RowType));

		// Render row
		$fecha_contable_grid->RenderRow();

		// Render list options
		$fecha_contable_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($fecha_contable_grid->RowAction <> "delete" && $fecha_contable_grid->RowAction <> "insertdelete" && !($fecha_contable_grid->RowAction == "insert" && $fecha_contable->CurrentAction == "F" && $fecha_contable_grid->EmptyRow())) {
?>
	<tr<?php echo $fecha_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$fecha_contable_grid->ListOptions->Render("body", "left", $fecha_contable_grid->RowCnt);
?>
	<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<?php echo $fecha_contable->idperiodo_contable->ListViewValue() ?></span>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->FormValue) ?>">
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->OldValue) ?>">
<?php } ?>
<a id="<?php echo $fecha_contable_grid->PageObjName . "_row_" . $fecha_contable_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idfecha_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->CurrentValue) ?>">
<input type="hidden" data-field="x_idfecha_contable" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT || $fecha_contable->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idfecha_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->CurrentValue) ?>">
<?php } ?>
	<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $fecha_contable->fecha->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablegrid", "x<?php echo $fecha_contable_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablegrid", "x<?php echo $fecha_contable_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->fecha->ViewAttributes() ?>>
<?php echo $fecha_contable->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
		<td data-name="estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_debito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_documento_debito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_debito->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_documento_debito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->FormValue) ?>">
<input type="hidden" data-field="x_estado_documento_debito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
		<td data-name="estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_credito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_documento_credito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_credito->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_documento_credito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->FormValue) ?>">
<input type="hidden" data-field="x_estado_documento_credito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
		<td data-name="estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_cliente" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_pago_cliente->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_cliente->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_pago_cliente" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->FormValue) ?>">
<input type="hidden" data-field="x_estado_pago_cliente" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
		<td data-name="estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_proveedor" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_pago_proveedor->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_proveedor->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_pago_proveedor" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->FormValue) ?>">
<input type="hidden" data-field="x_estado_pago_proveedor" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $fecha_contable->idempresa->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
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
 $fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_grid->RowCnt ?>_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
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
 $fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->idempresa->ViewAttributes() ?>>
<?php echo $fecha_contable->idempresa->ListViewValue() ?></span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->FormValue) ?>">
<input type="hidden" data-field="x_idempresa" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fecha_contable_grid->ListOptions->Render("body", "right", $fecha_contable_grid->RowCnt);
?>
	</tr>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD || $fecha_contable->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ffecha_contablegrid.UpdateOpts(<?php echo $fecha_contable_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($fecha_contable->CurrentAction <> "gridadd" || $fecha_contable->CurrentMode == "copy")
		if (!$fecha_contable_grid->Recordset->EOF) $fecha_contable_grid->Recordset->MoveNext();
}
?>
<?php
	if ($fecha_contable->CurrentMode == "add" || $fecha_contable->CurrentMode == "copy" || $fecha_contable->CurrentMode == "edit") {
		$fecha_contable_grid->RowIndex = '$rowindex$';
		$fecha_contable_grid->LoadDefaultValues();

		// Set row properties
		$fecha_contable->ResetAttrs();
		$fecha_contable->RowAttrs = array_merge($fecha_contable->RowAttrs, array('data-rowindex'=>$fecha_contable_grid->RowIndex, 'id'=>'r0_fecha_contable', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($fecha_contable->RowAttrs["class"], "ewTemplate");
		$fecha_contable->RowType = EW_ROWTYPE_ADD;

		// Render row
		$fecha_contable_grid->RenderRow();

		// Render list options
		$fecha_contable_grid->RenderListOptions();
		$fecha_contable_grid->StartRowCnt = 0;
?>
	<tr<?php echo $fecha_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$fecha_contable_grid->ListOptions->Render("body", "left", $fecha_contable_grid->RowIndex);
?>
	<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el$rowindex$_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idperiodo_contable" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablegrid", "x<?php echo $fecha_contable_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<span<?php echo $fecha_contable->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" id="o<?php echo $fecha_contable_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<span<?php echo $fecha_contable->estado_documento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->estado_documento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_documento_debito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_documento_debito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<span<?php echo $fecha_contable->estado_documento_credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->estado_documento_credito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_documento_credito" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_documento_credito" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<span<?php echo $fecha_contable->estado_pago_cliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->estado_pago_cliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_pago_cliente" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_pago_cliente" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<span<?php echo $fecha_contable->estado_pago_proveedor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->estado_pago_proveedor->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_pago_proveedor" name="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" id="x<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_pago_proveedor" name="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" id="o<?php echo $fecha_contable_grid->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
		<td>
<?php if ($fecha_contable->CurrentAction <> "F") { ?>
<span id="el$rowindex$_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
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
 $fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<span<?php echo $fecha_contable->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="x<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" id="o<?php echo $fecha_contable_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fecha_contable_grid->ListOptions->Render("body", "right", $fecha_contable_grid->RowCnt);
?>
<script type="text/javascript">
ffecha_contablegrid.UpdateOpts(<?php echo $fecha_contable_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($fecha_contable->CurrentMode == "add" || $fecha_contable->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $fecha_contable_grid->FormKeyCountName ?>" id="<?php echo $fecha_contable_grid->FormKeyCountName ?>" value="<?php echo $fecha_contable_grid->KeyCount ?>">
<?php echo $fecha_contable_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($fecha_contable->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $fecha_contable_grid->FormKeyCountName ?>" id="<?php echo $fecha_contable_grid->FormKeyCountName ?>" value="<?php echo $fecha_contable_grid->KeyCount ?>">
<?php echo $fecha_contable_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($fecha_contable->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffecha_contablegrid">
</div>
<?php

// Close recordset
if ($fecha_contable_grid->Recordset)
	$fecha_contable_grid->Recordset->Close();
?>
<?php if ($fecha_contable_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($fecha_contable_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($fecha_contable_grid->TotalRecs == 0 && $fecha_contable->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($fecha_contable_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">
ffecha_contablegrid.Init();
</script>
<?php } ?>
<?php
$fecha_contable_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$fecha_contable_grid->Page_Terminate();
?>
