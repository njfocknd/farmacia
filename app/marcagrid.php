<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php

// Create page object
if (!isset($marca_grid)) $marca_grid = new cmarca_grid();

// Page init
$marca_grid->Page_Init();

// Page main
$marca_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$marca_grid->Page_Render();
?>
<?php if ($marca->Export == "") { ?>
<script type="text/javascript">

// Page object
var marca_grid = new ew_Page("marca_grid");
marca_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = marca_grid.PageID; // For backward compatibility

// Form object
var fmarcagrid = new ew_Form("fmarcagrid");
fmarcagrid.FormKeyCountName = '<?php echo $marca_grid->FormKeyCountName ?>';

// Validate form
fmarcagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $marca->nombre->FldCaption(), $marca->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idfabricante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $marca->idfabricante->FldCaption(), $marca->idfabricante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($marca->fecha_insercion->FldErrMsg()) ?>");

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
fmarcagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idfabricante", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	return true;
}

// Form_CustomValidate event
fmarcagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmarcagrid.ValidateRequired = true;
<?php } else { ?>
fmarcagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmarcagrid.Lists["x_idfabricante"] = {"LinkField":"x_idfabricante","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($marca->CurrentAction == "gridadd") {
	if ($marca->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$marca_grid->TotalRecs = $marca->SelectRecordCount();
			$marca_grid->Recordset = $marca_grid->LoadRecordset($marca_grid->StartRec-1, $marca_grid->DisplayRecs);
		} else {
			if ($marca_grid->Recordset = $marca_grid->LoadRecordset())
				$marca_grid->TotalRecs = $marca_grid->Recordset->RecordCount();
		}
		$marca_grid->StartRec = 1;
		$marca_grid->DisplayRecs = $marca_grid->TotalRecs;
	} else {
		$marca->CurrentFilter = "0=1";
		$marca_grid->StartRec = 1;
		$marca_grid->DisplayRecs = $marca->GridAddRowCount;
	}
	$marca_grid->TotalRecs = $marca_grid->DisplayRecs;
	$marca_grid->StopRec = $marca_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$marca_grid->TotalRecs = $marca->SelectRecordCount();
	} else {
		if ($marca_grid->Recordset = $marca_grid->LoadRecordset())
			$marca_grid->TotalRecs = $marca_grid->Recordset->RecordCount();
	}
	$marca_grid->StartRec = 1;
	$marca_grid->DisplayRecs = $marca_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$marca_grid->Recordset = $marca_grid->LoadRecordset($marca_grid->StartRec-1, $marca_grid->DisplayRecs);

	// Set no record found message
	if ($marca->CurrentAction == "" && $marca_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$marca_grid->setWarningMessage($Language->Phrase("NoPermission"));
		if ($marca_grid->SearchWhere == "0=101")
			$marca_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$marca_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$marca_grid->RenderOtherOptions();
?>
<?php $marca_grid->ShowPageHeader(); ?>
<?php
$marca_grid->ShowMessage();
?>
<?php if ($marca_grid->TotalRecs > 0 || $marca->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fmarcagrid" class="ewForm form-inline">
<div id="gmp_marca" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_marcagrid" class="table ewTable">
<?php echo $marca->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$marca_grid->RenderListOptions();

// Render list options (header, left)
$marca_grid->ListOptions->Render("header", "left");
?>
<?php if ($marca->nombre->Visible) { // nombre ?>
	<?php if ($marca->SortUrl($marca->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_marca_nombre" class="marca_nombre"><div class="ewTableHeaderCaption"><?php echo $marca->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_marca_nombre" class="marca_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $marca->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($marca->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($marca->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($marca->idfabricante->Visible) { // idfabricante ?>
	<?php if ($marca->SortUrl($marca->idfabricante) == "") { ?>
		<th data-name="idfabricante"><div id="elh_marca_idfabricante" class="marca_idfabricante"><div class="ewTableHeaderCaption"><?php echo $marca->idfabricante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idfabricante"><div><div id="elh_marca_idfabricante" class="marca_idfabricante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $marca->idfabricante->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($marca->idfabricante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($marca->idfabricante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($marca->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($marca->SortUrl($marca->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_marca_fecha_insercion" class="marca_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $marca->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_marca_fecha_insercion" class="marca_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $marca->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($marca->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($marca->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$marca_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$marca_grid->StartRec = 1;
$marca_grid->StopRec = $marca_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($marca_grid->FormKeyCountName) && ($marca->CurrentAction == "gridadd" || $marca->CurrentAction == "gridedit" || $marca->CurrentAction == "F")) {
		$marca_grid->KeyCount = $objForm->GetValue($marca_grid->FormKeyCountName);
		$marca_grid->StopRec = $marca_grid->StartRec + $marca_grid->KeyCount - 1;
	}
}
$marca_grid->RecCnt = $marca_grid->StartRec - 1;
if ($marca_grid->Recordset && !$marca_grid->Recordset->EOF) {
	$marca_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $marca_grid->StartRec > 1)
		$marca_grid->Recordset->Move($marca_grid->StartRec - 1);
} elseif (!$marca->AllowAddDeleteRow && $marca_grid->StopRec == 0) {
	$marca_grid->StopRec = $marca->GridAddRowCount;
}

// Initialize aggregate
$marca->RowType = EW_ROWTYPE_AGGREGATEINIT;
$marca->ResetAttrs();
$marca_grid->RenderRow();
if ($marca->CurrentAction == "gridadd")
	$marca_grid->RowIndex = 0;
if ($marca->CurrentAction == "gridedit")
	$marca_grid->RowIndex = 0;
while ($marca_grid->RecCnt < $marca_grid->StopRec) {
	$marca_grid->RecCnt++;
	if (intval($marca_grid->RecCnt) >= intval($marca_grid->StartRec)) {
		$marca_grid->RowCnt++;
		if ($marca->CurrentAction == "gridadd" || $marca->CurrentAction == "gridedit" || $marca->CurrentAction == "F") {
			$marca_grid->RowIndex++;
			$objForm->Index = $marca_grid->RowIndex;
			if ($objForm->HasValue($marca_grid->FormActionName))
				$marca_grid->RowAction = strval($objForm->GetValue($marca_grid->FormActionName));
			elseif ($marca->CurrentAction == "gridadd")
				$marca_grid->RowAction = "insert";
			else
				$marca_grid->RowAction = "";
		}

		// Set up key count
		$marca_grid->KeyCount = $marca_grid->RowIndex;

		// Init row class and style
		$marca->ResetAttrs();
		$marca->CssClass = "";
		if ($marca->CurrentAction == "gridadd") {
			if ($marca->CurrentMode == "copy") {
				$marca_grid->LoadRowValues($marca_grid->Recordset); // Load row values
				$marca_grid->SetRecordKey($marca_grid->RowOldKey, $marca_grid->Recordset); // Set old record key
			} else {
				$marca_grid->LoadDefaultValues(); // Load default values
				$marca_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$marca_grid->LoadRowValues($marca_grid->Recordset); // Load row values
		}
		$marca->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($marca->CurrentAction == "gridadd") // Grid add
			$marca->RowType = EW_ROWTYPE_ADD; // Render add
		if ($marca->CurrentAction == "gridadd" && $marca->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$marca_grid->RestoreCurrentRowFormValues($marca_grid->RowIndex); // Restore form values
		if ($marca->CurrentAction == "gridedit") { // Grid edit
			if ($marca->EventCancelled) {
				$marca_grid->RestoreCurrentRowFormValues($marca_grid->RowIndex); // Restore form values
			}
			if ($marca_grid->RowAction == "insert")
				$marca->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$marca->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($marca->CurrentAction == "gridedit" && ($marca->RowType == EW_ROWTYPE_EDIT || $marca->RowType == EW_ROWTYPE_ADD) && $marca->EventCancelled) // Update failed
			$marca_grid->RestoreCurrentRowFormValues($marca_grid->RowIndex); // Restore form values
		if ($marca->RowType == EW_ROWTYPE_EDIT) // Edit row
			$marca_grid->EditRowCnt++;
		if ($marca->CurrentAction == "F") // Confirm row
			$marca_grid->RestoreCurrentRowFormValues($marca_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$marca->RowAttrs = array_merge($marca->RowAttrs, array('data-rowindex'=>$marca_grid->RowCnt, 'id'=>'r' . $marca_grid->RowCnt . '_marca', 'data-rowtype'=>$marca->RowType));

		// Render row
		$marca_grid->RenderRow();

		// Render list options
		$marca_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($marca_grid->RowAction <> "delete" && $marca_grid->RowAction <> "insertdelete" && !($marca_grid->RowAction == "insert" && $marca->CurrentAction == "F" && $marca_grid->EmptyRow())) {
?>
	<tr<?php echo $marca->RowAttributes() ?>>
<?php

// Render list options (body, left)
$marca_grid->ListOptions->Render("body", "left", $marca_grid->RowCnt);
?>
	<?php if ($marca->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $marca->nombre->CellAttributes() ?>>
<?php if ($marca->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_nombre" class="form-group marca_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $marca_grid->RowIndex ?>_nombre" id="x<?php echo $marca_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($marca->nombre->PlaceHolder) ?>" value="<?php echo $marca->nombre->EditValue ?>"<?php echo $marca->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $marca_grid->RowIndex ?>_nombre" id="o<?php echo $marca_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($marca->nombre->OldValue) ?>">
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_nombre" class="form-group marca_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $marca_grid->RowIndex ?>_nombre" id="x<?php echo $marca_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($marca->nombre->PlaceHolder) ?>" value="<?php echo $marca->nombre->EditValue ?>"<?php echo $marca->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $marca->nombre->ViewAttributes() ?>>
<?php echo $marca->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $marca_grid->RowIndex ?>_nombre" id="x<?php echo $marca_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($marca->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $marca_grid->RowIndex ?>_nombre" id="o<?php echo $marca_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($marca->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $marca_grid->PageObjName . "_row_" . $marca_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $marca_grid->RowIndex ?>_idmarca" id="x<?php echo $marca_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($marca->idmarca->CurrentValue) ?>">
<input type="hidden" data-field="x_idmarca" name="o<?php echo $marca_grid->RowIndex ?>_idmarca" id="o<?php echo $marca_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($marca->idmarca->OldValue) ?>">
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_EDIT || $marca->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idmarca" name="x<?php echo $marca_grid->RowIndex ?>_idmarca" id="x<?php echo $marca_grid->RowIndex ?>_idmarca" value="<?php echo ew_HtmlEncode($marca->idmarca->CurrentValue) ?>">
<?php } ?>
	<?php if ($marca->idfabricante->Visible) { // idfabricante ?>
		<td data-name="idfabricante"<?php echo $marca->idfabricante->CellAttributes() ?>>
<?php if ($marca->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($marca->idfabricante->getSessionValue() <> "") { ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_idfabricante" class="form-group marca_idfabricante">
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->idfabricante->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_idfabricante" class="form-group marca_idfabricante">
<select data-field="x_idfabricante" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante"<?php echo $marca->idfabricante->EditAttributes() ?>>
<?php
if (is_array($marca->idfabricante->EditValue)) {
	$arwrk = $marca->idfabricante->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($marca->idfabricante->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $marca->idfabricante->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idfabricante`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `fabricante`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $marca->Lookup_Selecting($marca->idfabricante, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" id="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idfabricante` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idfabricante" name="o<?php echo $marca_grid->RowIndex ?>_idfabricante" id="o<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->OldValue) ?>">
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($marca->idfabricante->getSessionValue() <> "") { ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_idfabricante" class="form-group marca_idfabricante">
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->idfabricante->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_idfabricante" class="form-group marca_idfabricante">
<select data-field="x_idfabricante" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante"<?php echo $marca->idfabricante->EditAttributes() ?>>
<?php
if (is_array($marca->idfabricante->EditValue)) {
	$arwrk = $marca->idfabricante->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($marca->idfabricante->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $marca->idfabricante->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idfabricante`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `fabricante`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $marca->Lookup_Selecting($marca->idfabricante, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" id="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idfabricante` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<?php echo $marca->idfabricante->ListViewValue() ?></span>
<input type="hidden" data-field="x_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->FormValue) ?>">
<input type="hidden" data-field="x_idfabricante" name="o<?php echo $marca_grid->RowIndex ?>_idfabricante" id="o<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($marca->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $marca->fecha_insercion->CellAttributes() ?>>
<?php if ($marca->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_fecha_insercion" class="form-group marca_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($marca->fecha_insercion->PlaceHolder) ?>" value="<?php echo $marca->fecha_insercion->EditValue ?>"<?php echo $marca->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($marca->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $marca_grid->RowCnt ?>_marca_fecha_insercion" class="form-group marca_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($marca->fecha_insercion->PlaceHolder) ?>" value="<?php echo $marca->fecha_insercion->EditValue ?>"<?php echo $marca->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($marca->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $marca->fecha_insercion->ViewAttributes() ?>>
<?php echo $marca->fecha_insercion->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($marca->fecha_insercion->FormValue) ?>">
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($marca->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$marca_grid->ListOptions->Render("body", "right", $marca_grid->RowCnt);
?>
	</tr>
<?php if ($marca->RowType == EW_ROWTYPE_ADD || $marca->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmarcagrid.UpdateOpts(<?php echo $marca_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($marca->CurrentAction <> "gridadd" || $marca->CurrentMode == "copy")
		if (!$marca_grid->Recordset->EOF) $marca_grid->Recordset->MoveNext();
}
?>
<?php
	if ($marca->CurrentMode == "add" || $marca->CurrentMode == "copy" || $marca->CurrentMode == "edit") {
		$marca_grid->RowIndex = '$rowindex$';
		$marca_grid->LoadDefaultValues();

		// Set row properties
		$marca->ResetAttrs();
		$marca->RowAttrs = array_merge($marca->RowAttrs, array('data-rowindex'=>$marca_grid->RowIndex, 'id'=>'r0_marca', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($marca->RowAttrs["class"], "ewTemplate");
		$marca->RowType = EW_ROWTYPE_ADD;

		// Render row
		$marca_grid->RenderRow();

		// Render list options
		$marca_grid->RenderListOptions();
		$marca_grid->StartRowCnt = 0;
?>
	<tr<?php echo $marca->RowAttributes() ?>>
<?php

// Render list options (body, left)
$marca_grid->ListOptions->Render("body", "left", $marca_grid->RowIndex);
?>
	<?php if ($marca->nombre->Visible) { // nombre ?>
		<td>
<?php if ($marca->CurrentAction <> "F") { ?>
<span id="el$rowindex$_marca_nombre" class="form-group marca_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $marca_grid->RowIndex ?>_nombre" id="x<?php echo $marca_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($marca->nombre->PlaceHolder) ?>" value="<?php echo $marca->nombre->EditValue ?>"<?php echo $marca->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_marca_nombre" class="form-group marca_nombre">
<span<?php echo $marca->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $marca_grid->RowIndex ?>_nombre" id="x<?php echo $marca_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($marca->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $marca_grid->RowIndex ?>_nombre" id="o<?php echo $marca_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($marca->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($marca->idfabricante->Visible) { // idfabricante ?>
		<td>
<?php if ($marca->CurrentAction <> "F") { ?>
<?php if ($marca->idfabricante->getSessionValue() <> "") { ?>
<span id="el$rowindex$_marca_idfabricante" class="form-group marca_idfabricante">
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->idfabricante->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_marca_idfabricante" class="form-group marca_idfabricante">
<select data-field="x_idfabricante" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante"<?php echo $marca->idfabricante->EditAttributes() ?>>
<?php
if (is_array($marca->idfabricante->EditValue)) {
	$arwrk = $marca->idfabricante->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($marca->idfabricante->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $marca->idfabricante->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idfabricante`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `fabricante`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $marca->Lookup_Selecting($marca->idfabricante, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" id="s_x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idfabricante` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_marca_idfabricante" class="form-group marca_idfabricante">
<span<?php echo $marca->idfabricante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->idfabricante->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idfabricante" name="x<?php echo $marca_grid->RowIndex ?>_idfabricante" id="x<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idfabricante" name="o<?php echo $marca_grid->RowIndex ?>_idfabricante" id="o<?php echo $marca_grid->RowIndex ?>_idfabricante" value="<?php echo ew_HtmlEncode($marca->idfabricante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($marca->fecha_insercion->Visible) { // fecha_insercion ?>
		<td>
<?php if ($marca->CurrentAction <> "F") { ?>
<span id="el$rowindex$_marca_fecha_insercion" class="form-group marca_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($marca->fecha_insercion->PlaceHolder) ?>" value="<?php echo $marca->fecha_insercion->EditValue ?>"<?php echo $marca->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_marca_fecha_insercion" class="form-group marca_fecha_insercion">
<span<?php echo $marca->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $marca->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha_insercion" name="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $marca_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($marca->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha_insercion" name="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $marca_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($marca->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$marca_grid->ListOptions->Render("body", "right", $marca_grid->RowCnt);
?>
<script type="text/javascript">
fmarcagrid.UpdateOpts(<?php echo $marca_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($marca->CurrentMode == "add" || $marca->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $marca_grid->FormKeyCountName ?>" id="<?php echo $marca_grid->FormKeyCountName ?>" value="<?php echo $marca_grid->KeyCount ?>">
<?php echo $marca_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($marca->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $marca_grid->FormKeyCountName ?>" id="<?php echo $marca_grid->FormKeyCountName ?>" value="<?php echo $marca_grid->KeyCount ?>">
<?php echo $marca_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($marca->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmarcagrid">
</div>
<?php

// Close recordset
if ($marca_grid->Recordset)
	$marca_grid->Recordset->Close();
?>
<?php if ($marca_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($marca_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($marca_grid->TotalRecs == 0 && $marca->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($marca_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($marca->Export == "") { ?>
<script type="text/javascript">
fmarcagrid.Init();
</script>
<?php } ?>
<?php
$marca_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$marca_grid->Page_Terminate();
?>
