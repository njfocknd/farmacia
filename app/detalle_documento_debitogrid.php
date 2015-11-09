<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($detalle_documento_debito_grid)) $detalle_documento_debito_grid = new cdetalle_documento_debito_grid();

// Page init
$detalle_documento_debito_grid->Page_Init();

// Page main
$detalle_documento_debito_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_debito_grid->Page_Render();
?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_debito_grid = new ew_Page("detalle_documento_debito_grid");
detalle_documento_debito_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = detalle_documento_debito_grid.PageID; // For backward compatibility

// Form object
var fdetalle_documento_debitogrid = new ew_Form("fdetalle_documento_debitogrid");
fdetalle_documento_debitogrid.FormKeyCountName = '<?php echo $detalle_documento_debito_grid->FormKeyCountName ?>';

// Validate form
fdetalle_documento_debitogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->iddocumento_debito->FldCaption(), $detalle_documento_debito->iddocumento_debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->idproducto->FldCaption(), $detalle_documento_debito->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->idbodega->FldCaption(), $detalle_documento_debito->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->cantidad->FldCaption(), $detalle_documento_debito->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->cantidad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->precio->FldCaption(), $detalle_documento_debito->precio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->precio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->monto->FldCaption(), $detalle_documento_debito->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->monto->FldErrMsg()) ?>");

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
fdetalle_documento_debitogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento_debito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documento_debitogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_debitogrid.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_debitogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_debitogrid.Lists["x_iddocumento_debito"] = {"LinkField":"x_iddocumento_debito","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitogrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($detalle_documento_debito->CurrentAction == "gridadd") {
	if ($detalle_documento_debito->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$detalle_documento_debito_grid->TotalRecs = $detalle_documento_debito->SelectRecordCount();
			$detalle_documento_debito_grid->Recordset = $detalle_documento_debito_grid->LoadRecordset($detalle_documento_debito_grid->StartRec-1, $detalle_documento_debito_grid->DisplayRecs);
		} else {
			if ($detalle_documento_debito_grid->Recordset = $detalle_documento_debito_grid->LoadRecordset())
				$detalle_documento_debito_grid->TotalRecs = $detalle_documento_debito_grid->Recordset->RecordCount();
		}
		$detalle_documento_debito_grid->StartRec = 1;
		$detalle_documento_debito_grid->DisplayRecs = $detalle_documento_debito_grid->TotalRecs;
	} else {
		$detalle_documento_debito->CurrentFilter = "0=1";
		$detalle_documento_debito_grid->StartRec = 1;
		$detalle_documento_debito_grid->DisplayRecs = $detalle_documento_debito->GridAddRowCount;
	}
	$detalle_documento_debito_grid->TotalRecs = $detalle_documento_debito_grid->DisplayRecs;
	$detalle_documento_debito_grid->StopRec = $detalle_documento_debito_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_debito_grid->TotalRecs = $detalle_documento_debito->SelectRecordCount();
	} else {
		if ($detalle_documento_debito_grid->Recordset = $detalle_documento_debito_grid->LoadRecordset())
			$detalle_documento_debito_grid->TotalRecs = $detalle_documento_debito_grid->Recordset->RecordCount();
	}
	$detalle_documento_debito_grid->StartRec = 1;
	$detalle_documento_debito_grid->DisplayRecs = $detalle_documento_debito_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$detalle_documento_debito_grid->Recordset = $detalle_documento_debito_grid->LoadRecordset($detalle_documento_debito_grid->StartRec-1, $detalle_documento_debito_grid->DisplayRecs);

	// Set no record found message
	if ($detalle_documento_debito->CurrentAction == "" && $detalle_documento_debito_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$detalle_documento_debito_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($detalle_documento_debito_grid->SearchWhere == "0=101")
			$detalle_documento_debito_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_debito_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_debito_grid->RenderOtherOptions();
?>
<?php $detalle_documento_debito_grid->ShowPageHeader(); ?>
<?php
$detalle_documento_debito_grid->ShowMessage();
?>
<?php if ($detalle_documento_debito_grid->TotalRecs > 0 || $detalle_documento_debito->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdetalle_documento_debitogrid" class="ewForm form-inline">
<div id="gmp_detalle_documento_debito" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_detalle_documento_debitogrid" class="table ewTable">
<?php echo $detalle_documento_debito->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_debito_grid->RenderListOptions();

// Render list options (header, left)
$detalle_documento_debito_grid->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->iddocumento_debito) == "") { ?>
		<th data-name="iddocumento_debito"><div id="elh_detalle_documento_debito_iddocumento_debito" class="detalle_documento_debito_iddocumento_debito"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->iddocumento_debito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento_debito"><div><div id="elh_detalle_documento_debito_iddocumento_debito" class="detalle_documento_debito_iddocumento_debito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->iddocumento_debito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->iddocumento_debito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->iddocumento_debito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_debito_idproducto" class="detalle_documento_debito_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_detalle_documento_debito_idproducto" class="detalle_documento_debito_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_detalle_documento_debito_idbodega" class="detalle_documento_debito_idbodega"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_detalle_documento_debito_idbodega" class="detalle_documento_debito_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_debito_cantidad" class="detalle_documento_debito_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div><div id="elh_detalle_documento_debito_cantidad" class="detalle_documento_debito_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->precio) == "") { ?>
		<th data-name="precio"><div id="elh_detalle_documento_debito_precio" class="detalle_documento_debito_precio"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->precio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio"><div><div id="elh_detalle_documento_debito_precio" class="detalle_documento_debito_precio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->precio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->precio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->precio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->monto) == "") { ?>
		<th data-name="monto"><div id="elh_detalle_documento_debito_monto" class="detalle_documento_debito_monto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_detalle_documento_debito_monto" class="detalle_documento_debito_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_debito_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$detalle_documento_debito_grid->StartRec = 1;
$detalle_documento_debito_grid->StopRec = $detalle_documento_debito_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_debito_grid->FormKeyCountName) && ($detalle_documento_debito->CurrentAction == "gridadd" || $detalle_documento_debito->CurrentAction == "gridedit" || $detalle_documento_debito->CurrentAction == "F")) {
		$detalle_documento_debito_grid->KeyCount = $objForm->GetValue($detalle_documento_debito_grid->FormKeyCountName);
		$detalle_documento_debito_grid->StopRec = $detalle_documento_debito_grid->StartRec + $detalle_documento_debito_grid->KeyCount - 1;
	}
}
$detalle_documento_debito_grid->RecCnt = $detalle_documento_debito_grid->StartRec - 1;
if ($detalle_documento_debito_grid->Recordset && !$detalle_documento_debito_grid->Recordset->EOF) {
	$detalle_documento_debito_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_debito_grid->StartRec > 1)
		$detalle_documento_debito_grid->Recordset->Move($detalle_documento_debito_grid->StartRec - 1);
} elseif (!$detalle_documento_debito->AllowAddDeleteRow && $detalle_documento_debito_grid->StopRec == 0) {
	$detalle_documento_debito_grid->StopRec = $detalle_documento_debito->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento_debito->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento_debito->ResetAttrs();
$detalle_documento_debito_grid->RenderRow();
if ($detalle_documento_debito->CurrentAction == "gridadd")
	$detalle_documento_debito_grid->RowIndex = 0;
if ($detalle_documento_debito->CurrentAction == "gridedit")
	$detalle_documento_debito_grid->RowIndex = 0;
while ($detalle_documento_debito_grid->RecCnt < $detalle_documento_debito_grid->StopRec) {
	$detalle_documento_debito_grid->RecCnt++;
	if (intval($detalle_documento_debito_grid->RecCnt) >= intval($detalle_documento_debito_grid->StartRec)) {
		$detalle_documento_debito_grid->RowCnt++;
		if ($detalle_documento_debito->CurrentAction == "gridadd" || $detalle_documento_debito->CurrentAction == "gridedit" || $detalle_documento_debito->CurrentAction == "F") {
			$detalle_documento_debito_grid->RowIndex++;
			$objForm->Index = $detalle_documento_debito_grid->RowIndex;
			if ($objForm->HasValue($detalle_documento_debito_grid->FormActionName))
				$detalle_documento_debito_grid->RowAction = strval($objForm->GetValue($detalle_documento_debito_grid->FormActionName));
			elseif ($detalle_documento_debito->CurrentAction == "gridadd")
				$detalle_documento_debito_grid->RowAction = "insert";
			else
				$detalle_documento_debito_grid->RowAction = "";
		}

		// Set up key count
		$detalle_documento_debito_grid->KeyCount = $detalle_documento_debito_grid->RowIndex;

		// Init row class and style
		$detalle_documento_debito->ResetAttrs();
		$detalle_documento_debito->CssClass = "";
		if ($detalle_documento_debito->CurrentAction == "gridadd") {
			if ($detalle_documento_debito->CurrentMode == "copy") {
				$detalle_documento_debito_grid->LoadRowValues($detalle_documento_debito_grid->Recordset); // Load row values
				$detalle_documento_debito_grid->SetRecordKey($detalle_documento_debito_grid->RowOldKey, $detalle_documento_debito_grid->Recordset); // Set old record key
			} else {
				$detalle_documento_debito_grid->LoadDefaultValues(); // Load default values
				$detalle_documento_debito_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$detalle_documento_debito_grid->LoadRowValues($detalle_documento_debito_grid->Recordset); // Load row values
		}
		$detalle_documento_debito->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento_debito->CurrentAction == "gridadd") // Grid add
			$detalle_documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento_debito->CurrentAction == "gridadd" && $detalle_documento_debito->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_debito_grid->RestoreCurrentRowFormValues($detalle_documento_debito_grid->RowIndex); // Restore form values
		if ($detalle_documento_debito->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento_debito->EventCancelled) {
				$detalle_documento_debito_grid->RestoreCurrentRowFormValues($detalle_documento_debito_grid->RowIndex); // Restore form values
			}
			if ($detalle_documento_debito_grid->RowAction == "insert")
				$detalle_documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento_debito->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento_debito->CurrentAction == "gridedit" && ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_debito->RowType == EW_ROWTYPE_ADD) && $detalle_documento_debito->EventCancelled) // Update failed
			$detalle_documento_debito_grid->RestoreCurrentRowFormValues($detalle_documento_debito_grid->RowIndex); // Restore form values
		if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_debito_grid->EditRowCnt++;
		if ($detalle_documento_debito->CurrentAction == "F") // Confirm row
			$detalle_documento_debito_grid->RestoreCurrentRowFormValues($detalle_documento_debito_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$detalle_documento_debito->RowAttrs = array_merge($detalle_documento_debito->RowAttrs, array('data-rowindex'=>$detalle_documento_debito_grid->RowCnt, 'id'=>'r' . $detalle_documento_debito_grid->RowCnt . '_detalle_documento_debito', 'data-rowtype'=>$detalle_documento_debito->RowType));

		// Render row
		$detalle_documento_debito_grid->RenderRow();

		// Render list options
		$detalle_documento_debito_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_debito_grid->RowAction <> "delete" && $detalle_documento_debito_grid->RowAction <> "insertdelete" && !($detalle_documento_debito_grid->RowAction == "insert" && $detalle_documento_debito->CurrentAction == "F" && $detalle_documento_debito_grid->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_debito_grid->ListOptions->Render("body", "left", $detalle_documento_debito_grid->RowCnt);
?>
	<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
		<td data-name="iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->iddocumento_debito->ListViewValue() ?></span>
<input type="hidden" data-field="x_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->FormValue) ?>">
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->OldValue) ?>">
<?php } ?>
<a id="<?php echo $detalle_documento_debito_grid->PageObjName . "_row_" . $detalle_documento_debito_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento_debito" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_debito->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento_debito->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $detalle_documento_debito->idbodega->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento_debito->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->cantidad->ListViewValue() ?></span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->FormValue) ?>">
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
		<td data-name="precio"<?php echo $detalle_documento_debito->precio->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->precio->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->precio->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->FormValue) ?>">
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $detalle_documento_debito->monto->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_grid->RowCnt ?>_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->monto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_debito_grid->ListOptions->Render("body", "right", $detalle_documento_debito_grid->RowCnt);
?>
	</tr>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD || $detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documento_debitogrid.UpdateOpts(<?php echo $detalle_documento_debito_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento_debito->CurrentAction <> "gridadd" || $detalle_documento_debito->CurrentMode == "copy")
		if (!$detalle_documento_debito_grid->Recordset->EOF) $detalle_documento_debito_grid->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento_debito->CurrentMode == "add" || $detalle_documento_debito->CurrentMode == "copy" || $detalle_documento_debito->CurrentMode == "edit") {
		$detalle_documento_debito_grid->RowIndex = '$rowindex$';
		$detalle_documento_debito_grid->LoadDefaultValues();

		// Set row properties
		$detalle_documento_debito->ResetAttrs();
		$detalle_documento_debito->RowAttrs = array_merge($detalle_documento_debito->RowAttrs, array('data-rowindex'=>$detalle_documento_debito_grid->RowIndex, 'id'=>'r0_detalle_documento_debito', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento_debito->RowAttrs["class"], "ewTemplate");
		$detalle_documento_debito->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_debito_grid->RenderRow();

		// Render list options
		$detalle_documento_debito_grid->RenderListOptions();
		$detalle_documento_debito_grid->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_debito_grid->ListOptions->Render("body", "left", $detalle_documento_debito_grid->RowIndex);
?>
	<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento_debito" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<span<?php echo $detalle_documento_debito->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
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
 $detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<span<?php echo $detalle_documento_debito->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<span<?php echo $detalle_documento_debito->cantidad->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->cantidad->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<span<?php echo $detalle_documento_debito->precio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->precio->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
		<td>
<?php if ($detalle_documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<span<?php echo $detalle_documento_debito->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $detalle_documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_debito_grid->ListOptions->Render("body", "right", $detalle_documento_debito_grid->RowCnt);
?>
<script type="text/javascript">
fdetalle_documento_debitogrid.UpdateOpts(<?php echo $detalle_documento_debito_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($detalle_documento_debito->CurrentMode == "add" || $detalle_documento_debito->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_debito_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_debito_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_debito_grid->KeyCount ?>">
<?php echo $detalle_documento_debito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_debito->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_debito_grid->FormKeyCountName ?>" id="<?php echo $detalle_documento_debito_grid->FormKeyCountName ?>" value="<?php echo $detalle_documento_debito_grid->KeyCount ?>">
<?php echo $detalle_documento_debito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_debito->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdetalle_documento_debitogrid">
</div>
<?php

// Close recordset
if ($detalle_documento_debito_grid->Recordset)
	$detalle_documento_debito_grid->Recordset->Close();
?>
<?php if ($detalle_documento_debito_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($detalle_documento_debito_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($detalle_documento_debito_grid->TotalRecs == 0 && $detalle_documento_debito->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_debito_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">
fdetalle_documento_debitogrid.Init();
</script>
<?php } ?>
<?php
$detalle_documento_debito_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$detalle_documento_debito_grid->Page_Terminate();
?>
