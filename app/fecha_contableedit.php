<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "fecha_contableinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "periodo_contableinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$fecha_contable_edit = NULL; // Initialize page object first

class cfecha_contable_edit extends cfecha_contable {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'fecha_contable';

	// Page object name
	var $PageObjName = 'fecha_contable_edit';

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

		// Table object (fecha_contable)
		if (!isset($GLOBALS["fecha_contable"]) || get_class($GLOBALS["fecha_contable"]) == "cfecha_contable") {
			$GLOBALS["fecha_contable"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["fecha_contable"];
		}

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fecha_contable', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("fecha_contablelist.php"));
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
		global $EW_EXPORT, $fecha_contable;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($fecha_contable);
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
		if (@$_GET["idfecha_contable"] <> "") {
			$this->idfecha_contable->setQueryStringValue($_GET["idfecha_contable"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		if ($this->idfecha_contable->CurrentValue == "")
			$this->Page_Terminate("fecha_contablelist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("fecha_contablelist.php"); // No matching record, return to list
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
		if (!$this->estado_documento_debito->FldIsDetailKey) {
			$this->estado_documento_debito->setFormValue($objForm->GetValue("x_estado_documento_debito"));
		}
		if (!$this->estado_documento_credito->FldIsDetailKey) {
			$this->estado_documento_credito->setFormValue($objForm->GetValue("x_estado_documento_credito"));
		}
		if (!$this->estado_pago_cliente->FldIsDetailKey) {
			$this->estado_pago_cliente->setFormValue($objForm->GetValue("x_estado_pago_cliente"));
		}
		if (!$this->estado_pago_proveedor->FldIsDetailKey) {
			$this->estado_pago_proveedor->setFormValue($objForm->GetValue("x_estado_pago_proveedor"));
		}
		if (!$this->idempresa->FldIsDetailKey) {
			$this->idempresa->setFormValue($objForm->GetValue("x_idempresa"));
		}
		if (!$this->idfecha_contable->FldIsDetailKey)
			$this->idfecha_contable->setFormValue($objForm->GetValue("x_idfecha_contable"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idfecha_contable->CurrentValue = $this->idfecha_contable->FormValue;
		$this->estado_documento_debito->CurrentValue = $this->estado_documento_debito->FormValue;
		$this->estado_documento_credito->CurrentValue = $this->estado_documento_credito->FormValue;
		$this->estado_pago_cliente->CurrentValue = $this->estado_pago_cliente->FormValue;
		$this->estado_pago_proveedor->CurrentValue = $this->estado_pago_proveedor->FormValue;
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
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
		$this->idfecha_contable->setDbValue($rs->fields('idfecha_contable'));
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->estado_documento_debito->setDbValue($rs->fields('estado_documento_debito'));
		$this->estado_documento_credito->setDbValue($rs->fields('estado_documento_credito'));
		$this->estado_pago_cliente->setDbValue($rs->fields('estado_pago_cliente'));
		$this->estado_pago_proveedor->setDbValue($rs->fields('estado_pago_proveedor'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idfecha_contable->DbValue = $row['idfecha_contable'];
		$this->idperiodo_contable->DbValue = $row['idperiodo_contable'];
		$this->fecha->DbValue = $row['fecha'];
		$this->estado_documento_debito->DbValue = $row['estado_documento_debito'];
		$this->estado_documento_credito->DbValue = $row['estado_documento_credito'];
		$this->estado_pago_cliente->DbValue = $row['estado_pago_cliente'];
		$this->estado_pago_proveedor->DbValue = $row['estado_pago_proveedor'];
		$this->idempresa->DbValue = $row['idempresa'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idfecha_contable
		// idperiodo_contable
		// fecha
		// estado_documento_debito
		// estado_documento_credito
		// estado_pago_cliente
		// estado_pago_proveedor
		// idempresa

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idfecha_contable
			$this->idfecha_contable->ViewValue = $this->idfecha_contable->CurrentValue;
			$this->idfecha_contable->ViewCustomAttributes = "";

			// idperiodo_contable
			if (strval($this->idperiodo_contable->CurrentValue) <> "") {
				$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `mes`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idperiodo_contable->ViewValue = $rswrk->fields('DispFld');
					$this->idperiodo_contable->ViewValue .= ew_ValueSeparator(1,$this->idperiodo_contable) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->CurrentValue;
				}
			} else {
				$this->idperiodo_contable->ViewValue = NULL;
			}
			$this->idperiodo_contable->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// estado_documento_debito
			if (strval($this->estado_documento_debito->CurrentValue) <> "") {
				switch ($this->estado_documento_debito->CurrentValue) {
					case $this->estado_documento_debito->FldTagValue(1):
						$this->estado_documento_debito->ViewValue = $this->estado_documento_debito->FldTagCaption(1) <> "" ? $this->estado_documento_debito->FldTagCaption(1) : $this->estado_documento_debito->CurrentValue;
						break;
					case $this->estado_documento_debito->FldTagValue(2):
						$this->estado_documento_debito->ViewValue = $this->estado_documento_debito->FldTagCaption(2) <> "" ? $this->estado_documento_debito->FldTagCaption(2) : $this->estado_documento_debito->CurrentValue;
						break;
					case $this->estado_documento_debito->FldTagValue(3):
						$this->estado_documento_debito->ViewValue = $this->estado_documento_debito->FldTagCaption(3) <> "" ? $this->estado_documento_debito->FldTagCaption(3) : $this->estado_documento_debito->CurrentValue;
						break;
					case $this->estado_documento_debito->FldTagValue(4):
						$this->estado_documento_debito->ViewValue = $this->estado_documento_debito->FldTagCaption(4) <> "" ? $this->estado_documento_debito->FldTagCaption(4) : $this->estado_documento_debito->CurrentValue;
						break;
					default:
						$this->estado_documento_debito->ViewValue = $this->estado_documento_debito->CurrentValue;
				}
			} else {
				$this->estado_documento_debito->ViewValue = NULL;
			}
			$this->estado_documento_debito->ViewCustomAttributes = "";

			// estado_documento_credito
			if (strval($this->estado_documento_credito->CurrentValue) <> "") {
				switch ($this->estado_documento_credito->CurrentValue) {
					case $this->estado_documento_credito->FldTagValue(1):
						$this->estado_documento_credito->ViewValue = $this->estado_documento_credito->FldTagCaption(1) <> "" ? $this->estado_documento_credito->FldTagCaption(1) : $this->estado_documento_credito->CurrentValue;
						break;
					case $this->estado_documento_credito->FldTagValue(2):
						$this->estado_documento_credito->ViewValue = $this->estado_documento_credito->FldTagCaption(2) <> "" ? $this->estado_documento_credito->FldTagCaption(2) : $this->estado_documento_credito->CurrentValue;
						break;
					case $this->estado_documento_credito->FldTagValue(3):
						$this->estado_documento_credito->ViewValue = $this->estado_documento_credito->FldTagCaption(3) <> "" ? $this->estado_documento_credito->FldTagCaption(3) : $this->estado_documento_credito->CurrentValue;
						break;
					case $this->estado_documento_credito->FldTagValue(4):
						$this->estado_documento_credito->ViewValue = $this->estado_documento_credito->FldTagCaption(4) <> "" ? $this->estado_documento_credito->FldTagCaption(4) : $this->estado_documento_credito->CurrentValue;
						break;
					default:
						$this->estado_documento_credito->ViewValue = $this->estado_documento_credito->CurrentValue;
				}
			} else {
				$this->estado_documento_credito->ViewValue = NULL;
			}
			$this->estado_documento_credito->ViewCustomAttributes = "";

			// estado_pago_cliente
			if (strval($this->estado_pago_cliente->CurrentValue) <> "") {
				switch ($this->estado_pago_cliente->CurrentValue) {
					case $this->estado_pago_cliente->FldTagValue(1):
						$this->estado_pago_cliente->ViewValue = $this->estado_pago_cliente->FldTagCaption(1) <> "" ? $this->estado_pago_cliente->FldTagCaption(1) : $this->estado_pago_cliente->CurrentValue;
						break;
					case $this->estado_pago_cliente->FldTagValue(2):
						$this->estado_pago_cliente->ViewValue = $this->estado_pago_cliente->FldTagCaption(2) <> "" ? $this->estado_pago_cliente->FldTagCaption(2) : $this->estado_pago_cliente->CurrentValue;
						break;
					case $this->estado_pago_cliente->FldTagValue(3):
						$this->estado_pago_cliente->ViewValue = $this->estado_pago_cliente->FldTagCaption(3) <> "" ? $this->estado_pago_cliente->FldTagCaption(3) : $this->estado_pago_cliente->CurrentValue;
						break;
					case $this->estado_pago_cliente->FldTagValue(4):
						$this->estado_pago_cliente->ViewValue = $this->estado_pago_cliente->FldTagCaption(4) <> "" ? $this->estado_pago_cliente->FldTagCaption(4) : $this->estado_pago_cliente->CurrentValue;
						break;
					default:
						$this->estado_pago_cliente->ViewValue = $this->estado_pago_cliente->CurrentValue;
				}
			} else {
				$this->estado_pago_cliente->ViewValue = NULL;
			}
			$this->estado_pago_cliente->ViewCustomAttributes = "";

			// estado_pago_proveedor
			if (strval($this->estado_pago_proveedor->CurrentValue) <> "") {
				switch ($this->estado_pago_proveedor->CurrentValue) {
					case $this->estado_pago_proveedor->FldTagValue(1):
						$this->estado_pago_proveedor->ViewValue = $this->estado_pago_proveedor->FldTagCaption(1) <> "" ? $this->estado_pago_proveedor->FldTagCaption(1) : $this->estado_pago_proveedor->CurrentValue;
						break;
					case $this->estado_pago_proveedor->FldTagValue(2):
						$this->estado_pago_proveedor->ViewValue = $this->estado_pago_proveedor->FldTagCaption(2) <> "" ? $this->estado_pago_proveedor->FldTagCaption(2) : $this->estado_pago_proveedor->CurrentValue;
						break;
					case $this->estado_pago_proveedor->FldTagValue(3):
						$this->estado_pago_proveedor->ViewValue = $this->estado_pago_proveedor->FldTagCaption(3) <> "" ? $this->estado_pago_proveedor->FldTagCaption(3) : $this->estado_pago_proveedor->CurrentValue;
						break;
					case $this->estado_pago_proveedor->FldTagValue(4):
						$this->estado_pago_proveedor->ViewValue = $this->estado_pago_proveedor->FldTagCaption(4) <> "" ? $this->estado_pago_proveedor->FldTagCaption(4) : $this->estado_pago_proveedor->CurrentValue;
						break;
					default:
						$this->estado_pago_proveedor->ViewValue = $this->estado_pago_proveedor->CurrentValue;
				}
			} else {
				$this->estado_pago_proveedor->ViewValue = NULL;
			}
			$this->estado_pago_proveedor->ViewCustomAttributes = "";

			// idempresa
			if (strval($this->idempresa->CurrentValue) <> "") {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idempresa->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
				}
			} else {
				$this->idempresa->ViewValue = NULL;
			}
			$this->idempresa->ViewCustomAttributes = "";

			// estado_documento_debito
			$this->estado_documento_debito->LinkCustomAttributes = "";
			$this->estado_documento_debito->HrefValue = "";
			$this->estado_documento_debito->TooltipValue = "";

			// estado_documento_credito
			$this->estado_documento_credito->LinkCustomAttributes = "";
			$this->estado_documento_credito->HrefValue = "";
			$this->estado_documento_credito->TooltipValue = "";

			// estado_pago_cliente
			$this->estado_pago_cliente->LinkCustomAttributes = "";
			$this->estado_pago_cliente->HrefValue = "";
			$this->estado_pago_cliente->TooltipValue = "";

			// estado_pago_proveedor
			$this->estado_pago_proveedor->LinkCustomAttributes = "";
			$this->estado_pago_proveedor->HrefValue = "";
			$this->estado_pago_proveedor->TooltipValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// estado_documento_debito
			$this->estado_documento_debito->EditAttrs["class"] = "form-control";
			$this->estado_documento_debito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(1), $this->estado_documento_debito->FldTagCaption(1) <> "" ? $this->estado_documento_debito->FldTagCaption(1) : $this->estado_documento_debito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(2), $this->estado_documento_debito->FldTagCaption(2) <> "" ? $this->estado_documento_debito->FldTagCaption(2) : $this->estado_documento_debito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(3), $this->estado_documento_debito->FldTagCaption(3) <> "" ? $this->estado_documento_debito->FldTagCaption(3) : $this->estado_documento_debito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(4), $this->estado_documento_debito->FldTagCaption(4) <> "" ? $this->estado_documento_debito->FldTagCaption(4) : $this->estado_documento_debito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_debito->EditValue = $arwrk;

			// estado_documento_credito
			$this->estado_documento_credito->EditAttrs["class"] = "form-control";
			$this->estado_documento_credito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(1), $this->estado_documento_credito->FldTagCaption(1) <> "" ? $this->estado_documento_credito->FldTagCaption(1) : $this->estado_documento_credito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(2), $this->estado_documento_credito->FldTagCaption(2) <> "" ? $this->estado_documento_credito->FldTagCaption(2) : $this->estado_documento_credito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(3), $this->estado_documento_credito->FldTagCaption(3) <> "" ? $this->estado_documento_credito->FldTagCaption(3) : $this->estado_documento_credito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(4), $this->estado_documento_credito->FldTagCaption(4) <> "" ? $this->estado_documento_credito->FldTagCaption(4) : $this->estado_documento_credito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_credito->EditValue = $arwrk;

			// estado_pago_cliente
			$this->estado_pago_cliente->EditAttrs["class"] = "form-control";
			$this->estado_pago_cliente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(1), $this->estado_pago_cliente->FldTagCaption(1) <> "" ? $this->estado_pago_cliente->FldTagCaption(1) : $this->estado_pago_cliente->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(2), $this->estado_pago_cliente->FldTagCaption(2) <> "" ? $this->estado_pago_cliente->FldTagCaption(2) : $this->estado_pago_cliente->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(3), $this->estado_pago_cliente->FldTagCaption(3) <> "" ? $this->estado_pago_cliente->FldTagCaption(3) : $this->estado_pago_cliente->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(4), $this->estado_pago_cliente->FldTagCaption(4) <> "" ? $this->estado_pago_cliente->FldTagCaption(4) : $this->estado_pago_cliente->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_cliente->EditValue = $arwrk;

			// estado_pago_proveedor
			$this->estado_pago_proveedor->EditAttrs["class"] = "form-control";
			$this->estado_pago_proveedor->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(1), $this->estado_pago_proveedor->FldTagCaption(1) <> "" ? $this->estado_pago_proveedor->FldTagCaption(1) : $this->estado_pago_proveedor->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(2), $this->estado_pago_proveedor->FldTagCaption(2) <> "" ? $this->estado_pago_proveedor->FldTagCaption(2) : $this->estado_pago_proveedor->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(3), $this->estado_pago_proveedor->FldTagCaption(3) <> "" ? $this->estado_pago_proveedor->FldTagCaption(3) : $this->estado_pago_proveedor->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(4), $this->estado_pago_proveedor->FldTagCaption(4) <> "" ? $this->estado_pago_proveedor->FldTagCaption(4) : $this->estado_pago_proveedor->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_proveedor->EditValue = $arwrk;

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;

			// Edit refer script
			// estado_documento_debito

			$this->estado_documento_debito->HrefValue = "";

			// estado_documento_credito
			$this->estado_documento_credito->HrefValue = "";

			// estado_pago_cliente
			$this->estado_pago_cliente->HrefValue = "";

			// estado_pago_proveedor
			$this->estado_pago_proveedor->HrefValue = "";

			// idempresa
			$this->idempresa->HrefValue = "";
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
		if (!$this->estado_documento_debito->FldIsDetailKey && !is_null($this->estado_documento_debito->FormValue) && $this->estado_documento_debito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento_debito->FldCaption(), $this->estado_documento_debito->ReqErrMsg));
		}
		if (!$this->estado_documento_credito->FldIsDetailKey && !is_null($this->estado_documento_credito->FormValue) && $this->estado_documento_credito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento_credito->FldCaption(), $this->estado_documento_credito->ReqErrMsg));
		}
		if (!$this->estado_pago_cliente->FldIsDetailKey && !is_null($this->estado_pago_cliente->FormValue) && $this->estado_pago_cliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_pago_cliente->FldCaption(), $this->estado_pago_cliente->ReqErrMsg));
		}
		if (!$this->estado_pago_proveedor->FldIsDetailKey && !is_null($this->estado_pago_proveedor->FormValue) && $this->estado_pago_proveedor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_pago_proveedor->FldCaption(), $this->estado_pago_proveedor->ReqErrMsg));
		}
		if (!$this->idempresa->FldIsDetailKey && !is_null($this->idempresa->FormValue) && $this->idempresa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempresa->FldCaption(), $this->idempresa->ReqErrMsg));
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

			// estado_documento_debito
			$this->estado_documento_debito->SetDbValueDef($rsnew, $this->estado_documento_debito->CurrentValue, "", $this->estado_documento_debito->ReadOnly);

			// estado_documento_credito
			$this->estado_documento_credito->SetDbValueDef($rsnew, $this->estado_documento_credito->CurrentValue, "", $this->estado_documento_credito->ReadOnly);

			// estado_pago_cliente
			$this->estado_pago_cliente->SetDbValueDef($rsnew, $this->estado_pago_cliente->CurrentValue, "", $this->estado_pago_cliente->ReadOnly);

			// estado_pago_proveedor
			$this->estado_pago_proveedor->SetDbValueDef($rsnew, $this->estado_pago_proveedor->CurrentValue, "", $this->estado_pago_proveedor->ReadOnly);

			// idempresa
			$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, $this->idempresa->ReadOnly);

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
			if ($sMasterTblVar == "periodo_contable") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idperiodo_contable"] <> "") {
					$GLOBALS["periodo_contable"]->idperiodo_contable->setQueryStringValue($_GET["fk_idperiodo_contable"]);
					$this->idperiodo_contable->setQueryStringValue($GLOBALS["periodo_contable"]->idperiodo_contable->QueryStringValue);
					$this->idperiodo_contable->setSessionValue($this->idperiodo_contable->QueryStringValue);
					if (!is_numeric($GLOBALS["periodo_contable"]->idperiodo_contable->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "periodo_contable") {
				if ($this->idperiodo_contable->QueryStringValue == "") $this->idperiodo_contable->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "fecha_contablelist.php", "", $this->TableVar, TRUE);
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
if (!isset($fecha_contable_edit)) $fecha_contable_edit = new cfecha_contable_edit();

// Page init
$fecha_contable_edit->Page_Init();

// Page main
$fecha_contable_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fecha_contable_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var fecha_contable_edit = new ew_Page("fecha_contable_edit");
fecha_contable_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = fecha_contable_edit.PageID; // For backward compatibility

// Form object
var ffecha_contableedit = new ew_Form("ffecha_contableedit");

// Validate form
ffecha_contableedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_estado_documento_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_debito->FldCaption(), $fecha_contable->estado_documento_debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_credito->FldCaption(), $fecha_contable->estado_documento_credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_cliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_cliente->FldCaption(), $fecha_contable->estado_pago_cliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_proveedor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_proveedor->FldCaption(), $fecha_contable->estado_pago_proveedor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->idempresa->FldCaption(), $fecha_contable->idempresa->ReqErrMsg)) ?>");

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
ffecha_contableedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffecha_contableedit.ValidateRequired = true;
<?php } else { ?>
ffecha_contableedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffecha_contableedit.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $fecha_contable_edit->ShowPageHeader(); ?>
<?php
$fecha_contable_edit->ShowMessage();
?>
<form name="ffecha_contableedit" id="ffecha_contableedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($fecha_contable_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $fecha_contable_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fecha_contable">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
	<div id="r_estado_documento_debito" class="form-group">
		<label id="elh_fecha_contable_estado_documento_debito" for="x_estado_documento_debito" class="col-sm-2 control-label ewLabel"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $fecha_contable->estado_documento_debito->CellAttributes() ?>>
<span id="el_fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x_estado_documento_debito" name="x_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $fecha_contable->estado_documento_debito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
	<div id="r_estado_documento_credito" class="form-group">
		<label id="elh_fecha_contable_estado_documento_credito" for="x_estado_documento_credito" class="col-sm-2 control-label ewLabel"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $fecha_contable->estado_documento_credito->CellAttributes() ?>>
<span id="el_fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x_estado_documento_credito" name="x_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $fecha_contable->estado_documento_credito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
	<div id="r_estado_pago_cliente" class="form-group">
		<label id="elh_fecha_contable_estado_pago_cliente" for="x_estado_pago_cliente" class="col-sm-2 control-label ewLabel"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $fecha_contable->estado_pago_cliente->CellAttributes() ?>>
<span id="el_fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x_estado_pago_cliente" name="x_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $fecha_contable->estado_pago_cliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
	<div id="r_estado_pago_proveedor" class="form-group">
		<label id="elh_fecha_contable_estado_pago_proveedor" for="x_estado_pago_proveedor" class="col-sm-2 control-label ewLabel"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $fecha_contable->estado_pago_proveedor->CellAttributes() ?>>
<span id="el_fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x_estado_pago_proveedor" name="x_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $fecha_contable->estado_pago_proveedor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label id="elh_fecha_contable_idempresa" for="x_idempresa" class="col-sm-2 control-label ewLabel"><?php echo $fecha_contable->idempresa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $fecha_contable->idempresa->CellAttributes() ?>>
<span id="el_fecha_contable_idempresa">
<select data-field="x_idempresa" id="x_idempresa" name="x_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $fecha_contable->idempresa->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_idfecha_contable" name="x_idfecha_contable" id="x_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
ffecha_contableedit.Init();
</script>
<?php
$fecha_contable_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$fecha_contable_edit->Page_Terminate();
?>
