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

$fecha_contable_view = NULL; // Initialize page object first

class cfecha_contable_view extends cfecha_contable {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'fecha_contable';

	// Page object name
	var $PageObjName = 'fecha_contable_view';

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

		// Table object (fecha_contable)
		if (!isset($GLOBALS["fecha_contable"]) || get_class($GLOBALS["fecha_contable"]) == "cfecha_contable") {
			$GLOBALS["fecha_contable"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["fecha_contable"];
		}
		$KeyUrl = "";
		if (@$_GET["idfecha_contable"] <> "") {
			$this->RecKey["idfecha_contable"] = $_GET["idfecha_contable"];
			$KeyUrl .= "&amp;idfecha_contable=" . urlencode($this->RecKey["idfecha_contable"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fecha_contable', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("fecha_contablelist.php"));
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
		if (@$_GET["idfecha_contable"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["idfecha_contable"]);
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
		$this->idfecha_contable->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			if (@$_GET["idfecha_contable"] <> "") {
				$this->idfecha_contable->setQueryStringValue($_GET["idfecha_contable"]);
				$this->RecKey["idfecha_contable"] = $this->idfecha_contable->QueryStringValue;
			} else {
				$sReturnUrl = "fecha_contablelist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "fecha_contablelist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "fecha_contablelist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

			// idfecha_contable
			$this->idfecha_contable->LinkCustomAttributes = "";
			$this->idfecha_contable->HrefValue = "";
			$this->idfecha_contable->TooltipValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";
			$this->idperiodo_contable->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

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
		$item->Body = "<button id=\"emf_fecha_contable\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_fecha_contable',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ffecha_contableview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($fecha_contable_view)) $fecha_contable_view = new cfecha_contable_view();

// Page init
$fecha_contable_view->Page_Init();

// Page main
$fecha_contable_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fecha_contable_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">

// Page object
var fecha_contable_view = new ew_Page("fecha_contable_view");
fecha_contable_view.PageID = "view"; // Page ID
var EW_PAGE_ID = fecha_contable_view.PageID; // For backward compatibility

// Form object
var ffecha_contableview = new ew_Form("ffecha_contableview");

// Form_CustomValidate event
ffecha_contableview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffecha_contableview.ValidateRequired = true;
<?php } else { ?>
ffecha_contableview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffecha_contableview.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ffecha_contableview.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($fecha_contable->Export == "") { ?>
<div class="ewToolbar">
<?php if ($fecha_contable->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $fecha_contable_view->ExportOptions->Render("body") ?>
<?php
	foreach ($fecha_contable_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($fecha_contable->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $fecha_contable_view->ShowPageHeader(); ?>
<?php
$fecha_contable_view->ShowMessage();
?>
<form name="ffecha_contableview" id="ffecha_contableview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($fecha_contable_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $fecha_contable_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fecha_contable">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($fecha_contable->idfecha_contable->Visible) { // idfecha_contable ?>
	<tr id="r_idfecha_contable">
		<td><span id="elh_fecha_contable_idfecha_contable"><?php echo $fecha_contable->idfecha_contable->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->idfecha_contable->CellAttributes() ?>>
<span id="el_fecha_contable_idfecha_contable" class="form-group">
<span<?php echo $fecha_contable->idfecha_contable->ViewAttributes() ?>>
<?php echo $fecha_contable->idfecha_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<tr id="r_idperiodo_contable">
		<td><span id="elh_fecha_contable_idperiodo_contable"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->idperiodo_contable->CellAttributes() ?>>
<span id="el_fecha_contable_idperiodo_contable" class="form-group">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<?php echo $fecha_contable->idperiodo_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_fecha_contable_fecha"><?php echo $fecha_contable->fecha->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->fecha->CellAttributes() ?>>
<span id="el_fecha_contable_fecha" class="form-group">
<span<?php echo $fecha_contable->fecha->ViewAttributes() ?>>
<?php echo $fecha_contable->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
	<tr id="r_estado_documento_debito">
		<td><span id="elh_fecha_contable_estado_documento_debito"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->estado_documento_debito->CellAttributes() ?>>
<span id="el_fecha_contable_estado_documento_debito" class="form-group">
<span<?php echo $fecha_contable->estado_documento_debito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_debito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
	<tr id="r_estado_documento_credito">
		<td><span id="elh_fecha_contable_estado_documento_credito"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->estado_documento_credito->CellAttributes() ?>>
<span id="el_fecha_contable_estado_documento_credito" class="form-group">
<span<?php echo $fecha_contable->estado_documento_credito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_credito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
	<tr id="r_estado_pago_cliente">
		<td><span id="elh_fecha_contable_estado_pago_cliente"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->estado_pago_cliente->CellAttributes() ?>>
<span id="el_fecha_contable_estado_pago_cliente" class="form-group">
<span<?php echo $fecha_contable->estado_pago_cliente->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_cliente->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
	<tr id="r_estado_pago_proveedor">
		<td><span id="elh_fecha_contable_estado_pago_proveedor"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->estado_pago_proveedor->CellAttributes() ?>>
<span id="el_fecha_contable_estado_pago_proveedor" class="form-group">
<span<?php echo $fecha_contable->estado_pago_proveedor->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_proveedor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
	<tr id="r_idempresa">
		<td><span id="elh_fecha_contable_idempresa"><?php echo $fecha_contable->idempresa->FldCaption() ?></span></td>
		<td<?php echo $fecha_contable->idempresa->CellAttributes() ?>>
<span id="el_fecha_contable_idempresa" class="form-group">
<span<?php echo $fecha_contable->idempresa->ViewAttributes() ?>>
<?php echo $fecha_contable->idempresa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ffecha_contableview.Init();
</script>
<?php
$fecha_contable_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$fecha_contable_view->Page_Terminate();
?>
