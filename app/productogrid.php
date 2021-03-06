<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
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
			elm = this.GetElements("x" + infix + "_codigo_barra");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->codigo_barra->FldCaption(), $producto->codigo_barra->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcategoria");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idcategoria->FldCaption(), $producto->idcategoria->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmarca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idmarca->FldCaption(), $producto->idmarca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->nombre->FldCaption(), $producto->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idpais->FldCaption(), $producto->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->existencia->FldCaption(), $producto->existencia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto->existencia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->estado->FldCaption(), $producto->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->precio_venta->FldCaption(), $producto->precio_venta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto->precio_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto->fecha_insercion->FldErrMsg()) ?>");

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
	if (ew_ValueChanged(fobj, infix, "codigo_barra", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcategoria", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idmarca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "existencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio_venta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "foto", false)) return false;
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
fproductogrid.Lists["x_idcategoria"] = {"LinkField":"x_idcategoria","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
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
		if (!$Security->CanList())
			$producto_grid->setWarningMessage($Language->Phrase("NoPermission"));
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
<?php if ($producto->codigo_barra->Visible) { // codigo_barra ?>
	<?php if ($producto->SortUrl($producto->codigo_barra) == "") { ?>
		<th data-name="codigo_barra"><div id="elh_producto_codigo_barra" class="producto_codigo_barra"><div class="ewTableHeaderCaption"><?php echo $producto->codigo_barra->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo_barra"><div><div id="elh_producto_codigo_barra" class="producto_codigo_barra">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->codigo_barra->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->codigo_barra->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->codigo_barra->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->idcategoria->Visible) { // idcategoria ?>
	<?php if ($producto->SortUrl($producto->idcategoria) == "") { ?>
		<th data-name="idcategoria"><div id="elh_producto_idcategoria" class="producto_idcategoria"><div class="ewTableHeaderCaption"><?php echo $producto->idcategoria->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcategoria"><div><div id="elh_producto_idcategoria" class="producto_idcategoria">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->idcategoria->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->idcategoria->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->idcategoria->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
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
<?php if ($producto->existencia->Visible) { // existencia ?>
	<?php if ($producto->SortUrl($producto->existencia) == "") { ?>
		<th data-name="existencia"><div id="elh_producto_existencia" class="producto_existencia"><div class="ewTableHeaderCaption"><?php echo $producto->existencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="existencia"><div><div id="elh_producto_existencia" class="producto_existencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->existencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->existencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->existencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
<?php if ($producto->precio_venta->Visible) { // precio_venta ?>
	<?php if ($producto->SortUrl($producto->precio_venta) == "") { ?>
		<th data-name="precio_venta"><div id="elh_producto_precio_venta" class="producto_precio_venta"><div class="ewTableHeaderCaption"><?php echo $producto->precio_venta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio_venta"><div><div id="elh_producto_precio_venta" class="producto_precio_venta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->precio_venta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->precio_venta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->precio_venta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($producto->SortUrl($producto->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_producto_fecha_insercion" class="producto_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $producto->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_producto_fecha_insercion" class="producto_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($producto->foto->Visible) { // foto ?>
	<?php if ($producto->SortUrl($producto->foto) == "") { ?>
		<th data-name="foto"><div id="elh_producto_foto" class="producto_foto"><div class="ewTableHeaderCaption"><?php echo $producto->foto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="foto"><div><div id="elh_producto_foto" class="producto_foto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $producto->foto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($producto->foto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($producto->foto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	<?php if ($producto->codigo_barra->Visible) { // codigo_barra ?>
		<td data-name="codigo_barra"<?php echo $producto->codigo_barra->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_codigo_barra" class="form-group producto_codigo_barra">
<input type="text" data-field="x_codigo_barra" name="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->codigo_barra->PlaceHolder) ?>" value="<?php echo $producto->codigo_barra->EditValue ?>"<?php echo $producto->codigo_barra->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_codigo_barra" name="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" value="<?php echo ew_HtmlEncode($producto->codigo_barra->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_codigo_barra" class="form-group producto_codigo_barra">
<input type="text" data-field="x_codigo_barra" name="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->codigo_barra->PlaceHolder) ?>" value="<?php echo $producto->codigo_barra->EditValue ?>"<?php echo $producto->codigo_barra->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->codigo_barra->ViewAttributes() ?>>
<?php echo $producto->codigo_barra->ListViewValue() ?></span>
<input type="hidden" data-field="x_codigo_barra" name="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" value="<?php echo ew_HtmlEncode($producto->codigo_barra->FormValue) ?>">
<input type="hidden" data-field="x_codigo_barra" name="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" value="<?php echo ew_HtmlEncode($producto->codigo_barra->OldValue) ?>">
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
	<?php if ($producto->idcategoria->Visible) { // idcategoria ?>
		<td data-name="idcategoria"<?php echo $producto->idcategoria->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($producto->idcategoria->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idcategoria" class="form-group producto_idcategoria">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idcategoria->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idcategoria" class="form-group producto_idcategoria">
<select data-field="x_idcategoria" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria"<?php echo $producto->idcategoria->EditAttributes() ?>>
<?php
if (is_array($producto->idcategoria->EditValue)) {
	$arwrk = $producto->idcategoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idcategoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idcategoria->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idcategoria, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" id="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcategoria` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcategoria" name="o<?php echo $producto_grid->RowIndex ?>_idcategoria" id="o<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($producto->idcategoria->getSessionValue() <> "") { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idcategoria" class="form-group producto_idcategoria">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idcategoria->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_idcategoria" class="form-group producto_idcategoria">
<select data-field="x_idcategoria" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria"<?php echo $producto->idcategoria->EditAttributes() ?>>
<?php
if (is_array($producto->idcategoria->EditValue)) {
	$arwrk = $producto->idcategoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idcategoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idcategoria->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idcategoria, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" id="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcategoria` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<?php echo $producto->idcategoria->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->FormValue) ?>">
<input type="hidden" data-field="x_idcategoria" name="o<?php echo $producto_grid->RowIndex ?>_idcategoria" id="o<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
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
</td>
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
	<?php if ($producto->existencia->Visible) { // existencia ?>
		<td data-name="existencia"<?php echo $producto->existencia->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_existencia" class="form-group producto_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_grid->RowIndex ?>_existencia" id="x<?php echo $producto_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto->existencia->PlaceHolder) ?>" value="<?php echo $producto->existencia->EditValue ?>"<?php echo $producto->existencia->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_grid->RowIndex ?>_existencia" id="o<?php echo $producto_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto->existencia->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_existencia" class="form-group producto_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_grid->RowIndex ?>_existencia" id="x<?php echo $producto_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto->existencia->PlaceHolder) ?>" value="<?php echo $producto->existencia->EditValue ?>"<?php echo $producto->existencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->existencia->ViewAttributes() ?>>
<?php echo $producto->existencia->ListViewValue() ?></span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_grid->RowIndex ?>_existencia" id="x<?php echo $producto_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto->existencia->FormValue) ?>">
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_grid->RowIndex ?>_existencia" id="o<?php echo $producto_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto->existencia->OldValue) ?>">
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
	<?php if ($producto->precio_venta->Visible) { // precio_venta ?>
		<td data-name="precio_venta"<?php echo $producto->precio_venta->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_precio_venta" class="form-group producto_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto->precio_venta->PlaceHolder) ?>" value="<?php echo $producto->precio_venta->EditValue ?>"<?php echo $producto->precio_venta->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto->precio_venta->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_precio_venta" class="form-group producto_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto->precio_venta->PlaceHolder) ?>" value="<?php echo $producto->precio_venta->EditValue ?>"<?php echo $producto->precio_venta->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->precio_venta->ViewAttributes() ?>>
<?php echo $producto->precio_venta->ListViewValue() ?></span>
<input type="hidden" data-field="x_precio_venta" name="x<?php echo $producto_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto->precio_venta->FormValue) ?>">
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto->precio_venta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $producto->fecha_insercion->CellAttributes() ?>>
<?php if ($producto->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_fecha_insercion" class="form-group producto_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto->fecha_insercion->EditValue ?>"<?php echo $producto->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_fecha_insercion" class="form-group producto_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto->fecha_insercion->EditValue ?>"<?php echo $producto->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $producto->fecha_insercion->ViewAttributes() ?>>
<?php echo $producto->fecha_insercion->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto->fecha_insercion->FormValue) ?>">
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($producto->foto->Visible) { // foto ?>
		<td data-name="foto"<?php echo $producto->foto->CellAttributes() ?>>
<?php if ($producto_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_producto_foto" class="form-group producto_foto">
<div id="fd_x<?php echo $producto_grid->RowIndex ?>_foto">
<span title="<?php echo $producto->foto->FldTitle() ? $producto->foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($producto->foto->ReadOnly || $producto->foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-field="x_foto" name="x<?php echo $producto_grid->RowIndex ?>_foto" id="x<?php echo $producto_grid->RowIndex ?>_foto">
</span>
<input type="hidden" name="fn_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fn_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fa_x<?php echo $producto_grid->RowIndex ?>_foto" value="0">
<input type="hidden" name="fs_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fs_x<?php echo $producto_grid->RowIndex ?>_foto" value="45">
<input type="hidden" name="fx_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fx_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fm_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $producto_grid->RowIndex ?>_foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-field="x_foto" name="o<?php echo $producto_grid->RowIndex ?>_foto" id="o<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo ew_HtmlEncode($producto->foto->OldValue) ?>">
<?php } elseif ($producto->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span>
<?php echo ew_GetFileViewTag($producto->foto, $producto->foto->ListViewValue()) ?>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $producto_grid->RowCnt ?>_producto_foto" class="form-group producto_foto">
<div id="fd_x<?php echo $producto_grid->RowIndex ?>_foto">
<span title="<?php echo $producto->foto->FldTitle() ? $producto->foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($producto->foto->ReadOnly || $producto->foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-field="x_foto" name="x<?php echo $producto_grid->RowIndex ?>_foto" id="x<?php echo $producto_grid->RowIndex ?>_foto">
</span>
<input type="hidden" name="fn_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fn_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $producto_grid->RowIndex ?>_foto"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fa_x<?php echo $producto_grid->RowIndex ?>_foto" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fa_x<?php echo $producto_grid->RowIndex ?>_foto" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fs_x<?php echo $producto_grid->RowIndex ?>_foto" value="45">
<input type="hidden" name="fx_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fx_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fm_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $producto_grid->RowIndex ?>_foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
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
	<?php if ($producto->codigo_barra->Visible) { // codigo_barra ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_codigo_barra" class="form-group producto_codigo_barra">
<input type="text" data-field="x_codigo_barra" name="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->codigo_barra->PlaceHolder) ?>" value="<?php echo $producto->codigo_barra->EditValue ?>"<?php echo $producto->codigo_barra->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_codigo_barra" class="form-group producto_codigo_barra">
<span<?php echo $producto->codigo_barra->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->codigo_barra->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_codigo_barra" name="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="x<?php echo $producto_grid->RowIndex ?>_codigo_barra" value="<?php echo ew_HtmlEncode($producto->codigo_barra->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_codigo_barra" name="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" id="o<?php echo $producto_grid->RowIndex ?>_codigo_barra" value="<?php echo ew_HtmlEncode($producto->codigo_barra->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->idcategoria->Visible) { // idcategoria ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<?php if ($producto->idcategoria->getSessionValue() <> "") { ?>
<span id="el$rowindex$_producto_idcategoria" class="form-group producto_idcategoria">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idcategoria->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_producto_idcategoria" class="form-group producto_idcategoria">
<select data-field="x_idcategoria" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria"<?php echo $producto->idcategoria->EditAttributes() ?>>
<?php
if (is_array($producto->idcategoria->EditValue)) {
	$arwrk = $producto->idcategoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idcategoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $producto->idcategoria->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $producto->Lookup_Selecting($producto->idcategoria, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" id="s_x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcategoria` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_producto_idcategoria" class="form-group producto_idcategoria">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idcategoria->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcategoria" name="x<?php echo $producto_grid->RowIndex ?>_idcategoria" id="x<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcategoria" name="o<?php echo $producto_grid->RowIndex ?>_idcategoria" id="o<?php echo $producto_grid->RowIndex ?>_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->OldValue) ?>">
</td>
	<?php } ?>
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
	<?php if ($producto->existencia->Visible) { // existencia ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_existencia" class="form-group producto_existencia">
<input type="text" data-field="x_existencia" name="x<?php echo $producto_grid->RowIndex ?>_existencia" id="x<?php echo $producto_grid->RowIndex ?>_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto->existencia->PlaceHolder) ?>" value="<?php echo $producto->existencia->EditValue ?>"<?php echo $producto->existencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_existencia" class="form-group producto_existencia">
<span<?php echo $producto->existencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->existencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_existencia" name="x<?php echo $producto_grid->RowIndex ?>_existencia" id="x<?php echo $producto_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto->existencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_existencia" name="o<?php echo $producto_grid->RowIndex ?>_existencia" id="o<?php echo $producto_grid->RowIndex ?>_existencia" value="<?php echo ew_HtmlEncode($producto->existencia->OldValue) ?>">
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
	<?php if ($producto->precio_venta->Visible) { // precio_venta ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_precio_venta" class="form-group producto_precio_venta">
<input type="text" data-field="x_precio_venta" name="x<?php echo $producto_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_grid->RowIndex ?>_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto->precio_venta->PlaceHolder) ?>" value="<?php echo $producto->precio_venta->EditValue ?>"<?php echo $producto->precio_venta->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_precio_venta" class="form-group producto_precio_venta">
<span<?php echo $producto->precio_venta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->precio_venta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_precio_venta" name="x<?php echo $producto_grid->RowIndex ?>_precio_venta" id="x<?php echo $producto_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto->precio_venta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_precio_venta" name="o<?php echo $producto_grid->RowIndex ?>_precio_venta" id="o<?php echo $producto_grid->RowIndex ?>_precio_venta" value="<?php echo ew_HtmlEncode($producto->precio_venta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->fecha_insercion->Visible) { // fecha_insercion ?>
		<td>
<?php if ($producto->CurrentAction <> "F") { ?>
<span id="el$rowindex$_producto_fecha_insercion" class="form-group producto_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto->fecha_insercion->EditValue ?>"<?php echo $producto->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_producto_fecha_insercion" class="form-group producto_fecha_insercion">
<span<?php echo $producto->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $producto_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $producto_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($producto->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($producto->foto->Visible) { // foto ?>
		<td>
<span id="el$rowindex$_producto_foto" class="form-group producto_foto">
<div id="fd_x<?php echo $producto_grid->RowIndex ?>_foto">
<span title="<?php echo $producto->foto->FldTitle() ? $producto->foto->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($producto->foto->ReadOnly || $producto->foto->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-field="x_foto" name="x<?php echo $producto_grid->RowIndex ?>_foto" id="x<?php echo $producto_grid->RowIndex ?>_foto">
</span>
<input type="hidden" name="fn_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fn_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fa_x<?php echo $producto_grid->RowIndex ?>_foto" value="0">
<input type="hidden" name="fs_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fs_x<?php echo $producto_grid->RowIndex ?>_foto" value="45">
<input type="hidden" name="fx_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fx_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $producto_grid->RowIndex ?>_foto" id= "fm_x<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo $producto->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $producto_grid->RowIndex ?>_foto" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-field="x_foto" name="o<?php echo $producto_grid->RowIndex ?>_foto" id="o<?php echo $producto_grid->RowIndex ?>_foto" value="<?php echo ew_HtmlEncode($producto->foto->OldValue) ?>">
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
