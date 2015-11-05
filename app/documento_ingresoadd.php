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

$documento_ingreso_add = NULL; // Initialize page object first

class cdocumento_ingreso_add extends cdocumento_ingreso {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_ingreso';

	// Page object name
	var $PageObjName = 'documento_ingreso_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["iddocumento_ingreso"] != "") {
				$this->iddocumento_ingreso->setQueryStringValue($_GET["iddocumento_ingreso"]);
				$this->setKey("iddocumento_ingreso", $this->iddocumento_ingreso->CurrentValue); // Set up key
			} else {
				$this->setKey("iddocumento_ingreso", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("documento_ingresolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "documento_ingresoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->idtipo_documento->CurrentValue = 1;
		$this->idsucursal->CurrentValue = 1;
		$this->serie->CurrentValue = NULL;
		$this->serie->OldValue = $this->serie->CurrentValue;
		$this->correlativo->CurrentValue = NULL;
		$this->correlativo->OldValue = $this->correlativo->CurrentValue;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->observaciones->CurrentValue = NULL;
		$this->observaciones->OldValue = $this->observaciones->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idtipo_documento->FldIsDetailKey) {
			$this->idtipo_documento->setFormValue($objForm->GetValue("x_idtipo_documento"));
		}
		if (!$this->idsucursal->FldIsDetailKey) {
			$this->idsucursal->setFormValue($objForm->GetValue("x_idsucursal"));
		}
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idtipo_documento->CurrentValue = $this->idtipo_documento->FormValue;
		$this->idsucursal->CurrentValue = $this->idsucursal->FormValue;
		$this->serie->CurrentValue = $this->serie->FormValue;
		$this->correlativo->CurrentValue = $this->correlativo->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->observaciones->CurrentValue = $this->observaciones->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("iddocumento_ingreso")) <> "")
			$this->iddocumento_ingreso->CurrentValue = $this->getKey("iddocumento_ingreso"); // iddocumento_ingreso
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
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

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idtipo_documento
			$this->idtipo_documento->EditAttrs["class"] = "form-control";
			$this->idtipo_documento->EditCustomAttributes = "";
			if (trim(strval($this->idtipo_documento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_documento`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idtipo_documento->EditValue = $arwrk;

			// idsucursal
			$this->idsucursal->EditAttrs["class"] = "form-control";
			$this->idsucursal->EditCustomAttributes = "";
			if (trim(strval($this->idsucursal->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idsucursal`" . ew_SearchString("=", $this->idsucursal->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sucursal`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsucursal->EditValue = $arwrk;

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

			// Edit refer script
			// idtipo_documento

			$this->idtipo_documento->HrefValue = "";

			// idsucursal
			$this->idsucursal->HrefValue = "";

			// serie
			$this->serie->HrefValue = "";

			// correlativo
			$this->correlativo->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// observaciones
			$this->observaciones->HrefValue = "";
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
		if (!$this->idsucursal->FldIsDetailKey && !is_null($this->idsucursal->FormValue) && $this->idsucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsucursal->FldCaption(), $this->idsucursal->ReqErrMsg));
		}
		if (!$this->correlativo->FldIsDetailKey && !is_null($this->correlativo->FormValue) && $this->correlativo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->correlativo->FldCaption(), $this->correlativo->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->correlativo->FormValue)) {
			ew_AddMessage($gsFormError, $this->correlativo->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("detalle_documento_ingreso", $DetailTblVar) && $GLOBALS["detalle_documento_ingreso"]->DetailAdd) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idtipo_documento
		$this->idtipo_documento->SetDbValueDef($rsnew, $this->idtipo_documento->CurrentValue, 0, strval($this->idtipo_documento->CurrentValue) == "");

		// idsucursal
		$this->idsucursal->SetDbValueDef($rsnew, $this->idsucursal->CurrentValue, 0, strval($this->idsucursal->CurrentValue) == "");

		// serie
		$this->serie->SetDbValueDef($rsnew, $this->serie->CurrentValue, NULL, FALSE);

		// correlativo
		$this->correlativo->SetDbValueDef($rsnew, $this->correlativo->CurrentValue, NULL, FALSE);

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// observaciones
		$this->observaciones->SetDbValueDef($rsnew, $this->observaciones->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->iddocumento_ingreso->setDbValue($conn->Insert_ID());
			$rsnew['iddocumento_ingreso'] = $this->iddocumento_ingreso->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("detalle_documento_ingreso", $DetailTblVar) && $GLOBALS["detalle_documento_ingreso"]->DetailAdd) {
				$GLOBALS["detalle_documento_ingreso"]->iddocumento_ingreso->setSessionValue($this->iddocumento_ingreso->CurrentValue); // Set master key
				if (!isset($GLOBALS["detalle_documento_ingreso_grid"])) $GLOBALS["detalle_documento_ingreso_grid"] = new cdetalle_documento_ingreso_grid(); // Get detail page object
				$AddRow = $GLOBALS["detalle_documento_ingreso_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["detalle_documento_ingreso"]->iddocumento_ingreso->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
				if ($GLOBALS["detalle_documento_ingreso_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["detalle_documento_ingreso_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["detalle_documento_ingreso_grid"]->CurrentMode = "add";
					$GLOBALS["detalle_documento_ingreso_grid"]->CurrentAction = "gridadd";

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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
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
if (!isset($documento_ingreso_add)) $documento_ingreso_add = new cdocumento_ingreso_add();

// Page init
$documento_ingreso_add->Page_Init();

// Page main
$documento_ingreso_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_ingreso_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var documento_ingreso_add = new ew_Page("documento_ingreso_add");
documento_ingreso_add.PageID = "add"; // Page ID
var EW_PAGE_ID = documento_ingreso_add.PageID; // For backward compatibility

// Form object
var fdocumento_ingresoadd = new ew_Form("fdocumento_ingresoadd");

// Validate form
fdocumento_ingresoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->idsucursal->FldCaption(), $documento_ingreso->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_ingreso->correlativo->FldCaption(), $documento_ingreso->correlativo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_correlativo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_ingreso->correlativo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_ingreso->fecha->FldErrMsg()) ?>");

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
fdocumento_ingresoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_ingresoadd.ValidateRequired = true;
<?php } else { ?>
fdocumento_ingresoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_ingresoadd.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_ingresoadd.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $documento_ingreso_add->ShowPageHeader(); ?>
<?php
$documento_ingreso_add->ShowMessage();
?>
<form name="fdocumento_ingresoadd" id="fdocumento_ingresoadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_ingreso_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_ingreso_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_ingreso">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($documento_ingreso->idtipo_documento->Visible) { // idtipo_documento ?>
	<div id="r_idtipo_documento" class="form-group">
		<label id="elh_documento_ingreso_idtipo_documento" for="x_idtipo_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->idtipo_documento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_ingreso_idtipo_documento">
<select data-field="x_idtipo_documento" id="x_idtipo_documento" name="x_idtipo_documento"<?php echo $documento_ingreso->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_ingreso->idtipo_documento->EditValue)) {
	$arwrk = $documento_ingreso->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_ingreso->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$documento_ingreso->Lookup_Selecting($documento_ingreso->idtipo_documento, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idtipo_documento" id="s_x_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $documento_ingreso->idtipo_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_ingreso->idsucursal->Visible) { // idsucursal ?>
	<div id="r_idsucursal" class="form-group">
		<label id="elh_documento_ingreso_idsucursal" for="x_idsucursal" class="col-sm-2 control-label ewLabel"><?php echo $documento_ingreso->idsucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_ingreso->idsucursal->CellAttributes() ?>>
<span id="el_documento_ingreso_idsucursal">
<select data-field="x_idsucursal" id="x_idsucursal" name="x_idsucursal"<?php echo $documento_ingreso->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento_ingreso->idsucursal->EditValue)) {
	$arwrk = $documento_ingreso->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_ingreso->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$documento_ingreso->Lookup_Selecting($documento_ingreso->idsucursal, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idsucursal" id="s_x_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $documento_ingreso->idsucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
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
ew_CreateCalendar("fdocumento_ingresoadd", "x_fecha", "%d/%m/%Y");
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
</div>
<?php
	if (in_array("detalle_documento_ingreso", explode(",", $documento_ingreso->getCurrentDetailTable())) && $detalle_documento_ingreso->DetailAdd) {
?>
<?php if ($documento_ingreso->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_ingreso", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_ingresogrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fdocumento_ingresoadd.Init();
</script>
<?php
$documento_ingreso_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_ingreso_add->Page_Terminate();
?>
