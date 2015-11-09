<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($detalle_documento_credito_grid)) $detalle_documento_credito_grid = new cdetalle_documento_credito_grid();

// Page init
$detalle_documento_credito_grid->Page_Init();

// Page main
$detalle_documento_credito_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_credito_grid->Page_Render();
?>
<?php if ($detalle_documento_credito->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_credito_grid = new ew_Page("detalle_documento_credito_grid");
detalle_documento_credito_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = detalle_documento_credito_grid.PageID; // For backward compatibility

// Form object
var fdetalle_documento_creditogrid = new ew_Form("fdetalle_documento_creditogrid");
fdetalle_documento_creditogrid.FormKeyCountName = '<?php echo $detalle_documento_credito_grid->FormKeyCountName ?>';

// Validate form
fdetalle_documento_creditogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_credito->iddocumento_credito->FldCaption(), $detalle_documento_credito->iddocumento_credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_credito->idproducto->FldCaption(), $detalle_documento_credito->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_credito->idbodega->FldCaption(), $detalle_documento_credito->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_credito->cantidad->FldCaption(), $detalle_documento_credito->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_credito->cantidad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_credito->precio->FldCaption(), $detalle_documento_credito->precio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_credito->precio->FldErrMsg()) ?>");

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
fdetalle_documento_creditogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento_credito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documento_creditogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_creditogrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_creditogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_creditogrid.Lists["x_iddocumento_credito"] = {"LinkField":"x_iddocumento_credito","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_creditogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_creditogrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_documento_credito->CurrentAction == "gridadd") {
	if ($detalle_documento_credito->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$detalle_documento_credito_grid->TotalRecs = $detalle_documento_credito->SelectRecordCount();
			$detalle_documento_credito_grid->Recordset = $detalle_documento_credito_grid->LoadRecordset($detalle_documento_credito_grid->StartRec-1, $detalle_documento_credito_grid->DisplayRecs);
		} else {
			if ($detalle_documento_credito_grid->Recordset = $detalle_documento_credito_grid->LoadRecordset())
				$detalle_documento_credito_grid->TotalRecs = $detalle_documento_credito_grid->Recordset->RecordCount();
		}
		$detalle_documento_credito_grid->StartRec = 1;
		$detalle_documento_credito_grid->DisplayRecs = $detalle_documento_credito_grid->TotalRecs;
	} else {
		$detalle_documento_credito->CurrentFilter = "0=1";
		$detalle_documento_credito_grid->StartRec = 1;
		$detalle_documento_credito_grid->DisplayRecs = $detalle_documento_credito->GridAddRowCount;
	}
	$detalle_documento_credito_grid->TotalRecs = $detalle_documento_credito_grid->DisplayRecs;
	$detalle_documento_credito_grid->StopRec = $detalle_documento_credito_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_credito_grid->TotalRecs = $detalle_documento_credito->SelectRecordCount();
	} else {
		if ($detalle_documento_credito_grid->Recordset = $detalle_documento_credito_grid->LoadRecordset())
			$detalle_documento_credito_grid->TotalRecs = $detalle_documento_credito_grid->Recordset->RecordCount();
	}
	$detalle_documento_credito_grid->StartRec = 1;
	$detalle_documento_credito_grid->DisplayRecs = $detalle_documento_credito_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_documento_credito_grid->Recordset = $detalle_documento_credito_grid->LoadRecordset($detalle_documento_credito_grid->StartRec-1, $detalle_documento_credito_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_documento_credito->CurrentAction == "" && $detalle_documento_credito_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$detalle_documento_credito_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($detalle_documento_credito_grid->SearchWhere == "0=101")
			$detalle_documento_credito_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_credito_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_credito_grid->RenderOtherOptions();
?>
<?php $detalle_documento_credito_grid->ShowPageHeader(); ?>
<?php
$detalle_documento_credito_grid->ShowMessage();
?>
<?php if ($detalle_documento_credito_grid->TotalRecs > 0 || $detalle_documento_credito->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdetalle_documento_creditogrid" class="ewForm form-inline">
<div id="gmp_detalle_documento_credito" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_documento_creditogrid" class="table ewTable">
<?php echo $detalle_documento_credito->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_credito_grid->RenderListOptions();

// Render list options (header, left)
$detalle_documento_credito_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento_credito->iddocumento_credito->Visible) { // iddocumento_credito ?>
	<?php if ($detalle_documento_credito->SortUrl($detalle_documento_credito->iddocumento_credito) == "") { ?>
		<th data-name="iddocumento_credito"><div id="elh_detalle_documento_credito_iddocumento_credito" class="detalle_documento_credito_iddocumento_credito"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->iddocumento_credito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento_credito"><div><div id="elh_detalle_documento_credito_iddocumento_credito" class="detalle_documento_credito_iddocumento_credito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->iddocumento_credito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_credito->iddocumento_credito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_credito->iddocumento_credito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_credito->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento_credito->SortUrl($detalle_documento_credito->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_credito_idproducto" class="detalle_documento_credito_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_detalle_documento_credito_idproducto" class="detalle_documento_credito_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_credito->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_credito->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_credito->idbodega->Visible) { // idbodega ?>
	<?php if ($detalle_documento_credito->SortUrl($detalle_documento_credito->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_detalle_documento_credito_idbodega" class="detalle_documento_credito_idbodega"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_detalle_documento_credito_idbodega" class="detalle_documento_credito_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_credito->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_credito->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_credito->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento_credito->SortUrl($detalle_documento_credito->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_credito_cantidad" class="detalle_documento_credito_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div><div id="elh_detalle_documento_credito_cantidad" class="detalle_documento_credito_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_credito->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_credito->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_credito->precio->Visible) { // precio ?>
	<?php if ($detalle_documento_credito->SortUrl($detalle_documento_credito->precio) == "") { ?>
		<th data-name="precio"><div id="elh_detalle_documento_credito_precio" class="detalle_documento_credito_precio"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->precio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio"><div><div id="elh_detalle_documento_credito_precio" class="detalle_documento_credito_precio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_credito->precio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_credito->precio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_credito->precio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_credito_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_documento_credito_grid->StartRec = 1;
$detalle_documento_credito_grid->StopRec = $detalle_documento_credito_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_credito_grid->FormKeyCountName) && ($detalle_documento_credito->CurrentAction == "gridadd" || $detalle_documento_credito->CurrentAction == "gridedit" || $detalle_documento_credito->CurrentAction == "F")) {
		$detalle_documento_credito_grid->KeyCount = $objForm->GetValue($detalle_documento_credito_grid->FormKeyCountName);
		$detalle_documento_credito_grid->StopRec = $detalle_documento_credito_grid->StartRec + $detalle_documento_credito_grid->KeyCount - 1;
	}
}
$detalle_documento_credito_grid->RecCnt = $detalle_documento_credito_grid->StartRec - 1;
if ($detalle_documento_credito_grid->Recordset && !$detalle_documento_credito_grid->Recordset->EOF) {
	$detalle_documento_credito_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_credito_grid->StartRec > 1)
		$detalle_documento_credito_grid->Recordset->Move($detalle_documento_credito_grid->StartRec - 1);
} elseif (!$detalle_documento_credito->AllowAddDeleteRow && $detalle_documento_credito_grid->StopRec == 0) {
	$detalle_documento_credito_grid->StopRec = $detalle_documento_credito->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento_credito->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento_credito->ResetAttrs();
$detalle_documento_credito_grid->RenderRow();
if ($detalle_documento_credito->CurrentAction == "gridadd")
	$detalle_documento_credito_grid->RowIndex = 0;
if ($detalle_documento_credito->CurrentAction == "gridedit")
	$detalle_documento_credito_grid->RowIndex = 0;
while ($detalle_documento_credito_grid->RecCnt < $detalle_documento_credito_grid->StopRec) {
	$detalle_documento_credito_grid->RecCnt++;
	if (intval($detalle_documento_credito_grid->RecCnt) >= intval($detalle_documento_credito_grid->StartRec)) {
		$detalle_documento_credito_grid->RowCnt++;
		if ($detalle_documento_credito->CurrentAction == "gridadd" || $detalle_documento_credito->CurrentAction == "gridedit" || $detalle_documento_credito->CurrentAction == "F") {
			$detalle_documento_credito_grid->RowIndex++;
			$objForm->Index = $detalle_documento_credito_grid->RowIndex;
			if ($objForm->HasValue($detalle_documento_credito_grid->FormActionName))
				$detalle_documento_credito_grid->RowAction = strval($objForm->GetValue($detalle_documento_credito_grid->FormActionName));
			elseif ($detalle_documento_credito->CurrentAction == "gridadd")
				$detalle_documento_credito_grid->RowAction = "insert";
			else
				$detalle_documento_credito_grid->RowAction = "";
		}

		// Set up key count
		$detalle_documento_credito_grid->KeyCount = $detalle_documento_credito_grid->RowIndex;

		// Init row class and style
		$detalle_documento_credito->ResetAttrs();
		$detalle_documento_credito->CssClass = "";
		if ($detalle_documento_credito->CurrentAction == "gridadd") {
			if ($detalle_documento_credito->CurrentMode == "copy") {
				$detalle_documento_credito_grid->LoadRowValues($detalle_documento_credito_grid->Recordset); // Load row values
				$detalle_documento_credito_grid->SetRecordKey($detalle_documento_credito_grid->RowOldKey, $detalle_documento_credito_grid->Recordset); // Set old record key
			} else {
				$detalle_documento_credito_grid->LoadDefaultValues(); // Load default values
				$detalle_documento_credito_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_documento_credito_grid->LoadRowValues($detalle_documento_credito_grid->Recordset); // Load row values
		}
		$detalle_documento_credito->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento_credito->CurrentAction == "gridadd") // Grid add
			$detalle_documento_credito->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento_credito->CurrentAction == "gridadd" && $detalle_documento_credito->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_credito_grid->RestoreCurrentRowFormValues($detalle_documento_credito_grid->RowIndex); // Restore form values
		if ($detalle_documento_credito->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento_credito->EventCancelled) {
				$detalle_documento_credito_grid->RestoreCurrentRowFormValues($detalle_documento_credito_grid->RowIndex); // Restore form values
			}
			if ($detalle_documento_credito_grid->RowAction == "insert")
				$detalle_documento_credito->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento_credito->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento_credito->CurrentAction == "gridedit" && ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_credito->RowType == EW_ROWTYPE_ADD) && $detalle_documento_credito->EventCancelled) // Update failed
			$detalle_documento_credito_grid->RestoreCurrentRowFormValues($detalle_documento_credito_grid->RowIndex); // Restore form values
		if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_credito_grid->EditRowCnt++;
		if ($detalle_documento_credito->CurrentAction == "F") // Confirm row
			$detalle_documento_credito_grid->RestoreCurrentRowFormValues($detalle_documento_credito_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_documento_credito->RowAttrs = array_merge($detalle_documento_credito->RowAttrs, array('data-rowindex'=>$detalle_documento_credito_grid->RowCnt, 'id'=>'r' . $detalle_documento_credito_grid->RowCnt . '_detalle_documento_credito', 'data-rowtype'=>$detalle_documento_credito->RowType));

		// Render row
		$detalle_documento_credito_grid->RenderRow();

		// Render list options
		$detalle_documento_credito_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_credito_grid->RowAction <> "delete" && $detalle_documento_credito_grid->RowAction <> "insertdelete" && !($detalle_documento_credito_grid->RowAction == "insert" && $detalle_documento_credito->CurrentAction == "F" && $detalle_documento_credito_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento_credito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_credito_grid->ListOptions->Render("body", "left", $detalle_documento_credito_grid->RowCnt);
?>
	<?php if ($detalle_documento_credito->iddocumento_credito->Visible) { // iddocumento_credito ?>
		<td data-name="iddocumento_credito"<?php echo $detalle_documento_credito->iddocumento_credito->CellAttributes() ?>>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento_credito->iddocumento_credito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<span<?php echo $detalle_documento_credito->iddocumento_credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->iddocumento_credito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<select data-field="x_iddocumento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito"<?php echo $detalle_documento_credito->iddocumento_credito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->iddocumento_credito->EditValue)) {
	$arwrk = $detalle_documento_credito->iddocumento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->iddocumento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->iddocumento_credito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_credito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_credito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->iddocumento_credito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_credito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_credito" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento_credito->iddocumento_credito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<span<?php echo $detalle_documento_credito->iddocumento_credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->iddocumento_credito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<select data-field="x_iddocumento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito"<?php echo $detalle_documento_credito->iddocumento_credito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->iddocumento_credito->EditValue)) {
	$arwrk = $detalle_documento_credito->iddocumento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->iddocumento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->iddocumento_credito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_credito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_credito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->iddocumento_credito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_credito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_credito->iddocumento_credito->ViewAttributes() ?>>
<?php echo $detalle_documento_credito->iddocumento_credito->ListViewValue() ?></span>
<input type="hidden" data-field="x_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->FormValue) ?>">
<input type="hidden" data-field="x_iddocumento_credito" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_documento_credito_grid->PageObjName . "_row_" . $detalle_documento_credito_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddetalle_documento_credito->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento_credito" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddetalle_documento_credito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_credito->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddetalle_documento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddetalle_documento_credito->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento_credito->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento_credito->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_idproducto" class="form-group detalle_documento_credito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_credito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_credito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idproducto->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_idproducto" class="form-group detalle_documento_credito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_credito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_credito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idproducto->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_credito->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_credito->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $detalle_documento_credito->idbodega->CellAttributes() ?>>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_idbodega" class="form-group detalle_documento_credito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_credito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_credito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idbodega->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_idbodega" class="form-group detalle_documento_credito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_credito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_credito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idbodega->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_credito->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento_credito->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento_credito->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_cantidad" class="form-group detalle_documento_credito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->cantidad->EditValue ?>"<?php echo $detalle_documento_credito->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_cantidad" class="form-group detalle_documento_credito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->cantidad->EditValue ?>"<?php echo $detalle_documento_credito->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_credito->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_credito->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->precio->Visible) { // precio ?>
		<td data-name="precio"<?php echo $detalle_documento_credito->precio->CellAttributes() ?>>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_precio" class="form-group detalle_documento_credito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->precio->EditValue ?>"<?php echo $detalle_documento_credito->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_credito_grid->RowCnt ?>_detalle_documento_credito_precio" class="form-group detalle_documento_credito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->precio->EditValue ?>"<?php echo $detalle_documento_credito->precio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_credito->precio->ViewAttributes() ?>>
<?php echo $detalle_documento_credito->precio->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->FormValue) ?>">
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_credito_grid->ListOptions->Render("body", "right", $detalle_documento_credito_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_documento_credito->RowType == EW_ROWTYPE_ADD || $detalle_documento_credito->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documento_creditogrid.UpdateOpts(<?php echo $detalle_documento_credito_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento_credito->CurrentAction <> "gridadd" || $detalle_documento_credito->CurrentMode == "copy")
		if (!$detalle_documento_credito_grid->Recordset->EOF) $detalle_documento_credito_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento_credito->CurrentMode == "add" || $detalle_documento_credito->CurrentMode == "copy" || $detalle_documento_credito->CurrentMode == "edit") {
		$detalle_documento_credito_grid->RowIndex = '$rowindex$';
		$detalle_documento_credito_grid->LoadDefaultValues();

		// Set row properties
		$detalle_documento_credito->ResetAttrs();
		$detalle_documento_credito->RowAttrs = array_merge($detalle_documento_credito->RowAttrs, array('data-rowindex'=>$detalle_documento_credito_grid->RowIndex, 'id'=>'r0_detalle_documento_credito', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento_credito->RowAttrs["class"], "ewTemplate");
		$detalle_documento_credito->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_credito_grid->RenderRow();

		// Render list options
		$detalle_documento_credito_grid->RenderListOptions();
		$detalle_documento_credito_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento_credito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_credito_grid->ListOptions->Render("body", "left", $detalle_documento_credito_grid->RowIndex);
?>
	<?php if ($detalle_documento_credito->iddocumento_credito->Visible) { // iddocumento_credito ?>
		<td>
<?php if ($detalle_documento_credito->CurrentAction <> "F") { ?>
<?php if ($detalle_documento_credito->iddocumento_credito->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<span<?php echo $detalle_documento_credito->iddocumento_credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->iddocumento_credito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<select data-field="x_iddocumento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito"<?php echo $detalle_documento_credito->iddocumento_credito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->iddocumento_credito->EditValue)) {
	$arwrk = $detalle_documento_credito->iddocumento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->iddocumento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->iddocumento_credito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_credito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_credito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->iddocumento_credito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_credito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_iddocumento_credito" class="form-group detalle_documento_credito_iddocumento_credito">
<span<?php echo $detalle_documento_credito->iddocumento_credito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->iddocumento_credito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento_credito" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_iddocumento_credito" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_iddocumento_credito" value="<?php echo ew_HtmlEncode($detalle_documento_credito->iddocumento_credito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($detalle_documento_credito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_credito_idproducto" class="form-group detalle_documento_credito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_credito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_credito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idproducto->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_idproducto" class="form-group detalle_documento_credito_idproducto">
<span<?php echo $detalle_documento_credito->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($detalle_documento_credito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_credito_idbodega" class="form-group detalle_documento_credito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_credito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_credito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_credito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_credito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_credito->idbodega->OldValue = "";
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
 $detalle_documento_credito->Lookup_Selecting($detalle_documento_credito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_idbodega" class="form-group detalle_documento_credito_idbodega">
<span<?php echo $detalle_documento_credito->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_credito->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($detalle_documento_credito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_credito_cantidad" class="form-group detalle_documento_credito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->cantidad->EditValue ?>"<?php echo $detalle_documento_credito->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_cantidad" class="form-group detalle_documento_credito_cantidad">
<span<?php echo $detalle_documento_credito->cantidad->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->cantidad->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_credito->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_credito->precio->Visible) { // precio ?>
		<td>
<?php if ($detalle_documento_credito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_credito_precio" class="form-group detalle_documento_credito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_credito->precio->EditValue ?>"<?php echo $detalle_documento_credito->precio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_credito_precio" class="form-group detalle_documento_credito_precio">
<span<?php echo $detalle_documento_credito->precio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_credito->precio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_credito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_credito->precio->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_credito_grid->ListOptions->Render("body", "right", $detalle_documento_credito_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_documento_creditogrid.UpdateOpts(<?php echo $detalle_documento_credito_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_documento_credito->CurrentMode == "add" || $detalle_documento_credito->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_credito_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_credito_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_credito_grid->KeyCount ?>">
<?php echo $detalle_documento_credito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_credito->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_credito_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_credito_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_credito_grid->KeyCount ?>">
<?php echo $detalle_documento_credito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_credito->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_documento_creditogrid">
</div>
<?php

// Close recordset
if ($detalle_documento_credito_grid->Recordset)
	$detalle_documento_credito_grid->Recordset->Close();
?>
<?php if ($detalle_documento_credito_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($detalle_documento_credito_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_documento_credito_grid->TotalRecs == 0 && $detalle_documento_credito->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_credito_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento_credito->Export == "") { ?>
<script type="text/javascript">
fdetalle_documento_creditogrid.Init();
</script>
<?php } ?>
<?php
$detalle_documento_credito_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_documento_credito_grid->Page_Terminate();
?>
