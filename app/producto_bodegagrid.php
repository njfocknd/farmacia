<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($producto_bodega_grid)) $producto_bodega_grid = new cproducto_bodega_grid();

// Page init
$producto_bodega_grid->Page_Init();

// Page main
$producto_bodega_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_bodega_grid->Page_Render();
?>
<?php if ($producto_bodega->Export == "") { ?>
<script type="text/javascript">

// Page object
var producto_bodega_grid = new ew_Page("producto_bodega_grid");
producto_bodega_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = producto_bodega_grid.PageID; // For backward compatibility

// Form object
var fproducto_bodegagrid = new ew_Form("fproducto_bodegagrid");
fproducto_bodegagrid.FormKeyCountName = '<?php echo $producto_bodega_grid->FormKeyCountName ?>';

// Validate form
fproducto_bodegagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->idproducto->FldCaption(), $producto_bodega->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->idbodega->FldCaption(), $producto_bodega->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_bodega->existencia->FldErrMsg()) ?>");

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
fproducto_bodegagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "existencia", false)) return false;
	return true;
}

// Form_CustomValidate event
fproducto_bodegagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_bodegagrid.ValidateRequired = true;
<?php } else { ?>
fproducto_bodegagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_bodegagrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_bodegagrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($producto_bodega->CurrentAction == "gridadd") {
	if ($producto_bodega->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$producto_bodega_grid->TotalRecs = $producto_bodega->SelectRecordCount();
			$producto_bodega_grid->Recordset = $producto_bodega_grid->LoadRecordset($producto_bodega_grid->StartRec-1, $producto_bodega_grid->DisplayRecs);
		} else {
			if ($producto_bodega_grid->Recordset = $producto_bodega_grid->LoadRecordset())
				$producto_bodega_grid->TotalRecs = $producto_bodega_grid->Recordset->RecordCount();
		}
		$producto_bodega_grid->StartRec = 1;
		$producto_bodega_grid->DisplayRecs = $producto_bodega_grid->TotalRecs;
	} else {
		$producto_bodega->CurrentFilter = "0=1";
		$producto_bodega_grid->StartRec = 1;
		$producto_bodega_grid->DisplayRecs = $producto_bodega->GridAddRowCount;
	}
	$producto_bodega_grid->TotalRecs = $producto_bodega_grid->DisplayRecs;
	$producto_bodega_grid->StopRec = $producto_bodega_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$producto_bodega_grid->TotalRecs = $producto_bodega->SelectRecordCount();
	} else {
		if ($producto_bodega_grid->Recordset = $producto_bodega_grid->LoadRecordset())
			$producto_bodega_grid->TotalRecs = $producto_bodega_grid->Recordset->RecordCount();
	}
	$producto_bodega_grid->StartRec = 1;
	$producto_bodega_grid->DisplayRecs = $producto_bodega_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$producto_bodega_grid->Recordset = $producto_bodega_grid->LoadRecordset($producto_bodega_grid->StartRec-1, $producto_bodega_grid->DisplayRecs);

	// Set no record found message
	if ($producto_bodega->CurrentAction == "" && $producto_bodega_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$producto_bodega_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($producto_bodega_grid->SearchWhere == "0=101")
			$producto_bodega_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$producto_bodega_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$producto_bodega_grid->RenderOtherOptions();
?>
<?php $producto_bodega_grid->ShowPageHeader(); ?>
<?php
$producto_bodega_grid->ShowMessage();
?>
<?php if ($producto_bodega_grid->TotalRecs > 0 || $producto_bodega->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproducto_bodegagrid" class="ewForm form-inline">
<div id="gmp_producto_bodega" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_producto_bodegagrid" class="table ewTable">
<?php echo $producto_bodega->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$producto_bodega_grid->RenderListOptions();

// Render list options (header, left)
$producto_bodega_grid->ListOptions->Render("header", "left");
?>
<?php if ($producto_bodega->idproducto->Visible) { // idproducto ?>
	<?php if ($producto_bodega->SortUrl($producto_bodega->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_producto_bodega_idproducto" class="producto_bodega_idproducto"><div class="ewTableHeaderCaption"><?php echo $producto_bodega->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_producto_bodega_idproducto" class="producto_bodega_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_bodega->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_bodega->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_bodega->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_bodega->idbodega->Visible) { // idbodega ?>
	<?php if ($producto_bodega->SortUrl($producto_bodega->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_producto_bodega_idbodega" class="producto_bodega_idbodega"><div class="ewTableHeaderCaption"><?php echo $producto_bodega->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_producto_bodega_idbodega" class="producto_bodega_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_bodega->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_bodega->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_bodega->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_bodega->existencia->Visible) { // existencia ?>
	<?php if ($producto_bodega->SortUrl($producto_bodega->existencia) == "") { ?>
		<th data-name="existencia"><div id="elh_producto_bodega_existencia" class="producto_bodega_existencia"><div class="ewTableHeaderCaption"><?php echo $producto_bodega->existencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="existencia"><div><div id="elh_producto_bodega_existencia" class="producto_bodega_existencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_bodega->existencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_bodega->existencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_bodega->existencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$producto_bodega_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$producto_bodega_grid->StartRec = 1;
$producto_bodega_grid->StopRec = $producto_bodega_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($producto_bodega_grid->FormKeyCountName) && ($producto_bodega->CurrentAction == "gridadd" || $producto_bodega->CurrentAction == "gridedit" || $producto_bodega->CurrentAction == "F")) {
		$producto_bodega_grid->KeyCount = $objForm->GetValue($producto_bodega_grid->FormKeyCountName);
		$producto_bodega_grid->StopRec = $producto_bodega_grid->StartRec + $producto_bodega_grid->KeyCount - 1;
	}
}
$producto_bodega_grid->RecCnt = $producto_bodega_grid->StartRec - 1;
if ($producto_bodega_grid->Recordset && !$producto_bodega_grid->Recordset->EOF) {
	$producto_bodega_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $producto_bodega_grid->StartRec > 1)
		$producto_bodega_grid->Recordset->Move($producto_bodega_grid->StartRec - 1);
} elseif (!$producto_bodega->AllowAddDeleteRow && $producto_bodega_grid->StopRec == 0) {
	$producto_bodega_grid->StopRec = $producto_bodega->GridAddRowCount;
}

// Initialize aggregate
$producto_bodega->RowType = EW_ROWTYPE_AGGREGATEINIT;
$producto_bodega->ResetAttrs();
$producto_bodega_grid->RenderRow();
if ($producto_bodega->CurrentAction == "gridadd")
	$producto_bodega_grid->RowIndex = 0;
if ($producto_bodega->CurrentAction == "gridedit")
	$producto_bodega_grid->RowIndex = 0;
while ($producto_bodega_grid->RecCnt < $producto_bodega_grid->StopRec) {
	$producto_bodega_grid->RecCnt++;
	if (intval($producto_bodega_grid->RecCnt) >= intval($producto_bodega_grid->StartRec)) {
		$producto_bodega_grid->RowCnt++;
		if ($producto_bodega->CurrentAction == "gridadd" || $producto_bodega->CurrentAction == "gridedit" || $producto_bodega->CurrentAction == "F") {
			$producto_bodega_grid->RowIndex++;
			$objForm->Index = $producto_bodega_grid->RowIndex;
			if ($objForm->HasValue($producto_bodega_grid->FormActionName))
				$producto_bodega_grid->RowAction = strval($objForm->GetValue($producto_bodega_grid->FormActionName));
			elseif ($producto_bodega->CurrentAction == "gridadd")
				$producto_bodega_grid->RowAction = "insert";
			else
				$producto_bodega_grid->RowAction = "";
		}

		// Set up key count
		$producto_bodega_grid->KeyCount = $producto_bodega_grid->RowIndex;

		// Init row class and style
		$producto_bodega->ResetAttrs();
		$producto_bodega->CssClass = "";
		if ($producto_bodega->CurrentAction == "gridadd") {
			if ($producto_bodega->CurrentMode == "copy") {
				$producto_bodega_grid->LoadRowValues($producto_bodega_grid->Recordset); // Load row values
				$producto_bodega_grid->SetRecordKey($producto_bodega_grid->RowOldKey, $producto_bodega_grid->Recordset); // Set old record key
			} else {
				$producto_bodega_grid->LoadDefaultValues(); // Load default values
				$producto_bodega_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$producto_bodega_grid->LoadRowValues($producto_bodega_grid->Recordset); // Load row values
		}
		$producto_bodega->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($producto_bodega->CurrentAction == "gridadd") // Grid add
			$producto_bodega->RowType = EW_ROWTYPE_ADD; // Render add
		if ($producto_bodega->CurrentAction == "gridadd" && $producto_bodega->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$producto_bodega_grid->RestoreCurrentRowFormValues($producto_bodega_grid->RowIndex); // Restore form values
		if ($producto_bodega->CurrentAction == "gridedit") { // Grid edit
			if ($producto_bodega->EventCancelled) {
				$producto_bodega_grid->RestoreCurrentRowFormValues($producto_bodega_grid->RowIndex); // Restore form values
			}
			if ($producto_bodega_grid->RowAction == "insert")
				$producto_bodega->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$producto_bodega->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($producto_bodega->CurrentAction == "gridedit" && ($producto_bodega->RowType == EW_ROWTYPE_EDIT || $producto_bodega->RowType == EW_ROWTYPE_ADD) && $producto_bodega->EventCancelled) // Update failed
			$producto_bodega_grid->RestoreCurrentRowFormValues($producto_bodega_grid->RowIndex); // Restore form values
		if ($producto_bodega->RowType == EW_ROWTYPE_EDIT) // Edit row
			$producto_bodega_grid->EditRowCnt++;
		if ($producto_bodega->CurrentAction == "F") // Confirm row
			$producto_bodega_grid->RestoreCurrentRowFormValues($producto_bodega_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$producto_bodega->RowAttrs = array_merge($producto_bodega->RowAttrs, array('data-rowindex'=>$producto_bodega_grid->RowCnt, 'id'=>'r' . $producto_bodega_grid->RowCnt . '_producto_bodega', 'data-rowtype'=>$producto_bodega->RowType));

		// Render row
		$producto_bodega_grid->RenderRow();

		// Render list options
		$producto_bodega_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($producto_bodega_grid->RowAction <> "delete" && $producto_bodega_grid->RowAction <> "insertdelete" && !($producto_bodega_grid->RowAction == "insert" && $producto_bodega->CurrentAction == "F" && $producto_bodega_grid->EmptyRow())) {
?>
	<tr<?php echo $producto_bodega->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_bodega_grid->ListOptions->Render("body", "left", $producto_bodega_grid->RowCnt);
?>
	<?php if ($producto_bodega->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $producto_bodega->idproducto->CellAttributes() ?>>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto_bodega->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto"<?php echo $producto_bodega->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idproducto->EditValue)) {
	$arwrk = $producto_bodega->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idproducto->OldValue = "";
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
 $producto_bodega->Lookup_Selecting($producto_bodega->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto_bodega->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto"<?php echo $producto_bodega->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idproducto->EditValue)) {
	$arwrk = $producto_bodega->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idproducto->OldValue = "";
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
 $producto_bodega->Lookup_Selecting($producto_bodega->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<?php echo $producto_bodega->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->OldValue) ?>">
<?php } ?>
<a id="<?php echo $producto_bodega_grid->PageObjName . "_row_" . $producto_bodega_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproducto_bodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto_bodega->CurrentValue) ?>">
<input type="hidden" data-field="x_idproducto_bodega" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto_bodega->OldValue) ?>">
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_EDIT || $producto_bodega->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproducto_bodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto_bodega" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto_bodega->CurrentValue) ?>">
<?php } ?>
	<?php if ($producto_bodega->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $producto_bodega->idbodega->CellAttributes() ?>>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto_bodega->idbodega->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega"<?php echo $producto_bodega->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idbodega->EditValue)) {
	$arwrk = $producto_bodega->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idbodega->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_bodega->Lookup_Selecting($producto_bodega->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto_bodega->idbodega->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega"<?php echo $producto_bodega->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idbodega->EditValue)) {
	$arwrk = $producto_bodega->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idbodega->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_bodega->Lookup_Selecting($producto_bodega->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<?php echo $producto_bodega->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_bodega->existencia->Visible) { // existencia ?>
		<td data-name="existencia"<?php echo $producto_bodega->existencia->CellAttributes() ?>>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_existencia" class="form-group producto_bodega_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_bodega->existencia->PlaceHolder) ?>" value="<?php echo $producto_bodega->existencia->EditValue ?>"<?php echo $producto_bodega->existencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_bodega->existencia->OldValue) ?>">
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_bodega_grid->RowCnt ?>_producto_bodega_existencia" class="form-group producto_bodega_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_bodega->existencia->PlaceHolder) ?>" value="<?php echo $producto_bodega->existencia->EditValue ?>"<?php echo $producto_bodega->existencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_bodega->existencia->ViewAttributes() ?>>
<?php echo $producto_bodega->existencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_bodega->existencia->FormValue) ?>">
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_bodega->existencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_bodega_grid->ListOptions->Render("body", "right", $producto_bodega_grid->RowCnt);
?>
	</tr>
<?php if ($producto_bodega->RowType == EW_ROWTYPE_ADD || $producto_bodega->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproducto_bodegagrid.UpdateOpts(<?php echo $producto_bodega_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($producto_bodega->CurrentAction <> "gridadd" || $producto_bodega->CurrentMode == "copy")
		if (!$producto_bodega_grid->Recordset->EOF) $producto_bodega_grid->Recordset->MoveNext();
}
?>
<?php
	if ($producto_bodega->CurrentMode == "add" || $producto_bodega->CurrentMode == "copy" || $producto_bodega->CurrentMode == "edit") {
		$producto_bodega_grid->RowIndex = '$rowindex$';
		$producto_bodega_grid->LoadDefaultValues();

		// Set row properties
		$producto_bodega->ResetAttrs();
		$producto_bodega->RowAttrs = array_merge($producto_bodega->RowAttrs, array('data-rowindex'=>$producto_bodega_grid->RowIndex, 'id'=>'r0_producto_bodega', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($producto_bodega->RowAttrs["class"], "ewTemplate");
		$producto_bodega->RowType = EW_ROWTYPE_ADD;

		// Render row
		$producto_bodega_grid->RenderRow();

		// Render list options
		$producto_bodega_grid->RenderListOptions();
		$producto_bodega_grid->StartRowCnt = 0;
?>
	<tr<?php echo $producto_bodega->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_bodega_grid->ListOptions->Render("body", "left", $producto_bodega_grid->RowIndex);
?>
	<?php if ($producto_bodega->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($producto_bodega->CurrentAction <> "F") { ?>
<?php if ($producto_bodega->idproducto->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto"<?php echo $producto_bodega->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idproducto->EditValue)) {
	$arwrk = $producto_bodega->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idproducto->OldValue = "";
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
 $producto_bodega->Lookup_Selecting($producto_bodega->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_bodega_idproducto" class="form-group producto_bodega_idproducto">
<span<?php echo $producto_bodega->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_bodega->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($producto_bodega->CurrentAction <> "F") { ?>
<?php if ($producto_bodega->idbodega->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega"<?php echo $producto_bodega->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idbodega->EditValue)) {
	$arwrk = $producto_bodega->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_bodega->idbodega->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto_bodega->Lookup_Selecting($producto_bodega->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_bodega_idbodega" class="form-group producto_bodega_idbodega">
<span<?php echo $producto_bodega->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="x<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_bodega_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_bodega->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_bodega->existencia->Visible) { // existencia ?>
		<td>
<?php if ($producto_bodega->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_bodega_existencia" class="form-group producto_bodega_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_bodega->existencia->PlaceHolder) ?>" value="<?php echo $producto_bodega->existencia->EditValue ?>"<?php echo $producto_bodega->existencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_bodega_existencia" class="form-group producto_bodega_existencia">
<span<?php echo $producto_bodega->existencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_bodega->existencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="x<?php echo $producto_bodega_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_bodega->existencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" id="o<?php echo $producto_bodega_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto_bodega->existencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_bodega_grid->ListOptions->Render("body", "right", $producto_bodega_grid->RowCnt);
?>
<script type="text/javascript">
fproducto_bodegagrid.UpdateOpts(<?php echo $producto_bodega_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($producto_bodega->CurrentMode == "add" || $producto_bodega->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $producto_bodega_grid->FormKeyCountName ?>" id="<?php echo $producto_bodega_grid->FormKeyCountName ?>" value="<?php echo $producto_bodega_grid->KeyCount ?>">
<?php echo $producto_bodega_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_bodega->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $producto_bodega_grid->FormKeyCountName ?>" id="<?php echo $producto_bodega_grid->FormKeyCountName ?>" value="<?php echo $producto_bodega_grid->KeyCount ?>">
<?php echo $producto_bodega_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_bodega->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproducto_bodegagrid">
</div>
<?php

// Close recordset
if ($producto_bodega_grid->Recordset)
	$producto_bodega_grid->Recordset->Close();
?>
<?php if ($producto_bodega_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($producto_bodega_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($producto_bodega_grid->TotalRecs == 0 && $producto_bodega->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($producto_bodega_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($producto_bodega->Export == "") { ?>
<script type="text/javascript">
fproducto_bodegagrid.Init();
</script>
<?php } ?>
<?php
$producto_bodega_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$producto_bodega_grid->Page_Terminate();
?>
