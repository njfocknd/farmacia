<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($documento_debito_grid)) $documento_debito_grid = new cdocumento_debito_grid();

// Page init
$documento_debito_grid->Page_Init();

// Page main
$documento_debito_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_debito_grid->Page_Render();
?>
<?php if ($documento_debito->Export == "") { ?>
<script type="text/javascript">

// Page object
var documento_debito_grid = new ew_Page("documento_debito_grid");
documento_debito_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = documento_debito_grid.PageID; // For backward compatibility

// Form object
var fdocumento_debitogrid = new ew_Form("fdocumento_debitogrid");
fdocumento_debitogrid.FormKeyCountName = '<?php echo $documento_debito_grid->FormKeyCountName ?>';

// Validate form
fdocumento_debitogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idtipo_documento->FldCaption(), $documento_debito->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idsucursal->FldCaption(), $documento_debito->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->correlativo->FldCaption(), $documento_debito->correlativo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->correlativo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->estado_documento->FldCaption(), $documento_debito->estado_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->monto->FldCaption(), $documento_debito->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->fecha_insercion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idcliente->FldCaption(), $documento_debito->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->idcliente->FldErrMsg()) ?>");

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
fdocumento_debitogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idtipo_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsucursal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "serie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "correlativo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcliente", false)) return false;
	return true;
}

