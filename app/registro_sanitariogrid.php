<?php

// Create page object
if (!isset($registro_sanitario_grid)) $registro_sanitario_grid = new cregistro_sanitario_grid();

// Page init
$registro_sanitario_grid->Page_Init();

// Page main
$registro_sanitario_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$registro_sanitario_grid->Page_Render();
?>
<?php if ($registro_sanitario->Export == "") { ?>
<script type="text/javascript">

// Page object
var registro_sanitario_grid = new ew_Page("registro_sanitario_grid");
registro_sanitario_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = registro_sanitario_grid.PageID; // For backward compatibility

// Form object
var fregistro_sanitariogrid = new ew_Form("fregistro_sanitariogrid");
fregistro_sanitariogrid.FormKeyCountName = '<?php echo $registro_sanitario_grid->FormKeyCountName ?>';

// Validate form
fregistro_sanitariogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_descripcion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $registro_sanitario->descripcion->FldCaption(), $registro_sanitario->descripcion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $registro_sanitario->idpais->FldCaption(), $registro_sanitario->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $registro_sanitario->idproducto->FldCaption(), $registro_sanitario->idproducto->ReqErrMsg)) ?>");

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
fregistro_sanitariogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "descripcion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	return true;
}

// Form_CustomValidate event
fregistro_sanitariogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fregistro_sanitariogrid.ValidateRequired = true;
<?php } else { ?>
fregistro_sanitariogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fregistro_sanitariogrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fregistro_sanitariogrid.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($registro_sanitario->CurrentAction == "gridadd") {
	if ($registro_sanitario->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$registro_sanitario_grid->TotalRecs = $registro_sanitario->SelectRecordCount();
			$registro_sanitario_grid->Recordset = $registro_sanitario_grid->LoadRecordset($registro_sanitario_grid->StartRec-1, $registro_sanitario_grid->DisplayRecs);
		} else {
			if ($registro_sanitario_grid->Recordset = $registro_sanitario_grid->LoadRecordset())
				$registro_sanitario_grid->TotalRecs = $registro_sanitario_grid->Recordset->RecordCount();
		}
		$registro_sanitario_grid->StartRec = 1;
		$registro_sanitario_grid->DisplayRecs = $registro_sanitario_grid->TotalRecs;
	} else {
		$registro_sanitario->CurrentFilter = "0=1";
		$registro_sanitario_grid->StartRec = 1;
		$registro_sanitario_grid->DisplayRecs = $registro_sanitario->GridAddRowCount;
	}
	$registro_sanitario_grid->TotalRecs = $registro_sanitario_grid->DisplayRecs;
	$registro_sanitario_grid->StopRec = $registro_sanitario_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$registro_sanitario_grid->TotalRecs = $registro_sanitario->SelectRecordCount();
	} else {
		if ($registro_sanitario_grid->Recordset = $registro_sanitario_grid->LoadRecordset())
			$registro_sanitario_grid->TotalRecs = $registro_sanitario_grid->Recordset->RecordCount();
	}
	$registro_sanitario_grid->StartRec = 1;
	$registro_sanitario_grid->DisplayRecs = $registro_sanitario_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$registro_sanitario_grid->Recordset = $registro_sanitario_grid->LoadRecordset($registro_sanitario_grid->StartRec-1, $registro_sanitario_grid->DisplayRecs);

	// Set no record found message
	if ($registro_sanitario->CurrentAction == "" && $registro_sanitario_grid->TotalRecs == 0) {
		if ($registro_sanitario_grid->SearchWhere == "0=101")
			$registro_sanitario_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$registro_sanitario_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$registro_sanitario_grid->RenderOtherOptions();
?>
<?php $registro_sanitario_grid->ShowPageHeader(); ?>
<?php
$registro_sanitario_grid->ShowMessage();
?>
<?php if ($registro_sanitario_grid->TotalRecs > 0 || $registro_sanitario->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fregistro_sanitariogrid" class="ewForm form-inline">
<div id="gmp_registro_sanitario" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_registro_sanitariogrid" class="table ewTable">
<?php echo $registro_sanitario->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$registro_sanitario_grid->RenderListOptions();

// Render list options (header, left)
$registro_sanitario_grid->ListOptions->Render("header", "left");
?>
<?php if ($registro_sanitario->descripcion->Visible) { // descripcion ?>
	<?php if ($registro_sanitario->SortUrl($registro_sanitario->descripcion) == "") { ?>
		<th data-name="descripcion"><div id="elh_registro_sanitario_descripcion" class="registro_sanitario_descripcion"><div class="ewTableHeaderCaption"><?php echo $registro_sanitario->descripcion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descripcion"><div><div id="elh_registro_sanitario_descripcion" class="registro_sanitario_descripcion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $registro_sanitario->descripcion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($registro_sanitario->descripcion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($registro_sanitario->descripcion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($registro_sanitario->idpais->Visible) { // idpais ?>
	<?php if ($registro_sanitario->SortUrl($registro_sanitario->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_registro_sanitario_idpais" class="registro_sanitario_idpais"><div class="ewTableHeaderCaption"><?php echo $registro_sanitario->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_registro_sanitario_idpais" class="registro_sanitario_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $registro_sanitario->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($registro_sanitario->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($registro_sanitario->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($registro_sanitario->idproducto->Visible) { // idproducto ?>
	<?php if ($registro_sanitario->SortUrl($registro_sanitario->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_registro_sanitario_idproducto" class="registro_sanitario_idproducto"><div class="ewTableHeaderCaption"><?php echo $registro_sanitario->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div><div id="elh_registro_sanitario_idproducto" class="registro_sanitario_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $registro_sanitario->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($registro_sanitario->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($registro_sanitario->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$registro_sanitario_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$registro_sanitario_grid->StartRec = 1;
$registro_sanitario_grid->StopRec = $registro_sanitario_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($registro_sanitario_grid->FormKeyCountName) && ($registro_sanitario->CurrentAction == "gridadd" || $registro_sanitario->CurrentAction == "gridedit" || $registro_sanitario->CurrentAction == "F")) {
		$registro_sanitario_grid->KeyCount = $objForm->GetValue($registro_sanitario_grid->FormKeyCountName);
		$registro_sanitario_grid->StopRec = $registro_sanitario_grid->StartRec + $registro_sanitario_grid->KeyCount - 1;
	}
}
$registro_sanitario_grid->RecCnt = $registro_sanitario_grid->StartRec - 1;
if ($registro_sanitario_grid->Recordset && !$registro_sanitario_grid->Recordset->EOF) {
	$registro_sanitario_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $registro_sanitario_grid->StartRec > 1)
		$registro_sanitario_grid->Recordset->Move($registro_sanitario_grid->StartRec - 1);
} elseif (!$registro_sanitario->AllowAddDeleteRow && $registro_sanitario_grid->StopRec == 0) {
	$registro_sanitario_grid->StopRec = $registro_sanitario->GridAddRowCount;
}

// Initialize aggregate
$registro_sanitario->RowType = EW_ROWTYPE_AGGREGATEINIT;
$registro_sanitario->ResetAttrs();
$registro_sanitario_grid->RenderRow();
if ($registro_sanitario->CurrentAction == "gridadd")
	$registro_sanitario_grid->RowIndex = 0;
if ($registro_sanitario->CurrentAction == "gridedit")
	$registro_sanitario_grid->RowIndex = 0;
while ($registro_sanitario_grid->RecCnt < $registro_sanitario_grid->StopRec) {
	$registro_sanitario_grid->RecCnt++;
	if (intval($registro_sanitario_grid->RecCnt) >= intval($registro_sanitario_grid->StartRec)) {
		$registro_sanitario_grid->RowCnt++;
		if ($registro_sanitario->CurrentAction == "gridadd" || $registro_sanitario->CurrentAction == "gridedit" || $registro_sanitario->CurrentAction == "F") {
			$registro_sanitario_grid->RowIndex++;
			$objForm->Index = $registro_sanitario_grid->RowIndex;
			if ($objForm->HasValue($registro_sanitario_grid->FormActionName))
				$registro_sanitario_grid->RowAction = strval($objForm->GetValue($registro_sanitario_grid->FormActionName));
			elseif ($registro_sanitario->CurrentAction == "gridadd")
				$registro_sanitario_grid->RowAction = "insert";
			else
				$registro_sanitario_grid->RowAction = "";
		}

		// Set up key count
		$registro_sanitario_grid->KeyCount = $registro_sanitario_grid->RowIndex;

		// Init row class and style
		$registro_sanitario->ResetAttrs();
		$registro_sanitario->CssClass = "";
		if ($registro_sanitario->CurrentAction == "gridadd") {
			if ($registro_sanitario->CurrentMode == "copy") {
				$registro_sanitario_grid->LoadRowValues($registro_sanitario_grid->Recordset); // Load row values
				$registro_sanitario_grid->SetRecordKey($registro_sanitario_grid->RowOldKey, $registro_sanitario_grid->Recordset); // Set old record key
			} else {
				$registro_sanitario_grid->LoadDefaultValues(); // Load default values
				$registro_sanitario_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$registro_sanitario_grid->LoadRowValues($registro_sanitario_grid->Recordset); // Load row values
		}
		$registro_sanitario->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($registro_sanitario->CurrentAction == "gridadd") // Grid add
			$registro_sanitario->RowType = EW_ROWTYPE_ADD; // Render add
		if ($registro_sanitario->CurrentAction == "gridadd" && $registro_sanitario->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$registro_sanitario_grid->RestoreCurrentRowFormValues($registro_sanitario_grid->RowIndex); // Restore form values
		if ($registro_sanitario->CurrentAction == "gridedit") { // Grid edit
			if ($registro_sanitario->EventCancelled) {
				$registro_sanitario_grid->RestoreCurrentRowFormValues($registro_sanitario_grid->RowIndex); // Restore form values
			}
			if ($registro_sanitario_grid->RowAction == "insert")
				$registro_sanitario->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$registro_sanitario->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($registro_sanitario->CurrentAction == "gridedit" && ($registro_sanitario->RowType == EW_ROWTYPE_EDIT || $registro_sanitario->RowType == EW_ROWTYPE_ADD) && $registro_sanitario->EventCancelled) // Update failed
			$registro_sanitario_grid->RestoreCurrentRowFormValues($registro_sanitario_grid->RowIndex); // Restore form values
		if ($registro_sanitario->RowType == EW_ROWTYPE_EDIT) // Edit row
			$registro_sanitario_grid->EditRowCnt++;
		if ($registro_sanitario->CurrentAction == "F") // Confirm row
			$registro_sanitario_grid->RestoreCurrentRowFormValues($registro_sanitario_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$registro_sanitario->RowAttrs = array_merge($registro_sanitario->RowAttrs, array('data-rowindex'=>$registro_sanitario_grid->RowCnt, 'id'=>'r' . $registro_sanitario_grid->RowCnt . '_registro_sanitario', 'data-rowtype'=>$registro_sanitario->RowType));

		// Render row
		$registro_sanitario_grid->RenderRow();

		// Render list options
		$registro_sanitario_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($registro_sanitario_grid->RowAction <> "delete" && $registro_sanitario_grid->RowAction <> "insertdelete" && !($registro_sanitario_grid->RowAction == "insert" && $registro_sanitario->CurrentAction == "F" && $registro_sanitario_grid->EmptyRow())) {
?>
	<tr<?php echo $registro_sanitario->RowAttributes() ?>>
<?php

// Render list options (body, left)
$registro_sanitario_grid->ListOptions->Render("body", "left", $registro_sanitario_grid->RowCnt);
?>
	<?php if ($registro_sanitario->descripcion->Visible) { // descripcion ?>
		<td data-name="descripcion"<?php echo $registro_sanitario->descripcion->CellAttributes() ?>>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_descripcion" class="form-group registro_sanitario_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->PlaceHolder) ?>" value="<?php echo $registro_sanitario->descripcion->EditValue ?>"<?php echo $registro_sanitario->descripcion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_descripcion" class="form-group registro_sanitario_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->PlaceHolder) ?>" value="<?php echo $registro_sanitario->descripcion->EditValue ?>"<?php echo $registro_sanitario->descripcion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $registro_sanitario->descripcion->ViewAttributes() ?>>
<?php echo $registro_sanitario->descripcion->ListViewValue() ?></span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->FormValue) ?>">
<input type="hidden" data-field="x_descripcion" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->OldValue) ?>">
<?php } ?>
<a id="<?php echo $registro_sanitario_grid->PageObjName . "_row_" . $registro_sanitario_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idregistro_sanitario" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" value="<?php echo ew_HtmlEncode($registro_sanitario->idregistro_sanitario->CurrentValue) ?>">
<input type="hidden" data-field="x_idregistro_sanitario" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" value="<?php echo ew_HtmlEncode($registro_sanitario->idregistro_sanitario->OldValue) ?>">
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_EDIT || $registro_sanitario->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idregistro_sanitario" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idregistro_sanitario" value="<?php echo ew_HtmlEncode($registro_sanitario->idregistro_sanitario->CurrentValue) ?>">
<?php } ?>
	<?php if ($registro_sanitario->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $registro_sanitario->idpais->CellAttributes() ?>>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idpais" class="form-group registro_sanitario_idpais">
<select data-field="x_idpais" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais"<?php echo $registro_sanitario->idpais->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idpais->EditValue)) {
	$arwrk = $registro_sanitario->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idpais->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idpais" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($registro_sanitario->idpais->OldValue) ?>">
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idpais" class="form-group registro_sanitario_idpais">
<select data-field="x_idpais" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais"<?php echo $registro_sanitario->idpais->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idpais->EditValue)) {
	$arwrk = $registro_sanitario->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idpais->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $registro_sanitario->idpais->ViewAttributes() ?>>
<?php echo $registro_sanitario->idpais->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($registro_sanitario->idpais->FormValue) ?>">
<input type="hidden" data-field="x_idpais" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($registro_sanitario->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($registro_sanitario->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $registro_sanitario->idproducto->CellAttributes() ?>>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($registro_sanitario->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<span<?php echo $registro_sanitario->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<select data-field="x_idproducto" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto"<?php echo $registro_sanitario->idproducto->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idproducto->EditValue)) {
	$arwrk = $registro_sanitario->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idproducto->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($registro_sanitario->idproducto->getSessionValue() <> "") { ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<span<?php echo $registro_sanitario->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $registro_sanitario_grid->RowCnt ?>_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<select data-field="x_idproducto" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto"<?php echo $registro_sanitario->idproducto->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idproducto->EditValue)) {
	$arwrk = $registro_sanitario->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idproducto->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $registro_sanitario->idproducto->ViewAttributes() ?>>
<?php echo $registro_sanitario->idproducto->ListViewValue() ?></span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->FormValue) ?>">
<input type="hidden" data-field="x_idproducto" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$registro_sanitario_grid->ListOptions->Render("body", "right", $registro_sanitario_grid->RowCnt);
?>
	</tr>
<?php if ($registro_sanitario->RowType == EW_ROWTYPE_ADD || $registro_sanitario->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fregistro_sanitariogrid.UpdateOpts(<?php echo $registro_sanitario_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($registro_sanitario->CurrentAction <> "gridadd" || $registro_sanitario->CurrentMode == "copy")
		if (!$registro_sanitario_grid->Recordset->EOF) $registro_sanitario_grid->Recordset->MoveNext();
}
?>
<?php
	if ($registro_sanitario->CurrentMode == "add" || $registro_sanitario->CurrentMode == "copy" || $registro_sanitario->CurrentMode == "edit") {
		$registro_sanitario_grid->RowIndex = '$rowindex$';
		$registro_sanitario_grid->LoadDefaultValues();

		// Set row properties
		$registro_sanitario->ResetAttrs();
		$registro_sanitario->RowAttrs = array_merge($registro_sanitario->RowAttrs, array('data-rowindex'=>$registro_sanitario_grid->RowIndex, 'id'=>'r0_registro_sanitario', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($registro_sanitario->RowAttrs["class"], "ewTemplate");
		$registro_sanitario->RowType = EW_ROWTYPE_ADD;

		// Render row
		$registro_sanitario_grid->RenderRow();

		// Render list options
		$registro_sanitario_grid->RenderListOptions();
		$registro_sanitario_grid->StartRowCnt = 0;
?>
	<tr<?php echo $registro_sanitario->RowAttributes() ?>>
<?php

// Render list options (body, left)
$registro_sanitario_grid->ListOptions->Render("body", "left", $registro_sanitario_grid->RowIndex);
?>
	<?php if ($registro_sanitario->descripcion->Visible) { // descripcion ?>
		<td>
<?php if ($registro_sanitario->CurrentAction <> "F") { ?>
<span id="el$rowindex$_registro_sanitario_descripcion" class="form-group registro_sanitario_descripcion">
<input type="text" data-field="x_descripcion" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->PlaceHolder) ?>" value="<?php echo $registro_sanitario->descripcion->EditValue ?>"<?php echo $registro_sanitario->descripcion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_registro_sanitario_descripcion" class="form-group registro_sanitario_descripcion">
<span<?php echo $registro_sanitario->descripcion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->descripcion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_descripcion" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_descripcion" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_descripcion" value="<?php echo ew_HtmlEncode($registro_sanitario->descripcion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($registro_sanitario->idpais->Visible) { // idpais ?>
		<td>
<?php if ($registro_sanitario->CurrentAction <> "F") { ?>
<span id="el$rowindex$_registro_sanitario_idpais" class="form-group registro_sanitario_idpais">
<select data-field="x_idpais" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais"<?php echo $registro_sanitario->idpais->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idpais->EditValue)) {
	$arwrk = $registro_sanitario->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idpais->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_registro_sanitario_idpais" class="form-group registro_sanitario_idpais">
<span<?php echo $registro_sanitario->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($registro_sanitario->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($registro_sanitario->idpais->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($registro_sanitario->idproducto->Visible) { // idproducto ?>
		<td>
<?php if ($registro_sanitario->CurrentAction <> "F") { ?>
<?php if ($registro_sanitario->idproducto->getSessionValue() <> "") { ?>
<span id="el$rowindex$_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<span<?php echo $registro_sanitario->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<select data-field="x_idproducto" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto"<?php echo $registro_sanitario->idproducto->EditAttributes() ?>>
<?php
if (is_array($registro_sanitario->idproducto->EditValue)) {
	$arwrk = $registro_sanitario->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($registro_sanitario->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $registro_sanitario->idproducto->OldValue = "";
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
 $registro_sanitario->Lookup_Selecting($registro_sanitario->idproducto, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="s_x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_registro_sanitario_idproducto" class="form-group registro_sanitario_idproducto">
<span<?php echo $registro_sanitario->idproducto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $registro_sanitario->idproducto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idproducto" name="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="x<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" id="o<?php echo $registro_sanitario_grid->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($registro_sanitario->idproducto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$registro_sanitario_grid->ListOptions->Render("body", "right", $registro_sanitario_grid->RowCnt);
?>
<script type="text/javascript">
fregistro_sanitariogrid.UpdateOpts(<?php echo $registro_sanitario_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($registro_sanitario->CurrentMode == "add" || $registro_sanitario->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $registro_sanitario_grid->FormKeyCountName ?>" id="<?php echo $registro_sanitario_grid->FormKeyCountName ?>" value="<?php echo $registro_sanitario_grid->KeyCount ?>">
<?php echo $registro_sanitario_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($registro_sanitario->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $registro_sanitario_grid->FormKeyCountName ?>" id="<?php echo $registro_sanitario_grid->FormKeyCountName ?>" value="<?php echo $registro_sanitario_grid->KeyCount ?>">
<?php echo $registro_sanitario_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($registro_sanitario->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fregistro_sanitariogrid">
</div>
<?php

// Close recordset
if ($registro_sanitario_grid->Recordset)
	$registro_sanitario_grid->Recordset->Close();
?>
<?php if ($registro_sanitario_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($registro_sanitario_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($registro_sanitario_grid->TotalRecs == 0 && $registro_sanitario->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($registro_sanitario_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($registro_sanitario->Export == "") { ?>
<script type="text/javascript">
fregistro_sanitariogrid.Init();
</script>
<?php } ?>
<?php
$registro_sanitario_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$registro_sanitario_grid->Page_Terminate();
?>
