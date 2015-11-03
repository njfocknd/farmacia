<?php

// Create page object
if (!isset($detalle_documento_interno_grid)) $detalle_documento_interno_grid = new cdetalle_documento_interno_grid();

// Page init
$detalle_documento_interno_grid->Page_Init();

// Page main
$detalle_documento_interno_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_interno_grid->Page_Render();
?>
<?php if ($detalle_documento_interno->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_interno_grid = new ew_Page("detalle_documento_interno_grid");
detalle_documento_interno_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = detalle_documento_interno_grid.PageID; // For backward compatibility

// Form object
var fdetalle_documento_internogrid = new ew_Form("fdetalle_documento_internogrid");
fdetalle_documento_internogrid.FormKeyCountName = '<?php echo $detalle_documento_interno_grid->FormKeyCountName ?>';

// Validate form
fdetalle_documento_internogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento_interno");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_interno->iddocumento_interno->FldCaption(), $detalle_documento_interno->iddocumento_interno->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_interno->idproducto->FldCaption(), $detalle_documento_interno->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega_ingreso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_interno->idbodega_ingreso->FldCaption(), $detalle_documento_interno->idbodega_ingreso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega_egreso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_interno->idbodega_egreso->FldCaption(), $detalle_documento_interno->idbodega_egreso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_interno->cantidad->FldCaption(), $detalle_documento_interno->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_interno->cantidad->FldErrMsg()) ?>");

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
fdetalle_documento_internogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento_interno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega_ingreso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega_egreso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documento_internogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_internogrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_internogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_internogrid.Lists["x_iddocumento_interno"] = {"LinkField":"x_iddocumento_interno","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_internogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_internogrid.Lists["x_idbodega_ingreso"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_internogrid.Lists["x_idbodega_egreso"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_documento_interno->CurrentAction == "gridadd") {
	if ($detalle_documento_interno->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$detalle_documento_interno_grid->TotalRecs = $detalle_documento_interno->SelectRecordCount();
			$detalle_documento_interno_grid->Recordset = $detalle_documento_interno_grid->LoadRecordset($detalle_documento_interno_grid->StartRec-1, $detalle_documento_interno_grid->DisplayRecs);
		} else {
			if ($detalle_documento_interno_grid->Recordset = $detalle_documento_interno_grid->LoadRecordset())
				$detalle_documento_interno_grid->TotalRecs = $detalle_documento_interno_grid->Recordset->RecordCount();
		}
		$detalle_documento_interno_grid->StartRec = 1;
		$detalle_documento_interno_grid->DisplayRecs = $detalle_documento_interno_grid->TotalRecs;
	} else {
		$detalle_documento_interno->CurrentFilter = "0=1";
		$detalle_documento_interno_grid->StartRec = 1;
		$detalle_documento_interno_grid->DisplayRecs = $detalle_documento_interno->GridAddRowCount;
	}
	$detalle_documento_interno_grid->TotalRecs = $detalle_documento_interno_grid->DisplayRecs;
	$detalle_documento_interno_grid->StopRec = $detalle_documento_interno_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_interno_grid->TotalRecs = $detalle_documento_interno->SelectRecordCount();
	} else {
		if ($detalle_documento_interno_grid->Recordset = $detalle_documento_interno_grid->LoadRecordset())
			$detalle_documento_interno_grid->TotalRecs = $detalle_documento_interno_grid->Recordset->RecordCount();
	}
	$detalle_documento_interno_grid->StartRec = 1;
	$detalle_documento_interno_grid->DisplayRecs = $detalle_documento_interno_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_documento_interno_grid->Recordset = $detalle_documento_interno_grid->LoadRecordset($detalle_documento_interno_grid->StartRec-1, $detalle_documento_interno_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_documento_interno->CurrentAction == "" && $detalle_documento_interno_grid->TotalRecs == 0) {
		if ($detalle_documento_interno_grid->SearchWhere == "0=101")
			$detalle_documento_interno_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_interno_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_interno_grid->RenderOtherOptions();
?>
<?php $detalle_documento_interno_grid->ShowPageHeader(); ?>
<?php
$detalle_documento_interno_grid->ShowMessage();
?>
<?php if ($detalle_documento_interno_grid->TotalRecs > 0 || $detalle_documento_interno->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdetalle_documento_internogrid" class="ewForm form-inline">
<div id="gmp_detalle_documento_interno" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_documento_internogrid" class="table ewTable">
<?php echo $detalle_documento_interno->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_interno_grid->RenderListOptions();

// Render list options (header, left)
$detalle_documento_interno_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento_interno->iddocumento_interno->Visible) { // iddocumento_interno ?>
	<?php if ($detalle_documento_interno->SortUrl($detalle_documento_interno->iddocumento_interno) == "") { ?>
		<th data-name="iddocumento_interno"><div id="elh_detalle_documento_interno_iddocumento_interno" class="detalle_documento_interno_iddocumento_interno"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->iddocumento_interno->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento_interno"><div><div id="elh_detalle_documento_interno_iddocumento_interno" class="detalle_documento_interno_iddocumento_interno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->iddocumento_interno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_interno->iddocumento_interno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_interno->iddocumento_interno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_interno->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento_interno->SortUrl($detalle_documento_interno->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_interno_idproducto" class="detalle_documento_interno_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_detalle_documento_interno_idproducto" class="detalle_documento_interno_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_interno->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_interno->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_interno->idbodega_ingreso->Visible) { // idbodega_ingreso ?>
	<?php if ($detalle_documento_interno->SortUrl($detalle_documento_interno->idbodega_ingreso) == "") { ?>
		<th data-name="idbodega_ingreso"><div id="elh_detalle_documento_interno_idbodega_ingreso" class="detalle_documento_interno_idbodega_ingreso"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idbodega_ingreso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega_ingreso"><div><div id="elh_detalle_documento_interno_idbodega_ingreso" class="detalle_documento_interno_idbodega_ingreso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idbodega_ingreso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_interno->idbodega_ingreso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_interno->idbodega_ingreso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_interno->idbodega_egreso->Visible) { // idbodega_egreso ?>
	<?php if ($detalle_documento_interno->SortUrl($detalle_documento_interno->idbodega_egreso) == "") { ?>
		<th data-name="idbodega_egreso"><div id="elh_detalle_documento_interno_idbodega_egreso" class="detalle_documento_interno_idbodega_egreso"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idbodega_egreso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega_egreso"><div><div id="elh_detalle_documento_interno_idbodega_egreso" class="detalle_documento_interno_idbodega_egreso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->idbodega_egreso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_interno->idbodega_egreso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_interno->idbodega_egreso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_interno->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento_interno->SortUrl($detalle_documento_interno->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_interno_cantidad" class="detalle_documento_interno_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div><div id="elh_detalle_documento_interno_cantidad" class="detalle_documento_interno_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_interno->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_interno->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_interno->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_interno_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_documento_interno_grid->StartRec = 1;
$detalle_documento_interno_grid->StopRec = $detalle_documento_interno_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_interno_grid->FormKeyCountName) && ($detalle_documento_interno->CurrentAction == "gridadd" || $detalle_documento_interno->CurrentAction == "gridedit" || $detalle_documento_interno->CurrentAction == "F")) {
		$detalle_documento_interno_grid->KeyCount = $objForm->GetValue($detalle_documento_interno_grid->FormKeyCountName);
		$detalle_documento_interno_grid->StopRec = $detalle_documento_interno_grid->StartRec + $detalle_documento_interno_grid->KeyCount - 1;
	}
}
$detalle_documento_interno_grid->RecCnt = $detalle_documento_interno_grid->StartRec - 1;
if ($detalle_documento_interno_grid->Recordset && !$detalle_documento_interno_grid->Recordset->EOF) {
	$detalle_documento_interno_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_interno_grid->StartRec > 1)
		$detalle_documento_interno_grid->Recordset->Move($detalle_documento_interno_grid->StartRec - 1);
} elseif (!$detalle_documento_interno->AllowAddDeleteRow && $detalle_documento_interno_grid->StopRec == 0) {
	$detalle_documento_interno_grid->StopRec = $detalle_documento_interno->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento_interno->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento_interno->ResetAttrs();
$detalle_documento_interno_grid->RenderRow();
if ($detalle_documento_interno->CurrentAction == "gridadd")
	$detalle_documento_interno_grid->RowIndex = 0;
if ($detalle_documento_interno->CurrentAction == "gridedit")
	$detalle_documento_interno_grid->RowIndex = 0;
while ($detalle_documento_interno_grid->RecCnt < $detalle_documento_interno_grid->StopRec) {
	$detalle_documento_interno_grid->RecCnt++;
	if (intval($detalle_documento_interno_grid->RecCnt) >= intval($detalle_documento_interno_grid->StartRec)) {
		$detalle_documento_interno_grid->RowCnt++;
		if ($detalle_documento_interno->CurrentAction == "gridadd" || $detalle_documento_interno->CurrentAction == "gridedit" || $detalle_documento_interno->CurrentAction == "F") {
			$detalle_documento_interno_grid->RowIndex++;
			$objForm->Index = $detalle_documento_interno_grid->RowIndex;
			if ($objForm->HasValue($detalle_documento_interno_grid->FormActionName))
				$detalle_documento_interno_grid->RowAction = strval($objForm->GetValue($detalle_documento_interno_grid->FormActionName));
			elseif ($detalle_documento_interno->CurrentAction == "gridadd")
				$detalle_documento_interno_grid->RowAction = "insert";
			else
				$detalle_documento_interno_grid->RowAction = "";
		}

		// Set up key count
		$detalle_documento_interno_grid->KeyCount = $detalle_documento_interno_grid->RowIndex;

		// Init row class and style
		$detalle_documento_interno->ResetAttrs();
		$detalle_documento_interno->CssClass = "";
		if ($detalle_documento_interno->CurrentAction == "gridadd") {
			if ($detalle_documento_interno->CurrentMode == "copy") {
				$detalle_documento_interno_grid->LoadRowValues($detalle_documento_interno_grid->Recordset); // Load row values
				$detalle_documento_interno_grid->SetRecordKey($detalle_documento_interno_grid->RowOldKey, $detalle_documento_interno_grid->Recordset); // Set old record key
			} else {
				$detalle_documento_interno_grid->LoadDefaultValues(); // Load default values
				$detalle_documento_interno_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_documento_interno_grid->LoadRowValues($detalle_documento_interno_grid->Recordset); // Load row values
		}
		$detalle_documento_interno->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento_interno->CurrentAction == "gridadd") // Grid add
			$detalle_documento_interno->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento_interno->CurrentAction == "gridadd" && $detalle_documento_interno->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_interno_grid->RestoreCurrentRowFormValues($detalle_documento_interno_grid->RowIndex); // Restore form values
		if ($detalle_documento_interno->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento_interno->EventCancelled) {
				$detalle_documento_interno_grid->RestoreCurrentRowFormValues($detalle_documento_interno_grid->RowIndex); // Restore form values
			}
			if ($detalle_documento_interno_grid->RowAction == "insert")
				$detalle_documento_interno->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento_interno->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento_interno->CurrentAction == "gridedit" && ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT || $detalle_documento_interno->RowType == EW_ROWTYPE_ADD) && $detalle_documento_interno->EventCancelled) // Update failed
			$detalle_documento_interno_grid->RestoreCurrentRowFormValues($detalle_documento_interno_grid->RowIndex); // Restore form values
		if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_interno_grid->EditRowCnt++;
		if ($detalle_documento_interno->CurrentAction == "F") // Confirm row
			$detalle_documento_interno_grid->RestoreCurrentRowFormValues($detalle_documento_interno_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_documento_interno->RowAttrs = array_merge($detalle_documento_interno->RowAttrs, array('data-rowindex'=>$detalle_documento_interno_grid->RowCnt, 'id'=>'r' . $detalle_documento_interno_grid->RowCnt . '_detalle_documento_interno', 'data-rowtype'=>$detalle_documento_interno->RowType));

		// Render row
		$detalle_documento_interno_grid->RenderRow();

		// Render list options
		$detalle_documento_interno_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_interno_grid->RowAction <> "delete" && $detalle_documento_interno_grid->RowAction <> "insertdelete" && !($detalle_documento_interno_grid->RowAction == "insert" && $detalle_documento_interno->CurrentAction == "F" && $detalle_documento_interno_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento_interno->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_interno_grid->ListOptions->Render("body", "left", $detalle_documento_interno_grid->RowCnt);
?>
	<?php if ($detalle_documento_interno->iddocumento_interno->Visible) { // iddocumento_interno ?>
		<td data-name="iddocumento_interno"<?php echo $detalle_documento_interno->iddocumento_interno->CellAttributes() ?>>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento_interno->iddocumento_interno->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<span<?php echo $detalle_documento_interno->iddocumento_interno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->iddocumento_interno->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<select data-field="x_iddocumento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno"<?php echo $detalle_documento_interno->iddocumento_interno->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->iddocumento_interno->EditValue)) {
	$arwrk = $detalle_documento_interno->iddocumento_interno->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->iddocumento_interno->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->iddocumento_interno->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_interno`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_interno`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->iddocumento_interno, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_interno` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_interno" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento_interno->iddocumento_interno->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<span<?php echo $detalle_documento_interno->iddocumento_interno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->iddocumento_interno->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<select data-field="x_iddocumento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno"<?php echo $detalle_documento_interno->iddocumento_interno->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->iddocumento_interno->EditValue)) {
	$arwrk = $detalle_documento_interno->iddocumento_interno->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->iddocumento_interno->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->iddocumento_interno->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_interno`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_interno`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->iddocumento_interno, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_interno` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_interno->iddocumento_interno->ViewAttributes() ?>>
<?php echo $detalle_documento_interno->iddocumento_interno->ListViewValue() ?></span>
<input type="hidden" data-field="x_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->FormValue) ?>">
<input type="hidden" data-field="x_iddocumento_interno" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_documento_interno_grid->PageObjName . "_row_" . $detalle_documento_interno_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddetalle_documento_interno->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento_interno" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddetalle_documento_interno->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT || $detalle_documento_interno->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddetalle_documento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddetalle_documento_interno->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento_interno->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento_interno->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idproducto" class="form-group detalle_documento_interno_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_interno->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idproducto->EditValue)) {
	$arwrk = $detalle_documento_interno->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idproducto->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idproducto" class="form-group detalle_documento_interno_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_interno->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idproducto->EditValue)) {
	$arwrk = $detalle_documento_interno->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idproducto->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_interno->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_interno->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->idbodega_ingreso->Visible) { // idbodega_ingreso ?>
		<td data-name="idbodega_ingreso"<?php echo $detalle_documento_interno->idbodega_ingreso->CellAttributes() ?>>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idbodega_ingreso" class="form-group detalle_documento_interno_idbodega_ingreso">
<select data-field="x_idbodega_ingreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso"<?php echo $detalle_documento_interno->idbodega_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_ingreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_ingreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega_ingreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_ingreso->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idbodega_ingreso" class="form-group detalle_documento_interno_idbodega_ingreso">
<select data-field="x_idbodega_ingreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso"<?php echo $detalle_documento_interno->idbodega_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_ingreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_ingreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_interno->idbodega_ingreso->ViewAttributes() ?>>
<?php echo $detalle_documento_interno->idbodega_ingreso->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega_ingreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_ingreso->FormValue) ?>">
<input type="hidden" data-field="x_idbodega_ingreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_ingreso->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->idbodega_egreso->Visible) { // idbodega_egreso ?>
		<td data-name="idbodega_egreso"<?php echo $detalle_documento_interno->idbodega_egreso->CellAttributes() ?>>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idbodega_egreso" class="form-group detalle_documento_interno_idbodega_egreso">
<select data-field="x_idbodega_egreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso"<?php echo $detalle_documento_interno->idbodega_egreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_egreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_egreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_egreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_egreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_egreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega_egreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_egreso->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_idbodega_egreso" class="form-group detalle_documento_interno_idbodega_egreso">
<select data-field="x_idbodega_egreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso"<?php echo $detalle_documento_interno->idbodega_egreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_egreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_egreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_egreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_egreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_egreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_interno->idbodega_egreso->ViewAttributes() ?>>
<?php echo $detalle_documento_interno->idbodega_egreso->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega_egreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_egreso->FormValue) ?>">
<input type="hidden" data-field="x_idbodega_egreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_egreso->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento_interno->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_cantidad" class="form-group detalle_documento_interno_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_interno->cantidad->EditValue ?>"<?php echo $detalle_documento_interno->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_interno_grid->RowCnt ?>_detalle_documento_interno_cantidad" class="form-group detalle_documento_interno_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_interno->cantidad->EditValue ?>"<?php echo $detalle_documento_interno->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_interno->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_interno->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_interno_grid->ListOptions->Render("body", "right", $detalle_documento_interno_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_documento_interno->RowType == EW_ROWTYPE_ADD || $detalle_documento_interno->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documento_internogrid.UpdateOpts(<?php echo $detalle_documento_interno_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento_interno->CurrentAction <> "gridadd" || $detalle_documento_interno->CurrentMode == "copy")
		if (!$detalle_documento_interno_grid->Recordset->EOF) $detalle_documento_interno_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento_interno->CurrentMode == "add" || $detalle_documento_interno->CurrentMode == "copy" || $detalle_documento_interno->CurrentMode == "edit") {
		$detalle_documento_interno_grid->RowIndex = '$rowindex$';
		$detalle_documento_interno_grid->LoadDefaultValues();

		// Set row properties
		$detalle_documento_interno->ResetAttrs();
		$detalle_documento_interno->RowAttrs = array_merge($detalle_documento_interno->RowAttrs, array('data-rowindex'=>$detalle_documento_interno_grid->RowIndex, 'id'=>'r0_detalle_documento_interno', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento_interno->RowAttrs["class"], "ewTemplate");
		$detalle_documento_interno->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_interno_grid->RenderRow();

		// Render list options
		$detalle_documento_interno_grid->RenderListOptions();
		$detalle_documento_interno_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento_interno->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_interno_grid->ListOptions->Render("body", "left", $detalle_documento_interno_grid->RowIndex);
?>
	<?php if ($detalle_documento_interno->iddocumento_interno->Visible) { // iddocumento_interno ?>
		<td>
<?php if ($detalle_documento_interno->CurrentAction <> "F") { ?>
<?php if ($detalle_documento_interno->iddocumento_interno->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<span<?php echo $detalle_documento_interno->iddocumento_interno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->iddocumento_interno->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<select data-field="x_iddocumento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno"<?php echo $detalle_documento_interno->iddocumento_interno->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->iddocumento_interno->EditValue)) {
	$arwrk = $detalle_documento_interno->iddocumento_interno->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->iddocumento_interno->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->iddocumento_interno->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_interno`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_interno`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->iddocumento_interno, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_interno` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_iddocumento_interno" class="form-group detalle_documento_interno_iddocumento_interno">
<span<?php echo $detalle_documento_interno->iddocumento_interno->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->iddocumento_interno->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento_interno" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_iddocumento_interno" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_iddocumento_interno" value="<?php echo ew_HtmlEncode($detalle_documento_interno->iddocumento_interno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($detalle_documento_interno->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_interno_idproducto" class="form-group detalle_documento_interno_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_interno->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idproducto->EditValue)) {
	$arwrk = $detalle_documento_interno->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idproducto->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_idproducto" class="form-group detalle_documento_interno_idproducto">
<span<?php echo $detalle_documento_interno->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->idbodega_ingreso->Visible) { // idbodega_ingreso ?>
		<td>
<?php if ($detalle_documento_interno->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_interno_idbodega_ingreso" class="form-group detalle_documento_interno_idbodega_ingreso">
<select data-field="x_idbodega_ingreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso"<?php echo $detalle_documento_interno->idbodega_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_ingreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_ingreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_idbodega_ingreso" class="form-group detalle_documento_interno_idbodega_ingreso">
<span<?php echo $detalle_documento_interno->idbodega_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->idbodega_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega_ingreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_ingreso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega_ingreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_ingreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->idbodega_egreso->Visible) { // idbodega_egreso ?>
		<td>
<?php if ($detalle_documento_interno->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_interno_idbodega_egreso" class="form-group detalle_documento_interno_idbodega_egreso">
<select data-field="x_idbodega_egreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso"<?php echo $detalle_documento_interno->idbodega_egreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_interno->idbodega_egreso->EditValue)) {
	$arwrk = $detalle_documento_interno->idbodega_egreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_interno->idbodega_egreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_interno->idbodega_egreso->OldValue = "";
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
 $detalle_documento_interno->Lookup_Selecting($detalle_documento_interno->idbodega_egreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="s_x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_idbodega_egreso" class="form-group detalle_documento_interno_idbodega_egreso">
<span<?php echo $detalle_documento_interno->idbodega_egreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->idbodega_egreso->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega_egreso" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_egreso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega_egreso" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_idbodega_egreso" value="<?php echo ew_HtmlEncode($detalle_documento_interno->idbodega_egreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_interno->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($detalle_documento_interno->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_interno_cantidad" class="form-group detalle_documento_interno_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_interno->cantidad->EditValue ?>"<?php echo $detalle_documento_interno->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_interno_cantidad" class="form-group detalle_documento_interno_cantidad">
<span<?php echo $detalle_documento_interno->cantidad->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_interno->cantidad->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_interno_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_interno->cantidad->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_interno_grid->ListOptions->Render("body", "right", $detalle_documento_interno_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_documento_internogrid.UpdateOpts(<?php echo $detalle_documento_interno_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_documento_interno->CurrentMode == "add" || $detalle_documento_interno->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_interno_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_interno_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_interno_grid->KeyCount ?>">
<?php echo $detalle_documento_interno_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_interno->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_interno_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_interno_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_interno_grid->KeyCount ?>">
<?php echo $detalle_documento_interno_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_interno->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_documento_internogrid">
</div>
<?php

// Close recordset
if ($detalle_documento_interno_grid->Recordset)
	$detalle_documento_interno_grid->Recordset->Close();
?>
<?php if ($detalle_documento_interno_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($detalle_documento_interno_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_documento_interno_grid->TotalRecs == 0 && $detalle_documento_interno->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_interno_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento_interno->Export == "") { ?>
<script type="text/javascript">
fdetalle_documento_internogrid.Init();
</script>
<?php } ?>
<?php
$detalle_documento_interno_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_documento_interno_grid->Page_Terminate();
?>
