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

$fecha_contable_list = NULL; // Initialize page object first

class cfecha_contable_list extends cfecha_contable {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'fecha_contable';

	// Page object name
	var $PageObjName = 'fecha_contable_list';

	// Grid form hidden field names
	var $FormName = 'ffecha_contablelist';
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

		// Table object (fecha_contable)
		if (!isset($GLOBALS["fecha_contable"]) || get_class($GLOBALS["fecha_contable"]) == "cfecha_contable") {
			$GLOBALS["fecha_contable"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["fecha_contable"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "fecha_contableadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "fecha_contabledelete.php";
		$this->MultiUpdateUrl = "fecha_contableupdate.php";

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fecha_contable', TRUE);

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

		// Create form object
		$objForm = new cFormObj();

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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "periodo_contable") {
			global $periodo_contable;
			$rsmaster = $periodo_contable->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("periodo_contablelist.php"); // Return to master page
			} else {
				$periodo_contable->LoadListRowValues($rsmaster);
				$periodo_contable->RowType = EW_ROWTYPE_MASTER; // Master row
				$periodo_contable->RenderListRow();
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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
			$this->idfecha_contable->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idfecha_contable->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->idfecha_contable->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_idperiodo_contable") && $objForm->HasValue("o_idperiodo_contable") && $this->idperiodo_contable->CurrentValue <> $this->idperiodo_contable->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_fecha") && $objForm->HasValue("o_fecha") && $this->fecha->CurrentValue <> $this->fecha->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_estado_documento_debito") && $objForm->HasValue("o_estado_documento_debito") && $this->estado_documento_debito->CurrentValue <> $this->estado_documento_debito->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_estado_documento_credito") && $objForm->HasValue("o_estado_documento_credito") && $this->estado_documento_credito->CurrentValue <> $this->estado_documento_credito->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_estado_pago_cliente") && $objForm->HasValue("o_estado_pago_cliente") && $this->estado_pago_cliente->CurrentValue <> $this->estado_pago_cliente->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_estado_pago_proveedor") && $objForm->HasValue("o_estado_pago_proveedor") && $this->estado_pago_proveedor->CurrentValue <> $this->estado_pago_proveedor->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idempresa") && $objForm->HasValue("o_idempresa") && $this->idempresa->CurrentValue <> $this->idempresa->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->idfecha_contable, $Default, FALSE); // idfecha_contable
		$this->BuildSearchSql($sWhere, $this->idperiodo_contable, $Default, FALSE); // idperiodo_contable
		$this->BuildSearchSql($sWhere, $this->fecha, $Default, FALSE); // fecha
		$this->BuildSearchSql($sWhere, $this->estado_documento_debito, $Default, FALSE); // estado_documento_debito
		$this->BuildSearchSql($sWhere, $this->estado_documento_credito, $Default, FALSE); // estado_documento_credito
		$this->BuildSearchSql($sWhere, $this->estado_pago_cliente, $Default, FALSE); // estado_pago_cliente
		$this->BuildSearchSql($sWhere, $this->estado_pago_proveedor, $Default, FALSE); // estado_pago_proveedor
		$this->BuildSearchSql($sWhere, $this->idempresa, $Default, FALSE); // idempresa

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->idfecha_contable->AdvancedSearch->Save(); // idfecha_contable
			$this->idperiodo_contable->AdvancedSearch->Save(); // idperiodo_contable
			$this->fecha->AdvancedSearch->Save(); // fecha
			$this->estado_documento_debito->AdvancedSearch->Save(); // estado_documento_debito
			$this->estado_documento_credito->AdvancedSearch->Save(); // estado_documento_credito
			$this->estado_pago_cliente->AdvancedSearch->Save(); // estado_pago_cliente
			$this->estado_pago_proveedor->AdvancedSearch->Save(); // estado_pago_proveedor
			$this->idempresa->AdvancedSearch->Save(); // idempresa
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->idfecha_contable->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->idperiodo_contable->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fecha->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado_documento_debito->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado_documento_credito->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado_pago_cliente->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado_pago_proveedor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->idempresa->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->idfecha_contable->AdvancedSearch->UnsetSession();
		$this->idperiodo_contable->AdvancedSearch->UnsetSession();
		$this->fecha->AdvancedSearch->UnsetSession();
		$this->estado_documento_debito->AdvancedSearch->UnsetSession();
		$this->estado_documento_credito->AdvancedSearch->UnsetSession();
		$this->estado_pago_cliente->AdvancedSearch->UnsetSession();
		$this->estado_pago_proveedor->AdvancedSearch->UnsetSession();
		$this->idempresa->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->idfecha_contable->AdvancedSearch->Load();
		$this->idperiodo_contable->AdvancedSearch->Load();
		$this->fecha->AdvancedSearch->Load();
		$this->estado_documento_debito->AdvancedSearch->Load();
		$this->estado_documento_credito->AdvancedSearch->Load();
		$this->estado_pago_cliente->AdvancedSearch->Load();
		$this->estado_pago_proveedor->AdvancedSearch->Load();
		$this->idempresa->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->idperiodo_contable); // idperiodo_contable
			$this->UpdateSort($this->fecha); // fecha
			$this->UpdateSort($this->estado_documento_debito); // estado_documento_debito
			$this->UpdateSort($this->estado_documento_credito); // estado_documento_credito
			$this->UpdateSort($this->estado_pago_cliente); // estado_pago_cliente
			$this->UpdateSort($this->estado_pago_proveedor); // estado_pago_proveedor
			$this->UpdateSort($this->idempresa); // idempresa
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
				$this->fecha->setSort("DESC");
				$this->idperiodo_contable->setSort("ASC");
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idperiodo_contable->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->idperiodo_contable->setSort("");
				$this->fecha->setSort("");
				$this->estado_documento_debito->setSort("");
				$this->estado_documento_credito->setSort("");
				$this->estado_pago_cliente->setSort("");
				$this->estado_pago_proveedor->setSort("");
				$this->idempresa->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idfecha_contable->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->idfecha_contable->CurrentValue . "\">";
		}
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
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ffecha_contablelist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere);

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		if (ew_IsMobile())
			$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"fecha_contablesrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" onclick=\"ew_SearchDialogShow({lnk:this,url:'fecha_contablesrch.php'});\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

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

	// Load default values
	function LoadDefaultValues() {
		$this->idperiodo_contable->CurrentValue = 1;
		$this->idperiodo_contable->OldValue = $this->idperiodo_contable->CurrentValue;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->estado_documento_debito->CurrentValue = "Abierto";
		$this->estado_documento_debito->OldValue = $this->estado_documento_debito->CurrentValue;
		$this->estado_documento_credito->CurrentValue = "Abierto";
		$this->estado_documento_credito->OldValue = $this->estado_documento_credito->CurrentValue;
		$this->estado_pago_cliente->CurrentValue = "Abierto";
		$this->estado_pago_cliente->OldValue = $this->estado_pago_cliente->CurrentValue;
		$this->estado_pago_proveedor->CurrentValue = "Abierto";
		$this->estado_pago_proveedor->OldValue = $this->estado_pago_proveedor->CurrentValue;
		$this->idempresa->CurrentValue = 1;
		$this->idempresa->OldValue = $this->idempresa->CurrentValue;
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// idfecha_contable

		$this->idfecha_contable->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idfecha_contable"]);
		if ($this->idfecha_contable->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idfecha_contable->AdvancedSearch->SearchOperator = @$_GET["z_idfecha_contable"];

		// idperiodo_contable
		$this->idperiodo_contable->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idperiodo_contable"]);
		if ($this->idperiodo_contable->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idperiodo_contable->AdvancedSearch->SearchOperator = @$_GET["z_idperiodo_contable"];

		// fecha
		$this->fecha->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fecha"]);
		if ($this->fecha->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fecha->AdvancedSearch->SearchOperator = @$_GET["z_fecha"];

		// estado_documento_debito
		$this->estado_documento_debito->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado_documento_debito"]);
		if ($this->estado_documento_debito->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado_documento_debito->AdvancedSearch->SearchOperator = @$_GET["z_estado_documento_debito"];

		// estado_documento_credito
		$this->estado_documento_credito->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado_documento_credito"]);
		if ($this->estado_documento_credito->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado_documento_credito->AdvancedSearch->SearchOperator = @$_GET["z_estado_documento_credito"];

		// estado_pago_cliente
		$this->estado_pago_cliente->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado_pago_cliente"]);
		if ($this->estado_pago_cliente->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado_pago_cliente->AdvancedSearch->SearchOperator = @$_GET["z_estado_pago_cliente"];

		// estado_pago_proveedor
		$this->estado_pago_proveedor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado_pago_proveedor"]);
		if ($this->estado_pago_proveedor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado_pago_proveedor->AdvancedSearch->SearchOperator = @$_GET["z_estado_pago_proveedor"];

		// idempresa
		$this->idempresa->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idempresa"]);
		if ($this->idempresa->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idempresa->AdvancedSearch->SearchOperator = @$_GET["z_idempresa"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idperiodo_contable->FldIsDetailKey) {
			$this->idperiodo_contable->setFormValue($objForm->GetValue("x_idperiodo_contable"));
		}
		$this->idperiodo_contable->setOldValue($objForm->GetValue("o_idperiodo_contable"));
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		$this->fecha->setOldValue($objForm->GetValue("o_fecha"));
		if (!$this->estado_documento_debito->FldIsDetailKey) {
			$this->estado_documento_debito->setFormValue($objForm->GetValue("x_estado_documento_debito"));
		}
		$this->estado_documento_debito->setOldValue($objForm->GetValue("o_estado_documento_debito"));
		if (!$this->estado_documento_credito->FldIsDetailKey) {
			$this->estado_documento_credito->setFormValue($objForm->GetValue("x_estado_documento_credito"));
		}
		$this->estado_documento_credito->setOldValue($objForm->GetValue("o_estado_documento_credito"));
		if (!$this->estado_pago_cliente->FldIsDetailKey) {
			$this->estado_pago_cliente->setFormValue($objForm->GetValue("x_estado_pago_cliente"));
		}
		$this->estado_pago_cliente->setOldValue($objForm->GetValue("o_estado_pago_cliente"));
		if (!$this->estado_pago_proveedor->FldIsDetailKey) {
			$this->estado_pago_proveedor->setFormValue($objForm->GetValue("x_estado_pago_proveedor"));
		}
		$this->estado_pago_proveedor->setOldValue($objForm->GetValue("o_estado_pago_proveedor"));
		if (!$this->idempresa->FldIsDetailKey) {
			$this->idempresa->setFormValue($objForm->GetValue("x_idempresa"));
		}
		$this->idempresa->setOldValue($objForm->GetValue("o_idempresa"));
		if (!$this->idfecha_contable->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idfecha_contable->setFormValue($objForm->GetValue("x_idfecha_contable"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idfecha_contable->CurrentValue = $this->idfecha_contable->FormValue;
		$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->estado_documento_debito->CurrentValue = $this->estado_documento_debito->FormValue;
		$this->estado_documento_credito->CurrentValue = $this->estado_documento_credito->FormValue;
		$this->estado_pago_cliente->CurrentValue = $this->estado_pago_cliente->FormValue;
		$this->estado_pago_proveedor->CurrentValue = $this->estado_pago_proveedor->FormValue;
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idfecha_contable")) <> "")
			$this->idfecha_contable->CurrentValue = $this->getKey("idfecha_contable"); // idfecha_contable
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			if ($this->idperiodo_contable->getSessionValue() <> "") {
				$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->getSessionValue();
				$this->idperiodo_contable->OldValue = $this->idperiodo_contable->CurrentValue;
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
			} else {
			if (trim(strval($this->idperiodo_contable->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `periodo_contable`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `mes`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idperiodo_contable->EditValue = $arwrk;
			}

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// estado_documento_debito
			$this->estado_documento_debito->EditAttrs["class"] = "form-control";
			$this->estado_documento_debito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(1), $this->estado_documento_debito->FldTagCaption(1) <> "" ? $this->estado_documento_debito->FldTagCaption(1) : $this->estado_documento_debito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(2), $this->estado_documento_debito->FldTagCaption(2) <> "" ? $this->estado_documento_debito->FldTagCaption(2) : $this->estado_documento_debito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(3), $this->estado_documento_debito->FldTagCaption(3) <> "" ? $this->estado_documento_debito->FldTagCaption(3) : $this->estado_documento_debito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(4), $this->estado_documento_debito->FldTagCaption(4) <> "" ? $this->estado_documento_debito->FldTagCaption(4) : $this->estado_documento_debito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_debito->EditValue = $arwrk;

			// estado_documento_credito
			$this->estado_documento_credito->EditAttrs["class"] = "form-control";
			$this->estado_documento_credito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(1), $this->estado_documento_credito->FldTagCaption(1) <> "" ? $this->estado_documento_credito->FldTagCaption(1) : $this->estado_documento_credito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(2), $this->estado_documento_credito->FldTagCaption(2) <> "" ? $this->estado_documento_credito->FldTagCaption(2) : $this->estado_documento_credito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(3), $this->estado_documento_credito->FldTagCaption(3) <> "" ? $this->estado_documento_credito->FldTagCaption(3) : $this->estado_documento_credito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(4), $this->estado_documento_credito->FldTagCaption(4) <> "" ? $this->estado_documento_credito->FldTagCaption(4) : $this->estado_documento_credito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_credito->EditValue = $arwrk;

			// estado_pago_cliente
			$this->estado_pago_cliente->EditAttrs["class"] = "form-control";
			$this->estado_pago_cliente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(1), $this->estado_pago_cliente->FldTagCaption(1) <> "" ? $this->estado_pago_cliente->FldTagCaption(1) : $this->estado_pago_cliente->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(2), $this->estado_pago_cliente->FldTagCaption(2) <> "" ? $this->estado_pago_cliente->FldTagCaption(2) : $this->estado_pago_cliente->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(3), $this->estado_pago_cliente->FldTagCaption(3) <> "" ? $this->estado_pago_cliente->FldTagCaption(3) : $this->estado_pago_cliente->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(4), $this->estado_pago_cliente->FldTagCaption(4) <> "" ? $this->estado_pago_cliente->FldTagCaption(4) : $this->estado_pago_cliente->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_cliente->EditValue = $arwrk;

			// estado_pago_proveedor
			$this->estado_pago_proveedor->EditAttrs["class"] = "form-control";
			$this->estado_pago_proveedor->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(1), $this->estado_pago_proveedor->FldTagCaption(1) <> "" ? $this->estado_pago_proveedor->FldTagCaption(1) : $this->estado_pago_proveedor->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(2), $this->estado_pago_proveedor->FldTagCaption(2) <> "" ? $this->estado_pago_proveedor->FldTagCaption(2) : $this->estado_pago_proveedor->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(3), $this->estado_pago_proveedor->FldTagCaption(3) <> "" ? $this->estado_pago_proveedor->FldTagCaption(3) : $this->estado_pago_proveedor->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(4), $this->estado_pago_proveedor->FldTagCaption(4) <> "" ? $this->estado_pago_proveedor->FldTagCaption(4) : $this->estado_pago_proveedor->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_proveedor->EditValue = $arwrk;

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;

			// Edit refer script
			// idperiodo_contable

			$this->idperiodo_contable->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// estado_documento_debito
			$this->estado_documento_debito->HrefValue = "";

			// estado_documento_credito
			$this->estado_documento_credito->HrefValue = "";

			// estado_pago_cliente
			$this->estado_pago_cliente->HrefValue = "";

			// estado_pago_proveedor
			$this->estado_pago_proveedor->HrefValue = "";

			// idempresa
			$this->idempresa->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			if ($this->idperiodo_contable->getSessionValue() <> "") {
				$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->getSessionValue();
				$this->idperiodo_contable->OldValue = $this->idperiodo_contable->CurrentValue;
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
			} else {
			if (trim(strval($this->idperiodo_contable->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `periodo_contable`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `mes`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idperiodo_contable->EditValue = $arwrk;
			}

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// estado_documento_debito
			$this->estado_documento_debito->EditAttrs["class"] = "form-control";
			$this->estado_documento_debito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(1), $this->estado_documento_debito->FldTagCaption(1) <> "" ? $this->estado_documento_debito->FldTagCaption(1) : $this->estado_documento_debito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(2), $this->estado_documento_debito->FldTagCaption(2) <> "" ? $this->estado_documento_debito->FldTagCaption(2) : $this->estado_documento_debito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(3), $this->estado_documento_debito->FldTagCaption(3) <> "" ? $this->estado_documento_debito->FldTagCaption(3) : $this->estado_documento_debito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_debito->FldTagValue(4), $this->estado_documento_debito->FldTagCaption(4) <> "" ? $this->estado_documento_debito->FldTagCaption(4) : $this->estado_documento_debito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_debito->EditValue = $arwrk;

			// estado_documento_credito
			$this->estado_documento_credito->EditAttrs["class"] = "form-control";
			$this->estado_documento_credito->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(1), $this->estado_documento_credito->FldTagCaption(1) <> "" ? $this->estado_documento_credito->FldTagCaption(1) : $this->estado_documento_credito->FldTagValue(1));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(2), $this->estado_documento_credito->FldTagCaption(2) <> "" ? $this->estado_documento_credito->FldTagCaption(2) : $this->estado_documento_credito->FldTagValue(2));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(3), $this->estado_documento_credito->FldTagCaption(3) <> "" ? $this->estado_documento_credito->FldTagCaption(3) : $this->estado_documento_credito->FldTagValue(3));
			$arwrk[] = array($this->estado_documento_credito->FldTagValue(4), $this->estado_documento_credito->FldTagCaption(4) <> "" ? $this->estado_documento_credito->FldTagCaption(4) : $this->estado_documento_credito->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_documento_credito->EditValue = $arwrk;

			// estado_pago_cliente
			$this->estado_pago_cliente->EditAttrs["class"] = "form-control";
			$this->estado_pago_cliente->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(1), $this->estado_pago_cliente->FldTagCaption(1) <> "" ? $this->estado_pago_cliente->FldTagCaption(1) : $this->estado_pago_cliente->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(2), $this->estado_pago_cliente->FldTagCaption(2) <> "" ? $this->estado_pago_cliente->FldTagCaption(2) : $this->estado_pago_cliente->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(3), $this->estado_pago_cliente->FldTagCaption(3) <> "" ? $this->estado_pago_cliente->FldTagCaption(3) : $this->estado_pago_cliente->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_cliente->FldTagValue(4), $this->estado_pago_cliente->FldTagCaption(4) <> "" ? $this->estado_pago_cliente->FldTagCaption(4) : $this->estado_pago_cliente->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_cliente->EditValue = $arwrk;

			// estado_pago_proveedor
			$this->estado_pago_proveedor->EditAttrs["class"] = "form-control";
			$this->estado_pago_proveedor->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(1), $this->estado_pago_proveedor->FldTagCaption(1) <> "" ? $this->estado_pago_proveedor->FldTagCaption(1) : $this->estado_pago_proveedor->FldTagValue(1));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(2), $this->estado_pago_proveedor->FldTagCaption(2) <> "" ? $this->estado_pago_proveedor->FldTagCaption(2) : $this->estado_pago_proveedor->FldTagValue(2));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(3), $this->estado_pago_proveedor->FldTagCaption(3) <> "" ? $this->estado_pago_proveedor->FldTagCaption(3) : $this->estado_pago_proveedor->FldTagValue(3));
			$arwrk[] = array($this->estado_pago_proveedor->FldTagValue(4), $this->estado_pago_proveedor->FldTagCaption(4) <> "" ? $this->estado_pago_proveedor->FldTagCaption(4) : $this->estado_pago_proveedor->FldTagValue(4));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado_pago_proveedor->EditValue = $arwrk;

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;

			// Edit refer script
			// idperiodo_contable

			$this->idperiodo_contable->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// estado_documento_debito
			$this->estado_documento_debito->HrefValue = "";

			// estado_documento_credito
			$this->estado_documento_credito->HrefValue = "";

			// estado_pago_cliente
			$this->estado_pago_cliente->HrefValue = "";

			// estado_pago_proveedor
			$this->estado_pago_proveedor->HrefValue = "";

			// idempresa
			$this->idempresa->HrefValue = "";
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->idperiodo_contable->FldIsDetailKey && !is_null($this->idperiodo_contable->FormValue) && $this->idperiodo_contable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idperiodo_contable->FldCaption(), $this->idperiodo_contable->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->estado_documento_debito->FldIsDetailKey && !is_null($this->estado_documento_debito->FormValue) && $this->estado_documento_debito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento_debito->FldCaption(), $this->estado_documento_debito->ReqErrMsg));
		}
		if (!$this->estado_documento_credito->FldIsDetailKey && !is_null($this->estado_documento_credito->FormValue) && $this->estado_documento_credito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_documento_credito->FldCaption(), $this->estado_documento_credito->ReqErrMsg));
		}
		if (!$this->estado_pago_cliente->FldIsDetailKey && !is_null($this->estado_pago_cliente->FormValue) && $this->estado_pago_cliente->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_pago_cliente->FldCaption(), $this->estado_pago_cliente->ReqErrMsg));
		}
		if (!$this->estado_pago_proveedor->FldIsDetailKey && !is_null($this->estado_pago_proveedor->FormValue) && $this->estado_pago_proveedor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado_pago_proveedor->FldCaption(), $this->estado_pago_proveedor->ReqErrMsg));
		}
		if (!$this->idempresa->FldIsDetailKey && !is_null($this->idempresa->FormValue) && $this->idempresa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempresa->FldCaption(), $this->idempresa->ReqErrMsg));
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['idfecha_contable'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// idperiodo_contable
			$this->idperiodo_contable->SetDbValueDef($rsnew, $this->idperiodo_contable->CurrentValue, 0, $this->idperiodo_contable->ReadOnly);

			// fecha
			$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, $this->fecha->ReadOnly);

			// estado_documento_debito
			$this->estado_documento_debito->SetDbValueDef($rsnew, $this->estado_documento_debito->CurrentValue, "", $this->estado_documento_debito->ReadOnly);

			// estado_documento_credito
			$this->estado_documento_credito->SetDbValueDef($rsnew, $this->estado_documento_credito->CurrentValue, "", $this->estado_documento_credito->ReadOnly);

			// estado_pago_cliente
			$this->estado_pago_cliente->SetDbValueDef($rsnew, $this->estado_pago_cliente->CurrentValue, "", $this->estado_pago_cliente->ReadOnly);

			// estado_pago_proveedor
			$this->estado_pago_proveedor->SetDbValueDef($rsnew, $this->estado_pago_proveedor->CurrentValue, "", $this->estado_pago_proveedor->ReadOnly);

			// idempresa
			$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, $this->idempresa->ReadOnly);

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
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idperiodo_contable
		$this->idperiodo_contable->SetDbValueDef($rsnew, $this->idperiodo_contable->CurrentValue, 0, strval($this->idperiodo_contable->CurrentValue) == "");

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// estado_documento_debito
		$this->estado_documento_debito->SetDbValueDef($rsnew, $this->estado_documento_debito->CurrentValue, "", strval($this->estado_documento_debito->CurrentValue) == "");

		// estado_documento_credito
		$this->estado_documento_credito->SetDbValueDef($rsnew, $this->estado_documento_credito->CurrentValue, "", strval($this->estado_documento_credito->CurrentValue) == "");

		// estado_pago_cliente
		$this->estado_pago_cliente->SetDbValueDef($rsnew, $this->estado_pago_cliente->CurrentValue, "", strval($this->estado_pago_cliente->CurrentValue) == "");

		// estado_pago_proveedor
		$this->estado_pago_proveedor->SetDbValueDef($rsnew, $this->estado_pago_proveedor->CurrentValue, "", strval($this->estado_pago_proveedor->CurrentValue) == "");

		// idempresa
		$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, strval($this->idempresa->CurrentValue) == "");

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
			$this->idfecha_contable->setDbValue($conn->Insert_ID());
			$rsnew['idfecha_contable'] = $this->idfecha_contable->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->idfecha_contable->AdvancedSearch->Load();
		$this->idperiodo_contable->AdvancedSearch->Load();
		$this->fecha->AdvancedSearch->Load();
		$this->estado_documento_debito->AdvancedSearch->Load();
		$this->estado_documento_credito->AdvancedSearch->Load();
		$this->estado_pago_cliente->AdvancedSearch->Load();
		$this->estado_pago_proveedor->AdvancedSearch->Load();
		$this->idempresa->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_fecha_contable\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_fecha_contable',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ffecha_contablelist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "periodo_contable") {
			global $periodo_contable;
			if (!isset($periodo_contable)) $periodo_contable = new cperiodo_contable;
			$rsmaster = $periodo_contable->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$periodo_contable->ExportDocument($Doc, $rsmaster, 1, 1);
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
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
if (!isset($fecha_contable_list)) $fecha_contable_list = new cfecha_contable_list();

// Page init
$fecha_contable_list->Page_Init();

// Page main
$fecha_contable_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fecha_contable_list->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">

// Page object
var fecha_contable_list = new ew_Page("fecha_contable_list");
fecha_contable_list.PageID = "list"; // Page ID
var EW_PAGE_ID = fecha_contable_list.PageID; // For backward compatibility

// Form object
var ffecha_contablelist = new ew_Form("ffecha_contablelist");
ffecha_contablelist.FormKeyCountName = '<?php echo $fecha_contable_list->FormKeyCountName ?>';

// Validate form
ffecha_contablelist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->idperiodo_contable->FldCaption(), $fecha_contable->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($fecha_contable->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_debito->FldCaption(), $fecha_contable->estado_documento_debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_documento_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_documento_credito->FldCaption(), $fecha_contable->estado_documento_credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_cliente");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_cliente->FldCaption(), $fecha_contable->estado_pago_cliente->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado_pago_proveedor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->estado_pago_proveedor->FldCaption(), $fecha_contable->estado_pago_proveedor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $fecha_contable->idempresa->FldCaption(), $fecha_contable->idempresa->ReqErrMsg)) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ffecha_contablelist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idperiodo_contable", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento_debito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_documento_credito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_pago_cliente", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado_pago_proveedor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	return true;
}

// Form_CustomValidate event
ffecha_contablelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffecha_contablelist.ValidateRequired = true;
<?php } else { ?>
ffecha_contablelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffecha_contablelist.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ffecha_contablelist.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ffecha_contablelistsrch = new ew_Form("ffecha_contablelistsrch");
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
<?php if ($fecha_contable_list->TotalRecs > 0 && $fecha_contable->getCurrentMasterTable() == "" && $fecha_contable_list->ExportOptions->Visible()) { ?>
<?php $fecha_contable_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($fecha_contable_list->SearchOptions->Visible()) { ?>
<?php $fecha_contable_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($fecha_contable->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($fecha_contable->Export == "") || (EW_EXPORT_MASTER_RECORD && $fecha_contable->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "periodo_contablelist.php";
if ($fecha_contable_list->DbMasterFilter <> "" && $fecha_contable->getCurrentMasterTable() == "periodo_contable") {
	if ($fecha_contable_list->MasterRecordExists) {
		if ($fecha_contable->getCurrentMasterTable() == $fecha_contable->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($fecha_contable_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $fecha_contable_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "periodo_contablemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($fecha_contable->CurrentAction == "gridadd") {
	$fecha_contable->CurrentFilter = "0=1";
	$fecha_contable_list->StartRec = 1;
	$fecha_contable_list->DisplayRecs = $fecha_contable->GridAddRowCount;
	$fecha_contable_list->TotalRecs = $fecha_contable_list->DisplayRecs;
	$fecha_contable_list->StopRec = $fecha_contable_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$fecha_contable_list->TotalRecs = $fecha_contable->SelectRecordCount();
	} else {
		if ($fecha_contable_list->Recordset = $fecha_contable_list->LoadRecordset())
			$fecha_contable_list->TotalRecs = $fecha_contable_list->Recordset->RecordCount();
	}
	$fecha_contable_list->StartRec = 1;
	if ($fecha_contable_list->DisplayRecs <= 0 || ($fecha_contable->Export <> "" && $fecha_contable->ExportAll)) // Display all records
		$fecha_contable_list->DisplayRecs = $fecha_contable_list->TotalRecs;
	if (!($fecha_contable->Export <> "" && $fecha_contable->ExportAll))
		$fecha_contable_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$fecha_contable_list->Recordset = $fecha_contable_list->LoadRecordset($fecha_contable_list->StartRec-1, $fecha_contable_list->DisplayRecs);

	// Set no record found message
	if ($fecha_contable->CurrentAction == "" && $fecha_contable_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$fecha_contable_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($fecha_contable_list->SearchWhere == "0=101")
			$fecha_contable_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$fecha_contable_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$fecha_contable_list->RenderOtherOptions();
?>
<?php $fecha_contable_list->ShowPageHeader(); ?>
<?php
$fecha_contable_list->ShowMessage();
?>
<?php if ($fecha_contable_list->TotalRecs > 0 || $fecha_contable->CurrentAction <> "") { ?>
<div class="ewGrid">
<form name="ffecha_contablelist" id="ffecha_contablelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($fecha_contable_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $fecha_contable_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fecha_contable">
<div id="gmp_fecha_contable" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($fecha_contable_list->TotalRecs > 0) { ?>
<table id="tbl_fecha_contablelist" class="table ewTable">
<?php echo $fecha_contable->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$fecha_contable_list->RenderListOptions();

// Render list options (header, left)
$fecha_contable_list->ListOptions->Render("header", "left");
?>
<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->idperiodo_contable) == "") { ?>
		<th data-name="idperiodo_contable"><div id="elh_fecha_contable_idperiodo_contable" class="fecha_contable_idperiodo_contable"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperiodo_contable"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->idperiodo_contable) ?>',1);"><div id="elh_fecha_contable_idperiodo_contable" class="fecha_contable_idperiodo_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->idperiodo_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->idperiodo_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_fecha_contable_fecha" class="fecha_contable_fecha"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->fecha) ?>',1);"><div id="elh_fecha_contable_fecha" class="fecha_contable_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_documento_debito) == "") { ?>
		<th data-name="estado_documento_debito"><div id="elh_fecha_contable_estado_documento_debito" class="fecha_contable_estado_documento_debito"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento_debito"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->estado_documento_debito) ?>',1);"><div id="elh_fecha_contable_estado_documento_debito" class="fecha_contable_estado_documento_debito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_documento_debito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_documento_debito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_documento_credito) == "") { ?>
		<th data-name="estado_documento_credito"><div id="elh_fecha_contable_estado_documento_credito" class="fecha_contable_estado_documento_credito"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_documento_credito"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->estado_documento_credito) ?>',1);"><div id="elh_fecha_contable_estado_documento_credito" class="fecha_contable_estado_documento_credito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_documento_credito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_documento_credito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_pago_cliente) == "") { ?>
		<th data-name="estado_pago_cliente"><div id="elh_fecha_contable_estado_pago_cliente" class="fecha_contable_estado_pago_cliente"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_pago_cliente"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->estado_pago_cliente) ?>',1);"><div id="elh_fecha_contable_estado_pago_cliente" class="fecha_contable_estado_pago_cliente">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_pago_cliente->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_pago_cliente->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->estado_pago_proveedor) == "") { ?>
		<th data-name="estado_pago_proveedor"><div id="elh_fecha_contable_estado_pago_proveedor" class="fecha_contable_estado_pago_proveedor"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado_pago_proveedor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->estado_pago_proveedor) ?>',1);"><div id="elh_fecha_contable_estado_pago_proveedor" class="fecha_contable_estado_pago_proveedor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->estado_pago_proveedor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->estado_pago_proveedor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
	<?php if ($fecha_contable->SortUrl($fecha_contable->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_fecha_contable_idempresa" class="fecha_contable_idempresa"><div class="ewTableHeaderCaption"><?php echo $fecha_contable->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $fecha_contable->SortUrl($fecha_contable->idempresa) ?>',1);"><div id="elh_fecha_contable_idempresa" class="fecha_contable_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $fecha_contable->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($fecha_contable->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($fecha_contable->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$fecha_contable_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($fecha_contable->ExportAll && $fecha_contable->Export <> "") {
	$fecha_contable_list->StopRec = $fecha_contable_list->TotalRecs;
} else {

	// Set the last record to display
	if ($fecha_contable_list->TotalRecs > $fecha_contable_list->StartRec + $fecha_contable_list->DisplayRecs - 1)
		$fecha_contable_list->StopRec = $fecha_contable_list->StartRec + $fecha_contable_list->DisplayRecs - 1;
	else
		$fecha_contable_list->StopRec = $fecha_contable_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($fecha_contable_list->FormKeyCountName) && ($fecha_contable->CurrentAction == "gridadd" || $fecha_contable->CurrentAction == "gridedit" || $fecha_contable->CurrentAction == "F")) {
		$fecha_contable_list->KeyCount = $objForm->GetValue($fecha_contable_list->FormKeyCountName);
		$fecha_contable_list->StopRec = $fecha_contable_list->StartRec + $fecha_contable_list->KeyCount - 1;
	}
}
$fecha_contable_list->RecCnt = $fecha_contable_list->StartRec - 1;
if ($fecha_contable_list->Recordset && !$fecha_contable_list->Recordset->EOF) {
	$fecha_contable_list->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $fecha_contable_list->StartRec > 1)
		$fecha_contable_list->Recordset->Move($fecha_contable_list->StartRec - 1);
} elseif (!$fecha_contable->AllowAddDeleteRow && $fecha_contable_list->StopRec == 0) {
	$fecha_contable_list->StopRec = $fecha_contable->GridAddRowCount;
}

// Initialize aggregate
$fecha_contable->RowType = EW_ROWTYPE_AGGREGATEINIT;
$fecha_contable->ResetAttrs();
$fecha_contable_list->RenderRow();
if ($fecha_contable->CurrentAction == "gridadd")
	$fecha_contable_list->RowIndex = 0;
if ($fecha_contable->CurrentAction == "gridedit")
	$fecha_contable_list->RowIndex = 0;
while ($fecha_contable_list->RecCnt < $fecha_contable_list->StopRec) {
	$fecha_contable_list->RecCnt++;
	if (intval($fecha_contable_list->RecCnt) >= intval($fecha_contable_list->StartRec)) {
		$fecha_contable_list->RowCnt++;
		if ($fecha_contable->CurrentAction == "gridadd" || $fecha_contable->CurrentAction == "gridedit" || $fecha_contable->CurrentAction == "F") {
			$fecha_contable_list->RowIndex++;
			$objForm->Index = $fecha_contable_list->RowIndex;
			if ($objForm->HasValue($fecha_contable_list->FormActionName))
				$fecha_contable_list->RowAction = strval($objForm->GetValue($fecha_contable_list->FormActionName));
			elseif ($fecha_contable->CurrentAction == "gridadd")
				$fecha_contable_list->RowAction = "insert";
			else
				$fecha_contable_list->RowAction = "";
		}

		// Set up key count
		$fecha_contable_list->KeyCount = $fecha_contable_list->RowIndex;

		// Init row class and style
		$fecha_contable->ResetAttrs();
		$fecha_contable->CssClass = "";
		if ($fecha_contable->CurrentAction == "gridadd") {
			$fecha_contable_list->LoadDefaultValues(); // Load default values
		} else {
			$fecha_contable_list->LoadRowValues($fecha_contable_list->Recordset); // Load row values
		}
		$fecha_contable->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($fecha_contable->CurrentAction == "gridadd") // Grid add
			$fecha_contable->RowType = EW_ROWTYPE_ADD; // Render add
		if ($fecha_contable->CurrentAction == "gridadd" && $fecha_contable->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$fecha_contable_list->RestoreCurrentRowFormValues($fecha_contable_list->RowIndex); // Restore form values
		if ($fecha_contable->CurrentAction == "gridedit") { // Grid edit
			if ($fecha_contable->EventCancelled) {
				$fecha_contable_list->RestoreCurrentRowFormValues($fecha_contable_list->RowIndex); // Restore form values
			}
			if ($fecha_contable_list->RowAction == "insert")
				$fecha_contable->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$fecha_contable->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($fecha_contable->CurrentAction == "gridedit" && ($fecha_contable->RowType == EW_ROWTYPE_EDIT || $fecha_contable->RowType == EW_ROWTYPE_ADD) && $fecha_contable->EventCancelled) // Update failed
			$fecha_contable_list->RestoreCurrentRowFormValues($fecha_contable_list->RowIndex); // Restore form values
		if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) // Edit row
			$fecha_contable_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$fecha_contable->RowAttrs = array_merge($fecha_contable->RowAttrs, array('data-rowindex'=>$fecha_contable_list->RowCnt, 'id'=>'r' . $fecha_contable_list->RowCnt . '_fecha_contable', 'data-rowtype'=>$fecha_contable->RowType));

		// Render row
		$fecha_contable_list->RenderRow();

		// Render list options
		$fecha_contable_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($fecha_contable_list->RowAction <> "delete" && $fecha_contable_list->RowAction <> "insertdelete" && !($fecha_contable_list->RowAction == "insert" && $fecha_contable->CurrentAction == "F" && $fecha_contable_list->EmptyRow())) {
?>
	<tr<?php echo $fecha_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$fecha_contable_list->ListOptions->Render("body", "left", $fecha_contable_list->RowCnt);
?>
	<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" id="o<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<?php echo $fecha_contable->idperiodo_contable->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $fecha_contable_list->PageObjName . "_row_" . $fecha_contable_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idfecha_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" id="x<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->CurrentValue) ?>">
<input type="hidden" data-field="x_idfecha_contable" name="o<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" id="o<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT || $fecha_contable->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idfecha_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" id="x<?php echo $fecha_contable_list->RowIndex ?>_idfecha_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->CurrentValue) ?>">
<?php } ?>
	<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $fecha_contable->fecha->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablelist", "x<?php echo $fecha_contable_list->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $fecha_contable_list->RowIndex ?>_fecha" id="o<?php echo $fecha_contable_list->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablelist", "x<?php echo $fecha_contable_list->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->fecha->ViewAttributes() ?>>
<?php echo $fecha_contable->fecha->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
		<td data-name="estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_debito" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_documento_debito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_debito->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
		<td data-name="estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_credito" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_documento_credito->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_documento_credito->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
		<td data-name="estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_cliente" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_pago_cliente->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_cliente->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
		<td data-name="estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_proveedor" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->estado_pago_proveedor->ViewAttributes() ?>>
<?php echo $fecha_contable->estado_pago_proveedor->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $fecha_contable->idempresa->CellAttributes() ?>>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $fecha_contable_list->RowIndex ?>_idempresa" id="o<?php echo $fecha_contable_list->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $fecha_contable_list->RowCnt ?>_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $fecha_contable->idempresa->ViewAttributes() ?>>
<?php echo $fecha_contable->idempresa->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fecha_contable_list->ListOptions->Render("body", "right", $fecha_contable_list->RowCnt);
?>
	</tr>
<?php if ($fecha_contable->RowType == EW_ROWTYPE_ADD || $fecha_contable->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ffecha_contablelist.UpdateOpts(<?php echo $fecha_contable_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($fecha_contable->CurrentAction <> "gridadd")
		if (!$fecha_contable_list->Recordset->EOF) $fecha_contable_list->Recordset->MoveNext();
}
?>
<?php
	if ($fecha_contable->CurrentAction == "gridadd" || $fecha_contable->CurrentAction == "gridedit") {
		$fecha_contable_list->RowIndex = '$rowindex$';
		$fecha_contable_list->LoadDefaultValues();

		// Set row properties
		$fecha_contable->ResetAttrs();
		$fecha_contable->RowAttrs = array_merge($fecha_contable->RowAttrs, array('data-rowindex'=>$fecha_contable_list->RowIndex, 'id'=>'r0_fecha_contable', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($fecha_contable->RowAttrs["class"], "ewTemplate");
		$fecha_contable->RowType = EW_ROWTYPE_ADD;

		// Render row
		$fecha_contable_list->RenderRow();

		// Render list options
		$fecha_contable_list->RenderListOptions();
		$fecha_contable_list->StartRowCnt = 0;
?>
	<tr<?php echo $fecha_contable->RowAttributes() ?>>
<?php

// Render list options (body, left)
$fecha_contable_list->ListOptions->Render("body", "left", $fecha_contable_list->RowIndex);
?>
	<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td>
<?php if ($fecha_contable->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el$rowindex$_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<span<?php echo $fecha_contable->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $fecha_contable->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_fecha_contable_idperiodo_contable" class="form-group fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" name="x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$fecha_contable->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idperiodo_contable, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idperiodo_contable" name="o<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" id="o<?php echo $fecha_contable_list->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($fecha_contable->idperiodo_contable->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
		<td>
<span id="el$rowindex$_fecha_contable_fecha" class="form-group fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" id="x<?php echo $fecha_contable_list->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablelist", "x<?php echo $fecha_contable_list->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $fecha_contable_list->RowIndex ?>_fecha" id="o<?php echo $fecha_contable_list->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($fecha_contable->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
		<td>
<span id="el$rowindex$_fecha_contable_estado_documento_debito" class="form-group fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_debito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_debito" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_debito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_debito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
		<td>
<span id="el$rowindex$_fecha_contable_estado_documento_credito" class="form-group fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_documento_credito->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_documento_credito" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_documento_credito" value="<?php echo ew_HtmlEncode($fecha_contable->estado_documento_credito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
		<td>
<span id="el$rowindex$_fecha_contable_estado_pago_cliente" class="form-group fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_cliente->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_cliente" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_cliente" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_cliente->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
		<td>
<span id="el$rowindex$_fecha_contable_estado_pago_proveedor" class="form-group fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" name="x<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->estado_pago_proveedor->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado_pago_proveedor" name="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" id="o<?php echo $fecha_contable_list->RowIndex ?>_estado_pago_proveedor" value="<?php echo ew_HtmlEncode($fecha_contable->estado_pago_proveedor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
		<td>
<span id="el$rowindex$_fecha_contable_idempresa" class="form-group fecha_contable_idempresa">
<select data-field="x_idempresa" id="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" name="x<?php echo $fecha_contable_list->RowIndex ?>_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $fecha_contable->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$fecha_contable->Lookup_Selecting($fecha_contable->idempresa, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" id="s_x<?php echo $fecha_contable_list->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $fecha_contable_list->RowIndex ?>_idempresa" id="o<?php echo $fecha_contable_list->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($fecha_contable->idempresa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$fecha_contable_list->ListOptions->Render("body", "right", $fecha_contable_list->RowCnt);
?>
<script type="text/javascript">
ffecha_contablelist.UpdateOpts(<?php echo $fecha_contable_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($fecha_contable->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $fecha_contable_list->FormKeyCountName ?>" id="<?php echo $fecha_contable_list->FormKeyCountName ?>" value="<?php echo $fecha_contable_list->KeyCount ?>">
<?php echo $fecha_contable_list->MultiSelectKey ?>
<?php } ?>
<?php if ($fecha_contable->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $fecha_contable_list->FormKeyCountName ?>" id="<?php echo $fecha_contable_list->FormKeyCountName ?>" value="<?php echo $fecha_contable_list->KeyCount ?>">
<?php echo $fecha_contable_list->MultiSelectKey ?>
<?php } ?>
<?php if ($fecha_contable->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($fecha_contable_list->Recordset)
	$fecha_contable_list->Recordset->Close();
?>
<?php if ($fecha_contable->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($fecha_contable->CurrentAction <> "gridadd" && $fecha_contable->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($fecha_contable_list->Pager)) $fecha_contable_list->Pager = new cPrevNextPager($fecha_contable_list->StartRec, $fecha_contable_list->DisplayRecs, $fecha_contable_list->TotalRecs) ?>
<?php if ($fecha_contable_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($fecha_contable_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $fecha_contable_list->PageUrl() ?>start=<?php echo $fecha_contable_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($fecha_contable_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $fecha_contable_list->PageUrl() ?>start=<?php echo $fecha_contable_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $fecha_contable_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($fecha_contable_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $fecha_contable_list->PageUrl() ?>start=<?php echo $fecha_contable_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($fecha_contable_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $fecha_contable_list->PageUrl() ?>start=<?php echo $fecha_contable_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $fecha_contable_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $fecha_contable_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $fecha_contable_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $fecha_contable_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($fecha_contable_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($fecha_contable_list->TotalRecs == 0 && $fecha_contable->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($fecha_contable_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($fecha_contable->Export == "") { ?>
<script type="text/javascript">
ffecha_contablelistsrch.Init();
ffecha_contablelist.Init();
</script>
<?php } ?>
<?php
$fecha_contable_list->ShowPageFooter();
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
$fecha_contable_list->Page_Terminate();
?>
