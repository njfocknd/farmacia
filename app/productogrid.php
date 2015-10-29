<?php

// Create page object
if (!isset($producto_grid)) $producto_grid = new cproducto_grid();

// Page init
$producto_grid->Page_Init();

// Page main
$producto_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_grid->Page_Render();
?>
<?php if ($producto->Export == "") { ?>
<script type="text/javascript">

// Page object
var producto_grid = new ew_Page("producto_grid");
producto_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = producto_grid.PageID; // For backward compatibility

// Form object
var fproductogrid = new ew_Form("fproductogrid");
fproductogrid.FormKeyCountName = '<?php echo $producto_grid->FormKeyCountName ?>';

// Validate form
fproductogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idmarca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idmarca->FldCaption(), $producto->idmarca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->nombre->FldCaption(), $producto->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idpais->FldCaption(), $producto->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->estado->FldCaption(), $producto->estado->ReqErrMsg)) ?>");

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
fproductogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idmarca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fproductogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductogrid.ValidateRequired = true;
<?php } else { ?>
fproductogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproductogrid.Lists["x_idmarca"] = {"LinkField":"x_idmarca","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproductogrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($producto->CurrentAction == "gridadd") {
	if ($producto->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$producto_grid->TotalRecs = $producto->SelectRecordCount();
			$producto_grid->Recordset = $producto_grid->LoadRecordset($producto_grid->StartRec-1, $producto_grid->DisplayRecs);
		} else {
			if ($producto_grid->Recordset = $producto_grid->LoadRecordset())
				$producto_grid->TotalRecs = $producto_grid->Recordset->RecordCount();
		}
		$producto_grid->StartRec = 1;
		$producto_grid->DisplayRecs = $producto_grid->TotalRecs;
	} else {
		$producto->CurrentFilter = "0=1";
		$producto_grid->StartRec = 1;
		$producto_grid->DisplayRecs = $producto->GridAddRowCount;
	}
	$producto_grid->TotalRecs = $producto_grid->DisplayRecs;
	$producto_grid->StopRec = $producto_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$producto_grid->TotalRecs = $producto->SelectRecordCount();
	} else {
		if ($producto_grid->Recordset = $producto_grid->LoadRecordset())
			$producto_grid->TotalRecs = $producto_grid->Recordset->RecordCount();
	}
	$producto_grid->StartRec = 1;
	$producto_grid->DisplayRecs = $producto_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$producto_grid->Recordset = $producto_grid->LoadRecordset($producto_grid->StartRec-1, $producto_grid->DisplayRecs);

	// Set no record found message
	if ($producto->CurrentAction == "" && $producto_grid->TotalRecs == 0) {
		if ($producto_grid->SearchWhere == "0=101")
			$producto_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$producto_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$producto_grid->RenderOtherOptions();
?>
<?php $producto_grid->ShowPageHeader(); ?>
<?php
$producto_grid->ShowMessage();
?>
<?php if ($producto_grid->TotalRecs > 0 || $producto->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproductogrid" class="ewForm form-inline">
<div id="gmp_producto" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_productogrid" class="table ewTable">
<?php echo $producto->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$producto_grid->RenderListOptions();

// Render list options (header, left)
$producto_grid->ListOptions->Render("header", "left");
?>
<?php if ($producto->idmarca->Visible) { // idmarca ?>
	<?php if ($producto->SortUrl($producto->idmarca) == "") { ?>
		<th data-name="idmarca"><div id="elh_producto_idmarca" class="producto_idmarca"><div class="ewTableHeaderCaption"><?php echo $producto->idmarca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idmarca"><div><div id="elh_producto_idmarca" class="producto_idmarca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->idmarca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->idmarca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->idmarca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->nombre->Visible) { // nombre ?>
	<?php if ($producto->SortUrl($producto->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_producto_nombre" class="producto_nombre"><div class="ewTableHeaderCaption"><?php echo $producto->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_producto_nombre" class="producto_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->idpais->Visible) { // idpais ?>
	<?php if ($producto->SortUrl($producto->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_producto_idpais" class="producto_idpais"><div class="ewTableHeaderCaption"><?php echo $producto->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_producto_idpais" class="producto_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->estado->Visible) { // estado ?>
	<?php if ($producto->SortUrl($producto->estado) == "") { ?>
		<th data-name="estado"><div id="elh_producto_estado" class="producto_estado"><div class="ewTableHeaderCaption"><?php echo $producto->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_producto_estado" class="producto_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$producto_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$producto_grid->StartRec = 1;
$producto_grid->StopRec = $producto_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($producto_grid->FormKeyCountName) && ($producto->CurrentAction == "gridadd" || $producto->CurrentAction == "gridedit" || $producto->CurrentAction == "F")) {
		$producto_grid->KeyCount = $objForm->GetValue($producto_grid->FormKeyCountName);
		$producto_grid->StopRec = $producto_grid->StartRec + $producto_grid->KeyCount - 1;
	}
}
$producto_grid->RecCnt = $producto_grid->StartRec - 1;
if ($producto_grid->Recordset && !$producto_grid->Recordset->EOF) {
	$producto_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $producto_grid->StartRec > 1)
		$producto_grid->Recordset->Move($producto_grid->StartRec - 1);
} elseif (!$producto->AllowAddDeleteRow && $producto_grid->StopRec == 0) {
	$producto_grid->StopRec = $producto->GridAddRowCount;
}

// Initialize aggregate
$producto->RowType = EW_ROWTYPE_AGGREGATEINIT;
$producto->ResetAttrs();
$producto_grid->RenderRow();
if ($producto->CurrentAction == "gridadd")
	$producto_grid->RowIndex = 0;
if ($producto->CurrentAction == "gridedit")
	$producto_grid->RowIndex = 0;
while ($producto_grid->RecCnt < $producto_grid->StopRec) {
	$producto_grid->RecCnt++;
	if (intval($producto_grid->RecCnt) >= intval($producto_grid->StartRec)) {
		$producto_grid->RowCnt++;
		if ($producto->CurrentAction == "gridadd" || $producto->CurrentAction == "gridedit" || $producto->CurrentAction == "F") {
			$producto_grid->RowIndex++;
			$objForm->Index = $producto_grid->RowIndex;
			if ($objForm->HasValue($producto_grid->FormActionName))
				$producto_grid->RowAction = strval($objForm->GetValue($producto_grid->FormActionName));
			elseif ($producto->CurrentAction == "gridadd")
				$producto_grid->RowAction = "insert";
			else
				$producto_grid->RowAction = "";
		}

		// Set up key count
		$producto_grid->KeyCount = $producto_grid->RowIndex;

		// Init row class and style
		$producto->ResetAttrs();
		$producto->CssClass = "";
		if ($producto->CurrentAction == "gridadd") {
			if ($producto->CurrentMode == "copy") {
				$producto_grid->LoadRowValues($producto_grid->Recordset); // Load row values
				$producto_grid->SetRecordKey($producto_grid->RowOldKey, $producto_grid->Recordset); // Set old record key
			} else {
				$producto_grid->LoadDefaultValues(); // Load default values
				$producto_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$producto_grid->LoadRowValues($producto_grid->Recordset); // Load row values
		}
		$producto->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($producto->CurrentAction == "gridadd") // Grid add
			$producto->RowType = EW_ROWTYPE_ADD; // Render add
		if ($producto->CurrentAction == "gridadd" && $producto->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$producto_grid->RestoreCurrentRowFormValues($producto_grid->RowIndex); // Restore form values
		if ($producto->CurrentAction == "gridedit") { // Grid edit
			if ($producto->EventCancelled) {
				$producto_grid->RestoreCurrentRowFormValues($producto_grid->RowIndex); // Restore form values
			}
			if ($producto_grid->RowAction == "insert")
				$producto->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$producto->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($producto->CurrentAction == "gridedit" && ($producto->RowType == EW_ROWTYPE_EDIT || $producto->RowType == EW_ROWTYPE_ADD) && $producto->EventCancelled) // Update failed
			$producto_grid->RestoreCurrentRowFormValues($producto_grid->RowIndex); // Restore form values
		if ($producto->RowType == EW_ROWTYPE_EDIT) // Edit row
			$producto_grid->EditRowCnt++;
		if ($producto->CurrentAction == "F") // Confirm row
			$producto_grid->RestoreCurrentRowFormValues($producto_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$producto->RowAttrs = array_merge($producto->RowAttrs, array('data-rowindex'=>$producto_grid->RowCnt, 'id'=>'r' . $producto_grid->RowCnt . '_producto', 'data-rowtype'=>$producto->RowType));

		// Render row
		$producto_grid->RenderRow();

		// Render list options
		$producto_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($producto_grid->RowAction <> "delete" && $producto_grid->RowAction <> "insertdelete" && !($producto_grid->RowAction == "insert" && $producto->CurrentAction == "F" && $producto_grid->EmptyRow())) {
?>
	<tr<?php echo $producto->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_grid->ListOptions->Render("body", "left", $producto_grid->RowCnt);
?>
	<?php if ($producto->idmarca->Visible) { // idmarca ?>
		<td data-name="idmarca"<?php echo $producto->idmarca->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto->idmarca->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idmarca" class="form-group producto_idmarca">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idmarca" class="form-group producto_idmarca">
<select data-field="x_idmarca" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca"<?php echo $producto->idmarca->EditAttributes() ?>>
<?php
if (is_array($producto->idmarca->EditValue)) {
	$arwrk = $producto->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" id="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idmarca" name="o<?php echo $producto_grid->RowIndex ?>_idmarca" id="o<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto->idmarca->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idmarca" class="form-group producto_idmarca">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idmarca" class="form-group producto_idmarca">
<select data-field="x_idmarca" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca"<?php echo $producto->idmarca->EditAttributes() ?>>
<?php
if (is_array($producto->idmarca->EditValue)) {
	$arwrk = $producto->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" id="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<?php echo $producto->idmarca->ListViewValue() ?></span>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->FormValue) ?>">
<input type="hidden" data-field="x_idmarca" name="o<?php echo $producto_grid->RowIndex ?>_idmarca" id="o<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->OldValue) ?>">
<?php } ?>
<a id="<?php echo $producto_grid->PageObjName . "_row_" . $producto_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto->idproducto->CurrentValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT || $producto->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto->idproducto->CurrentValue) ?>">
<?php } ?>
	<?php if ($producto->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $producto->nombre->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_nombre" class="form-group producto_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $producto_grid->RowIndex ?>_nombre" id="x<?php echo $producto_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->nombre->PlaceHolder) ?>" value="<?php echo $producto->nombre->EditValue ?>"<?php echo $producto->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $producto_grid->RowIndex ?>_nombre" id="o<?php echo $producto_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($producto->nombre->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_nombre" class="form-group producto_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $producto_grid->RowIndex ?>_nombre" id="x<?php echo $producto_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->nombre->PlaceHolder) ?>" value="<?php echo $producto->nombre->EditValue ?>"<?php echo $producto->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->nombre->ViewAttributes() ?>>
<?php echo $producto->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $producto_grid->RowIndex ?>_nombre" id="x<?php echo $producto_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($producto->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $producto_grid->RowIndex ?>_nombre" id="o<?php echo $producto_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($producto->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $producto->idpais->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idpais" class="form-group producto_idpais">
<select data-field="x_idpais" id="x<?php echo $producto_grid->RowIndex ?>_idpais" name="x<?php echo $producto_grid->RowIndex ?>_idpais"<?php echo $producto->idpais->EditAttributes() ?>>
<?php
if (is_array($producto->idpais->EditValue)) {
	$arwrk = $producto->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idpais" id="s_x<?php echo $producto_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idpais" name="o<?php echo $producto_grid->RowIndex ?>_idpais" id="o<?php echo $producto_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($producto->idpais->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idpais" class="form-group producto_idpais">
<select data-field="x_idpais" id="x<?php echo $producto_grid->RowIndex ?>_idpais" name="x<?php echo $producto_grid->RowIndex ?>_idpais"<?php echo $producto->idpais->EditAttributes() ?>>
<?php
if (is_array($producto->idpais->EditValue)) {
	$arwrk = $producto->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idpais" id="s_x<?php echo $producto_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->idpais->ViewAttributes() ?>>
<?php echo $producto->idpais->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $producto_grid->RowIndex ?>_idpais" id="x<?php echo $producto_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($producto->idpais->FormValue) ?>">
<input type="hidden" data-field="x_idpais" name="o<?php echo $producto_grid->RowIndex ?>_idpais" id="o<?php echo $producto_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($producto->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $producto->estado->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_estado" class="form-group producto_estado">
<select data-field="x_estado" id="x<?php echo $producto_grid->RowIndex ?>_estado" name="x<?php echo $producto_grid->RowIndex ?>_estado"<?php echo $producto->estado->EditAttributes() ?>>
<?php
if (is_array($producto->estado->EditValue)) {
	$arwrk = $producto->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->estado->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $producto_grid->RowIndex ?>_estado" id="o<?php echo $producto_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($producto->estado->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_estado" class="form-group producto_estado">
<select data-field="x_estado" id="x<?php echo $producto_grid->RowIndex ?>_estado" name="x<?php echo $producto_grid->RowIndex ?>_estado"<?php echo $producto->estado->EditAttributes() ?>>
<?php
if (is_array($producto->estado->EditValue)) {
	$arwrk = $producto->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->estado->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->estado->ViewAttributes() ?>>
<?php echo $producto->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $producto_grid->RowIndex ?>_estado" id="x<?php echo $producto_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($producto->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $producto_grid->RowIndex ?>_estado" id="o<?php echo $producto_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($producto->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_grid->ListOptions->Render("body", "right", $producto_grid->RowCnt);
?>
	</tr>
<?php if ($producto->RowType == EW_ROWTYPE_ADD || $producto->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproductogrid.UpdateOpts(<?php echo $producto_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($producto->CurrentAction <> "gridadd" || $producto->CurrentMode == "copy")
		if (!$producto_grid->Recordset->EOF) $producto_grid->Recordset->MoveNext();
}
?>
<?php
	if ($producto->CurrentMode == "add" || $producto->CurrentMode == "copy" || $producto->CurrentMode == "edit") {
		$producto_grid->RowIndex = '$rowindex$';
		$producto_grid->LoadDefaultValues();

		// Set row properties
		$producto->ResetAttrs();
		$producto->RowAttrs = array_merge($producto->RowAttrs, array('data-rowindex'=>$producto_grid->RowIndex, 'id'=>'r0_producto', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($producto->RowAttrs["class"], "ewTemplate");
		$producto->RowType = EW_ROWTYPE_ADD;

		// Render row
		$producto_grid->RenderRow();

		// Render list options
		$producto_grid->RenderListOptions();
		$producto_grid->StartRowCnt = 0;
?>
	<tr<?php echo $producto->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_grid->ListOptions->Render("body", "left", $producto_grid->RowIndex);
?>
	<?php if ($producto->idmarca->Visible) { // idmarca ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<?php if ($producto->idmarca->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_idmarca" class="form-group producto_idmarca">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_idmarca" class="form-group producto_idmarca">
<select data-field="x_idmarca" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca"<?php echo $producto->idmarca->EditAttributes() ?>>
<?php
if (is_array($producto->idmarca->EditValue)) {
	$arwrk = $producto->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" id="s_x<?php echo $producto_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_idmarca" class="form-group producto_idmarca">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $producto_grid->RowIndex ?>_idmarca" id="x<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idmarca" name="o<?php echo $producto_grid->RowIndex ?>_idmarca" id="o<?php echo $producto_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->nombre->Visible) { // nombre ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_nombre" class="form-group producto_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $producto_grid->RowIndex ?>_nombre" id="x<?php echo $producto_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->nombre->PlaceHolder) ?>" value="<?php echo $producto->nombre->EditValue ?>"<?php echo $producto->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_nombre" class="form-group producto_nombre">
<span<?php echo $producto->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $producto_grid->RowIndex ?>_nombre" id="x<?php echo $producto_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($producto->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $producto_grid->RowIndex ?>_nombre" id="o<?php echo $producto_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($producto->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->idpais->Visible) { // idpais ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_idpais" class="form-group producto_idpais">
<select data-field="x_idpais" id="x<?php echo $producto_grid->RowIndex ?>_idpais" name="x<?php echo $producto_grid->RowIndex ?>_idpais"<?php echo $producto->idpais->EditAttributes() ?>>
<?php
if (is_array($producto->idpais->EditValue)) {
	$arwrk = $producto->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idpais" id="s_x<?php echo $producto_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_idpais" class="form-group producto_idpais">
<span<?php echo $producto->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $producto_grid->RowIndex ?>_idpais" id="x<?php echo $producto_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($producto->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $producto_grid->RowIndex ?>_idpais" id="o<?php echo $producto_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($producto->idpais->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->estado->Visible) { // estado ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_estado" class="form-group producto_estado">
<select data-field="x_estado" id="x<?php echo $producto_grid->RowIndex ?>_estado" name="x<?php echo $producto_grid->RowIndex ?>_estado"<?php echo $producto->estado->EditAttributes() ?>>
<?php
if (is_array($producto->estado->EditValue)) {
	$arwrk = $producto->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->estado->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_estado" class="form-group producto_estado">
<span<?php echo $producto->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $producto_grid->RowIndex ?>_estado" id="x<?php echo $producto_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($producto->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $producto_grid->RowIndex ?>_estado" id="o<?php echo $producto_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($producto->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_grid->ListOptions->Render("body", "right", $producto_grid->RowCnt);
?>
<script type="text/javascript">
fproductogrid.UpdateOpts(<?php echo $producto_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($producto->CurrentMode == "add" || $producto->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $producto_grid->FormKeyCountName ?>" id="<?php echo $producto_grid->FormKeyCountName ?>" value="<?php echo $producto_grid->KeyCount ?>">
<?php echo $producto_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $producto_grid->FormKeyCountName ?>" id="<?php echo $producto_grid->FormKeyCountName ?>" value="<?php echo $producto_grid->KeyCount ?>">
<?php echo $producto_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproductogrid">
</div>
<?php

// Close recordset
if ($producto_grid->Recordset)
	$producto_grid->Recordset->Close();
?>
<?php if ($producto_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($producto_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($producto_grid->TotalRecs == 0 && $producto->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($producto_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($producto->Export == "") { ?>
<script type="text/javascript">
fproductogrid.Init();
</script>
<?php } ?>
<?php
$producto_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$producto_grid->Page_Terminate();
?>
