<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "proveedorinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "personainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "pago_proveedorgridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$proveedor_add = NULL; // Initialize page object first

class cproveedor_add extends cproveedor {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'proveedor';

	// Page object name
	var $PageObjName = 'proveedor_add';

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

		// Table object (proveedor)
		if (!isset($GLOBALS["proveedor"]) || get_class($GLOBALS["proveedor"]) == "cproveedor") {
			$GLOBALS["proveedor"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["proveedor"];
		}

		// Table object (persona)
		if (!isset($GLOBALS['persona'])) $GLOBALS['persona'] = new cpersona();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'proveedor', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("proveedorlist.php"));
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

			// Process auto fill for detail table 'pago_proveedor'
			if (@$_POST["grid"] == "fpago_proveedorgrid") {
				if (!isset($GLOBALS["pago_proveedor_grid"])) $GLOBALS["pago_proveedor_grid"] = new cpago_proveedor_grid;
				$GLOBALS["pago_proveedor_grid"]->Page_Init();
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
		global $EW_EXPORT, $proveedor;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($proveedor);
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
			if (@$_GET["idproveedor"] != "") {
				$this->idproveedor->setQueryStringValue($_GET["idproveedor"]);
				$this->setKey("idproveedor", $this->idproveedor->CurrentValue); // Set up key
			} else {
				$this->setKey("idproveedor", ""); // Clear key
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
					$this->Page_Terminate("proveedorlist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "proveedorview.php")
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
		$this->idpersona->CurrentValue = 1;
		$this->nit->CurrentValue = NULL;
		$this->nit->OldValue = $this->nit->CurrentValue;
		$this->nombre_factura->CurrentValue = NULL;
		$this->nombre_factura->OldValue = $this->nombre_factura->CurrentValue;
		$this->direccion_factura->CurrentValue = NULL;
		$this->direccion_factura->OldValue = $this->direccion_factura->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idpersona->FldIsDetailKey) {
			$this->idpersona->setFormValue($objForm->GetValue("x_idpersona"));
		}
		if (!$this->nit->FldIsDetailKey) {
			$this->nit->setFormValue($objForm->GetValue("x_nit"));
		}
		if (!$this->nombre_factura->FldIsDetailKey) {
			$this->nombre_factura->setFormValue($objForm->GetValue("x_nombre_factura"));
		}
		if (!$this->direccion_factura->FldIsDetailKey) {
			$this->direccion_factura->setFormValue($objForm->GetValue("x_direccion_factura"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idpersona->CurrentValue = $this->idpersona->FormValue;
		$this->nit->CurrentValue = $this->nit->FormValue;
		$this->nombre_factura->CurrentValue = $this->nombre_factura->FormValue;
		$this->direccion_factura->CurrentValue = $this->direccion_factura->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
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
		$this->idproveedor->setDbValue($rs->fields('idproveedor'));
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->codigo->setDbValue($rs->fields('codigo'));
		$this->nit->setDbValue($rs->fields('nit'));
		$this->nombre_factura->setDbValue($rs->fields('nombre_factura'));
		$this->direccion_factura->setDbValue($rs->fields('direccion_factura'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idproveedor->DbValue = $row['idproveedor'];
		$this->idpersona->DbValue = $row['idpersona'];
		$this->codigo->DbValue = $row['codigo'];
		$this->nit->DbValue = $row['nit'];
		$this->nombre_factura->DbValue = $row['nombre_factura'];
		$this->direccion_factura->DbValue = $row['direccion_factura'];
		$this->debito->DbValue = $row['debito'];
		$this->credito->DbValue = $row['credito'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->_email->DbValue = $row['email'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idproveedor")) <> "")
			$this->idproveedor->CurrentValue = $this->getKey("idproveedor"); // idproveedor
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
		// idproveedor
		// idpersona
		// codigo
		// nit
		// nombre_factura
		// direccion_factura
		// debito
		// credito
		// fecha_insercion
		// email
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idproveedor
			$this->idproveedor->ViewValue = $this->idproveedor->CurrentValue;
			$this->idproveedor->ViewCustomAttributes = "";

			// idpersona
			if (strval($this->idpersona->CurrentValue) <> "") {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpersona->ViewValue = $rswrk->fields('DispFld');
					$this->idpersona->ViewValue .= ew_ValueSeparator(1,$this->idpersona) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
				}
			} else {
				$this->idpersona->ViewValue = NULL;
			}
			$this->idpersona->ViewCustomAttributes = "";

			// codigo
			$this->codigo->ViewValue = $this->codigo->CurrentValue;
			$this->codigo->ViewCustomAttributes = "";

			// nit
			$this->nit->ViewValue = $this->nit->CurrentValue;
			$this->nit->ViewCustomAttributes = "";

			// nombre_factura
			$this->nombre_factura->ViewValue = $this->nombre_factura->CurrentValue;
			$this->nombre_factura->ViewCustomAttributes = "";

			// direccion_factura
			$this->direccion_factura->ViewValue = $this->direccion_factura->CurrentValue;
			$this->direccion_factura->ViewCustomAttributes = "";

			// debito
			$this->debito->ViewValue = $this->debito->CurrentValue;
			$this->debito->ViewCustomAttributes = "";

			// credito
			$this->credito->ViewValue = $this->credito->CurrentValue;
			$this->credito->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

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

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";
			$this->idpersona->TooltipValue = "";

			// nit
			$this->nit->LinkCustomAttributes = "";
			$this->nit->HrefValue = "";
			$this->nit->TooltipValue = "";

			// nombre_factura
			$this->nombre_factura->LinkCustomAttributes = "";
			$this->nombre_factura->HrefValue = "";
			$this->nombre_factura->TooltipValue = "";

			// direccion_factura
			$this->direccion_factura->LinkCustomAttributes = "";
			$this->direccion_factura->HrefValue = "";
			$this->direccion_factura->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idpersona
			$this->idpersona->EditAttrs["class"] = "form-control";
			$this->idpersona->EditCustomAttributes = "";
			if ($this->idpersona->getSessionValue() <> "") {
				$this->idpersona->CurrentValue = $this->idpersona->getSessionValue();
			if (strval($this->idpersona->CurrentValue) <> "") {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpersona->ViewValue = $rswrk->fields('DispFld');
					$this->idpersona->ViewValue .= ew_ValueSeparator(1,$this->idpersona) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
				}
			} else {
				$this->idpersona->ViewValue = NULL;
			}
			$this->idpersona->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idpersona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `persona`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpersona->EditValue = $arwrk;
			}

			// nit
			$this->nit->EditAttrs["class"] = "form-control";
			$this->nit->EditCustomAttributes = "";
			$this->nit->EditValue = ew_HtmlEncode($this->nit->CurrentValue);
			$this->nit->PlaceHolder = ew_RemoveHtml($this->nit->FldCaption());

			// nombre_factura
			$this->nombre_factura->EditAttrs["class"] = "form-control";
			$this->nombre_factura->EditCustomAttributes = "";
			$this->nombre_factura->EditValue = ew_HtmlEncode($this->nombre_factura->CurrentValue);
			$this->nombre_factura->PlaceHolder = ew_RemoveHtml($this->nombre_factura->FldCaption());

			// direccion_factura
			$this->direccion_factura->EditAttrs["class"] = "form-control";
			$this->direccion_factura->EditCustomAttributes = "";
			$this->direccion_factura->EditValue = ew_HtmlEncode($this->direccion_factura->CurrentValue);
			$this->direccion_factura->PlaceHolder = ew_RemoveHtml($this->direccion_factura->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// Edit refer script
			// idpersona

			$this->idpersona->HrefValue = "";

			// nit
			$this->nit->HrefValue = "";

			// nombre_factura
			$this->nombre_factura->HrefValue = "";

			// direccion_factura
			$this->direccion_factura->HrefValue = "";

			// email
			$this->_email->HrefValue = "";
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
		if (!$this->idpersona->FldIsDetailKey && !is_null($this->idpersona->FormValue) && $this->idpersona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpersona->FldCaption(), $this->idpersona->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->_email->FormValue)) {
			ew_AddMessage($gsFormError, $this->_email->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("pago_proveedor", $DetailTblVar) && $GLOBALS["pago_proveedor"]->DetailAdd) {
			if (!isset($GLOBALS["pago_proveedor_grid"])) $GLOBALS["pago_proveedor_grid"] = new cpago_proveedor_grid(); // get detail page object
			$GLOBALS["pago_proveedor_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'persona'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_persona();
		if (strval($this->idpersona->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@idpersona@", ew_AdjustSql($this->idpersona->CurrentValue), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["persona"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "persona", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idpersona
		$this->idpersona->SetDbValueDef($rsnew, $this->idpersona->CurrentValue, 0, strval($this->idpersona->CurrentValue) == "");

		// nit
		$this->nit->SetDbValueDef($rsnew, $this->nit->CurrentValue, NULL, FALSE);

		// nombre_factura
		$this->nombre_factura->SetDbValueDef($rsnew, $this->nombre_factura->CurrentValue, NULL, FALSE);

		// direccion_factura
		$this->direccion_factura->SetDbValueDef($rsnew, $this->direccion_factura->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

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
			$this->idproveedor->setDbValue($conn->Insert_ID());
			$rsnew['idproveedor'] = $this->idproveedor->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("pago_proveedor", $DetailTblVar) && $GLOBALS["pago_proveedor"]->DetailAdd) {
				$GLOBALS["pago_proveedor"]->idproveedor->setSessionValue($this->idproveedor->CurrentValue); // Set master key
				if (!isset($GLOBALS["pago_proveedor_grid"])) $GLOBALS["pago_proveedor_grid"] = new cpago_proveedor_grid(); // Get detail page object
				$AddRow = $GLOBALS["pago_proveedor_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["pago_proveedor"]->idproveedor->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "persona") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idpersona"] <> "") {
					$GLOBALS["persona"]->idpersona->setQueryStringValue($_GET["fk_idpersona"]);
					$this->idpersona->setQueryStringValue($GLOBALS["persona"]->idpersona->QueryStringValue);
					$this->idpersona->setSessionValue($this->idpersona->QueryStringValue);
					if (!is_numeric($GLOBALS["persona"]->idpersona->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "persona") {
				if ($this->idpersona->QueryStringValue == "") $this->idpersona->setSessionValue("");
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
			if (in_array("pago_proveedor", $DetailTblVar)) {
				if (!isset($GLOBALS["pago_proveedor_grid"]))
					$GLOBALS["pago_proveedor_grid"] = new cpago_proveedor_grid;
				if ($GLOBALS["pago_proveedor_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["pago_proveedor_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["pago_proveedor_grid"]->CurrentMode = "add";
					$GLOBALS["pago_proveedor_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["pago_proveedor_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["pago_proveedor_grid"]->setStartRecordNumber(1);
					$GLOBALS["pago_proveedor_grid"]->idproveedor->FldIsDetailKey = TRUE;
					$GLOBALS["pago_proveedor_grid"]->idproveedor->CurrentValue = $this->idproveedor->CurrentValue;
					$GLOBALS["pago_proveedor_grid"]->idproveedor->setSessionValue($GLOBALS["pago_proveedor_grid"]->idproveedor->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "proveedorlist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'proveedor';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'proveedor';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idproveedor'];

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
if (!isset($proveedor_add)) $proveedor_add = new cproveedor_add();

// Page init
$proveedor_add->Page_Init();

// Page main
$proveedor_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$proveedor_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var proveedor_add = new ew_Page("proveedor_add");
proveedor_add.PageID = "add"; // Page ID
var EW_PAGE_ID = proveedor_add.PageID; // For backward compatibility

// Form object
var fproveedoradd = new ew_Form("fproveedoradd");

// Validate form
fproveedoradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idpersona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $proveedor->idpersona->FldCaption(), $proveedor->idpersona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($proveedor->_email->FldErrMsg()) ?>");

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
fproveedoradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproveedoradd.ValidateRequired = true;
<?php } else { ?>
fproveedoradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproveedoradd.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","x_apellido","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $proveedor_add->ShowPageHeader(); ?>
<?php
$proveedor_add->ShowMessage();
?>
<form name="fproveedoradd" id="fproveedoradd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($proveedor_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $proveedor_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
	<div id="r_idpersona" class="form-group">
		<label id="elh_proveedor_idpersona" for="x_idpersona" class="col-sm-2 control-label ewLabel"><?php echo $proveedor->idpersona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $proveedor->idpersona->CellAttributes() ?>>
<?php if ($proveedor->idpersona->getSessionValue() <> "") { ?>
<span id="el_proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idpersona" name="x_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el_proveedor_idpersona">
<select data-field="x_idpersona" id="x_idpersona" name="x_idpersona"<?php echo $proveedor->idpersona->EditAttributes() ?>>
<?php
if (is_array($proveedor->idpersona->EditValue)) {
	$arwrk = $proveedor->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($proveedor->idpersona->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$proveedor->idpersona) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$proveedor->Lookup_Selecting($proveedor->idpersona, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idpersona" id="s_x_idpersona" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpersona` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $proveedor->idpersona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($proveedor->nit->Visible) { // nit ?>
	<div id="r_nit" class="form-group">
		<label id="elh_proveedor_nit" for="x_nit" class="col-sm-2 control-label ewLabel"><?php echo $proveedor->nit->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $proveedor->nit->CellAttributes() ?>>
<span id="el_proveedor_nit">
<input type="text" data-field="x_nit" name="x_nit" id="x_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->PlaceHolder) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<?php echo $proveedor->nit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
	<div id="r_nombre_factura" class="form-group">
		<label id="elh_proveedor_nombre_factura" for="x_nombre_factura" class="col-sm-2 control-label ewLabel"><?php echo $proveedor->nombre_factura->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $proveedor->nombre_factura->CellAttributes() ?>>
<span id="el_proveedor_nombre_factura">
<input type="text" data-field="x_nombre_factura" name="x_nombre_factura" id="x_nombre_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre_factura->PlaceHolder) ?>" value="<?php echo $proveedor->nombre_factura->EditValue ?>"<?php echo $proveedor->nombre_factura->EditAttributes() ?>>
</span>
<?php echo $proveedor->nombre_factura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
	<div id="r_direccion_factura" class="form-group">
		<label id="elh_proveedor_direccion_factura" for="x_direccion_factura" class="col-sm-2 control-label ewLabel"><?php echo $proveedor->direccion_factura->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $proveedor->direccion_factura->CellAttributes() ?>>
<span id="el_proveedor_direccion_factura">
<input type="text" data-field="x_direccion_factura" name="x_direccion_factura" id="x_direccion_factura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion_factura->PlaceHolder) ?>" value="<?php echo $proveedor->direccion_factura->EditValue ?>"<?php echo $proveedor->direccion_factura->EditAttributes() ?>>
</span>
<?php echo $proveedor->direccion_factura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($proveedor->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_proveedor__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $proveedor->_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $proveedor->_email->CellAttributes() ?>>
<span id="el_proveedor__email">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->_email->PlaceHolder) ?>" value="<?php echo $proveedor->_email->EditValue ?>"<?php echo $proveedor->_email->EditAttributes() ?>>
</span>
<?php echo $proveedor->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("pago_proveedor", explode(",", $proveedor->getCurrentDetailTable())) && $pago_proveedor->DetailAdd) {
?>
<?php if ($proveedor->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("pago_proveedor", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "pago_proveedorgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fproveedoradd.Init();
</script>
<?php
$proveedor_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$proveedor_add->Page_Terminate();
?>
