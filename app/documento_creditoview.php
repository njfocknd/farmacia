<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "documento_creditoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "detalle_documento_creditogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$documento_credito_view = NULL; // Initialize page object first

class cdocumento_credito_view extends cdocumento_credito {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_credito';

	// Page object name
	var $PageObjName = 'documento_credito_view';

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

		// Table object (documento_credito)
		if (!isset($GLOBALS["documento_credito"]) || get_class($GLOBALS["documento_credito"]) == "cdocumento_credito") {
			$GLOBALS["documento_credito"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_credito"];
		}
		$KeyUrl = "";
		if (@$_GET["iddocumento_credito"] <> "") {
			$this->RecKey["iddocumento_credito"] = $_GET["iddocumento_credito"];
			$KeyUrl .= "&amp;iddocumento_credito=" . urlencode($this->RecKey["iddocumento_credito"]);
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

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_credito', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("documento_creditolist.php"));
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
		if (@$_GET["iddocumento_credito"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["iddocumento_credito"]);
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
		$this->iddocumento_credito->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Process auto fill for detail table 'detalle_documento_credito'
			if (@$_POST["grid"] == "fdetalle_documento_creditogrid") {
				if (!isset($GLOBALS["detalle_documento_credito_grid"])) $GLOBALS["detalle_documento_credito_grid"] = new cdetalle_documento_credito_grid;
				$GLOBALS["detalle_documento_credito_grid"]->Page_Init();
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
		global $EW_EXPORT, $documento_credito;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($documento_credito);
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

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["iddocumento_credito"] <> "") {
				$this->iddocumento_credito->setQueryStringValue($_GET["iddocumento_credito"]);
				$this->RecKey["iddocumento_credito"] = $this->iddocumento_credito->QueryStringValue;
			} else {
				$sReturnUrl = "documento_creditolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "documento_creditolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "documento_creditolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
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

		// Show detail edit/copy
		if ($this->getCurrentDetailTable() <> "") {

			// Detail Edit
			$item = &$option->Add("detailedit");
			$item->Body = "<a class=\"ewAction ewDetailEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable())) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a>";
			$item->Visible = ($Security->CanEdit());
		}
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_detalle_documento_credito"
		$item = &$option->Add("detail_detalle_documento_credito");
		$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("detalle_documento_credito", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("detalle_documento_creditolist.php?" . EW_TABLE_SHOW_MASTER . "=documento_credito&fk_iddocumento_credito=" . strval($this->iddocumento_credito->CurrentValue) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["detalle_documento_credito_grid"] && $GLOBALS["detalle_documento_credito_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'detalle_documento_credito')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=detalle_documento_credito")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "detalle_documento_credito";
		}
		if ($GLOBALS["detalle_documento_credito_grid"] && $GLOBALS["detalle_documento_credito_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'detalle_documento_credito')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=detalle_documento_credito")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "detalle_documento_credito";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'detalle_documento_credito');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "detalle_documento_credito";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		$this->iddocumento_credito->setDbValue($rs->fields('iddocumento_credito'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->correlativo->setDbValue($rs->fields('correlativo'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
		$this->estado_documento->setDbValue($rs->fields('estado_documento'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->idproveedor->setDbValue($rs->fields('idproveedor'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddocumento_credito->DbValue = $row['iddocumento_credito'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->serie->DbValue = $row['serie'];
		$this->correlativo->DbValue = $row['correlativo'];
		$this->fecha->DbValue = $row['fecha'];
		$this->observaciones->DbValue = $row['observaciones'];
		$this->estado_documento->DbValue = $row['estado_documento'];
		$this->estado->DbValue = $row['estado'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->idproveedor->DbValue = $row['idproveedor'];
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
		// iddocumento_credito
		// idtipo_documento
		// idsucursal
		// serie
		// correlativo
		// fecha
		// observaciones
		// estado_documento
		// estado
		// monto
		// fecha_insercion
		// idproveedor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// iddocumento_credito
			$this->iddocumento_credito->ViewValue = $this->iddocumento_credito->CurrentValue;
			$this->iddocumento_credito->ViewCustomAttributes = "";

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
			$sSqlWrk .= " ORDER BY `nombre`";
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

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -2, -2, -2);
			$this->monto->CellCssStyle .= "text-align: right;";
			$this->monto->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// idproveedor
			if (strval($this->idproveedor->CurrentValue) <> "") {
				$sFilterWrk = "`idproveedor`" . ew_SearchString("=", $this->idproveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idproveedor`, `nombre_factura` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `proveedor`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproveedor, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idproveedor->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idproveedor->ViewValue = $this->idproveedor->CurrentValue;
				}
			} else {
				$this->idproveedor->ViewValue = NULL;
			}
			$this->idproveedor->ViewCustomAttributes = "";

			// iddocumento_credito
			$this->iddocumento_credito->LinkCustomAttributes = "";
			$this->iddocumento_credito->HrefValue = "";
			$this->iddocumento_credito->TooltipValue = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

			// serie
			$this->serie->LinkCustomAttributes = "";
			$this->serie->HrefValue = "";
			$this->serie->TooltipValue = "";

			// correlativo
			$this->correlativo->LinkCustomAttributes = "";
			$this->correlativo->HrefValue = "";
			$this->correlativo->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

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

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// idproveedor
			$this->idproveedor->LinkCustomAttributes = "";
			$this->idproveedor->HrefValue = "";
			$this->idproveedor->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_documento_credito\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_documento_credito',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdocumento_creditoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export detail records (detalle_documento_credito)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("detalle_documento_credito", explode(",", $this->getCurrentDetailTable()))) {
			global $detalle_documento_credito;
			if (!isset($detalle_documento_credito)) $detalle_documento_credito = new cdetalle_documento_credito;
			$rsdetail = $detalle_documento_credito->LoadRs($detalle_documento_credito->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$detalle_documento_credito->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsdetail->Close();
			}
		}
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
			if (in_array("detalle_documento_credito", $DetailTblVar)) {
				if (!isset($GLOBALS["detalle_documento_credito_grid"]))
					$GLOBALS["detalle_documento_credito_grid"] = new cdetalle_documento_credito_grid;
				if ($GLOBALS["detalle_documento_credito_grid"]->DetailView) {
					$GLOBALS["detalle_documento_credito_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["detalle_documento_credito_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["detalle_documento_credito_grid"]->setStartRecordNumber(1);
					$GLOBALS["detalle_documento_credito_grid"]->iddocumento_credito->FldIsDetailKey = TRUE;
					$GLOBALS["detalle_documento_credito_grid"]->iddocumento_credito->CurrentValue = $this->iddocumento_credito->CurrentValue;
					$GLOBALS["detalle_documento_credito_grid"]->iddocumento_credito->setSessionValue($GLOBALS["detalle_documento_credito_grid"]->iddocumento_credito->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "documento_creditolist.php", "", $this->TableVar, TRUE);
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
if (!isset($documento_credito_view)) $documento_credito_view = new cdocumento_credito_view();

// Page init
$documento_credito_view->Page_Init();

// Page main
$documento_credito_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_credito_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($documento_credito->Export == "") { ?>
<script type="text/javascript">

// Page object
var documento_credito_view = new ew_Page("documento_credito_view");
documento_credito_view.PageID = "view"; // Page ID
var EW_PAGE_ID = documento_credito_view.PageID; // For backward compatibility

// Form object
var fdocumento_creditoview = new ew_Form("fdocumento_creditoview");

// Form_CustomValidate event
fdocumento_creditoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_creditoview.ValidateRequired = true;
<?php } else { ?>
fdocumento_creditoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_creditoview.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_creditoview.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_creditoview.Lists["x_idproveedor"] = {"LinkField":"x_idproveedor","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre_factura","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($documento_credito->Export == "") { ?>
<div class="ewToolbar">
<?php if ($documento_credito->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $documento_credito_view->ExportOptions->Render("body") ?>
<?php
	foreach ($documento_credito_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($documento_credito->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $documento_credito_view->ShowPageHeader(); ?>
<?php
$documento_credito_view->ShowMessage();
?>
<form name="fdocumento_creditoview" id="fdocumento_creditoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_credito_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_credito_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_credito">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($documento_credito->iddocumento_credito->Visible) { // iddocumento_credito ?>
	<tr id="r_iddocumento_credito">
		<td><span id="elh_documento_credito_iddocumento_credito"><?php echo $documento_credito->iddocumento_credito->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->iddocumento_credito->CellAttributes() ?>>
<span id="el_documento_credito_iddocumento_credito" class="form-group">
<span<?php echo $documento_credito->iddocumento_credito->ViewAttributes() ?>>
<?php echo $documento_credito->iddocumento_credito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->idtipo_documento->Visible) { // idtipo_documento ?>
	<tr id="r_idtipo_documento">
		<td><span id="elh_documento_credito_idtipo_documento"><?php echo $documento_credito->idtipo_documento->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_credito_idtipo_documento" class="form-group">
<span<?php echo $documento_credito->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_credito->idtipo_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->idsucursal->Visible) { // idsucursal ?>
	<tr id="r_idsucursal">
		<td><span id="elh_documento_credito_idsucursal"><?php echo $documento_credito->idsucursal->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->idsucursal->CellAttributes() ?>>
<span id="el_documento_credito_idsucursal" class="form-group">
<span<?php echo $documento_credito->idsucursal->ViewAttributes() ?>>
<?php echo $documento_credito->idsucursal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->serie->Visible) { // serie ?>
	<tr id="r_serie">
		<td><span id="elh_documento_credito_serie"><?php echo $documento_credito->serie->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->serie->CellAttributes() ?>>
<span id="el_documento_credito_serie" class="form-group">
<span<?php echo $documento_credito->serie->ViewAttributes() ?>>
<?php echo $documento_credito->serie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->correlativo->Visible) { // correlativo ?>
	<tr id="r_correlativo">
		<td><span id="elh_documento_credito_correlativo"><?php echo $documento_credito->correlativo->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->correlativo->CellAttributes() ?>>
<span id="el_documento_credito_correlativo" class="form-group">
<span<?php echo $documento_credito->correlativo->ViewAttributes() ?>>
<?php echo $documento_credito->correlativo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_documento_credito_fecha"><?php echo $documento_credito->fecha->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->fecha->CellAttributes() ?>>
<span id="el_documento_credito_fecha" class="form-group">
<span<?php echo $documento_credito->fecha->ViewAttributes() ?>>
<?php echo $documento_credito->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->observaciones->Visible) { // observaciones ?>
	<tr id="r_observaciones">
		<td><span id="elh_documento_credito_observaciones"><?php echo $documento_credito->observaciones->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->observaciones->CellAttributes() ?>>
<span id="el_documento_credito_observaciones" class="form-group">
<span<?php echo $documento_credito->observaciones->ViewAttributes() ?>>
<?php echo $documento_credito->observaciones->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->estado_documento->Visible) { // estado_documento ?>
	<tr id="r_estado_documento">
		<td><span id="elh_documento_credito_estado_documento"><?php echo $documento_credito->estado_documento->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->estado_documento->CellAttributes() ?>>
<span id="el_documento_credito_estado_documento" class="form-group">
<span<?php echo $documento_credito->estado_documento->ViewAttributes() ?>>
<?php echo $documento_credito->estado_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_documento_credito_estado"><?php echo $documento_credito->estado->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->estado->CellAttributes() ?>>
<span id="el_documento_credito_estado" class="form-group">
<span<?php echo $documento_credito->estado->ViewAttributes() ?>>
<?php echo $documento_credito->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_documento_credito_monto"><?php echo $documento_credito->monto->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->monto->CellAttributes() ?>>
<span id="el_documento_credito_monto" class="form-group">
<span<?php echo $documento_credito->monto->ViewAttributes() ?>>
<?php echo $documento_credito->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_documento_credito_fecha_insercion"><?php echo $documento_credito->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_credito_fecha_insercion" class="form-group">
<span<?php echo $documento_credito->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_credito->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_credito->idproveedor->Visible) { // idproveedor ?>
	<tr id="r_idproveedor">
		<td><span id="elh_documento_credito_idproveedor"><?php echo $documento_credito->idproveedor->FldCaption() ?></span></td>
		<td<?php echo $documento_credito->idproveedor->CellAttributes() ?>>
<span id="el_documento_credito_idproveedor" class="form-group">
<span<?php echo $documento_credito->idproveedor->ViewAttributes() ?>>
<?php echo $documento_credito->idproveedor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("detalle_documento_credito", explode(",", $documento_credito->getCurrentDetailTable())) && $detalle_documento_credito->DetailView) {
?>
<?php if ($documento_credito->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_credito", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_creditogrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fdocumento_creditoview.Init();
</script>
<?php
$documento_credito_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($documento_credito->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_credito_view->Page_Terminate();
?>
