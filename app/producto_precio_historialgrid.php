<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($producto_precio_historial_grid)) $producto_precio_historial_grid = new cproducto_precio_historial_grid();

// Page init
$producto_precio_historial_grid->Page_Init();

// Page main
$producto_precio_historial_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_precio_historial_grid->Page_Render();
?>
<?php if ($producto_precio_historial->Export == "") { ?>
<script type="text/javascript">

// Page object
var producto_precio_historial_grid = new ew_Page("producto_precio_historial_grid");
producto_precio_historial_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = producto_precio_historial_grid.PageID; // For backward compatibility

// Form object
var fproducto_precio_historialgrid = new ew_Form("fproducto_precio_historialgrid");
fproducto_precio_historialgrid.FormKeyCountName = '<?php echo $producto_precio_historial_grid->FormKeyCountName ?>';

// Validate form
fproducto_precio_historialgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_precio_historial->idproducto->FldCaption(), $producto_precio_historial->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_precio_historial->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_precio_historial->precio_venta->FldCaption(), $producto_precio_historial->precio_venta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_precio_historial->precio_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_compra");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_precio_historial->precio_compra->FldCaption(), $producto_precio_historial->precio_compra->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_compra");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_precio_historial->precio_compra->FldErrMsg()) ?>");

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
fproducto_precio_historialgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio_venta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio_compra", false)) return false;
	return true;
}

