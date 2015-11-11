<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "boleta_depositoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "pago_clientegridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$boleta_deposito_add = NULL; // Initialize page object first

class cboleta_deposito_add extends cboleta_deposito {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'boleta_deposito';

	// Page object name
	var $PageObjName = 'boleta_deposito_add';

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

		// Table object (boleta_deposito)
		if (!isset($GLOBALS["boleta_deposito"]) || get_class($GLOBALS["boleta_deposito"]) == "cboleta_deposito") {
			$GLOBALS["boleta_deposito"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["boleta_deposito"];
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
			define("EW_TABLE_NAME", 'boleta_deposito', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("boleta_depositolist.php"));
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
		global $EW_EXPORT, $boleta_deposito;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($boleta_deposito);
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
			if (@$_GET["idboleta_deposito"] != "") {
				$this->idboleta_deposito->setQueryStringValue($_GET["idboleta_deposito"]);
				$this->setKey("idboleta_deposito", $this->idboleta_deposito->CurrentValue); // Set up key
			} else {
				$this->setKey("idboleta_deposito", ""); // Clear key
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
					$this->Page_Terminate("boleta_depositolist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "boleta_depositoview.php")
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
		$this->idbanco->CurrentValue = 1;
		$this->idcuenta->CurrentValue = 1;
		$this->numero->CurrentValue = NULL;
		$this->numero->OldValue = $this->numero->CurrentValue;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->efectivo->CurrentValue = 0.00;
		$this->cheque->CurrentValue = 0.00;
		$this->cheque_otro->CurrentValue = 0.00;
		$this->descripcion->CurrentValue = NULL;
		$this->descripcion->OldValue = $this->descripcion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idbanco->FldIsDetailKey) {
			$this->idbanco->setFormValue($objForm->GetValue("x_idbanco"));
		}
		if (!$this->idcuenta->FldIsDetailKey) {
			$this->idcuenta->setFormValue($objForm->GetValue("x_idcuenta"));
		}
		if (!$this->numero->FldIsDetailKey) {
			$this->numero->setFormValue($objForm->GetValue("x_numero"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->efectivo->FldIsDetailKey) {
			$this->efectivo->setFormValue($objForm->GetValue("x_efectivo"));
		}
		if (!$this->cheque->FldIsDetailKey) {
			$this->cheque->setFormValue($objForm->GetValue("x_cheque"));
		}
		if (!$this->cheque_otro->FldIsDetailKey) {
			$this->cheque_otro->setFormValue($objForm->GetValue("x_cheque_otro"));
		}
		if (!$this->descripcion->FldIsDetailKey) {
			$this->descripcion->setFormValue($objForm->GetValue("x_descripcion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idbanco->CurrentValue = $this->idbanco->FormValue;
		$this->idcuenta->CurrentValue = $this->idcuenta->FormValue;
		$this->numero->CurrentValue = $this->numero->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->efectivo->CurrentValue = $this->efectivo->FormValue;
		$this->cheque->CurrentValue = $this->cheque->FormValue;
		$this->cheque_otro->CurrentValue = $this->cheque_otro->FormValue;
		$this->descripcion->CurrentValue = $this->descripcion->FormValue;
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
		$this->idboleta_deposito->setDbValue($rs->fields('idboleta_deposito'));
		$this->idbanco->setDbValue($rs->fields('idbanco'));
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->efectivo->setDbValue($rs->fields('efectivo'));
		$this->cheque->setDbValue($rs->fields('cheque'));
		$this->cheque_otro->setDbValue($rs->fields('cheque_otro'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idboleta_deposito->DbValue = $row['idboleta_deposito'];
		$this->idbanco->DbValue = $row['idbanco'];
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->numero->DbValue = $row['numero'];
		$this->fecha->DbValue = $row['fecha'];
		$this->efectivo->DbValue = $row['efectivo'];
		$this->cheque->DbValue = $row['cheque'];
		$this->cheque_otro->DbValue = $row['cheque_otro'];
		$this->monto->DbValue = $row['monto'];
		$this->descripcion->DbValue = $row['descripcion'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idboleta_deposito")) <> "")
			$this->idboleta_deposito->CurrentValue = $this->getKey("idboleta_deposito"); // idboleta_deposito
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

		if ($this->efectivo->FormValue == $this->efectivo->CurrentValue && is_numeric(ew_StrToFloat($this->efectivo->CurrentValue)))
			$this->efectivo->CurrentValue = ew_StrToFloat($this->efectivo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->cheque->FormValue == $this->cheque->CurrentValue && is_numeric(ew_StrToFloat($this->cheque->CurrentValue)))
			$this->cheque->CurrentValue = ew_StrToFloat($this->cheque->CurrentValue);

		// Convert decimal values if posted back
		if ($this->cheque_otro->FormValue == $this->cheque_otro->CurrentValue && is_numeric(ew_StrToFloat($this->cheque_otro->CurrentValue)))
			$this->cheque_otro->CurrentValue = ew_StrToFloat($this->cheque_otro->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idboleta_deposito
		// idbanco
		// idcuenta
		// numero
		// fecha
		// efectivo
		// cheque
		// cheque_otro
		// monto
		// descripcion
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idboleta_deposito
			$this->idboleta_deposito->ViewValue = $this->idboleta_deposito->CurrentValue;
			$this->idboleta_deposito->ViewCustomAttributes = "";

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
			$sSqlWrk .= " ORDER BY `nombre`";
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

			// numero
			$this->numero->ViewValue = $this->numero->CurrentValue;
			$this->numero->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// efectivo
			$this->efectivo->ViewValue = $this->efectivo->CurrentValue;
			$this->efectivo->ViewCustomAttributes = "";

			// cheque
			$this->cheque->ViewValue = $this->cheque->CurrentValue;
			$this->cheque->ViewCustomAttributes = "";

			// cheque_otro
			$this->cheque_otro->ViewValue = $this->cheque_otro->CurrentValue;
			$this->cheque_otro->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewCustomAttributes = "";

			// descripcion
			$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
			$this->descripcion->ViewCustomAttributes = "";

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

			// idbanco
			$this->idbanco->LinkCustomAttributes = "";
			$this->idbanco->HrefValue = "";
			$this->idbanco->TooltipValue = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
			$this->idcuenta->TooltipValue = "";

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";
			$this->numero->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// efectivo
			$this->efectivo->LinkCustomAttributes = "";
			$this->efectivo->HrefValue = "";
			$this->efectivo->TooltipValue = "";

			// cheque
			$this->cheque->LinkCustomAttributes = "";
			$this->cheque->HrefValue = "";
			$this->cheque->TooltipValue = "";

			// cheque_otro
			$this->cheque_otro->LinkCustomAttributes = "";
			$this->cheque_otro->HrefValue = "";
			$this->cheque_otro->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idbanco
			$this->idbanco->EditAttrs["class"] = "form-control";
			$this->idbanco->EditCustomAttributes = "";
			if (trim(strval($this->idbanco->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idbanco`" . ew_SearchString("=", $this->idbanco->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `banco`";
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
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idbanco->EditValue = $arwrk;

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
			$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idbanco` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cuenta`";
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

			// numero
			$this->numero->EditAttrs["class"] = "form-control";
			$this->numero->EditCustomAttributes = "";
			$this->numero->EditValue = ew_HtmlEncode($this->numero->CurrentValue);
			$this->numero->PlaceHolder = ew_RemoveHtml($this->numero->FldCaption());

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// efectivo
			$this->efectivo->EditAttrs["class"] = "form-control";
			$this->efectivo->EditCustomAttributes = "";
			$this->efectivo->EditValue = ew_HtmlEncode($this->efectivo->CurrentValue);
			$this->efectivo->PlaceHolder = ew_RemoveHtml($this->efectivo->FldCaption());
			if (strval($this->efectivo->EditValue) <> "" && is_numeric($this->efectivo->EditValue)) $this->efectivo->EditValue = ew_FormatNumber($this->efectivo->EditValue, -2, -1, -2, 0);

			// cheque
			$this->cheque->EditAttrs["class"] = "form-control";
			$this->cheque->EditCustomAttributes = "";
			$this->cheque->EditValue = ew_HtmlEncode($this->cheque->CurrentValue);
			$this->cheque->PlaceHolder = ew_RemoveHtml($this->cheque->FldCaption());
			if (strval($this->cheque->EditValue) <> "" && is_numeric($this->cheque->EditValue)) $this->cheque->EditValue = ew_FormatNumber($this->cheque->EditValue, -2, -1, -2, 0);

			// cheque_otro
			$this->cheque_otro->EditAttrs["class"] = "form-control";
			$this->cheque_otro->EditCustomAttributes = "";
			$this->cheque_otro->EditValue = ew_HtmlEncode($this->cheque_otro->CurrentValue);
			$this->cheque_otro->PlaceHolder = ew_RemoveHtml($this->cheque_otro->FldCaption());
			if (strval($this->cheque_otro->EditValue) <> "" && is_numeric($this->cheque_otro->EditValue)) $this->cheque_otro->EditValue = ew_FormatNumber($this->cheque_otro->EditValue, -2, -1, -2, 0);

			// descripcion
			$this->descripcion->EditAttrs["class"] = "form-control";
			$this->descripcion->EditCustomAttributes = "";
			$this->descripcion->EditValue = ew_HtmlEncode($this->descripcion->CurrentValue);
			$this->descripcion->PlaceHolder = ew_RemoveHtml($this->descripcion->FldCaption());

			// Edit refer script
			// idbanco

			$this->idbanco->HrefValue = "";

			// idcuenta
			$this->idcuenta->HrefValue = "";

			// numero
			$this->numero->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// efectivo
			$this->efectivo->HrefValue = "";

			// cheque
			$this->cheque->HrefValue = "";

			// cheque_otro
			$this->cheque_otro->HrefValue = "";

			// descripcion
			$this->descripcion->HrefValue = "";
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
		if (!$this->idbanco->FldIsDetailKey && !is_null($this->idbanco->FormValue) && $this->idbanco->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idbanco->FldCaption(), $this->idbanco->ReqErrMsg));
		}
		if (!$this->idcuenta->FldIsDetailKey && !is_null($this->idcuenta->FormValue) && $this->idcuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta->FldCaption(), $this->idcuenta->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->efectivo->FldIsDetailKey && !is_null($this->efectivo->FormValue) && $this->efectivo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->efectivo->FldCaption(), $this->efectivo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->efectivo->FormValue)) {
			ew_AddMessage($gsFormError, $this->efectivo->FldErrMsg());
		}
		if (!$this->cheque->FldIsDetailKey && !is_null($this->cheque->FormValue) && $this->cheque->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cheque->FldCaption(), $this->cheque->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->cheque->FormValue)) {
			ew_AddMessage($gsFormError, $this->cheque->FldErrMsg());
		}
		if (!$this->cheque_otro->FldIsDetailKey && !is_null($this->cheque_otro->FormValue) && $this->cheque_otro->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cheque_otro->FldCaption(), $this->cheque_otro->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->cheque_otro->FormValue)) {
			ew_AddMessage($gsFormError, $this->cheque_otro->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("pago_cliente", $DetailTblVar) && $GLOBALS["pago_cliente"]->DetailAdd) {
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

		// idbanco
		$this->idbanco->SetDbValueDef($rsnew, $this->idbanco->CurrentValue, 0, strval($this->idbanco->CurrentValue) == "");

		// idcuenta
		$this->idcuenta->SetDbValueDef($rsnew, $this->idcuenta->CurrentValue, 0, strval($this->idcuenta->CurrentValue) == "");

		// numero
		$this->numero->SetDbValueDef($rsnew, $this->numero->CurrentValue, NULL, FALSE);

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// efectivo
		$this->efectivo->SetDbValueDef($rsnew, $this->efectivo->CurrentValue, 0, strval($this->efectivo->CurrentValue) == "");

		// cheque
		$this->cheque->SetDbValueDef($rsnew, $this->cheque->CurrentValue, 0, strval($this->cheque->CurrentValue) == "");

		// cheque_otro
		$this->cheque_otro->SetDbValueDef($rsnew, $this->cheque_otro->CurrentValue, 0, strval($this->cheque_otro->CurrentValue) == "");

		// descripcion
		$this->descripcion->SetDbValueDef($rsnew, $this->descripcion->CurrentValue, NULL, FALSE);

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
			$this->idboleta_deposito->setDbValue($conn->Insert_ID());
			$rsnew['idboleta_deposito'] = $this->idboleta_deposito->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("pago_cliente", $DetailTblVar) && $GLOBALS["pago_cliente"]->DetailAdd) {
				$GLOBALS["pago_cliente"]->idboleta_deposito->setSessionValue($this->idboleta_deposito->CurrentValue); // Set master key
				if (!isset($GLOBALS["pago_cliente_grid"])) $GLOBALS["pago_cliente_grid"] = new cpago_cliente_grid(); // Get detail page object
				$AddRow = $GLOBALS["pago_cliente_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["pago_cliente"]->idboleta_deposito->setSessionValue(""); // Clear master key if insert failed
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
				if ($GLOBALS["pago_cliente_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["pago_cliente_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["pago_cliente_grid"]->CurrentMode = "add";
					$GLOBALS["pago_cliente_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["pago_cliente_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["pago_cliente_grid"]->setStartRecordNumber(1);
					$GLOBALS["pago_cliente_grid"]->idboleta_deposito->FldIsDetailKey = TRUE;
					$GLOBALS["pago_cliente_grid"]->idboleta_deposito->CurrentValue = $this->idboleta_deposito->CurrentValue;
					$GLOBALS["pago_cliente_grid"]->idboleta_deposito->setSessionValue($GLOBALS["pago_cliente_grid"]->idboleta_deposito->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "boleta_depositolist.php", "", $this->TableVar, TRUE);
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
if (!isset($boleta_deposito_add)) $boleta_deposito_add = new cboleta_deposito_add();

// Page init
$boleta_deposito_add->Page_Init();

// Page main
$boleta_deposito_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$boleta_deposito_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var boleta_deposito_add = new ew_Page("boleta_deposito_add");
boleta_deposito_add.PageID = "add"; // Page ID
var EW_PAGE_ID = boleta_deposito_add.PageID; // For backward compatibility

// Form object
var fboleta_depositoadd = new ew_Form("fboleta_depositoadd");

// Validate form
fboleta_depositoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->idbanco->FldCaption(), $boleta_deposito->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->idcuenta->FldCaption(), $boleta_deposito->idcuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_efectivo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->efectivo->FldCaption(), $boleta_deposito->efectivo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_efectivo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->efectivo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cheque");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->cheque->FldCaption(), $boleta_deposito->cheque->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cheque");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->cheque->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cheque_otro");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $boleta_deposito->cheque_otro->FldCaption(), $boleta_deposito->cheque_otro->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cheque_otro");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($boleta_deposito->cheque_otro->FldErrMsg()) ?>");

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
fboleta_depositoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fboleta_depositoadd.ValidateRequired = true;
<?php } else { ?>
fboleta_depositoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fboleta_depositoadd.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fboleta_depositoadd.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":["x_idbanco"],"FilterFields":["x_idbanco"],"Options":[]};

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
<?php $boleta_deposito_add->ShowPageHeader(); ?>
<?php
$boleta_deposito_add->ShowMessage();
?>
<form name="fboleta_depositoadd" id="fboleta_depositoadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($boleta_deposito_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $boleta_deposito_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="boleta_deposito">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($boleta_deposito->idbanco->Visible) { // idbanco ?>
	<div id="r_idbanco" class="form-group">
		<label id="elh_boleta_deposito_idbanco" for="x_idbanco" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->idbanco->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->idbanco->CellAttributes() ?>>
<span id="el_boleta_deposito_idbanco">
<?php $boleta_deposito->idbanco->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_idcuenta']); " . @$boleta_deposito->idbanco->EditAttrs["onchange"]; ?>
<select data-field="x_idbanco" id="x_idbanco" name="x_idbanco"<?php echo $boleta_deposito->idbanco->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idbanco->EditValue)) {
	$arwrk = $boleta_deposito->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$boleta_deposito->Lookup_Selecting($boleta_deposito->idbanco, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idbanco" id="s_x_idbanco" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbanco` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $boleta_deposito->idbanco->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->idcuenta->Visible) { // idcuenta ?>
	<div id="r_idcuenta" class="form-group">
		<label id="elh_boleta_deposito_idcuenta" for="x_idcuenta" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->idcuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->idcuenta->CellAttributes() ?>>
<?php if ($boleta_deposito->idcuenta->getSessionValue() <> "") { ?>
<span id="el_boleta_deposito_idcuenta">
<span<?php echo $boleta_deposito->idcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $boleta_deposito->idcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcuenta" name="x_idcuenta" value="<?php echo ew_HtmlEncode($boleta_deposito->idcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el_boleta_deposito_idcuenta">
<select data-field="x_idcuenta" id="x_idcuenta" name="x_idcuenta"<?php echo $boleta_deposito->idcuenta->EditAttributes() ?>>
<?php
if (is_array($boleta_deposito->idcuenta->EditValue)) {
	$arwrk = $boleta_deposito->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($boleta_deposito->idcuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$boleta_deposito->idcuenta) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$boleta_deposito->Lookup_Selecting($boleta_deposito->idcuenta, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `numero`";
?>
<input type="hidden" name="s_x_idcuenta" id="s_x_idcuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`idbanco` IN ({filter_value})"); ?>&amp;t1=3">
</span>
<?php } ?>
<?php echo $boleta_deposito->idcuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group">
		<label id="elh_boleta_deposito_numero" for="x_numero" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->numero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->numero->CellAttributes() ?>>
<span id="el_boleta_deposito_numero">
<input type="text" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->numero->PlaceHolder) ?>" value="<?php echo $boleta_deposito->numero->EditValue ?>"<?php echo $boleta_deposito->numero->EditAttributes() ?>>
</span>
<?php echo $boleta_deposito->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_boleta_deposito_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->fecha->CellAttributes() ?>>
<span id="el_boleta_deposito_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->fecha->PlaceHolder) ?>" value="<?php echo $boleta_deposito->fecha->EditValue ?>"<?php echo $boleta_deposito->fecha->EditAttributes() ?>>
<?php if (!$boleta_deposito->fecha->ReadOnly && !$boleta_deposito->fecha->Disabled && @$boleta_deposito->fecha->EditAttrs["readonly"] == "" && @$boleta_deposito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fboleta_depositoadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $boleta_deposito->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->efectivo->Visible) { // efectivo ?>
	<div id="r_efectivo" class="form-group">
		<label id="elh_boleta_deposito_efectivo" for="x_efectivo" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->efectivo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->efectivo->CellAttributes() ?>>
<span id="el_boleta_deposito_efectivo">
<input type="text" data-field="x_efectivo" name="x_efectivo" id="x_efectivo" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->efectivo->PlaceHolder) ?>" value="<?php echo $boleta_deposito->efectivo->EditValue ?>"<?php echo $boleta_deposito->efectivo->EditAttributes() ?>>
</span>
<?php echo $boleta_deposito->efectivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->cheque->Visible) { // cheque ?>
	<div id="r_cheque" class="form-group">
		<label id="elh_boleta_deposito_cheque" for="x_cheque" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->cheque->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->cheque->CellAttributes() ?>>
<span id="el_boleta_deposito_cheque">
<input type="text" data-field="x_cheque" name="x_cheque" id="x_cheque" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->cheque->PlaceHolder) ?>" value="<?php echo $boleta_deposito->cheque->EditValue ?>"<?php echo $boleta_deposito->cheque->EditAttributes() ?>>
</span>
<?php echo $boleta_deposito->cheque->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->cheque_otro->Visible) { // cheque_otro ?>
	<div id="r_cheque_otro" class="form-group">
		<label id="elh_boleta_deposito_cheque_otro" for="x_cheque_otro" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->cheque_otro->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->cheque_otro->CellAttributes() ?>>
<span id="el_boleta_deposito_cheque_otro">
<input type="text" data-field="x_cheque_otro" name="x_cheque_otro" id="x_cheque_otro" size="30" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->cheque_otro->PlaceHolder) ?>" value="<?php echo $boleta_deposito->cheque_otro->EditValue ?>"<?php echo $boleta_deposito->cheque_otro->EditAttributes() ?>>
</span>
<?php echo $boleta_deposito->cheque_otro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($boleta_deposito->descripcion->Visible) { // descripcion ?>
	<div id="r_descripcion" class="form-group">
		<label id="elh_boleta_deposito_descripcion" for="x_descripcion" class="col-sm-2 control-label ewLabel"><?php echo $boleta_deposito->descripcion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $boleta_deposito->descripcion->CellAttributes() ?>>
<span id="el_boleta_deposito_descripcion">
<input type="text" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($boleta_deposito->descripcion->PlaceHolder) ?>" value="<?php echo $boleta_deposito->descripcion->EditValue ?>"<?php echo $boleta_deposito->descripcion->EditAttributes() ?>>
</span>
<?php echo $boleta_deposito->descripcion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("pago_cliente", explode(",", $boleta_deposito->getCurrentDetailTable())) && $pago_cliente->DetailAdd) {
?>
<?php if ($boleta_deposito->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("pago_cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "pago_clientegrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fboleta_depositoadd.Init();
</script>
<?php
$boleta_deposito_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$boleta_deposito_add->Page_Terminate();
?>
