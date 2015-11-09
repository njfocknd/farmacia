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

$documento_debito_edit = NULL; // Initialize page object first

class cdocumento_debito_edit extends cdocumento_debito {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_debito';

	// Page object name
	var $PageObjName = 'documento_debito_edit';

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
	var $AuditTrailOnEdit = TRUE;

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->iddocumento_debito->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["iddocumento_debito"] <> "") {
			$this->iddocumento_debito->setQueryStringValue($_GET["iddocumento_debito"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		if ($this->iddocumento_debito->CurrentValue == "")
			$this->Page_Terminate("documento_debitolist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("documento_debitolist.php"); // No matching record, return to list
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
		if (!$this->iddocumento_debito->FldIsDetailKey)
			$this->iddocumento_debito->setFormValue($objForm->GetValue("x_iddocumento_debito"));
		if (!$this->idtipo_documento->FldIsDetailKey) {
			$this->idtipo_documento->setFormValue($objForm->GetValue("x_idtipo_documento"));
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
		if (!$this->estado_documento->FldIsDetailKey) {
			$this->estado_documento->setFormValue($objForm->GetValue("x_estado_documento"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->fecha_anulacion->FldIsDetailKey) {
			$this->fecha_anulacion->setFormValue($objForm->GetValue("x_fecha_anulacion"));
			$this->fecha_anulacion->CurrentValue = ew_UnFormatDateTime($this->fecha_anulacion->CurrentValue, 7);
		}
		if (!$this->motivo_anulacion->FldIsDetailKey) {
			$this->motivo_anulacion->setFormValue($objForm->GetValue("x_motivo_anulacion"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->fecha_insercion->FldIsDetailKey) {
			$this->fecha_insercion->setFormValue($objForm->GetValue("x_fecha_insercion"));
			$this->fecha_insercion->CurrentValue = ew_UnFormatDateTime($this->fecha_insercion->CurrentValue, 7);
		}
		if (!$this->idcliente->FldIsDetailKey) {
			$this->idcliente->setFormValue($objForm->GetValue("x_idcliente"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->iddocumento_debito->CurrentValue = $this->iddocumento_debito->FormValue;
		$this->idtipo_documento->CurrentValue = $this->idtipo_documento->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->direccion->CurrentValue = $this->direccion->FormValue;
		$this->nit->CurrentValue = $this->nit->FormValue;
		$this->observaciones->CurrentValue = $this->observaciones->FormValue;
		$this->estado_documento->CurrentValue = $this->estado_documento->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->fecha_anulacion->CurrentValue = $this->fecha_anulacion->FormValue;
		$this->fecha_anulacion->CurrentValue = ew_UnFormatDateTime($this->fecha_anulacion->CurrentValue, 7);
		$this->motivo_anulacion->CurrentValue = $this->motivo_anulacion->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->fecha_insercion->CurrentValue = $this->fecha_insercion->FormValue;
		$this->fecha_insercion->CurrentValue = ew_UnFormatDateTime($this->fecha_insercion->CurrentValue, 7);
		$this->idcliente->CurrentValue = $this->idcliente->FormValue;
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
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->nit->setDbValue($rs->fields('nit'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
		$this->estado_documento->setDbValue($rs->fields('estado_documento'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_anulacion->setDbValue($rs->fields('fecha_anulacion'));
		$this->motivo_anulacion->setDbValue($rs->fields('motivo_anulacion'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->idcliente->setDbValue($rs->fields('idcliente'));
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
		$this->nombre->DbValue = $row['nombre'];
		$this->direccion->DbValue = $row['direccion'];
		$this->nit->DbValue = $row['nit'];
		$this->observaciones->DbValue = $row['observaciones'];
		$this->estado_documento->DbValue = $row['estado_documento'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_anulacion->DbValue = $row['fecha_anulacion'];
		$this->motivo_anulacion->DbValue = $row['motivo_anulacion'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->idcliente->DbValue = $row['idcliente'];
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
		// iddocumento_debito
		// idtipo_documento
		// idsucursal
		// idserie_documento
		// serie
		// correlativo
		// fecha
		// nombre
		// direccion
		// nit
		// observaciones
		// estado_documento
		// estado
		// fecha_anulacion
		// motivo_anulacion
		// monto
		// fecha_insercion
		// idcliente

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

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// idcliente
			$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
			$this->idcliente->ViewCustomAttributes = "";

			// iddocumento_debito
			$this->iddocumento_debito->LinkCustomAttributes = "";
			$this->iddocumento_debito->HrefValue = "";
			$this->iddocumento_debito->TooltipValue = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

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

			// estado_documento
			$this->estado_documento->LinkCustomAttributes = "";
			$this->estado_documento->HrefValue = "";
			$this->estado_documento->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_anulacion
			$this->fecha_anulacion->LinkCustomAttributes = "";
			$this->fecha_anulacion->HrefValue = "";
			$this->fecha_anulacion->TooltipValue = "";

			// motivo_anulacion
			$this->motivo_anulacion->LinkCustomAttributes = "";
			$this->motivo_anulacion->HrefValue = "";
			$this->motivo_anulacion->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// idcliente
			$this->idcliente->LinkCustomAttributes = "";
			$this->idcliente->HrefValue = "";
			$this->idcliente->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// iddocumento_debito
			$this->iddocumento_debito->EditAttrs["class"] = "form-control";
			$this->iddocumento_debito->EditCustomAttributes = "";
			$this->iddocumento_debito->EditValue = $this->iddocumento_debito->CurrentValue;
			$this->iddocumento_debito->ViewCustomAttributes = "";

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

			// fecha_anulacion
			$this->fecha_anulacion->EditAttrs["class"] = "form-control";
			$this->fecha_anulacion->EditCustomAttributes = "";
			$this->fecha_anulacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_anulacion->CurrentValue, 7));
			$this->fecha_anulacion->PlaceHolder = ew_RemoveHtml($this->fecha_anulacion->FldCaption());

			// motivo_anulacion
			$this->motivo_anulacion->EditAttrs["class"] = "form-control";
			$this->motivo_anulacion->EditCustomAttributes = "";
			$this->motivo_anulacion->EditValue = ew_HtmlEncode($this->motivo_anulacion->CurrentValue);
			$this->motivo_anulacion->PlaceHolder = ew_RemoveHtml($this->motivo_anulacion->FldCaption());

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// fecha_insercion
			$this->fecha_insercion->EditAttrs["class"] = "form-control";
			$this->fecha_insercion->EditCustomAttributes = "";
			$this->fecha_insercion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_insercion->CurrentValue, 7));
			$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

			// idcliente
			$this->idcliente->EditAttrs["class"] = "form-control";
			$this->idcliente->EditCustomAttributes = "";
			$this->idcliente->EditValue = ew_HtmlEncode($this->idcliente->CurrentValue);
			$this->idcliente->PlaceHolder = ew_RemoveHtml($this->idcliente->FldCaption());

			// Edit refer script
			// iddocumento_debito

			$this->iddocumento_debito->HrefValue = "";

			// idtipo_documento
			$this->idtipo_documento->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// direccion
			$this->direccion->HrefValue = "";

			// nit
			$this->nit->HrefValue = "";

			// observaciones
			$this->observaciones->HrefValue = "";

			// estado_documento
			$this->estado_documento->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// fecha_anulacion
			$this->fecha_anulacion->HrefValue = "";

			// motivo_anulacion
			$this->motivo_anulacion->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";

			// fecha_insercion
			$this->fecha_insercion->HrefValue = "";

			// idcliente
			$this->idcliente->HrefValue = "";
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
		if (!$this->estado_documento->FldIsDetailKey && !is_null($this->estado_documento->FormValue) && $this->estado_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento->FldCaption(), $this->estado_documento->ReqErrMsg));
		}
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha_anulacion->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_anulacion->FldErrMsg());
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha_insercion->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_insercion->FldErrMsg());
		}
		if (!$this->idcliente->FldIsDetailKey && !is_null($this->idcliente->FormValue) && $this->idcliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcliente->FldCaption(), $this->idcliente->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcliente->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcliente->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("detalle_documento_debito", $DetailTblVar) && $GLOBALS["detalle_documento_debito"]->DetailEdit) {
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

			// idtipo_documento
			$this->idtipo_documento->SetDbValueDef($rsnew, $this->idtipo_documento->CurrentValue, 0, $this->idtipo_documento->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, $this->nombre->ReadOnly);

			// direccion
			$this->direccion->SetDbValueDef($rsnew, $this->direccion->CurrentValue, NULL, $this->direccion->ReadOnly);

			// nit
			$this->nit->SetDbValueDef($rsnew, $this->nit->CurrentValue, NULL, $this->nit->ReadOnly);

			// observaciones
			$this->observaciones->SetDbValueDef($rsnew, $this->observaciones->CurrentValue, NULL, $this->observaciones->ReadOnly);

			// estado_documento
			$this->estado_documento->SetDbValueDef($rsnew, $this->estado_documento->CurrentValue, "", $this->estado_documento->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

			// fecha_anulacion
			$this->fecha_anulacion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_anulacion->CurrentValue, 7), NULL, $this->fecha_anulacion->ReadOnly);

			// motivo_anulacion
			$this->motivo_anulacion->SetDbValueDef($rsnew, $this->motivo_anulacion->CurrentValue, NULL, $this->motivo_anulacion->ReadOnly);

			// monto
			$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, $this->monto->ReadOnly);

			// fecha_insercion
			$this->fecha_insercion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_insercion->CurrentValue, 7), NULL, $this->fecha_insercion->ReadOnly);

			// idcliente
			$this->idcliente->SetDbValueDef($rsnew, $this->idcliente->CurrentValue, 0, $this->idcliente->ReadOnly);

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
					if (in_array("detalle_documento_debito", $DetailTblVar) && $GLOBALS["detalle_documento_debito"]->DetailEdit) {
						if (!isset($GLOBALS["detalle_documento_debito_grid"])) $GLOBALS["detalle_documento_debito_grid"] = new cdetalle_documento_debito_grid(); // Get detail page object
						$EditRow = $GLOBALS["detalle_documento_debito_grid"]->GridUpdate();
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
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
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
			$this->setSessionWhere($this->GetDetailFilter());

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
				if ($GLOBALS["detalle_documento_debito_grid"]->DetailEdit) {
					$GLOBALS["detalle_documento_debito_grid"]->CurrentMode = "edit";
					$GLOBALS["detalle_documento_debito_grid"]->CurrentAction = "gridedit";

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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'documento_debito';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'documento_debito';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['iddocumento_debito'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
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
if (!isset($documento_debito_edit)) $documento_debito_edit = new cdocumento_debito_edit();

// Page init
$documento_debito_edit->Page_Init();

// Page main
$documento_debito_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_debito_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var documento_debito_edit = new ew_Page("documento_debito_edit");
documento_debito_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = documento_debito_edit.PageID; // For backward compatibility

// Form object
var fdocumento_debitoedit = new ew_Form("fdocumento_debitoedit");

// Validate form
fdocumento_debitoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_estado_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->estado_documento->FldCaption(), $documento_debito->estado_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->estado->FldCaption(), $documento_debito->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_anulacion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->fecha_anulacion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->monto->FldCaption(), $documento_debito->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->fecha_insercion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_debito->idcliente->FldCaption(), $documento_debito->idcliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcliente");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_debito->idcliente->FldErrMsg()) ?>");

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
fdocumento_debitoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_debitoedit.ValidateRequired = true;
<?php } else { ?>
fdocumento_debitoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_debitoedit.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $documento_debito_edit->ShowPageHeader(); ?>
<?php
$documento_debito_edit->ShowMessage();
?>
<form name="fdocumento_debitoedit" id="fdocumento_debitoedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_debito_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_debito_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_debito">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
	<div id="r_iddocumento_debito" class="form-group">
		<label id="elh_documento_debito_iddocumento_debito" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->iddocumento_debito->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->iddocumento_debito->CellAttributes() ?>>
<span id="el_documento_debito_iddocumento_debito">
<span<?php echo $documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_debito->iddocumento_debito->EditValue ?></p></span>
</span>
<input type="hidden" data-field="x_iddocumento_debito" name="x_iddocumento_debito" id="x_iddocumento_debito" value="<?php echo ew_HtmlEncode($documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php echo $documento_debito->iddocumento_debito->CustomMsg ?></div></div>
	</div>
<?php } ?>
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
<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
	<div id="r_estado_documento" class="form-group">
		<label id="elh_documento_debito_estado_documento" for="x_estado_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->estado_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->estado_documento->CellAttributes() ?>>
<span id="el_documento_debito_estado_documento">
<select data-field="x_estado_documento" id="x_estado_documento" name="x_estado_documento"<?php echo $documento_debito->estado_documento->EditAttributes() ?>>
<?php
if (is_array($documento_debito->estado_documento->EditValue)) {
	$arwrk = $documento_debito->estado_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->estado_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $documento_debito->estado_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_documento_debito_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->estado->CellAttributes() ?>>
<span id="el_documento_debito_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $documento_debito->estado->EditAttributes() ?>>
<?php
if (is_array($documento_debito->estado->EditValue)) {
	$arwrk = $documento_debito->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_debito->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $documento_debito->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->fecha_anulacion->Visible) { // fecha_anulacion ?>
	<div id="r_fecha_anulacion" class="form-group">
		<label id="elh_documento_debito_fecha_anulacion" for="x_fecha_anulacion" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->fecha_anulacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->fecha_anulacion->CellAttributes() ?>>
<span id="el_documento_debito_fecha_anulacion">
<input type="text" data-field="x_fecha_anulacion" name="x_fecha_anulacion" id="x_fecha_anulacion" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha_anulacion->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha_anulacion->EditValue ?>"<?php echo $documento_debito->fecha_anulacion->EditAttributes() ?>>
</span>
<?php echo $documento_debito->fecha_anulacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->motivo_anulacion->Visible) { // motivo_anulacion ?>
	<div id="r_motivo_anulacion" class="form-group">
		<label id="elh_documento_debito_motivo_anulacion" for="x_motivo_anulacion" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->motivo_anulacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->motivo_anulacion->CellAttributes() ?>>
<span id="el_documento_debito_motivo_anulacion">
<input type="text" data-field="x_motivo_anulacion" name="x_motivo_anulacion" id="x_motivo_anulacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($documento_debito->motivo_anulacion->PlaceHolder) ?>" value="<?php echo $documento_debito->motivo_anulacion->EditValue ?>"<?php echo $documento_debito->motivo_anulacion->EditAttributes() ?>>
</span>
<?php echo $documento_debito->motivo_anulacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_documento_debito_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->monto->CellAttributes() ?>>
<span id="el_documento_debito_monto">
<input type="text" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->monto->PlaceHolder) ?>" value="<?php echo $documento_debito->monto->EditValue ?>"<?php echo $documento_debito->monto->EditAttributes() ?>>
</span>
<?php echo $documento_debito->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
	<div id="r_fecha_insercion" class="form-group">
		<label id="elh_documento_debito_fecha_insercion" for="x_fecha_insercion" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->fecha_insercion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_debito_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x_fecha_insercion" id="x_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($documento_debito->fecha_insercion->PlaceHolder) ?>" value="<?php echo $documento_debito->fecha_insercion->EditValue ?>"<?php echo $documento_debito->fecha_insercion->EditAttributes() ?>>
</span>
<?php echo $documento_debito->fecha_insercion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
	<div id="r_idcliente" class="form-group">
		<label id="elh_documento_debito_idcliente" for="x_idcliente" class="col-sm-2 control-label ewLabel"><?php echo $documento_debito->idcliente->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_debito->idcliente->CellAttributes() ?>>
<span id="el_documento_debito_idcliente">
<input type="text" data-field="x_idcliente" name="x_idcliente" id="x_idcliente" size="30" placeholder="<?php echo ew_HtmlEncode($documento_debito->idcliente->PlaceHolder) ?>" value="<?php echo $documento_debito->idcliente->EditValue ?>"<?php echo $documento_debito->idcliente->EditAttributes() ?>>
</span>
<?php echo $documento_debito->idcliente->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("detalle_documento_debito", explode(",", $documento_debito->getCurrentDetailTable())) && $detalle_documento_debito->DetailEdit) {
?>
<?php if ($documento_debito->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_debito", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_debitogrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fdocumento_debitoedit.Init();
</script>
<?php
$documento_debito_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_debito_edit->Page_Terminate();
?>
