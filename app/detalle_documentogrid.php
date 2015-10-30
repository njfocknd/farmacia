<?php

// Create page object
if (!isset($detalle_documento_grid)) $detalle_documento_grid = new cdetalle_documento_grid();

// Page init
$detalle_documento_grid->Page_Init();

// Page main
$detalle_documento_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_grid->Page_Render();
?>
<?php if ($detalle_documento->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_grid = new ew_Page("detalle_documento_grid");
detalle_documento_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = detalle_documento_grid.PageID; // For backward compatibility

// Form object
var fdetalle_documentogrid = new ew_Form("fdetalle_documentogrid");
fdetalle_documentogrid.FormKeyCountName = '<?php echo $detalle_documento_grid->FormKeyCountName ?>';

// Validate form
fdetalle_documentogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->iddocumento->FldCaption(), $detalle_documento->iddocumento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->idproducto->FldCaption(), $detalle_documento->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->idbodega->FldCaption(), $detalle_documento->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->cantidad->FldCaption(), $detalle_documento->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento->cantidad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->precio->FldCaption(), $detalle_documento->precio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento->precio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento->monto->FldCaption(), $detalle_documento->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento->monto->FldErrMsg()) ?>");

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
fdetalle_documentogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documentogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documentogrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_documentogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documentogrid.Lists["x_iddocumento"] = {"LinkField":"x_iddocumento","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documentogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documentogrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_documento->CurrentAction == "gridadd") {
	if ($detalle_documento->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$detalle_documento_grid->TotalRecs = $detalle_documento->SelectRecordCount();
			$detalle_documento_grid->Recordset = $detalle_documento_grid->LoadRecordset($detalle_documento_grid->StartRec-1, $detalle_documento_grid->DisplayRecs);
		} else {
			if ($detalle_documento_grid->Recordset = $detalle_documento_grid->LoadRecordset())
				$detalle_documento_grid->TotalRecs = $detalle_documento_grid->Recordset->RecordCount();
		}
		$detalle_documento_grid->StartRec = 1;
		$detalle_documento_grid->DisplayRecs = $detalle_documento_grid->TotalRecs;
	} else {
		$detalle_documento->CurrentFilter = "0=1";
		$detalle_documento_grid->StartRec = 1;
		$detalle_documento_grid->DisplayRecs = $detalle_documento->GridAddRowCount;
	}
	$detalle_documento_grid->TotalRecs = $detalle_documento_grid->DisplayRecs;
	$detalle_documento_grid->StopRec = $detalle_documento_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_grid->TotalRecs = $detalle_documento->SelectRecordCount();
	} else {
		if ($detalle_documento_grid->Recordset = $detalle_documento_grid->LoadRecordset())
			$detalle_documento_grid->TotalRecs = $detalle_documento_grid->Recordset->RecordCount();
	}
	$detalle_documento_grid->StartRec = 1;
	$detalle_documento_grid->DisplayRecs = $detalle_documento_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_documento_grid->Recordset = $detalle_documento_grid->LoadRecordset($detalle_documento_grid->StartRec-1, $detalle_documento_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_documento->CurrentAction == "" && $detalle_documento_grid->TotalRecs == 0) {
		if ($detalle_documento_grid->SearchWhere == "0=101")
			$detalle_documento_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_grid->RenderOtherOptions();
?>
<?php $detalle_documento_grid->ShowPageHeader(); ?>
<?php
$detalle_documento_grid->ShowMessage();
?>
<?php if ($detalle_documento_grid->TotalRecs > 0 || $detalle_documento->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdetalle_documentogrid" class="ewForm form-inline">
<div id="gmp_detalle_documento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_documentogrid" class="table ewTable">
<?php echo $detalle_documento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_grid->RenderListOptions();

// Render list options (header, left)
$detalle_documento_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento->iddocumento->Visible) { // iddocumento ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->iddocumento) == "") { ?>
		<th data-name="iddocumento"><div id="elh_detalle_documento_iddocumento" class="detalle_documento_iddocumento"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->iddocumento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento"><div><div id="elh_detalle_documento_iddocumento" class="detalle_documento_iddocumento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->iddocumento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->iddocumento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->iddocumento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_idproducto" class="detalle_documento_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_detalle_documento_idproducto" class="detalle_documento_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento->idbodega->Visible) { // idbodega ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_detalle_documento_idbodega" class="detalle_documento_idbodega"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_detalle_documento_idbodega" class="detalle_documento_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_cantidad" class="detalle_documento_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div><div id="elh_detalle_documento_cantidad" class="detalle_documento_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento->precio->Visible) { // precio ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->precio) == "") { ?>
		<th data-name="precio"><div id="elh_detalle_documento_precio" class="detalle_documento_precio"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->precio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio"><div><div id="elh_detalle_documento_precio" class="detalle_documento_precio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->precio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->precio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->precio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento->monto->Visible) { // monto ?>
	<?php if ($detalle_documento->SortUrl($detalle_documento->monto) == "") { ?>
		<th data-name="monto"><div id="elh_detalle_documento_monto" class="detalle_documento_monto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_detalle_documento_monto" class="detalle_documento_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_documento_grid->StartRec = 1;
$detalle_documento_grid->StopRec = $detalle_documento_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_grid->FormKeyCountName) && ($detalle_documento->CurrentAction == "gridadd" || $detalle_documento->CurrentAction == "gridedit" || $detalle_documento->CurrentAction == "F")) {
		$detalle_documento_grid->KeyCount = $objForm->GetValue($detalle_documento_grid->FormKeyCountName);
		$detalle_documento_grid->StopRec = $detalle_documento_grid->StartRec + $detalle_documento_grid->KeyCount - 1;
	}
}
$detalle_documento_grid->RecCnt = $detalle_documento_grid->StartRec - 1;
if ($detalle_documento_grid->Recordset && !$detalle_documento_grid->Recordset->EOF) {
	$detalle_documento_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_grid->StartRec > 1)
		$detalle_documento_grid->Recordset->Move($detalle_documento_grid->StartRec - 1);
} elseif (!$detalle_documento->AllowAddDeleteRow && $detalle_documento_grid->StopRec == 0) {
	$detalle_documento_grid->StopRec = $detalle_documento->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento->ResetAttrs();
$detalle_documento_grid->RenderRow();
if ($detalle_documento->CurrentAction == "gridadd")
	$detalle_documento_grid->RowIndex = 0;
if ($detalle_documento->CurrentAction == "gridedit")
	$detalle_documento_grid->RowIndex = 0;
while ($detalle_documento_grid->RecCnt < $detalle_documento_grid->StopRec) {
	$detalle_documento_grid->RecCnt++;
	if (intval($detalle_documento_grid->RecCnt) >= intval($detalle_documento_grid->StartRec)) {
		$detalle_documento_grid->RowCnt++;
		if ($detalle_documento->CurrentAction == "gridadd" || $detalle_documento->CurrentAction == "gridedit" || $detalle_documento->CurrentAction == "F") {
			$detalle_documento_grid->RowIndex++;
			$objForm->Index = $detalle_documento_grid->RowIndex;
			if ($objForm->HasValue($detalle_documento_grid->FormActionName))
				$detalle_documento_grid->RowAction = strval($objForm->GetValue($detalle_documento_grid->FormActionName));
			elseif ($detalle_documento->CurrentAction == "gridadd")
				$detalle_documento_grid->RowAction = "insert";
			else
				$detalle_documento_grid->RowAction = "";
		}

		// Set up key count
		$detalle_documento_grid->KeyCount = $detalle_documento_grid->RowIndex;

		// Init row class and style
		$detalle_documento->ResetAttrs();
		$detalle_documento->CssClass = "";
		if ($detalle_documento->CurrentAction == "gridadd") {
			if ($detalle_documento->CurrentMode == "copy") {
				$detalle_documento_grid->LoadRowValues($detalle_documento_grid->Recordset); // Load row values
				$detalle_documento_grid->SetRecordKey($detalle_documento_grid->RowOldKey, $detalle_documento_grid->Recordset); // Set old record key
			} else {
				$detalle_documento_grid->LoadDefaultValues(); // Load default values
				$detalle_documento_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_documento_grid->LoadRowValues($detalle_documento_grid->Recordset); // Load row values
		}
		$detalle_documento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento->CurrentAction == "gridadd") // Grid add
			$detalle_documento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento->CurrentAction == "gridadd" && $detalle_documento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_grid->RestoreCurrentRowFormValues($detalle_documento_grid->RowIndex); // Restore form values
		if ($detalle_documento->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento->EventCancelled) {
				$detalle_documento_grid->RestoreCurrentRowFormValues($detalle_documento_grid->RowIndex); // Restore form values
			}
			if ($detalle_documento_grid->RowAction == "insert")
				$detalle_documento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento->CurrentAction == "gridedit" && ($detalle_documento->RowType == EW_ROWTYPE_EDIT || $detalle_documento->RowType == EW_ROWTYPE_ADD) && $detalle_documento->EventCancelled) // Update failed
			$detalle_documento_grid->RestoreCurrentRowFormValues($detalle_documento_grid->RowIndex); // Restore form values
		if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_grid->EditRowCnt++;
		if ($detalle_documento->CurrentAction == "F") // Confirm row
			$detalle_documento_grid->RestoreCurrentRowFormValues($detalle_documento_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_documento->RowAttrs = array_merge($detalle_documento->RowAttrs, array('data-rowindex'=>$detalle_documento_grid->RowCnt, 'id'=>'r' . $detalle_documento_grid->RowCnt . '_detalle_documento', 'data-rowtype'=>$detalle_documento->RowType));

		// Render row
		$detalle_documento_grid->RenderRow();

		// Render list options
		$detalle_documento_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_grid->RowAction <> "delete" && $detalle_documento_grid->RowAction <> "insertdelete" && !($detalle_documento_grid->RowAction == "insert" && $detalle_documento->CurrentAction == "F" && $detalle_documento_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_grid->ListOptions->Render("body", "left", $detalle_documento_grid->RowCnt);
?>
	<?php if ($detalle_documento->iddocumento->Visible) { // iddocumento ?>
		<td data-name="iddocumento"<?php echo $detalle_documento->iddocumento->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento->iddocumento->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<span<?php echo $detalle_documento->iddocumento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->iddocumento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<select data-field="x_iddocumento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento"<?php echo $detalle_documento->iddocumento->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->iddocumento->EditValue)) {
	$arwrk = $detalle_documento->iddocumento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->iddocumento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->iddocumento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento->Lookup_Selecting($detalle_documento->iddocumento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento" name="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento->iddocumento->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<span<?php echo $detalle_documento->iddocumento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->iddocumento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<select data-field="x_iddocumento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento"<?php echo $detalle_documento->iddocumento->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->iddocumento->EditValue)) {
	$arwrk = $detalle_documento->iddocumento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->iddocumento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->iddocumento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento->Lookup_Selecting($detalle_documento->iddocumento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->iddocumento->ViewAttributes() ?>>
<?php echo $detalle_documento->iddocumento->ListViewValue() ?></span>
<input type="hidden" data-field="x_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->FormValue) ?>">
<input type="hidden" data-field="x_iddocumento" name="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_documento_grid->PageObjName . "_row_" . $detalle_documento_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" value="<?php echo ew_HtmlEncode($detalle_documento->iddetalle_documento->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento" name="o<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" id="o<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" value="<?php echo ew_HtmlEncode($detalle_documento->iddetalle_documento->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT || $detalle_documento->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddetalle_documento" value="<?php echo ew_HtmlEncode($detalle_documento->iddetalle_documento->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_idproducto" class="form-group detalle_documento_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idproducto->EditValue)) {
	$arwrk = $detalle_documento->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idproducto->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_idproducto" class="form-group detalle_documento_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idproducto->EditValue)) {
	$arwrk = $detalle_documento->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idproducto->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $detalle_documento->idbodega->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_idbodega" class="form-group detalle_documento_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idbodega->EditValue)) {
	$arwrk = $detalle_documento->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idbodega->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_idbodega" class="form-group detalle_documento_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idbodega->EditValue)) {
	$arwrk = $detalle_documento->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idbodega->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_cantidad" class="form-group detalle_documento_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento->cantidad->EditValue ?>"<?php echo $detalle_documento->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_cantidad" class="form-group detalle_documento_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento->cantidad->EditValue ?>"<?php echo $detalle_documento->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento->cantidad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento->precio->Visible) { // precio ?>
		<td data-name="precio"<?php echo $detalle_documento->precio->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_precio" class="form-group detalle_documento_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento->precio->EditValue ?>"<?php echo $detalle_documento->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento->precio->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_precio" class="form-group detalle_documento_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento->precio->EditValue ?>"<?php echo $detalle_documento->precio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->precio->ViewAttributes() ?>>
<?php echo $detalle_documento->precio->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento->precio->FormValue) ?>">
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento->precio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $detalle_documento->monto->CellAttributes() ?>>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_monto" class="form-group detalle_documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento->monto->EditValue ?>"<?php echo $detalle_documento->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento->monto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_grid->RowCnt ?>_detalle_documento_monto" class="form-group detalle_documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento->monto->EditValue ?>"<?php echo $detalle_documento->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento->monto->ViewAttributes() ?>>
<?php echo $detalle_documento->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_grid->ListOptions->Render("body", "right", $detalle_documento_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_documento->RowType == EW_ROWTYPE_ADD || $detalle_documento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documentogrid.UpdateOpts(<?php echo $detalle_documento_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento->CurrentAction <> "gridadd" || $detalle_documento->CurrentMode == "copy")
		if (!$detalle_documento_grid->Recordset->EOF) $detalle_documento_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento->CurrentMode == "add" || $detalle_documento->CurrentMode == "copy" || $detalle_documento->CurrentMode == "edit") {
		$detalle_documento_grid->RowIndex = '$rowindex$';
		$detalle_documento_grid->LoadDefaultValues();

		// Set row properties
		$detalle_documento->ResetAttrs();
		$detalle_documento->RowAttrs = array_merge($detalle_documento->RowAttrs, array('data-rowindex'=>$detalle_documento_grid->RowIndex, 'id'=>'r0_detalle_documento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento->RowAttrs["class"], "ewTemplate");
		$detalle_documento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_grid->RenderRow();

		// Render list options
		$detalle_documento_grid->RenderListOptions();
		$detalle_documento_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_grid->ListOptions->Render("body", "left", $detalle_documento_grid->RowIndex);
?>
	<?php if ($detalle_documento->iddocumento->Visible) { // iddocumento ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<?php if ($detalle_documento->iddocumento->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<span<?php echo $detalle_documento->iddocumento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->iddocumento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<select data-field="x_iddocumento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento"<?php echo $detalle_documento->iddocumento->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->iddocumento->EditValue)) {
	$arwrk = $detalle_documento->iddocumento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->iddocumento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->iddocumento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento->Lookup_Selecting($detalle_documento->iddocumento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_iddocumento" class="form-group detalle_documento_iddocumento">
<span<?php echo $detalle_documento->iddocumento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->iddocumento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento" name="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="x<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_iddocumento" name="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" id="o<?php echo $detalle_documento_grid->RowIndex ?>_iddocumento" value="<?php echo ew_HtmlEncode($detalle_documento->iddocumento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_idproducto" class="form-group detalle_documento_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idproducto->EditValue)) {
	$arwrk = $detalle_documento->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idproducto->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_idproducto" class="form-group detalle_documento_idproducto">
<span<?php echo $detalle_documento->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_idbodega" class="form-group detalle_documento_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento->idbodega->EditValue)) {
	$arwrk = $detalle_documento->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento->idbodega->OldValue = "";
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
 $detalle_documento->Lookup_Selecting($detalle_documento->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_idbodega" class="form-group detalle_documento_idbodega">
<span<?php echo $detalle_documento->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_cantidad" class="form-group detalle_documento_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento->cantidad->EditValue ?>"<?php echo $detalle_documento->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_cantidad" class="form-group detalle_documento_cantidad">
<span<?php echo $detalle_documento->cantidad->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->cantidad->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento->precio->Visible) { // precio ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_precio" class="form-group detalle_documento_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento->precio->EditValue ?>"<?php echo $detalle_documento->precio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_precio" class="form-group detalle_documento_precio">
<span<?php echo $detalle_documento->precio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->precio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento->precio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento->precio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento->monto->Visible) { // monto ?>
		<td>
<?php if ($detalle_documento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_monto" class="form-group detalle_documento_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento->monto->EditValue ?>"<?php echo $detalle_documento->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_monto" class="form-group detalle_documento_monto">
<span<?php echo $detalle_documento->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_grid->ListOptions->Render("body", "right", $detalle_documento_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_documentogrid.UpdateOpts(<?php echo $detalle_documento_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_documento->CurrentMode == "add" || $detalle_documento->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_grid->KeyCount ?>">
<?php echo $detalle_documento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_grid->KeyCount ?>">
<?php echo $detalle_documento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_documentogrid">
</div>
<?php

// Close recordset
if ($detalle_documento_grid->Recordset)
	$detalle_documento_grid->Recordset->Close();
?>
<?php if ($detalle_documento_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($detalle_documento_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_documento_grid->TotalRecs == 0 && $detalle_documento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento->Export == "") { ?>
<script type="text/javascript">
fdetalle_documentogrid.Init();
</script>
<?php } ?>
<?php
$detalle_documento_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_documento_grid->Page_Terminate();
?>
