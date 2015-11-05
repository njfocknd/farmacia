<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "documento_ingresoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "detalle_documento_ingresogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$documento_ingreso_edit = NULL; // Initialize page object first

class cdocumento_ingreso_edit extends cdocumento_ingreso {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_ingreso';

	// Page object name
	var $PageObjName = 'documento_ingreso_edit';

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

		// Table object (documento_ingreso)
		if (!isset($GLOBALS["documento_ingreso"]) || get_class($GLOBALS["documento_ingreso"]) == "cdocumento_ingreso") {
			$GLOBALS["documento_ingreso"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_ingreso"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_ingreso', TRUE);

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

			// Process auto fill for detail table 'detalle_documento_ingreso'
			if (@$_POST["grid"] == "fdetalle_documento_ingresogrid") {
				if (!isset($GLOBALS["detalle_documento_ingreso_grid"])) $GLOBALS["detalle_documento_ingreso_grid"] = new cdetalle_documento_ingreso_grid;
				$GLOBALS["detalle_documento_ingreso_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $documento_ingreso;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($documento_ingreso);
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
		if (@$_GET["iddocumento_ingreso"] <> "") {
			$this->iddocumento_ingreso->setQueryStringValue($_GET["iddocumento_ingreso"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->iddocumento_ingreso->CurrentValue == "")
			$this->Page_Terminate("documento_ingresolist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("documento_ingresolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
					else
						$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->serie->FldIsDetailKey) {
			$this->serie->setFormValue($objForm->GetValue("x_serie"));
		}
		if (!$this->correlativo->FldIsDetailKey) {
			$this->correlativo->setFormValue($objForm->GetValue("x_correlativo"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->observaciones->FldIsDetailKey) {
			$this->observaciones->setFormValue($objForm->GetValue("x_observaciones"));
		}
		if (!$this->estado_documento->FldIsDetailKey) {
			$this->estado_documento->setFormValue($objForm->GetValue("x_estado_documento"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->iddocumento_ingreso->FldIsDetailKey)
			$this->iddocumento_ingreso->setFormValue($objForm->GetValue("x_iddocumento_ingreso"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->iddocumento_ingreso->CurrentValue = $this->iddocumento_ingreso->FormValue;
		$this->serie->CurrentValue = $this->serie->FormValue;
		$this->correlativo->CurrentValue = $this->correlativo->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->observaciones->CurrentValue = $this->observaciones->FormValue;
		$this->estado_documento->CurrentValue = $this->estado_documento->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
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
		$this->iddocumento_ingreso->setDbValue($rs->fields('iddocumento_ingreso'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->correlativo->setDbValue($rs->fields('correlativo'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
		$this->estado_documento->setDbValue($rs->fields('estado_documento'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddocumento_ingreso->DbValue = $row['iddocumento_ingreso'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->serie->DbValue = $row['serie'];
		$this->correlativo->DbValue = $row['correlativo'];
		$this->fecha->DbValue = $row['fecha'];
		$this->observaciones->DbValue = $row['observaciones'];
		$this->estado_documento->DbValue = $row['estado_documento'];
		$this->estado->DbValue = $row['estado'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// iddocumento_ingreso
		// idtipo_documento
		// idsucursal
		// serie
		// correlativo
		// fecha
		// observaciones
		// estado_documento
		// estado
		// monto
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// iddocumento_ingreso
			$this->iddocumento_ingreso->ViewValue = $this->iddocumento_ingreso->CurrentValue;
			$this->iddocumento_ingreso->ViewCustomAttributes = "";

			// idtipo_documento
			if (strval($this->idtipo_documento->CurrentValue) <> "") {
				$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idtipo_documento->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
				}
			} else {
				$this->idtipo_documento->ViewValue = NULL;
			}
			$this->idtipo_documento->ViewCustomAttributes = "";

			// idsucursal
			if (strval($this->idsucursal->CurrentValue) <> "") {
				$sFilterWrk = "`idsucursal`" . ew_SearchString("=", $this->idsucursal->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idsucursal, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idsucursal->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idsucursal->ViewValue = $this->idsucursal->CurrentValue;
				}
			} else {
				$this->idsucursal->ViewValue = NULL;
			}
			$this->idsucursal->ViewCustomAttributes = "";

			// serie
			$this->serie->ViewValue = $this->serie->CurrentValue;
			$this->serie->ViewCustomAttributes = "";

			// correlativo
			$this->correlativo->ViewValue = $this->correlativo->CurrentValue;
			$this->correlativo->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// observaciones
			$this->observaciones->ViewValue = $this->observaciones->CurrentValue;
			$this->observaciones->ViewCustomAttributes = "";

			// estado_documento
			if (strval($this->estado_documento->CurrentValue) <> "") {
				switch ($this->estado_documento->CurrentValue) {
					case $this->estado_documento->FldTagValue(1):
						$this->estado_documento->ViewValue = $this->estado_documento->FldTagCaption(1) <> "" ? $this->estado_documento->FldTagCaption(1) : $this->estado_documento->CurrentValue;
						break;
					case $this->estado_documento->FldTagValue(2):
						$this->estado_documento->ViewValue = $this->estado_documento->FldTagCaption(2) <> "" ? $this->estado_documento->FldTagCaption(2) : $this->estado_documento->CurrentValue;
						break;
					default:
						$this->estado_documento->ViewValue = $this->estado_documento->CurrentValue;
				}
			} else {
				$this->estado_documento->ViewValue = NULL;
			}
			$this->estado_documento->ViewCustomAttributes = "";

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

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// serie
			$this->serie->LinkCustomAttributes = "";
			$this->serie->HrefValue = "";
			$this->serie->TooltipValue = "";

			// correlativo
			$this->correlativo->LinkCustomAttributes = "";
			$this->correlativo->HrefValue = "";
			$this->correlativo->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// observaciones
			$this->observaciones->LinkCustomAttributes = "";
			$this->observaciones->HrefValue = "";
			$this->observaciones->TooltipValue = "";

			// estado_documento
			$this->estado_documento->LinkCustomAttributes = "";
			$this->estado_documento->HrefValue = "";
			$this->estado_documento->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// serie
			$this->serie->EditAttrs["class"] = "form-control";
			$this->serie->EditCustomAttributes = "";
			$this->serie->EditValue = ew_HtmlEncode($this->serie->CurrentValue);
			$this->serie->PlaceHolder = ew_RemoveHtml($this->serie->FldCaption());

			// correlativo
			$this->correlativo->EditAttrs["class"] = "form-control";
			$this->correlativo->EditCustomAttributes = "";
			$this->correlativo->EditValue = ew_HtmlEncode($this->correlativo->CurrentValue);
			$this->correlativo->PlaceHolder = ew_RemoveHtml($this->correlativo->FldCaption());

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// observaciones
			$this->observaciones->EditAttrs["class"] = "form-control";
			$this->observaciones->EditCustomAttributes = "";
			$this->observaciones->EditValue = ew_HtmlEncode($this->observaciones->CurrentValue);
			$this->observaciones->PlaceHolder = ew_RemoveHtml($this->observaciones->FldCaption());

			// estado_documento
			$this->estado_documento->EditAttrs["class"] = "form-control";
			$this->estado_documento->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento->FldTagValue(1), $this->estado_documento->FldTagCaption(1) <> "" ? $this->estado_documento->FldTagCaption(1) : $this->estado_documento->FldTagValue(1));
			$arwrk[] = array($this->estado_documento->FldTagValue(2), $this->estado_documento->FldTagCaption(2) <> "" ? $this->estado_documento->FldTagCaption(2) : $this->estado_documento->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento->EditValue = $arwrk;

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// serie

			$this->serie->HrefValue = "";

			// correlativo
			$this->correlativo->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// observaciones
			$this->observaciones->HrefValue = "";

			// estado_documento
			$this->estado_documento->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";
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
		if (!$this->correlativo->FldIsDetailKey && !is_null($this->correlativo->FormValue) && $this->correlativo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->correlativo->FldCaption(), $this->correlativo->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->correlativo->FormValue)) {
			ew_AddMessage($gsFormError, $this->correlativo->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->estado_documento->FldIsDetailKey && !is_null($this->estado_documento->FormValue) && $this->estado_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento->FldCaption(), $this->estado_documento->ReqErrMsg));
		}
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("detalle_documento_ingreso", $DetailTblVar) && $GLOBALS["detalle_documento_ingreso"]->DetailEdit) {
			if (!isset($GLOBALS["detalle_documento_ingreso_grid"])) $GLOBALS["detalle_documento_ingreso_grid"] = new cdetalle_documento_ingreso_grid(); // get detail page object
			$GLOBALS["detalle_documento_ingreso_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// serie
			$this->serie->SetDbValueDef($rsnew, $this->serie->CurrentValue, NULL, $this->serie->ReadOnly);

			// correlativo
			$this->correlativo->SetDbValueDef($rsnew, $this->correlativo->CurrentValue, NULL, $this->correlativo->ReadOnly);

			// fecha
			$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, $this->fecha->ReadOnly);

			// observaciones
			$this->observaciones->SetDbValueDef($rsnew, $this->observaciones->CurrentValue, NULL, $this->observaciones->ReadOnly);

			// estado_documento
			$this->estado_documento->SetDbValueDef($rsnew, $this->estado_documento->CurrentValue, "", $this->estado_documento->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, NULL, $this->estado->ReadOnly);

			// monto
			$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, $this->monto->ReadOnly);

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("detalle_documento_ingreso", $DetailTblVar) && $GLOBALS["detalle_documento_ingreso"]->DetailEdit) {
						if (!isset($GLOBALS["detalle_documento_ingreso_grid"])) $GLOBALS["detalle_documento_ingreso_grid"] = new cdetalle_documento_ingreso_grid(); // Get detail page object
						$EditRow = $GLOBALS["detalle_documento_ingreso_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("detalle_documento_ingreso", $DetailTblVar)) {
				if (!isset($GLOBALS["detalle_documento_ingreso_grid"]))
					$GLOBALS["detalle_documento_ingreso_grid"] = new cdetalle_documento_ingreso_grid;
				if ($GLOBALS["detalle_documento_ingreso_grid"]->DetailEdit) {
					$GLOBALS["detalle_documento_ingreso_grid"]->CurrentMode = "edit";
					$GLOBALS["detalle_documento_ingreso_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["detalle_documento_ingreso_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["detalle_documento_ingreso_grid"]->setStartRecordNumber(1);
					$GLOBALS["detalle_documento_ingreso_grid"]->iddocumento_ingreso->FldIsDetailKey = TRUE;
					$GLOBALS["detalle_documento_ingreso_grid"]->iddocumento_ingreso->CurrentValue = $this->iddocumento_ingreso->CurrentValue;
					$GLOBALS["detalle_documento_ingreso_grid"]->iddocumento_ingreso->setSessionValue($GLOBALS["detalle_documento_ingreso_grid"]->iddocumento_ingreso->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "documento_ingresolist.php", "", $this->TableVar, TRUE);
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
if (!isset($documento_ingreso_edit)) $documento_ingreso_edit = new cdocumento_ingreso_edit();

// Page init
$documento_ingreso_edit->Page_Init();

// Page main
$documento_ingreso_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_ingreso_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var documento_ingreso_edit = new ew_Page("documento_ingreso_edit");
documento_ingreso_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = documento_ingreso_edit.PageID; // For backward compatibility

// Form object
var fdocumento_ingresoedit = new ew_Form("fdocumento_ingresoedit");

// Validate form
fdocumento_ingresoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->correlativo->FldCaption(), $documento_ingreso->correlativo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_ingreso->correlativo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_ingreso->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->estado_documento->FldCaption(), $documento_ingreso->estado_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->estado->FldCaption(), $documento_ingreso->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->monto->FldCaption(), $documento_ingreso->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_ingreso->monto->FldErrMsg()) ?>");

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
fdocumento_ingresoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_ingresoedit.ValidateRequired = true;
<?php } else { ?>
fdocumento_ingresoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $documento_ingreso_edit->ShowPageHeader(); ?>
<?php
$documento_ingreso_edit->ShowMessage();
?>
<form name="fdocumento_ingresoedit" id="fdocumento_ingresoedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_ingreso_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_ingreso_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_ingreso">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($documento_ingreso->serie->Visible) { // serie ?>
	<div id="r_serie" class="form-group">
		<label id="elh_documento_ingreso_serie" for="x_serie" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->serie->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->serie->CellAttributes() ?>>
<span id="el_documento_ingreso_serie">
<input type="text" data-field="x_serie" name="x_serie" id="x_serie" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_ingreso->serie->PlaceHolder) ?>" value="<?php echo $documento_ingreso->serie->EditValue ?>"<?php echo $documento_ingreso->serie->EditAttributes() ?>>
</span>
<?php echo $documento_ingreso->serie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->correlativo->Visible) { // correlativo ?>
	<div id="r_correlativo" class="form-group">
		<label id="elh_documento_ingreso_correlativo" for="x_correlativo" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->correlativo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->correlativo->CellAttributes() ?>>
<span id="el_documento_ingreso_correlativo">
<input type="text" data-field="x_correlativo" name="x_correlativo" id="x_correlativo" size="30" placeholder="<?php echo ew_HtmlEncode($documento_ingreso->correlativo->PlaceHolder) ?>" value="<?php echo $documento_ingreso->correlativo->EditValue ?>"<?php echo $documento_ingreso->correlativo->EditAttributes() ?>>
</span>
<?php echo $documento_ingreso->correlativo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_documento_ingreso_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->fecha->CellAttributes() ?>>
<span id="el_documento_ingreso_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($documento_ingreso->fecha->PlaceHolder) ?>" value="<?php echo $documento_ingreso->fecha->EditValue ?>"<?php echo $documento_ingreso->fecha->EditAttributes() ?>>
<?php if (!$documento_ingreso->fecha->ReadOnly && !$documento_ingreso->fecha->Disabled && @$documento_ingreso->fecha->EditAttrs["readonly"] == "" && @$documento_ingreso->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_ingresoedit", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $documento_ingreso->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->observaciones->Visible) { // observaciones ?>
	<div id="r_observaciones" class="form-group">
		<label id="elh_documento_ingreso_observaciones" for="x_observaciones" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->observaciones->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->observaciones->CellAttributes() ?>>
<span id="el_documento_ingreso_observaciones">
<input type="text" data-field="x_observaciones" name="x_observaciones" id="x_observaciones" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_ingreso->observaciones->PlaceHolder) ?>" value="<?php echo $documento_ingreso->observaciones->EditValue ?>"<?php echo $documento_ingreso->observaciones->EditAttributes() ?>>
</span>
<?php echo $documento_ingreso->observaciones->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->estado_documento->Visible) { // estado_documento ?>
	<div id="r_estado_documento" class="form-group">
		<label id="elh_documento_ingreso_estado_documento" for="x_estado_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->estado_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->estado_documento->CellAttributes() ?>>
<span id="el_documento_ingreso_estado_documento">
<select data-field="x_estado_documento" id="x_estado_documento" name="x_estado_documento"<?php echo $documento_ingreso->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento_ingreso->estado_documento->EditValue)) {
	$arwrk = $documento_ingreso->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_ingreso->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $documento_ingreso->estado_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_documento_ingreso_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->estado->CellAttributes() ?>>
<span id="el_documento_ingreso_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $documento_ingreso->estado->EditAttributes() ?>>
<?php
if (is_array($documento_ingreso->estado->EditValue)) {
	$arwrk = $documento_ingreso->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_ingreso->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $documento_ingreso->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_documento_ingreso_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->monto->CellAttributes() ?>>
<span id="el_documento_ingreso_monto">
<input type="text" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_ingreso->monto->PlaceHolder) ?>" value="<?php echo $documento_ingreso->monto->EditValue ?>"<?php echo $documento_ingreso->monto->EditAttributes() ?>>
</span>
<?php echo $documento_ingreso->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_iddocumento_ingreso" name="x_iddocumento_ingreso" id="x_iddocumento_ingreso" value="<?php echo ew_HtmlEncode($documento_ingreso->iddocumento_ingreso->CurrentValue) ?>">
<?php
	if (in_array("detalle_documento_ingreso", explode(",", $documento_ingreso->getCurrentDetailTable())) && $detalle_documento_ingreso->DetailEdit) {
?>
<?php if ($documento_ingreso->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_ingreso", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_ingresogrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fdocumento_ingresoedit.Init();
</script>
<?php
$documento_ingreso_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_ingreso_edit->Page_Terminate();
?>
