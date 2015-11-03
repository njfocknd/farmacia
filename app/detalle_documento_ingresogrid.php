<?php

// Create page object
if (!isset($detalle_documento_ingreso_grid)) $detalle_documento_ingreso_grid = new cdetalle_documento_ingreso_grid();

// Page init
$detalle_documento_ingreso_grid->Page_Init();

// Page main
$detalle_documento_ingreso_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_ingreso_grid->Page_Render();
?>
<?php if ($detalle_documento_ingreso->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_ingreso_grid = new ew_Page("detalle_documento_ingreso_grid");
detalle_documento_ingreso_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = detalle_documento_ingreso_grid.PageID; // For backward compatibility

// Form object
var fdetalle_documento_ingresogrid = new ew_Form("fdetalle_documento_ingresogrid");
fdetalle_documento_ingresogrid.FormKeyCountName = '<?php echo $detalle_documento_ingreso_grid->FormKeyCountName ?>';

// Validate form
fdetalle_documento_ingresogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento_ingreso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_ingreso->iddocumento_ingreso->FldCaption(), $detalle_documento_ingreso->iddocumento_ingreso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_ingreso->idproducto->FldCaption(), $detalle_documento_ingreso->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_ingreso->idbodega->FldCaption(), $detalle_documento_ingreso->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_ingreso->cantidad->FldCaption(), $detalle_documento_ingreso->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_ingreso->cantidad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_ingreso->precio->FldCaption(), $detalle_documento_ingreso->precio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_ingreso->precio->FldErrMsg()) ?>");

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
fdetalle_documento_ingresogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento_ingreso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documento_ingresogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_ingresogrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_ingresogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_ingresogrid.Lists["x_iddocumento_ingreso"] = {"LinkField":"x_iddocumento_ingreso","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_ingresogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_ingresogrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_documento_ingreso->CurrentAction == "gridadd") {
	if ($detalle_documento_ingreso->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$detalle_documento_ingreso_grid->TotalRecs = $detalle_documento_ingreso->SelectRecordCount();
			$detalle_documento_ingreso_grid->Recordset = $detalle_documento_ingreso_grid->LoadRecordset($detalle_documento_ingreso_grid->StartRec-1, $detalle_documento_ingreso_grid->DisplayRecs);
		} else {
			if ($detalle_documento_ingreso_grid->Recordset = $detalle_documento_ingreso_grid->LoadRecordset())
				$detalle_documento_ingreso_grid->TotalRecs = $detalle_documento_ingreso_grid->Recordset->RecordCount();
		}
		$detalle_documento_ingreso_grid->StartRec = 1;
		$detalle_documento_ingreso_grid->DisplayRecs = $detalle_documento_ingreso_grid->TotalRecs;
	} else {
		$detalle_documento_ingreso->CurrentFilter = "0=1";
		$detalle_documento_ingreso_grid->StartRec = 1;
		$detalle_documento_ingreso_grid->DisplayRecs = $detalle_documento_ingreso->GridAddRowCount;
	}
	$detalle_documento_ingreso_grid->TotalRecs = $detalle_documento_ingreso_grid->DisplayRecs;
	$detalle_documento_ingreso_grid->StopRec = $detalle_documento_ingreso_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_ingreso_grid->TotalRecs = $detalle_documento_ingreso->SelectRecordCount();
	} else {
		if ($detalle_documento_ingreso_grid->Recordset = $detalle_documento_ingreso_grid->LoadRecordset())
			$detalle_documento_ingreso_grid->TotalRecs = $detalle_documento_ingreso_grid->Recordset->RecordCount();
	}
	$detalle_documento_ingreso_grid->StartRec = 1;
	$detalle_documento_ingreso_grid->DisplayRecs = $detalle_documento_ingreso_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_documento_ingreso_grid->Recordset = $detalle_documento_ingreso_grid->LoadRecordset($detalle_documento_ingreso_grid->StartRec-1, $detalle_documento_ingreso_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_documento_ingreso->CurrentAction == "" && $detalle_documento_ingreso_grid->TotalRecs == 0) {
		if ($detalle_documento_ingreso_grid->SearchWhere == "0=101")
			$detalle_documento_ingreso_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_ingreso_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_ingreso_grid->RenderOtherOptions();
?>
<?php $detalle_documento_ingreso_grid->ShowPageHeader(); ?>
<?php
$detalle_documento_ingreso_grid->ShowMessage();
?>
<?php if ($detalle_documento_ingreso_grid->TotalRecs > 0 || $detalle_documento_ingreso->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdetalle_documento_ingresogrid" class="ewForm form-inline">
<div id="gmp_detalle_documento_ingreso" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_documento_ingresogrid" class="table ewTable">
<?php echo $detalle_documento_ingreso->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_ingreso_grid->RenderListOptions();

// Render list options (header, left)
$detalle_documento_ingreso_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento_ingreso->iddocumento_ingreso->Visible) { // iddocumento_ingreso ?>
	<?php if ($detalle_documento_ingreso->SortUrl($detalle_documento_ingreso->iddocumento_ingreso) == "") { ?>
		<th data-name="iddocumento_ingreso"><div id="elh_detalle_documento_ingreso_iddocumento_ingreso" class="detalle_documento_ingreso_iddocumento_ingreso"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento_ingreso"><div><div id="elh_detalle_documento_ingreso_iddocumento_ingreso" class="detalle_documento_ingreso_iddocumento_ingreso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_ingreso->iddocumento_ingreso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_ingreso->iddocumento_ingreso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_ingreso->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento_ingreso->SortUrl($detalle_documento_ingreso->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_ingreso_idproducto" class="detalle_documento_ingreso_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_detalle_documento_ingreso_idproducto" class="detalle_documento_ingreso_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_ingreso->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_ingreso->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_ingreso->idbodega->Visible) { // idbodega ?>
	<?php if ($detalle_documento_ingreso->SortUrl($detalle_documento_ingreso->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_detalle_documento_ingreso_idbodega" class="detalle_documento_ingreso_idbodega"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_detalle_documento_ingreso_idbodega" class="detalle_documento_ingreso_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_ingreso->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_ingreso->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_ingreso->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento_ingreso->SortUrl($detalle_documento_ingreso->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_ingreso_cantidad" class="detalle_documento_ingreso_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div><div id="elh_detalle_documento_ingreso_cantidad" class="detalle_documento_ingreso_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_ingreso->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_ingreso->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_ingreso->precio->Visible) { // precio ?>
	<?php if ($detalle_documento_ingreso->SortUrl($detalle_documento_ingreso->precio) == "") { ?>
		<th data-name="precio"><div id="elh_detalle_documento_ingreso_precio" class="detalle_documento_ingreso_precio"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->precio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio"><div><div id="elh_detalle_documento_ingreso_precio" class="detalle_documento_ingreso_precio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_ingreso->precio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_ingreso->precio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_ingreso->precio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_ingreso_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_documento_ingreso_grid->StartRec = 1;
$detalle_documento_ingreso_grid->StopRec = $detalle_documento_ingreso_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_ingreso_grid->FormKeyCountName) && ($detalle_documento_ingreso->CurrentAction == "gridadd" || $detalle_documento_ingreso->CurrentAction == "gridedit" || $detalle_documento_ingreso->CurrentAction == "F")) {
		$detalle_documento_ingreso_grid->KeyCount = $objForm->GetValue($detalle_documento_ingreso_grid->FormKeyCountName);
		$detalle_documento_ingreso_grid->StopRec = $detalle_documento_ingreso_grid->StartRec + $detalle_documento_ingreso_grid->KeyCount - 1;
	}
}
$detalle_documento_ingreso_grid->RecCnt = $detalle_documento_ingreso_grid->StartRec - 1;
if ($detalle_documento_ingreso_grid->Recordset && !$detalle_documento_ingreso_grid->Recordset->EOF) {
	$detalle_documento_ingreso_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_ingreso_grid->StartRec > 1)
		$detalle_documento_ingreso_grid->Recordset->Move($detalle_documento_ingreso_grid->StartRec - 1);
} elseif (!$detalle_documento_ingreso->AllowAddDeleteRow && $detalle_documento_ingreso_grid->StopRec == 0) {
	$detalle_documento_ingreso_grid->StopRec = $detalle_documento_ingreso->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento_ingreso->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento_ingreso->ResetAttrs();
$detalle_documento_ingreso_grid->RenderRow();
if ($detalle_documento_ingreso->CurrentAction == "gridadd")
	$detalle_documento_ingreso_grid->RowIndex = 0;
if ($detalle_documento_ingreso->CurrentAction == "gridedit")
	$detalle_documento_ingreso_grid->RowIndex = 0;
while ($detalle_documento_ingreso_grid->RecCnt < $detalle_documento_ingreso_grid->StopRec) {
	$detalle_documento_ingreso_grid->RecCnt++;
	if (intval($detalle_documento_ingreso_grid->RecCnt) >= intval($detalle_documento_ingreso_grid->StartRec)) {
		$detalle_documento_ingreso_grid->RowCnt++;
		if ($detalle_documento_ingreso->CurrentAction == "gridadd" || $detalle_documento_ingreso->CurrentAction == "gridedit" || $detalle_documento_ingreso->CurrentAction == "F") {
			$detalle_documento_ingreso_grid->RowIndex++;
			$objForm->Index = $detalle_documento_ingreso_grid->RowIndex;
			if ($objForm->HasValue($detalle_documento_ingreso_grid->FormActionName))
				$detalle_documento_ingreso_grid->RowAction = strval($objForm->GetValue($detalle_documento_ingreso_grid->FormActionName));
			elseif ($detalle_documento_ingreso->CurrentAction == "gridadd")
				$detalle_documento_ingreso_grid->RowAction = "insert";
			else
				$detalle_documento_ingreso_grid->RowAction = "";
		}

		// Set up key count
		$detalle_documento_ingreso_grid->KeyCount = $detalle_documento_ingreso_grid->RowIndex;

		// Init row class and style
		$detalle_documento_ingreso->ResetAttrs();
		$detalle_documento_ingreso->CssClass = "";
		if ($detalle_documento_ingreso->CurrentAction == "gridadd") {
			if ($detalle_documento_ingreso->CurrentMode == "copy") {
				$detalle_documento_ingreso_grid->LoadRowValues($detalle_documento_ingreso_grid->Recordset); // Load row values
				$detalle_documento_ingreso_grid->SetRecordKey($detalle_documento_ingreso_grid->RowOldKey, $detalle_documento_ingreso_grid->Recordset); // Set old record key
			} else {
				$detalle_documento_ingreso_grid->LoadDefaultValues(); // Load default values
				$detalle_documento_ingreso_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_documento_ingreso_grid->LoadRowValues($detalle_documento_ingreso_grid->Recordset); // Load row values
		}
		$detalle_documento_ingreso->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento_ingreso->CurrentAction == "gridadd") // Grid add
			$detalle_documento_ingreso->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento_ingreso->CurrentAction == "gridadd" && $detalle_documento_ingreso->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_ingreso_grid->RestoreCurrentRowFormValues($detalle_documento_ingreso_grid->RowIndex); // Restore form values
		if ($detalle_documento_ingreso->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento_ingreso->EventCancelled) {
				$detalle_documento_ingreso_grid->RestoreCurrentRowFormValues($detalle_documento_ingreso_grid->RowIndex); // Restore form values
			}
			if ($detalle_documento_ingreso_grid->RowAction == "insert")
				$detalle_documento_ingreso->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento_ingreso->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento_ingreso->CurrentAction == "gridedit" && ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT || $detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) && $detalle_documento_ingreso->EventCancelled) // Update failed
			$detalle_documento_ingreso_grid->RestoreCurrentRowFormValues($detalle_documento_ingreso_grid->RowIndex); // Restore form values
		if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_ingreso_grid->EditRowCnt++;
		if ($detalle_documento_ingreso->CurrentAction == "F") // Confirm row
			$detalle_documento_ingreso_grid->RestoreCurrentRowFormValues($detalle_documento_ingreso_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_documento_ingreso->RowAttrs = array_merge($detalle_documento_ingreso->RowAttrs, array('data-rowindex'=>$detalle_documento_ingreso_grid->RowCnt, 'id'=>'r' . $detalle_documento_ingreso_grid->RowCnt . '_detalle_documento_ingreso', 'data-rowtype'=>$detalle_documento_ingreso->RowType));

		// Render row
		$detalle_documento_ingreso_grid->RenderRow();

		// Render list options
		$detalle_documento_ingreso_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_ingreso_grid->RowAction <> "delete" && $detalle_documento_ingreso_grid->RowAction <> "insertdelete" && !($detalle_documento_ingreso_grid->RowAction == "insert" && $detalle_documento_ingreso->CurrentAction == "F" && $detalle_documento_ingreso_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento_ingreso->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_ingreso_grid->ListOptions->Render("body", "left", $detalle_documento_ingreso_grid->RowCnt);
?>
	<?php if ($detalle_documento_ingreso->iddocumento_ingreso->Visible) { // iddocumento_ingreso ?>
		<td data-name="iddocumento_ingreso"<?php echo $detalle_documento_ingreso->iddocumento_ingreso->CellAttributes() ?>>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento_ingreso->iddocumento_ingreso->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<span<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<select data-field="x_iddocumento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso"<?php echo $detalle_documento_ingreso->iddocumento_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->iddocumento_ingreso->EditValue)) {
	$arwrk = $detalle_documento_ingreso->iddocumento_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->iddocumento_ingreso->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_ingreso`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_ingreso`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->iddocumento_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_ingreso` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_ingreso" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento_ingreso->iddocumento_ingreso->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<span<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<select data-field="x_iddocumento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso"<?php echo $detalle_documento_ingreso->iddocumento_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->iddocumento_ingreso->EditValue)) {
	$arwrk = $detalle_documento_ingreso->iddocumento_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->iddocumento_ingreso->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_ingreso`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_ingreso`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->iddocumento_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_ingreso` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewAttributes() ?>>
<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ListViewValue() ?></span>
<input type="hidden" data-field="x_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->FormValue) ?>">
<input type="hidden" data-field="x_iddocumento_ingreso" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_documento_ingreso_grid->PageObjName . "_row_" . $detalle_documento_ingreso_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddetalle_documento_ingreso->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento_ingreso" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddetalle_documento_ingreso->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT || $detalle_documento_ingreso->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddetalle_documento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddetalle_documento_ingreso->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento_ingreso->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento_ingreso->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_idproducto" class="form-group detalle_documento_ingreso_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_ingreso->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idproducto->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idproducto->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_idproducto" class="form-group detalle_documento_ingreso_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_ingreso->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idproducto->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idproducto->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_ingreso->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_ingreso->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $detalle_documento_ingreso->idbodega->CellAttributes() ?>>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_idbodega" class="form-group detalle_documento_ingreso_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_ingreso->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idbodega->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idbodega->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_idbodega" class="form-group detalle_documento_ingreso_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_ingreso->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idbodega->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idbodega->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_ingreso->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento_ingreso->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento_ingreso->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_cantidad" class="form-group detalle_documento_ingreso_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->cantidad->EditValue ?>"<?php echo $detalle_documento_ingreso->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_cantidad" class="form-group detalle_documento_ingreso_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->cantidad->EditValue ?>"<?php echo $detalle_documento_ingreso->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_ingreso->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_ingreso->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->precio->Visible) { // precio ?>
		<td data-name="precio"<?php echo $detalle_documento_ingreso->precio->CellAttributes() ?>>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_precio" class="form-group detalle_documento_ingreso_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->precio->EditValue ?>"<?php echo $detalle_documento_ingreso->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_ingreso_grid->RowCnt ?>_detalle_documento_ingreso_precio" class="form-group detalle_documento_ingreso_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->precio->EditValue ?>"<?php echo $detalle_documento_ingreso->precio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_ingreso->precio->ViewAttributes() ?>>
<?php echo $detalle_documento_ingreso->precio->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->FormValue) ?>">
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_ingreso_grid->ListOptions->Render("body", "right", $detalle_documento_ingreso_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_documento_ingreso->RowType == EW_ROWTYPE_ADD || $detalle_documento_ingreso->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documento_ingresogrid.UpdateOpts(<?php echo $detalle_documento_ingreso_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento_ingreso->CurrentAction <> "gridadd" || $detalle_documento_ingreso->CurrentMode == "copy")
		if (!$detalle_documento_ingreso_grid->Recordset->EOF) $detalle_documento_ingreso_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento_ingreso->CurrentMode == "add" || $detalle_documento_ingreso->CurrentMode == "copy" || $detalle_documento_ingreso->CurrentMode == "edit") {
		$detalle_documento_ingreso_grid->RowIndex = '$rowindex$';
		$detalle_documento_ingreso_grid->LoadDefaultValues();

		// Set row properties
		$detalle_documento_ingreso->ResetAttrs();
		$detalle_documento_ingreso->RowAttrs = array_merge($detalle_documento_ingreso->RowAttrs, array('data-rowindex'=>$detalle_documento_ingreso_grid->RowIndex, 'id'=>'r0_detalle_documento_ingreso', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento_ingreso->RowAttrs["class"], "ewTemplate");
		$detalle_documento_ingreso->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_ingreso_grid->RenderRow();

		// Render list options
		$detalle_documento_ingreso_grid->RenderListOptions();
		$detalle_documento_ingreso_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento_ingreso->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_ingreso_grid->ListOptions->Render("body", "left", $detalle_documento_ingreso_grid->RowIndex);
?>
	<?php if ($detalle_documento_ingreso->iddocumento_ingreso->Visible) { // iddocumento_ingreso ?>
		<td>
<?php if ($detalle_documento_ingreso->CurrentAction <> "F") { ?>
<?php if ($detalle_documento_ingreso->iddocumento_ingreso->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<span<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<select data-field="x_iddocumento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso"<?php echo $detalle_documento_ingreso->iddocumento_ingreso->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->iddocumento_ingreso->EditValue)) {
	$arwrk = $detalle_documento_ingreso->iddocumento_ingreso->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->iddocumento_ingreso->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->iddocumento_ingreso->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_ingreso`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_ingreso`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->iddocumento_ingreso, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_ingreso` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_iddocumento_ingreso" class="form-group detalle_documento_ingreso_iddocumento_ingreso">
<span<?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->iddocumento_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento_ingreso" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_iddocumento_ingreso" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->iddocumento_ingreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($detalle_documento_ingreso->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_ingreso_idproducto" class="form-group detalle_documento_ingreso_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_ingreso->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idproducto->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idproducto->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_idproducto" class="form-group detalle_documento_ingreso_idproducto">
<span<?php echo $detalle_documento_ingreso->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($detalle_documento_ingreso->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_ingreso_idbodega" class="form-group detalle_documento_ingreso_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_ingreso->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_ingreso->idbodega->EditValue)) {
	$arwrk = $detalle_documento_ingreso->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_ingreso->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_ingreso->idbodega->OldValue = "";
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
 $detalle_documento_ingreso->Lookup_Selecting($detalle_documento_ingreso->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_idbodega" class="form-group detalle_documento_ingreso_idbodega">
<span<?php echo $detalle_documento_ingreso->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($detalle_documento_ingreso->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_ingreso_cantidad" class="form-group detalle_documento_ingreso_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->cantidad->EditValue ?>"<?php echo $detalle_documento_ingreso->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_cantidad" class="form-group detalle_documento_ingreso_cantidad">
<span<?php echo $detalle_documento_ingreso->cantidad->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->cantidad->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_ingreso->precio->Visible) { // precio ?>
		<td>
<?php if ($detalle_documento_ingreso->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_ingreso_precio" class="form-group detalle_documento_ingreso_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_ingreso->precio->EditValue ?>"<?php echo $detalle_documento_ingreso->precio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_ingreso_precio" class="form-group detalle_documento_ingreso_precio">
<span<?php echo $detalle_documento_ingreso->precio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_ingreso->precio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_ingreso_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_ingreso->precio->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_ingreso_grid->ListOptions->Render("body", "right", $detalle_documento_ingreso_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_documento_ingresogrid.UpdateOpts(<?php echo $detalle_documento_ingreso_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_documento_ingreso->CurrentMode == "add" || $detalle_documento_ingreso->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_ingreso_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_ingreso_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_ingreso_grid->KeyCount ?>">
<?php echo $detalle_documento_ingreso_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_ingreso->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_ingreso_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_ingreso_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_ingreso_grid->KeyCount ?>">
<?php echo $detalle_documento_ingreso_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_ingreso->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_documento_ingresogrid">
</div>
<?php

// Close recordset
if ($detalle_documento_ingreso_grid->Recordset)
	$detalle_documento_ingreso_grid->Recordset->Close();
?>
<?php if ($detalle_documento_ingreso_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($detalle_documento_ingreso_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_documento_ingreso_grid->TotalRecs == 0 && $detalle_documento_ingreso->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_ingreso_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento_ingreso->Export == "") { ?>
<script type="text/javascript">
fdetalle_documento_ingresogrid.Init();
</script>
<?php } ?>
<?php
$detalle_documento_ingreso_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_documento_ingreso_grid->Page_Terminate();
?>
