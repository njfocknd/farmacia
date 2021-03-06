<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "documento_debitoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "sucursalinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "serie_documentoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "tipo_documentoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "detalle_documento_debitogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$documento_debito_add = NULL; // Initialize page object first

class cdocumento_debito_add extends cdocumento_debito {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_debito';

	// Page object name
	var $PageObjName = 'documento_debito_add';

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

		// Table object (documento_debito)
		if (!isset($GLOBALS["documento_debito"]) || get_class($GLOBALS["documento_debito"]) == "cdocumento_debito") {
			$GLOBALS["documento_debito"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_debito"];
		}

		// Table object (sucursal)
		if (!isset($GLOBALS['sucursal'])) $GLOBALS['sucursal'] = new csucursal();

		// Table object (serie_documento)
		if (!isset($GLOBALS['serie_documento'])) $GLOBALS['serie_documento'] = new cserie_documento();

		// Table object (tipo_documento)
		if (!isset($GLOBALS['tipo_documento'])) $GLOBALS['tipo_documento'] = new ctipo_documento();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_debito', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("documento_debitolist.php"));
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

			// Process auto fill for detail table 'detalle_documento_debito'
			if (@$_POST["grid"] == "fdetalle_documento_debitogrid") {
				if (!isset($GLOBALS["detalle_documento_debito_grid"])) $GLOBALS["detalle_documento_debito_grid"] = new cdetalle_documento_debito_grid;
				$GLOBALS["detalle_documento_debito_grid"]->Page_Init();
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
		global $EW_EXPORT, $documento_debito;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($documento_debito);
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
			if (@$_GET["iddocumento_debito"] != "") {
				$this->iddocumento_debito->setQueryStringValue($_GET["iddocumento_debito"]);
				$this->setKey("iddocumento_debito", $this->iddocumento_debito->CurrentValue); // Set up key
			} else {
				$this->setKey("iddocumento_debito", ""); // Clear key
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
					$this->Page_Terminate("documento_debitolist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "documento_debitoview.php")
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
		$this->idserie_documento->CurrentValue = 1;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->idcliente->CurrentValue = 1;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->direccion->CurrentValue = NULL;
		$this->direccion->OldValue = $this->direccion->CurrentValue;
		$this->nit->CurrentValue = NULL;
		$this->nit->OldValue = $this->nit->CurrentValue;
		$this->observaciones->CurrentValue = NULL;
		$this->observaciones->OldValue = $this->observaciones->CurrentValue;
		$this->idmoneda->CurrentValue = 1;
		$this->tasa_cambio->CurrentValue = 1.00000;
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
		if (!$this->idserie_documento->FldIsDetailKey) {
			$this->idserie_documento->setFormValue($objForm->GetValue("x_idserie_documento"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->idcliente->FldIsDetailKey) {
			$this->idcliente->setFormValue($objForm->GetValue("x_idcliente"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->direccion->FldIsDetailKey) {
			$this->direccion->setFormValue($objForm->GetValue("x_direccion"));
		}
		if (!$this->nit->FldIsDetailKey) {
			$this->nit->setFormValue($objForm->GetValue("x_nit"));
		}
		if (!$this->observaciones->FldIsDetailKey) {
			$this->observaciones->setFormValue($objForm->GetValue("x_observaciones"));
		}
		if (!$this->idmoneda->FldIsDetailKey) {
			$this->idmoneda->setFormValue($objForm->GetValue("x_idmoneda"));
		}
		if (!$this->tasa_cambio->FldIsDetailKey) {
			$this->tasa_cambio->setFormValue($objForm->GetValue("x_tasa_cambio"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idtipo_documento->CurrentValue = $this->idtipo_documento->FormValue;
		$this->idsucursal->CurrentValue = $this->idsucursal->FormValue;
		$this->idserie_documento->CurrentValue = $this->idserie_documento->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->idcliente->CurrentValue = $this->idcliente->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->direccion->CurrentValue = $this->direccion->FormValue;
		$this->nit->CurrentValue = $this->nit->FormValue;
		$this->observaciones->CurrentValue = $this->observaciones->FormValue;
		$this->idmoneda->CurrentValue = $this->idmoneda->FormValue;
		$this->tasa_cambio->CurrentValue = $this->tasa_cambio->FormValue;
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
		$this->iddocumento_debito->setDbValue($rs->fields('iddocumento_debito'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->idserie_documento->setDbValue($rs->fields('idserie_documento'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->correlativo->setDbValue($rs->fields('correlativo'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->idcliente->setDbValue($rs->fields('idcliente'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->nit->setDbValue($rs->fields('nit'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
		$this->estado_documento->setDbValue($rs->fields('estado_documento'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_anulacion->setDbValue($rs->fields('fecha_anulacion'));
		$this->motivo_anulacion->setDbValue($rs->fields('motivo_anulacion'));
		$this->idmoneda->setDbValue($rs->fields('idmoneda'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->importe_bruto->setDbValue($rs->fields('importe_bruto'));
		$this->importe_descuento->setDbValue($rs->fields('importe_descuento'));
		$this->importe_exento->setDbValue($rs->fields('importe_exento'));
		$this->importe_neto->setDbValue($rs->fields('importe_neto'));
		$this->importe_iva->setDbValue($rs->fields('importe_iva'));
		$this->importe_otros_impuestos->setDbValue($rs->fields('importe_otros_impuestos'));
		$this->importe_isr->setDbValue($rs->fields('importe_isr'));
		$this->importe_total->setDbValue($rs->fields('importe_total'));
		$this->idfecha_contable->setDbValue($rs->fields('idfecha_contable'));
		$this->tasa_cambio->setDbValue($rs->fields('tasa_cambio'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddocumento_debito->DbValue = $row['iddocumento_debito'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->idserie_documento->DbValue = $row['idserie_documento'];
		$this->serie->DbValue = $row['serie'];
		$this->correlativo->DbValue = $row['correlativo'];
		$this->fecha->DbValue = $row['fecha'];
		$this->idcliente->DbValue = $row['idcliente'];
		$this->nombre->DbValue = $row['nombre'];
		$this->direccion->DbValue = $row['direccion'];
		$this->nit->DbValue = $row['nit'];
		$this->observaciones->DbValue = $row['observaciones'];
		$this->estado_documento->DbValue = $row['estado_documento'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_anulacion->DbValue = $row['fecha_anulacion'];
		$this->motivo_anulacion->DbValue = $row['motivo_anulacion'];
		$this->idmoneda->DbValue = $row['idmoneda'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->importe_bruto->DbValue = $row['importe_bruto'];
		$this->importe_descuento->DbValue = $row['importe_descuento'];
		$this->importe_exento->DbValue = $row['importe_exento'];
		$this->importe_neto->DbValue = $row['importe_neto'];
		$this->importe_iva->DbValue = $row['importe_iva'];
		$this->importe_otros_impuestos->DbValue = $row['importe_otros_impuestos'];
		$this->importe_isr->DbValue = $row['importe_isr'];
		$this->importe_total->DbValue = $row['importe_total'];
		$this->idfecha_contable->DbValue = $row['idfecha_contable'];
		$this->tasa_cambio->DbValue = $row['tasa_cambio'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("iddocumento_debito")) <> "")
			$this->iddocumento_debito->CurrentValue = $this->getKey("iddocumento_debito"); // iddocumento_debito
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

		if ($this->tasa_cambio->FormValue == $this->tasa_cambio->CurrentValue && is_numeric(ew_StrToFloat($this->tasa_cambio->CurrentValue)))
			$this->tasa_cambio->CurrentValue = ew_StrToFloat($this->tasa_cambio->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// iddocumento_debito
		// idtipo_documento
		// idsucursal
		// idserie_documento
		// serie
		// correlativo
		// fecha
		// idcliente
		// nombre
		// direccion
		// nit
		// observaciones
		// estado_documento
		// estado
		// fecha_anulacion
		// motivo_anulacion
		// idmoneda
		// monto
		// fecha_insercion
		// importe_bruto
		// importe_descuento
		// importe_exento
		// importe_neto
		// importe_iva
		// importe_otros_impuestos
		// importe_isr
		// importe_total
		// idfecha_contable
		// tasa_cambio

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// iddocumento_debito
			$this->iddocumento_debito->ViewValue = $this->iddocumento_debito->CurrentValue;
			$this->iddocumento_debito->ViewCustomAttributes = "";

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

			// idserie_documento
			if (strval($this->idserie_documento->CurrentValue) <> "") {
				$sFilterWrk = "`idserie_documento`" . ew_SearchString("=", $this->idserie_documento->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idserie_documento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `serie_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idserie_documento, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `serie`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idserie_documento->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idserie_documento->ViewValue = $this->idserie_documento->CurrentValue;
				}
			} else {
				$this->idserie_documento->ViewValue = NULL;
			}
			$this->idserie_documento->ViewCustomAttributes = "";

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

			// idcliente
			if (strval($this->idcliente->CurrentValue) <> "") {
				$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcliente`, `nit` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
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

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// direccion
			$this->direccion->ViewValue = $this->direccion->CurrentValue;
			$this->direccion->ViewCustomAttributes = "";

			// nit
			$this->nit->ViewValue = $this->nit->CurrentValue;
			$this->nit->ViewCustomAttributes = "";

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
					case $this->estado_documento->FldTagValue(3):
						$this->estado_documento->ViewValue = $this->estado_documento->FldTagCaption(3) <> "" ? $this->estado_documento->FldTagCaption(3) : $this->estado_documento->CurrentValue;
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

			// fecha_anulacion
			$this->fecha_anulacion->ViewValue = $this->fecha_anulacion->CurrentValue;
			$this->fecha_anulacion->ViewValue = ew_FormatDateTime($this->fecha_anulacion->ViewValue, 7);
			$this->fecha_anulacion->ViewCustomAttributes = "";

			// motivo_anulacion
			$this->motivo_anulacion->ViewValue = $this->motivo_anulacion->CurrentValue;
			$this->motivo_anulacion->ViewCustomAttributes = "";

			// idmoneda
			if (strval($this->idmoneda->CurrentValue) <> "") {
				$sFilterWrk = "`idmoneda`" . ew_SearchString("=", $this->idmoneda->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idmoneda`, `simbolo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idmoneda, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idmoneda->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idmoneda->ViewValue = $this->idmoneda->CurrentValue;
				}
			} else {
				$this->idmoneda->ViewValue = NULL;
			}
			$this->idmoneda->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -2, -2, -2);
			$this->monto->CellCssStyle .= "text-align: right;";
			$this->monto->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// importe_bruto
			$this->importe_bruto->ViewValue = $this->importe_bruto->CurrentValue;
			$this->importe_bruto->ViewValue = ew_FormatNumber($this->importe_bruto->ViewValue, 2, -2, -2, -2);
			$this->importe_bruto->ViewCustomAttributes = "";

			// importe_descuento
			$this->importe_descuento->ViewValue = $this->importe_descuento->CurrentValue;
			$this->importe_descuento->ViewValue = ew_FormatNumber($this->importe_descuento->ViewValue, 2, -2, -2, -2);
			$this->importe_descuento->ViewCustomAttributes = "";

			// importe_exento
			$this->importe_exento->ViewValue = $this->importe_exento->CurrentValue;
			$this->importe_exento->ViewValue = ew_FormatNumber($this->importe_exento->ViewValue, 2, -2, -2, -2);
			$this->importe_exento->ViewCustomAttributes = "";

			// importe_neto
			$this->importe_neto->ViewValue = $this->importe_neto->CurrentValue;
			$this->importe_neto->ViewValue = ew_FormatNumber($this->importe_neto->ViewValue, 2, -2, -2, -2);
			$this->importe_neto->ViewCustomAttributes = "";

			// importe_iva
			$this->importe_iva->ViewValue = $this->importe_iva->CurrentValue;
			$this->importe_iva->ViewValue = ew_FormatNumber($this->importe_iva->ViewValue, 2, -2, -2, -2);
			$this->importe_iva->ViewCustomAttributes = "";

			// importe_otros_impuestos
			$this->importe_otros_impuestos->ViewValue = $this->importe_otros_impuestos->CurrentValue;
			$this->importe_otros_impuestos->ViewValue = ew_FormatNumber($this->importe_otros_impuestos->ViewValue, 2, -2, -2, -2);
			$this->importe_otros_impuestos->ViewCustomAttributes = "";

			// importe_isr
			$this->importe_isr->ViewValue = $this->importe_isr->CurrentValue;
			$this->importe_isr->ViewValue = ew_FormatNumber($this->importe_isr->ViewValue, 2, -2, -2, -2);
			$this->importe_isr->ViewCustomAttributes = "";

			// importe_total
			$this->importe_total->ViewValue = $this->importe_total->CurrentValue;
			$this->importe_total->ViewValue = ew_FormatNumber($this->importe_total->ViewValue, 2, -2, -2, -2);
			$this->importe_total->ViewCustomAttributes = "";

			// idfecha_contable
			if (strval($this->idfecha_contable->CurrentValue) <> "") {
				$sFilterWrk = "`idfecha_contable`" . ew_SearchString("=", $this->idfecha_contable->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idfecha_contable`, `fecha` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `fecha_contable`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idfecha_contable, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idfecha_contable->ViewValue = ew_FormatDateTime($rswrk->fields('DispFld'), 7);
					$rswrk->Close();
				} else {
					$this->idfecha_contable->ViewValue = $this->idfecha_contable->CurrentValue;
				}
			} else {
				$this->idfecha_contable->ViewValue = NULL;
			}
			$this->idfecha_contable->ViewCustomAttributes = "";

			// tasa_cambio
			$this->tasa_cambio->ViewValue = $this->tasa_cambio->CurrentValue;
			$this->tasa_cambio->ViewCustomAttributes = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

			// idserie_documento
			$this->idserie_documento->LinkCustomAttributes = "";
			$this->idserie_documento->HrefValue = "";
			$this->idserie_documento->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// idcliente
			$this->idcliente->LinkCustomAttributes = "";
			$this->idcliente->HrefValue = "";
			$this->idcliente->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";
			$this->direccion->TooltipValue = "";

			// nit
			$this->nit->LinkCustomAttributes = "";
			$this->nit->HrefValue = "";
			$this->nit->TooltipValue = "";

			// observaciones
			$this->observaciones->LinkCustomAttributes = "";
			$this->observaciones->HrefValue = "";
			$this->observaciones->TooltipValue = "";

			// idmoneda
			$this->idmoneda->LinkCustomAttributes = "";
			$this->idmoneda->HrefValue = "";
			$this->idmoneda->TooltipValue = "";

			// tasa_cambio
			$this->tasa_cambio->LinkCustomAttributes = "";
			$this->tasa_cambio->HrefValue = "";
			$this->tasa_cambio->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idtipo_documento
			$this->idtipo_documento->EditAttrs["class"] = "form-control";
			$this->idtipo_documento->EditCustomAttributes = "";
			if ($this->idtipo_documento->getSessionValue() <> "") {
				$this->idtipo_documento->CurrentValue = $this->idtipo_documento->getSessionValue();
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
			} else {
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
			}

			// idsucursal
			$this->idsucursal->EditAttrs["class"] = "form-control";
			$this->idsucursal->EditCustomAttributes = "";
			if ($this->idsucursal->getSessionValue() <> "") {
				$this->idsucursal->CurrentValue = $this->idsucursal->getSessionValue();
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
			} else {
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
			}

			// idserie_documento
			$this->idserie_documento->EditAttrs["class"] = "form-control";
			$this->idserie_documento->EditCustomAttributes = "";
			if ($this->idserie_documento->getSessionValue() <> "") {
				$this->idserie_documento->CurrentValue = $this->idserie_documento->getSessionValue();
			if (strval($this->idserie_documento->CurrentValue) <> "") {
				$sFilterWrk = "`idserie_documento`" . ew_SearchString("=", $this->idserie_documento->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idserie_documento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `serie_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idserie_documento, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `serie`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idserie_documento->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idserie_documento->ViewValue = $this->idserie_documento->CurrentValue;
				}
			} else {
				$this->idserie_documento->ViewValue = NULL;
			}
			$this->idserie_documento->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idserie_documento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idserie_documento`" . ew_SearchString("=", $this->idserie_documento->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idserie_documento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idtipo_documento` AS `SelectFilterFld`, `idsucursal` AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `serie_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idserie_documento, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `serie`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idserie_documento->EditValue = $arwrk;
			}

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// idcliente
			$this->idcliente->EditAttrs["class"] = "form-control";
			$this->idcliente->EditCustomAttributes = "";
			if (trim(strval($this->idcliente->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idcliente`, `nit` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cliente`";
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
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcliente->EditValue = $arwrk;

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// direccion
			$this->direccion->EditAttrs["class"] = "form-control";
			$this->direccion->EditCustomAttributes = "";
			$this->direccion->EditValue = ew_HtmlEncode($this->direccion->CurrentValue);
			$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

			// nit
			$this->nit->EditAttrs["class"] = "form-control";
			$this->nit->EditCustomAttributes = "";
			$this->nit->EditValue = ew_HtmlEncode($this->nit->CurrentValue);
			$this->nit->PlaceHolder = ew_RemoveHtml($this->nit->FldCaption());

			// observaciones
			$this->observaciones->EditAttrs["class"] = "form-control";
			$this->observaciones->EditCustomAttributes = "";
			$this->observaciones->EditValue = ew_HtmlEncode($this->observaciones->CurrentValue);
			$this->observaciones->PlaceHolder = ew_RemoveHtml($this->observaciones->FldCaption());

			// idmoneda
			$this->idmoneda->EditAttrs["class"] = "form-control";
			$this->idmoneda->EditCustomAttributes = "";
			if (trim(strval($this->idmoneda->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idmoneda`" . ew_SearchString("=", $this->idmoneda->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idmoneda`, `simbolo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `moneda`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idmoneda, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idmoneda->EditValue = $arwrk;

			// tasa_cambio
			$this->tasa_cambio->EditAttrs["class"] = "form-control";
			$this->tasa_cambio->EditCustomAttributes = "";
			$this->tasa_cambio->EditValue = ew_HtmlEncode($this->tasa_cambio->CurrentValue);
			$this->tasa_cambio->PlaceHolder = ew_RemoveHtml($this->tasa_cambio->FldCaption());
			if (strval($this->tasa_cambio->EditValue) <> "" && is_numeric($this->tasa_cambio->EditValue)) $this->tasa_cambio->EditValue = ew_FormatNumber($this->tasa_cambio->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// idtipo_documento

			$this->idtipo_documento->HrefValue = "";

			// idsucursal
			$this->idsucursal->HrefValue = "";

			// idserie_documento
			$this->idserie_documento->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// idcliente
			$this->idcliente->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// direccion
			$this->direccion->HrefValue = "";

			// nit
			$this->nit->HrefValue = "";

			// observaciones
			$this->observaciones->HrefValue = "";

			// idmoneda
			$this->idmoneda->HrefValue = "";

			// tasa_cambio
			$this->tasa_cambio->HrefValue = "";
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
		if (!$this->idtipo_documento->FldIsDetailKey && !is_null($this->idtipo_documento->FormValue) && $this->idtipo_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idtipo_documento->FldCaption(), $this->idtipo_documento->ReqErrMsg));
		}
		if (!$this->idsucursal->FldIsDetailKey && !is_null($this->idsucursal->FormValue) && $this->idsucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsucursal->FldCaption(), $this->idsucursal->ReqErrMsg));
		}
		if (!$this->idserie_documento->FldIsDetailKey && !is_null($this->idserie_documento->FormValue) && $this->idserie_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idserie_documento->FldCaption(), $this->idserie_documento->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->idcliente->FldIsDetailKey && !is_null($this->idcliente->FormValue) && $this->idcliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcliente->FldCaption(), $this->idcliente->ReqErrMsg));
		}
		if (!$this->idmoneda->FldIsDetailKey && !is_null($this->idmoneda->FormValue) && $this->idmoneda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idmoneda->FldCaption(), $this->idmoneda->ReqErrMsg));
		}
		if (!$this->tasa_cambio->FldIsDetailKey && !is_null($this->tasa_cambio->FormValue) && $this->tasa_cambio->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tasa_cambio->FldCaption(), $this->tasa_cambio->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->tasa_cambio->FormValue)) {
			ew_AddMessage($gsFormError, $this->tasa_cambio->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("detalle_documento_debito", $DetailTblVar) && $GLOBALS["detalle_documento_debito"]->DetailAdd) {
			if (!isset($GLOBALS["detalle_documento_debito_grid"])) $GLOBALS["detalle_documento_debito_grid"] = new cdetalle_documento_debito_grid(); // get detail page object
			$GLOBALS["detalle_documento_debito_grid"]->ValidateGridForm();
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

		// idserie_documento
		$this->idserie_documento->SetDbValueDef($rsnew, $this->idserie_documento->CurrentValue, 0, strval($this->idserie_documento->CurrentValue) == "");

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// idcliente
		$this->idcliente->SetDbValueDef($rsnew, $this->idcliente->CurrentValue, 0, strval($this->idcliente->CurrentValue) == "");

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, FALSE);

		// direccion
		$this->direccion->SetDbValueDef($rsnew, $this->direccion->CurrentValue, NULL, FALSE);

		// nit
		$this->nit->SetDbValueDef($rsnew, $this->nit->CurrentValue, NULL, FALSE);

		// observaciones
		$this->observaciones->SetDbValueDef($rsnew, $this->observaciones->CurrentValue, NULL, FALSE);

		// idmoneda
		$this->idmoneda->SetDbValueDef($rsnew, $this->idmoneda->CurrentValue, 0, strval($this->idmoneda->CurrentValue) == "");

		// tasa_cambio
		$this->tasa_cambio->SetDbValueDef($rsnew, $this->tasa_cambio->CurrentValue, 0, strval($this->tasa_cambio->CurrentValue) == "");

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
			$this->iddocumento_debito->setDbValue($conn->Insert_ID());
			$rsnew['iddocumento_debito'] = $this->iddocumento_debito->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("detalle_documento_debito", $DetailTblVar) && $GLOBALS["detalle_documento_debito"]->DetailAdd) {
				$GLOBALS["detalle_documento_debito"]->iddocumento_debito->setSessionValue($this->iddocumento_debito->CurrentValue); // Set master key
				if (!isset($GLOBALS["detalle_documento_debito_grid"])) $GLOBALS["detalle_documento_debito_grid"] = new cdetalle_documento_debito_grid(); // Get detail page object
				$AddRow = $GLOBALS["detalle_documento_debito_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["detalle_documento_debito"]->iddocumento_debito->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "sucursal") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idsucursal"] <> "") {
					$GLOBALS["sucursal"]->idsucursal->setQueryStringValue($_GET["fk_idsucursal"]);
					$this->idsucursal->setQueryStringValue($GLOBALS["sucursal"]->idsucursal->QueryStringValue);
					$this->idsucursal->setSessionValue($this->idsucursal->QueryStringValue);
					if (!is_numeric($GLOBALS["sucursal"]->idsucursal->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "tipo_documento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idtipo_documento"] <> "") {
					$GLOBALS["tipo_documento"]->idtipo_documento->setQueryStringValue($_GET["fk_idtipo_documento"]);
					$this->idtipo_documento->setQueryStringValue($GLOBALS["tipo_documento"]->idtipo_documento->QueryStringValue);
					$this->idtipo_documento->setSessionValue($this->idtipo_documento->QueryStringValue);
					if (!is_numeric($GLOBALS["tipo_documento"]->idtipo_documento->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "serie_documento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idserie_documento"] <> "") {
					$GLOBALS["serie_documento"]->idserie_documento->setQueryStringValue($_GET["fk_idserie_documento"]);
					$this->idserie_documento->setQueryStringValue($GLOBALS["serie_documento"]->idserie_documento->QueryStringValue);
					$this->idserie_documento->setSessionValue($this->idserie_documento->QueryStringValue);
					if (!is_numeric($GLOBALS["serie_documento"]->idserie_documento->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "sucursal") {
				if ($this->idsucursal->QueryStringValue == "") $this->idsucursal->setSessionValue("");
			}
			if ($sMasterTblVar <> "tipo_documento") {
				if ($this->idtipo_documento->QueryStringValue == "") $this->idtipo_documento->setSessionValue("");
			}
			if ($sMasterTblVar <> "serie_documento") {
				if ($this->idserie_documento->QueryStringValue == "") $this->idserie_documento->setSessionValue("");
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
			if (in_array("detalle_documento_debito", $DetailTblVar)) {
				if (!isset($GLOBALS["detalle_documento_debito_grid"]))
					$GLOBALS["detalle_documento_debito_grid"] = new cdetalle_documento_debito_grid;
				if ($GLOBALS["detalle_documento_debito_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["detalle_documento_debito_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["detalle_documento_debito_grid"]->CurrentMode = "add";
					$GLOBALS["detalle_documento_debito_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["detalle_documento_debito_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["detalle_documento_debito_grid"]->setStartRecordNumber(1);
					$GLOBALS["detalle_documento_debito_grid"]->iddocumento_debito->FldIsDetailKey = TRUE;
					$GLOBALS["detalle_documento_debito_grid"]->iddocumento_debito->CurrentValue = $this->iddocumento_debito->CurrentValue;
					$GLOBALS["detalle_documento_debito_grid"]->iddocumento_debito->setSessionValue($GLOBALS["detalle_documento_debito_grid"]->iddocumento_debito->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "documento_debitolist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'documento_debito';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'documento_debito';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['iddocumento_debito'];

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
if (!isset($documento_debito_add)) $documento_debito_add = new cdocumento_debito_add();

// Page init
$documento_debito_add->Page_Init();

// Page main
$documento_debito_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_debito_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var documento_debito_add = new ew_Page("documento_debito_add");
documento_debito_add.PageID = "add"; // Page ID
var EW_PAGE_ID = documento_debito_add.PageID; // For backward compatibility

// Form object
var fdocumento_debitoadd = new ew_Form("fdocumento_debitoadd");

// Validate form
fdocumento_debitoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idtipo_documento->FldCaption(), $documento_debito->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idsucursal->FldCaption(), $documento_debito->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idserie_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idserie_documento->FldCaption(), $documento_debito->idserie_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idcliente->FldCaption(), $documento_debito->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmoneda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idmoneda->FldCaption(), $documento_debito->idmoneda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tasa_cambio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->tasa_cambio->FldCaption(), $documento_debito->tasa_cambio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tasa_cambio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->tasa_cambio->FldErrMsg()) ?>");

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
fdocumento_debitoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_debitoadd.ValidateRequired = true;
<?php } else { ?>
fdocumento_debitoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_debitoadd.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoadd.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoadd.Lists["x_idserie_documento"] = {"LinkField":"x_idserie_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","",""],"ParentFields":["x_idtipo_documento","x_idsucursal"],"FilterFields":["x_idtipo_documento","x_idsucursal"],"Options":[]};
fdocumento_debitoadd.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_nit","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoadd.Lists["x_idmoneda"] = {"LinkField":"x_idmoneda","Ajax":true,"AutoFill":false,"DisplayFields":["x_simbolo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $documento_debito_add->ShowPageHeader(); ?>
<?php
$documento_debito_add->ShowMessage();
?>
<form name="fdocumento_debitoadd" id="fdocumento_debitoadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_debito_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_debito_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_debito">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
	<div id="r_idtipo_documento" class="form-group">
		<label id="elh_documento_debito_idtipo_documento" for="x_idtipo_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idtipo_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idtipo_documento->CellAttributes() ?>>
<?php if ($documento_debito->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el_documento_debito_idtipo_documento">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idtipo_documento" name="x_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_debito->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documento_debito_idtipo_documento">
<?php $documento_debito->idtipo_documento->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_idserie_documento']); " . @$documento_debito->idtipo_documento->EditAttrs["onchange"]; ?>
<select data-field="x_idtipo_documento" id="x_idtipo_documento" name="x_idtipo_documento"<?php echo $documento_debito->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idtipo_documento->EditValue)) {
	$arwrk = $documento_debito->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$documento_debito->Lookup_Selecting($documento_debito->idtipo_documento, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idtipo_documento" id="s_x_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $documento_debito->idtipo_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
	<div id="r_idsucursal" class="form-group">
		<label id="elh_documento_debito_idsucursal" for="x_idsucursal" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idsucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idsucursal->CellAttributes() ?>>
<?php if ($documento_debito->idsucursal->getSessionValue() <> "") { ?>
<span id="el_documento_debito_idsucursal">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idsucursal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idsucursal" name="x_idsucursal" value="<?php echo ew_HtmlEncode($documento_debito->idsucursal->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documento_debito_idsucursal">
<?php $documento_debito->idsucursal->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x_idserie_documento']); " . @$documento_debito->idsucursal->EditAttrs["onchange"]; ?>
<select data-field="x_idsucursal" id="x_idsucursal" name="x_idsucursal"<?php echo $documento_debito->idsucursal->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idsucursal->EditValue)) {
	$arwrk = $documento_debito->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$documento_debito->Lookup_Selecting($documento_debito->idsucursal, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idsucursal" id="s_x_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $documento_debito->idsucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->idserie_documento->Visible) { // idserie_documento ?>
	<div id="r_idserie_documento" class="form-group">
		<label id="elh_documento_debito_idserie_documento" for="x_idserie_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idserie_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idserie_documento->CellAttributes() ?>>
<?php if ($documento_debito->idserie_documento->getSessionValue() <> "") { ?>
<span id="el_documento_debito_idserie_documento">
<span<?php echo $documento_debito->idserie_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->idserie_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idserie_documento" name="x_idserie_documento" value="<?php echo ew_HtmlEncode($documento_debito->idserie_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documento_debito_idserie_documento">
<select data-field="x_idserie_documento" id="x_idserie_documento" name="x_idserie_documento"<?php echo $documento_debito->idserie_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idserie_documento->EditValue)) {
	$arwrk = $documento_debito->idserie_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idserie_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idserie_documento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `serie_documento`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$documento_debito->Lookup_Selecting($documento_debito->idserie_documento, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `serie`";
?>
<input type="hidden" name="s_x_idserie_documento" id="s_x_idserie_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idserie_documento` = {filter_value}"); ?>&amp;t0=3&amp;f1=<?php echo ew_Encrypt("`idtipo_documento` IN ({filter_value})"); ?>&amp;t1=3&amp;f2=<?php echo ew_Encrypt("`idsucursal` IN ({filter_value})"); ?>&amp;t2=3">
</span>
<?php } ?>
<?php echo $documento_debito->idserie_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_documento_debito_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->fecha->CellAttributes() ?>>
<span id="el_documento_debito_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha->EditValue ?>"<?php echo $documento_debito->fecha->EditAttributes() ?>>
<?php if (!$documento_debito->fecha->ReadOnly && !$documento_debito->fecha->Disabled && @$documento_debito->fecha->EditAttrs["readonly"] == "" && @$documento_debito->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_debitoadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $documento_debito->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
	<div id="r_idcliente" class="form-group">
		<label id="elh_documento_debito_idcliente" for="x_idcliente" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idcliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idcliente->CellAttributes() ?>>
<span id="el_documento_debito_idcliente">
<select data-field="x_idcliente" id="x_idcliente" name="x_idcliente"<?php echo $documento_debito->idcliente->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idcliente->EditValue)) {
	$arwrk = $documento_debito->idcliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idcliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$documento_debito->idcliente) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcliente`, `nit` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$documento_debito->Lookup_Selecting($documento_debito->idcliente, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idcliente" id="s_x_idcliente" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcliente` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $documento_debito->idcliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_documento_debito_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->nombre->CellAttributes() ?>>
<span id="el_documento_debito_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->nombre->PlaceHolder) ?>" value="<?php echo $documento_debito->nombre->EditValue ?>"<?php echo $documento_debito->nombre->EditAttributes() ?>>
</span>
<?php echo $documento_debito->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->direccion->Visible) { // direccion ?>
	<div id="r_direccion" class="form-group">
		<label id="elh_documento_debito_direccion" for="x_direccion" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->direccion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->direccion->CellAttributes() ?>>
<span id="el_documento_debito_direccion">
<input type="text" data-field="x_direccion" name="x_direccion" id="x_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->direccion->PlaceHolder) ?>" value="<?php echo $documento_debito->direccion->EditValue ?>"<?php echo $documento_debito->direccion->EditAttributes() ?>>
</span>
<?php echo $documento_debito->direccion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->nit->Visible) { // nit ?>
	<div id="r_nit" class="form-group">
		<label id="elh_documento_debito_nit" for="x_nit" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->nit->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->nit->CellAttributes() ?>>
<span id="el_documento_debito_nit">
<input type="text" data-field="x_nit" name="x_nit" id="x_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->nit->PlaceHolder) ?>" value="<?php echo $documento_debito->nit->EditValue ?>"<?php echo $documento_debito->nit->EditAttributes() ?>>
</span>
<?php echo $documento_debito->nit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->observaciones->Visible) { // observaciones ?>
	<div id="r_observaciones" class="form-group">
		<label id="elh_documento_debito_observaciones" for="x_observaciones" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->observaciones->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->observaciones->CellAttributes() ?>>
<span id="el_documento_debito_observaciones">
<input type="text" data-field="x_observaciones" name="x_observaciones" id="x_observaciones" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->observaciones->PlaceHolder) ?>" value="<?php echo $documento_debito->observaciones->EditValue ?>"<?php echo $documento_debito->observaciones->EditAttributes() ?>>
</span>
<?php echo $documento_debito->observaciones->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->idmoneda->Visible) { // idmoneda ?>
	<div id="r_idmoneda" class="form-group">
		<label id="elh_documento_debito_idmoneda" for="x_idmoneda" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idmoneda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idmoneda->CellAttributes() ?>>
<span id="el_documento_debito_idmoneda">
<select data-field="x_idmoneda" id="x_idmoneda" name="x_idmoneda"<?php echo $documento_debito->idmoneda->EditAttributes() ?>>
<?php
if (is_array($documento_debito->idmoneda->EditValue)) {
	$arwrk = $documento_debito->idmoneda->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->idmoneda->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idmoneda`, `simbolo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
$sWhereWrk = "";

// Call Lookup selecting
$documento_debito->Lookup_Selecting($documento_debito->idmoneda, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idmoneda" id="s_x_idmoneda" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmoneda` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $documento_debito->idmoneda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->tasa_cambio->Visible) { // tasa_cambio ?>
	<div id="r_tasa_cambio" class="form-group">
		<label id="elh_documento_debito_tasa_cambio" for="x_tasa_cambio" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->tasa_cambio->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->tasa_cambio->CellAttributes() ?>>
<span id="el_documento_debito_tasa_cambio">
<input type="text" data-field="x_tasa_cambio" name="x_tasa_cambio" id="x_tasa_cambio" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->tasa_cambio->PlaceHolder) ?>" value="<?php echo $documento_debito->tasa_cambio->EditValue ?>"<?php echo $documento_debito->tasa_cambio->EditAttributes() ?>>
</span>
<?php echo $documento_debito->tasa_cambio->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("detalle_documento_debito", explode(",", $documento_debito->getCurrentDetailTable())) && $detalle_documento_debito->DetailAdd) {
?>
<?php if ($documento_debito->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_debito", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_debitogrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fdocumento_debitoadd.Init();
</script>
<?php
$documento_debito_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_debito_add->Page_Terminate();
?>
