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
<?php include_once $EW_RELATIVE_PATH . "cheque_clienteinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$pago_cliente_view = NULL; // Initialize page object first

class cpago_cliente_view extends cpago_cliente {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'pago_cliente';

	// Page object name
	var $PageObjName = 'pago_cliente_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["idpago_cliente"] <> "") {
			$this->RecKey["idpago_cliente"] = $_GET["idpago_cliente"];
			$KeyUrl .= "&amp;idpago_cliente=" . urlencode($this->RecKey["idpago_cliente"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

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

		// Table object (cheque_cliente)
		if (!isset($GLOBALS['cheque_cliente'])) $GLOBALS['cheque_cliente'] = new ccheque_cliente();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pago_cliente', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("pago_clientelist.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["idpago_cliente"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["idpago_cliente"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idpago_cliente"] <> "") {
				$this->idpago_cliente->setQueryStringValue($_GET["idpago_cliente"]);
				$this->RecKey["idpago_cliente"] = $this->idpago_cliente->QueryStringValue;
			} else {
				$sReturnUrl = "pago_clientelist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "pago_clientelist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "pago_clientelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Load List page SQL
		$sSql = $this->SelectSQL();

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->idcheque_cliente->setDbValue($rs->fields('idcheque_cliente'));
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
		$this->idcheque_cliente->DbValue = $row['idcheque_cliente'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		// idcheque_cliente

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

			// idcheque_cliente
			if (strval($this->idcheque_cliente->CurrentValue) <> "") {
				$sFilterWrk = "`idcheque_cliente`" . ew_SearchString("=", $this->idcheque_cliente->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcheque_cliente`, `numero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cheque_cliente`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcheque_cliente, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcheque_cliente->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idcheque_cliente->ViewValue = $this->idcheque_cliente->CurrentValue;
				}
			} else {
				$this->idcheque_cliente->ViewValue = NULL;
			}
			$this->idcheque_cliente->ViewCustomAttributes = "";

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

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

			// idboleta_deposito
			$this->idboleta_deposito->LinkCustomAttributes = "";
			$this->idboleta_deposito->HrefValue = "";
			$this->idboleta_deposito->TooltipValue = "";

			// idvoucher_tarjeta
			$this->idvoucher_tarjeta->LinkCustomAttributes = "";
			$this->idvoucher_tarjeta->HrefValue = "";
			$this->idvoucher_tarjeta->TooltipValue = "";

			// idcheque_cliente
			$this->idcheque_cliente->LinkCustomAttributes = "";
			$this->idcheque_cliente->HrefValue = "";
			$this->idcheque_cliente->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_pago_cliente\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pago_cliente',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpago_clienteview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Call Page Exported server event
		$this->Page_Exported();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
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
			if ($sMasterTblVar == "cheque_cliente") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcheque_cliente"] <> "") {
					$GLOBALS["cheque_cliente"]->idcheque_cliente->setQueryStringValue($_GET["fk_idcheque_cliente"]);
					$this->idcheque_cliente->setQueryStringValue($GLOBALS["cheque_cliente"]->idcheque_cliente->QueryStringValue);
					$this->idcheque_cliente->setSessionValue($this->idcheque_cliente->QueryStringValue);
					if (!is_numeric($GLOBALS["cheque_cliente"]->idcheque_cliente->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cheque_cliente") {
				if ($this->idcheque_cliente->QueryStringValue == "") $this->idcheque_cliente->setSessionValue("");
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
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, ew_CurrentUrl());
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pago_cliente_view)) $pago_cliente_view = new cpago_cliente_view();

// Page init
$pago_cliente_view->Page_Init();

// Page main
$pago_cliente_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pago_cliente_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">

// Page object
var pago_cliente_view = new ew_Page("pago_cliente_view");
pago_cliente_view.PageID = "view"; // Page ID
var EW_PAGE_ID = pago_cliente_view.PageID; // For backward compatibility

// Form object
var fpago_clienteview = new ew_Form("fpago_clienteview");

// Form_CustomValidate event
fpago_clienteview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpago_clienteview.ValidateRequired = true;
<?php } else { ?>
fpago_clienteview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpago_clienteview.Lists["x_idtipo_pago"] = {"LinkField":"x_idtipo_pago","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteview.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_codigo","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteview.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteview.Lists["x_idboleta_deposito"] = {"LinkField":"x_idboleta_deposito","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteview.Lists["x_idvoucher_tarjeta"] = {"LinkField":"x_idvoucher_tarjeta","Ajax":true,"AutoFill":false,"DisplayFields":["x_marca","x_marca","x_ultimos_cuatro_digitos",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clienteview.Lists["x_idcheque_cliente"] = {"LinkField":"x_idcheque_cliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($pago_cliente->Export == "") { ?>
<div class="ewToolbar">
<?php if ($pago_cliente->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $pago_cliente_view->ExportOptions->Render("body") ?>
<?php
	foreach ($pago_cliente_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($pago_cliente->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $pago_cliente_view->ShowPageHeader(); ?>
<?php
$pago_cliente_view->ShowMessage();
?>
<form name="fpago_clienteview" id="fpago_clienteview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pago_cliente_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pago_cliente_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pago_cliente">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($pago_cliente->idtipo_pago->Visible) { // idtipo_pago ?>
	<tr id="r_idtipo_pago">
		<td><span id="elh_pago_cliente_idtipo_pago"><?php echo $pago_cliente->idtipo_pago->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idtipo_pago->CellAttributes() ?>>
<span id="el_pago_cliente_idtipo_pago" class="form-group">
<span<?php echo $pago_cliente->idtipo_pago->ViewAttributes() ?>>
<?php echo $pago_cliente->idtipo_pago->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
	<tr id="r_idcliente">
		<td><span id="elh_pago_cliente_idcliente"><?php echo $pago_cliente->idcliente->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idcliente->CellAttributes() ?>>
<span id="el_pago_cliente_idcliente" class="form-group">
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<?php echo $pago_cliente->idcliente->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_pago_cliente_monto"><?php echo $pago_cliente->monto->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->monto->CellAttributes() ?>>
<span id="el_pago_cliente_monto" class="form-group">
<span<?php echo $pago_cliente->monto->ViewAttributes() ?>>
<?php echo $pago_cliente->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_pago_cliente_fecha"><?php echo $pago_cliente->fecha->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->fecha->CellAttributes() ?>>
<span id="el_pago_cliente_fecha" class="form-group">
<span<?php echo $pago_cliente->fecha->ViewAttributes() ?>>
<?php echo $pago_cliente->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_pago_cliente_estado"><?php echo $pago_cliente->estado->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->estado->CellAttributes() ?>>
<span id="el_pago_cliente_estado" class="form-group">
<span<?php echo $pago_cliente->estado->ViewAttributes() ?>>
<?php echo $pago_cliente->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_pago_cliente_fecha_insercion"><?php echo $pago_cliente->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->fecha_insercion->CellAttributes() ?>>
<span id="el_pago_cliente_fecha_insercion" class="form-group">
<span<?php echo $pago_cliente->fecha_insercion->ViewAttributes() ?>>
<?php echo $pago_cliente->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
	<tr id="r_idsucursal">
		<td><span id="elh_pago_cliente_idsucursal"><?php echo $pago_cliente->idsucursal->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idsucursal->CellAttributes() ?>>
<span id="el_pago_cliente_idsucursal" class="form-group">
<span<?php echo $pago_cliente->idsucursal->ViewAttributes() ?>>
<?php echo $pago_cliente->idsucursal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->idboleta_deposito->Visible) { // idboleta_deposito ?>
	<tr id="r_idboleta_deposito">
		<td><span id="elh_pago_cliente_idboleta_deposito"><?php echo $pago_cliente->idboleta_deposito->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idboleta_deposito->CellAttributes() ?>>
<span id="el_pago_cliente_idboleta_deposito" class="form-group">
<span<?php echo $pago_cliente->idboleta_deposito->ViewAttributes() ?>>
<?php echo $pago_cliente->idboleta_deposito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->idvoucher_tarjeta->Visible) { // idvoucher_tarjeta ?>
	<tr id="r_idvoucher_tarjeta">
		<td><span id="elh_pago_cliente_idvoucher_tarjeta"><?php echo $pago_cliente->idvoucher_tarjeta->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idvoucher_tarjeta->CellAttributes() ?>>
<span id="el_pago_cliente_idvoucher_tarjeta" class="form-group">
<span<?php echo $pago_cliente->idvoucher_tarjeta->ViewAttributes() ?>>
<?php echo $pago_cliente->idvoucher_tarjeta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pago_cliente->idcheque_cliente->Visible) { // idcheque_cliente ?>
	<tr id="r_idcheque_cliente">
		<td><span id="elh_pago_cliente_idcheque_cliente"><?php echo $pago_cliente->idcheque_cliente->FldCaption() ?></span></td>
		<td<?php echo $pago_cliente->idcheque_cliente->CellAttributes() ?>>
<span id="el_pago_cliente_idcheque_cliente" class="form-group">
<span<?php echo $pago_cliente->idcheque_cliente->ViewAttributes() ?>>
<?php echo $pago_cliente->idcheque_cliente->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fpago_clienteview.Init();
</script>
<?php
$pago_cliente_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$pago_cliente_view->Page_Terminate();
?>
