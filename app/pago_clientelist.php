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

$pago_cliente_list = NULL; // Initialize page object first

class cpago_cliente_list extends cpago_cliente {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'pago_cliente';

	// Page object name
	var $PageObjName = 'pago_cliente_list';

	// Grid form hidden field names
	var $FormName = 'fpago_clientelist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pago_clienteadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pago_clientedelete.php";
		$this->MultiUpdateUrl = "pago_clienteupdate.php";

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
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pago_cliente', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("login.php"));
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cliente") {
			global $cliente;
			$rsmaster = $cliente->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("clientelist.php"); // Return to master page
			} else {
				$cliente->LoadListRowValues($rsmaster);
				$cliente->RowType = EW_ROWTYPE_MASTER; // Master row
				$cliente->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "tipo_pago") {
			global $tipo_pago;
			$rsmaster = $tipo_pago->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("tipo_pagolist.php"); // Return to master page
			} else {
				$tipo_pago->LoadListRowValues($rsmaster);
				$tipo_pago->RowType = EW_ROWTYPE_MASTER; // Master row
				$tipo_pago->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "boleta_deposito") {
			global $boleta_deposito;
			$rsmaster = $boleta_deposito->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("boleta_depositolist.php"); // Return to master page
			} else {
				$boleta_deposito->LoadListRowValues($rsmaster);
				$boleta_deposito->RowType = EW_ROWTYPE_MASTER; // Master row
				$boleta_deposito->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "voucher_tarjeta") {
			global $voucher_tarjeta;
			$rsmaster = $voucher_tarjeta->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("voucher_tarjetalist.php"); // Return to master page
			} else {
				$voucher_tarjeta->LoadListRowValues($rsmaster);
				$voucher_tarjeta->RowType = EW_ROWTYPE_MASTER; // Master row
				$voucher_tarjeta->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cheque_cliente") {
			global $cheque_cliente;
			$rsmaster = $cheque_cliente->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cheque_clientelist.php"); // Return to master page
			} else {
				$cheque_cliente->LoadListRowValues($rsmaster);
				$cheque_cliente->RowType = EW_ROWTYPE_MASTER; // Master row
				$cheque_cliente->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount();
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->idpago_cliente->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idpago_cliente->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->idtipo_pago); // idtipo_pago
			$this->UpdateSort($this->idcliente); // idcliente
			$this->UpdateSort($this->monto); // monto
			$this->UpdateSort($this->fecha); // fecha
			$this->UpdateSort($this->idsucursal); // idsucursal
			$this->UpdateSort($this->idboleta_deposito); // idboleta_deposito
			$this->UpdateSort($this->idvoucher_tarjeta); // idvoucher_tarjeta
			$this->UpdateSort($this->idcheque_cliente); // idcheque_cliente
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idcliente->setSessionValue("");
				$this->idtipo_pago->setSessionValue("");
				$this->idboleta_deposito->setSessionValue("");
				$this->idvoucher_tarjeta->setSessionValue("");
				$this->idcheque_cliente->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->idtipo_pago->setSort("");
				$this->idcliente->setSort("");
				$this->monto->setSort("");
				$this->fecha->setSort("");
				$this->idsucursal->setSort("");
				$this->idboleta_deposito->setSort("");
				$this->idvoucher_tarjeta->setSort("");
				$this->idcheque_cliente->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idpago_cliente->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fpago_clientelist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch())
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Body = "<button id=\"emf_pago_cliente\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_pago_cliente',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpago_clientelist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cliente") {
			global $cliente;
			if (!isset($cliente)) $cliente = new ccliente;
			$rsmaster = $cliente->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cliente->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "tipo_pago") {
			global $tipo_pago;
			if (!isset($tipo_pago)) $tipo_pago = new ctipo_pago;
			$rsmaster = $tipo_pago->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$tipo_pago->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "boleta_deposito") {
			global $boleta_deposito;
			if (!isset($boleta_deposito)) $boleta_deposito = new cboleta_deposito;
			$rsmaster = $boleta_deposito->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$boleta_deposito->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "voucher_tarjeta") {
			global $voucher_tarjeta;
			if (!isset($voucher_tarjeta)) $voucher_tarjeta = new cvoucher_tarjeta;
			$rsmaster = $voucher_tarjeta->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$voucher_tarjeta->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cheque_cliente") {
			global $cheque_cliente;
			if (!isset($cheque_cliente)) $cheque_cliente = new ccheque_cliente;
			$rsmaster = $cheque_cliente->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$cheque_cliente->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
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
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'pago_cliente';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($pago_cliente_list)) $pago_cliente_list = new cpago_cliente_list();

