<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_transaccioninfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$cuenta_transaccion_view = NULL; // Initialize page object first

class ccuenta_transaccion_view extends ccuenta_transaccion {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'cuenta_transaccion';

	// Page object name
	var $PageObjName = 'cuenta_transaccion_view';

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

		// Table object (cuenta_transaccion)
		if (!isset($GLOBALS["cuenta_transaccion"]) || get_class($GLOBALS["cuenta_transaccion"]) == "ccuenta_transaccion") {
			$GLOBALS["cuenta_transaccion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta_transaccion"];
		}
		$KeyUrl = "";
		if (@$_GET["idcuenta_transaccion"] <> "") {
			$this->RecKey["idcuenta_transaccion"] = $_GET["idcuenta_transaccion"];
			$KeyUrl .= "&amp;idcuenta_transaccion=" . urlencode($this->RecKey["idcuenta_transaccion"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (cuenta)
		if (!isset($GLOBALS['cuenta'])) $GLOBALS['cuenta'] = new ccuenta();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta_transaccion', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("cuenta_transaccionlist.php"));
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
		if (@$_GET["idcuenta_transaccion"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["idcuenta_transaccion"]);
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
		$this->idcuenta_transaccion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $cuenta_transaccion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta_transaccion);
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
			if (@$_GET["idcuenta_transaccion"] <> "") {
				$this->idcuenta_transaccion->setQueryStringValue($_GET["idcuenta_transaccion"]);
				$this->RecKey["idcuenta_transaccion"] = $this->idcuenta_transaccion->QueryStringValue;
			} else {
				$sReturnUrl = "cuenta_transaccionlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cuenta_transaccionlist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "cuenta_transaccionlist.php"; // Not page request, return to list
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
		$this->idcuenta_transaccion->setDbValue($rs->fields('idcuenta_transaccion'));
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->id_referencia->setDbValue($rs->fields('id_referencia'));
		$this->tabla_referencia->setDbValue($rs->fields('tabla_referencia'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta_transaccion->DbValue = $row['idcuenta_transaccion'];
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->fecha->DbValue = $row['fecha'];
		$this->descripcion->DbValue = $row['descripcion'];
		$this->debito->DbValue = $row['debito'];
		$this->credito->DbValue = $row['credito'];
		$this->id_referencia->DbValue = $row['id_referencia'];
		$this->tabla_referencia->DbValue = $row['tabla_referencia'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
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
		if ($this->debito->FormValue == $this->debito->CurrentValue && is_numeric(ew_StrToFloat($this->debito->CurrentValue)))
			$this->debito->CurrentValue = ew_StrToFloat($this->debito->CurrentValue);

		// Convert decimal values if posted back
		if ($this->credito->FormValue == $this->credito->CurrentValue && is_numeric(ew_StrToFloat($this->credito->CurrentValue)))
			$this->credito->CurrentValue = ew_StrToFloat($this->credito->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta_transaccion
		// idcuenta
		// fecha
		// descripcion
		// debito
		// credito
		// id_referencia
		// tabla_referencia
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcuenta_transaccion
			$this->idcuenta_transaccion->ViewValue = $this->idcuenta_transaccion->CurrentValue;
			$this->idcuenta_transaccion->ViewCustomAttributes = "";

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

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// descripcion
			$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
			$this->descripcion->ViewCustomAttributes = "";

			// debito
			$this->debito->ViewValue = $this->debito->CurrentValue;
			$this->debito->ViewValue = ew_FormatNumber($this->debito->ViewValue, 2, -2, -2, -2);
			$this->debito->ViewCustomAttributes = "";

			// credito
			$this->credito->ViewValue = $this->credito->CurrentValue;
			$this->credito->ViewValue = ew_FormatNumber($this->credito->ViewValue, 2, -2, -2, -2);
			$this->credito->ViewCustomAttributes = "";

			// id_referencia
			$this->id_referencia->ViewValue = $this->id_referencia->CurrentValue;
			$this->id_referencia->ViewCustomAttributes = "";

			// tabla_referencia
			$this->tabla_referencia->ViewValue = $this->tabla_referencia->CurrentValue;
			$this->tabla_referencia->ViewCustomAttributes = "";

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

			// idcuenta_transaccion
			$this->idcuenta_transaccion->LinkCustomAttributes = "";
			$this->idcuenta_transaccion->HrefValue = "";
			$this->idcuenta_transaccion->TooltipValue = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
			$this->idcuenta->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";

			// debito
			$this->debito->LinkCustomAttributes = "";
			$this->debito->HrefValue = "";
			$this->debito->TooltipValue = "";

			// credito
			$this->credito->LinkCustomAttributes = "";
			$this->credito->HrefValue = "";
			$this->credito->TooltipValue = "";

			// id_referencia
			$this->id_referencia->LinkCustomAttributes = "";
			$this->id_referencia->HrefValue = "";
			$this->id_referencia->TooltipValue = "";

			// tabla_referencia
			$this->tabla_referencia->LinkCustomAttributes = "";
			$this->tabla_referencia->HrefValue = "";
			$this->tabla_referencia->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_cuenta_transaccion\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_cuenta_transaccion',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fcuenta_transaccionview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
			$this->setSessionWhere($this->GetDetailFilter());

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "cuenta_transaccionlist.php", "", $this->TableVar, TRUE);
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
if (!isset($cuenta_transaccion_view)) $cuenta_transaccion_view = new ccuenta_transaccion_view();

// Page init
$cuenta_transaccion_view->Page_Init();

// Page main
$cuenta_transaccion_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_transaccion_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<script type="text/javascript">

// Page object
var cuenta_transaccion_view = new ew_Page("cuenta_transaccion_view");
cuenta_transaccion_view.PageID = "view"; // Page ID
var EW_PAGE_ID = cuenta_transaccion_view.PageID; // For backward compatibility

// Form object
var fcuenta_transaccionview = new ew_Form("fcuenta_transaccionview");

// Form_CustomValidate event
fcuenta_transaccionview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_transaccionview.ValidateRequired = true;
<?php } else { ?>
fcuenta_transaccionview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_transaccionview.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","x_nombre","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<div class="ewToolbar">
<?php if ($cuenta_transaccion->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $cuenta_transaccion_view->ExportOptions->Render("body") ?>
<?php
	foreach ($cuenta_transaccion_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $cuenta_transaccion_view->ShowPageHeader(); ?>
<?php
$cuenta_transaccion_view->ShowMessage();
?>
<form name="fcuenta_transaccionview" id="fcuenta_transaccionview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_transaccion_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_transaccion_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_transaccion">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($cuenta_transaccion->idcuenta_transaccion->Visible) { // idcuenta_transaccion ?>
	<tr id="r_idcuenta_transaccion">
		<td><span id="elh_cuenta_transaccion_idcuenta_transaccion"><?php echo $cuenta_transaccion->idcuenta_transaccion->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->idcuenta_transaccion->CellAttributes() ?>>
<span id="el_cuenta_transaccion_idcuenta_transaccion" class="form-group">
<span<?php echo $cuenta_transaccion->idcuenta_transaccion->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->idcuenta_transaccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->idcuenta->Visible) { // idcuenta ?>
	<tr id="r_idcuenta">
		<td><span id="elh_cuenta_transaccion_idcuenta"><?php echo $cuenta_transaccion->idcuenta->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->idcuenta->CellAttributes() ?>>
<span id="el_cuenta_transaccion_idcuenta" class="form-group">
<span<?php echo $cuenta_transaccion->idcuenta->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->idcuenta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_cuenta_transaccion_fecha"><?php echo $cuenta_transaccion->fecha->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->fecha->CellAttributes() ?>>
<span id="el_cuenta_transaccion_fecha" class="form-group">
<span<?php echo $cuenta_transaccion->fecha->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->descripcion->Visible) { // descripcion ?>
	<tr id="r_descripcion">
		<td><span id="elh_cuenta_transaccion_descripcion"><?php echo $cuenta_transaccion->descripcion->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->descripcion->CellAttributes() ?>>
<span id="el_cuenta_transaccion_descripcion" class="form-group">
<span<?php echo $cuenta_transaccion->descripcion->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->descripcion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->debito->Visible) { // debito ?>
	<tr id="r_debito">
		<td><span id="elh_cuenta_transaccion_debito"><?php echo $cuenta_transaccion->debito->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->debito->CellAttributes() ?>>
<span id="el_cuenta_transaccion_debito" class="form-group">
<span<?php echo $cuenta_transaccion->debito->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->debito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->credito->Visible) { // credito ?>
	<tr id="r_credito">
		<td><span id="elh_cuenta_transaccion_credito"><?php echo $cuenta_transaccion->credito->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->credito->CellAttributes() ?>>
<span id="el_cuenta_transaccion_credito" class="form-group">
<span<?php echo $cuenta_transaccion->credito->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->credito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->id_referencia->Visible) { // id_referencia ?>
	<tr id="r_id_referencia">
		<td><span id="elh_cuenta_transaccion_id_referencia"><?php echo $cuenta_transaccion->id_referencia->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->id_referencia->CellAttributes() ?>>
<span id="el_cuenta_transaccion_id_referencia" class="form-group">
<span<?php echo $cuenta_transaccion->id_referencia->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->id_referencia->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->tabla_referencia->Visible) { // tabla_referencia ?>
	<tr id="r_tabla_referencia">
		<td><span id="elh_cuenta_transaccion_tabla_referencia"><?php echo $cuenta_transaccion->tabla_referencia->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->tabla_referencia->CellAttributes() ?>>
<span id="el_cuenta_transaccion_tabla_referencia" class="form-group">
<span<?php echo $cuenta_transaccion->tabla_referencia->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->tabla_referencia->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_cuenta_transaccion_estado"><?php echo $cuenta_transaccion->estado->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->estado->CellAttributes() ?>>
<span id="el_cuenta_transaccion_estado" class="form-group">
<span<?php echo $cuenta_transaccion->estado->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_transaccion->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_cuenta_transaccion_fecha_insercion"><?php echo $cuenta_transaccion->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $cuenta_transaccion->fecha_insercion->CellAttributes() ?>>
<span id="el_cuenta_transaccion_fecha_insercion" class="form-group">
<span<?php echo $cuenta_transaccion->fecha_insercion->ViewAttributes() ?>>
<?php echo $cuenta_transaccion->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fcuenta_transaccionview.Init();
</script>
<?php
$cuenta_transaccion_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($cuenta_transaccion->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$cuenta_transaccion_view->Page_Terminate();
?>
