<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "metainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "periodo_contableinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$meta_add = NULL; // Initialize page object first

class cmeta_add extends cmeta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'meta';

	// Page object name
	var $PageObjName = 'meta_add';

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

		// Table object (meta)
		if (!isset($GLOBALS["meta"]) || get_class($GLOBALS["meta"]) == "cmeta") {
			$GLOBALS["meta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["meta"];
		}

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'meta', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("metalist.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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
		global $EW_EXPORT, $meta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($meta);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idmeta"] != "") {
				$this->idmeta->setQueryStringValue($_GET["idmeta"]);
				$this->setKey("idmeta", $this->idmeta->CurrentValue); // Set up key
			} else {
				$this->setKey("idmeta", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("metalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "metaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->idsucursal->CurrentValue = 1;
		$this->idperiodo_contable->CurrentValue = 1;
		$this->monto->CurrentValue = 0.00;
		$this->cantidad->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idsucursal->FldIsDetailKey) {
			$this->idsucursal->setFormValue($objForm->GetValue("x_idsucursal"));
		}
		if (!$this->idperiodo_contable->FldIsDetailKey) {
			$this->idperiodo_contable->setFormValue($objForm->GetValue("x_idperiodo_contable"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->cantidad->FldIsDetailKey) {
			$this->cantidad->setFormValue($objForm->GetValue("x_cantidad"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idsucursal->CurrentValue = $this->idsucursal->FormValue;
		$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->cantidad->CurrentValue = $this->cantidad->FormValue;
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
		$this->idmeta->setDbValue($rs->fields('idmeta'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idmeta->DbValue = $row['idmeta'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->idperiodo_contable->DbValue = $row['idperiodo_contable'];
		$this->monto->DbValue = $row['monto'];
		$this->cantidad->DbValue = $row['cantidad'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idmeta")) <> "")
			$this->idmeta->CurrentValue = $this->getKey("idmeta"); // idmeta
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
		// Convert decimal values if posted back

		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idmeta
		// idsucursal
		// idperiodo_contable
		// monto
		// cantidad
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idmeta
			$this->idmeta->ViewValue = $this->idmeta->CurrentValue;
			$this->idmeta->ViewCustomAttributes = "";

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

			// monto
			$this->monto->ViewValue = $this->monto->CurrentValue;
			$this->monto->ViewValue = ew_FormatCurrency($this->monto->ViewValue, 2, -2, -2, -2);
			$this->monto->ViewCustomAttributes = "";

			// cantidad
			$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
			$this->cantidad->ViewValue = ew_FormatNumber($this->cantidad->ViewValue, 0, -2, -2, -2);
			$this->cantidad->ViewCustomAttributes = "";

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
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";
			$this->idperiodo_contable->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// cantidad
			$this->cantidad->LinkCustomAttributes = "";
			$this->cantidad->HrefValue = "";
			$this->cantidad->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idsucursal
			$this->idsucursal->EditAttrs["class"] = "form-control";
			$this->idsucursal->EditCustomAttributes = "";
			if (trim(strval($this->idsucursal->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idsucursal`" . ew_SearchString("=", $this->idsucursal->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sucursal`";
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
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsucursal->EditValue = $arwrk;

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			if ($this->idperiodo_contable->getSessionValue() <> "") {
				$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->getSessionValue();
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

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -2, -2, -2);

			// cantidad
			$this->cantidad->EditAttrs["class"] = "form-control";
			$this->cantidad->EditCustomAttributes = "";
			$this->cantidad->EditValue = ew_HtmlEncode($this->cantidad->CurrentValue);
			$this->cantidad->PlaceHolder = ew_RemoveHtml($this->cantidad->FldCaption());

			// Edit refer script
			// idsucursal

			$this->idsucursal->HrefValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->HrefValue = "";

			// monto
			$this->monto->HrefValue = "";

			// cantidad
			$this->cantidad->HrefValue = "";
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
		if (!$this->idsucursal->FldIsDetailKey && !is_null($this->idsucursal->FormValue) && $this->idsucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsucursal->FldCaption(), $this->idsucursal->ReqErrMsg));
		}
		if (!$this->idperiodo_contable->FldIsDetailKey && !is_null($this->idperiodo_contable->FormValue) && $this->idperiodo_contable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idperiodo_contable->FldCaption(), $this->idperiodo_contable->ReqErrMsg));
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if (!$this->cantidad->FldIsDetailKey && !is_null($this->cantidad->FormValue) && $this->cantidad->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cantidad->FldCaption(), $this->cantidad->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->cantidad->FormValue)) {
			ew_AddMessage($gsFormError, $this->cantidad->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idsucursal
		$this->idsucursal->SetDbValueDef($rsnew, $this->idsucursal->CurrentValue, 0, strval($this->idsucursal->CurrentValue) == "");

		// idperiodo_contable
		$this->idperiodo_contable->SetDbValueDef($rsnew, $this->idperiodo_contable->CurrentValue, 0, strval($this->idperiodo_contable->CurrentValue) == "");

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// cantidad
		$this->cantidad->SetDbValueDef($rsnew, $this->cantidad->CurrentValue, 0, strval($this->cantidad->CurrentValue) == "");

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
			$this->idmeta->setDbValue($conn->Insert_ID());
			$rsnew['idmeta'] = $this->idmeta->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$Breadcrumb->Add("list", $this->TableVar, "metalist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
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
if (!isset($meta_add)) $meta_add = new cmeta_add();

// Page init
$meta_add->Page_Init();

// Page main
$meta_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$meta_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var meta_add = new ew_Page("meta_add");
meta_add.PageID = "add"; // Page ID
var EW_PAGE_ID = meta_add.PageID; // For backward compatibility

// Form object
var fmetaadd = new ew_Form("fmetaadd");

// Validate form
fmetaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->idsucursal->FldCaption(), $meta->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->idperiodo_contable->FldCaption(), $meta->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->monto->FldCaption(), $meta->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($meta->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $meta->cantidad->FldCaption(), $meta->cantidad->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cantidad");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($meta->cantidad->FldErrMsg()) ?>");

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
fmetaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmetaadd.ValidateRequired = true;
<?php } else { ?>
fmetaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmetaadd.Lists["x_idsucursal"] = {"LinkField":"x_idsucursal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fmetaadd.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $meta_add->ShowPageHeader(); ?>
<?php
$meta_add->ShowMessage();
?>
<form name="fmetaadd" id="fmetaadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($meta_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $meta_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="meta">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($meta->idsucursal->Visible) { // idsucursal ?>
	<div id="r_idsucursal" class="form-group">
		<label id="elh_meta_idsucursal" for="x_idsucursal" class="col-sm-2 control-label ewLabel"><?php echo $meta->idsucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $meta->idsucursal->CellAttributes() ?>>
<span id="el_meta_idsucursal">
<select data-field="x_idsucursal" id="x_idsucursal" name="x_idsucursal"<?php echo $meta->idsucursal->EditAttributes() ?>>
<?php
if (is_array($meta->idsucursal->EditValue)) {
	$arwrk = $meta->idsucursal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idsucursal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idsucursal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sucursal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$meta->Lookup_Selecting($meta->idsucursal, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idsucursal" id="s_x_idsucursal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsucursal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $meta->idsucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($meta->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<div id="r_idperiodo_contable" class="form-group">
		<label id="elh_meta_idperiodo_contable" for="x_idperiodo_contable" class="col-sm-2 control-label ewLabel"><?php echo $meta->idperiodo_contable->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $meta->idperiodo_contable->CellAttributes() ?>>
<?php if ($meta->idperiodo_contable->getSessionValue() <> "") { ?>
<span id="el_meta_idperiodo_contable">
<span<?php echo $meta->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $meta->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idperiodo_contable" name="x_idperiodo_contable" value="<?php echo ew_HtmlEncode($meta->idperiodo_contable->CurrentValue) ?>">
<?php } else { ?>
<span id="el_meta_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x_idperiodo_contable" name="x_idperiodo_contable"<?php echo $meta->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($meta->idperiodo_contable->EditValue)) {
	$arwrk = $meta->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($meta->idperiodo_contable->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$meta->idperiodo_contable) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `mes` AS `DispFld`, `anio` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";

// Call Lookup selecting
$meta->Lookup_Selecting($meta->idperiodo_contable, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `mes`";
?>
<input type="hidden" name="s_x_idperiodo_contable" id="s_x_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $meta->idperiodo_contable->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($meta->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_meta_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $meta->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $meta->monto->CellAttributes() ?>>
<span id="el_meta_monto">
<input type="text" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($meta->monto->PlaceHolder) ?>" value="<?php echo $meta->monto->EditValue ?>"<?php echo $meta->monto->EditAttributes() ?>>
</span>
<?php echo $meta->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($meta->cantidad->Visible) { // cantidad ?>
	<div id="r_cantidad" class="form-group">
		<label id="elh_meta_cantidad" for="x_cantidad" class="col-sm-2 control-label ewLabel"><?php echo $meta->cantidad->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $meta->cantidad->CellAttributes() ?>>
<span id="el_meta_cantidad">
<input type="text" data-field="x_cantidad" name="x_cantidad" id="x_cantidad" size="30" placeholder="<?php echo ew_HtmlEncode($meta->cantidad->PlaceHolder) ?>" value="<?php echo $meta->cantidad->EditValue ?>"<?php echo $meta->cantidad->EditAttributes() ?>>
</span>
<?php echo $meta->cantidad->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fmetaadd.Init();
</script>
<?php
$meta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$meta_add->Page_Terminate();
?>
