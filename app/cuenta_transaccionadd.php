<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_transaccioninfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$cuenta_transaccion_add = NULL; // Initialize page object first

class ccuenta_transaccion_add extends ccuenta_transaccion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'cuenta_transaccion';

	// Page object name
	var $PageObjName = 'cuenta_transaccion_add';

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
	var $AuditTrailOnAdd = TRUE;

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
		$hidden = TRUE;
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

		// Table object (cuenta_transaccion)
		if (!isset($GLOBALS["cuenta_transaccion"]) || get_class($GLOBALS["cuenta_transaccion"]) == "ccuenta_transaccion") {
			$GLOBALS["cuenta_transaccion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta_transaccion"];
		}

		// Table object (cuenta)
		if (!isset($GLOBALS['cuenta'])) $GLOBALS['cuenta'] = new ccuenta();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta_transaccion', TRUE);

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

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("cuenta_transaccionlist.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

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
		global $EW_EXPORT, $cuenta_transaccion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta_transaccion);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idcuenta_transaccion"] != "") {
				$this->idcuenta_transaccion->setQueryStringValue($_GET["idcuenta_transaccion"]);
				$this->setKey("idcuenta_transaccion", $this->idcuenta_transaccion->CurrentValue); // Set up key
			} else {
				$this->setKey("idcuenta_transaccion", ""); // Clear key
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
					$this->Page_Terminate("cuenta_transaccionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cuenta_transaccionview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
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
		$this->idcuenta->CurrentValue = NULL;
		$this->idcuenta->OldValue = $this->idcuenta->CurrentValue;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->descripcion->CurrentValue = NULL;
		$this->descripcion->OldValue = $this->descripcion->CurrentValue;
		$this->debito->CurrentValue = 0.00;
		$this->credito->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idcuenta->FldIsDetailKey) {
			$this->idcuenta->setFormValue($objForm->GetValue("x_idcuenta"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->descripcion->FldIsDetailKey) {
			$this->descripcion->setFormValue($objForm->GetValue("x_descripcion"));
		}
		if (!$this->debito->FldIsDetailKey) {
			$this->debito->setFormValue($objForm->GetValue("x_debito"));
		}
		if (!$this->credito->FldIsDetailKey) {
			$this->credito->setFormValue($objForm->GetValue("x_credito"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idcuenta->CurrentValue = $this->idcuenta->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->descripcion->CurrentValue = $this->descripcion->FormValue;
		$this->debito->CurrentValue = $this->debito->FormValue;
		$this->credito->CurrentValue = $this->credito->FormValue;
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
		$this->idcuenta_transaccion->setDbValue($rs->fields('idcuenta_transaccion'));
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->id_referencia->setDbValue($rs->fields('id_referencia'));
		$this->tabla_referencia->setDbValue($rs->fields('tabla_referencia'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta_transaccion->DbValue = $row['idcuenta_transaccion'];
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->fecha->DbValue = $row['fecha'];
		$this->descripcion->DbValue = $row['descripcion'];
		$this->debito->DbValue = $row['debito'];
		$this->credito->DbValue = $row['credito'];
		$this->id_referencia->DbValue = $row['id_referencia'];
		$this->tabla_referencia->DbValue = $row['tabla_referencia'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcuenta_transaccion")) <> "")
			$this->idcuenta_transaccion->CurrentValue = $this->getKey("idcuenta_transaccion"); // idcuenta_transaccion
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
		// Convert decimal values if posted back

		if ($this->debito->FormValue == $this->debito->CurrentValue && is_numeric(ew_StrToFloat($this->debito->CurrentValue)))
			$this->debito->CurrentValue = ew_StrToFloat($this->debito->CurrentValue);

		// Convert decimal values if posted back
		if ($this->credito->FormValue == $this->credito->CurrentValue && is_numeric(ew_StrToFloat($this->credito->CurrentValue)))
			$this->credito->CurrentValue = ew_StrToFloat($this->credito->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta_transaccion
		// idcuenta
		// fecha
		// descripcion
		// debito
		// credito
		// id_referencia
		// tabla_referencia
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcuenta_transaccion
			$this->idcuenta_transaccion->ViewValue = $this->idcuenta_transaccion->CurrentValue;
			$this->idcuenta_transaccion->ViewCustomAttributes = "";

			// idcuenta
			if (strval($this->idcuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `numero`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcuenta->ViewValue = $rswrk->fields('DispFld');
					$this->idcuenta->ViewValue .= ew_ValueSeparator(1,$this->idcuenta) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
				}
			} else {
				$this->idcuenta->ViewValue = NULL;
			}
			$this->idcuenta->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// descripcion
			$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
			$this->descripcion->ViewCustomAttributes = "";

			// debito
			$this->debito->ViewValue = $this->debito->CurrentValue;
			$this->debito->ViewValue = ew_FormatNumber($this->debito->ViewValue, 2, -2, -2, -2);
			$this->debito->ViewCustomAttributes = "";

			// credito
			$this->credito->ViewValue = $this->credito->CurrentValue;
			$this->credito->ViewValue = ew_FormatNumber($this->credito->ViewValue, 2, -2, -2, -2);
			$this->credito->ViewCustomAttributes = "";

			// id_referencia
			$this->id_referencia->ViewValue = $this->id_referencia->CurrentValue;
			$this->id_referencia->ViewCustomAttributes = "";

			// tabla_referencia
			$this->tabla_referencia->ViewValue = $this->tabla_referencia->CurrentValue;
			$this->tabla_referencia->ViewCustomAttributes = "";

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

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
			$this->idcuenta->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";

			// debito
			$this->debito->LinkCustomAttributes = "";
			$this->debito->HrefValue = "";
			$this->debito->TooltipValue = "";

			// credito
			$this->credito->LinkCustomAttributes = "";
			$this->credito->HrefValue = "";
			$this->credito->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idcuenta
			$this->idcuenta->EditAttrs["class"] = "form-control";
			$this->idcuenta->EditCustomAttributes = "";
			if ($this->idcuenta->getSessionValue() <> "") {
				$this->idcuenta->CurrentValue = $this->idcuenta->getSessionValue();
			if (strval($this->idcuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `numero`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcuenta->ViewValue = $rswrk->fields('DispFld');
					$this->idcuenta->ViewValue .= ew_ValueSeparator(1,$this->idcuenta) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
				}
			} else {
				$this->idcuenta->ViewValue = NULL;
			}
			$this->idcuenta->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idcuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `numero`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcuenta->EditValue = $arwrk;
			}

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// descripcion
			$this->descripcion->EditAttrs["class"] = "form-control";
			$this->descripcion->EditCustomAttributes = "";
			$this->descripcion->EditValue = ew_HtmlEncode($this->descripcion->CurrentValue);
			$this->descripcion->PlaceHolder = ew_RemoveHtml($this->descripcion->FldCaption());

			// debito
			$this->debito->EditAttrs["class"] = "form-control";
			$this->debito->EditCustomAttributes = "";
			$this->debito->EditValue = ew_HtmlEncode($this->debito->CurrentValue);
			$this->debito->PlaceHolder = ew_RemoveHtml($this->debito->FldCaption());
			if (strval($this->debito->EditValue) <> "" && is_numeric($this->debito->EditValue)) $this->debito->EditValue = ew_FormatNumber($this->debito->EditValue, -2, -2, -2, -2);

			// credito
			$this->credito->EditAttrs["class"] = "form-control";
			$this->credito->EditCustomAttributes = "";
			$this->credito->EditValue = ew_HtmlEncode($this->credito->CurrentValue);
			$this->credito->PlaceHolder = ew_RemoveHtml($this->credito->FldCaption());
			if (strval($this->credito->EditValue) <> "" && is_numeric($this->credito->EditValue)) $this->credito->EditValue = ew_FormatNumber($this->credito->EditValue, -2, -2, -2, -2);

			// Edit refer script
			// idcuenta

			$this->idcuenta->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// descripcion
			$this->descripcion->HrefValue = "";

			// debito
			$this->debito->HrefValue = "";

			// credito
			$this->credito->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->debito->FldIsDetailKey && !is_null($this->debito->FormValue) && $this->debito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->debito->FldCaption(), $this->debito->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->debito->FormValue)) {
			ew_AddMessage($gsFormError, $this->debito->FldErrMsg());
		}
		if (!$this->credito->FldIsDetailKey && !is_null($this->credito->FormValue) && $this->credito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->credito->FldCaption(), $this->credito->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->credito->FormValue)) {
			ew_AddMessage($gsFormError, $this->credito->FldErrMsg());
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idcuenta
		$this->idcuenta->SetDbValueDef($rsnew, $this->idcuenta->CurrentValue, NULL, FALSE);

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// descripcion
		$this->descripcion->SetDbValueDef($rsnew, $this->descripcion->CurrentValue, NULL, FALSE);

		// debito
		$this->debito->SetDbValueDef($rsnew, $this->debito->CurrentValue, 0, strval($this->debito->CurrentValue) == "");

		// credito
		$this->credito->SetDbValueDef($rsnew, $this->credito->CurrentValue, 0, strval($this->credito->CurrentValue) == "");

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
			$this->idcuenta_transaccion->setDbValue($conn->Insert_ID());
			$rsnew['idcuenta_transaccion'] = $this->idcuenta_transaccion->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcuenta"] <> "") {
					$GLOBALS["cuenta"]->idcuenta->setQueryStringValue($_GET["fk_idcuenta"]);
					$this->idcuenta->setQueryStringValue($GLOBALS["cuenta"]->idcuenta->QueryStringValue);
					$this->idcuenta->setSessionValue($this->idcuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["cuenta"]->idcuenta->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cuenta") {
				if ($this->idcuenta->QueryStringValue == "") $this->idcuenta->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "cuenta_transaccionlist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'cuenta_transaccion';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'cuenta_transaccion';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idcuenta_transaccion'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
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
if (!isset($cuenta_transaccion_add)) $cuenta_transaccion_add = new ccuenta_transaccion_add();

// Page init
$cuenta_transaccion_add->Page_Init();

// Page main
$cuenta_transaccion_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_transaccion_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var cuenta_transaccion_add = new ew_Page("cuenta_transaccion_add");
cuenta_transaccion_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cuenta_transaccion_add.PageID; // For backward compatibility

// Form object
var fcuenta_transaccionadd = new ew_Form("fcuenta_transaccionadd");

// Validate form
fcuenta_transaccionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_transaccion->debito->FldCaption(), $cuenta_transaccion->debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->debito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_transaccion->credito->FldCaption(), $cuenta_transaccion->credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta_transaccion->credito->FldErrMsg()) ?>");

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
fcuenta_transaccionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_transaccionadd.ValidateRequired = true;
<?php } else { ?>
fcuenta_transaccionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_transaccionadd.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $cuenta_transaccion_add->ShowPageHeader(); ?>
<?php
$cuenta_transaccion_add->ShowMessage();
?>
<form name="fcuenta_transaccionadd" id="fcuenta_transaccionadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_transaccion_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_transaccion_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_transaccion">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($cuenta_transaccion->idcuenta->Visible) { // idcuenta ?>
	<div id="r_idcuenta" class="form-group">
		<label id="elh_cuenta_transaccion_idcuenta" for="x_idcuenta" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_transaccion->idcuenta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_transaccion->idcuenta->CellAttributes() ?>>
<?php if ($cuenta_transaccion->idcuenta->getSessionValue() <> "") { ?>
<span id="el_cuenta_transaccion_idcuenta">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_transaccion->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcuenta" name="x_idcuenta" value="<?php echo ew_HtmlEncode($cuenta_transaccion->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cuenta_transaccion_idcuenta">
<select data-field="x_idcuenta" id="x_idcuenta" name="x_idcuenta"<?php echo $cuenta_transaccion->idcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_transaccion->idcuenta->EditValue)) {
	$arwrk = $cuenta_transaccion->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_transaccion->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cuenta_transaccion->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$cuenta_transaccion->Lookup_Selecting($cuenta_transaccion->idcuenta, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x_idcuenta" id="s_x_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $cuenta_transaccion->idcuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_transaccion->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_cuenta_transaccion_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_transaccion->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_transaccion->fecha->CellAttributes() ?>>
<span id="el_cuenta_transaccion_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->fecha->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->fecha->EditValue ?>"<?php echo $cuenta_transaccion->fecha->EditAttributes() ?>>
<?php if (!$cuenta_transaccion->fecha->ReadOnly && !$cuenta_transaccion->fecha->Disabled && @$cuenta_transaccion->fecha->EditAttrs["readonly"] == "" && @$cuenta_transaccion->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcuenta_transaccionadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $cuenta_transaccion->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_transaccion->descripcion->Visible) { // descripcion ?>
	<div id="r_descripcion" class="form-group">
		<label id="elh_cuenta_transaccion_descripcion" for="x_descripcion" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_transaccion->descripcion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_transaccion->descripcion->CellAttributes() ?>>
<span id="el_cuenta_transaccion_descripcion">
<input type="text" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->descripcion->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->descripcion->EditValue ?>"<?php echo $cuenta_transaccion->descripcion->EditAttributes() ?>>
</span>
<?php echo $cuenta_transaccion->descripcion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_transaccion->debito->Visible) { // debito ?>
	<div id="r_debito" class="form-group">
		<label id="elh_cuenta_transaccion_debito" for="x_debito" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_transaccion->debito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_transaccion->debito->CellAttributes() ?>>
<span id="el_cuenta_transaccion_debito">
<input type="text" data-field="x_debito" name="x_debito" id="x_debito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->debito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->debito->EditValue ?>"<?php echo $cuenta_transaccion->debito->EditAttributes() ?>>
</span>
<?php echo $cuenta_transaccion->debito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_transaccion->credito->Visible) { // credito ?>
	<div id="r_credito" class="form-group">
		<label id="elh_cuenta_transaccion_credito" for="x_credito" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_transaccion->credito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_transaccion->credito->CellAttributes() ?>>
<span id="el_cuenta_transaccion_credito">
<input type="text" data-field="x_credito" name="x_credito" id="x_credito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_transaccion->credito->PlaceHolder) ?>" value="<?php echo $cuenta_transaccion->credito->EditValue ?>"<?php echo $cuenta_transaccion->credito->EditAttributes() ?>>
</span>
<?php echo $cuenta_transaccion->credito->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcuenta_transaccionadd.Init();
</script>
<?php
$cuenta_transaccion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$cuenta_transaccion_add->Page_Terminate();
?>
