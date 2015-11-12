<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "detalle_documento_debitoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "documento_debitoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$detalle_documento_debito_view = NULL; // Initialize page object first

class cdetalle_documento_debito_view extends cdetalle_documento_debito {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'detalle_documento_debito';

	// Page object name
	var $PageObjName = 'detalle_documento_debito_view';

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

		// Table object (detalle_documento_debito)
		if (!isset($GLOBALS["detalle_documento_debito"]) || get_class($GLOBALS["detalle_documento_debito"]) == "cdetalle_documento_debito") {
			$GLOBALS["detalle_documento_debito"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detalle_documento_debito"];
		}
		$KeyUrl = "";
		if (@$_GET["iddetalle_documento_debito"] <> "") {
			$this->RecKey["iddetalle_documento_debito"] = $_GET["iddetalle_documento_debito"];
			$KeyUrl .= "&amp;iddetalle_documento_debito=" . urlencode($this->RecKey["iddetalle_documento_debito"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (documento_debito)
		if (!isset($GLOBALS['documento_debito'])) $GLOBALS['documento_debito'] = new cdocumento_debito();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_documento_debito', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("detalle_documento_debitolist.php"));
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
		if (@$_GET["iddetalle_documento_debito"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["iddetalle_documento_debito"]);
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
		global $EW_EXPORT, $detalle_documento_debito;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detalle_documento_debito);
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
			if (@$_GET["iddetalle_documento_debito"] <> "") {
				$this->iddetalle_documento_debito->setQueryStringValue($_GET["iddetalle_documento_debito"]);
				$this->RecKey["iddetalle_documento_debito"] = $this->iddetalle_documento_debito->QueryStringValue;
			} else {
				$sReturnUrl = "detalle_documento_debitolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "detalle_documento_debitolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "detalle_documento_debitolist.php"; // Not page request, return to list
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
		$option->UseDropDownButton = FALSE;
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
		$this->iddetalle_documento_debito->setDbValue($rs->fields('iddetalle_documento_debito'));
		$this->iddocumento_debito->setDbValue($rs->fields('iddocumento_debito'));
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idbodega->setDbValue($rs->fields('idbodega'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->precio->setDbValue($rs->fields('precio'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->importe_descuento->setDbValue($rs->fields('importe_descuento'));
		$this->importe_bruto->setDbValue($rs->fields('importe_bruto'));
		$this->importe_exento->setDbValue($rs->fields('importe_exento'));
		$this->importe_neto->setDbValue($rs->fields('importe_neto'));
		$this->importe_iva->setDbValue($rs->fields('importe_iva'));
		$this->importe_otros_impuestos->setDbValue($rs->fields('importe_otros_impuestos'));
		$this->importe_total->setDbValue($rs->fields('importe_total'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddetalle_documento_debito->DbValue = $row['iddetalle_documento_debito'];
		$this->iddocumento_debito->DbValue = $row['iddocumento_debito'];
		$this->idproducto->DbValue = $row['idproducto'];
		$this->idbodega->DbValue = $row['idbodega'];
		$this->cantidad->DbValue = $row['cantidad'];
		$this->precio->DbValue = $row['precio'];
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->importe_descuento->DbValue = $row['importe_descuento'];
		$this->importe_bruto->DbValue = $row['importe_bruto'];
		$this->importe_exento->DbValue = $row['importe_exento'];
		$this->importe_neto->DbValue = $row['importe_neto'];
		$this->importe_iva->DbValue = $row['importe_iva'];
		$this->importe_otros_impuestos->DbValue = $row['importe_otros_impuestos'];
		$this->importe_total->DbValue = $row['importe_total'];
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
		if ($this->precio->FormValue == $this->precio->CurrentValue && is_numeric(ew_StrToFloat($this->precio->CurrentValue)))
			$this->precio->CurrentValue = ew_StrToFloat($this->precio->CurrentValue);

		// Convert decimal values if posted back
		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_descuento->FormValue == $this->importe_descuento->CurrentValue && is_numeric(ew_StrToFloat($this->importe_descuento->CurrentValue)))
			$this->importe_descuento->CurrentValue = ew_StrToFloat($this->importe_descuento->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_bruto->FormValue == $this->importe_bruto->CurrentValue && is_numeric(ew_StrToFloat($this->importe_bruto->CurrentValue)))
			$this->importe_bruto->CurrentValue = ew_StrToFloat($this->importe_bruto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_exento->FormValue == $this->importe_exento->CurrentValue && is_numeric(ew_StrToFloat($this->importe_exento->CurrentValue)))
			$this->importe_exento->CurrentValue = ew_StrToFloat($this->importe_exento->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_neto->FormValue == $this->importe_neto->CurrentValue && is_numeric(ew_StrToFloat($this->importe_neto->CurrentValue)))
			$this->importe_neto->CurrentValue = ew_StrToFloat($this->importe_neto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_iva->FormValue == $this->importe_iva->CurrentValue && is_numeric(ew_StrToFloat($this->importe_iva->CurrentValue)))
			$this->importe_iva->CurrentValue = ew_StrToFloat($this->importe_iva->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_otros_impuestos->FormValue == $this->importe_otros_impuestos->CurrentValue && is_numeric(ew_StrToFloat($this->importe_otros_impuestos->CurrentValue)))
			$this->importe_otros_impuestos->CurrentValue = ew_StrToFloat($this->importe_otros_impuestos->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_total->FormValue == $this->importe_total->CurrentValue && is_numeric(ew_StrToFloat($this->importe_total->CurrentValue)))
			$this->importe_total->CurrentValue = ew_StrToFloat($this->importe_total->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// iddetalle_documento_debito
		// iddocumento_debito
		// idproducto
		// idbodega
		// cantidad
		// precio
		// monto
		// estado
		// fecha_insercion
		// importe_descuento
		// importe_bruto
		// importe_exento
		// importe_neto
		// importe_iva
		// importe_otros_impuestos
		// importe_total

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// iddetalle_documento_debito
			$this->iddetalle_documento_debito->ViewValue = $this->iddetalle_documento_debito->CurrentValue;
			$this->iddetalle_documento_debito->ViewCustomAttributes = "";

			// iddocumento_debito
			if (strval($this->iddocumento_debito->CurrentValue) <> "") {
				$sFilterWrk = "`iddocumento_debito`" . ew_SearchString("=", $this->iddocumento_debito->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->iddocumento_debito, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `correlativo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->iddocumento_debito->ViewValue = $rswrk->fields('DispFld');
					$this->iddocumento_debito->ViewValue .= ew_ValueSeparator(2,$this->iddocumento_debito) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->iddocumento_debito->ViewValue = $this->iddocumento_debito->CurrentValue;
				}
			} else {
				$this->iddocumento_debito->ViewValue = NULL;
			}
			$this->iddocumento_debito->ViewCustomAttributes = "";

			// idproducto
			if (strval($this->idproducto->CurrentValue) <> "") {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproducto, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idproducto->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idproducto->ViewValue = $this->idproducto->CurrentValue;
				}
			} else {
				$this->idproducto->ViewValue = NULL;
			}
			$this->idproducto->ViewCustomAttributes = "";

			// idbodega
			if (strval($this->idbodega->CurrentValue) <> "") {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idbodega, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `descripcion`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idbodega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idbodega->ViewValue = $this->idbodega->CurrentValue;
				}
			} else {
				$this->idbodega->ViewValue = NULL;
			}
			$this->idbodega->ViewCustomAttributes = "";

			// cantidad
			$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
			$this->cantidad->ViewCustomAttributes = "";

			// precio
			$this->precio->ViewValue = $this->precio->CurrentValue;
			$this->precio->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewCustomAttributes = "";

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

			// importe_descuento
			$this->importe_descuento->ViewValue = $this->importe_descuento->CurrentValue;
			$this->importe_descuento->ViewCustomAttributes = "";

			// importe_bruto
			$this->importe_bruto->ViewValue = $this->importe_bruto->CurrentValue;
			$this->importe_bruto->ViewCustomAttributes = "";

			// importe_exento
			$this->importe_exento->ViewValue = $this->importe_exento->CurrentValue;
			$this->importe_exento->ViewCustomAttributes = "";

			// importe_neto
			$this->importe_neto->ViewValue = $this->importe_neto->CurrentValue;
			$this->importe_neto->ViewCustomAttributes = "";

			// importe_iva
			$this->importe_iva->ViewValue = $this->importe_iva->CurrentValue;
			$this->importe_iva->ViewCustomAttributes = "";

			// importe_otros_impuestos
			$this->importe_otros_impuestos->ViewValue = $this->importe_otros_impuestos->CurrentValue;
			$this->importe_otros_impuestos->ViewCustomAttributes = "";

			// importe_total
			$this->importe_total->ViewValue = $this->importe_total->CurrentValue;
			$this->importe_total->ViewCustomAttributes = "";

			// iddocumento_debito
			$this->iddocumento_debito->LinkCustomAttributes = "";
			$this->iddocumento_debito->HrefValue = "";
			$this->iddocumento_debito->TooltipValue = "";

			// idproducto
			$this->idproducto->LinkCustomAttributes = "";
			$this->idproducto->HrefValue = "";
			$this->idproducto->TooltipValue = "";

			// idbodega
			$this->idbodega->LinkCustomAttributes = "";
			$this->idbodega->HrefValue = "";
			$this->idbodega->TooltipValue = "";

			// cantidad
			$this->cantidad->LinkCustomAttributes = "";
			$this->cantidad->HrefValue = "";
			$this->cantidad->TooltipValue = "";

			// precio
			$this->precio->LinkCustomAttributes = "";
			$this->precio->HrefValue = "";
			$this->precio->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// importe_descuento
			$this->importe_descuento->LinkCustomAttributes = "";
			$this->importe_descuento->HrefValue = "";
			$this->importe_descuento->TooltipValue = "";

			// importe_bruto
			$this->importe_bruto->LinkCustomAttributes = "";
			$this->importe_bruto->HrefValue = "";
			$this->importe_bruto->TooltipValue = "";

			// importe_exento
			$this->importe_exento->LinkCustomAttributes = "";
			$this->importe_exento->HrefValue = "";
			$this->importe_exento->TooltipValue = "";

			// importe_neto
			$this->importe_neto->LinkCustomAttributes = "";
			$this->importe_neto->HrefValue = "";
			$this->importe_neto->TooltipValue = "";

			// importe_iva
			$this->importe_iva->LinkCustomAttributes = "";
			$this->importe_iva->HrefValue = "";
			$this->importe_iva->TooltipValue = "";

			// importe_otros_impuestos
			$this->importe_otros_impuestos->LinkCustomAttributes = "";
			$this->importe_otros_impuestos->HrefValue = "";
			$this->importe_otros_impuestos->TooltipValue = "";

			// importe_total
			$this->importe_total->LinkCustomAttributes = "";
			$this->importe_total->HrefValue = "";
			$this->importe_total->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_detalle_documento_debito\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_detalle_documento_debito',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdetalle_documento_debitoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
			if ($sMasterTblVar == "documento_debito") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_iddocumento_debito"] <> "") {
					$GLOBALS["documento_debito"]->iddocumento_debito->setQueryStringValue($_GET["fk_iddocumento_debito"]);
					$this->iddocumento_debito->setQueryStringValue($GLOBALS["documento_debito"]->iddocumento_debito->QueryStringValue);
					$this->iddocumento_debito->setSessionValue($this->iddocumento_debito->QueryStringValue);
					if (!is_numeric($GLOBALS["documento_debito"]->iddocumento_debito->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "documento_debito") {
				if ($this->iddocumento_debito->QueryStringValue == "") $this->iddocumento_debito->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "detalle_documento_debitolist.php", "", $this->TableVar, TRUE);
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
if (!isset($detalle_documento_debito_view)) $detalle_documento_debito_view = new cdetalle_documento_debito_view();

// Page init
$detalle_documento_debito_view->Page_Init();

// Page main
$detalle_documento_debito_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_debito_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_debito_view = new ew_Page("detalle_documento_debito_view");
detalle_documento_debito_view.PageID = "view"; // Page ID
var EW_PAGE_ID = detalle_documento_debito_view.PageID; // For backward compatibility

// Form object
var fdetalle_documento_debitoview = new ew_Form("fdetalle_documento_debitoview");

// Form_CustomValidate event
fdetalle_documento_debitoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_debitoview.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_debitoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_debitoview.Lists["x_iddocumento_debito"] = {"LinkField":"x_iddocumento_debito","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitoview.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitoview.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<div class="ewToolbar">
<?php if ($detalle_documento_debito->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $detalle_documento_debito_view->ExportOptions->Render("body") ?>
<?php
	foreach ($detalle_documento_debito_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $detalle_documento_debito_view->ShowPageHeader(); ?>
<?php
$detalle_documento_debito_view->ShowMessage();
?>
<form name="fdetalle_documento_debitoview" id="fdetalle_documento_debitoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_documento_debito_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_documento_debito_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_documento_debito">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
	<tr id="r_iddocumento_debito">
		<td><span id="elh_detalle_documento_debito_iddocumento_debito"><?php echo $detalle_documento_debito->iddocumento_debito->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->iddocumento_debito->CellAttributes() ?>>
<span id="el_detalle_documento_debito_iddocumento_debito" class="form-group">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
	<tr id="r_idproducto">
		<td><span id="elh_detalle_documento_debito_idproducto"><?php echo $detalle_documento_debito->idproducto->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->idproducto->CellAttributes() ?>>
<span id="el_detalle_documento_debito_idproducto" class="form-group">
<span<?php echo $detalle_documento_debito->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idproducto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
	<tr id="r_idbodega">
		<td><span id="elh_detalle_documento_debito_idbodega"><?php echo $detalle_documento_debito->idbodega->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->idbodega->CellAttributes() ?>>
<span id="el_detalle_documento_debito_idbodega" class="form-group">
<span<?php echo $detalle_documento_debito->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idbodega->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
	<tr id="r_cantidad">
		<td><span id="elh_detalle_documento_debito_cantidad"><?php echo $detalle_documento_debito->cantidad->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->cantidad->CellAttributes() ?>>
<span id="el_detalle_documento_debito_cantidad" class="form-group">
<span<?php echo $detalle_documento_debito->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->cantidad->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
	<tr id="r_precio">
		<td><span id="elh_detalle_documento_debito_precio"><?php echo $detalle_documento_debito->precio->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->precio->CellAttributes() ?>>
<span id="el_detalle_documento_debito_precio" class="form-group">
<span<?php echo $detalle_documento_debito->precio->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->precio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_detalle_documento_debito_monto"><?php echo $detalle_documento_debito->monto->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->monto->CellAttributes() ?>>
<span id="el_detalle_documento_debito_monto" class="form-group">
<span<?php echo $detalle_documento_debito->monto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_detalle_documento_debito_estado"><?php echo $detalle_documento_debito->estado->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->estado->CellAttributes() ?>>
<span id="el_detalle_documento_debito_estado" class="form-group">
<span<?php echo $detalle_documento_debito->estado->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_detalle_documento_debito_fecha_insercion"><?php echo $detalle_documento_debito->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->fecha_insercion->CellAttributes() ?>>
<span id="el_detalle_documento_debito_fecha_insercion" class="form-group">
<span<?php echo $detalle_documento_debito->fecha_insercion->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_descuento->Visible) { // importe_descuento ?>
	<tr id="r_importe_descuento">
		<td><span id="elh_detalle_documento_debito_importe_descuento"><?php echo $detalle_documento_debito->importe_descuento->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_descuento->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_descuento" class="form-group">
<span<?php echo $detalle_documento_debito->importe_descuento->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_descuento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_bruto->Visible) { // importe_bruto ?>
	<tr id="r_importe_bruto">
		<td><span id="elh_detalle_documento_debito_importe_bruto"><?php echo $detalle_documento_debito->importe_bruto->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_bruto->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_bruto" class="form-group">
<span<?php echo $detalle_documento_debito->importe_bruto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_bruto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_exento->Visible) { // importe_exento ?>
	<tr id="r_importe_exento">
		<td><span id="elh_detalle_documento_debito_importe_exento"><?php echo $detalle_documento_debito->importe_exento->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_exento->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_exento" class="form-group">
<span<?php echo $detalle_documento_debito->importe_exento->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_exento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_neto->Visible) { // importe_neto ?>
	<tr id="r_importe_neto">
		<td><span id="elh_detalle_documento_debito_importe_neto"><?php echo $detalle_documento_debito->importe_neto->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_neto->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_neto" class="form-group">
<span<?php echo $detalle_documento_debito->importe_neto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_neto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_iva->Visible) { // importe_iva ?>
	<tr id="r_importe_iva">
		<td><span id="elh_detalle_documento_debito_importe_iva"><?php echo $detalle_documento_debito->importe_iva->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_iva->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_iva" class="form-group">
<span<?php echo $detalle_documento_debito->importe_iva->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_iva->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_otros_impuestos->Visible) { // importe_otros_impuestos ?>
	<tr id="r_importe_otros_impuestos">
		<td><span id="elh_detalle_documento_debito_importe_otros_impuestos"><?php echo $detalle_documento_debito->importe_otros_impuestos->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_otros_impuestos->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_otros_impuestos" class="form-group">
<span<?php echo $detalle_documento_debito->importe_otros_impuestos->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_otros_impuestos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detalle_documento_debito->importe_total->Visible) { // importe_total ?>
	<tr id="r_importe_total">
		<td><span id="elh_detalle_documento_debito_importe_total"><?php echo $detalle_documento_debito->importe_total->FldCaption() ?></span></td>
		<td<?php echo $detalle_documento_debito->importe_total->CellAttributes() ?>>
<span id="el_detalle_documento_debito_importe_total" class="form-group">
<span<?php echo $detalle_documento_debito->importe_total->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->importe_total->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fdetalle_documento_debitoview.Init();
</script>
<?php
$detalle_documento_debito_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$detalle_documento_debito_view->Page_Terminate();
?>
