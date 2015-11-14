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

$documento_debito_view = NULL; // Initialize page object first

class cdocumento_debito_view extends cdocumento_debito {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'documento_debito';

	// Page object name
	var $PageObjName = 'documento_debito_view';

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

		// Table object (documento_debito)
		if (!isset($GLOBALS["documento_debito"]) || get_class($GLOBALS["documento_debito"]) == "cdocumento_debito") {
			$GLOBALS["documento_debito"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_debito"];
		}
		$KeyUrl = "";
		if (@$_GET["iddocumento_debito"] <> "") {
			$this->RecKey["iddocumento_debito"] = $_GET["iddocumento_debito"];
			$KeyUrl .= "&amp;iddocumento_debito=" . urlencode($this->RecKey["iddocumento_debito"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

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
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_debito', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("documento_debitolist.php"));
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
		if (@$_GET["iddocumento_debito"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["iddocumento_debito"]);
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
			if (@$_GET["iddocumento_debito"] <> "") {
				$this->iddocumento_debito->setQueryStringValue($_GET["iddocumento_debito"]);
				$this->RecKey["iddocumento_debito"] = $this->iddocumento_debito->QueryStringValue;
			} else {
				$sReturnUrl = "documento_debitolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "documento_debitolist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "documento_debitolist.php"; // Not page request, return to list
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

		// "detail_detalle_documento_debito"
		$item = &$option->Add("detail_detalle_documento_debito");
		$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("detalle_documento_debito", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("detalle_documento_debitolist.php?" . EW_TABLE_SHOW_MASTER . "=documento_debito&fk_iddocumento_debito=" . strval($this->iddocumento_debito->CurrentValue) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["detalle_documento_debito_grid"] && $GLOBALS["detalle_documento_debito_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'detalle_documento_debito')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=detalle_documento_debito")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "detalle_documento_debito";
		}
		if ($GLOBALS["detalle_documento_debito_grid"] && $GLOBALS["detalle_documento_debito_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'detalle_documento_debito')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=detalle_documento_debito")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "detalle_documento_debito";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'detalle_documento_debito');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "detalle_documento_debito";
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

		// Convert decimal values if posted back
		if ($this->importe_bruto->FormValue == $this->importe_bruto->CurrentValue && is_numeric(ew_StrToFloat($this->importe_bruto->CurrentValue)))
			$this->importe_bruto->CurrentValue = ew_StrToFloat($this->importe_bruto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_descuento->FormValue == $this->importe_descuento->CurrentValue && is_numeric(ew_StrToFloat($this->importe_descuento->CurrentValue)))
			$this->importe_descuento->CurrentValue = ew_StrToFloat($this->importe_descuento->CurrentValue);

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
		if ($this->importe_isr->FormValue == $this->importe_isr->CurrentValue && is_numeric(ew_StrToFloat($this->importe_isr->CurrentValue)))
			$this->importe_isr->CurrentValue = ew_StrToFloat($this->importe_isr->CurrentValue);

		// Convert decimal values if posted back
		if ($this->importe_total->FormValue == $this->importe_total->CurrentValue && is_numeric(ew_StrToFloat($this->importe_total->CurrentValue)))
			$this->importe_total->CurrentValue = ew_StrToFloat($this->importe_total->CurrentValue);

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

			// iddocumento_debito
			$this->iddocumento_debito->LinkCustomAttributes = "";
			$this->iddocumento_debito->HrefValue = "";
			$this->iddocumento_debito->TooltipValue = "";

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

			// idmoneda
			$this->idmoneda->LinkCustomAttributes = "";
			$this->idmoneda->HrefValue = "";
			$this->idmoneda->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// importe_bruto
			$this->importe_bruto->LinkCustomAttributes = "";
			$this->importe_bruto->HrefValue = "";
			$this->importe_bruto->TooltipValue = "";

			// importe_descuento
			$this->importe_descuento->LinkCustomAttributes = "";
			$this->importe_descuento->HrefValue = "";
			$this->importe_descuento->TooltipValue = "";

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

			// importe_isr
			$this->importe_isr->LinkCustomAttributes = "";
			$this->importe_isr->HrefValue = "";
			$this->importe_isr->TooltipValue = "";

			// importe_total
			$this->importe_total->LinkCustomAttributes = "";
			$this->importe_total->HrefValue = "";
			$this->importe_total->TooltipValue = "";

			// idfecha_contable
			$this->idfecha_contable->LinkCustomAttributes = "";
			$this->idfecha_contable->HrefValue = "";
			$this->idfecha_contable->TooltipValue = "";

			// tasa_cambio
			$this->tasa_cambio->LinkCustomAttributes = "";
			$this->tasa_cambio->HrefValue = "";
			$this->tasa_cambio->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_documento_debito\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_documento_debito',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fdocumento_debitoview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export detail records (detalle_documento_debito)
		if (EW_EXPORT_DETAIL_RECORDS && in_array("detalle_documento_debito", explode(",", $this->getCurrentDetailTable()))) {
			global $detalle_documento_debito;
			if (!isset($detalle_documento_debito)) $detalle_documento_debito = new cdetalle_documento_debito;
			$rsdetail = $detalle_documento_debito->LoadRs($detalle_documento_debito->GetDetailFilter()); // Load detail records
			if ($rsdetail && !$rsdetail->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("h"); // Change to horizontal
				if ($this->Export <> "csv" || EW_EXPORT_DETAIL_RECORDS_FOR_CSV) {
					$Doc->ExportEmptyRow();
					$detailcnt = $rsdetail->RecordCount();
					$detalle_documento_debito->ExportDocument($Doc, $rsdetail, 1, $detailcnt);
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
				if ($GLOBALS["detalle_documento_debito_grid"]->DetailView) {
					$GLOBALS["detalle_documento_debito_grid"]->CurrentMode = "view";

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
if (!isset($documento_debito_view)) $documento_debito_view = new cdocumento_debito_view();

// Page init
$documento_debito_view->Page_Init();

// Page main
$documento_debito_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_debito_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if ($documento_debito->Export == "") { ?>
<script type="text/javascript">

// Page object
var documento_debito_view = new ew_Page("documento_debito_view");
documento_debito_view.PageID = "view"; // Page ID
var EW_PAGE_ID = documento_debito_view.PageID; // For backward compatibility

// Form object
var fdocumento_debitoview = new ew_Form("fdocumento_debitoview");

// Form_CustomValidate event
fdocumento_debitoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_debitoview.ValidateRequired = true;
<?php } else { ?>
fdocumento_debitoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_debitoview.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoview.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoview.Lists["x_idserie_documento"] = {"LinkField":"x_idserie_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_serie","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoview.Lists["x_idcliente"] = {"LinkField":"x_idcliente","Ajax":true,"AutoFill":false,"DisplayFields":["x_nit","x_nombre_factura","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoview.Lists["x_idmoneda"] = {"LinkField":"x_idmoneda","Ajax":true,"AutoFill":false,"DisplayFields":["x_simbolo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_debitoview.Lists["x_idfecha_contable"] = {"LinkField":"x_idfecha_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_fecha","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($documento_debito->Export == "") { ?>
<div class="ewToolbar">
<?php if ($documento_debito->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $documento_debito_view->ExportOptions->Render("body") ?>
<?php
	foreach ($documento_debito_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($documento_debito->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $documento_debito_view->ShowPageHeader(); ?>
<?php
$documento_debito_view->ShowMessage();
?>
<form name="fdocumento_debitoview" id="fdocumento_debitoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_debito_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_debito_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_debito">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($documento_debito->iddocumento_debito->Visible) { // iddocumento_debito ?>
	<tr id="r_iddocumento_debito">
		<td><span id="elh_documento_debito_iddocumento_debito"><?php echo $documento_debito->iddocumento_debito->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->iddocumento_debito->CellAttributes() ?>>
<span id="el_documento_debito_iddocumento_debito" class="form-group">
<span<?php echo $documento_debito->iddocumento_debito->ViewAttributes() ?>>
<?php echo $documento_debito->iddocumento_debito->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idtipo_documento->Visible) { // idtipo_documento ?>
	<tr id="r_idtipo_documento">
		<td><span id="elh_documento_debito_idtipo_documento"><?php echo $documento_debito->idtipo_documento->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_debito_idtipo_documento" class="form-group">
<span<?php echo $documento_debito->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_debito->idtipo_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idsucursal->Visible) { // idsucursal ?>
	<tr id="r_idsucursal">
		<td><span id="elh_documento_debito_idsucursal"><?php echo $documento_debito->idsucursal->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idsucursal->CellAttributes() ?>>
<span id="el_documento_debito_idsucursal" class="form-group">
<span<?php echo $documento_debito->idsucursal->ViewAttributes() ?>>
<?php echo $documento_debito->idsucursal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idserie_documento->Visible) { // idserie_documento ?>
	<tr id="r_idserie_documento">
		<td><span id="elh_documento_debito_idserie_documento"><?php echo $documento_debito->idserie_documento->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idserie_documento->CellAttributes() ?>>
<span id="el_documento_debito_idserie_documento" class="form-group">
<span<?php echo $documento_debito->idserie_documento->ViewAttributes() ?>>
<?php echo $documento_debito->idserie_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->serie->Visible) { // serie ?>
	<tr id="r_serie">
		<td><span id="elh_documento_debito_serie"><?php echo $documento_debito->serie->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->serie->CellAttributes() ?>>
<span id="el_documento_debito_serie" class="form-group">
<span<?php echo $documento_debito->serie->ViewAttributes() ?>>
<?php echo $documento_debito->serie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->correlativo->Visible) { // correlativo ?>
	<tr id="r_correlativo">
		<td><span id="elh_documento_debito_correlativo"><?php echo $documento_debito->correlativo->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->correlativo->CellAttributes() ?>>
<span id="el_documento_debito_correlativo" class="form-group">
<span<?php echo $documento_debito->correlativo->ViewAttributes() ?>>
<?php echo $documento_debito->correlativo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_documento_debito_fecha"><?php echo $documento_debito->fecha->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->fecha->CellAttributes() ?>>
<span id="el_documento_debito_fecha" class="form-group">
<span<?php echo $documento_debito->fecha->ViewAttributes() ?>>
<?php echo $documento_debito->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idcliente->Visible) { // idcliente ?>
	<tr id="r_idcliente">
		<td><span id="elh_documento_debito_idcliente"><?php echo $documento_debito->idcliente->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idcliente->CellAttributes() ?>>
<span id="el_documento_debito_idcliente" class="form-group">
<span<?php echo $documento_debito->idcliente->ViewAttributes() ?>>
<?php echo $documento_debito->idcliente->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->nombre->Visible) { // nombre ?>
	<tr id="r_nombre">
		<td><span id="elh_documento_debito_nombre"><?php echo $documento_debito->nombre->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->nombre->CellAttributes() ?>>
<span id="el_documento_debito_nombre" class="form-group">
<span<?php echo $documento_debito->nombre->ViewAttributes() ?>>
<?php echo $documento_debito->nombre->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->direccion->Visible) { // direccion ?>
	<tr id="r_direccion">
		<td><span id="elh_documento_debito_direccion"><?php echo $documento_debito->direccion->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->direccion->CellAttributes() ?>>
<span id="el_documento_debito_direccion" class="form-group">
<span<?php echo $documento_debito->direccion->ViewAttributes() ?>>
<?php echo $documento_debito->direccion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->nit->Visible) { // nit ?>
	<tr id="r_nit">
		<td><span id="elh_documento_debito_nit"><?php echo $documento_debito->nit->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->nit->CellAttributes() ?>>
<span id="el_documento_debito_nit" class="form-group">
<span<?php echo $documento_debito->nit->ViewAttributes() ?>>
<?php echo $documento_debito->nit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->observaciones->Visible) { // observaciones ?>
	<tr id="r_observaciones">
		<td><span id="elh_documento_debito_observaciones"><?php echo $documento_debito->observaciones->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->observaciones->CellAttributes() ?>>
<span id="el_documento_debito_observaciones" class="form-group">
<span<?php echo $documento_debito->observaciones->ViewAttributes() ?>>
<?php echo $documento_debito->observaciones->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->estado_documento->Visible) { // estado_documento ?>
	<tr id="r_estado_documento">
		<td><span id="elh_documento_debito_estado_documento"><?php echo $documento_debito->estado_documento->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->estado_documento->CellAttributes() ?>>
<span id="el_documento_debito_estado_documento" class="form-group">
<span<?php echo $documento_debito->estado_documento->ViewAttributes() ?>>
<?php echo $documento_debito->estado_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_documento_debito_estado"><?php echo $documento_debito->estado->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->estado->CellAttributes() ?>>
<span id="el_documento_debito_estado" class="form-group">
<span<?php echo $documento_debito->estado->ViewAttributes() ?>>
<?php echo $documento_debito->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->fecha_anulacion->Visible) { // fecha_anulacion ?>
	<tr id="r_fecha_anulacion">
		<td><span id="elh_documento_debito_fecha_anulacion"><?php echo $documento_debito->fecha_anulacion->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->fecha_anulacion->CellAttributes() ?>>
<span id="el_documento_debito_fecha_anulacion" class="form-group">
<span<?php echo $documento_debito->fecha_anulacion->ViewAttributes() ?>>
<?php echo $documento_debito->fecha_anulacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->motivo_anulacion->Visible) { // motivo_anulacion ?>
	<tr id="r_motivo_anulacion">
		<td><span id="elh_documento_debito_motivo_anulacion"><?php echo $documento_debito->motivo_anulacion->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->motivo_anulacion->CellAttributes() ?>>
<span id="el_documento_debito_motivo_anulacion" class="form-group">
<span<?php echo $documento_debito->motivo_anulacion->ViewAttributes() ?>>
<?php echo $documento_debito->motivo_anulacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idmoneda->Visible) { // idmoneda ?>
	<tr id="r_idmoneda">
		<td><span id="elh_documento_debito_idmoneda"><?php echo $documento_debito->idmoneda->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idmoneda->CellAttributes() ?>>
<span id="el_documento_debito_idmoneda" class="form-group">
<span<?php echo $documento_debito->idmoneda->ViewAttributes() ?>>
<?php echo $documento_debito->idmoneda->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_documento_debito_monto"><?php echo $documento_debito->monto->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->monto->CellAttributes() ?>>
<span id="el_documento_debito_monto" class="form-group">
<span<?php echo $documento_debito->monto->ViewAttributes() ?>>
<?php echo $documento_debito->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_documento_debito_fecha_insercion"><?php echo $documento_debito->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_debito_fecha_insercion" class="form-group">
<span<?php echo $documento_debito->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_debito->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_bruto->Visible) { // importe_bruto ?>
	<tr id="r_importe_bruto">
		<td><span id="elh_documento_debito_importe_bruto"><?php echo $documento_debito->importe_bruto->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_bruto->CellAttributes() ?>>
<span id="el_documento_debito_importe_bruto" class="form-group">
<span<?php echo $documento_debito->importe_bruto->ViewAttributes() ?>>
<?php echo $documento_debito->importe_bruto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_descuento->Visible) { // importe_descuento ?>
	<tr id="r_importe_descuento">
		<td><span id="elh_documento_debito_importe_descuento"><?php echo $documento_debito->importe_descuento->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_descuento->CellAttributes() ?>>
<span id="el_documento_debito_importe_descuento" class="form-group">
<span<?php echo $documento_debito->importe_descuento->ViewAttributes() ?>>
<?php echo $documento_debito->importe_descuento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_exento->Visible) { // importe_exento ?>
	<tr id="r_importe_exento">
		<td><span id="elh_documento_debito_importe_exento"><?php echo $documento_debito->importe_exento->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_exento->CellAttributes() ?>>
<span id="el_documento_debito_importe_exento" class="form-group">
<span<?php echo $documento_debito->importe_exento->ViewAttributes() ?>>
<?php echo $documento_debito->importe_exento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_neto->Visible) { // importe_neto ?>
	<tr id="r_importe_neto">
		<td><span id="elh_documento_debito_importe_neto"><?php echo $documento_debito->importe_neto->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_neto->CellAttributes() ?>>
<span id="el_documento_debito_importe_neto" class="form-group">
<span<?php echo $documento_debito->importe_neto->ViewAttributes() ?>>
<?php echo $documento_debito->importe_neto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_iva->Visible) { // importe_iva ?>
	<tr id="r_importe_iva">
		<td><span id="elh_documento_debito_importe_iva"><?php echo $documento_debito->importe_iva->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_iva->CellAttributes() ?>>
<span id="el_documento_debito_importe_iva" class="form-group">
<span<?php echo $documento_debito->importe_iva->ViewAttributes() ?>>
<?php echo $documento_debito->importe_iva->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_otros_impuestos->Visible) { // importe_otros_impuestos ?>
	<tr id="r_importe_otros_impuestos">
		<td><span id="elh_documento_debito_importe_otros_impuestos"><?php echo $documento_debito->importe_otros_impuestos->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_otros_impuestos->CellAttributes() ?>>
<span id="el_documento_debito_importe_otros_impuestos" class="form-group">
<span<?php echo $documento_debito->importe_otros_impuestos->ViewAttributes() ?>>
<?php echo $documento_debito->importe_otros_impuestos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_isr->Visible) { // importe_isr ?>
	<tr id="r_importe_isr">
		<td><span id="elh_documento_debito_importe_isr"><?php echo $documento_debito->importe_isr->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_isr->CellAttributes() ?>>
<span id="el_documento_debito_importe_isr" class="form-group">
<span<?php echo $documento_debito->importe_isr->ViewAttributes() ?>>
<?php echo $documento_debito->importe_isr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->importe_total->Visible) { // importe_total ?>
	<tr id="r_importe_total">
		<td><span id="elh_documento_debito_importe_total"><?php echo $documento_debito->importe_total->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->importe_total->CellAttributes() ?>>
<span id="el_documento_debito_importe_total" class="form-group">
<span<?php echo $documento_debito->importe_total->ViewAttributes() ?>>
<?php echo $documento_debito->importe_total->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->idfecha_contable->Visible) { // idfecha_contable ?>
	<tr id="r_idfecha_contable">
		<td><span id="elh_documento_debito_idfecha_contable"><?php echo $documento_debito->idfecha_contable->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->idfecha_contable->CellAttributes() ?>>
<span id="el_documento_debito_idfecha_contable" class="form-group">
<span<?php echo $documento_debito->idfecha_contable->ViewAttributes() ?>>
<?php echo $documento_debito->idfecha_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_debito->tasa_cambio->Visible) { // tasa_cambio ?>
	<tr id="r_tasa_cambio">
		<td><span id="elh_documento_debito_tasa_cambio"><?php echo $documento_debito->tasa_cambio->FldCaption() ?></span></td>
		<td<?php echo $documento_debito->tasa_cambio->CellAttributes() ?>>
<span id="el_documento_debito_tasa_cambio" class="form-group">
<span<?php echo $documento_debito->tasa_cambio->ViewAttributes() ?>>
<?php echo $documento_debito->tasa_cambio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("detalle_documento_debito", explode(",", $documento_debito->getCurrentDetailTable())) && $detalle_documento_debito->DetailView) {
?>
<?php if ($documento_debito->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detalle_documento_debito", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detalle_documento_debitogrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fdocumento_debitoview.Init();
</script>
<?php
$documento_debito_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($documento_debito->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$documento_debito_view->Page_Terminate();
?>
