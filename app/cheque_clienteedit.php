<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cheque_clienteinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "pago_clientegridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$cheque_cliente_edit = NULL; // Initialize page object first

class ccheque_cliente_edit extends ccheque_cliente {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'cheque_cliente';

	// Page object name
	var $PageObjName = 'cheque_cliente_edit';

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

		// Table object (cheque_cliente)
		if (!isset($GLOBALS["cheque_cliente"]) || get_class($GLOBALS["cheque_cliente"]) == "ccheque_cliente") {
			$GLOBALS["cheque_cliente"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cheque_cliente"];
		}

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cheque_cliente', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("cheque_clientelist.php"));
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

			// Process auto fill for detail table 'pago_cliente'
			if (@$_POST["grid"] == "fpago_clientegrid") {
				if (!isset($GLOBALS["pago_cliente_grid"])) $GLOBALS["pago_cliente_grid"] = new cpago_cliente_grid;
				$GLOBALS["pago_cliente_grid"]->Page_Init();
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
		global $EW_EXPORT, $cheque_cliente;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cheque_cliente);
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
		if (@$_GET["idcheque_cliente"] <> "") {
			$this->idcheque_cliente->setQueryStringValue($_GET["idcheque_cliente"]);
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
		if ($this->idcheque_cliente->CurrentValue == "")
			$this->Page_Terminate("cheque_clientelist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cheque_clientelist.php"); // No matching record, return to list
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
		if (!$this->numero->FldIsDetailKey) {
			$this->numero->setFormValue($objForm->GetValue("x_numero"));
		}
		if (!$this->propietario->FldIsDetailKey) {
			$this->propietario->setFormValue($objForm->GetValue("x_propietario"));
		}
		if (!$this->cuenta->FldIsDetailKey) {
			$this->cuenta->setFormValue($objForm->GetValue("x_cuenta"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->descripcion->FldIsDetailKey) {
			$this->descripcion->setFormValue($objForm->GetValue("x_descripcion"));
		}
		if (!$this->cheque_estado->FldIsDetailKey) {
			$this->cheque_estado->setFormValue($objForm->GetValue("x_cheque_estado"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idcheque_cliente->FldIsDetailKey)
			$this->idcheque_cliente->setFormValue($objForm->GetValue("x_idcheque_cliente"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idcheque_cliente->CurrentValue = $this->idcheque_cliente->FormValue;
		$this->numero->CurrentValue = $this->numero->FormValue;
		$this->propietario->CurrentValue = $this->propietario->FormValue;
		$this->cuenta->CurrentValue = $this->cuenta->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->descripcion->CurrentValue = $this->descripcion->FormValue;
		$this->cheque_estado->CurrentValue = $this->cheque_estado->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
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
		$this->idcheque_cliente->setDbValue($rs->fields('idcheque_cliente'));
		$this->idbanco->setDbValue($rs->fields('idbanco'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->propietario->setDbValue($rs->fields('propietario'));
		$this->cuenta->setDbValue($rs->fields('cuenta'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->cheque_estado->setDbValue($rs->fields('cheque_estado'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcheque_cliente->DbValue = $row['idcheque_cliente'];
		$this->idbanco->DbValue = $row['idbanco'];
		$this->numero->DbValue = $row['numero'];
		$this->propietario->DbValue = $row['propietario'];
		$this->cuenta->DbValue = $row['cuenta'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha->DbValue = $row['fecha'];
		$this->descripcion->DbValue = $row['descripcion'];
		$this->cheque_estado->DbValue = $row['cheque_estado'];
		$this->estado->DbValue = $row['estado'];
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
		// idcheque_cliente
		// idbanco
		// numero
		// propietario
		// cuenta
		// monto
		// fecha
		// descripcion
		// cheque_estado
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcheque_cliente
			$this->idcheque_cliente->ViewValue = $this->idcheque_cliente->CurrentValue;
			$this->idcheque_cliente->ViewCustomAttributes = "";

			// idbanco
			if (strval($this->idbanco->CurrentValue) <> "") {
				$sFilterWrk = "`idbanco`" . ew_SearchString("=", $this->idbanco->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idbanco, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idbanco->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idbanco->ViewValue = $this->idbanco->CurrentValue;
				}
			} else {
				$this->idbanco->ViewValue = NULL;
			}
			$this->idbanco->ViewCustomAttributes = "";

			// numero
			$this->numero->ViewValue = $this->numero->CurrentValue;
			$this->numero->ViewCustomAttributes = "";

			// propietario
			$this->propietario->ViewValue = $this->propietario->CurrentValue;
			$this->propietario->ViewCustomAttributes = "";

			// cuenta
			$this->cuenta->ViewValue = $this->cuenta->CurrentValue;
			$this->cuenta->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// descripcion
			$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
			$this->descripcion->ViewCustomAttributes = "";

			// cheque_estado
			if (strval($this->cheque_estado->CurrentValue) <> "") {
				switch ($this->cheque_estado->CurrentValue) {
					case $this->cheque_estado->FldTagValue(1):
						$this->cheque_estado->ViewValue = $this->cheque_estado->FldTagCaption(1) <> "" ? $this->cheque_estado->FldTagCaption(1) : $this->cheque_estado->CurrentValue;
						break;
					case $this->cheque_estado->FldTagValue(2):
						$this->cheque_estado->ViewValue = $this->cheque_estado->FldTagCaption(2) <> "" ? $this->cheque_estado->FldTagCaption(2) : $this->cheque_estado->CurrentValue;
						break;
					case $this->cheque_estado->FldTagValue(3):
						$this->cheque_estado->ViewValue = $this->cheque_estado->FldTagCaption(3) <> "" ? $this->cheque_estado->FldTagCaption(3) : $this->cheque_estado->CurrentValue;
						break;
					default:
						$this->cheque_estado->ViewValue = $this->cheque_estado->CurrentValue;
				}
			} else {
				$this->cheque_estado->ViewValue = NULL;
			}
			$this->cheque_estado->ViewCustomAttributes = "";

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

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";
			$this->numero->TooltipValue = "";

			// propietario
			$this->propietario->LinkCustomAttributes = "";
			$this->propietario->HrefValue = "";
			$this->propietario->TooltipValue = "";

			// cuenta
			$this->cuenta->LinkCustomAttributes = "";
			$this->cuenta->HrefValue = "";
			$this->cuenta->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";

			// cheque_estado
			$this->cheque_estado->LinkCustomAttributes = "";
			$this->cheque_estado->HrefValue = "";
			$this->cheque_estado->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// numero
			$this->numero->EditAttrs["class"] = "form-control";
			$this->numero->EditCustomAttributes = "";
			$this->numero->EditValue = ew_HtmlEncode($this->numero->CurrentValue);
			$this->numero->PlaceHolder = ew_RemoveHtml($this->numero->FldCaption());

			// propietario
			$this->propietario->EditAttrs["class"] = "form-control";
			$this->propietario->EditCustomAttributes = "";
			$this->propietario->EditValue = ew_HtmlEncode($this->propietario->CurrentValue);
			$this->propietario->PlaceHolder = ew_RemoveHtml($this->propietario->FldCaption());

			// cuenta
			$this->cuenta->EditAttrs["class"] = "form-control";
			$this->cuenta->EditCustomAttributes = "";
			$this->cuenta->EditValue = ew_HtmlEncode($this->cuenta->CurrentValue);
			$this->cuenta->PlaceHolder = ew_RemoveHtml($this->cuenta->FldCaption());

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

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

			// cheque_estado
			$this->cheque_estado->EditAttrs["class"] = "form-control";
			$this->cheque_estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->cheque_estado->FldTagValue(1), $this->cheque_estado->FldTagCaption(1) <> "" ? $this->cheque_estado->FldTagCaption(1) : $this->cheque_estado->FldTagValue(1));
			$arwrk[] = array($this->cheque_estado->FldTagValue(2), $this->cheque_estado->FldTagCaption(2) <> "" ? $this->cheque_estado->FldTagCaption(2) : $this->cheque_estado->FldTagValue(2));
			$arwrk[] = array($this->cheque_estado->FldTagValue(3), $this->cheque_estado->FldTagCaption(3) <> "" ? $this->cheque_estado->FldTagCaption(3) : $this->cheque_estado->FldTagValue(3));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->cheque_estado->EditValue = $arwrk;

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// Edit refer script
			// numero

			$this->numero->HrefValue = "";

			// propietario
			$this->propietario->HrefValue = "";

			// cuenta
			$this->cuenta->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// descripcion
			$this->descripcion->HrefValue = "";

			// cheque_estado
			$this->cheque_estado->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";
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
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->cheque_estado->FldIsDetailKey && !is_null($this->cheque_estado->FormValue) && $this->cheque_estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cheque_estado->FldCaption(), $this->cheque_estado->ReqErrMsg));
		}
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("pago_cliente", $DetailTblVar) && $GLOBALS["pago_cliente"]->DetailEdit) {
			if (!isset($GLOBALS["pago_cliente_grid"])) $GLOBALS["pago_cliente_grid"] = new cpago_cliente_grid(); // get detail page object
			$GLOBALS["pago_cliente_grid"]->ValidateGridForm();
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

			// numero
			$this->numero->SetDbValueDef($rsnew, $this->numero->CurrentValue, NULL, $this->numero->ReadOnly);

			// propietario
			$this->propietario->SetDbValueDef($rsnew, $this->propietario->CurrentValue, NULL, $this->propietario->ReadOnly);

			// cuenta
			$this->cuenta->SetDbValueDef($rsnew, $this->cuenta->CurrentValue, NULL, $this->cuenta->ReadOnly);

			// monto
			$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, $this->monto->ReadOnly);

			// fecha
			$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, $this->fecha->ReadOnly);

			// descripcion
			$this->descripcion->SetDbValueDef($rsnew, $this->descripcion->CurrentValue, NULL, $this->descripcion->ReadOnly);

			// cheque_estado
			$this->cheque_estado->SetDbValueDef($rsnew, $this->cheque_estado->CurrentValue, "", $this->cheque_estado->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

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
					if (in_array("pago_cliente", $DetailTblVar) && $GLOBALS["pago_cliente"]->DetailEdit) {
						if (!isset($GLOBALS["pago_cliente_grid"])) $GLOBALS["pago_cliente_grid"] = new cpago_cliente_grid(); // Get detail page object
						$EditRow = $GLOBALS["pago_cliente_grid"]->GridUpdate();
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
			if (in_array("pago_cliente", $DetailTblVar)) {
				if (!isset($GLOBALS["pago_cliente_grid"]))
					$GLOBALS["pago_cliente_grid"] = new cpago_cliente_grid;
				if ($GLOBALS["pago_cliente_grid"]->DetailEdit) {
					$GLOBALS["pago_cliente_grid"]->CurrentMode = "edit";
					$GLOBALS["pago_cliente_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["pago_cliente_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["pago_cliente_grid"]->setStartRecordNumber(1);
					$GLOBALS["pago_cliente_grid"]->idcheque_cliente->FldIsDetailKey = TRUE;
					$GLOBALS["pago_cliente_grid"]->idcheque_cliente->CurrentValue = $this->idcheque_cliente->CurrentValue;
					$GLOBALS["pago_cliente_grid"]->idcheque_cliente->setSessionValue($GLOBALS["pago_cliente_grid"]->idcheque_cliente->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "cheque_clientelist.php", "", $this->TableVar, TRUE);
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
if (!isset($cheque_cliente_edit)) $cheque_cliente_edit = new ccheque_cliente_edit();

// Page init
$cheque_cliente_edit->Page_Init();

// Page main
$cheque_cliente_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cheque_cliente_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var cheque_cliente_edit = new ew_Page("cheque_cliente_edit");
cheque_cliente_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cheque_cliente_edit.PageID; // For backward compatibility

// Form object
var fcheque_clienteedit = new ew_Form("fcheque_clienteedit");

// Validate form
fcheque_clienteedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cheque_cliente->monto->FldCaption(), $cheque_cliente->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cheque_cliente->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cheque_cliente->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cheque_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cheque_cliente->cheque_estado->FldCaption(), $cheque_cliente->cheque_estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cheque_cliente->estado->FldCaption(), $cheque_cliente->estado->ReqErrMsg)) ?>");

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
fcheque_clienteedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcheque_clienteedit.ValidateRequired = true;
<?php } else { ?>
fcheque_clienteedit.ValidateRequired = false; 
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
<?php $cheque_cliente_edit->ShowPageHeader(); ?>
<?php
$cheque_cliente_edit->ShowMessage();
?>
<form name="fcheque_clienteedit" id="fcheque_clienteedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cheque_cliente_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cheque_cliente_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cheque_cliente">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($cheque_cliente->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group">
		<label id="elh_cheque_cliente_numero" for="x_numero" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->numero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->numero->CellAttributes() ?>>
<span id="el_cheque_cliente_numero">
<input type="text" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->numero->PlaceHolder) ?>" value="<?php echo $cheque_cliente->numero->EditValue ?>"<?php echo $cheque_cliente->numero->EditAttributes() ?>>
</span>
<?php echo $cheque_cliente->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->propietario->Visible) { // propietario ?>
	<div id="r_propietario" class="form-group">
		<label id="elh_cheque_cliente_propietario" for="x_propietario" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->propietario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->propietario->CellAttributes() ?>>
<span id="el_cheque_cliente_propietario">
<input type="text" data-field="x_propietario" name="x_propietario" id="x_propietario" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->propietario->PlaceHolder) ?>" value="<?php echo $cheque_cliente->propietario->EditValue ?>"<?php echo $cheque_cliente->propietario->EditAttributes() ?>>
</span>
<?php echo $cheque_cliente->propietario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->cuenta->Visible) { // cuenta ?>
	<div id="r_cuenta" class="form-group">
		<label id="elh_cheque_cliente_cuenta" for="x_cuenta" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->cuenta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->cuenta->CellAttributes() ?>>
<span id="el_cheque_cliente_cuenta">
<input type="text" data-field="x_cuenta" name="x_cuenta" id="x_cuenta" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->cuenta->PlaceHolder) ?>" value="<?php echo $cheque_cliente->cuenta->EditValue ?>"<?php echo $cheque_cliente->cuenta->EditAttributes() ?>>
</span>
<?php echo $cheque_cliente->cuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_cheque_cliente_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->monto->CellAttributes() ?>>
<span id="el_cheque_cliente_monto">
<input type="text" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->monto->PlaceHolder) ?>" value="<?php echo $cheque_cliente->monto->EditValue ?>"<?php echo $cheque_cliente->monto->EditAttributes() ?>>
</span>
<?php echo $cheque_cliente->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_cheque_cliente_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->fecha->CellAttributes() ?>>
<span id="el_cheque_cliente_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->fecha->PlaceHolder) ?>" value="<?php echo $cheque_cliente->fecha->EditValue ?>"<?php echo $cheque_cliente->fecha->EditAttributes() ?>>
<?php if (!$cheque_cliente->fecha->ReadOnly && !$cheque_cliente->fecha->Disabled && @$cheque_cliente->fecha->EditAttrs["readonly"] == "" && @$cheque_cliente->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcheque_clienteedit", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $cheque_cliente->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->descripcion->Visible) { // descripcion ?>
	<div id="r_descripcion" class="form-group">
		<label id="elh_cheque_cliente_descripcion" for="x_descripcion" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->descripcion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->descripcion->CellAttributes() ?>>
<span id="el_cheque_cliente_descripcion">
<input type="text" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cheque_cliente->descripcion->PlaceHolder) ?>" value="<?php echo $cheque_cliente->descripcion->EditValue ?>"<?php echo $cheque_cliente->descripcion->EditAttributes() ?>>
</span>
<?php echo $cheque_cliente->descripcion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->cheque_estado->Visible) { // cheque_estado ?>
	<div id="r_cheque_estado" class="form-group">
		<label id="elh_cheque_cliente_cheque_estado" for="x_cheque_estado" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->cheque_estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->cheque_estado->CellAttributes() ?>>
<span id="el_cheque_cliente_cheque_estado">
<select data-field="x_cheque_estado" id="x_cheque_estado" name="x_cheque_estado"<?php echo $cheque_cliente->cheque_estado->EditAttributes() ?>>
<?php
if (is_array($cheque_cliente->cheque_estado->EditValue)) {
	$arwrk = $cheque_cliente->cheque_estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cheque_cliente->cheque_estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $cheque_cliente->cheque_estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cheque_cliente->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_cheque_cliente_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $cheque_cliente->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cheque_cliente->estado->CellAttributes() ?>>
<span id="el_cheque_cliente_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $cheque_cliente->estado->EditAttributes() ?>>
<?php
if (is_array($cheque_cliente->estado->EditValue)) {
	$arwrk = $cheque_cliente->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cheque_cliente->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $cheque_cliente->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_idcheque_cliente" name="x_idcheque_cliente" id="x_idcheque_cliente" value="<?php echo ew_HtmlEncode($cheque_cliente->idcheque_cliente->CurrentValue) ?>">
<?php
	if (in_array("pago_cliente", explode(",", $cheque_cliente->getCurrentDetailTable())) && $pago_cliente->DetailEdit) {
?>
<?php if ($cheque_cliente->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("pago_cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "pago_clientegrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcheque_clienteedit.Init();
</script>
<?php
$cheque_cliente_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$cheque_cliente_edit->Page_Terminate();
?>
