<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_bodegainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$producto_bodega_edit = NULL; // Initialize page object first

class cproducto_bodega_edit extends cproducto_bodega {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'producto_bodega';

	// Page object name
	var $PageObjName = 'producto_bodega_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (producto_bodega)
		if (!isset($GLOBALS["producto_bodega"]) || get_class($GLOBALS["producto_bodega"]) == "cproducto_bodega") {
			$GLOBALS["producto_bodega"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["producto_bodega"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'producto_bodega', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $producto_bodega;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($producto_bodega);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["idproducto_bodega"] <> "") {
			$this->idproducto_bodega->setQueryStringValue($_GET["idproducto_bodega"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->idproducto_bodega->CurrentValue == "")
			$this->Page_Terminate("producto_bodegalist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("producto_bodegalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idproducto->FldIsDetailKey) {
			$this->idproducto->setFormValue($objForm->GetValue("x_idproducto"));
		}
		if (!$this->idbodega->FldIsDetailKey) {
			$this->idbodega->setFormValue($objForm->GetValue("x_idbodega"));
		}
		if (!$this->existencia->FldIsDetailKey) {
			$this->existencia->setFormValue($objForm->GetValue("x_existencia"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idproducto_sucursal->FldIsDetailKey) {
			$this->idproducto_sucursal->setFormValue($objForm->GetValue("x_idproducto_sucursal"));
		}
		if (!$this->idproducto_bodega->FldIsDetailKey)
			$this->idproducto_bodega->setFormValue($objForm->GetValue("x_idproducto_bodega"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idproducto_bodega->CurrentValue = $this->idproducto_bodega->FormValue;
		$this->idproducto->CurrentValue = $this->idproducto->FormValue;
		$this->idbodega->CurrentValue = $this->idbodega->FormValue;
		$this->existencia->CurrentValue = $this->existencia->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->idproducto_sucursal->CurrentValue = $this->idproducto_sucursal->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->idproducto_bodega->setDbValue($rs->fields('idproducto_bodega'));
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idbodega->setDbValue($rs->fields('idbodega'));
		$this->existencia->setDbValue($rs->fields('existencia'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->idproducto_sucursal->setDbValue($rs->fields('idproducto_sucursal'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idproducto_bodega->DbValue = $row['idproducto_bodega'];
		$this->idproducto->DbValue = $row['idproducto'];
		$this->idbodega->DbValue = $row['idbodega'];
		$this->existencia->DbValue = $row['existencia'];
		$this->estado->DbValue = $row['estado'];
		$this->idproducto_sucursal->DbValue = $row['idproducto_sucursal'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idproducto_bodega
		// idproducto
		// idbodega
		// existencia
		// estado
		// idproducto_sucursal

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idproducto_bodega
			$this->idproducto_bodega->ViewValue = $this->idproducto_bodega->CurrentValue;
			$this->idproducto_bodega->ViewCustomAttributes = "";

			// idproducto
			if (strval($this->idproducto->CurrentValue) <> "") {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproducto, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idproducto->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idproducto->ViewValue = $this->idproducto->CurrentValue;
				}
			} else {
				$this->idproducto->ViewValue = NULL;
			}
			$this->idproducto->ViewCustomAttributes = "";

			// idbodega
			if (strval($this->idbodega->CurrentValue) <> "") {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idbodega, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `descripcion`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idbodega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idbodega->ViewValue = $this->idbodega->CurrentValue;
				}
			} else {
				$this->idbodega->ViewValue = NULL;
			}
			$this->idbodega->ViewCustomAttributes = "";

			// existencia
			$this->existencia->ViewValue = $this->existencia->CurrentValue;
			$this->existencia->ViewCustomAttributes = "";

			// estado
			if (strval($this->estado->CurrentValue) <> "") {
				switch ($this->estado->CurrentValue) {
					case $this->estado->FldTagValue(1):
						$this->estado->ViewValue = $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->CurrentValue;
						break;
					case $this->estado->FldTagValue(2):
						$this->estado->ViewValue = $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->CurrentValue;
						break;
					default:
						$this->estado->ViewValue = $this->estado->CurrentValue;
				}
			} else {
				$this->estado->ViewValue = NULL;
			}
			$this->estado->ViewCustomAttributes = "";

			// idproducto_sucursal
			$this->idproducto_sucursal->ViewValue = $this->idproducto_sucursal->CurrentValue;
			$this->idproducto_sucursal->ViewCustomAttributes = "";

			// idproducto
			$this->idproducto->LinkCustomAttributes = "";
			$this->idproducto->HrefValue = "";
			$this->idproducto->TooltipValue = "";

			// idbodega
			$this->idbodega->LinkCustomAttributes = "";
			$this->idbodega->HrefValue = "";
			$this->idbodega->TooltipValue = "";

			// existencia
			$this->existencia->LinkCustomAttributes = "";
			$this->existencia->HrefValue = "";
			$this->existencia->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// idproducto_sucursal
			$this->idproducto_sucursal->LinkCustomAttributes = "";
			$this->idproducto_sucursal->HrefValue = "";
			$this->idproducto_sucursal->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idproducto
			$this->idproducto->EditAttrs["class"] = "form-control";
			$this->idproducto->EditCustomAttributes = "";
			if (trim(strval($this->idproducto->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `producto`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproducto, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idproducto->EditValue = $arwrk;

			// idbodega
			$this->idbodega->EditAttrs["class"] = "form-control";
			$this->idbodega->EditCustomAttributes = "";
			if (trim(strval($this->idbodega->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `bodega`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idbodega, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `descripcion`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idbodega->EditValue = $arwrk;

			// existencia
			$this->existencia->EditAttrs["class"] = "form-control";
			$this->existencia->EditCustomAttributes = "";
			$this->existencia->EditValue = ew_HtmlEncode($this->existencia->CurrentValue);
			$this->existencia->PlaceHolder = ew_RemoveHtml($this->existencia->FldCaption());

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// idproducto_sucursal
			$this->idproducto_sucursal->EditAttrs["class"] = "form-control";
			$this->idproducto_sucursal->EditCustomAttributes = "";
			$this->idproducto_sucursal->EditValue = ew_HtmlEncode($this->idproducto_sucursal->CurrentValue);
			$this->idproducto_sucursal->PlaceHolder = ew_RemoveHtml($this->idproducto_sucursal->FldCaption());

			// Edit refer script
			// idproducto

			$this->idproducto->HrefValue = "";

			// idbodega
			$this->idbodega->HrefValue = "";

			// existencia
			$this->existencia->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// idproducto_sucursal
			$this->idproducto_sucursal->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->idproducto->FldIsDetailKey && !is_null($this->idproducto->FormValue) && $this->idproducto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idproducto->FldCaption(), $this->idproducto->ReqErrMsg));
		}
		if (!$this->idbodega->FldIsDetailKey && !is_null($this->idbodega->FormValue) && $this->idbodega->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idbodega->FldCaption(), $this->idbodega->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->existencia->FormValue)) {
			ew_AddMessage($gsFormError, $this->existencia->FldErrMsg());
		}
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}
		if (!$this->idproducto_sucursal->FldIsDetailKey && !is_null($this->idproducto_sucursal->FormValue) && $this->idproducto_sucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idproducto_sucursal->FldCaption(), $this->idproducto_sucursal->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idproducto_sucursal->FormValue)) {
			ew_AddMessage($gsFormError, $this->idproducto_sucursal->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// idproducto
			$this->idproducto->SetDbValueDef($rsnew, $this->idproducto->CurrentValue, 0, $this->idproducto->ReadOnly);

			// idbodega
			$this->idbodega->SetDbValueDef($rsnew, $this->idbodega->CurrentValue, 0, $this->idbodega->ReadOnly);

			// existencia
			$this->existencia->SetDbValueDef($rsnew, $this->existencia->CurrentValue, NULL, $this->existencia->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

			// idproducto_sucursal
			$this->idproducto_sucursal->SetDbValueDef($rsnew, $this->idproducto_sucursal->CurrentValue, 0, $this->idproducto_sucursal->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "producto_bodegalist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($producto_bodega_edit)) $producto_bodega_edit = new cproducto_bodega_edit();

// Page init
$producto_bodega_edit->Page_Init();

// Page main
$producto_bodega_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_bodega_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var producto_bodega_edit = new ew_Page("producto_bodega_edit");
producto_bodega_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = producto_bodega_edit.PageID; // For backward compatibility

// Form object
var fproducto_bodegaedit = new ew_Form("fproducto_bodegaedit");

// Validate form
fproducto_bodegaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->idproducto->FldCaption(), $producto_bodega->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->idbodega->FldCaption(), $producto_bodega->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_existencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_bodega->existencia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->estado->FldCaption(), $producto_bodega->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto_sucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_bodega->idproducto_sucursal->FldCaption(), $producto_bodega->idproducto_sucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto_sucursal");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_bodega->idproducto_sucursal->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fproducto_bodegaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_bodegaedit.ValidateRequired = true;
<?php } else { ?>
fproducto_bodegaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_bodegaedit.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_bodegaedit.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $producto_bodega_edit->ShowPageHeader(); ?>
<?php
$producto_bodega_edit->ShowMessage();
?>
<form name="fproducto_bodegaedit" id="fproducto_bodegaedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($producto_bodega_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $producto_bodega_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="producto_bodega">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($producto_bodega->idproducto->Visible) { // idproducto ?>
	<div id="r_idproducto" class="form-group">
		<label id="elh_producto_bodega_idproducto" for="x_idproducto" class="col-sm-2 control-label ewLabel"><?php echo $producto_bodega->idproducto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_bodega->idproducto->CellAttributes() ?>>
<span id="el_producto_bodega_idproducto">
<select data-field="x_idproducto" id="x_idproducto" name="x_idproducto"<?php echo $producto_bodega->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idproducto->EditValue)) {
	$arwrk = $producto_bodega->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
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
$producto_bodega->Lookup_Selecting($producto_bodega->idproducto, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idproducto" id="s_x_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $producto_bodega->idproducto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_bodega->idbodega->Visible) { // idbodega ?>
	<div id="r_idbodega" class="form-group">
		<label id="elh_producto_bodega_idbodega" for="x_idbodega" class="col-sm-2 control-label ewLabel"><?php echo $producto_bodega->idbodega->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_bodega->idbodega->CellAttributes() ?>>
<span id="el_producto_bodega_idbodega">
<select data-field="x_idbodega" id="x_idbodega" name="x_idbodega"<?php echo $producto_bodega->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->idbodega->EditValue)) {
	$arwrk = $producto_bodega->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
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
$producto_bodega->Lookup_Selecting($producto_bodega->idbodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x_idbodega" id="s_x_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $producto_bodega->idbodega->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_bodega->existencia->Visible) { // existencia ?>
	<div id="r_existencia" class="form-group">
		<label id="elh_producto_bodega_existencia" for="x_existencia" class="col-sm-2 control-label ewLabel"><?php echo $producto_bodega->existencia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $producto_bodega->existencia->CellAttributes() ?>>
<span id="el_producto_bodega_existencia">
<input type="text" data-field="x_existencia" name="x_existencia" id="x_existencia" size="30" placeholder="<?php echo ew_HtmlEncode($producto_bodega->existencia->PlaceHolder) ?>" value="<?php echo $producto_bodega->existencia->EditValue ?>"<?php echo $producto_bodega->existencia->EditAttributes() ?>>
</span>
<?php echo $producto_bodega->existencia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_bodega->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_producto_bodega_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $producto_bodega->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_bodega->estado->CellAttributes() ?>>
<span id="el_producto_bodega_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $producto_bodega->estado->EditAttributes() ?>>
<?php
if (is_array($producto_bodega->estado->EditValue)) {
	$arwrk = $producto_bodega->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_bodega->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span>
<?php echo $producto_bodega->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_bodega->idproducto_sucursal->Visible) { // idproducto_sucursal ?>
	<div id="r_idproducto_sucursal" class="form-group">
		<label id="elh_producto_bodega_idproducto_sucursal" for="x_idproducto_sucursal" class="col-sm-2 control-label ewLabel"><?php echo $producto_bodega->idproducto_sucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_bodega->idproducto_sucursal->CellAttributes() ?>>
<span id="el_producto_bodega_idproducto_sucursal">
<input type="text" data-field="x_idproducto_sucursal" name="x_idproducto_sucursal" id="x_idproducto_sucursal" size="30" placeholder="<?php echo ew_HtmlEncode($producto_bodega->idproducto_sucursal->PlaceHolder) ?>" value="<?php echo $producto_bodega->idproducto_sucursal->EditValue ?>"<?php echo $producto_bodega->idproducto_sucursal->EditAttributes() ?>>
</span>
<?php echo $producto_bodega->idproducto_sucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_idproducto_bodega" name="x_idproducto_bodega" id="x_idproducto_bodega" value="<?php echo ew_HtmlEncode($producto_bodega->idproducto_bodega->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fproducto_bodegaedit.Init();
</script>
<?php
$producto_bodega_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$producto_bodega_edit->Page_Terminate();
?>
