<?php

// Create page object
if (!isset($medicamento_grid)) $medicamento_grid = new cmedicamento_grid();

// Page init
$medicamento_grid->Page_Init();

// Page main
$medicamento_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$medicamento_grid->Page_Render();
?>
<?php if ($medicamento->Export == "") { ?>
<script type="text/javascript">

// Page object
var medicamento_grid = new ew_Page("medicamento_grid");
medicamento_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = medicamento_grid.PageID; // For backward compatibility

// Form object
var fmedicamentogrid = new ew_Form("fmedicamentogrid");
fmedicamentogrid.FormKeyCountName = '<?php echo $medicamento_grid->FormKeyCountName ?>';

// Validate form
fmedicamentogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $medicamento->nombre->FldCaption(), $medicamento->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $medicamento->idpais->FldCaption(), $medicamento->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmarca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $medicamento->idmarca->FldCaption(), $medicamento->idmarca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $medicamento->estado->FldCaption(), $medicamento->estado->ReqErrMsg)) ?>");

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
fmedicamentogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idmarca", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fmedicamentogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmedicamentogrid.ValidateRequired = true;
<?php } else { ?>
fmedicamentogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmedicamentogrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fmedicamentogrid.Lists["x_idmarca"] = {"LinkField":"x_idmarca","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($medicamento->CurrentAction == "gridadd") {
	if ($medicamento->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$medicamento_grid->TotalRecs = $medicamento->SelectRecordCount();
			$medicamento_grid->Recordset = $medicamento_grid->LoadRecordset($medicamento_grid->StartRec-1, $medicamento_grid->DisplayRecs);
		} else {
			if ($medicamento_grid->Recordset = $medicamento_grid->LoadRecordset())
				$medicamento_grid->TotalRecs = $medicamento_grid->Recordset->RecordCount();
		}
		$medicamento_grid->StartRec = 1;
		$medicamento_grid->DisplayRecs = $medicamento_grid->TotalRecs;
	} else {
		$medicamento->CurrentFilter = "0=1";
		$medicamento_grid->StartRec = 1;
		$medicamento_grid->DisplayRecs = $medicamento->GridAddRowCount;
	}
	$medicamento_grid->TotalRecs = $medicamento_grid->DisplayRecs;
	$medicamento_grid->StopRec = $medicamento_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$medicamento_grid->TotalRecs = $medicamento->SelectRecordCount();
	} else {
		if ($medicamento_grid->Recordset = $medicamento_grid->LoadRecordset())
			$medicamento_grid->TotalRecs = $medicamento_grid->Recordset->RecordCount();
	}
	$medicamento_grid->StartRec = 1;
	$medicamento_grid->DisplayRecs = $medicamento_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$medicamento_grid->Recordset = $medicamento_grid->LoadRecordset($medicamento_grid->StartRec-1, $medicamento_grid->DisplayRecs);

	// Set no record found message
	if ($medicamento->CurrentAction == "" && $medicamento_grid->TotalRecs == 0) {
		if ($medicamento_grid->SearchWhere == "0=101")
			$medicamento_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$medicamento_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$medicamento_grid->RenderOtherOptions();
?>
<?php $medicamento_grid->ShowPageHeader(); ?>
<?php
$medicamento_grid->ShowMessage();
?>
<?php if ($medicamento_grid->TotalRecs > 0 || $medicamento->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fmedicamentogrid" class="ewForm form-inline">
<div id="gmp_medicamento" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_medicamentogrid" class="table ewTable">
<?php echo $medicamento->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$medicamento_grid->RenderListOptions();

// Render list options (header, left)
$medicamento_grid->ListOptions->Render("header", "left");
?>
<?php if ($medicamento->nombre->Visible) { // nombre ?>
	<?php if ($medicamento->SortUrl($medicamento->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_medicamento_nombre" class="medicamento_nombre"><div class="ewTableHeaderCaption"><?php echo $medicamento->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_medicamento_nombre" class="medicamento_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $medicamento->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($medicamento->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($medicamento->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($medicamento->idpais->Visible) { // idpais ?>
	<?php if ($medicamento->SortUrl($medicamento->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_medicamento_idpais" class="medicamento_idpais"><div class="ewTableHeaderCaption"><?php echo $medicamento->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_medicamento_idpais" class="medicamento_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $medicamento->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($medicamento->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($medicamento->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($medicamento->idmarca->Visible) { // idmarca ?>
	<?php if ($medicamento->SortUrl($medicamento->idmarca) == "") { ?>
		<th data-name="idmarca"><div id="elh_medicamento_idmarca" class="medicamento_idmarca"><div class="ewTableHeaderCaption"><?php echo $medicamento->idmarca->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idmarca"><div><div id="elh_medicamento_idmarca" class="medicamento_idmarca">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $medicamento->idmarca->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($medicamento->idmarca->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($medicamento->idmarca->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($medicamento->estado->Visible) { // estado ?>
	<?php if ($medicamento->SortUrl($medicamento->estado) == "") { ?>
		<th data-name="estado"><div id="elh_medicamento_estado" class="medicamento_estado"><div class="ewTableHeaderCaption"><?php echo $medicamento->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_medicamento_estado" class="medicamento_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $medicamento->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($medicamento->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($medicamento->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$medicamento_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$medicamento_grid->StartRec = 1;
$medicamento_grid->StopRec = $medicamento_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($medicamento_grid->FormKeyCountName) && ($medicamento->CurrentAction == "gridadd" || $medicamento->CurrentAction == "gridedit" || $medicamento->CurrentAction == "F")) {
		$medicamento_grid->KeyCount = $objForm->GetValue($medicamento_grid->FormKeyCountName);
		$medicamento_grid->StopRec = $medicamento_grid->StartRec + $medicamento_grid->KeyCount - 1;
	}
}
$medicamento_grid->RecCnt = $medicamento_grid->StartRec - 1;
if ($medicamento_grid->Recordset && !$medicamento_grid->Recordset->EOF) {
	$medicamento_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $medicamento_grid->StartRec > 1)
		$medicamento_grid->Recordset->Move($medicamento_grid->StartRec - 1);
} elseif (!$medicamento->AllowAddDeleteRow && $medicamento_grid->StopRec == 0) {
	$medicamento_grid->StopRec = $medicamento->GridAddRowCount;
}

// Initialize aggregate
$medicamento->RowType = EW_ROWTYPE_AGGREGATEINIT;
$medicamento->ResetAttrs();
$medicamento_grid->RenderRow();
if ($medicamento->CurrentAction == "gridadd")
	$medicamento_grid->RowIndex = 0;
if ($medicamento->CurrentAction == "gridedit")
	$medicamento_grid->RowIndex = 0;
while ($medicamento_grid->RecCnt < $medicamento_grid->StopRec) {
	$medicamento_grid->RecCnt++;
	if (intval($medicamento_grid->RecCnt) >= intval($medicamento_grid->StartRec)) {
		$medicamento_grid->RowCnt++;
		if ($medicamento->CurrentAction == "gridadd" || $medicamento->CurrentAction == "gridedit" || $medicamento->CurrentAction == "F") {
			$medicamento_grid->RowIndex++;
			$objForm->Index = $medicamento_grid->RowIndex;
			if ($objForm->HasValue($medicamento_grid->FormActionName))
				$medicamento_grid->RowAction = strval($objForm->GetValue($medicamento_grid->FormActionName));
			elseif ($medicamento->CurrentAction == "gridadd")
				$medicamento_grid->RowAction = "insert";
			else
				$medicamento_grid->RowAction = "";
		}

		// Set up key count
		$medicamento_grid->KeyCount = $medicamento_grid->RowIndex;

		// Init row class and style
		$medicamento->ResetAttrs();
		$medicamento->CssClass = "";
		if ($medicamento->CurrentAction == "gridadd") {
			if ($medicamento->CurrentMode == "copy") {
				$medicamento_grid->LoadRowValues($medicamento_grid->Recordset); // Load row values
				$medicamento_grid->SetRecordKey($medicamento_grid->RowOldKey, $medicamento_grid->Recordset); // Set old record key
			} else {
				$medicamento_grid->LoadDefaultValues(); // Load default values
				$medicamento_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$medicamento_grid->LoadRowValues($medicamento_grid->Recordset); // Load row values
		}
		$medicamento->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($medicamento->CurrentAction == "gridadd") // Grid add
			$medicamento->RowType = EW_ROWTYPE_ADD; // Render add
		if ($medicamento->CurrentAction == "gridadd" && $medicamento->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$medicamento_grid->RestoreCurrentRowFormValues($medicamento_grid->RowIndex); // Restore form values
		if ($medicamento->CurrentAction == "gridedit") { // Grid edit
			if ($medicamento->EventCancelled) {
				$medicamento_grid->RestoreCurrentRowFormValues($medicamento_grid->RowIndex); // Restore form values
			}
			if ($medicamento_grid->RowAction == "insert")
				$medicamento->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$medicamento->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($medicamento->CurrentAction == "gridedit" && ($medicamento->RowType == EW_ROWTYPE_EDIT || $medicamento->RowType == EW_ROWTYPE_ADD) && $medicamento->EventCancelled) // Update failed
			$medicamento_grid->RestoreCurrentRowFormValues($medicamento_grid->RowIndex); // Restore form values
		if ($medicamento->RowType == EW_ROWTYPE_EDIT) // Edit row
			$medicamento_grid->EditRowCnt++;
		if ($medicamento->CurrentAction == "F") // Confirm row
			$medicamento_grid->RestoreCurrentRowFormValues($medicamento_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$medicamento->RowAttrs = array_merge($medicamento->RowAttrs, array('data-rowindex'=>$medicamento_grid->RowCnt, 'id'=>'r' . $medicamento_grid->RowCnt . '_medicamento', 'data-rowtype'=>$medicamento->RowType));

		// Render row
		$medicamento_grid->RenderRow();

		// Render list options
		$medicamento_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($medicamento_grid->RowAction <> "delete" && $medicamento_grid->RowAction <> "insertdelete" && !($medicamento_grid->RowAction == "insert" && $medicamento->CurrentAction == "F" && $medicamento_grid->EmptyRow())) {
?>
	<tr<?php echo $medicamento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$medicamento_grid->ListOptions->Render("body", "left", $medicamento_grid->RowCnt);
?>
	<?php if ($medicamento->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $medicamento->nombre->CellAttributes() ?>>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_nombre" class="form-group medicamento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $medicamento_grid->RowIndex ?>_nombre" id="x<?php echo $medicamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($medicamento->nombre->PlaceHolder) ?>" value="<?php echo $medicamento->nombre->EditValue ?>"<?php echo $medicamento->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $medicamento_grid->RowIndex ?>_nombre" id="o<?php echo $medicamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($medicamento->nombre->OldValue) ?>">
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_nombre" class="form-group medicamento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $medicamento_grid->RowIndex ?>_nombre" id="x<?php echo $medicamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($medicamento->nombre->PlaceHolder) ?>" value="<?php echo $medicamento->nombre->EditValue ?>"<?php echo $medicamento->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $medicamento->nombre->ViewAttributes() ?>>
<?php echo $medicamento->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $medicamento_grid->RowIndex ?>_nombre" id="x<?php echo $medicamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($medicamento->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $medicamento_grid->RowIndex ?>_nombre" id="o<?php echo $medicamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($medicamento->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $medicamento_grid->PageObjName . "_row_" . $medicamento_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idmedicamento" name="x<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" id="x<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" value="<?php echo ew_HtmlEncode($medicamento->idmedicamento->CurrentValue) ?>">
<input type="hidden" data-field="x_idmedicamento" name="o<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" id="o<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" value="<?php echo ew_HtmlEncode($medicamento->idmedicamento->OldValue) ?>">
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_EDIT || $medicamento->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idmedicamento" name="x<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" id="x<?php echo $medicamento_grid->RowIndex ?>_idmedicamento" value="<?php echo ew_HtmlEncode($medicamento->idmedicamento->CurrentValue) ?>">
<?php } ?>
	<?php if ($medicamento->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $medicamento->idpais->CellAttributes() ?>>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idpais" class="form-group medicamento_idpais">
<select data-field="x_idpais" id="x<?php echo $medicamento_grid->RowIndex ?>_idpais" name="x<?php echo $medicamento_grid->RowIndex ?>_idpais"<?php echo $medicamento->idpais->EditAttributes() ?>>
<?php
if (is_array($medicamento->idpais->EditValue)) {
	$arwrk = $medicamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idpais" name="o<?php echo $medicamento_grid->RowIndex ?>_idpais" id="o<?php echo $medicamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($medicamento->idpais->OldValue) ?>">
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idpais" class="form-group medicamento_idpais">
<select data-field="x_idpais" id="x<?php echo $medicamento_grid->RowIndex ?>_idpais" name="x<?php echo $medicamento_grid->RowIndex ?>_idpais"<?php echo $medicamento->idpais->EditAttributes() ?>>
<?php
if (is_array($medicamento->idpais->EditValue)) {
	$arwrk = $medicamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $medicamento->idpais->ViewAttributes() ?>>
<?php echo $medicamento->idpais->ListViewValue() ?></span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $medicamento_grid->RowIndex ?>_idpais" id="x<?php echo $medicamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($medicamento->idpais->FormValue) ?>">
<input type="hidden" data-field="x_idpais" name="o<?php echo $medicamento_grid->RowIndex ?>_idpais" id="o<?php echo $medicamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($medicamento->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($medicamento->idmarca->Visible) { // idmarca ?>
		<td data-name="idmarca"<?php echo $medicamento->idmarca->CellAttributes() ?>>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($medicamento->idmarca->getSessionValue() <> "") { ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idmarca" class="form-group medicamento_idmarca">
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idmarca" class="form-group medicamento_idmarca">
<select data-field="x_idmarca" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca"<?php echo $medicamento->idmarca->EditAttributes() ?>>
<?php
if (is_array($medicamento->idmarca->EditValue)) {
	$arwrk = $medicamento->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idmarca" name="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->OldValue) ?>">
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($medicamento->idmarca->getSessionValue() <> "") { ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idmarca" class="form-group medicamento_idmarca">
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_idmarca" class="form-group medicamento_idmarca">
<select data-field="x_idmarca" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca"<?php echo $medicamento->idmarca->EditAttributes() ?>>
<?php
if (is_array($medicamento->idmarca->EditValue)) {
	$arwrk = $medicamento->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<?php echo $medicamento->idmarca->ListViewValue() ?></span>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->FormValue) ?>">
<input type="hidden" data-field="x_idmarca" name="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($medicamento->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $medicamento->estado->CellAttributes() ?>>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_estado" class="form-group medicamento_estado">
<select data-field="x_estado" id="x<?php echo $medicamento_grid->RowIndex ?>_estado" name="x<?php echo $medicamento_grid->RowIndex ?>_estado"<?php echo $medicamento->estado->EditAttributes() ?>>
<?php
if (is_array($medicamento->estado->EditValue)) {
	$arwrk = $medicamento->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->estado->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $medicamento_grid->RowIndex ?>_estado" id="o<?php echo $medicamento_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($medicamento->estado->OldValue) ?>">
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $medicamento_grid->RowCnt ?>_medicamento_estado" class="form-group medicamento_estado">
<select data-field="x_estado" id="x<?php echo $medicamento_grid->RowIndex ?>_estado" name="x<?php echo $medicamento_grid->RowIndex ?>_estado"<?php echo $medicamento->estado->EditAttributes() ?>>
<?php
if (is_array($medicamento->estado->EditValue)) {
	$arwrk = $medicamento->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->estado->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($medicamento->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $medicamento->estado->ViewAttributes() ?>>
<?php echo $medicamento->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $medicamento_grid->RowIndex ?>_estado" id="x<?php echo $medicamento_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($medicamento->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $medicamento_grid->RowIndex ?>_estado" id="o<?php echo $medicamento_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($medicamento->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$medicamento_grid->ListOptions->Render("body", "right", $medicamento_grid->RowCnt);
?>
	</tr>
<?php if ($medicamento->RowType == EW_ROWTYPE_ADD || $medicamento->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmedicamentogrid.UpdateOpts(<?php echo $medicamento_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($medicamento->CurrentAction <> "gridadd" || $medicamento->CurrentMode == "copy")
		if (!$medicamento_grid->Recordset->EOF) $medicamento_grid->Recordset->MoveNext();
}
?>
<?php
	if ($medicamento->CurrentMode == "add" || $medicamento->CurrentMode == "copy" || $medicamento->CurrentMode == "edit") {
		$medicamento_grid->RowIndex = '$rowindex$';
		$medicamento_grid->LoadDefaultValues();

		// Set row properties
		$medicamento->ResetAttrs();
		$medicamento->RowAttrs = array_merge($medicamento->RowAttrs, array('data-rowindex'=>$medicamento_grid->RowIndex, 'id'=>'r0_medicamento', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($medicamento->RowAttrs["class"], "ewTemplate");
		$medicamento->RowType = EW_ROWTYPE_ADD;

		// Render row
		$medicamento_grid->RenderRow();

		// Render list options
		$medicamento_grid->RenderListOptions();
		$medicamento_grid->StartRowCnt = 0;
?>
	<tr<?php echo $medicamento->RowAttributes() ?>>
<?php

// Render list options (body, left)
$medicamento_grid->ListOptions->Render("body", "left", $medicamento_grid->RowIndex);
?>
	<?php if ($medicamento->nombre->Visible) { // nombre ?>
		<td>
<?php if ($medicamento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_medicamento_nombre" class="form-group medicamento_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $medicamento_grid->RowIndex ?>_nombre" id="x<?php echo $medicamento_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($medicamento->nombre->PlaceHolder) ?>" value="<?php echo $medicamento->nombre->EditValue ?>"<?php echo $medicamento->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_medicamento_nombre" class="form-group medicamento_nombre">
<span<?php echo $medicamento->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $medicamento_grid->RowIndex ?>_nombre" id="x<?php echo $medicamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($medicamento->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $medicamento_grid->RowIndex ?>_nombre" id="o<?php echo $medicamento_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($medicamento->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($medicamento->idpais->Visible) { // idpais ?>
		<td>
<?php if ($medicamento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_medicamento_idpais" class="form-group medicamento_idpais">
<select data-field="x_idpais" id="x<?php echo $medicamento_grid->RowIndex ?>_idpais" name="x<?php echo $medicamento_grid->RowIndex ?>_idpais"<?php echo $medicamento->idpais->EditAttributes() ?>>
<?php
if (is_array($medicamento->idpais->EditValue)) {
	$arwrk = $medicamento->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idpais->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idpais, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_medicamento_idpais" class="form-group medicamento_idpais">
<span<?php echo $medicamento->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idpais" name="x<?php echo $medicamento_grid->RowIndex ?>_idpais" id="x<?php echo $medicamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($medicamento->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idpais" name="o<?php echo $medicamento_grid->RowIndex ?>_idpais" id="o<?php echo $medicamento_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($medicamento->idpais->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($medicamento->idmarca->Visible) { // idmarca ?>
		<td>
<?php if ($medicamento->CurrentAction <> "F") { ?>
<?php if ($medicamento->idmarca->getSessionValue() <> "") { ?>
<span id="el$rowindex$_medicamento_idmarca" class="form-group medicamento_idmarca">
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_medicamento_idmarca" class="form-group medicamento_idmarca">
<select data-field="x_idmarca" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca"<?php echo $medicamento->idmarca->EditAttributes() ?>>
<?php
if (is_array($medicamento->idmarca->EditValue)) {
	$arwrk = $medicamento->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->idmarca->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $medicamento->Lookup_Selecting($medicamento->idmarca, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="s_x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_medicamento_idmarca" class="form-group medicamento_idmarca">
<span<?php echo $medicamento->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="x<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idmarca" name="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" id="o<?php echo $medicamento_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($medicamento->idmarca->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($medicamento->estado->Visible) { // estado ?>
		<td>
<?php if ($medicamento->CurrentAction <> "F") { ?>
<span id="el$rowindex$_medicamento_estado" class="form-group medicamento_estado">
<select data-field="x_estado" id="x<?php echo $medicamento_grid->RowIndex ?>_estado" name="x<?php echo $medicamento_grid->RowIndex ?>_estado"<?php echo $medicamento->estado->EditAttributes() ?>>
<?php
if (is_array($medicamento->estado->EditValue)) {
	$arwrk = $medicamento->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($medicamento->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $medicamento->estado->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_medicamento_estado" class="form-group medicamento_estado">
<span<?php echo $medicamento->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $medicamento->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $medicamento_grid->RowIndex ?>_estado" id="x<?php echo $medicamento_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($medicamento->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $medicamento_grid->RowIndex ?>_estado" id="o<?php echo $medicamento_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($medicamento->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$medicamento_grid->ListOptions->Render("body", "right", $medicamento_grid->RowCnt);
?>
<script type="text/javascript">
fmedicamentogrid.UpdateOpts(<?php echo $medicamento_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($medicamento->CurrentMode == "add" || $medicamento->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $medicamento_grid->FormKeyCountName ?>" id="<?php echo $medicamento_grid->FormKeyCountName ?>" value="<?php echo $medicamento_grid->KeyCount ?>">
<?php echo $medicamento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($medicamento->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $medicamento_grid->FormKeyCountName ?>" id="<?php echo $medicamento_grid->FormKeyCountName ?>" value="<?php echo $medicamento_grid->KeyCount ?>">
<?php echo $medicamento_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($medicamento->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmedicamentogrid">
</div>
<?php

// Close recordset
if ($medicamento_grid->Recordset)
	$medicamento_grid->Recordset->Close();
?>
<?php if ($medicamento_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($medicamento_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($medicamento_grid->TotalRecs == 0 && $medicamento->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($medicamento_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($medicamento->Export == "") { ?>
<script type="text/javascript">
fmedicamentogrid.Init();
</script>
<?php } ?>
<?php
$medicamento_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$medicamento_grid->Page_Terminate();
?>
