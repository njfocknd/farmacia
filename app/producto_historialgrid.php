<?php

// Create page object
if (!isset($producto_historial_grid)) $producto_historial_grid = new cproducto_historial_grid();

// Page init
$producto_historial_grid->Page_Init();

// Page main
$producto_historial_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_historial_grid->Page_Render();
?>
<?php if ($producto_historial->Export == "") { ?>
<script type="text/javascript">

// Page object
var producto_historial_grid = new ew_Page("producto_historial_grid");
producto_historial_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = producto_historial_grid.PageID; // For backward compatibility

// Form object
var fproducto_historialgrid = new ew_Form("fproducto_historialgrid");
fproducto_historialgrid.FormKeyCountName = '<?php echo $producto_historial_grid->FormKeyCountName ?>';

// Validate form
fproducto_historialgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idproducto->FldCaption(), $producto_historial->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idbodega->FldCaption(), $producto_historial->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_unidades_ingreso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->unidades_ingreso->FldCaption(), $producto_historial->unidades_ingreso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_unidades_ingreso");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_ingreso->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_unidades_salida");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->unidades_salida->FldCaption(), $producto_historial->unidades_salida->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_unidades_salida");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_salida->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->fecha_insercion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idrelacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idrelacion->FldCaption(), $producto_historial->idrelacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idrelacion");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->idrelacion->FldErrMsg()) ?>");

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
fproducto_historialgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "unidades_ingreso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "unidades_salida", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idrelacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tabla_relacion", false)) return false;
	return true;
}

