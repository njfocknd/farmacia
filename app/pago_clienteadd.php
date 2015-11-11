<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "pago_clienteinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "clienteinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "boleta_depositoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "voucher_tarjetainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "tipo_pagoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$pago_cliente_add = NULL; // Initialize page object first

class cpago_cliente_add extends cpago_cliente {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'pago_cliente';

	// Page object name
	var $PageObjName = 'pago_cliente_add';

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

		// Table object (pago_cliente)
		if (!isset($GLOBALS["pago_cliente"]) || get_class($GLOBALS["pago_cliente"]) == "cpago_cliente") {
			$GLOBALS["pago_cliente"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pago_cliente"];
		}

		// Table object (cliente)
		if (!isset($GLOBALS['cliente'])) $GLOBALS['cliente'] = new ccliente();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (boleta_deposito)
		if (!isset($GLOBALS['boleta_deposito'])) $GLOBALS['boleta_deposito'] = new cboleta_deposito();

		// Table object (voucher_tarjeta)
		if (!isset($GLOBALS['voucher_tarjeta'])) $GLOBALS['voucher_tarjeta'] = new cvoucher_tarjeta();

		// Table object (tipo_pago)
		if (!isset($GLOBALS['tipo_pago'])) $GLOBALS['tipo_pago'] = new ctipo_pago();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pago_cliente', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("pago_clientelist.php"));
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
		global $EW_EXPORT, $pago_cliente;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pago_cliente);
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
			if (@$_GET["idpago_cliente"] != "") {
				$this->idpago_cliente->setQueryStringValue($_GET["idpago_cliente"]);
				$this->setKey("idpago_cliente", $this->idpago_cliente->CurrentValue); // Set up key
			} else {
				$this->setKey("idpago_cliente", ""); // Clear key
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
					$this->Page_Terminate("pago_clientelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "pago_clienteview.php")
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
		$this->idtipo_pago->CurrentValue = 1;
		$this->idcliente->CurrentValue = 1;
		$this->monto->CurrentValue = 0.00;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->idsucursal->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idtipo_pago->FldIsDetailKey) {
			$this->idtipo_pago->setFormValue($objForm->GetValue("x_idtipo_pago"));
		}
		if (!$this->idcliente->FldIsDetailKey) {
			$this->idcliente->setFormValue($objForm->GetValue("x_idcliente"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->idsucursal->FldIsDetailKey) {
			$this->idsucursal->setFormValue($objForm->GetValue("x_idsucursal"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idtipo_pago->CurrentValue = $this->idtipo_pago->FormValue;
		$this->idcliente->CurrentValue = $this->idcliente->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->idsucursal->CurrentValue = $this->idsucursal->FormValue;
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
		$this->idpago_cliente->setDbValue($rs->fields('idpago_cliente'));
		$this->idtipo_pago->setDbValue($rs->fields('idtipo_pago'));
		$this->idcliente->setDbValue($rs->fields('idcliente'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->idboleta_deposito->setDbValue($rs->fields('idboleta_deposito'));
		$this->idvoucher_tarjeta->setDbValue($rs->fields('idvoucher_tarjeta'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpago_cliente->DbValue = $row['idpago_cliente'];
		$this->idtipo_pago->DbValue = $row['idtipo_pago'];
		$this->idcliente->DbValue = $row['idcliente'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha->DbValue = $row['fecha'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->idboleta_deposito->DbValue = $row['idboleta_deposito'];
		$this->idvoucher_tarjeta->DbValue = $row['idvoucher_tarjeta'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idpago_cliente")) <> "")
			$this->idpago_cliente->CurrentValue = $this->getKey("idpago_cliente"); // idpago_cliente
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

		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idpago_cliente
		// idtipo_pago
		// idcliente
		// monto
		// fecha
		// estado
		// fecha_insercion
		// idsucursal
		// idboleta_deposito
		// idvoucher_tarjeta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idpago_cliente
			$this->idpago_cliente->ViewValue = $this->idpago_cliente->CurrentValue;
			$this->idpago_cliente->ViewCustomAttributes = "";

			// idtipo_pago
			if (strval($this->idtipo_pago->CurrentValue) <> "") {
				$sFilterWrk = "`idtipo_pago`" . ew_SearchString("=", $this->idtipo_pago->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_pago`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idtipo_pago, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idtipo_pago->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idtipo_pago->ViewValue = $this->idtipo_pago->CurrentValue;
				}
			} else {
				$this->idtipo_pago->ViewValue = NULL;
			}
			$this->idtipo_pago->ViewCustomAttributes = "";

			// idcliente
			if (strval($this->idcliente->CurrentValue) <> "") {
				$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `codigo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcliente->ViewValue = $rswrk->fields('DispFld');
					$this->idcliente->ViewValue .= ew_ValueSeparator(1,$this->idcliente) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
				}
			} else {
				$this->idcliente->ViewValue = NULL;
			}
			$this->idcliente->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -2, 0, -1);
			$this->monto->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

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

			// idboleta_deposito
			if (strval($this->idboleta_deposito->CurrentValue) <> "") {
				$sFilterWrk = "`idboleta_deposito`" . ew_SearchString("=", $this->idboleta_deposito->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idboleta_deposito`, `numero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `boleta_deposito`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idboleta_deposito, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `numero`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idboleta_deposito->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idboleta_deposito->ViewValue = $this->idboleta_deposito->CurrentValue;
				}
			} else {
				$this->idboleta_deposito->ViewValue = NULL;
			}
			$this->idboleta_deposito->ViewCustomAttributes = "";

			// idvoucher_tarjeta
			if (strval($this->idvoucher_tarjeta->CurrentValue) <> "") {
				$sFilterWrk = "`idvoucher_tarjeta`" . ew_SearchString("=", $this->idvoucher_tarjeta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idvoucher_tarjeta`, `marca` AS `DispFld`, `marca` AS `Disp2Fld`, `ultimos_cuatro_digitos` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `voucher_tarjeta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idvoucher_tarjeta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idvoucher_tarjeta->ViewValue = $rswrk->fields('DispFld');
					$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(1,$this->idvoucher_tarjeta) . $rswrk->fields('Disp2Fld');
					$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(2,$this->idvoucher_tarjeta) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->idvoucher_tarjeta->ViewValue = $this->idvoucher_tarjeta->CurrentValue;
				}
			} else {
				$this->idvoucher_tarjeta->ViewValue = NULL;
			}
			$this->idvoucher_tarjeta->ViewCustomAttributes = "";

			// idtipo_pago
			$this->idtipo_pago->LinkCustomAttributes = "";
			$this->idtipo_pago->HrefValue = "";
			$this->idtipo_pago->TooltipValue = "";

			// idcliente
			$this->idcliente->LinkCustomAttributes = "";
			$this->idcliente->HrefValue = "";
			$this->idcliente->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idtipo_pago
			$this->idtipo_pago->EditAttrs["class"] = "form-control";
			$this->idtipo_pago->EditCustomAttributes = "";
			if ($this->idtipo_pago->getSessionValue() <> "") {
				$this->idtipo_pago->CurrentValue = $this->idtipo_pago->getSessionValue();
			if (strval($this->idtipo_pago->CurrentValue) <> "") {
				$sFilterWrk = "`idtipo_pago`" . ew_SearchString("=", $this->idtipo_pago->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_pago`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idtipo_pago, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idtipo_pago->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idtipo_pago->ViewValue = $this->idtipo_pago->CurrentValue;
				}
			} else {
				$this->idtipo_pago->ViewValue = NULL;
			}
			$this->idtipo_pago->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idtipo_pago->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idtipo_pago`" . ew_SearchString("=", $this->idtipo_pago->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_pago`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idtipo_pago, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idtipo_pago->EditValue = $arwrk;
			}

			// idcliente
			$this->idcliente->EditAttrs["class"] = "form-control";
			$this->idcliente->EditCustomAttributes = "";
			if ($this->idcliente->getSessionValue() <> "") {
				$this->idcliente->CurrentValue = $this->idcliente->getSessionValue();
			if (strval($this->idcliente->CurrentValue) <> "") {
				$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `codigo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcliente->ViewValue = $rswrk->fields('DispFld');
					$this->idcliente->ViewValue .= ew_ValueSeparator(1,$this->idcliente) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
				}
			} else {
				$this->idcliente->ViewValue = NULL;
			}
			$this->idcliente->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idcliente->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cliente`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `codigo`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcliente->EditValue = $arwrk;
			}

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -2, 0, -1);

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

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
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsucursal->EditValue = $arwrk;

			// Edit refer script
			// idtipo_pago

			$this->idtipo_pago->HrefValue = "";

			// idcliente
			$this->idcliente->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// idsucursal
			$this->idsucursal->HrefValue = "";
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
		if (!$this->idtipo_pago->FldIsDetailKey && !is_null($this->idtipo_pago->FormValue) && $this->idtipo_pago->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idtipo_pago->FldCaption(), $this->idtipo_pago->ReqErrMsg));
		}
		if (!$this->idcliente->FldIsDetailKey && !is_null($this->idcliente->FormValue) && $this->idcliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcliente->FldCaption(), $this->idcliente->ReqErrMsg));
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->idsucursal->FldIsDetailKey && !is_null($this->idsucursal->FormValue) && $this->idsucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsucursal->FldCaption(), $this->idsucursal->ReqErrMsg));
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

		// Check referential integrity for master table 'cliente'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_cliente();
		if (strval($this->idcliente->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@idcliente@", ew_AdjustSql($this->idcliente->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["cliente"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "cliente", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Check referential integrity for master table 'tipo_pago'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_tipo_pago();
		if (strval($this->idtipo_pago->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@idtipo_pago@", ew_AdjustSql($this->idtipo_pago->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["tipo_pago"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "tipo_pago", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idtipo_pago
		$this->idtipo_pago->SetDbValueDef($rsnew, $this->idtipo_pago->CurrentValue, 0, strval($this->idtipo_pago->CurrentValue) == "");

		// idcliente
		$this->idcliente->SetDbValueDef($rsnew, $this->idcliente->CurrentValue, 0, strval($this->idcliente->CurrentValue) == "");

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// idsucursal
		$this->idsucursal->SetDbValueDef($rsnew, $this->idsucursal->CurrentValue, 0, strval($this->idsucursal->CurrentValue) == "");

		// idboleta_deposito
		if ($this->idboleta_deposito->getSessionValue() <> "") {
			$rsnew['idboleta_deposito'] = $this->idboleta_deposito->getSessionValue();
		}

		// idvoucher_tarjeta
		if ($this->idvoucher_tarjeta->getSessionValue() <> "") {
			$rsnew['idvoucher_tarjeta'] = $this->idvoucher_tarjeta->getSessionValue();
		}

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
			$this->idpago_cliente->setDbValue($conn->Insert_ID());
			$rsnew['idpago_cliente'] = $this->idpago_cliente->DbValue;
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
			if ($sMasterTblVar == "cliente") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcliente"] <> "") {
					$GLOBALS["cliente"]->idcliente->setQueryStringValue($_GET["fk_idcliente"]);
					$this->idcliente->setQueryStringValue($GLOBALS["cliente"]->idcliente->QueryStringValue);
					$this->idcliente->setSessionValue($this->idcliente->QueryStringValue);
					if (!is_numeric($GLOBALS["cliente"]->idcliente->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "tipo_pago") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idtipo_pago"] <> "") {
					$GLOBALS["tipo_pago"]->idtipo_pago->setQueryStringValue($_GET["fk_idtipo_pago"]);
					$this->idtipo_pago->setQueryStringValue($GLOBALS["tipo_pago"]->idtipo_pago->QueryStringValue);
					$this->idtipo_pago->setSessionValue($this->idtipo_pago->QueryStringValue);
					if (!is_numeric($GLOBALS["tipo_pago"]->idtipo_pago->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "boleta_deposito") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idboleta_deposito"] <> "") {
					$GLOBALS["boleta_deposito"]->idboleta_deposito->setQueryStringValue($_GET["fk_idboleta_deposito"]);
					$this->idboleta_deposito->setQueryStringValue($GLOBALS["boleta_deposito"]->idboleta_deposito->QueryStringValue);
					$this->idboleta_deposito->setSessionValue($this->idboleta_deposito->QueryStringValue);
					if (!is_numeric($GLOBALS["boleta_deposito"]->idboleta_deposito->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "voucher_tarjeta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idvoucher_tarjeta"] <> "") {
					$GLOBALS["voucher_tarjeta"]->idvoucher_tarjeta->setQueryStringValue($_GET["fk_idvoucher_tarjeta"]);
					$this->idvoucher_tarjeta->setQueryStringValue($GLOBALS["voucher_tarjeta"]->idvoucher_tarjeta->QueryStringValue);
					$this->idvoucher_tarjeta->setSessionValue($this->idvoucher_tarjeta->QueryStringValue);
					if (!is_numeric($GLOBALS["voucher_tarjeta"]->idvoucher_tarjeta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cliente") {
				if ($this->idcliente->QueryStringValue == "") $this->idcliente->setSessionValue("");
			}
			if ($sMasterTblVar <> "tipo_pago") {
				if ($this->idtipo_pago->QueryStringValue == "") $this->idtipo_pago->setSessionValue("");
			}
			if ($sMasterTblVar <> "boleta_deposito") {
				if ($this->idboleta_deposito->QueryStringValue == "") $this->idboleta_deposito->setSessionValue("");
			}
			if ($sMasterTblVar <> "voucher_tarjeta") {
				if ($this->idvoucher_tarjeta->QueryStringValue == "") $this->idvoucher_tarjeta->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "pago_clientelist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'pago_cliente';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'pago_cliente';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idpago_cliente'];

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
if (!isset($pago_cliente_add)) $pago_cliente_add = new cpago_cliente_add();

// Page init
$pago_cliente_add->Page_Init();

// Page main
$pago_cliente_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pago_cliente_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var pago_cliente_add = new ew_Page("pago_cliente_add");
pago_cliente_add.PageID = "add"; // Page ID
var EW_PAGE_ID = pago_cliente_add.PageID; // For backward compatibility

// Form object
var fpago_clienteadd = new ew_Form("fpago_clienteadd");

// Validate form
fpago_clienteadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_pago");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->idtipo_pago->FldCaption(), $pago_cliente->idtipo_pago->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->idcliente->FldCaption(), $pago_cliente->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->monto->FldCaption(), $pago_cliente->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_cliente->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pago_cliente->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $pago_cliente->idsucursal->FldCaption(), $pago_cliente->idsucursal->ReqErrMsg)) ?>");

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
fpago_clienteadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpago_clienteadd.ValidateRequired = true;
<?php } else { ?>
fpago_clienteadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpago_clienteadd.Lists["x_idtipo_pago"] = {"LinkField":"x_idtipo_pago","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteadd.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_codigo","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteadd.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $pago_cliente_add->ShowPageHeader(); ?>
<?php
$pago_cliente_add->ShowMessage();
?>
<form name="fpago_clienteadd" id="fpago_clienteadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pago_cliente_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pago_cliente_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pago_cliente">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($pago_cliente->idtipo_pago->Visible) { // idtipo_pago ?>
	<div id="r_idtipo_pago" class="form-group">
		<label id="elh_pago_cliente_idtipo_pago" for="x_idtipo_pago" class="col-sm-2 control-label ewLabel"><?php echo $pago_cliente->idtipo_pago->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pago_cliente->idtipo_pago->CellAttributes() ?>>
<?php if ($pago_cliente->idtipo_pago->getSessionValue() <> "") { ?>
<span id="el_pago_cliente_idtipo_pago">
<span<?php echo $pago_cliente->idtipo_pago->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idtipo_pago->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idtipo_pago" name="x_idtipo_pago" value="<?php echo ew_HtmlEncode($pago_cliente->idtipo_pago->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pago_cliente_idtipo_pago">
<select data-field="x_idtipo_pago" id="x_idtipo_pago" name="x_idtipo_pago"<?php echo $pago_cliente->idtipo_pago->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idtipo_pago->EditValue)) {
	$arwrk = $pago_cliente->idtipo_pago->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idtipo_pago->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_pago`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$pago_cliente->Lookup_Selecting($pago_cliente->idtipo_pago, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idtipo_pago" id="s_x_idtipo_pago" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_pago` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $pago_cliente->idtipo_pago->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
	<div id="r_idcliente" class="form-group">
		<label id="elh_pago_cliente_idcliente" for="x_idcliente" class="col-sm-2 control-label ewLabel"><?php echo $pago_cliente->idcliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pago_cliente->idcliente->CellAttributes() ?>>
<?php if ($pago_cliente->idcliente->getSessionValue() <> "") { ?>
<span id="el_pago_cliente_idcliente">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pago_cliente->idcliente->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcliente" name="x_idcliente" value="<?php echo ew_HtmlEncode($pago_cliente->idcliente->CurrentValue) ?>">
<?php } else { ?>
<span id="el_pago_cliente_idcliente">
<select data-field="x_idcliente" id="x_idcliente" name="x_idcliente"<?php echo $pago_cliente->idcliente->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idcliente->EditValue)) {
	$arwrk = $pago_cliente->idcliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idcliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$pago_cliente->idcliente) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$pago_cliente->Lookup_Selecting($pago_cliente->idcliente, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `codigo`";
?>
<input type="hidden" name="s_x_idcliente" id="s_x_idcliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcliente` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $pago_cliente->idcliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pago_cliente->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_pago_cliente_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $pago_cliente->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pago_cliente->monto->CellAttributes() ?>>
<span id="el_pago_cliente_monto">
<input type="text" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($pago_cliente->monto->PlaceHolder) ?>" value="<?php echo $pago_cliente->monto->EditValue ?>"<?php echo $pago_cliente->monto->EditAttributes() ?>>
</span>
<?php echo $pago_cliente->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_pago_cliente_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $pago_cliente->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pago_cliente->fecha->CellAttributes() ?>>
<span id="el_pago_cliente_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($pago_cliente->fecha->PlaceHolder) ?>" value="<?php echo $pago_cliente->fecha->EditValue ?>"<?php echo $pago_cliente->fecha->EditAttributes() ?>>
<?php if (!$pago_cliente->fecha->ReadOnly && !$pago_cliente->fecha->Disabled && @$pago_cliente->fecha->EditAttrs["readonly"] == "" && @$pago_cliente->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpago_clienteadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $pago_cliente->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
	<div id="r_idsucursal" class="form-group">
		<label id="elh_pago_cliente_idsucursal" for="x_idsucursal" class="col-sm-2 control-label ewLabel"><?php echo $pago_cliente->idsucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $pago_cliente->idsucursal->CellAttributes() ?>>
<span id="el_pago_cliente_idsucursal">
<select data-field="x_idsucursal" id="x_idsucursal" name="x_idsucursal"<?php echo $pago_cliente->idsucursal->EditAttributes() ?>>
<?php
if (is_array($pago_cliente->idsucursal->EditValue)) {
	$arwrk = $pago_cliente->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($pago_cliente->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$pago_cliente->Lookup_Selecting($pago_cliente->idsucursal, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idsucursal" id="s_x_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $pago_cliente->idsucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($pago_cliente->idboleta_deposito->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_idboleta_deposito" id="x_idboleta_deposito" value="<?php echo ew_HtmlEncode(strval($pago_cliente->idboleta_deposito->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($pago_cliente->idvoucher_tarjeta->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_idvoucher_tarjeta" id="x_idvoucher_tarjeta" value="<?php echo ew_HtmlEncode(strval($pago_cliente->idvoucher_tarjeta->getSessionValue())) ?>">
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpago_clienteadd.Init();
</script>
<?php
$pago_cliente_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$pago_cliente_add->Page_Terminate();
?>