// Form_CustomValidate event
fproducto_precio_historialgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_precio_historialgrid.ValidateRequired = true;
<?php } else { ?>
fproducto_precio_historialgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_precio_historialgrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($producto_precio_historial->CurrentAction == "gridadd") {
	if ($producto_precio_historial->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$producto_precio_historial_grid->TotalRecs = $producto_precio_historial->SelectRecordCount();
			$producto_precio_historial_grid->Recordset = $producto_precio_historial_grid->LoadRecordset($producto_precio_historial_grid->StartRec-1, $producto_precio_historial_grid->DisplayRecs);
		} else {
			if ($producto_precio_historial_grid->Recordset = $producto_precio_historial_grid->LoadRecordset())
				$producto_precio_historial_grid->TotalRecs = $producto_precio_historial_grid->Recordset->RecordCount();
		}
		$producto_precio_historial_grid->StartRec = 1;
		$producto_precio_historial_grid->DisplayRecs = $producto_precio_historial_grid->TotalRecs;
	} else {
		$producto_precio_historial->CurrentFilter = "0=1";
		$producto_precio_historial_grid->StartRec = 1;
		$producto_precio_historial_grid->DisplayRecs = $producto_precio_historial->GridAddRowCount;
	}
	$producto_precio_historial_grid->TotalRecs = $producto_precio_historial_grid->DisplayRecs;
	$producto_precio_historial_grid->StopRec = $producto_precio_historial_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$producto_precio_historial_grid->TotalRecs = $producto_precio_historial->SelectRecordCount();
	} else {
		if ($producto_precio_historial_grid->Recordset = $producto_precio_historial_grid->LoadRecordset())
			$producto_precio_historial_grid->TotalRecs = $producto_precio_historial_grid->Recordset->RecordCount();
	}
	$producto_precio_historial_grid->StartRec = 1;
	$producto_precio_historial_grid->DisplayRecs = $producto_precio_historial_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$producto_precio_historial_grid->Recordset = $producto_precio_historial_grid->LoadRecordset($producto_precio_historial_grid->StartRec-1, $producto_precio_historial_grid->DisplayRecs);

	// Set no record found message
	if ($producto_precio_historial->CurrentAction == "" && $producto_precio_historial_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$producto_precio_historial_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($producto_precio_historial_grid->SearchWhere == "0=101")
			$producto_precio_historial_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$producto_precio_historial_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$producto_precio_historial_grid->RenderOtherOptions();
?>
<?php $producto_precio_historial_grid->ShowPageHeader(); ?>
<?php
$producto_precio_historial_grid->ShowMessage();
?>
<?php if ($producto_precio_historial_grid->TotalRecs > 0 || $producto_precio_historial->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproducto_precio_historialgrid" class="ewForm form-inline">
<div id="gmp_producto_precio_historial" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_producto_precio_historialgrid" class="table ewTable">
<?php echo $producto_precio_historial->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$producto_precio_historial_grid->RenderListOptions();

// Render list options (header, left)
$producto_precio_historial_grid->ListOptions->Render("header", "left");
?>
<?php if ($producto_precio_historial->idproducto->Visible) { // idproducto ?>
	<?php if ($producto_precio_historial->SortUrl($producto_precio_historial->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_producto_precio_historial_idproducto" class="producto_precio_historial_idproducto"><div class="ewTableHeaderCaption"><?php echo $producto_precio_historial->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_producto_precio_historial_idproducto" class="producto_precio_historial_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_precio_historial->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_precio_historial->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_precio_historial->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_precio_historial->fecha->Visible) { // fecha ?>
	<?php if ($producto_precio_historial->SortUrl($producto_precio_historial->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_producto_precio_historial_fecha" class="producto_precio_historial_fecha"><div class="ewTableHeaderCaption"><?php echo $producto_precio_historial->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_producto_precio_historial_fecha" class="producto_precio_historial_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_precio_historial->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_precio_historial->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_precio_historial->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_precio_historial->precio_venta->Visible) { // precio_venta ?>
	<?php if ($producto_precio_historial->SortUrl($producto_precio_historial->precio_venta) == "") { ?>
		<th data-name="precio_venta"><div id="elh_producto_precio_historial_precio_venta" class="producto_precio_historial_precio_venta"><div class="ewTableHeaderCaption"><?php echo $producto_precio_historial->precio_venta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio_venta"><div><div id="elh_producto_precio_historial_precio_venta" class="producto_precio_historial_precio_venta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_precio_historial->precio_venta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_precio_historial->precio_venta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_precio_historial->precio_venta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_precio_historial->precio_compra->Visible) { // precio_compra ?>
	<?php if ($producto_precio_historial->SortUrl($producto_precio_historial->precio_compra) == "") { ?>
		<th data-name="precio_compra"><div id="elh_producto_precio_historial_precio_compra" class="producto_precio_historial_precio_compra"><div class="ewTableHeaderCaption"><?php echo $producto_precio_historial->precio_compra->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio_compra"><div><div id="elh_producto_precio_historial_precio_compra" class="producto_precio_historial_precio_compra">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_precio_historial->precio_compra->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_precio_historial->precio_compra->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_precio_historial->precio_compra->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$producto_precio_historial_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$producto_precio_historial_grid->StartRec = 1;
$producto_precio_historial_grid->StopRec = $producto_precio_historial_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($producto_precio_historial_grid->FormKeyCountName) && ($producto_precio_historial->CurrentAction == "gridadd" || $producto_precio_historial->CurrentAction == "gridedit" || $producto_precio_historial->CurrentAction == "F")) {
		$producto_precio_historial_grid->KeyCount = $objForm->GetValue($producto_precio_historial_grid->FormKeyCountName);
		$producto_precio_historial_grid->StopRec = $producto_precio_historial_grid->StartRec + $producto_precio_historial_grid->KeyCount - 1;
	}
}
$producto_precio_historial_grid->RecCnt = $producto_precio_historial_grid->StartRec - 1;
if ($producto_precio_historial_grid->Recordset && !$producto_precio_historial_grid->Recordset->EOF) {
	$producto_precio_historial_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $producto_precio_historial_grid->StartRec > 1)
		$producto_precio_historial_grid->Recordset->Move($producto_precio_historial_grid->StartRec - 1);
} elseif (!$producto_precio_historial->AllowAddDeleteRow && $producto_precio_historial_grid->StopRec == 0) {
	$producto_precio_historial_grid->StopRec = $producto_precio_historial->GridAddRowCount;
}

// Initialize aggregate
$producto_precio_historial->RowType = EW_ROWTYPE_AGGREGATEINIT;
$producto_precio_historial->ResetAttrs();
$producto_precio_historial_grid->RenderRow();
if ($producto_precio_historial->CurrentAction == "gridadd")
	$producto_precio_historial_grid->RowIndex = 0;
if ($producto_precio_historial->CurrentAction == "gridedit")
	$producto_precio_historial_grid->RowIndex = 0;
while ($producto_precio_historial_grid->RecCnt < $producto_precio_historial_grid->StopRec) {
	$producto_precio_historial_grid->RecCnt++;
	if (intval($producto_precio_historial_grid->RecCnt) >= intval($producto_precio_historial_grid->StartRec)) {
		$producto_precio_historial_grid->RowCnt++;
		if ($producto_precio_historial->CurrentAction == "gridadd" || $producto_precio_historial->CurrentAction == "gridedit" || $producto_precio_historial->CurrentAction == "F") {
			$producto_precio_historial_grid->RowIndex++;
			$objForm->Index = $producto_precio_historial_grid->RowIndex;
			if ($objForm->HasValue($producto_precio_historial_grid->FormActionName))
				$producto_precio_historial_grid->RowAction = strval($objForm->GetValue($producto_precio_historial_grid->FormActionName));
			elseif ($producto_precio_historial->CurrentAction == "gridadd")
				$producto_precio_historial_grid->RowAction = "insert";
			else
				$producto_precio_historial_grid->RowAction = "";
		}

		// Set up key count
		$producto_precio_historial_grid->KeyCount = $producto_precio_historial_grid->RowIndex;

		// Init row class and style
		$producto_precio_historial->ResetAttrs();
		$producto_precio_historial->CssClass = "";
		if ($producto_precio_historial->CurrentAction == "gridadd") {
			if ($producto_precio_historial->CurrentMode == "copy") {
				$producto_precio_historial_grid->LoadRowValues($producto_precio_historial_grid->Recordset); // Load row values
				$producto_precio_historial_grid->SetRecordKey($producto_precio_historial_grid->RowOldKey, $producto_precio_historial_grid->Recordset); // Set old record key
			} else {
				$producto_precio_historial_grid->LoadDefaultValues(); // Load default values
				$producto_precio_historial_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$producto_precio_historial_grid->LoadRowValues($producto_precio_historial_grid->Recordset); // Load row values
		}
		$producto_precio_historial->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($producto_precio_historial->CurrentAction == "gridadd") // Grid add
			$producto_precio_historial->RowType = EW_ROWTYPE_ADD; // Render add
		if ($producto_precio_historial->CurrentAction == "gridadd" && $producto_precio_historial->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$producto_precio_historial_grid->RestoreCurrentRowFormValues($producto_precio_historial_grid->RowIndex); // Restore form values
		if ($producto_precio_historial->CurrentAction == "gridedit") { // Grid edit
			if ($producto_precio_historial->EventCancelled) {
				$producto_precio_historial_grid->RestoreCurrentRowFormValues($producto_precio_historial_grid->RowIndex); // Restore form values
			}
			if ($producto_precio_historial_grid->RowAction == "insert")
				$producto_precio_historial->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$producto_precio_historial->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($producto_precio_historial->CurrentAction == "gridedit" && ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT || $producto_precio_historial->RowType == EW_ROWTYPE_ADD) && $producto_precio_historial->EventCancelled) // Update failed
			$producto_precio_historial_grid->RestoreCurrentRowFormValues($producto_precio_historial_grid->RowIndex); // Restore form values
		if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT) // Edit row
			$producto_precio_historial_grid->EditRowCnt++;
		if ($producto_precio_historial->CurrentAction == "F") // Confirm row
			$producto_precio_historial_grid->RestoreCurrentRowFormValues($producto_precio_historial_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$producto_precio_historial->RowAttrs = array_merge($producto_precio_historial->RowAttrs, array('data-rowindex'=>$producto_precio_historial_grid->RowCnt, 'id'=>'r' . $producto_precio_historial_grid->RowCnt . '_producto_precio_historial', 'data-rowtype'=>$producto_precio_historial->RowType));

		// Render row
		$producto_precio_historial_grid->RenderRow();

		// Render list options
		$producto_precio_historial_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($producto_precio_historial_grid->RowAction <> "delete" && $producto_precio_historial_grid->RowAction <> "insertdelete" && !($producto_precio_historial_grid->RowAction == "insert" && $producto_precio_historial->CurrentAction == "F" && $producto_precio_historial_grid->EmptyRow())) {
?>
	<tr<?php echo $producto_precio_historial->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_precio_historial_grid->ListOptions->Render("body", "left", $producto_precio_historial_grid->RowCnt);
?>
	<?php if ($producto_precio_historial->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $producto_precio_historial->idproducto->CellAttributes() ?>>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto_precio_historial->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<span<?php echo $producto_precio_historial->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_precio_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_precio_historial->idproducto->EditValue)) {
	$arwrk = $producto_precio_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_precio_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_precio_historial->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $producto_precio_historial->Lookup_Selecting($producto_precio_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto_precio_historial->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<span<?php echo $producto_precio_historial->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_precio_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_precio_historial->idproducto->EditValue)) {
	$arwrk = $producto_precio_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_precio_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_precio_historial->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $producto_precio_historial->Lookup_Selecting($producto_precio_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_precio_historial->idproducto->ViewAttributes() ?>>
<?php echo $producto_precio_historial->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->OldValue) ?>">
<?php } ?>
<a id="<?php echo $producto_precio_historial_grid->PageObjName . "_row_" . $producto_precio_historial_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproducto_precio_historial" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto_precio_historial->CurrentValue) ?>">
<input type="hidden" data-field="x_idproducto_precio_historial" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto_precio_historial->OldValue) ?>">
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT || $producto_precio_historial->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproducto_precio_historial" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto_precio_historial" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto_precio_historial->CurrentValue) ?>">
<?php } ?>
	<?php if ($producto_precio_historial->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $producto_precio_historial->fecha->CellAttributes() ?>>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_fecha" class="form-group producto_precio_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->fecha->EditValue ?>"<?php echo $producto_precio_historial->fecha->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->OldValue) ?>">
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_fecha" class="form-group producto_precio_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->fecha->EditValue ?>"<?php echo $producto_precio_historial->fecha->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_precio_historial->fecha->ViewAttributes() ?>>
<?php echo $producto_precio_historial->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_precio_historial->precio_venta->Visible) { // precio_venta ?>
		<td data-name="precio_venta"<?php echo $producto_precio_historial->precio_venta->CellAttributes() ?>>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_precio_venta" class="form-group producto_precio_historial_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_venta->EditValue ?>"<?php echo $producto_precio_historial->precio_venta->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->OldValue) ?>">
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_precio_venta" class="form-group producto_precio_historial_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_venta->EditValue ?>"<?php echo $producto_precio_historial->precio_venta->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_precio_historial->precio_venta->ViewAttributes() ?>>
<?php echo $producto_precio_historial->precio_venta->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio_venta" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->FormValue) ?>">
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_precio_historial->precio_compra->Visible) { // precio_compra ?>
		<td data-name="precio_compra"<?php echo $producto_precio_historial->precio_compra->CellAttributes() ?>>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_precio_compra" class="form-group producto_precio_historial_precio_compra">
<input type="text" data-field="x_precio_compra" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_compra->EditValue ?>"<?php echo $producto_precio_historial->precio_compra->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio_compra" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->OldValue) ?>">
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_precio_historial_grid->RowCnt ?>_producto_precio_historial_precio_compra" class="form-group producto_precio_historial_precio_compra">
<input type="text" data-field="x_precio_compra" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_compra->EditValue ?>"<?php echo $producto_precio_historial->precio_compra->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_precio_historial->precio_compra->ViewAttributes() ?>>
<?php echo $producto_precio_historial->precio_compra->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio_compra" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->FormValue) ?>">
<input type="hidden" data-field="x_precio_compra" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_precio_historial_grid->ListOptions->Render("body", "right", $producto_precio_historial_grid->RowCnt);
?>
	</tr>
<?php if ($producto_precio_historial->RowType == EW_ROWTYPE_ADD || $producto_precio_historial->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproducto_precio_historialgrid.UpdateOpts(<?php echo $producto_precio_historial_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($producto_precio_historial->CurrentAction <> "gridadd" || $producto_precio_historial->CurrentMode == "copy")
		if (!$producto_precio_historial_grid->Recordset->EOF) $producto_precio_historial_grid->Recordset->MoveNext();
}
?>
<?php
	if ($producto_precio_historial->CurrentMode == "add" || $producto_precio_historial->CurrentMode == "copy" || $producto_precio_historial->CurrentMode == "edit") {
		$producto_precio_historial_grid->RowIndex = '$rowindex$';
		$producto_precio_historial_grid->LoadDefaultValues();

		// Set row properties
		$producto_precio_historial->ResetAttrs();
		$producto_precio_historial->RowAttrs = array_merge($producto_precio_historial->RowAttrs, array('data-rowindex'=>$producto_precio_historial_grid->RowIndex, 'id'=>'r0_producto_precio_historial', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($producto_precio_historial->RowAttrs["class"], "ewTemplate");
		$producto_precio_historial->RowType = EW_ROWTYPE_ADD;

		// Render row
		$producto_precio_historial_grid->RenderRow();

		// Render list options
		$producto_precio_historial_grid->RenderListOptions();
		$producto_precio_historial_grid->StartRowCnt = 0;
?>
	<tr<?php echo $producto_precio_historial->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_precio_historial_grid->ListOptions->Render("body", "left", $producto_precio_historial_grid->RowIndex);
?>
	<?php if ($producto_precio_historial->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($producto_precio_historial->CurrentAction <> "F") { ?>
<?php if ($producto_precio_historial->idproducto->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<span<?php echo $producto_precio_historial->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_precio_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_precio_historial->idproducto->EditValue)) {
	$arwrk = $producto_precio_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_precio_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_precio_historial->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $producto_precio_historial->Lookup_Selecting($producto_precio_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_precio_historial_idproducto" class="form-group producto_precio_historial_idproducto">
<span<?php echo $producto_precio_historial->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_precio_historial->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_precio_historial->fecha->Visible) { // fecha ?>
		<td>
<?php if ($producto_precio_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_precio_historial_fecha" class="form-group producto_precio_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->fecha->EditValue ?>"<?php echo $producto_precio_historial->fecha->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_precio_historial_fecha" class="form-group producto_precio_historial_fecha">
<span<?php echo $producto_precio_historial->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_precio_historial->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_precio_historial->precio_venta->Visible) { // precio_venta ?>
		<td>
<?php if ($producto_precio_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_precio_historial_precio_venta" class="form-group producto_precio_historial_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_venta->EditValue ?>"<?php echo $producto_precio_historial->precio_venta->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_precio_historial_precio_venta" class="form-group producto_precio_historial_precio_venta">
<span<?php echo $producto_precio_historial->precio_venta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->precio_venta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio_venta" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_venta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_precio_historial->precio_compra->Visible) { // precio_compra ?>
		<td>
<?php if ($producto_precio_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_precio_historial_precio_compra" class="form-group producto_precio_historial_precio_compra">
<input type="text" data-field="x_precio_compra" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" size="30" placeholder="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->PlaceHolder) ?>" value="<?php echo $producto_precio_historial->precio_compra->EditValue ?>"<?php echo $producto_precio_historial->precio_compra->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_precio_historial_precio_compra" class="form-group producto_precio_historial_precio_compra">
<span<?php echo $producto_precio_historial->precio_compra->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_precio_historial->precio_compra->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio_compra" name="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="x<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio_compra" name="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" id="o<?php echo $producto_precio_historial_grid->RowIndex ?>_precio_compra" value="<?php echo ew_HtmlEncode($producto_precio_historial->precio_compra->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_precio_historial_grid->ListOptions->Render("body", "right", $producto_precio_historial_grid->RowCnt);
?>
<script type="text/javascript">
fproducto_precio_historialgrid.UpdateOpts(<?php echo $producto_precio_historial_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($producto_precio_historial->CurrentMode == "add" || $producto_precio_historial->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $producto_precio_historial_grid->FormKeyCountName ?>" id="<?php echo $producto_precio_historial_grid->FormKeyCountName ?>" value="<?php echo $producto_precio_historial_grid->KeyCount ?>">
<?php echo $producto_precio_historial_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_precio_historial->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $producto_precio_historial_grid->FormKeyCountName ?>" id="<?php echo $producto_precio_historial_grid->FormKeyCountName ?>" value="<?php echo $producto_precio_historial_grid->KeyCount ?>">
<?php echo $producto_precio_historial_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_precio_historial->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproducto_precio_historialgrid">
</div>
<?php

// Close recordset
if ($producto_precio_historial_grid->Recordset)
	$producto_precio_historial_grid->Recordset->Close();
?>
<?php if ($producto_precio_historial_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($producto_precio_historial_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($producto_precio_historial_grid->TotalRecs == 0 && $producto_precio_historial->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($producto_precio_historial_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($producto_precio_historial->Export == "") { ?>
<script type="text/javascript">
fproducto_precio_historialgrid.Init();
</script>
<?php } ?>
<?php
$producto_precio_historial_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$producto_precio_historial_grid->Page_Terminate();
?>