// Form_CustomValidate event
fdocumento_debitogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_debitogrid.ValidateRequired = true;
<?php } else { ?>
fdocumento_debitogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_debitogrid.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitogrid.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($documento_debito->CurrentAction == "gridadd") {
	if ($documento_debito->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$documento_debito_grid->TotalRecs = $documento_debito->SelectRecordCount();
			$documento_debito_grid->Recordset = $documento_debito_grid->LoadRecordset($documento_debito_grid->StartRec-1, $documento_debito_grid->DisplayRecs);
		} else {
			if ($documento_debito_grid->Recordset = $documento_debito_grid->LoadRecordset())
				$documento_debito_grid->TotalRecs = $documento_debito_grid->Recordset->RecordCount();
		}
		$documento_debito_grid->StartRec = 1;
		$documento_debito_grid->DisplayRecs = $documento_debito_grid->TotalRecs;
	} else {
		$documento_debito->CurrentFilter = "0=1";
		$documento_debito_grid->StartRec = 1;
		$documento_debito_grid->DisplayRecs = $documento_debito->GridAddRowCount;
	}
	$documento_debito_grid->TotalRecs = $documento_debito_grid->DisplayRecs;
	$documento_debito_grid->StopRec = $documento_debito_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$documento_debito_grid->TotalRecs = $documento_debito->SelectRecordCount();
	} else {
		if ($documento_debito_grid->Recordset = $documento_debito_grid->LoadRecordset())
			$documento_debito_grid->TotalRecs = $documento_debito_grid->Recordset->RecordCount();
	}
	$documento_debito_grid->StartRec = 1;
	$documento_debito_grid->DisplayRecs = $documento_debito_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$documento_debito_grid->Recordset = $documento_debito_grid->LoadRecordset($documento_debito_grid->StartRec-1, $documento_debito_grid->DisplayRecs);

	// Set no record found message
	if ($documento_debito->CurrentAction == "" && $documento_debito_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$documento_debito_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($documento_debito_grid->SearchWhere == "0=101")
			$documento_debito_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$documento_debito_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$documento_debito_grid->RenderOtherOptions();
?>
<?php $documento_debito_grid->ShowPageHeader(); ?>
<?php
$documento_debito_grid->ShowMessage();
?>
<?php if ($documento_debito_grid->TotalRecs > 0 || $documento_debito->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdocumento_debitogrid" class="ewForm form-inline">
<div id="gmp_documento_debito" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_documento_debitogrid" class="table ewTable">
<?php echo $documento_debito->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$documento_debito_grid->RenderListOptions();

// Render list options (header, left)
$documento_debito_grid->ListOptions->Render("header", "left");
?>
<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
	<?php if ($documento_debito->SortUrl($documento_debito->idtipo_documento) == "") { ?>
		<th data-name="idtipo_documento"><div id="elh_documento_debito_idtipo_documento" class="documento_debito_idtipo_documento"><div class="ewTableHeaderCaption"><?php echo $documento_debito->idtipo_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_documento"><div><div id="elh_documento_debito_idtipo_documento" class="documento_debito_idtipo_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->idtipo_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->idtipo_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->idtipo_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
	<?php if ($documento_debito->SortUrl($documento_debito->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_documento_debito_idsucursal" class="documento_debito_idsucursal"><div class="ewTableHeaderCaption"><?php echo $documento_debito->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div><div id="elh_documento_debito_idsucursal" class="documento_debito_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->serie->Visible) { // serie ?>
	<?php if ($documento_debito->SortUrl($documento_debito->serie) == "") { ?>
		<th data-name="serie"><div id="elh_documento_debito_serie" class="documento_debito_serie"><div class="ewTableHeaderCaption"><?php echo $documento_debito->serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="serie"><div><div id="elh_documento_debito_serie" class="documento_debito_serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->serie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->correlativo->Visible) { // correlativo ?>
	<?php if ($documento_debito->SortUrl($documento_debito->correlativo) == "") { ?>
		<th data-name="correlativo"><div id="elh_documento_debito_correlativo" class="documento_debito_correlativo"><div class="ewTableHeaderCaption"><?php echo $documento_debito->correlativo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="correlativo"><div><div id="elh_documento_debito_correlativo" class="documento_debito_correlativo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->correlativo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->correlativo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->correlativo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->fecha->Visible) { // fecha ?>
	<?php if ($documento_debito->SortUrl($documento_debito->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_documento_debito_fecha" class="documento_debito_fecha"><div class="ewTableHeaderCaption"><?php echo $documento_debito->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_documento_debito_fecha" class="documento_debito_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->nombre->Visible) { // nombre ?>
	<?php if ($documento_debito->SortUrl($documento_debito->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_documento_debito_nombre" class="documento_debito_nombre"><div class="ewTableHeaderCaption"><?php echo $documento_debito->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_documento_debito_nombre" class="documento_debito_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
	<?php if ($documento_debito->SortUrl($documento_debito->estado_documento) == "") { ?>
		<th data-name="estado_documento"><div id="elh_documento_debito_estado_documento" class="documento_debito_estado_documento"><div class="ewTableHeaderCaption"><?php echo $documento_debito->estado_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento"><div><div id="elh_documento_debito_estado_documento" class="documento_debito_estado_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->estado_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->estado_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->estado_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->monto->Visible) { // monto ?>
	<?php if ($documento_debito->SortUrl($documento_debito->monto) == "") { ?>
		<th data-name="monto"><div id="elh_documento_debito_monto" class="documento_debito_monto"><div class="ewTableHeaderCaption"><?php echo $documento_debito->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_documento_debito_monto" class="documento_debito_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($documento_debito->SortUrl($documento_debito->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_documento_debito_fecha_insercion" class="documento_debito_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $documento_debito->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_documento_debito_fecha_insercion" class="documento_debito_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
	<?php if ($documento_debito->SortUrl($documento_debito->idcliente) == "") { ?>
		<th data-name="idcliente"><div id="elh_documento_debito_idcliente" class="documento_debito_idcliente"><div class="ewTableHeaderCaption"><?php echo $documento_debito->idcliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcliente"><div><div id="elh_documento_debito_idcliente" class="documento_debito_idcliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_debito->idcliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_debito->idcliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_debito->idcliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$documento_debito_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$documento_debito_grid->StartRec = 1;
$documento_debito_grid->StopRec = $documento_debito_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($documento_debito_grid->FormKeyCountName) && ($documento_debito->CurrentAction == "gridadd" || $documento_debito->CurrentAction == "gridedit" || $documento_debito->CurrentAction == "F")) {
		$documento_debito_grid->KeyCount = $objForm->GetValue($documento_debito_grid->FormKeyCountName);
		$documento_debito_grid->StopRec = $documento_debito_grid->StartRec + $documento_debito_grid->KeyCount - 1;
	}
}
$documento_debito_grid->RecCnt = $documento_debito_grid->StartRec - 1;
if ($documento_debito_grid->Recordset && !$documento_debito_grid->Recordset->EOF) {
	$documento_debito_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $documento_debito_grid->StartRec > 1)
		$documento_debito_grid->Recordset->Move($documento_debito_grid->StartRec - 1);
} elseif (!$documento_debito->AllowAddDeleteRow && $documento_debito_grid->StopRec == 0) {
	$documento_debito_grid->StopRec = $documento_debito->GridAddRowCount;
}

// Initialize aggregate
$documento_debito->RowType = EW_ROWTYPE_AGGREGATEINIT;
$documento_debito->ResetAttrs();
$documento_debito_grid->RenderRow();
if ($documento_debito->CurrentAction == "gridadd")
	$documento_debito_grid->RowIndex = 0;
if ($documento_debito->CurrentAction == "gridedit")
	$documento_debito_grid->RowIndex = 0;
while ($documento_debito_grid->RecCnt < $documento_debito_grid->StopRec) {
	$documento_debito_grid->RecCnt++;
	if (intval($documento_debito_grid->RecCnt) >= intval($documento_debito_grid->StartRec)) {
		$documento_debito_grid->RowCnt++;
		if ($documento_debito->CurrentAction == "gridadd" || $documento_debito->CurrentAction == "gridedit" || $documento_debito->CurrentAction == "F") {
			$documento_debito_grid->RowIndex++;
			$objForm->Index = $documento_debito_grid->RowIndex;
			if ($objForm->HasValue($documento_debito_grid->FormActionName))
				$documento_debito_grid->RowAction = strval($objForm->GetValue($documento_debito_grid->FormActionName));
			elseif ($documento_debito->CurrentAction == "gridadd")
				$documento_debito_grid->RowAction = "insert";
			else
				$documento_debito_grid->RowAction = "";
		}

		// Set up key count
		$documento_debito_grid->KeyCount = $documento_debito_grid->RowIndex;

		// Init row class and style
		$documento_debito->ResetAttrs();
		$documento_debito->CssClass = "";
		if ($documento_debito->CurrentAction == "gridadd") {
			if ($documento_debito->CurrentMode == "copy") {
				$documento_debito_grid->LoadRowValues($documento_debito_grid->Recordset); // Load row values
				$documento_debito_grid->SetRecordKey($documento_debito_grid->RowOldKey, $documento_debito_grid->Recordset); // Set old record key
			} else {
				$documento_debito_grid->LoadDefaultValues(); // Load default values
				$documento_debito_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$documento_debito_grid->LoadRowValues($documento_debito_grid->Recordset); // Load row values
		}
		$documento_debito->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($documento_debito->CurrentAction == "gridadd") // Grid add
			$documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
		if ($documento_debito->CurrentAction == "gridadd" && $documento_debito->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$documento_debito_grid->RestoreCurrentRowFormValues($documento_debito_grid->RowIndex); // Restore form values
		if ($documento_debito->CurrentAction == "gridedit") { // Grid edit
			if ($documento_debito->EventCancelled) {
				$documento_debito_grid->RestoreCurrentRowFormValues($documento_debito_grid->RowIndex); // Restore form values
			}
			if ($documento_debito_grid->RowAction == "insert")
				$documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$documento_debito->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($documento_debito->CurrentAction == "gridedit" && ($documento_debito->RowType == EW_ROWTYPE_EDIT || $documento_debito->RowType == EW_ROWTYPE_ADD) && $documento_debito->EventCancelled) // Update failed
			$documento_debito_grid->RestoreCurrentRowFormValues($documento_debito_grid->RowIndex); // Restore form values
		if ($documento_debito->RowType == EW_ROWTYPE_EDIT) // Edit row
			$documento_debito_grid->EditRowCnt++;
		if ($documento_debito->CurrentAction == "F") // Confirm row
			$documento_debito_grid->RestoreCurrentRowFormValues($documento_debito_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$documento_debito->RowAttrs = array_merge($documento_debito->RowAttrs, array('data-rowindex'=>$documento_debito_grid->RowCnt, 'id'=>'r' . $documento_debito_grid->RowCnt . '_documento_debito', 'data-rowtype'=>$documento_debito->RowType));

		// Render row
		$documento_debito_grid->RenderRow();

		// Render list options
		$documento_debito_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($documento_debito_grid->RowAction <> "delete" && $documento_debito_grid->RowAction <> "insertdelete" && !($documento_debito_grid->RowAction == "insert" && $documento_debito->CurrentAction == "F" && $documento_debito_grid->EmptyRow())) {
?>
	<tr<?php echo $documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_debito_grid->ListOptions->Render("body", "left", $documento_debito_grid->RowCnt);
?>
	<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento"<?php echo $documento_debito->idtipo_documento->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($documento_debito->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_debito->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idtipo_documento->EditValue)) {
	$arwrk = $documento_debito->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_debito->Lookup_Selecting($documento_debito->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documento_debito->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_debito->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idtipo_documento->EditValue)) {
	$arwrk = $documento_debito->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_debito->Lookup_Selecting($documento_debito->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_debito->idtipo_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->FormValue) ?>">
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->OldValue) ?>">
<?php } ?>
<a id="<?php echo $documento_debito_grid->PageObjName . "_row_" . $documento_debito_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddocumento_debito" name="x<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" id="x<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($documento_debito->iddocumento_debito->CurrentValue) ?>">
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" id="o<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($documento_debito->iddocumento_debito->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT || $documento_debito->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddocumento_debito" name="x<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" id="x<?php echo $documento_debito_grid->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } ?>
	<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $documento_debito->idsucursal->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($documento_debito->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal"<?php echo $documento_debito->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idsucursal->EditValue)) {
	$arwrk = $documento_debito->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idsucursal->OldValue = "";
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
 $documento_debito->Lookup_Selecting($documento_debito->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documento_debito->idsucursal->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal"<?php echo $documento_debito->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idsucursal->EditValue)) {
	$arwrk = $documento_debito->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idsucursal->OldValue = "";
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
 $documento_debito->Lookup_Selecting($documento_debito->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<?php echo $documento_debito->idsucursal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->FormValue) ?>">
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->serie->Visible) { // serie ?>
		<td data-name="serie"<?php echo $documento_debito->serie->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_serie" class="form-group documento_debito_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_debito_grid->RowIndex ?>_serie" id="x<?php echo $documento_debito_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->serie->PlaceHolder) ?>" value="<?php echo $documento_debito->serie->EditValue ?>"<?php echo $documento_debito->serie->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_debito_grid->RowIndex ?>_serie" id="o<?php echo $documento_debito_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_debito->serie->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_serie" class="form-group documento_debito_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_debito_grid->RowIndex ?>_serie" id="x<?php echo $documento_debito_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->serie->PlaceHolder) ?>" value="<?php echo $documento_debito->serie->EditValue ?>"<?php echo $documento_debito->serie->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->serie->ViewAttributes() ?>>
<?php echo $documento_debito->serie->ListViewValue() ?></span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_debito_grid->RowIndex ?>_serie" id="x<?php echo $documento_debito_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_debito->serie->FormValue) ?>">
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_debito_grid->RowIndex ?>_serie" id="o<?php echo $documento_debito_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_debito->serie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->correlativo->Visible) { // correlativo ?>
		<td data-name="correlativo"<?php echo $documento_debito->correlativo->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_correlativo" class="form-group documento_debito_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->correlativo->PlaceHolder) ?>" value="<?php echo $documento_debito->correlativo->EditValue ?>"<?php echo $documento_debito->correlativo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento_debito->correlativo->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_correlativo" class="form-group documento_debito_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->correlativo->PlaceHolder) ?>" value="<?php echo $documento_debito->correlativo->EditValue ?>"<?php echo $documento_debito->correlativo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->correlativo->ViewAttributes() ?>>
<?php echo $documento_debito->correlativo->ListViewValue() ?></span>
<input type="hidden" data-field="x_correlativo" name="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento_debito->correlativo->FormValue) ?>">
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento_debito->correlativo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $documento_debito->fecha->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_fecha" class="form-group documento_debito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha->EditValue ?>"<?php echo $documento_debito->fecha->EditAttributes() ?>>
<?php if (!$documento_debito->fecha->ReadOnly && !$documento_debito->fecha->Disabled && @$documento_debito->fecha->EditAttrs["readonly"] == "" && @$documento_debito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_debitogrid", "x<?php echo $documento_debito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_debito->fecha->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_fecha" class="form-group documento_debito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha->EditValue ?>"<?php echo $documento_debito->fecha->EditAttributes() ?>>
<?php if (!$documento_debito->fecha->ReadOnly && !$documento_debito->fecha->Disabled && @$documento_debito->fecha->EditAttrs["readonly"] == "" && @$documento_debito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_debitogrid", "x<?php echo $documento_debito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->fecha->ViewAttributes() ?>>
<?php echo $documento_debito->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_debito->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_debito->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $documento_debito->nombre->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_nombre" class="form-group documento_debito_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->nombre->PlaceHolder) ?>" value="<?php echo $documento_debito->nombre->EditValue ?>"<?php echo $documento_debito->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento_debito->nombre->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_nombre" class="form-group documento_debito_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->nombre->PlaceHolder) ?>" value="<?php echo $documento_debito->nombre->EditValue ?>"<?php echo $documento_debito->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->nombre->ViewAttributes() ?>>
<?php echo $documento_debito->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento_debito->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento_debito->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
		<td data-name="estado_documento"<?php echo $documento_debito->estado_documento->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_estado_documento" class="form-group documento_debito_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento"<?php echo $documento_debito->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->estado_documento->EditValue)) {
	$arwrk = $documento_debito->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->estado_documento->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento_debito->estado_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_estado_documento" class="form-group documento_debito_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento"<?php echo $documento_debito->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->estado_documento->EditValue)) {
	$arwrk = $documento_debito->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->estado_documento->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->estado_documento->ViewAttributes() ?>>
<?php echo $documento_debito->estado_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento_debito->estado_documento->FormValue) ?>">
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento_debito->estado_documento->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $documento_debito->monto->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_monto" class="form-group documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->monto->PlaceHolder) ?>" value="<?php echo $documento_debito->monto->EditValue ?>"<?php echo $documento_debito->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_debito->monto->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_monto" class="form-group documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->monto->PlaceHolder) ?>" value="<?php echo $documento_debito->monto->EditValue ?>"<?php echo $documento_debito->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->monto->ViewAttributes() ?>>
<?php echo $documento_debito->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_debito->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_debito->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $documento_debito->fecha_insercion->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_fecha_insercion" class="form-group documento_debito_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha_insercion->EditValue ?>"<?php echo $documento_debito->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_fecha_insercion" class="form-group documento_debito_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha_insercion->EditValue ?>"<?php echo $documento_debito->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_debito->fecha_insercion->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->FormValue) ?>">
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
		<td data-name="idcliente"<?php echo $documento_debito->idcliente->CellAttributes() ?>>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idcliente" class="form-group documento_debito_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->idcliente->PlaceHolder) ?>" value="<?php echo $documento_debito->idcliente->EditValue ?>"<?php echo $documento_debito->idcliente->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento_debito->idcliente->OldValue) ?>">
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_debito_grid->RowCnt ?>_documento_debito_idcliente" class="form-group documento_debito_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->idcliente->PlaceHolder) ?>" value="<?php echo $documento_debito->idcliente->EditValue ?>"<?php echo $documento_debito->idcliente->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_debito->idcliente->ViewAttributes() ?>>
<?php echo $documento_debito->idcliente->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento_debito->idcliente->FormValue) ?>">
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento_debito->idcliente->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_debito_grid->ListOptions->Render("body", "right", $documento_debito_grid->RowCnt);
?>
	</tr>
<?php if ($documento_debito->RowType == EW_ROWTYPE_ADD || $documento_debito->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdocumento_debitogrid.UpdateOpts(<?php echo $documento_debito_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($documento_debito->CurrentAction <> "gridadd" || $documento_debito->CurrentMode == "copy")
		if (!$documento_debito_grid->Recordset->EOF) $documento_debito_grid->Recordset->MoveNext();
}
?>
<?php
	if ($documento_debito->CurrentMode == "add" || $documento_debito->CurrentMode == "copy" || $documento_debito->CurrentMode == "edit") {
		$documento_debito_grid->RowIndex = '$rowindex$';
		$documento_debito_grid->LoadDefaultValues();

		// Set row properties
		$documento_debito->ResetAttrs();
		$documento_debito->RowAttrs = array_merge($documento_debito->RowAttrs, array('data-rowindex'=>$documento_debito_grid->RowIndex, 'id'=>'r0_documento_debito', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($documento_debito->RowAttrs["class"], "ewTemplate");
		$documento_debito->RowType = EW_ROWTYPE_ADD;

		// Render row
		$documento_debito_grid->RenderRow();

		// Render list options
		$documento_debito_grid->RenderListOptions();
		$documento_debito_grid->StartRowCnt = 0;
?>
	<tr<?php echo $documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_debito_grid->ListOptions->Render("body", "left", $documento_debito_grid->RowIndex);
?>
	<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<?php if ($documento_debito->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el$rowindex$_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_debito->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idtipo_documento->EditValue)) {
	$arwrk = $documento_debito->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_debito->Lookup_Selecting($documento_debito->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_idtipo_documento" class="form-group documento_debito_idtipo_documento">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<?php if ($documento_debito->idsucursal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<select data-field="x_idsucursal" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal"<?php echo $documento_debito->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idsucursal->EditValue)) {
	$arwrk = $documento_debito->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->idsucursal->OldValue = "";
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
 $documento_debito->Lookup_Selecting($documento_debito->idsucursal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="s_x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_idsucursal" class="form-group documento_debito_idsucursal">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idsucursal" name="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="x<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idsucursal" name="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" id="o<?php echo $documento_debito_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->serie->Visible) { // serie ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_serie" class="form-group documento_debito_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_debito_grid->RowIndex ?>_serie" id="x<?php echo $documento_debito_grid->RowIndex ?>_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->serie->PlaceHolder) ?>" value="<?php echo $documento_debito->serie->EditValue ?>"<?php echo $documento_debito->serie->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_serie" class="form-group documento_debito_serie">
<span<?php echo $documento_debito->serie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->serie->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_debito_grid->RowIndex ?>_serie" id="x<?php echo $documento_debito_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_debito->serie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_debito_grid->RowIndex ?>_serie" id="o<?php echo $documento_debito_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_debito->serie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->correlativo->Visible) { // correlativo ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_correlativo" class="form-group documento_debito_correlativo">
<input type="text" data-field="x_correlativo" name="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->correlativo->PlaceHolder) ?>" value="<?php echo $documento_debito->correlativo->EditValue ?>"<?php echo $documento_debito->correlativo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_correlativo" class="form-group documento_debito_correlativo">
<span<?php echo $documento_debito->correlativo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->correlativo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_correlativo" name="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="x<?php echo $documento_debito_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento_debito->correlativo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_correlativo" name="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" id="o<?php echo $documento_debito_grid->RowIndex ?>_correlativo" value="<?php echo ew_HtmlEncode($documento_debito->correlativo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->fecha->Visible) { // fecha ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_fecha" class="form-group documento_debito_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha->EditValue ?>"<?php echo $documento_debito->fecha->EditAttributes() ?>>
<?php if (!$documento_debito->fecha->ReadOnly && !$documento_debito->fecha->Disabled && @$documento_debito->fecha->EditAttrs["readonly"] == "" && @$documento_debito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_debitogrid", "x<?php echo $documento_debito_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_fecha" class="form-group documento_debito_fecha">
<span<?php echo $documento_debito->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_debito->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_debito->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->nombre->Visible) { // nombre ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_nombre" class="form-group documento_debito_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->nombre->PlaceHolder) ?>" value="<?php echo $documento_debito->nombre->EditValue ?>"<?php echo $documento_debito->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_nombre" class="form-group documento_debito_nombre">
<span<?php echo $documento_debito->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="x<?php echo $documento_debito_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento_debito->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" id="o<?php echo $documento_debito_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($documento_debito->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_estado_documento" class="form-group documento_debito_estado_documento">
<select data-field="x_estado_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento"<?php echo $documento_debito->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->estado_documento->EditValue)) {
	$arwrk = $documento_debito->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_debito->estado_documento->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_estado_documento" class="form-group documento_debito_estado_documento">
<span<?php echo $documento_debito->estado_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->estado_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado_documento" name="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" id="x<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento_debito->estado_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado_documento" name="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" id="o<?php echo $documento_debito_grid->RowIndex ?>_estado_documento" value="<?php echo ew_HtmlEncode($documento_debito->estado_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->monto->Visible) { // monto ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_monto" class="form-group documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $documento_debito_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->monto->PlaceHolder) ?>" value="<?php echo $documento_debito->monto->EditValue ?>"<?php echo $documento_debito->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_monto" class="form-group documento_debito_monto">
<span<?php echo $documento_debito->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_debito_grid->RowIndex ?>_monto" id="x<?php echo $documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_debito->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_debito_grid->RowIndex ?>_monto" id="o<?php echo $documento_debito_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_debito->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_fecha_insercion" class="form-group documento_debito_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha_insercion->EditValue ?>"<?php echo $documento_debito->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_fecha_insercion" class="form-group documento_debito_fecha_insercion">
<span<?php echo $documento_debito->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $documento_debito_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
		<td>
<?php if ($documento_debito->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_debito_idcliente" class="form-group documento_debito_idcliente">
<input type="text" data-field="x_idcliente" name="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->idcliente->PlaceHolder) ?>" value="<?php echo $documento_debito->idcliente->EditValue ?>"<?php echo $documento_debito->idcliente->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_debito_idcliente" class="form-group documento_debito_idcliente">
<span<?php echo $documento_debito->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="x<?php echo $documento_debito_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento_debito->idcliente->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcliente" name="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" id="o<?php echo $documento_debito_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($documento_debito->idcliente->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_debito_grid->ListOptions->Render("body", "right", $documento_debito_grid->RowCnt);
?>
<script type="text/javascript">
fdocumento_debitogrid.UpdateOpts(<?php echo $documento_debito_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($documento_debito->CurrentMode == "add" || $documento_debito->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $documento_debito_grid->FormKeyCountName ?>" id="<?php echo $documento_debito_grid->FormKeyCountName ?>" value="<?php echo $documento_debito_grid->KeyCount ?>">
<?php echo $documento_debito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_debito->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $documento_debito_grid->FormKeyCountName ?>" id="<?php echo $documento_debito_grid->FormKeyCountName ?>" value="<?php echo $documento_debito_grid->KeyCount ?>">
<?php echo $documento_debito_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_debito->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdocumento_debitogrid">
</div>
<?php

// Close recordset
if ($documento_debito_grid->Recordset)
	$documento_debito_grid->Recordset->Close();
?>
<?php if ($documento_debito_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($documento_debito_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($documento_debito_grid->TotalRecs == 0 && $documento_debito->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($documento_debito_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($documento_debito->Export == "") { ?>
<script type="text/javascript">
fdocumento_debitogrid.Init();
</script>
<?php } ?>
<?php
$documento_debito_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$documento_debito_grid->Page_Terminate();
?>
