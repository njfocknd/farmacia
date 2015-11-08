<?php

// Create page object
if (!isset($cliente_grid)) $cliente_grid = new ccliente_grid();

// Page init
$cliente_grid->Page_Init();

// Page main
$cliente_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cliente_grid->Page_Render();
?>
<?php if ($cliente->Export == "") { ?>
<script type="text/javascript">

// Page object
var cliente_grid = new ew_Page("cliente_grid");
cliente_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cliente_grid.PageID; // For backward compatibility

// Form object
var fclientegrid = new ew_Form("fclientegrid");
fclientegrid.FormKeyCountName = '<?php echo $cliente_grid->FormKeyCountName ?>';

// Validate form
fclientegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idpersona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cliente->idpersona->FldCaption(), $cliente->idpersona->ReqErrMsg)) ?>");

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
fclientegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idpersona", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre_factura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "direccion_factura", false)) return false;
	return true;
}

// Form_CustomValidate event
fclientegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fclientegrid.ValidateRequired = true;
<?php } else { ?>
fclientegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fclientegrid.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","x_apellido",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cliente->CurrentAction == "gridadd") {
	if ($cliente->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cliente_grid->TotalRecs = $cliente->SelectRecordCount();
			$cliente_grid->Recordset = $cliente_grid->LoadRecordset($cliente_grid->StartRec-1, $cliente_grid->DisplayRecs);
		} else {
			if ($cliente_grid->Recordset = $cliente_grid->LoadRecordset())
				$cliente_grid->TotalRecs = $cliente_grid->Recordset->RecordCount();
		}
		$cliente_grid->StartRec = 1;
		$cliente_grid->DisplayRecs = $cliente_grid->TotalRecs;
	} else {
		$cliente->CurrentFilter = "0=1";
		$cliente_grid->StartRec = 1;
		$cliente_grid->DisplayRecs = $cliente->GridAddRowCount;
	}
	$cliente_grid->TotalRecs = $cliente_grid->DisplayRecs;
	$cliente_grid->StopRec = $cliente_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cliente_grid->TotalRecs = $cliente->SelectRecordCount();
	} else {
		if ($cliente_grid->Recordset = $cliente_grid->LoadRecordset())
			$cliente_grid->TotalRecs = $cliente_grid->Recordset->RecordCount();
	}
	$cliente_grid->StartRec = 1;
	$cliente_grid->DisplayRecs = $cliente_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cliente_grid->Recordset = $cliente_grid->LoadRecordset($cliente_grid->StartRec-1, $cliente_grid->DisplayRecs);

	// Set no record found message
	if ($cliente->CurrentAction == "" && $cliente_grid->TotalRecs == 0) {
		if ($cliente_grid->SearchWhere == "0=101")
			$cliente_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cliente_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cliente_grid->RenderOtherOptions();
?>
<?php $cliente_grid->ShowPageHeader(); ?>
<?php
$cliente_grid->ShowMessage();
?>
<?php if ($cliente_grid->TotalRecs > 0 || $cliente->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fclientegrid" class="ewForm form-inline">
<div id="gmp_cliente" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_clientegrid" class="table ewTable">
<?php echo $cliente->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cliente_grid->RenderListOptions();

// Render list options (header, left)
$cliente_grid->ListOptions->Render("header", "left");
?>
<?php if ($cliente->idpersona->Visible) { // idpersona ?>
	<?php if ($cliente->SortUrl($cliente->idpersona) == "") { ?>
		<th data-name="idpersona"><div id="elh_cliente_idpersona" class="cliente_idpersona"><div class="ewTableHeaderCaption"><?php echo $cliente->idpersona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpersona"><div><div id="elh_cliente_idpersona" class="cliente_idpersona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cliente->idpersona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cliente->idpersona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cliente->idpersona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cliente->nit->Visible) { // nit ?>
	<?php if ($cliente->SortUrl($cliente->nit) == "") { ?>
		<th data-name="nit"><div id="elh_cliente_nit" class="cliente_nit"><div class="ewTableHeaderCaption"><?php echo $cliente->nit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nit"><div><div id="elh_cliente_nit" class="cliente_nit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cliente->nit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cliente->nit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cliente->nit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cliente->nombre_factura->Visible) { // nombre_factura ?>
	<?php if ($cliente->SortUrl($cliente->nombre_factura) == "") { ?>
		<th data-name="nombre_factura"><div id="elh_cliente_nombre_factura" class="cliente_nombre_factura"><div class="ewTableHeaderCaption"><?php echo $cliente->nombre_factura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre_factura"><div><div id="elh_cliente_nombre_factura" class="cliente_nombre_factura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cliente->nombre_factura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cliente->nombre_factura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cliente->nombre_factura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cliente->direccion_factura->Visible) { // direccion_factura ?>
	<?php if ($cliente->SortUrl($cliente->direccion_factura) == "") { ?>
		<th data-name="direccion_factura"><div id="elh_cliente_direccion_factura" class="cliente_direccion_factura"><div class="ewTableHeaderCaption"><?php echo $cliente->direccion_factura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion_factura"><div><div id="elh_cliente_direccion_factura" class="cliente_direccion_factura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cliente->direccion_factura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cliente->direccion_factura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cliente->direccion_factura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cliente_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cliente_grid->StartRec = 1;
$cliente_grid->StopRec = $cliente_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cliente_grid->FormKeyCountName) && ($cliente->CurrentAction == "gridadd" || $cliente->CurrentAction == "gridedit" || $cliente->CurrentAction == "F")) {
		$cliente_grid->KeyCount = $objForm->GetValue($cliente_grid->FormKeyCountName);
		$cliente_grid->StopRec = $cliente_grid->StartRec + $cliente_grid->KeyCount - 1;
	}
}
$cliente_grid->RecCnt = $cliente_grid->StartRec - 1;
if ($cliente_grid->Recordset && !$cliente_grid->Recordset->EOF) {
	$cliente_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $cliente_grid->StartRec > 1)
		$cliente_grid->Recordset->Move($cliente_grid->StartRec - 1);
} elseif (!$cliente->AllowAddDeleteRow && $cliente_grid->StopRec == 0) {
	$cliente_grid->StopRec = $cliente->GridAddRowCount;
}

// Initialize aggregate
$cliente->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cliente->ResetAttrs();
$cliente_grid->RenderRow();
if ($cliente->CurrentAction == "gridadd")
	$cliente_grid->RowIndex = 0;
if ($cliente->CurrentAction == "gridedit")
	$cliente_grid->RowIndex = 0;
while ($cliente_grid->RecCnt < $cliente_grid->StopRec) {
	$cliente_grid->RecCnt++;
	if (intval($cliente_grid->RecCnt) >= intval($cliente_grid->StartRec)) {
		$cliente_grid->RowCnt++;
		if ($cliente->CurrentAction == "gridadd" || $cliente->CurrentAction == "gridedit" || $cliente->CurrentAction == "F") {
			$cliente_grid->RowIndex++;
			$objForm->Index = $cliente_grid->RowIndex;
			if ($objForm->HasValue($cliente_grid->FormActionName))
				$cliente_grid->RowAction = strval($objForm->GetValue($cliente_grid->FormActionName));
			elseif ($cliente->CurrentAction == "gridadd")
				$cliente_grid->RowAction = "insert";
			else
				$cliente_grid->RowAction = "";
		}

		// Set up key count
		$cliente_grid->KeyCount = $cliente_grid->RowIndex;

		// Init row class and style
		$cliente->ResetAttrs();
		$cliente->CssClass = "";
		if ($cliente->CurrentAction == "gridadd") {
			if ($cliente->CurrentMode == "copy") {
				$cliente_grid->LoadRowValues($cliente_grid->Recordset); // Load row values
				$cliente_grid->SetRecordKey($cliente_grid->RowOldKey, $cliente_grid->Recordset); // Set old record key
			} else {
				$cliente_grid->LoadDefaultValues(); // Load default values
				$cliente_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cliente_grid->LoadRowValues($cliente_grid->Recordset); // Load row values
		}
		$cliente->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cliente->CurrentAction == "gridadd") // Grid add
			$cliente->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cliente->CurrentAction == "gridadd" && $cliente->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cliente_grid->RestoreCurrentRowFormValues($cliente_grid->RowIndex); // Restore form values
		if ($cliente->CurrentAction == "gridedit") { // Grid edit
			if ($cliente->EventCancelled) {
				$cliente_grid->RestoreCurrentRowFormValues($cliente_grid->RowIndex); // Restore form values
			}
			if ($cliente_grid->RowAction == "insert")
				$cliente->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cliente->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cliente->CurrentAction == "gridedit" && ($cliente->RowType == EW_ROWTYPE_EDIT || $cliente->RowType == EW_ROWTYPE_ADD) && $cliente->EventCancelled) // Update failed
			$cliente_grid->RestoreCurrentRowFormValues($cliente_grid->RowIndex); // Restore form values
		if ($cliente->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cliente_grid->EditRowCnt++;
		if ($cliente->CurrentAction == "F") // Confirm row
			$cliente_grid->RestoreCurrentRowFormValues($cliente_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cliente->RowAttrs = array_merge($cliente->RowAttrs, array('data-rowindex'=>$cliente_grid->RowCnt, 'id'=>'r' . $cliente_grid->RowCnt . '_cliente', 'data-rowtype'=>$cliente->RowType));

		// Render row
		$cliente_grid->RenderRow();

		// Render list options
		$cliente_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cliente_grid->RowAction <> "delete" && $cliente_grid->RowAction <> "insertdelete" && !($cliente_grid->RowAction == "insert" && $cliente->CurrentAction == "F" && $cliente_grid->EmptyRow())) {
?>
	<tr<?php echo $cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cliente_grid->ListOptions->Render("body", "left", $cliente_grid->RowCnt);
?>
	<?php if ($cliente->idpersona->Visible) { // idpersona ?>
		<td data-name="idpersona"<?php echo $cliente->idpersona->CellAttributes() ?>>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cliente->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_idpersona" class="form-group cliente_idpersona">
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_idpersona" class="form-group cliente_idpersona">
<select data-field="x_idpersona" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona"<?php echo $cliente->idpersona->EditAttributes() ?>>
<?php
if (is_array($cliente->idpersona->EditValue)) {
	$arwrk = $cliente->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cliente->idpersona->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cliente->idpersona->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, `apellido` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cliente->Lookup_Selecting($cliente->idpersona, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" id="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpersona` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idpersona" name="o<?php echo $cliente_grid->RowIndex ?>_idpersona" id="o<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->OldValue) ?>">
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cliente->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_idpersona" class="form-group cliente_idpersona">
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_idpersona" class="form-group cliente_idpersona">
<select data-field="x_idpersona" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona"<?php echo $cliente->idpersona->EditAttributes() ?>>
<?php
if (is_array($cliente->idpersona->EditValue)) {
	$arwrk = $cliente->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cliente->idpersona->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cliente->idpersona->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, `apellido` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cliente->Lookup_Selecting($cliente->idpersona, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" id="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpersona` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<?php echo $cliente->idpersona->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->FormValue) ?>">
<input type="hidden" data-field="x_idpersona" name="o<?php echo $cliente_grid->RowIndex ?>_idpersona" id="o<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cliente_grid->PageObjName . "_row_" . $cliente_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $cliente_grid->RowIndex ?>_idcliente" id="x<?php echo $cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($cliente->idcliente->CurrentValue) ?>">
<input type="hidden" data-field="x_idcliente" name="o<?php echo $cliente_grid->RowIndex ?>_idcliente" id="o<?php echo $cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($cliente->idcliente->OldValue) ?>">
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_EDIT || $cliente->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcliente" name="x<?php echo $cliente_grid->RowIndex ?>_idcliente" id="x<?php echo $cliente_grid->RowIndex ?>_idcliente" value="<?php echo ew_HtmlEncode($cliente->idcliente->CurrentValue) ?>">
<?php } ?>
	<?php if ($cliente->nit->Visible) { // nit ?>
		<td data-name="nit"<?php echo $cliente->nit->CellAttributes() ?>>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_nit" class="form-group cliente_nit">
<input type="text" data-field="x_nit" name="x<?php echo $cliente_grid->RowIndex ?>_nit" id="x<?php echo $cliente_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nit->PlaceHolder) ?>" value="<?php echo $cliente->nit->EditValue ?>"<?php echo $cliente->nit->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nit" name="o<?php echo $cliente_grid->RowIndex ?>_nit" id="o<?php echo $cliente_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($cliente->nit->OldValue) ?>">
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_nit" class="form-group cliente_nit">
<input type="text" data-field="x_nit" name="x<?php echo $cliente_grid->RowIndex ?>_nit" id="x<?php echo $cliente_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nit->PlaceHolder) ?>" value="<?php echo $cliente->nit->EditValue ?>"<?php echo $cliente->nit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cliente->nit->ViewAttributes() ?>>
<?php echo $cliente->nit->ListViewValue() ?></span>
<input type="hidden" data-field="x_nit" name="x<?php echo $cliente_grid->RowIndex ?>_nit" id="x<?php echo $cliente_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($cliente->nit->FormValue) ?>">
<input type="hidden" data-field="x_nit" name="o<?php echo $cliente_grid->RowIndex ?>_nit" id="o<?php echo $cliente_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($cliente->nit->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cliente->nombre_factura->Visible) { // nombre_factura ?>
		<td data-name="nombre_factura"<?php echo $cliente->nombre_factura->CellAttributes() ?>>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_nombre_factura" class="form-group cliente_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nombre_factura->PlaceHolder) ?>" value="<?php echo $cliente->nombre_factura->EditValue ?>"<?php echo $cliente->nombre_factura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($cliente->nombre_factura->OldValue) ?>">
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_nombre_factura" class="form-group cliente_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nombre_factura->PlaceHolder) ?>" value="<?php echo $cliente->nombre_factura->EditValue ?>"<?php echo $cliente->nombre_factura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cliente->nombre_factura->ViewAttributes() ?>>
<?php echo $cliente->nombre_factura->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre_factura" name="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($cliente->nombre_factura->FormValue) ?>">
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($cliente->nombre_factura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cliente->direccion_factura->Visible) { // direccion_factura ?>
		<td data-name="direccion_factura"<?php echo $cliente->direccion_factura->CellAttributes() ?>>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_direccion_factura" class="form-group cliente_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->direccion_factura->PlaceHolder) ?>" value="<?php echo $cliente->direccion_factura->EditValue ?>"<?php echo $cliente->direccion_factura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($cliente->direccion_factura->OldValue) ?>">
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cliente_grid->RowCnt ?>_cliente_direccion_factura" class="form-group cliente_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->direccion_factura->PlaceHolder) ?>" value="<?php echo $cliente->direccion_factura->EditValue ?>"<?php echo $cliente->direccion_factura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cliente->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cliente->direccion_factura->ViewAttributes() ?>>
<?php echo $cliente->direccion_factura->ListViewValue() ?></span>
<input type="hidden" data-field="x_direccion_factura" name="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($cliente->direccion_factura->FormValue) ?>">
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($cliente->direccion_factura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cliente_grid->ListOptions->Render("body", "right", $cliente_grid->RowCnt);
?>
	</tr>
<?php if ($cliente->RowType == EW_ROWTYPE_ADD || $cliente->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fclientegrid.UpdateOpts(<?php echo $cliente_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cliente->CurrentAction <> "gridadd" || $cliente->CurrentMode == "copy")
		if (!$cliente_grid->Recordset->EOF) $cliente_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cliente->CurrentMode == "add" || $cliente->CurrentMode == "copy" || $cliente->CurrentMode == "edit") {
		$cliente_grid->RowIndex = '$rowindex$';
		$cliente_grid->LoadDefaultValues();

		// Set row properties
		$cliente->ResetAttrs();
		$cliente->RowAttrs = array_merge($cliente->RowAttrs, array('data-rowindex'=>$cliente_grid->RowIndex, 'id'=>'r0_cliente', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cliente->RowAttrs["class"], "ewTemplate");
		$cliente->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cliente_grid->RenderRow();

		// Render list options
		$cliente_grid->RenderListOptions();
		$cliente_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cliente_grid->ListOptions->Render("body", "left", $cliente_grid->RowIndex);
?>
	<?php if ($cliente->idpersona->Visible) { // idpersona ?>
		<td>
<?php if ($cliente->CurrentAction <> "F") { ?>
<?php if ($cliente->idpersona->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cliente_idpersona" class="form-group cliente_idpersona">
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cliente_idpersona" class="form-group cliente_idpersona">
<select data-field="x_idpersona" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona"<?php echo $cliente->idpersona->EditAttributes() ?>>
<?php
if (is_array($cliente->idpersona->EditValue)) {
	$arwrk = $cliente->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cliente->idpersona->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cliente->idpersona->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, `apellido` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $cliente->Lookup_Selecting($cliente->idpersona, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" id="s_x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpersona` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cliente_idpersona" class="form-group cliente_idpersona">
<span<?php echo $cliente->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpersona" name="x<?php echo $cliente_grid->RowIndex ?>_idpersona" id="x<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpersona" name="o<?php echo $cliente_grid->RowIndex ?>_idpersona" id="o<?php echo $cliente_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($cliente->idpersona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cliente->nit->Visible) { // nit ?>
		<td>
<?php if ($cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cliente_nit" class="form-group cliente_nit">
<input type="text" data-field="x_nit" name="x<?php echo $cliente_grid->RowIndex ?>_nit" id="x<?php echo $cliente_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nit->PlaceHolder) ?>" value="<?php echo $cliente->nit->EditValue ?>"<?php echo $cliente->nit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cliente_nit" class="form-group cliente_nit">
<span<?php echo $cliente->nit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->nit->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nit" name="x<?php echo $cliente_grid->RowIndex ?>_nit" id="x<?php echo $cliente_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($cliente->nit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nit" name="o<?php echo $cliente_grid->RowIndex ?>_nit" id="o<?php echo $cliente_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($cliente->nit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cliente->nombre_factura->Visible) { // nombre_factura ?>
		<td>
<?php if ($cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cliente_nombre_factura" class="form-group cliente_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->nombre_factura->PlaceHolder) ?>" value="<?php echo $cliente->nombre_factura->EditValue ?>"<?php echo $cliente->nombre_factura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cliente_nombre_factura" class="form-group cliente_nombre_factura">
<span<?php echo $cliente->nombre_factura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->nombre_factura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre_factura" name="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="x<?php echo $cliente_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($cliente->nombre_factura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre_factura" name="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" id="o<?php echo $cliente_grid->RowIndex ?>_nombre_factura" value="<?php echo ew_HtmlEncode($cliente->nombre_factura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cliente->direccion_factura->Visible) { // direccion_factura ?>
		<td>
<?php if ($cliente->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cliente_direccion_factura" class="form-group cliente_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cliente->direccion_factura->PlaceHolder) ?>" value="<?php echo $cliente->direccion_factura->EditValue ?>"<?php echo $cliente->direccion_factura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cliente_direccion_factura" class="form-group cliente_direccion_factura">
<span<?php echo $cliente->direccion_factura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cliente->direccion_factura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_direccion_factura" name="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="x<?php echo $cliente_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($cliente->direccion_factura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_direccion_factura" name="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" id="o<?php echo $cliente_grid->RowIndex ?>_direccion_factura" value="<?php echo ew_HtmlEncode($cliente->direccion_factura->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cliente_grid->ListOptions->Render("body", "right", $cliente_grid->RowCnt);
?>
<script type="text/javascript">
fclientegrid.UpdateOpts(<?php echo $cliente_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cliente->CurrentMode == "add" || $cliente->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cliente_grid->FormKeyCountName ?>" id="<?php echo $cliente_grid->FormKeyCountName ?>" value="<?php echo $cliente_grid->KeyCount ?>">
<?php echo $cliente_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cliente->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cliente_grid->FormKeyCountName ?>" id="<?php echo $cliente_grid->FormKeyCountName ?>" value="<?php echo $cliente_grid->KeyCount ?>">
<?php echo $cliente_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cliente->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fclientegrid">
</div>
<?php

// Close recordset
if ($cliente_grid->Recordset)
	$cliente_grid->Recordset->Close();
?>
<?php if ($cliente_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($cliente_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cliente_grid->TotalRecs == 0 && $cliente->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cliente_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cliente->Export == "") { ?>
<script type="text/javascript">
fclientegrid.Init();
</script>
<?php } ?>
<?php
$cliente_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cliente_grid->Page_Terminate();
?>