// Page init
$pago_cliente_list->Page_Init();

// Page main
$pago_cliente_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pago_cliente_list->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">

// Page object
var pago_cliente_list = new ew_Page("pago_cliente_list");
pago_cliente_list.PageID = "list"; // Page ID
var EW_PAGE_ID = pago_cliente_list.PageID; // For backward compatibility

// Form object
var fpago_clientelist = new ew_Form("fpago_clientelist");
fpago_clientelist.FormKeyCountName = '<?php echo $pago_cliente_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpago_clientelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpago_clientelist.ValidateRequired = true;
<?php } else { ?>
fpago_clientelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpago_clientelist.Lists["x_idtipo_pago"] = {"LinkField":"x_idtipo_pago","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientelist.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_codigo","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientelist.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientelist.Lists["x_idboleta_deposito"] = {"LinkField":"x_idboleta_deposito","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientelist.Lists["x_idvoucher_tarjeta"] = {"LinkField":"x_idvoucher_tarjeta","Ajax":true,"AutoFill":false,"DisplayFields":["x_marca","x_marca","x_ultimos_cuatro_digitos",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fpago_clientelist.Lists["x_idcheque_cliente"] = {"LinkField":"x_idcheque_cliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_numero","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php if ($pago_cliente_list->TotalRecs > 0 && $pago_cliente->getCurrentMasterTable() == "" && $pago_cliente_list->ExportOptions->Visible()) { ?>
<?php $pago_cliente_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pago_cliente->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($pago_cliente->Export == "") || (EW_EXPORT_MASTER_RECORD && $pago_cliente->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "clientelist.php";
if ($pago_cliente_list->DbMasterFilter <> "" && $pago_cliente->getCurrentMasterTable() == "cliente") {
	if ($pago_cliente_list->MasterRecordExists) {
		if ($pago_cliente->getCurrentMasterTable() == $pago_cliente->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pago_cliente_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pago_cliente_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "clientemaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "tipo_pagolist.php";
if ($pago_cliente_list->DbMasterFilter <> "" && $pago_cliente->getCurrentMasterTable() == "tipo_pago") {
	if ($pago_cliente_list->MasterRecordExists) {
		if ($pago_cliente->getCurrentMasterTable() == $pago_cliente->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pago_cliente_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pago_cliente_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "tipo_pagomaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "boleta_depositolist.php";
if ($pago_cliente_list->DbMasterFilter <> "" && $pago_cliente->getCurrentMasterTable() == "boleta_deposito") {
	if ($pago_cliente_list->MasterRecordExists) {
		if ($pago_cliente->getCurrentMasterTable() == $pago_cliente->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pago_cliente_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pago_cliente_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "boleta_depositomaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "voucher_tarjetalist.php";
if ($pago_cliente_list->DbMasterFilter <> "" && $pago_cliente->getCurrentMasterTable() == "voucher_tarjeta") {
	if ($pago_cliente_list->MasterRecordExists) {
		if ($pago_cliente->getCurrentMasterTable() == $pago_cliente->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pago_cliente_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pago_cliente_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "voucher_tarjetamaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "cheque_clientelist.php";
if ($pago_cliente_list->DbMasterFilter <> "" && $pago_cliente->getCurrentMasterTable() == "cheque_cliente") {
	if ($pago_cliente_list->MasterRecordExists) {
		if ($pago_cliente->getCurrentMasterTable() == $pago_cliente->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($pago_cliente_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $pago_cliente_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "cheque_clientemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$pago_cliente_list->TotalRecs = $pago_cliente->SelectRecordCount();
	} else {
		if ($pago_cliente_list->Recordset = $pago_cliente_list->LoadRecordset())
			$pago_cliente_list->TotalRecs = $pago_cliente_list->Recordset->RecordCount();
	}
	$pago_cliente_list->StartRec = 1;
	if ($pago_cliente_list->DisplayRecs <= 0 || ($pago_cliente->Export <> "" && $pago_cliente->ExportAll)) // Display all records
		$pago_cliente_list->DisplayRecs = $pago_cliente_list->TotalRecs;
	if (!($pago_cliente->Export <> "" && $pago_cliente->ExportAll))
		$pago_cliente_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pago_cliente_list->Recordset = $pago_cliente_list->LoadRecordset($pago_cliente_list->StartRec-1, $pago_cliente_list->DisplayRecs);

	// Set no record found message
	if ($pago_cliente->CurrentAction == "" && $pago_cliente_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pago_cliente_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($pago_cliente_list->SearchWhere == "0=101")
			$pago_cliente_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pago_cliente_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pago_cliente_list->RenderOtherOptions();
?>
<?php $pago_cliente_list->ShowPageHeader(); ?>
<?php
$pago_cliente_list->ShowMessage();
?>
<?php if ($pago_cliente_list->TotalRecs > 0 || $pago_cliente->CurrentAction <> "") { ?>
<div class="ewGrid">
<form name="fpago_clientelist" id="fpago_clientelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pago_cliente_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pago_cliente_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pago_cliente">
<div id="gmp_pago_cliente" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($pago_cliente_list->TotalRecs > 0) { ?>
<table id="tbl_pago_clientelist" class="table ewTable">
<?php echo $pago_cliente->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$pago_cliente_list->RenderListOptions();

// Render list options (header, left)
$pago_cliente_list->ListOptions->Render("header", "left");
?>
<?php if ($pago_cliente->idtipo_pago->Visible) { // idtipo_pago ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idtipo_pago) == "") { ?>
		<th data-name="idtipo_pago"><div id="elh_pago_cliente_idtipo_pago" class="pago_cliente_idtipo_pago"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idtipo_pago->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_pago"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idtipo_pago) ?>',1);"><div id="elh_pago_cliente_idtipo_pago" class="pago_cliente_idtipo_pago">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idtipo_pago->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idtipo_pago->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idtipo_pago->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idcliente) == "") { ?>
		<th data-name="idcliente"><div id="elh_pago_cliente_idcliente" class="pago_cliente_idcliente"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idcliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcliente"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idcliente) ?>',1);"><div id="elh_pago_cliente_idcliente" class="pago_cliente_idcliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idcliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idcliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idcliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->monto->Visible) { // monto ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->monto) == "") { ?>
		<th data-name="monto"><div id="elh_pago_cliente_monto" class="pago_cliente_monto"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->monto) ?>',1);"><div id="elh_pago_cliente_monto" class="pago_cliente_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_pago_cliente_fecha" class="pago_cliente_fecha"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->fecha) ?>',1);"><div id="elh_pago_cliente_fecha" class="pago_cliente_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idsucursal) == "") { ?>
		<th data-name="idsucursal"><div id="elh_pago_cliente_idsucursal" class="pago_cliente_idsucursal"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idsucursal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsucursal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idsucursal) ?>',1);"><div id="elh_pago_cliente_idsucursal" class="pago_cliente_idsucursal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idsucursal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idsucursal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idsucursal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idboleta_deposito->Visible) { // idboleta_deposito ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idboleta_deposito) == "") { ?>
		<th data-name="idboleta_deposito"><div id="elh_pago_cliente_idboleta_deposito" class="pago_cliente_idboleta_deposito"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idboleta_deposito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idboleta_deposito"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idboleta_deposito) ?>',1);"><div id="elh_pago_cliente_idboleta_deposito" class="pago_cliente_idboleta_deposito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idboleta_deposito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idboleta_deposito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idboleta_deposito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idvoucher_tarjeta->Visible) { // idvoucher_tarjeta ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idvoucher_tarjeta) == "") { ?>
		<th data-name="idvoucher_tarjeta"><div id="elh_pago_cliente_idvoucher_tarjeta" class="pago_cliente_idvoucher_tarjeta"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idvoucher_tarjeta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idvoucher_tarjeta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idvoucher_tarjeta) ?>',1);"><div id="elh_pago_cliente_idvoucher_tarjeta" class="pago_cliente_idvoucher_tarjeta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idvoucher_tarjeta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idvoucher_tarjeta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idvoucher_tarjeta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pago_cliente->idcheque_cliente->Visible) { // idcheque_cliente ?>
	<?php if ($pago_cliente->SortUrl($pago_cliente->idcheque_cliente) == "") { ?>
		<th data-name="idcheque_cliente"><div id="elh_pago_cliente_idcheque_cliente" class="pago_cliente_idcheque_cliente"><div class="ewTableHeaderCaption"><?php echo $pago_cliente->idcheque_cliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcheque_cliente"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pago_cliente->SortUrl($pago_cliente->idcheque_cliente) ?>',1);"><div id="elh_pago_cliente_idcheque_cliente" class="pago_cliente_idcheque_cliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pago_cliente->idcheque_cliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pago_cliente->idcheque_cliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($pago_cliente->idcheque_cliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pago_cliente_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pago_cliente->ExportAll && $pago_cliente->Export <> "") {
	$pago_cliente_list->StopRec = $pago_cliente_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pago_cliente_list->TotalRecs > $pago_cliente_list->StartRec + $pago_cliente_list->DisplayRecs - 1)
		$pago_cliente_list->StopRec = $pago_cliente_list->StartRec + $pago_cliente_list->DisplayRecs - 1;
	else
		$pago_cliente_list->StopRec = $pago_cliente_list->TotalRecs;
}
$pago_cliente_list->RecCnt = $pago_cliente_list->StartRec - 1;
if ($pago_cliente_list->Recordset && !$pago_cliente_list->Recordset->EOF) {
	$pago_cliente_list->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $pago_cliente_list->StartRec > 1)
		$pago_cliente_list->Recordset->Move($pago_cliente_list->StartRec - 1);
} elseif (!$pago_cliente->AllowAddDeleteRow && $pago_cliente_list->StopRec == 0) {
	$pago_cliente_list->StopRec = $pago_cliente->GridAddRowCount;
}

// Initialize aggregate
$pago_cliente->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pago_cliente->ResetAttrs();
$pago_cliente_list->RenderRow();
while ($pago_cliente_list->RecCnt < $pago_cliente_list->StopRec) {
	$pago_cliente_list->RecCnt++;
	if (intval($pago_cliente_list->RecCnt) >= intval($pago_cliente_list->StartRec)) {
		$pago_cliente_list->RowCnt++;

		// Set up key count
		$pago_cliente_list->KeyCount = $pago_cliente_list->RowIndex;

		// Init row class and style
		$pago_cliente->ResetAttrs();
		$pago_cliente->CssClass = "";
		if ($pago_cliente->CurrentAction == "gridadd") {
		} else {
			$pago_cliente_list->LoadRowValues($pago_cliente_list->Recordset); // Load row values
		}
		$pago_cliente->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pago_cliente->RowAttrs = array_merge($pago_cliente->RowAttrs, array('data-rowindex'=>$pago_cliente_list->RowCnt, 'id'=>'r' . $pago_cliente_list->RowCnt . '_pago_cliente', 'data-rowtype'=>$pago_cliente->RowType));

		// Render row
		$pago_cliente_list->RenderRow();

		// Render list options
		$pago_cliente_list->RenderListOptions();
?>
	<tr<?php echo $pago_cliente->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pago_cliente_list->ListOptions->Render("body", "left", $pago_cliente_list->RowCnt);
?>
	<?php if ($pago_cliente->idtipo_pago->Visible) { // idtipo_pago ?>
		<td data-name="idtipo_pago"<?php echo $pago_cliente->idtipo_pago->CellAttributes() ?>>
<span<?php echo $pago_cliente->idtipo_pago->ViewAttributes() ?>>
<?php echo $pago_cliente->idtipo_pago->ListViewValue() ?></span>
<a id="<?php echo $pago_cliente_list->PageObjName . "_row_" . $pago_cliente_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pago_cliente->idcliente->Visible) { // idcliente ?>
		<td data-name="idcliente"<?php echo $pago_cliente->idcliente->CellAttributes() ?>>
<span<?php echo $pago_cliente->idcliente->ViewAttributes() ?>>
<?php echo $pago_cliente->idcliente->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $pago_cliente->monto->CellAttributes() ?>>
<span<?php echo $pago_cliente->monto->ViewAttributes() ?>>
<?php echo $pago_cliente->monto->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $pago_cliente->fecha->CellAttributes() ?>>
<span<?php echo $pago_cliente->fecha->ViewAttributes() ?>>
<?php echo $pago_cliente->fecha->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->idsucursal->Visible) { // idsucursal ?>
		<td data-name="idsucursal"<?php echo $pago_cliente->idsucursal->CellAttributes() ?>>
<span<?php echo $pago_cliente->idsucursal->ViewAttributes() ?>>
<?php echo $pago_cliente->idsucursal->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->idboleta_deposito->Visible) { // idboleta_deposito ?>
		<td data-name="idboleta_deposito"<?php echo $pago_cliente->idboleta_deposito->CellAttributes() ?>>
<span<?php echo $pago_cliente->idboleta_deposito->ViewAttributes() ?>>
<?php echo $pago_cliente->idboleta_deposito->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->idvoucher_tarjeta->Visible) { // idvoucher_tarjeta ?>
		<td data-name="idvoucher_tarjeta"<?php echo $pago_cliente->idvoucher_tarjeta->CellAttributes() ?>>
<span<?php echo $pago_cliente->idvoucher_tarjeta->ViewAttributes() ?>>
<?php echo $pago_cliente->idvoucher_tarjeta->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($pago_cliente->idcheque_cliente->Visible) { // idcheque_cliente ?>
		<td data-name="idcheque_cliente"<?php echo $pago_cliente->idcheque_cliente->CellAttributes() ?>>
<span<?php echo $pago_cliente->idcheque_cliente->ViewAttributes() ?>>
<?php echo $pago_cliente->idcheque_cliente->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pago_cliente_list->ListOptions->Render("body", "right", $pago_cliente_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pago_cliente->CurrentAction <> "gridadd")
		$pago_cliente_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pago_cliente->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pago_cliente_list->Recordset)
	$pago_cliente_list->Recordset->Close();
?>
<?php if ($pago_cliente->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($pago_cliente->CurrentAction <> "gridadd" && $pago_cliente->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pago_cliente_list->Pager)) $pago_cliente_list->Pager = new cPrevNextPager($pago_cliente_list->StartRec, $pago_cliente_list->DisplayRecs, $pago_cliente_list->TotalRecs) ?>
<?php if ($pago_cliente_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pago_cliente_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pago_cliente_list->PageUrl() ?>start=<?php echo $pago_cliente_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pago_cliente_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pago_cliente_list->PageUrl() ?>start=<?php echo $pago_cliente_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pago_cliente_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pago_cliente_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pago_cliente_list->PageUrl() ?>start=<?php echo $pago_cliente_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pago_cliente_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pago_cliente_list->PageUrl() ?>start=<?php echo $pago_cliente_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pago_cliente_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pago_cliente_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pago_cliente_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pago_cliente_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pago_cliente_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($pago_cliente_list->TotalRecs == 0 && $pago_cliente->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pago_cliente_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($pago_cliente->Export == "") { ?>
<script type="text/javascript">
fpago_clientelist.Init();
</script>
<?php } ?>
<?php
$pago_cliente_list->ShowPageFooter();
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
$pago_cliente_list->Page_Terminate();
?>