// Form_CustomValidate event
fproducto_historialgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_historialgrid.ValidateRequired = true;
<?php } else { ?>
fproducto_historialgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_historialgrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_historialgrid.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($producto_historial->CurrentAction == "gridadd") {
	if ($producto_historial->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$producto_historial_grid->TotalRecs = $producto_historial->SelectRecordCount();
			$producto_historial_grid->Recordset = $producto_historial_grid->LoadRecordset($producto_historial_grid->StartRec-1, $producto_historial_grid->DisplayRecs);
		} else {
			if ($producto_historial_grid->Recordset = $producto_historial_grid->LoadRecordset())
				$producto_historial_grid->TotalRecs = $producto_historial_grid->Recordset->RecordCount();
		}
		$producto_historial_grid->StartRec = 1;
		$producto_historial_grid->DisplayRecs = $producto_historial_grid->TotalRecs;
	} else {
		$producto_historial->CurrentFilter = "0=1";
		$producto_historial_grid->StartRec = 1;
		$producto_historial_grid->DisplayRecs = $producto_historial->GridAddRowCount;
	}
	$producto_historial_grid->TotalRecs = $producto_historial_grid->DisplayRecs;
	$producto_historial_grid->StopRec = $producto_historial_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$producto_historial_grid->TotalRecs = $producto_historial->SelectRecordCount();
	} else {
		if ($producto_historial_grid->Recordset = $producto_historial_grid->LoadRecordset())
			$producto_historial_grid->TotalRecs = $producto_historial_grid->Recordset->RecordCount();
	}
	$producto_historial_grid->StartRec = 1;
	$producto_historial_grid->DisplayRecs = $producto_historial_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$producto_historial_grid->Recordset = $producto_historial_grid->LoadRecordset($producto_historial_grid->StartRec-1, $producto_historial_grid->DisplayRecs);

	// Set no record found message
	if ($producto_historial->CurrentAction == "" && $producto_historial_grid->TotalRecs == 0) {
		if ($producto_historial_grid->SearchWhere == "0=101")
			$producto_historial_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$producto_historial_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$producto_historial_grid->RenderOtherOptions();
?>
<?php $producto_historial_grid->ShowPageHeader(); ?>
<?php
$producto_historial_grid->ShowMessage();
?>
<?php if ($producto_historial_grid->TotalRecs > 0 || $producto_historial->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fproducto_historialgrid" class="ewForm form-inline">
<div id="gmp_producto_historial" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_producto_historialgrid" class="table ewTable">
<?php echo $producto_historial->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$producto_historial_grid->RenderListOptions();

// Render list options (header, left)
$producto_historial_grid->ListOptions->Render("header", "left");
?>
<?php if ($producto_historial->idproducto->Visible) { // idproducto ?>
	<?php if ($producto_historial->SortUrl($producto_historial->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_producto_historial_idproducto" class="producto_historial_idproducto"><div class="ewTableHeaderCaption"><?php echo $producto_historial->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_producto_historial_idproducto" class="producto_historial_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->idbodega->Visible) { // idbodega ?>
	<?php if ($producto_historial->SortUrl($producto_historial->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_producto_historial_idbodega" class="producto_historial_idbodega"><div class="ewTableHeaderCaption"><?php echo $producto_historial->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div><div id="elh_producto_historial_idbodega" class="producto_historial_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->fecha->Visible) { // fecha ?>
	<?php if ($producto_historial->SortUrl($producto_historial->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_producto_historial_fecha" class="producto_historial_fecha"><div class="ewTableHeaderCaption"><?php echo $producto_historial->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_producto_historial_fecha" class="producto_historial_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->unidades_ingreso->Visible) { // unidades_ingreso ?>
	<?php if ($producto_historial->SortUrl($producto_historial->unidades_ingreso) == "") { ?>
		<th data-name="unidades_ingreso"><div id="elh_producto_historial_unidades_ingreso" class="producto_historial_unidades_ingreso"><div class="ewTableHeaderCaption"><?php echo $producto_historial->unidades_ingreso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="unidades_ingreso"><div><div id="elh_producto_historial_unidades_ingreso" class="producto_historial_unidades_ingreso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->unidades_ingreso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->unidades_ingreso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->unidades_ingreso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->unidades_salida->Visible) { // unidades_salida ?>
	<?php if ($producto_historial->SortUrl($producto_historial->unidades_salida) == "") { ?>
		<th data-name="unidades_salida"><div id="elh_producto_historial_unidades_salida" class="producto_historial_unidades_salida"><div class="ewTableHeaderCaption"><?php echo $producto_historial->unidades_salida->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="unidades_salida"><div><div id="elh_producto_historial_unidades_salida" class="producto_historial_unidades_salida">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->unidades_salida->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->unidades_salida->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->unidades_salida->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($producto_historial->SortUrl($producto_historial->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_producto_historial_fecha_insercion" class="producto_historial_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $producto_historial->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_producto_historial_fecha_insercion" class="producto_historial_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->idrelacion->Visible) { // idrelacion ?>
	<?php if ($producto_historial->SortUrl($producto_historial->idrelacion) == "") { ?>
		<th data-name="idrelacion"><div id="elh_producto_historial_idrelacion" class="producto_historial_idrelacion"><div class="ewTableHeaderCaption"><?php echo $producto_historial->idrelacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idrelacion"><div><div id="elh_producto_historial_idrelacion" class="producto_historial_idrelacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->idrelacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->idrelacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->idrelacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto_historial->tabla_relacion->Visible) { // tabla_relacion ?>
	<?php if ($producto_historial->SortUrl($producto_historial->tabla_relacion) == "") { ?>
		<th data-name="tabla_relacion"><div id="elh_producto_historial_tabla_relacion" class="producto_historial_tabla_relacion"><div class="ewTableHeaderCaption"><?php echo $producto_historial->tabla_relacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tabla_relacion"><div><div id="elh_producto_historial_tabla_relacion" class="producto_historial_tabla_relacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto_historial->tabla_relacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto_historial->tabla_relacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto_historial->tabla_relacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$producto_historial_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$producto_historial_grid->StartRec = 1;
$producto_historial_grid->StopRec = $producto_historial_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($producto_historial_grid->FormKeyCountName) && ($producto_historial->CurrentAction == "gridadd" || $producto_historial->CurrentAction == "gridedit" || $producto_historial->CurrentAction == "F")) {
		$producto_historial_grid->KeyCount = $objForm->GetValue($producto_historial_grid->FormKeyCountName);
		$producto_historial_grid->StopRec = $producto_historial_grid->StartRec + $producto_historial_grid->KeyCount - 1;
	}
}
$producto_historial_grid->RecCnt = $producto_historial_grid->StartRec - 1;
if ($producto_historial_grid->Recordset && !$producto_historial_grid->Recordset->EOF) {
	$producto_historial_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $producto_historial_grid->StartRec > 1)
		$producto_historial_grid->Recordset->Move($producto_historial_grid->StartRec - 1);
} elseif (!$producto_historial->AllowAddDeleteRow && $producto_historial_grid->StopRec == 0) {
	$producto_historial_grid->StopRec = $producto_historial->GridAddRowCount;
}

// Initialize aggregate
$producto_historial->RowType = EW_ROWTYPE_AGGREGATEINIT;
$producto_historial->ResetAttrs();
$producto_historial_grid->RenderRow();
if ($producto_historial->CurrentAction == "gridadd")
	$producto_historial_grid->RowIndex = 0;
if ($producto_historial->CurrentAction == "gridedit")
	$producto_historial_grid->RowIndex = 0;
while ($producto_historial_grid->RecCnt < $producto_historial_grid->StopRec) {
	$producto_historial_grid->RecCnt++;
	if (intval($producto_historial_grid->RecCnt) >= intval($producto_historial_grid->StartRec)) {
		$producto_historial_grid->RowCnt++;
		if ($producto_historial->CurrentAction == "gridadd" || $producto_historial->CurrentAction == "gridedit" || $producto_historial->CurrentAction == "F") {
			$producto_historial_grid->RowIndex++;
			$objForm->Index = $producto_historial_grid->RowIndex;
			if ($objForm->HasValue($producto_historial_grid->FormActionName))
				$producto_historial_grid->RowAction = strval($objForm->GetValue($producto_historial_grid->FormActionName));
			elseif ($producto_historial->CurrentAction == "gridadd")
				$producto_historial_grid->RowAction = "insert";
			else
				$producto_historial_grid->RowAction = "";
		}

		// Set up key count
		$producto_historial_grid->KeyCount = $producto_historial_grid->RowIndex;

		// Init row class and style
		$producto_historial->ResetAttrs();
		$producto_historial->CssClass = "";
		if ($producto_historial->CurrentAction == "gridadd") {
			if ($producto_historial->CurrentMode == "copy") {
				$producto_historial_grid->LoadRowValues($producto_historial_grid->Recordset); // Load row values
				$producto_historial_grid->SetRecordKey($producto_historial_grid->RowOldKey, $producto_historial_grid->Recordset); // Set old record key
			} else {
				$producto_historial_grid->LoadDefaultValues(); // Load default values
				$producto_historial_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$producto_historial_grid->LoadRowValues($producto_historial_grid->Recordset); // Load row values
		}
		$producto_historial->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($producto_historial->CurrentAction == "gridadd") // Grid add
			$producto_historial->RowType = EW_ROWTYPE_ADD; // Render add
		if ($producto_historial->CurrentAction == "gridadd" && $producto_historial->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$producto_historial_grid->RestoreCurrentRowFormValues($producto_historial_grid->RowIndex); // Restore form values
		if ($producto_historial->CurrentAction == "gridedit") { // Grid edit
			if ($producto_historial->EventCancelled) {
				$producto_historial_grid->RestoreCurrentRowFormValues($producto_historial_grid->RowIndex); // Restore form values
			}
			if ($producto_historial_grid->RowAction == "insert")
				$producto_historial->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$producto_historial->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($producto_historial->CurrentAction == "gridedit" && ($producto_historial->RowType == EW_ROWTYPE_EDIT || $producto_historial->RowType == EW_ROWTYPE_ADD) && $producto_historial->EventCancelled) // Update failed
			$producto_historial_grid->RestoreCurrentRowFormValues($producto_historial_grid->RowIndex); // Restore form values
		if ($producto_historial->RowType == EW_ROWTYPE_EDIT) // Edit row
			$producto_historial_grid->EditRowCnt++;
		if ($producto_historial->CurrentAction == "F") // Confirm row
			$producto_historial_grid->RestoreCurrentRowFormValues($producto_historial_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$producto_historial->RowAttrs = array_merge($producto_historial->RowAttrs, array('data-rowindex'=>$producto_historial_grid->RowCnt, 'id'=>'r' . $producto_historial_grid->RowCnt . '_producto_historial', 'data-rowtype'=>$producto_historial->RowType));

		// Render row
		$producto_historial_grid->RenderRow();

		// Render list options
		$producto_historial_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($producto_historial_grid->RowAction <> "delete" && $producto_historial_grid->RowAction <> "insertdelete" && !($producto_historial_grid->RowAction == "insert" && $producto_historial->CurrentAction == "F" && $producto_historial_grid->EmptyRow())) {
?>
	<tr<?php echo $producto_historial->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_historial_grid->ListOptions->Render("body", "left", $producto_historial_grid->RowCnt);
?>
	<?php if ($producto_historial->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $producto_historial->idproducto->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idproducto" class="form-group producto_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto->EditValue)) {
	$arwrk = $producto_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idproducto->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_historial->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idproducto" class="form-group producto_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto->EditValue)) {
	$arwrk = $producto_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idproducto->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->idproducto->ViewAttributes() ?>>
<?php echo $producto_historial->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_historial->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_historial->idproducto->OldValue) ?>">
<?php } ?>
<a id="<?php echo $producto_historial_grid->PageObjName . "_row_" . $producto_historial_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idproducto_historial" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" value="<?php echo ew_HtmlEncode($producto_historial->idproducto_historial->CurrentValue) ?>">
<input type="hidden" data-field="x_idproducto_historial" name="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" id="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" value="<?php echo ew_HtmlEncode($producto_historial->idproducto_historial->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT || $producto_historial->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idproducto_historial" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto_historial" value="<?php echo ew_HtmlEncode($producto_historial->idproducto_historial->CurrentValue) ?>">
<?php } ?>
	<?php if ($producto_historial->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $producto_historial->idbodega->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idbodega" class="form-group producto_historial_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega"<?php echo $producto_historial->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idbodega->EditValue)) {
	$arwrk = $producto_historial->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idbodega->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_historial->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idbodega" class="form-group producto_historial_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega"<?php echo $producto_historial->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idbodega->EditValue)) {
	$arwrk = $producto_historial->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idbodega->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->idbodega->ViewAttributes() ?>>
<?php echo $producto_historial->idbodega->ListViewValue() ?></span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_historial->idbodega->FormValue) ?>">
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_historial->idbodega->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $producto_historial->fecha->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_fecha" class="form-group producto_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha->EditValue ?>"<?php echo $producto_historial->fecha->EditAttributes() ?>>
<?php if (!$producto_historial->fecha->ReadOnly && !$producto_historial->fecha->Disabled && @$producto_historial->fecha->EditAttrs["readonly"] == "" && @$producto_historial->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fproducto_historialgrid", "x<?php echo $producto_historial_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_historial->fecha->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_fecha" class="form-group producto_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha->EditValue ?>"<?php echo $producto_historial->fecha->EditAttributes() ?>>
<?php if (!$producto_historial->fecha->ReadOnly && !$producto_historial->fecha->Disabled && @$producto_historial->fecha->EditAttrs["readonly"] == "" && @$producto_historial->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fproducto_historialgrid", "x<?php echo $producto_historial_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->fecha->ViewAttributes() ?>>
<?php echo $producto_historial->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_historial->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_historial->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->unidades_ingreso->Visible) { // unidades_ingreso ?>
		<td data-name="unidades_ingreso"<?php echo $producto_historial->unidades_ingreso->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_unidades_ingreso" class="form-group producto_historial_unidades_ingreso">
<input type="text" data-field="x_unidades_ingreso" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_ingreso->EditValue ?>"<?php echo $producto_historial->unidades_ingreso->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_unidades_ingreso" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" value="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_unidades_ingreso" class="form-group producto_historial_unidades_ingreso">
<input type="text" data-field="x_unidades_ingreso" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_ingreso->EditValue ?>"<?php echo $producto_historial->unidades_ingreso->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->unidades_ingreso->ViewAttributes() ?>>
<?php echo $producto_historial->unidades_ingreso->ListViewValue() ?></span>
<input type="hidden" data-field="x_unidades_ingreso" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" value="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->FormValue) ?>">
<input type="hidden" data-field="x_unidades_ingreso" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" value="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->unidades_salida->Visible) { // unidades_salida ?>
		<td data-name="unidades_salida"<?php echo $producto_historial->unidades_salida->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_unidades_salida" class="form-group producto_historial_unidades_salida">
<input type="text" data-field="x_unidades_salida" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_salida->EditValue ?>"<?php echo $producto_historial->unidades_salida->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_unidades_salida" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" value="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_unidades_salida" class="form-group producto_historial_unidades_salida">
<input type="text" data-field="x_unidades_salida" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_salida->EditValue ?>"<?php echo $producto_historial->unidades_salida->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->unidades_salida->ViewAttributes() ?>>
<?php echo $producto_historial->unidades_salida->ListViewValue() ?></span>
<input type="hidden" data-field="x_unidades_salida" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" value="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->FormValue) ?>">
<input type="hidden" data-field="x_unidades_salida" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" value="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $producto_historial->fecha_insercion->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_fecha_insercion" class="form-group producto_historial_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha_insercion->EditValue ?>"<?php echo $producto_historial->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_fecha_insercion" class="form-group producto_historial_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha_insercion->EditValue ?>"<?php echo $producto_historial->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->fecha_insercion->ViewAttributes() ?>>
<?php echo $producto_historial->fecha_insercion->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->FormValue) ?>">
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->idrelacion->Visible) { // idrelacion ?>
		<td data-name="idrelacion"<?php echo $producto_historial->idrelacion->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idrelacion" class="form-group producto_historial_idrelacion">
<input type="text" data-field="x_idrelacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->idrelacion->PlaceHolder) ?>" value="<?php echo $producto_historial->idrelacion->EditValue ?>"<?php echo $producto_historial->idrelacion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_idrelacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" value="<?php echo ew_HtmlEncode($producto_historial->idrelacion->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_idrelacion" class="form-group producto_historial_idrelacion">
<input type="text" data-field="x_idrelacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->idrelacion->PlaceHolder) ?>" value="<?php echo $producto_historial->idrelacion->EditValue ?>"<?php echo $producto_historial->idrelacion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->idrelacion->ViewAttributes() ?>>
<?php echo $producto_historial->idrelacion->ListViewValue() ?></span>
<input type="hidden" data-field="x_idrelacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" value="<?php echo ew_HtmlEncode($producto_historial->idrelacion->FormValue) ?>">
<input type="hidden" data-field="x_idrelacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" value="<?php echo ew_HtmlEncode($producto_historial->idrelacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto_historial->tabla_relacion->Visible) { // tabla_relacion ?>
		<td data-name="tabla_relacion"<?php echo $producto_historial->tabla_relacion->CellAttributes() ?>>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_tabla_relacion" class="form-group producto_historial_tabla_relacion">
<input type="text" data-field="x_tabla_relacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->PlaceHolder) ?>" value="<?php echo $producto_historial->tabla_relacion->EditValue ?>"<?php echo $producto_historial->tabla_relacion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_tabla_relacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" value="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->OldValue) ?>">
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_historial_grid->RowCnt ?>_producto_historial_tabla_relacion" class="form-group producto_historial_tabla_relacion">
<input type="text" data-field="x_tabla_relacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->PlaceHolder) ?>" value="<?php echo $producto_historial->tabla_relacion->EditValue ?>"<?php echo $producto_historial->tabla_relacion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto_historial->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto_historial->tabla_relacion->ViewAttributes() ?>>
<?php echo $producto_historial->tabla_relacion->ListViewValue() ?></span>
<input type="hidden" data-field="x_tabla_relacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" value="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->FormValue) ?>">
<input type="hidden" data-field="x_tabla_relacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" value="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_historial_grid->ListOptions->Render("body", "right", $producto_historial_grid->RowCnt);
?>
	</tr>
<?php if ($producto_historial->RowType == EW_ROWTYPE_ADD || $producto_historial->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproducto_historialgrid.UpdateOpts(<?php echo $producto_historial_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($producto_historial->CurrentAction <> "gridadd" || $producto_historial->CurrentMode == "copy")
		if (!$producto_historial_grid->Recordset->EOF) $producto_historial_grid->Recordset->MoveNext();
}
?>
<?php
	if ($producto_historial->CurrentMode == "add" || $producto_historial->CurrentMode == "copy" || $producto_historial->CurrentMode == "edit") {
		$producto_historial_grid->RowIndex = '$rowindex$';
		$producto_historial_grid->LoadDefaultValues();

		// Set row properties
		$producto_historial->ResetAttrs();
		$producto_historial->RowAttrs = array_merge($producto_historial->RowAttrs, array('data-rowindex'=>$producto_historial_grid->RowIndex, 'id'=>'r0_producto_historial', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($producto_historial->RowAttrs["class"], "ewTemplate");
		$producto_historial->RowType = EW_ROWTYPE_ADD;

		// Render row
		$producto_historial_grid->RenderRow();

		// Render list options
		$producto_historial_grid->RenderListOptions();
		$producto_historial_grid->StartRowCnt = 0;
?>
	<tr<?php echo $producto_historial->RowAttributes() ?>>
<?php

// Render list options (body, left)
$producto_historial_grid->ListOptions->Render("body", "left", $producto_historial_grid->RowIndex);
?>
	<?php if ($producto_historial->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_idproducto" class="form-group producto_historial_idproducto">
<select data-field="x_idproducto" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto"<?php echo $producto_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto->EditValue)) {
	$arwrk = $producto_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idproducto->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_idproducto" class="form-group producto_historial_idproducto">
<span<?php echo $producto_historial->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="x<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_historial->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" id="o<?php echo $producto_historial_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($producto_historial->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->idbodega->Visible) { // idbodega ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_idbodega" class="form-group producto_historial_idbodega">
<select data-field="x_idbodega" id="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" name="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega"<?php echo $producto_historial->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idbodega->EditValue)) {
	$arwrk = $producto_historial->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto_historial->idbodega->OldValue = "";
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
 $producto_historial->Lookup_Selecting($producto_historial->idbodega, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="s_x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_idbodega" class="form-group producto_historial_idbodega">
<span<?php echo $producto_historial->idbodega->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->idbodega->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idbodega" name="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="x<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_historial->idbodega->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" id="o<?php echo $producto_historial_grid->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($producto_historial->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->fecha->Visible) { // fecha ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_fecha" class="form-group producto_historial_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha->EditValue ?>"<?php echo $producto_historial->fecha->EditAttributes() ?>>
<?php if (!$producto_historial->fecha->ReadOnly && !$producto_historial->fecha->Disabled && @$producto_historial->fecha->EditAttrs["readonly"] == "" && @$producto_historial->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fproducto_historialgrid", "x<?php echo $producto_historial_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_fecha" class="form-group producto_historial_fecha">
<span<?php echo $producto_historial->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_historial->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($producto_historial->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->unidades_ingreso->Visible) { // unidades_ingreso ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_unidades_ingreso" class="form-group producto_historial_unidades_ingreso">
<input type="text" data-field="x_unidades_ingreso" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_ingreso->EditValue ?>"<?php echo $producto_historial->unidades_ingreso->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_unidades_ingreso" class="form-group producto_historial_unidades_ingreso">
<span<?php echo $producto_historial->unidades_ingreso->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->unidades_ingreso->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_unidades_ingreso" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" value="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_unidades_ingreso" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_ingreso" value="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->unidades_salida->Visible) { // unidades_salida ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_unidades_salida" class="form-group producto_historial_unidades_salida">
<input type="text" data-field="x_unidades_salida" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_salida->EditValue ?>"<?php echo $producto_historial->unidades_salida->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_unidades_salida" class="form-group producto_historial_unidades_salida">
<span<?php echo $producto_historial->unidades_salida->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->unidades_salida->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_unidades_salida" name="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="x<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" value="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_unidades_salida" name="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" id="o<?php echo $producto_historial_grid->RowIndex ?>_unidades_salida" value="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->fecha_insercion->Visible) { // fecha_insercion ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_fecha_insercion" class="form-group producto_historial_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha_insercion->EditValue ?>"<?php echo $producto_historial->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_fecha_insercion" class="form-group producto_historial_fecha_insercion">
<span<?php echo $producto_historial->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_historial_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->idrelacion->Visible) { // idrelacion ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_idrelacion" class="form-group producto_historial_idrelacion">
<input type="text" data-field="x_idrelacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->idrelacion->PlaceHolder) ?>" value="<?php echo $producto_historial->idrelacion->EditValue ?>"<?php echo $producto_historial->idrelacion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_idrelacion" class="form-group producto_historial_idrelacion">
<span<?php echo $producto_historial->idrelacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->idrelacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idrelacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" value="<?php echo ew_HtmlEncode($producto_historial->idrelacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idrelacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_idrelacion" value="<?php echo ew_HtmlEncode($producto_historial->idrelacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto_historial->tabla_relacion->Visible) { // tabla_relacion ?>
		<td>
<?php if ($producto_historial->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_historial_tabla_relacion" class="form-group producto_historial_tabla_relacion">
<input type="text" data-field="x_tabla_relacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->PlaceHolder) ?>" value="<?php echo $producto_historial->tabla_relacion->EditValue ?>"<?php echo $producto_historial->tabla_relacion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_historial_tabla_relacion" class="form-group producto_historial_tabla_relacion">
<span<?php echo $producto_historial->tabla_relacion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto_historial->tabla_relacion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_tabla_relacion" name="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="x<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" value="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_tabla_relacion" name="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" id="o<?php echo $producto_historial_grid->RowIndex ?>_tabla_relacion" value="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$producto_historial_grid->ListOptions->Render("body", "right", $producto_historial_grid->RowCnt);
?>
<script type="text/javascript">
fproducto_historialgrid.UpdateOpts(<?php echo $producto_historial_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($producto_historial->CurrentMode == "add" || $producto_historial->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $producto_historial_grid->FormKeyCountName ?>" id="<?php echo $producto_historial_grid->FormKeyCountName ?>" value="<?php echo $producto_historial_grid->KeyCount ?>">
<?php echo $producto_historial_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_historial->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $producto_historial_grid->FormKeyCountName ?>" id="<?php echo $producto_historial_grid->FormKeyCountName ?>" value="<?php echo $producto_historial_grid->KeyCount ?>">
<?php echo $producto_historial_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($producto_historial->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproducto_historialgrid">
</div>
<?php

// Close recordset
if ($producto_historial_grid->Recordset)
	$producto_historial_grid->Recordset->Close();
?>
<?php if ($producto_historial_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($producto_historial_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($producto_historial_grid->TotalRecs == 0 && $producto_historial->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($producto_historial_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($producto_historial->Export == "") { ?>
<script type="text/javascript">
fproducto_historialgrid.Init();
</script>
<?php } ?>
<?php
$producto_historial_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$producto_historial_grid->Page_Terminate();
?>
