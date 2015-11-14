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

$detalle_documento_debito_list = NULL; // Initialize page object first

class cdetalle_documento_debito_list extends cdetalle_documento_debito {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'detalle_documento_debito';

	// Page object name
	var $PageObjName = 'detalle_documento_debito_list';

	// Grid form hidden field names
	var $FormName = 'fdetalle_documento_debitolist';
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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "detalle_documento_debitoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "detalle_documento_debitodelete.php";
		$this->MultiUpdateUrl = "detalle_documento_debitoupdate.php";

		// Table object (documento_debito)
		if (!isset($GLOBALS['documento_debito'])) $GLOBALS['documento_debito'] = new cdocumento_debito();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detalle_documento_debito', TRUE);

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "documento_debito") {
			global $documento_debito;
			$rsmaster = $documento_debito->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("documento_debitolist.php"); // Return to master page
			} else {
				$documento_debito->LoadListRowValues($rsmaster);
				$documento_debito->RowType = EW_ROWTYPE_MASTER; // Master row
				$documento_debito->RenderListRow();
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
		$this->precio->FormValue = ""; // Clear form value
		$this->monto->FormValue = ""; // Clear form value
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
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
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
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
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
			$this->iddetalle_documento_debito->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->iddetalle_documento_debito->FormValue))
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
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
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
					$sKey .= $this->iddetalle_documento_debito->CurrentValue;

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
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_iddocumento_debito") && $objForm->HasValue("o_iddocumento_debito") && $this->iddocumento_debito->CurrentValue <> $this->iddocumento_debito->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idproducto") && $objForm->HasValue("o_idproducto") && $this->idproducto->CurrentValue <> $this->idproducto->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idbodega") && $objForm->HasValue("o_idbodega") && $this->idbodega->CurrentValue <> $this->idbodega->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cantidad") && $objForm->HasValue("o_cantidad") && $this->cantidad->CurrentValue <> $this->cantidad->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_precio") && $objForm->HasValue("o_precio") && $this->precio->CurrentValue <> $this->precio->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_monto") && $objForm->HasValue("o_monto") && $this->monto->CurrentValue <> $this->monto->OldValue)
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

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->iddocumento_debito); // iddocumento_debito
			$this->UpdateSort($this->idproducto); // idproducto
			$this->UpdateSort($this->idbodega); // idbodega
			$this->UpdateSort($this->cantidad); // cantidad
			$this->UpdateSort($this->precio); // precio
			$this->UpdateSort($this->monto); // monto
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
				$this->iddocumento_debito->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->iddocumento_debito->setSort("");
				$this->idproducto->setSort("");
				$this->idbodega->setSort("");
				$this->cantidad->setSort("");
				$this->precio->setSort("");
				$this->monto->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->iddetalle_documento_debito->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->iddetalle_documento_debito->CurrentValue . "\">";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fdetalle_documento_debitolist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->iddocumento_debito->CurrentValue = 1;
		$this->iddocumento_debito->OldValue = $this->iddocumento_debito->CurrentValue;
		$this->idproducto->CurrentValue = 1;
		$this->idproducto->OldValue = $this->idproducto->CurrentValue;
		$this->idbodega->CurrentValue = 1;
		$this->idbodega->OldValue = $this->idbodega->CurrentValue;
		$this->cantidad->CurrentValue = 0;
		$this->cantidad->OldValue = $this->cantidad->CurrentValue;
		$this->precio->CurrentValue = 0.00;
		$this->precio->OldValue = $this->precio->CurrentValue;
		$this->monto->CurrentValue = 0.00;
		$this->monto->OldValue = $this->monto->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->iddocumento_debito->FldIsDetailKey) {
			$this->iddocumento_debito->setFormValue($objForm->GetValue("x_iddocumento_debito"));
		}
		$this->iddocumento_debito->setOldValue($objForm->GetValue("o_iddocumento_debito"));
		if (!$this->idproducto->FldIsDetailKey) {
			$this->idproducto->setFormValue($objForm->GetValue("x_idproducto"));
		}
		$this->idproducto->setOldValue($objForm->GetValue("o_idproducto"));
		if (!$this->idbodega->FldIsDetailKey) {
			$this->idbodega->setFormValue($objForm->GetValue("x_idbodega"));
		}
		$this->idbodega->setOldValue($objForm->GetValue("o_idbodega"));
		if (!$this->cantidad->FldIsDetailKey) {
			$this->cantidad->setFormValue($objForm->GetValue("x_cantidad"));
		}
		$this->cantidad->setOldValue($objForm->GetValue("o_cantidad"));
		if (!$this->precio->FldIsDetailKey) {
			$this->precio->setFormValue($objForm->GetValue("x_precio"));
		}
		$this->precio->setOldValue($objForm->GetValue("o_precio"));
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		$this->monto->setOldValue($objForm->GetValue("o_monto"));
		if (!$this->iddetalle_documento_debito->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->iddetalle_documento_debito->setFormValue($objForm->GetValue("x_iddetalle_documento_debito"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->iddetalle_documento_debito->CurrentValue = $this->iddetalle_documento_debito->FormValue;
		$this->iddocumento_debito->CurrentValue = $this->iddocumento_debito->FormValue;
		$this->idproducto->CurrentValue = $this->idproducto->FormValue;
		$this->idbodega->CurrentValue = $this->idbodega->FormValue;
		$this->cantidad->CurrentValue = $this->cantidad->FormValue;
		$this->precio->CurrentValue = $this->precio->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
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
		$this->bandera_maestro->setDbValue($rs->fields('bandera_maestro'));
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
		$this->bandera_maestro->DbValue = $row['bandera_maestro'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("iddetalle_documento_debito")) <> "")
			$this->iddetalle_documento_debito->CurrentValue = $this->getKey("iddetalle_documento_debito"); // iddetalle_documento_debito
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
		if ($this->precio->FormValue == $this->precio->CurrentValue && is_numeric(ew_StrToFloat($this->precio->CurrentValue)))
			$this->precio->CurrentValue = ew_StrToFloat($this->precio->CurrentValue);

		// Convert decimal values if posted back
		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

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
		// bandera_maestro

		$this->bandera_maestro->CellCssStyle = "white-space: nowrap;";
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
			$this->cantidad->ViewValue = ew_FormatNumber($this->cantidad->ViewValue, 0, -2, -2, -2);
			$this->cantidad->CellCssStyle .= "text-align: right;";
			$this->cantidad->ViewCustomAttributes = "";

			// precio
			$this->precio->ViewValue = $this->precio->CurrentValue;
			$this->precio->ViewValue = ew_FormatNumber($this->precio->ViewValue, 2, -2, -2, -2);
			$this->precio->CellCssStyle .= "text-align: right;";
			$this->precio->ViewCustomAttributes = "";

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -2, -2, -2);
			$this->monto->CellCssStyle .= "text-align: right;";
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// iddocumento_debito
			$this->iddocumento_debito->EditAttrs["class"] = "form-control";
			$this->iddocumento_debito->EditCustomAttributes = "";
			if ($this->iddocumento_debito->getSessionValue() <> "") {
				$this->iddocumento_debito->CurrentValue = $this->iddocumento_debito->getSessionValue();
				$this->iddocumento_debito->OldValue = $this->iddocumento_debito->CurrentValue;
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
			} else {
			if (trim(strval($this->iddocumento_debito->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`iddocumento_debito`" . ew_SearchString("=", $this->iddocumento_debito->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `documento_debito`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->iddocumento_debito->EditValue = $arwrk;
			}

			// idproducto
			$this->idproducto->EditAttrs["class"] = "form-control";
			$this->idproducto->EditCustomAttributes = "";
			if (trim(strval($this->idproducto->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `producto`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idproducto->EditValue = $arwrk;

			// idbodega
			$this->idbodega->EditAttrs["class"] = "form-control";
			$this->idbodega->EditCustomAttributes = "";
			if (trim(strval($this->idbodega->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `bodega`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idbodega->EditValue = $arwrk;

			// cantidad
			$this->cantidad->EditAttrs["class"] = "form-control";
			$this->cantidad->EditCustomAttributes = "";
			$this->cantidad->EditValue = ew_HtmlEncode($this->cantidad->CurrentValue);
			$this->cantidad->PlaceHolder = ew_RemoveHtml($this->cantidad->FldCaption());

			// precio
			$this->precio->EditAttrs["class"] = "form-control";
			$this->precio->EditCustomAttributes = "";
			$this->precio->EditValue = ew_HtmlEncode($this->precio->CurrentValue);
			$this->precio->PlaceHolder = ew_RemoveHtml($this->precio->FldCaption());
			if (strval($this->precio->EditValue) <> "" && is_numeric($this->precio->EditValue)) {
			$this->precio->EditValue = ew_FormatNumber($this->precio->EditValue, -2, -2, -2, -2);
			$this->precio->OldValue = $this->precio->EditValue;
			}

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) {
			$this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -2, -2, -2);
			$this->monto->OldValue = $this->monto->EditValue;
			}

			// Edit refer script
			// iddocumento_debito

			$this->iddocumento_debito->HrefValue = "";

			// idproducto
			$this->idproducto->HrefValue = "";

			// idbodega
			$this->idbodega->HrefValue = "";

			// cantidad
			$this->cantidad->HrefValue = "";

			// precio
			$this->precio->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// iddocumento_debito
			$this->iddocumento_debito->EditAttrs["class"] = "form-control";
			$this->iddocumento_debito->EditCustomAttributes = "";
			if ($this->iddocumento_debito->getSessionValue() <> "") {
				$this->iddocumento_debito->CurrentValue = $this->iddocumento_debito->getSessionValue();
				$this->iddocumento_debito->OldValue = $this->iddocumento_debito->CurrentValue;
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
			} else {
			if (trim(strval($this->iddocumento_debito->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`iddocumento_debito`" . ew_SearchString("=", $this->iddocumento_debito->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `documento_debito`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->iddocumento_debito->EditValue = $arwrk;
			}

			// idproducto
			$this->idproducto->EditAttrs["class"] = "form-control";
			$this->idproducto->EditCustomAttributes = "";
			if (trim(strval($this->idproducto->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `producto`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idproducto->EditValue = $arwrk;

			// idbodega
			$this->idbodega->EditAttrs["class"] = "form-control";
			$this->idbodega->EditCustomAttributes = "";
			if (trim(strval($this->idbodega->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `bodega`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idbodega->EditValue = $arwrk;

			// cantidad
			$this->cantidad->EditAttrs["class"] = "form-control";
			$this->cantidad->EditCustomAttributes = "";
			$this->cantidad->EditValue = ew_HtmlEncode($this->cantidad->CurrentValue);
			$this->cantidad->PlaceHolder = ew_RemoveHtml($this->cantidad->FldCaption());

			// precio
			$this->precio->EditAttrs["class"] = "form-control";
			$this->precio->EditCustomAttributes = "";
			$this->precio->EditValue = ew_HtmlEncode($this->precio->CurrentValue);
			$this->precio->PlaceHolder = ew_RemoveHtml($this->precio->FldCaption());
			if (strval($this->precio->EditValue) <> "" && is_numeric($this->precio->EditValue)) {
			$this->precio->EditValue = ew_FormatNumber($this->precio->EditValue, -2, -2, -2, -2);
			$this->precio->OldValue = $this->precio->EditValue;
			}

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) {
			$this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -2, -2, -2);
			$this->monto->OldValue = $this->monto->EditValue;
			}

			// Edit refer script
			// iddocumento_debito

			$this->iddocumento_debito->HrefValue = "";

			// idproducto
			$this->idproducto->HrefValue = "";

			// idbodega
			$this->idbodega->HrefValue = "";

			// cantidad
			$this->cantidad->HrefValue = "";

			// precio
			$this->precio->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";
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
		if (!$this->iddocumento_debito->FldIsDetailKey && !is_null($this->iddocumento_debito->FormValue) && $this->iddocumento_debito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->iddocumento_debito->FldCaption(), $this->iddocumento_debito->ReqErrMsg));
		}
		if (!$this->idproducto->FldIsDetailKey && !is_null($this->idproducto->FormValue) && $this->idproducto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idproducto->FldCaption(), $this->idproducto->ReqErrMsg));
		}
		if (!$this->idbodega->FldIsDetailKey && !is_null($this->idbodega->FormValue) && $this->idbodega->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idbodega->FldCaption(), $this->idbodega->ReqErrMsg));
		}
		if (!$this->cantidad->FldIsDetailKey && !is_null($this->cantidad->FormValue) && $this->cantidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cantidad->FldCaption(), $this->cantidad->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->cantidad->FormValue)) {
			ew_AddMessage($gsFormError, $this->cantidad->FldErrMsg());
		}
		if (!$this->precio->FldIsDetailKey && !is_null($this->precio->FormValue) && $this->precio->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->precio->FldCaption(), $this->precio->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->precio->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio->FldErrMsg());
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
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
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

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
				$sThisKey .= $row['iddetalle_documento_debito'];
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
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
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

			// iddocumento_debito
			$this->iddocumento_debito->SetDbValueDef($rsnew, $this->iddocumento_debito->CurrentValue, 0, $this->iddocumento_debito->ReadOnly);

			// idproducto
			$this->idproducto->SetDbValueDef($rsnew, $this->idproducto->CurrentValue, 0, $this->idproducto->ReadOnly);

			// idbodega
			$this->idbodega->SetDbValueDef($rsnew, $this->idbodega->CurrentValue, 0, $this->idbodega->ReadOnly);

			// cantidad
			$this->cantidad->SetDbValueDef($rsnew, $this->cantidad->CurrentValue, 0, $this->cantidad->ReadOnly);

			// precio
			$this->precio->SetDbValueDef($rsnew, $this->precio->CurrentValue, 0, $this->precio->ReadOnly);

			// monto
			$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, $this->monto->ReadOnly);

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
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
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

		// iddocumento_debito
		$this->iddocumento_debito->SetDbValueDef($rsnew, $this->iddocumento_debito->CurrentValue, 0, strval($this->iddocumento_debito->CurrentValue) == "");

		// idproducto
		$this->idproducto->SetDbValueDef($rsnew, $this->idproducto->CurrentValue, 0, strval($this->idproducto->CurrentValue) == "");

		// idbodega
		$this->idbodega->SetDbValueDef($rsnew, $this->idbodega->CurrentValue, 0, strval($this->idbodega->CurrentValue) == "");

		// cantidad
		$this->cantidad->SetDbValueDef($rsnew, $this->cantidad->CurrentValue, 0, strval($this->cantidad->CurrentValue) == "");

		// precio
		$this->precio->SetDbValueDef($rsnew, $this->precio->CurrentValue, 0, strval($this->precio->CurrentValue) == "");

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

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
			$this->iddetalle_documento_debito->setDbValue($conn->Insert_ID());
			$rsnew['iddetalle_documento_debito'] = $this->iddetalle_documento_debito->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
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
		$item->Body = "<button id=\"emf_detalle_documento_debito\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_detalle_documento_debito',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdetalle_documento_debitolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "documento_debito") {
			global $documento_debito;
			if (!isset($documento_debito)) $documento_debito = new cdocumento_debito;
			$rsmaster = $documento_debito->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$documento_debito->ExportDocument($Doc, $rsmaster, 1, 1);
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
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'detalle_documento_debito';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'detalle_documento_debito';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['iddetalle_documento_debito'];

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

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'detalle_documento_debito';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['iddetalle_documento_debito'];

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

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		if (!$this->AuditTrailOnDelete) return;
		$table = 'detalle_documento_debito';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['iddetalle_documento_debito'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
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
if (!isset($detalle_documento_debito_list)) $detalle_documento_debito_list = new cdetalle_documento_debito_list();

// Page init
$detalle_documento_debito_list->Page_Init();

// Page main
$detalle_documento_debito_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detalle_documento_debito_list->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">

// Page object
var detalle_documento_debito_list = new ew_Page("detalle_documento_debito_list");
detalle_documento_debito_list.PageID = "list"; // Page ID
var EW_PAGE_ID = detalle_documento_debito_list.PageID; // For backward compatibility

// Form object
var fdetalle_documento_debitolist = new ew_Form("fdetalle_documento_debitolist");
fdetalle_documento_debitolist.FormKeyCountName = '<?php echo $detalle_documento_debito_list->FormKeyCountName ?>';

// Validate form
fdetalle_documento_debitolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_iddocumento_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->iddocumento_debito->FldCaption(), $detalle_documento_debito->iddocumento_debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->idproducto->FldCaption(), $detalle_documento_debito->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->idbodega->FldCaption(), $detalle_documento_debito->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->cantidad->FldCaption(), $detalle_documento_debito->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->cantidad->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->precio->FldCaption(), $detalle_documento_debito->precio->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->precio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $detalle_documento_debito->monto->FldCaption(), $detalle_documento_debito->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detalle_documento_debito->monto->FldErrMsg()) ?>");

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
fdetalle_documento_debitolist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "iddocumento_debito", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idproducto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbodega", false)) return false;
	if (ew_ValueChanged(fobj, infix, "cantidad", false)) return false;
	if (ew_ValueChanged(fobj, infix, "precio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fdetalle_documento_debitolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetalle_documento_debitolist.ValidateRequired = true;
<?php } else { ?>
fdetalle_documento_debitolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetalle_documento_debitolist.Lists["x_iddocumento_debito"] = {"LinkField":"x_iddocumento_debito","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","x_correlativo",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitolist.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdetalle_documento_debitolist.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php if ($detalle_documento_debito_list->TotalRecs > 0 && $detalle_documento_debito->getCurrentMasterTable() == "" && $detalle_documento_debito_list->ExportOptions->Visible()) { ?>
<?php $detalle_documento_debito_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($detalle_documento_debito->Export == "") || (EW_EXPORT_MASTER_RECORD && $detalle_documento_debito->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "documento_debitolist.php";
if ($detalle_documento_debito_list->DbMasterFilter <> "" && $detalle_documento_debito->getCurrentMasterTable() == "documento_debito") {
	if ($detalle_documento_debito_list->MasterRecordExists) {
		if ($detalle_documento_debito->getCurrentMasterTable() == $detalle_documento_debito->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($detalle_documento_debito_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $detalle_documento_debito_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "documento_debitomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($detalle_documento_debito->CurrentAction == "gridadd") {
	$detalle_documento_debito->CurrentFilter = "0=1";
	$detalle_documento_debito_list->StartRec = 1;
	$detalle_documento_debito_list->DisplayRecs = $detalle_documento_debito->GridAddRowCount;
	$detalle_documento_debito_list->TotalRecs = $detalle_documento_debito_list->DisplayRecs;
	$detalle_documento_debito_list->StopRec = $detalle_documento_debito_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$detalle_documento_debito_list->TotalRecs = $detalle_documento_debito->SelectRecordCount();
	} else {
		if ($detalle_documento_debito_list->Recordset = $detalle_documento_debito_list->LoadRecordset())
			$detalle_documento_debito_list->TotalRecs = $detalle_documento_debito_list->Recordset->RecordCount();
	}
	$detalle_documento_debito_list->StartRec = 1;
	if ($detalle_documento_debito_list->DisplayRecs <= 0 || ($detalle_documento_debito->Export <> "" && $detalle_documento_debito->ExportAll)) // Display all records
		$detalle_documento_debito_list->DisplayRecs = $detalle_documento_debito_list->TotalRecs;
	if (!($detalle_documento_debito->Export <> "" && $detalle_documento_debito->ExportAll))
		$detalle_documento_debito_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$detalle_documento_debito_list->Recordset = $detalle_documento_debito_list->LoadRecordset($detalle_documento_debito_list->StartRec-1, $detalle_documento_debito_list->DisplayRecs);

	// Set no record found message
	if ($detalle_documento_debito->CurrentAction == "" && $detalle_documento_debito_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$detalle_documento_debito_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($detalle_documento_debito_list->SearchWhere == "0=101")
			$detalle_documento_debito_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$detalle_documento_debito_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$detalle_documento_debito_list->RenderOtherOptions();
?>
<?php $detalle_documento_debito_list->ShowPageHeader(); ?>
<?php
$detalle_documento_debito_list->ShowMessage();
?>
<?php if ($detalle_documento_debito_list->TotalRecs > 0 || $detalle_documento_debito->CurrentAction <> "") { ?>
<div class="ewGrid">
<form name="fdetalle_documento_debitolist" id="fdetalle_documento_debitolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detalle_documento_debito_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detalle_documento_debito_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detalle_documento_debito">
<div id="gmp_detalle_documento_debito" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($detalle_documento_debito_list->TotalRecs > 0) { ?>
<table id="tbl_detalle_documento_debitolist" class="table ewTable">
<?php echo $detalle_documento_debito->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$detalle_documento_debito_list->RenderListOptions();

// Render list options (header, left)
$detalle_documento_debito_list->ListOptions->Render("header", "left");
?>
<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->iddocumento_debito) == "") { ?>
		<th data-name="iddocumento_debito"><div id="elh_detalle_documento_debito_iddocumento_debito" class="detalle_documento_debito_iddocumento_debito"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->iddocumento_debito->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="iddocumento_debito"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->iddocumento_debito) ?>',1);"><div id="elh_detalle_documento_debito_iddocumento_debito" class="detalle_documento_debito_iddocumento_debito">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->iddocumento_debito->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->iddocumento_debito->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->iddocumento_debito->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->idproducto) == "") { ?>
		<th data-name="idproducto"><div id="elh_detalle_documento_debito_idproducto" class="detalle_documento_debito_idproducto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idproducto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idproducto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->idproducto) ?>',1);"><div id="elh_detalle_documento_debito_idproducto" class="detalle_documento_debito_idproducto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idproducto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->idproducto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->idproducto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->idbodega) == "") { ?>
		<th data-name="idbodega"><div id="elh_detalle_documento_debito_idbodega" class="detalle_documento_debito_idbodega"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idbodega->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbodega"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->idbodega) ?>',1);"><div id="elh_detalle_documento_debito_idbodega" class="detalle_documento_debito_idbodega">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->idbodega->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->idbodega->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->idbodega->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->cantidad) == "") { ?>
		<th data-name="cantidad"><div id="elh_detalle_documento_debito_cantidad" class="detalle_documento_debito_cantidad"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->cantidad->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cantidad"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->cantidad) ?>',1);"><div id="elh_detalle_documento_debito_cantidad" class="detalle_documento_debito_cantidad">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->cantidad->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->cantidad->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->cantidad->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->precio) == "") { ?>
		<th data-name="precio"><div id="elh_detalle_documento_debito_precio" class="detalle_documento_debito_precio"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->precio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="precio"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->precio) ?>',1);"><div id="elh_detalle_documento_debito_precio" class="detalle_documento_debito_precio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->precio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->precio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->precio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
	<?php if ($detalle_documento_debito->SortUrl($detalle_documento_debito->monto) == "") { ?>
		<th data-name="monto"><div id="elh_detalle_documento_debito_monto" class="detalle_documento_debito_monto"><div class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $detalle_documento_debito->SortUrl($detalle_documento_debito->monto) ?>',1);"><div id="elh_detalle_documento_debito_monto" class="detalle_documento_debito_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $detalle_documento_debito->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($detalle_documento_debito->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($detalle_documento_debito->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$detalle_documento_debito_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($detalle_documento_debito->ExportAll && $detalle_documento_debito->Export <> "") {
	$detalle_documento_debito_list->StopRec = $detalle_documento_debito_list->TotalRecs;
} else {

	// Set the last record to display
	if ($detalle_documento_debito_list->TotalRecs > $detalle_documento_debito_list->StartRec + $detalle_documento_debito_list->DisplayRecs - 1)
		$detalle_documento_debito_list->StopRec = $detalle_documento_debito_list->StartRec + $detalle_documento_debito_list->DisplayRecs - 1;
	else
		$detalle_documento_debito_list->StopRec = $detalle_documento_debito_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($detalle_documento_debito_list->FormKeyCountName) && ($detalle_documento_debito->CurrentAction == "gridadd" || $detalle_documento_debito->CurrentAction == "gridedit" || $detalle_documento_debito->CurrentAction == "F")) {
		$detalle_documento_debito_list->KeyCount = $objForm->GetValue($detalle_documento_debito_list->FormKeyCountName);
		$detalle_documento_debito_list->StopRec = $detalle_documento_debito_list->StartRec + $detalle_documento_debito_list->KeyCount - 1;
	}
}
$detalle_documento_debito_list->RecCnt = $detalle_documento_debito_list->StartRec - 1;
if ($detalle_documento_debito_list->Recordset && !$detalle_documento_debito_list->Recordset->EOF) {
	$detalle_documento_debito_list->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $detalle_documento_debito_list->StartRec > 1)
		$detalle_documento_debito_list->Recordset->Move($detalle_documento_debito_list->StartRec - 1);
} elseif (!$detalle_documento_debito->AllowAddDeleteRow && $detalle_documento_debito_list->StopRec == 0) {
	$detalle_documento_debito_list->StopRec = $detalle_documento_debito->GridAddRowCount;
}

// Initialize aggregate
$detalle_documento_debito->RowType = EW_ROWTYPE_AGGREGATEINIT;
$detalle_documento_debito->ResetAttrs();
$detalle_documento_debito_list->RenderRow();
if ($detalle_documento_debito->CurrentAction == "gridadd")
	$detalle_documento_debito_list->RowIndex = 0;
if ($detalle_documento_debito->CurrentAction == "gridedit")
	$detalle_documento_debito_list->RowIndex = 0;
while ($detalle_documento_debito_list->RecCnt < $detalle_documento_debito_list->StopRec) {
	$detalle_documento_debito_list->RecCnt++;
	if (intval($detalle_documento_debito_list->RecCnt) >= intval($detalle_documento_debito_list->StartRec)) {
		$detalle_documento_debito_list->RowCnt++;
		if ($detalle_documento_debito->CurrentAction == "gridadd" || $detalle_documento_debito->CurrentAction == "gridedit" || $detalle_documento_debito->CurrentAction == "F") {
			$detalle_documento_debito_list->RowIndex++;
			$objForm->Index = $detalle_documento_debito_list->RowIndex;
			if ($objForm->HasValue($detalle_documento_debito_list->FormActionName))
				$detalle_documento_debito_list->RowAction = strval($objForm->GetValue($detalle_documento_debito_list->FormActionName));
			elseif ($detalle_documento_debito->CurrentAction == "gridadd")
				$detalle_documento_debito_list->RowAction = "insert";
			else
				$detalle_documento_debito_list->RowAction = "";
		}

		// Set up key count
		$detalle_documento_debito_list->KeyCount = $detalle_documento_debito_list->RowIndex;

		// Init row class and style
		$detalle_documento_debito->ResetAttrs();
		$detalle_documento_debito->CssClass = "";
		if ($detalle_documento_debito->CurrentAction == "gridadd") {
			$detalle_documento_debito_list->LoadDefaultValues(); // Load default values
		} else {
			$detalle_documento_debito_list->LoadRowValues($detalle_documento_debito_list->Recordset); // Load row values
		}
		$detalle_documento_debito->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($detalle_documento_debito->CurrentAction == "gridadd") // Grid add
			$detalle_documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
		if ($detalle_documento_debito->CurrentAction == "gridadd" && $detalle_documento_debito->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$detalle_documento_debito_list->RestoreCurrentRowFormValues($detalle_documento_debito_list->RowIndex); // Restore form values
		if ($detalle_documento_debito->CurrentAction == "gridedit") { // Grid edit
			if ($detalle_documento_debito->EventCancelled) {
				$detalle_documento_debito_list->RestoreCurrentRowFormValues($detalle_documento_debito_list->RowIndex); // Restore form values
			}
			if ($detalle_documento_debito_list->RowAction == "insert")
				$detalle_documento_debito->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$detalle_documento_debito->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($detalle_documento_debito->CurrentAction == "gridedit" && ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_debito->RowType == EW_ROWTYPE_ADD) && $detalle_documento_debito->EventCancelled) // Update failed
			$detalle_documento_debito_list->RestoreCurrentRowFormValues($detalle_documento_debito_list->RowIndex); // Restore form values
		if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) // Edit row
			$detalle_documento_debito_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$detalle_documento_debito->RowAttrs = array_merge($detalle_documento_debito->RowAttrs, array('data-rowindex'=>$detalle_documento_debito_list->RowCnt, 'id'=>'r' . $detalle_documento_debito_list->RowCnt . '_detalle_documento_debito', 'data-rowtype'=>$detalle_documento_debito->RowType));

		// Render row
		$detalle_documento_debito_list->RenderRow();

		// Render list options
		$detalle_documento_debito_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($detalle_documento_debito_list->RowAction <> "delete" && $detalle_documento_debito_list->RowAction <> "insertdelete" && !($detalle_documento_debito_list->RowAction == "insert" && $detalle_documento_debito->CurrentAction == "F" && $detalle_documento_debito_list->EmptyRow())) {
?>
	<tr<?php echo $detalle_documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_debito_list->ListOptions->Render("body", "left", $detalle_documento_debito_list->RowCnt);
?>
	<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
		<td data-name="iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->iddocumento_debito->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $detalle_documento_debito_list->PageObjName . "_row_" . $detalle_documento_debito_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddetalle_documento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->CurrentValue) ?>">
<input type="hidden" data-field="x_iddetalle_documento_debito" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT || $detalle_documento_debito->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddetalle_documento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddetalle_documento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddetalle_documento_debito->CurrentValue) ?>">
<?php } ?>
	<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
		<td data-name="idproducto"<?php echo $detalle_documento_debito->idproducto->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->idproducto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idproducto->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
		<td data-name="idbodega"<?php echo $detalle_documento_debito->idbodega->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->idbodega->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->idbodega->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
		<td data-name="cantidad"<?php echo $detalle_documento_debito->cantidad->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->cantidad->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->cantidad->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
		<td data-name="precio"<?php echo $detalle_documento_debito->precio->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->precio->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->precio->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $detalle_documento_debito->monto->CellAttributes() ?>>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->OldValue) ?>">
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $detalle_documento_debito_list->RowCnt ?>_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $detalle_documento_debito->monto->ViewAttributes() ?>>
<?php echo $detalle_documento_debito->monto->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_debito_list->ListOptions->Render("body", "right", $detalle_documento_debito_list->RowCnt);
?>
	</tr>
<?php if ($detalle_documento_debito->RowType == EW_ROWTYPE_ADD || $detalle_documento_debito->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdetalle_documento_debitolist.UpdateOpts(<?php echo $detalle_documento_debito_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($detalle_documento_debito->CurrentAction <> "gridadd")
		if (!$detalle_documento_debito_list->Recordset->EOF) $detalle_documento_debito_list->Recordset->MoveNext();
}
?>
<?php
	if ($detalle_documento_debito->CurrentAction == "gridadd" || $detalle_documento_debito->CurrentAction == "gridedit") {
		$detalle_documento_debito_list->RowIndex = '$rowindex$';
		$detalle_documento_debito_list->LoadDefaultValues();

		// Set row properties
		$detalle_documento_debito->ResetAttrs();
		$detalle_documento_debito->RowAttrs = array_merge($detalle_documento_debito->RowAttrs, array('data-rowindex'=>$detalle_documento_debito_list->RowIndex, 'id'=>'r0_detalle_documento_debito', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($detalle_documento_debito->RowAttrs["class"], "ewTemplate");
		$detalle_documento_debito->RowType = EW_ROWTYPE_ADD;

		// Render row
		$detalle_documento_debito_list->RenderRow();

		// Render list options
		$detalle_documento_debito_list->RenderListOptions();
		$detalle_documento_debito_list->StartRowCnt = 0;
?>
	<tr<?php echo $detalle_documento_debito->RowAttributes() ?>>
<?php

// Render list options (body, left)
$detalle_documento_debito_list->ListOptions->Render("body", "left", $detalle_documento_debito_list->RowIndex);
?>
	<?php if ($detalle_documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
		<td>
<?php if ($detalle_documento_debito->iddocumento_debito->getSessionValue() <> "") { ?>
<span id="el$rowindex$_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<span<?php echo $detalle_documento_debito->iddocumento_debito->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detalle_documento_debito->iddocumento_debito->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_detalle_documento_debito_iddocumento_debito" class="form-group detalle_documento_debito_iddocumento_debito">
<select data-field="x_iddocumento_debito" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito"<?php echo $detalle_documento_debito->iddocumento_debito->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->iddocumento_debito->EditValue)) {
	$arwrk = $detalle_documento_debito->iddocumento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->iddocumento_debito->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->iddocumento_debito->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->iddocumento_debito, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `correlativo`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`iddocumento_debito` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_iddocumento_debito" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_iddocumento_debito" value="<?php echo ew_HtmlEncode($detalle_documento_debito->iddocumento_debito->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idproducto->Visible) { // idproducto ?>
		<td>
<span id="el$rowindex$_detalle_documento_debito_idproducto" class="form-group detalle_documento_debito_idproducto">
<select data-field="x_idproducto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto"<?php echo $detalle_documento_debito->idproducto->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idproducto->EditValue)) {
	$arwrk = $detalle_documento_debito->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idproducto->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idproducto, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idproducto" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idproducto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idproducto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->idbodega->Visible) { // idbodega ?>
		<td>
<span id="el$rowindex$_detalle_documento_debito_idbodega" class="form-group detalle_documento_debito_idbodega">
<select data-field="x_idbodega" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega"<?php echo $detalle_documento_debito->idbodega->EditAttributes() ?>>
<?php
if (is_array($detalle_documento_debito->idbodega->EditValue)) {
	$arwrk = $detalle_documento_debito->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($detalle_documento_debito->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $detalle_documento_debito->idbodega->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$detalle_documento_debito->Lookup_Selecting($detalle_documento_debito->idbodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" id="s_x<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idbodega" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_idbodega" value="<?php echo ew_HtmlEncode($detalle_documento_debito->idbodega->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->cantidad->Visible) { // cantidad ?>
		<td>
<span id="el$rowindex$_detalle_documento_debito_cantidad" class="form-group detalle_documento_debito_cantidad">
<input type="text" data-field="x_cantidad" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->cantidad->EditValue ?>"<?php echo $detalle_documento_debito->cantidad->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_cantidad" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_cantidad" value="<?php echo ew_HtmlEncode($detalle_documento_debito->cantidad->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->precio->Visible) { // precio ?>
		<td>
<span id="el$rowindex$_detalle_documento_debito_precio" class="form-group detalle_documento_debito_precio">
<input type="text" data-field="x_precio" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->precio->EditValue ?>"<?php echo $detalle_documento_debito->precio->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_precio" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_precio" value="<?php echo ew_HtmlEncode($detalle_documento_debito->precio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($detalle_documento_debito->monto->Visible) { // monto ?>
		<td>
<span id="el$rowindex$_detalle_documento_debito_monto" class="form-group detalle_documento_debito_monto">
<input type="text" data-field="x_monto" name="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" id="x<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->PlaceHolder) ?>" value="<?php echo $detalle_documento_debito->monto->EditValue ?>"<?php echo $detalle_documento_debito->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" id="o<?php echo $detalle_documento_debito_list->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($detalle_documento_debito->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$detalle_documento_debito_list->ListOptions->Render("body", "right", $detalle_documento_debito_list->RowCnt);
?>
<script type="text/javascript">
fdetalle_documento_debitolist.UpdateOpts(<?php echo $detalle_documento_debito_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($detalle_documento_debito->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $detalle_documento_debito_list->FormKeyCountName ?>" id="<?php echo $detalle_documento_debito_list->FormKeyCountName ?>" value="<?php echo $detalle_documento_debito_list->KeyCount ?>">
<?php echo $detalle_documento_debito_list->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_debito->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $detalle_documento_debito_list->FormKeyCountName ?>" id="<?php echo $detalle_documento_debito_list->FormKeyCountName ?>" value="<?php echo $detalle_documento_debito_list->KeyCount ?>">
<?php echo $detalle_documento_debito_list->MultiSelectKey ?>
<?php } ?>
<?php if ($detalle_documento_debito->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($detalle_documento_debito_list->Recordset)
	$detalle_documento_debito_list->Recordset->Close();
?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($detalle_documento_debito->CurrentAction <> "gridadd" && $detalle_documento_debito->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($detalle_documento_debito_list->Pager)) $detalle_documento_debito_list->Pager = new cPrevNextPager($detalle_documento_debito_list->StartRec, $detalle_documento_debito_list->DisplayRecs, $detalle_documento_debito_list->TotalRecs) ?>
<?php if ($detalle_documento_debito_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($detalle_documento_debito_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $detalle_documento_debito_list->PageUrl() ?>start=<?php echo $detalle_documento_debito_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($detalle_documento_debito_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $detalle_documento_debito_list->PageUrl() ?>start=<?php echo $detalle_documento_debito_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $detalle_documento_debito_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($detalle_documento_debito_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $detalle_documento_debito_list->PageUrl() ?>start=<?php echo $detalle_documento_debito_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($detalle_documento_debito_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $detalle_documento_debito_list->PageUrl() ?>start=<?php echo $detalle_documento_debito_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $detalle_documento_debito_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $detalle_documento_debito_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $detalle_documento_debito_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $detalle_documento_debito_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_debito_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($detalle_documento_debito_list->TotalRecs == 0 && $detalle_documento_debito->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($detalle_documento_debito_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($detalle_documento_debito->Export == "") { ?>
<script type="text/javascript">
fdetalle_documento_debitolist.Init();
</script>
<?php } ?>
<?php
$detalle_documento_debito_list->ShowPageFooter();
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
$detalle_documento_debito_list->Page_Terminate();
?>
