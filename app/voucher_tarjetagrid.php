<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($voucher_tarjeta_grid)) $voucher_tarjeta_grid = new cvoucher_tarjeta_grid();

// Page init
$voucher_tarjeta_grid->Page_Init();

// Page main
$voucher_tarjeta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$voucher_tarjeta_grid->Page_Render();
?>
<?php if ($voucher_tarjeta->Export == "") { ?>
<script type="text/javascript">

// Page object
var voucher_tarjeta_grid = new ew_Page("voucher_tarjeta_grid");
voucher_tarjeta_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = voucher_tarjeta_grid.PageID; // For backward compatibility

// Form object
var fvoucher_tarjetagrid = new ew_Form("fvoucher_tarjetagrid");
fvoucher_tarjetagrid.FormKeyCountName = '<?php echo $voucher_tarjeta_grid->FormKeyCountName ?>';

// Validate form
fvoucher_tarjetagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $voucher_tarjeta->idbanco->FldCaption(), $voucher_tarjeta->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $voucher_tarjeta->idcuenta->FldCaption(), $voucher_tarjeta->idcuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ultimos_cuatro_digitos");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($voucher_tarjeta->ultimos_cuatro_digitos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($voucher_tarjeta->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $voucher_tarjeta->monto->FldCaption(), $voucher_tarjeta->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($voucher_tarjeta->monto->FldErrMsg()) ?>");

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
fvoucher_tarjetagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idbanco", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "marca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ultimos_cuatro_digitos", false)) return false;
	if (ew_ValueChanged(fobj, infix, "referencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fvoucher_tarjetagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvoucher_tarjetagrid.ValidateRequired = true;
<?php } else { ?>
fvoucher_tarjetagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvoucher_tarjetagrid.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fvoucher_tarjetagrid.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($voucher_tarjeta->CurrentAction == "gridadd") {
	if ($voucher_tarjeta->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$voucher_tarjeta_grid->TotalRecs = $voucher_tarjeta->SelectRecordCount();
			$voucher_tarjeta_grid->Recordset = $voucher_tarjeta_grid->LoadRecordset($voucher_tarjeta_grid->StartRec-1, $voucher_tarjeta_grid->DisplayRecs);
		} else {
			if ($voucher_tarjeta_grid->Recordset = $voucher_tarjeta_grid->LoadRecordset())
				$voucher_tarjeta_grid->TotalRecs = $voucher_tarjeta_grid->Recordset->RecordCount();
		}
		$voucher_tarjeta_grid->StartRec = 1;
		$voucher_tarjeta_grid->DisplayRecs = $voucher_tarjeta_grid->TotalRecs;
	} else {
		$voucher_tarjeta->CurrentFilter = "0=1";
		$voucher_tarjeta_grid->StartRec = 1;
		$voucher_tarjeta_grid->DisplayRecs = $voucher_tarjeta->GridAddRowCount;
	}
	$voucher_tarjeta_grid->TotalRecs = $voucher_tarjeta_grid->DisplayRecs;
	$voucher_tarjeta_grid->StopRec = $voucher_tarjeta_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$voucher_tarjeta_grid->TotalRecs = $voucher_tarjeta->SelectRecordCount();
	} else {
		if ($voucher_tarjeta_grid->Recordset = $voucher_tarjeta_grid->LoadRecordset())
			$voucher_tarjeta_grid->TotalRecs = $voucher_tarjeta_grid->Recordset->RecordCount();
	}
	$voucher_tarjeta_grid->StartRec = 1;
	$voucher_tarjeta_grid->DisplayRecs = $voucher_tarjeta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$voucher_tarjeta_grid->Recordset = $voucher_tarjeta_grid->LoadRecordset($voucher_tarjeta_grid->StartRec-1, $voucher_tarjeta_grid->DisplayRecs);

	// Set no record found message
	if ($voucher_tarjeta->CurrentAction == "" && $voucher_tarjeta_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$voucher_tarjeta_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($voucher_tarjeta_grid->SearchWhere == "0=101")
			$voucher_tarjeta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$voucher_tarjeta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$voucher_tarjeta_grid->RenderOtherOptions();
?>
<?php $voucher_tarjeta_grid->ShowPageHeader(); ?>
<?php
$voucher_tarjeta_grid->ShowMessage();
?>
<?php if ($voucher_tarjeta_grid->TotalRecs > 0 || $voucher_tarjeta->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fvoucher_tarjetagrid" class="ewForm form-inline">
<div id="gmp_voucher_tarjeta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_voucher_tarjetagrid" class="table ewTable">
<?php echo $voucher_tarjeta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$voucher_tarjeta_grid->RenderListOptions();

// Render list options (header, left)
$voucher_tarjeta_grid->ListOptions->Render("header", "left");
?>
<?php if ($voucher_tarjeta->idbanco->Visible) { // idbanco ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->idbanco) == "") { ?>
		<th data-name="idbanco"><div id="elh_voucher_tarjeta_idbanco" class="voucher_tarjeta_idbanco"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->idbanco->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco"><div><div id="elh_voucher_tarjeta_idbanco" class="voucher_tarjeta_idbanco">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->idbanco->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->idbanco->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->idbanco->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->idcuenta->Visible) { // idcuenta ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->idcuenta) == "") { ?>
		<th data-name="idcuenta"><div id="elh_voucher_tarjeta_idcuenta" class="voucher_tarjeta_idcuenta"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->idcuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta"><div><div id="elh_voucher_tarjeta_idcuenta" class="voucher_tarjeta_idcuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->idcuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->idcuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->idcuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->marca->Visible) { // marca ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->marca) == "") { ?>
		<th data-name="marca"><div id="elh_voucher_tarjeta_marca" class="voucher_tarjeta_marca"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->marca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="marca"><div><div id="elh_voucher_tarjeta_marca" class="voucher_tarjeta_marca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->marca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->marca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->marca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->nombre->Visible) { // nombre ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_voucher_tarjeta_nombre" class="voucher_tarjeta_nombre"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_voucher_tarjeta_nombre" class="voucher_tarjeta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->ultimos_cuatro_digitos->Visible) { // ultimos_cuatro_digitos ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->ultimos_cuatro_digitos) == "") { ?>
		<th data-name="ultimos_cuatro_digitos"><div id="elh_voucher_tarjeta_ultimos_cuatro_digitos" class="voucher_tarjeta_ultimos_cuatro_digitos"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->ultimos_cuatro_digitos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ultimos_cuatro_digitos"><div><div id="elh_voucher_tarjeta_ultimos_cuatro_digitos" class="voucher_tarjeta_ultimos_cuatro_digitos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->ultimos_cuatro_digitos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->ultimos_cuatro_digitos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->ultimos_cuatro_digitos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->referencia->Visible) { // referencia ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->referencia) == "") { ?>
		<th data-name="referencia"><div id="elh_voucher_tarjeta_referencia" class="voucher_tarjeta_referencia"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->referencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="referencia"><div><div id="elh_voucher_tarjeta_referencia" class="voucher_tarjeta_referencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->referencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->referencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->referencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->fecha->Visible) { // fecha ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_voucher_tarjeta_fecha" class="voucher_tarjeta_fecha"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_voucher_tarjeta_fecha" class="voucher_tarjeta_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($voucher_tarjeta->monto->Visible) { // monto ?>
	<?php if ($voucher_tarjeta->SortUrl($voucher_tarjeta->monto) == "") { ?>
		<th data-name="monto"><div id="elh_voucher_tarjeta_monto" class="voucher_tarjeta_monto"><div class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_voucher_tarjeta_monto" class="voucher_tarjeta_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $voucher_tarjeta->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($voucher_tarjeta->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($voucher_tarjeta->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$voucher_tarjeta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$voucher_tarjeta_grid->StartRec = 1;
$voucher_tarjeta_grid->StopRec = $voucher_tarjeta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($voucher_tarjeta_grid->FormKeyCountName) && ($voucher_tarjeta->CurrentAction == "gridadd" || $voucher_tarjeta->CurrentAction == "gridedit" || $voucher_tarjeta->CurrentAction == "F")) {
		$voucher_tarjeta_grid->KeyCount = $objForm->GetValue($voucher_tarjeta_grid->FormKeyCountName);
		$voucher_tarjeta_grid->StopRec = $voucher_tarjeta_grid->StartRec + $voucher_tarjeta_grid->KeyCount - 1;
	}
}
$voucher_tarjeta_grid->RecCnt = $voucher_tarjeta_grid->StartRec - 1;
if ($voucher_tarjeta_grid->Recordset && !$voucher_tarjeta_grid->Recordset->EOF) {
	$voucher_tarjeta_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $voucher_tarjeta_grid->StartRec > 1)
		$voucher_tarjeta_grid->Recordset->Move($voucher_tarjeta_grid->StartRec - 1);
} elseif (!$voucher_tarjeta->AllowAddDeleteRow && $voucher_tarjeta_grid->StopRec == 0) {
	$voucher_tarjeta_grid->StopRec = $voucher_tarjeta->GridAddRowCount;
}

// Initialize aggregate
$voucher_tarjeta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$voucher_tarjeta->ResetAttrs();
$voucher_tarjeta_grid->RenderRow();
if ($voucher_tarjeta->CurrentAction == "gridadd")
	$voucher_tarjeta_grid->RowIndex = 0;
if ($voucher_tarjeta->CurrentAction == "gridedit")
	$voucher_tarjeta_grid->RowIndex = 0;
while ($voucher_tarjeta_grid->RecCnt < $voucher_tarjeta_grid->StopRec) {
	$voucher_tarjeta_grid->RecCnt++;
	if (intval($voucher_tarjeta_grid->RecCnt) >= intval($voucher_tarjeta_grid->StartRec)) {
		$voucher_tarjeta_grid->RowCnt++;
		if ($voucher_tarjeta->CurrentAction == "gridadd" || $voucher_tarjeta->CurrentAction == "gridedit" || $voucher_tarjeta->CurrentAction == "F") {
			$voucher_tarjeta_grid->RowIndex++;
			$objForm->Index = $voucher_tarjeta_grid->RowIndex;
			if ($objForm->HasValue($voucher_tarjeta_grid->FormActionName))
				$voucher_tarjeta_grid->RowAction = strval($objForm->GetValue($voucher_tarjeta_grid->FormActionName));
			elseif ($voucher_tarjeta->CurrentAction == "gridadd")
				$voucher_tarjeta_grid->RowAction = "insert";
			else
				$voucher_tarjeta_grid->RowAction = "";
		}

		// Set up key count
		$voucher_tarjeta_grid->KeyCount = $voucher_tarjeta_grid->RowIndex;

		// Init row class and style
		$voucher_tarjeta->ResetAttrs();
		$voucher_tarjeta->CssClass = "";
		if ($voucher_tarjeta->CurrentAction == "gridadd") {
			if ($voucher_tarjeta->CurrentMode == "copy") {
				$voucher_tarjeta_grid->LoadRowValues($voucher_tarjeta_grid->Recordset); // Load row values
				$voucher_tarjeta_grid->SetRecordKey($voucher_tarjeta_grid->RowOldKey, $voucher_tarjeta_grid->Recordset); // Set old record key
			} else {
				$voucher_tarjeta_grid->LoadDefaultValues(); // Load default values
				$voucher_tarjeta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$voucher_tarjeta_grid->LoadRowValues($voucher_tarjeta_grid->Recordset); // Load row values
		}
		$voucher_tarjeta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($voucher_tarjeta->CurrentAction == "gridadd") // Grid add
			$voucher_tarjeta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($voucher_tarjeta->CurrentAction == "gridadd" && $voucher_tarjeta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$voucher_tarjeta_grid->RestoreCurrentRowFormValues($voucher_tarjeta_grid->RowIndex); // Restore form values
		if ($voucher_tarjeta->CurrentAction == "gridedit") { // Grid edit
			if ($voucher_tarjeta->EventCancelled) {
				$voucher_tarjeta_grid->RestoreCurrentRowFormValues($voucher_tarjeta_grid->RowIndex); // Restore form values
			}
			if ($voucher_tarjeta_grid->RowAction == "insert")
				$voucher_tarjeta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$voucher_tarjeta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($voucher_tarjeta->CurrentAction == "gridedit" && ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT || $voucher_tarjeta->RowType == EW_ROWTYPE_ADD) && $voucher_tarjeta->EventCancelled) // Update failed
			$voucher_tarjeta_grid->RestoreCurrentRowFormValues($voucher_tarjeta_grid->RowIndex); // Restore form values
		if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$voucher_tarjeta_grid->EditRowCnt++;
		if ($voucher_tarjeta->CurrentAction == "F") // Confirm row
			$voucher_tarjeta_grid->RestoreCurrentRowFormValues($voucher_tarjeta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$voucher_tarjeta->RowAttrs = array_merge($voucher_tarjeta->RowAttrs, array('data-rowindex'=>$voucher_tarjeta_grid->RowCnt, 'id'=>'r' . $voucher_tarjeta_grid->RowCnt . '_voucher_tarjeta', 'data-rowtype'=>$voucher_tarjeta->RowType));

		// Render row
		$voucher_tarjeta_grid->RenderRow();

		// Render list options
		$voucher_tarjeta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($voucher_tarjeta_grid->RowAction <> "delete" && $voucher_tarjeta_grid->RowAction <> "insertdelete" && !($voucher_tarjeta_grid->RowAction == "insert" && $voucher_tarjeta->CurrentAction == "F" && $voucher_tarjeta_grid->EmptyRow())) {
?>
	<tr<?php echo $voucher_tarjeta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$voucher_tarjeta_grid->ListOptions->Render("body", "left", $voucher_tarjeta_grid->RowCnt);
?>
	<?php if ($voucher_tarjeta->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco"<?php echo $voucher_tarjeta->idbanco->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idbanco" class="form-group voucher_tarjeta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco"<?php echo $voucher_tarjeta->idbanco->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idbanco->EditValue)) {
	$arwrk = $voucher_tarjeta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idbanco->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idbanco" class="form-group voucher_tarjeta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco"<?php echo $voucher_tarjeta->idbanco->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idbanco->EditValue)) {
	$arwrk = $voucher_tarjeta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->idbanco->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->idbanco->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idbanco->FormValue) ?>">
<input type="hidden" data-field="x_idbanco" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idbanco->OldValue) ?>">
<?php } ?>
<a id="<?php echo $voucher_tarjeta_grid->PageObjName . "_row_" . $voucher_tarjeta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idvoucher_tarjeta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idvoucher_tarjeta->CurrentValue) ?>">
<input type="hidden" data-field="x_idvoucher_tarjeta" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idvoucher_tarjeta->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT || $voucher_tarjeta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idvoucher_tarjeta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idvoucher_tarjeta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idvoucher_tarjeta->CurrentValue) ?>">
<?php } ?>
	<?php if ($voucher_tarjeta->idcuenta->Visible) { // idcuenta ?>
		<td data-name="idcuenta"<?php echo $voucher_tarjeta->idcuenta->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($voucher_tarjeta->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta"<?php echo $voucher_tarjeta->idcuenta->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idcuenta->EditValue)) {
	$arwrk = $voucher_tarjeta->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$voucher_tarjeta->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($voucher_tarjeta->idcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta"<?php echo $voucher_tarjeta->idcuenta->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idcuenta->EditValue)) {
	$arwrk = $voucher_tarjeta->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$voucher_tarjeta->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->idcuenta->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->FormValue) ?>">
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->marca->Visible) { // marca ?>
		<td data-name="marca"<?php echo $voucher_tarjeta->marca->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_marca" class="form-group voucher_tarjeta_marca">
<select data-field="x_marca" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca"<?php echo $voucher_tarjeta->marca->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->marca->EditValue)) {
	$arwrk = $voucher_tarjeta->marca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->marca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->marca->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_marca" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" value="<?php echo ew_HtmlEncode($voucher_tarjeta->marca->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_marca" class="form-group voucher_tarjeta_marca">
<select data-field="x_marca" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca"<?php echo $voucher_tarjeta->marca->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->marca->EditValue)) {
	$arwrk = $voucher_tarjeta->marca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->marca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->marca->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->marca->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->marca->ListViewValue() ?></span>
<input type="hidden" data-field="x_marca" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" value="<?php echo ew_HtmlEncode($voucher_tarjeta->marca->FormValue) ?>">
<input type="hidden" data-field="x_marca" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" value="<?php echo ew_HtmlEncode($voucher_tarjeta->marca->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $voucher_tarjeta->nombre->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_nombre" class="form-group voucher_tarjeta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->nombre->EditValue ?>"<?php echo $voucher_tarjeta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_nombre" class="form-group voucher_tarjeta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->nombre->EditValue ?>"<?php echo $voucher_tarjeta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->nombre->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->ultimos_cuatro_digitos->Visible) { // ultimos_cuatro_digitos ?>
		<td data-name="ultimos_cuatro_digitos"<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_ultimos_cuatro_digitos" class="form-group voucher_tarjeta_ultimos_cuatro_digitos">
<input type="text" data-field="x_ultimos_cuatro_digitos" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditValue ?>"<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_ultimos_cuatro_digitos" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" value="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_ultimos_cuatro_digitos" class="form-group voucher_tarjeta_ultimos_cuatro_digitos">
<input type="text" data-field="x_ultimos_cuatro_digitos" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditValue ?>"<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ListViewValue() ?></span>
<input type="hidden" data-field="x_ultimos_cuatro_digitos" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" value="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->FormValue) ?>">
<input type="hidden" data-field="x_ultimos_cuatro_digitos" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" value="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->referencia->Visible) { // referencia ?>
		<td data-name="referencia"<?php echo $voucher_tarjeta->referencia->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_referencia" class="form-group voucher_tarjeta_referencia">
<input type="text" data-field="x_referencia" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->referencia->EditValue ?>"<?php echo $voucher_tarjeta->referencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_referencia" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" value="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_referencia" class="form-group voucher_tarjeta_referencia">
<input type="text" data-field="x_referencia" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->referencia->EditValue ?>"<?php echo $voucher_tarjeta->referencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->referencia->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->referencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_referencia" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" value="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->FormValue) ?>">
<input type="hidden" data-field="x_referencia" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" value="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $voucher_tarjeta->fecha->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_fecha" class="form-group voucher_tarjeta_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->fecha->EditValue ?>"<?php echo $voucher_tarjeta->fecha->EditAttributes() ?>>
<?php if (!$voucher_tarjeta->fecha->ReadOnly && !$voucher_tarjeta->fecha->Disabled && @$voucher_tarjeta->fecha->EditAttrs["readonly"] == "" && @$voucher_tarjeta->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fvoucher_tarjetagrid", "x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_fecha" class="form-group voucher_tarjeta_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->fecha->EditValue ?>"<?php echo $voucher_tarjeta->fecha->EditAttributes() ?>>
<?php if (!$voucher_tarjeta->fecha->ReadOnly && !$voucher_tarjeta->fecha->Disabled && @$voucher_tarjeta->fecha->EditAttrs["readonly"] == "" && @$voucher_tarjeta->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fvoucher_tarjetagrid", "x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->fecha->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $voucher_tarjeta->monto->CellAttributes() ?>>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_monto" class="form-group voucher_tarjeta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->monto->EditValue ?>"<?php echo $voucher_tarjeta->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->OldValue) ?>">
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $voucher_tarjeta_grid->RowCnt ?>_voucher_tarjeta_monto" class="form-group voucher_tarjeta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->monto->EditValue ?>"<?php echo $voucher_tarjeta->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $voucher_tarjeta->monto->ViewAttributes() ?>>
<?php echo $voucher_tarjeta->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$voucher_tarjeta_grid->ListOptions->Render("body", "right", $voucher_tarjeta_grid->RowCnt);
?>
	</tr>
<?php if ($voucher_tarjeta->RowType == EW_ROWTYPE_ADD || $voucher_tarjeta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvoucher_tarjetagrid.UpdateOpts(<?php echo $voucher_tarjeta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($voucher_tarjeta->CurrentAction <> "gridadd" || $voucher_tarjeta->CurrentMode == "copy")
		if (!$voucher_tarjeta_grid->Recordset->EOF) $voucher_tarjeta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($voucher_tarjeta->CurrentMode == "add" || $voucher_tarjeta->CurrentMode == "copy" || $voucher_tarjeta->CurrentMode == "edit") {
		$voucher_tarjeta_grid->RowIndex = '$rowindex$';
		$voucher_tarjeta_grid->LoadDefaultValues();

		// Set row properties
		$voucher_tarjeta->ResetAttrs();
		$voucher_tarjeta->RowAttrs = array_merge($voucher_tarjeta->RowAttrs, array('data-rowindex'=>$voucher_tarjeta_grid->RowIndex, 'id'=>'r0_voucher_tarjeta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($voucher_tarjeta->RowAttrs["class"], "ewTemplate");
		$voucher_tarjeta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$voucher_tarjeta_grid->RenderRow();

		// Render list options
		$voucher_tarjeta_grid->RenderListOptions();
		$voucher_tarjeta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $voucher_tarjeta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$voucher_tarjeta_grid->ListOptions->Render("body", "left", $voucher_tarjeta_grid->RowIndex);
?>
	<?php if ($voucher_tarjeta->idbanco->Visible) { // idbanco ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_idbanco" class="form-group voucher_tarjeta_idbanco">
<select data-field="x_idbanco" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco"<?php echo $voucher_tarjeta->idbanco->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idbanco->EditValue)) {
	$arwrk = $voucher_tarjeta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idbanco->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idbanco, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_idbanco" class="form-group voucher_tarjeta_idbanco">
<span<?php echo $voucher_tarjeta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbanco" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idbanco->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbanco" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idbanco->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->idcuenta->Visible) { // idcuenta ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<?php if ($voucher_tarjeta->idcuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<select data-field="x_idcuenta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta"<?php echo $voucher_tarjeta->idcuenta->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->idcuenta->EditValue)) {
	$arwrk = $voucher_tarjeta->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$voucher_tarjeta->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->idcuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $voucher_tarjeta->Lookup_Selecting($voucher_tarjeta->idcuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="s_x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_idcuenta" class="form-group voucher_tarjeta_idcuenta">
<span<?php echo $voucher_tarjeta->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcuenta" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcuenta" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($voucher_tarjeta->idcuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->marca->Visible) { // marca ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_marca" class="form-group voucher_tarjeta_marca">
<select data-field="x_marca" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca"<?php echo $voucher_tarjeta->marca->EditAttributes() ?>>
<?php
if (is_array($voucher_tarjeta->marca->EditValue)) {
	$arwrk = $voucher_tarjeta->marca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($voucher_tarjeta->marca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $voucher_tarjeta->marca->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_marca" class="form-group voucher_tarjeta_marca">
<span<?php echo $voucher_tarjeta->marca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->marca->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_marca" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" value="<?php echo ew_HtmlEncode($voucher_tarjeta->marca->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_marca" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_marca" value="<?php echo ew_HtmlEncode($voucher_tarjeta->marca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->nombre->Visible) { // nombre ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_nombre" class="form-group voucher_tarjeta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->nombre->EditValue ?>"<?php echo $voucher_tarjeta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_nombre" class="form-group voucher_tarjeta_nombre">
<span<?php echo $voucher_tarjeta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($voucher_tarjeta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->ultimos_cuatro_digitos->Visible) { // ultimos_cuatro_digitos ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_ultimos_cuatro_digitos" class="form-group voucher_tarjeta_ultimos_cuatro_digitos">
<input type="text" data-field="x_ultimos_cuatro_digitos" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditValue ?>"<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_ultimos_cuatro_digitos" class="form-group voucher_tarjeta_ultimos_cuatro_digitos">
<span<?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->ultimos_cuatro_digitos->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_ultimos_cuatro_digitos" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" value="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_ultimos_cuatro_digitos" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_ultimos_cuatro_digitos" value="<?php echo ew_HtmlEncode($voucher_tarjeta->ultimos_cuatro_digitos->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->referencia->Visible) { // referencia ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_referencia" class="form-group voucher_tarjeta_referencia">
<input type="text" data-field="x_referencia" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->referencia->EditValue ?>"<?php echo $voucher_tarjeta->referencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_referencia" class="form-group voucher_tarjeta_referencia">
<span<?php echo $voucher_tarjeta->referencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->referencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_referencia" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" value="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_referencia" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_referencia" value="<?php echo ew_HtmlEncode($voucher_tarjeta->referencia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->fecha->Visible) { // fecha ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_fecha" class="form-group voucher_tarjeta_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->fecha->EditValue ?>"<?php echo $voucher_tarjeta->fecha->EditAttributes() ?>>
<?php if (!$voucher_tarjeta->fecha->ReadOnly && !$voucher_tarjeta->fecha->Disabled && @$voucher_tarjeta->fecha->EditAttrs["readonly"] == "" && @$voucher_tarjeta->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fvoucher_tarjetagrid", "x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_fecha" class="form-group voucher_tarjeta_fecha">
<span<?php echo $voucher_tarjeta->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($voucher_tarjeta->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($voucher_tarjeta->monto->Visible) { // monto ?>
		<td>
<?php if ($voucher_tarjeta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_voucher_tarjeta_monto" class="form-group voucher_tarjeta_monto">
<input type="text" data-field="x_monto" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->PlaceHolder) ?>" value="<?php echo $voucher_tarjeta->monto->EditValue ?>"<?php echo $voucher_tarjeta->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_voucher_tarjeta_monto" class="form-group voucher_tarjeta_monto">
<span<?php echo $voucher_tarjeta->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $voucher_tarjeta->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="x<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" id="o<?php echo $voucher_tarjeta_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($voucher_tarjeta->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$voucher_tarjeta_grid->ListOptions->Render("body", "right", $voucher_tarjeta_grid->RowCnt);
?>
<script type="text/javascript">
fvoucher_tarjetagrid.UpdateOpts(<?php echo $voucher_tarjeta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($voucher_tarjeta->CurrentMode == "add" || $voucher_tarjeta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $voucher_tarjeta_grid->FormKeyCountName ?>" id="<?php echo $voucher_tarjeta_grid->FormKeyCountName ?>" value="<?php echo $voucher_tarjeta_grid->KeyCount ?>">
<?php echo $voucher_tarjeta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($voucher_tarjeta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $voucher_tarjeta_grid->FormKeyCountName ?>" id="<?php echo $voucher_tarjeta_grid->FormKeyCountName ?>" value="<?php echo $voucher_tarjeta_grid->KeyCount ?>">
<?php echo $voucher_tarjeta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($voucher_tarjeta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fvoucher_tarjetagrid">
</div>
<?php

// Close recordset
if ($voucher_tarjeta_grid->Recordset)
	$voucher_tarjeta_grid->Recordset->Close();
?>
<?php if ($voucher_tarjeta_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($voucher_tarjeta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($voucher_tarjeta_grid->TotalRecs == 0 && $voucher_tarjeta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($voucher_tarjeta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($voucher_tarjeta->Export == "") { ?>
<script type="text/javascript">
fvoucher_tarjetagrid.Init();
</script>
<?php } ?>
<?php
$voucher_tarjeta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$voucher_tarjeta_grid->Page_Terminate();
?>
