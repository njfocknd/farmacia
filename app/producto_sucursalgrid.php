<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($producto_sucursal_grid)) $producto_sucursal_grid = new cproducto_sucursal_grid();

// Page init
$producto_sucursal_grid->Page_Init();

// Page main
$producto_sucursal_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_sucursal_grid->Page_Render();
?>
<?php if ($producto_sucursal->Export == "") { ?>
<script type="text/javascript">

// Page object
var producto_sucursal_grid = new ew_Page("producto_sucursal_grid");
producto_sucursal_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = producto_sucursal_grid.PageID; // For backward compatibility

// Form object
var fproducto_sucursalgrid = new ew_Form("fproducto_sucursalgrid");
fproducto_sucursalgrid.FormKeyCountName = '<?php echo $producto_sucursal_grid->FormKeyCountName ?>';

// Validate form
fproducto_sucursalgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_sucursal->idproducto->FldCaption(), $producto_sucursal->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_sucursal->idsucursal->FldCaption(), $producto_sucursal->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_sucursal->existencia->FldCaption(), $producto_sucursal->existencia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_sucursal->existencia->FldErrMsg()) ?>");

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
fproducto_sucursalgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "existencia", false)) return false;
	return true;
}

// Form_CustomValidate event
fproducto_sucursalgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_sucursalgrid.ValidateRequired = true;
<?php } else { ?>
fproducto_sucursalgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_sucursalgrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_sucursalgrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($producto_sucursal->CurrentAction == "gridadd") {
	if ($producto_sucursal->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$producto_sucursal_grid->TotalRecs = $producto_sucursal->SelectRecordCount();
			$producto_sucursal_grid->Recordset = $producto_sucursal_grid->LoadRecordset($producto_sucursal_grid->StartRec-1, $producto_sucursal_grid->DisplayRecs);
		} else {
			if ($producto_sucursal_grid->Recordset = $producto_sucursal_grid->LoadRecordset())
				$producto_sucursal_grid->TotalRecs = $producto_sucursal_grid->Recordset->RecordCount();
		}
		$producto_sucursal_grid->StartRec = 1;
		$producto_sucursal_grid->DisplayRecs = $producto_sucursal_grid->TotalRecs;
	} else {
		$producto_sucursal->CurrentFilter = "0=1";
		$producto_sucursal_grid->StartRec = 1;
		$producto_sucursal_grid->DisplayRecs = $producto_sucursal->GridAddRowCount;
	}
	$producto_sucursal_grid->TotalRecs = $producto_sucursal_grid->DisplayRecs;
	$producto_sucursal_grid->StopRec = $producto_sucursal_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$producto_sucursal_grid->TotalRecs = $producto_sucursal->SelectRecordCount();
	} else {
		if ($producto_sucursal_grid->Recordset = $producto_sucursal_grid->LoadRecordset())
			$producto_sucursal_grid->TotalRecs = $producto_sucursal_grid->Recordset->RecordCount();
	}
	$producto_sucursal_grid->StartRec = 1;
	$producto_sucursal_grid->DisplayRecs = $producto_sucursal_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$producto_sucursal_grid->Recordset = $producto_sucursal_grid->LoadRecordset($producto_sucursal_grid->StartRec-1, $producto_sucursal_grid->DisplayRecs);

	// Set no record found message
	if ($producto_sucursal->CurrentAction == "" && $producto_sucursal_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$producto_sucursal_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($producto_sucursal_grid->SearchWhere == "0=101")
			$producto_sucursal_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$producto_sucursal_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$producto_sucursal_grid->RenderOtherOptions();
?>
<?php $producto_sucursal_grid->ShowPageHeader(); ?>
<?php
$producto_sucursal_grid->ShowMessage();
?>
<?php if ($producto_sucursal_grid->TotalRecs > 0 || $producto_sucursal->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproducto_sucursalgrid" class="ewForm form-inline">
<div id="gmp_producto_sucursal" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_producto_sucursalgrid" class="table ewTable">
<?php echo $producto_sucursal->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$producto_sucursal_grid->RenderListOptions();

// Render list options (header, left)
$producto_sucursal_grid->ListOptions->Render("header", "left");
?>
<?php if ($producto_sucursal->idproducto->Visible) { // idproducto ?>
	<?php if ($producto_sucursal->SortUrl($producto_sucursal->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_producto_sucursal_idproducto" class="producto_sucursal_idproducto"><div class="ewTableHeaderCaption"><?php echo $producto_sucursal->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_producto_sucursal_idproducto" class="producto_sucursal_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_sucursal->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_sucursal->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_sucursal->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_sucursal->idsucursal->Visible) { // idsucursal ?>
	<?php if ($producto_sucursal->SortUrl($producto_sucursal->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_producto_sucursal_idsucursal" class="producto_sucursal_idsucursal"><div class="ewTableHeaderCaption"><?php echo $producto_sucursal->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_producto_sucursal_idsucursal" class="producto_sucursal_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_sucursal->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_sucursal->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_sucursal->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_sucursal->existencia->Visible) { // existencia ?>
	<?php if ($producto_sucursal->SortUrl($producto_sucursal->existencia) == "") { ?>
		<th data-name="existencia"><div id="elh_producto_sucursal_existencia" class="producto_sucursal_existencia"><div class="ewTableHeaderCaption"><?php echo $producto_sucursal->existencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="existencia"><div><div id="elh_producto_sucursal_existencia" class="producto_sucursal_existencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_sucursal->existencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_sucursal->existencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_sucursal->existencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$producto_sucursal_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$producto_sucursal_grid->StartRec = 1;
$producto_sucursal_grid->StopRec = $producto_sucursal_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($producto_sucursal_grid->FormKeyCountName) && ($producto_sucursal->CurrentAction == "gridadd" || $producto_sucursal->CurrentAction == "gridedit" || $producto_sucursal->CurrentAction == "F")) {
		$producto_sucursal_grid->KeyCount = $objForm->GetValue($producto_sucursal_grid->FormKeyCountName);
		$producto_sucursal_grid->StopRec = $producto_sucursal_grid->StartRec + $producto_sucursal_grid->KeyCount - 1;
	}
}
$producto_sucursal_grid->RecCnt = $producto_sucursal_grid->StartRec - 1;
if ($producto_sucursal_grid->Recordset && !$producto_sucursal_grid->Recordset->EOF) {
	$producto_sucursal_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $producto_sucursal_grid->StartRec > 1)
		$producto_sucursal_grid->Recordset->Move($producto_sucursal_grid->StartRec - 1);
} elseif (!$producto_sucursal->AllowAddDeleteRow && $producto_sucursal_grid->StopRec == 0) {
	$producto_sucursal_grid->StopRec = $producto_sucursal->GridAddRowCount;
}

// Initialize aggregate
$producto_sucursal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$producto_sucursal->ResetAttrs();
$producto_sucursal_grid->RenderRow();
if ($producto_sucursal->CurrentAction == "gridadd")
	$producto_sucursal_grid->RowIndex = 0;
if ($producto_sucursal->CurrentAction == "gridedit")
	$producto_sucursal_grid->RowIndex = 0;
while ($producto_sucursal_grid->RecCnt < $producto_sucursal_grid->StopRec) {
	$producto_sucursal_grid->RecCnt++;
	if (intval($producto_sucursal_grid->RecCnt) >= intval($producto_sucursal_grid->StartRec)) {
		$producto_sucursal_grid->RowCnt++;
		if ($producto_sucursal->CurrentAction == "gridadd" || $producto_sucursal->CurrentAction == "gridedit" || $producto_sucursal->CurrentAction == "F") {
			$producto_sucursal_grid->RowIndex++;
			$objForm->Index = $producto_sucursal_grid->RowIndex;
			if ($objForm->HasValue($producto_sucursal_grid->FormActionName))
				$producto_sucursal_grid->RowAction = strval($objForm->GetValue($producto_sucursal_grid->FormActionName));
			elseif ($producto_sucursal->CurrentAction == "gridadd")
				$producto_sucursal_grid->RowAction = "insert";
			else
				$producto_sucursal_grid->RowAction = "";
		}

		// Set up key count
		$producto_sucursal_grid->KeyCount = $producto_sucursal_grid->RowIndex;

		// Init row class and style
		$producto_sucursal->ResetAttrs();
		$producto_sucursal->CssClass = "";
		if ($producto_sucursal->CurrentAction == "gridadd") {
			if ($producto_sucursal->CurrentMode == "copy") {
				$producto_sucursal_grid->LoadRowValues($producto_sucursal_grid->Recordset); // Load row values
				$producto_sucursal_grid->SetRecordKey($producto_sucursal_grid->RowOldKey, $producto_sucursal_grid->Recordset); // Set old record key
			} else {
				$producto_sucursal_grid->LoadDefaultValues(); // Load default values
				$producto_sucursal_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$producto_sucursal_grid->LoadRowValues($producto_sucursal_grid->Recordset); // Load row values
		}
		$producto_sucursal->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($producto_sucursal->CurrentAction == "gridadd") // Grid add
			$producto_sucursal->RowType = EW_ROWTYPE_ADD; // Render add
		if ($producto_sucursal->CurrentAction == "gridadd" && $producto_sucursal->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$producto_sucursal_grid->RestoreCurrentRowFormValues($producto_sucursal_grid->RowIndex); // Restore form values
		if ($producto_sucursal->CurrentAction == "gridedit") { // Grid edit
			if ($producto_sucursal->EventCancelled) {
				$producto_sucursal_grid->RestoreCurrentRowFormValues($producto_sucursal_grid->RowIndex); // Restore form values
			}
			if ($producto_sucursal_grid->RowAction == "insert")
				$producto_sucursal->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$producto_sucursal->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($producto_sucursal->CurrentAction == "gridedit" && ($producto_sucursal->RowType == EW_ROWTYPE_EDIT || $producto_sucursal->RowType == EW_ROWTYPE_ADD) && $producto_sucursal->EventCancelled) // Update failed
			$producto_sucursal_grid->RestoreCurrentRowFormValues($producto_sucursal_grid->RowIndex); // Restore form values
		if ($producto_sucursal->RowType == EW_ROWTYPE_EDIT) // Edit row
			$producto_sucursal_grid->EditRowCnt++;
		if ($producto_sucursal->CurrentAction == "F") // Confirm row
			$producto_sucursal_grid->RestoreCurrentRowFormValues($producto_sucursal_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$producto_sucursal->RowAttrs = array_merge($producto_sucursal->RowAttrs, array('data-rowindex'=>$producto_sucursal_grid->RowCnt, 'id'=>'r' . $producto_sucursal_grid->RowCnt . '_producto_sucursal', 'data-rowtype'=>$producto_sucursal->RowType));

		// Render row
		$producto_sucursal_grid->RenderRow();

		// Render list options
		$producto_sucursal_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($producto_sucursal_grid->RowAction <> "delete" && $producto_sucursal_grid->RowAction <> "insertdelete" && !($producto_sucursal_grid->RowAction == "insert" && $producto_sucursal->CurrentAction == "F" && $producto_sucursal_grid->EmptyRow())) {
?>
	<tr<?php echo $producto_sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_sucursal_grid->ListOptions->Render("body", "left", $producto_sucursal_grid->RowCnt);
?>
	<?php if ($producto_sucursal->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $producto_sucursal->idproducto->CellAttributes() ?>>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto_sucursal->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto"<?php echo $producto_sucursal->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idproducto->EditValue)) {
	$arwrk = $producto_sucursal->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto_sucursal->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto"<?php echo $producto_sucursal->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idproducto->EditValue)) {
	$arwrk = $producto_sucursal->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<?php echo $producto_sucursal->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->OldValue) ?>">
<?php } ?>
<a id="<?php echo $producto_sucursal_grid->PageObjName . "_row_" . $producto_sucursal_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproducto_sucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto_sucursal->CurrentValue) ?>">
<input type="hidden" data-field="x_idproducto_sucursal" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto_sucursal->OldValue) ?>">
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_EDIT || $producto_sucursal->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproducto_sucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto_sucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto_sucursal->CurrentValue) ?>">
<?php } ?>
	<?php if ($producto_sucursal->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $producto_sucursal->idsucursal->CellAttributes() ?>>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto_sucursal->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal"<?php echo $producto_sucursal->idsucursal->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idsucursal->EditValue)) {
	$arwrk = $producto_sucursal->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idsucursal->OldValue = "";
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
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto_sucursal->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal"<?php echo $producto_sucursal->idsucursal->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idsucursal->EditValue)) {
	$arwrk = $producto_sucursal->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idsucursal->OldValue = "";
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
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<?php echo $producto_sucursal->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_sucursal->existencia->Visible) { // existencia ?>
		<td data-name="existencia"<?php echo $producto_sucursal->existencia->CellAttributes() ?>>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_existencia" class="form-group producto_sucursal_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_sucursal->existencia->PlaceHolder) ?>" value="<?php echo $producto_sucursal->existencia->EditValue ?>"<?php echo $producto_sucursal->existencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_sucursal->existencia->OldValue) ?>">
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_sucursal_grid->RowCnt ?>_producto_sucursal_existencia" class="form-group producto_sucursal_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_sucursal->existencia->PlaceHolder) ?>" value="<?php echo $producto_sucursal->existencia->EditValue ?>"<?php echo $producto_sucursal->existencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_sucursal->existencia->ViewAttributes() ?>>
<?php echo $producto_sucursal->existencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_sucursal->existencia->FormValue) ?>">
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_sucursal->existencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_sucursal_grid->ListOptions->Render("body", "right", $producto_sucursal_grid->RowCnt);
?>
	</tr>
<?php if ($producto_sucursal->RowType == EW_ROWTYPE_ADD || $producto_sucursal->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproducto_sucursalgrid.UpdateOpts(<?php echo $producto_sucursal_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($producto_sucursal->CurrentAction <> "gridadd" || $producto_sucursal->CurrentMode == "copy")
		if (!$producto_sucursal_grid->Recordset->EOF) $producto_sucursal_grid->Recordset->MoveNext();
}
?>
<?php
	if ($producto_sucursal->CurrentMode == "add" || $producto_sucursal->CurrentMode == "copy" || $producto_sucursal->CurrentMode == "edit") {
		$producto_sucursal_grid->RowIndex = '$rowindex$';
		$producto_sucursal_grid->LoadDefaultValues();

		// Set row properties
		$producto_sucursal->ResetAttrs();
		$producto_sucursal->RowAttrs = array_merge($producto_sucursal->RowAttrs, array('data-rowindex'=>$producto_sucursal_grid->RowIndex, 'id'=>'r0_producto_sucursal', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($producto_sucursal->RowAttrs["class"], "ewTemplate");
		$producto_sucursal->RowType = EW_ROWTYPE_ADD;

		// Render row
		$producto_sucursal_grid->RenderRow();

		// Render list options
		$producto_sucursal_grid->RenderListOptions();
		$producto_sucursal_grid->StartRowCnt = 0;
?>
	<tr<?php echo $producto_sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_sucursal_grid->ListOptions->Render("body", "left", $producto_sucursal_grid->RowIndex);
?>
	<?php if ($producto_sucursal->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($producto_sucursal->CurrentAction <> "F") { ?>
<?php if ($producto_sucursal->idproducto->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto"<?php echo $producto_sucursal->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idproducto->EditValue)) {
	$arwrk = $producto_sucursal->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idproducto->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_sucursal_idproducto" class="form-group producto_sucursal_idproducto">
<span<?php echo $producto_sucursal->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_sucursal->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_sucursal->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($producto_sucursal->CurrentAction <> "F") { ?>
<?php if ($producto_sucursal->idsucursal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal"<?php echo $producto_sucursal->idsucursal->EditAttributes() ?>>
<?php
if (is_array($producto_sucursal->idsucursal->EditValue)) {
	$arwrk = $producto_sucursal->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_sucursal->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_sucursal->idsucursal->OldValue = "";
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
 $producto_sucursal->Lookup_Selecting($producto_sucursal->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_sucursal_idsucursal" class="form-group producto_sucursal_idsucursal">
<span<?php echo $producto_sucursal->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($producto_sucursal->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_sucursal->existencia->Visible) { // existencia ?>
		<td>
<?php if ($producto_sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_sucursal_existencia" class="form-group producto_sucursal_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_sucursal->existencia->PlaceHolder) ?>" value="<?php echo $producto_sucursal->existencia->EditValue ?>"<?php echo $producto_sucursal->existencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_sucursal_existencia" class="form-group producto_sucursal_existencia">
<span<?php echo $producto_sucursal->existencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_sucursal->existencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="x<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_sucursal->existencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" id="o<?php echo $producto_sucursal_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_sucursal->existencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_sucursal_grid->ListOptions->Render("body", "right", $producto_sucursal_grid->RowCnt);
?>
<script type="text/javascript">
fproducto_sucursalgrid.UpdateOpts(<?php echo $producto_sucursal_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($producto_sucursal->CurrentMode == "add" || $producto_sucursal->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $producto_sucursal_grid->FormKeyCountName ?>" id="<?php echo $producto_sucursal_grid->FormKeyCountName ?>" value="<?php echo $producto_sucursal_grid->KeyCount ?>">
<?php echo $producto_sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_sucursal->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $producto_sucursal_grid->FormKeyCountName ?>" id="<?php echo $producto_sucursal_grid->FormKeyCountName ?>" value="<?php echo $producto_sucursal_grid->KeyCount ?>">
<?php echo $producto_sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_sucursal->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproducto_sucursalgrid">
</div>
<?php

// Close recordset
if ($producto_sucursal_grid->Recordset)
	$producto_sucursal_grid->Recordset->Close();
?>
<?php if ($producto_sucursal_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($producto_sucursal_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($producto_sucursal_grid->TotalRecs == 0 && $producto_sucursal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($producto_sucursal_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($producto_sucursal->Export == "") { ?>
<script type="text/javascript">
fproducto_sucursalgrid.Init();
</script>
<?php } ?>
<?php
$producto_sucursal_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$producto_sucursal_grid->Page_Terminate();
?>
