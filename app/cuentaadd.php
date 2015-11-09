<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "bancoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$cuenta_add = NULL; // Initialize page object first

class ccuenta_add extends ccuenta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'cuenta';

	// Page object name
	var $PageObjName = 'cuenta_add';

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
		$hidden = FALSE;
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

		// Table object (cuenta)
		if (!isset($GLOBALS["cuenta"]) || get_class($GLOBALS["cuenta"]) == "ccuenta") {
			$GLOBALS["cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta"];
		}

		// Table object (banco)
		if (!isset($GLOBALS['banco'])) $GLOBALS['banco'] = new cbanco();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

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
		global $EW_EXPORT, $cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta);
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
			if (@$_GET["idcuenta"] != "") {
				$this->idcuenta->setQueryStringValue($_GET["idcuenta"]);
				$this->setKey("idcuenta", $this->idcuenta->CurrentValue); // Set up key
			} else {
				$this->setKey("idcuenta", ""); // Clear key
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
					$this->Page_Terminate("cuentalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cuentaview.php")
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
		$this->idcuenta->CurrentValue = NULL;
		$this->idcuenta->OldValue = $this->idcuenta->CurrentValue;
		$this->idbanco->CurrentValue = 1;
		$this->idsucursal->CurrentValue = 1;
		$this->idmoneda->CurrentValue = NULL;
		$this->idmoneda->OldValue = $this->idmoneda->CurrentValue;
		$this->numero->CurrentValue = NULL;
		$this->numero->OldValue = $this->numero->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->saldo->CurrentValue = 0.00;
		$this->debito->CurrentValue = 0.00;
		$this->credito->CurrentValue = 0.00;
		$this->estado->CurrentValue = "Activo";
		$this->fecha_insercio->CurrentValue = NULL;
		$this->fecha_insercio->OldValue = $this->fecha_insercio->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idcuenta->FldIsDetailKey) {
			$this->idcuenta->setFormValue($objForm->GetValue("x_idcuenta"));
		}
		if (!$this->idbanco->FldIsDetailKey) {
			$this->idbanco->setFormValue($objForm->GetValue("x_idbanco"));
		}
		if (!$this->idsucursal->FldIsDetailKey) {
			$this->idsucursal->setFormValue($objForm->GetValue("x_idsucursal"));
		}
		if (!$this->idmoneda->FldIsDetailKey) {
			$this->idmoneda->setFormValue($objForm->GetValue("x_idmoneda"));
		}
		if (!$this->numero->FldIsDetailKey) {
			$this->numero->setFormValue($objForm->GetValue("x_numero"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->saldo->FldIsDetailKey) {
			$this->saldo->setFormValue($objForm->GetValue("x_saldo"));
		}
		if (!$this->debito->FldIsDetailKey) {
			$this->debito->setFormValue($objForm->GetValue("x_debito"));
		}
		if (!$this->credito->FldIsDetailKey) {
			$this->credito->setFormValue($objForm->GetValue("x_credito"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->fecha_insercio->FldIsDetailKey) {
			$this->fecha_insercio->setFormValue($objForm->GetValue("x_fecha_insercio"));
			$this->fecha_insercio->CurrentValue = ew_UnFormatDateTime($this->fecha_insercio->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idcuenta->CurrentValue = $this->idcuenta->FormValue;
		$this->idbanco->CurrentValue = $this->idbanco->FormValue;
		$this->idsucursal->CurrentValue = $this->idsucursal->FormValue;
		$this->idmoneda->CurrentValue = $this->idmoneda->FormValue;
		$this->numero->CurrentValue = $this->numero->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->saldo->CurrentValue = $this->saldo->FormValue;
		$this->debito->CurrentValue = $this->debito->FormValue;
		$this->credito->CurrentValue = $this->credito->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->fecha_insercio->CurrentValue = $this->fecha_insercio->FormValue;
		$this->fecha_insercio->CurrentValue = ew_UnFormatDateTime($this->fecha_insercio->CurrentValue, 7);
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
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->idbanco->setDbValue($rs->fields('idbanco'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->idmoneda->setDbValue($rs->fields('idmoneda'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercio->setDbValue($rs->fields('fecha_insercio'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->idbanco->DbValue = $row['idbanco'];
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->idmoneda->DbValue = $row['idmoneda'];
		$this->numero->DbValue = $row['numero'];
		$this->nombre->DbValue = $row['nombre'];
		$this->saldo->DbValue = $row['saldo'];
		$this->debito->DbValue = $row['debito'];
		$this->credito->DbValue = $row['credito'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercio->DbValue = $row['fecha_insercio'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcuenta")) <> "")
			$this->idcuenta->CurrentValue = $this->getKey("idcuenta"); // idcuenta
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

		if ($this->saldo->FormValue == $this->saldo->CurrentValue && is_numeric(ew_StrToFloat($this->saldo->CurrentValue)))
			$this->saldo->CurrentValue = ew_StrToFloat($this->saldo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->debito->FormValue == $this->debito->CurrentValue && is_numeric(ew_StrToFloat($this->debito->CurrentValue)))
			$this->debito->CurrentValue = ew_StrToFloat($this->debito->CurrentValue);

		// Convert decimal values if posted back
		if ($this->credito->FormValue == $this->credito->CurrentValue && is_numeric(ew_StrToFloat($this->credito->CurrentValue)))
			$this->credito->CurrentValue = ew_StrToFloat($this->credito->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta
		// idbanco
		// idsucursal
		// idmoneda
		// numero
		// nombre
		// saldo
		// debito
		// credito
		// estado
		// fecha_insercio

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcuenta
			$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
			$this->idcuenta->ViewCustomAttributes = "";

			// idbanco
			$this->idbanco->ViewValue = $this->idbanco->CurrentValue;
			$this->idbanco->ViewCustomAttributes = "";

			// idsucursal
			$this->idsucursal->ViewValue = $this->idsucursal->CurrentValue;
			$this->idsucursal->ViewCustomAttributes = "";

			// idmoneda
			$this->idmoneda->ViewValue = $this->idmoneda->CurrentValue;
			$this->idmoneda->ViewCustomAttributes = "";

			// numero
			$this->numero->ViewValue = $this->numero->CurrentValue;
			$this->numero->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// saldo
			$this->saldo->ViewValue = $this->saldo->CurrentValue;
			$this->saldo->ViewCustomAttributes = "";

			// debito
			$this->debito->ViewValue = $this->debito->CurrentValue;
			$this->debito->ViewCustomAttributes = "";

			// credito
			$this->credito->ViewValue = $this->credito->CurrentValue;
			$this->credito->ViewCustomAttributes = "";

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

			// fecha_insercio
			$this->fecha_insercio->ViewValue = $this->fecha_insercio->CurrentValue;
			$this->fecha_insercio->ViewValue = ew_FormatDateTime($this->fecha_insercio->ViewValue, 7);
			$this->fecha_insercio->ViewCustomAttributes = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
			$this->idcuenta->TooltipValue = "";

			// idbanco
			$this->idbanco->LinkCustomAttributes = "";
			$this->idbanco->HrefValue = "";
			$this->idbanco->TooltipValue = "";

			// idsucursal
			$this->idsucursal->LinkCustomAttributes = "";
			$this->idsucursal->HrefValue = "";
			$this->idsucursal->TooltipValue = "";

			// idmoneda
			$this->idmoneda->LinkCustomAttributes = "";
			$this->idmoneda->HrefValue = "";
			$this->idmoneda->TooltipValue = "";

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";
			$this->numero->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// saldo
			$this->saldo->LinkCustomAttributes = "";
			$this->saldo->HrefValue = "";
			$this->saldo->TooltipValue = "";

			// debito
			$this->debito->LinkCustomAttributes = "";
			$this->debito->HrefValue = "";
			$this->debito->TooltipValue = "";

			// credito
			$this->credito->LinkCustomAttributes = "";
			$this->credito->HrefValue = "";
			$this->credito->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercio
			$this->fecha_insercio->LinkCustomAttributes = "";
			$this->fecha_insercio->HrefValue = "";
			$this->fecha_insercio->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idcuenta
			$this->idcuenta->EditAttrs["class"] = "form-control";
			$this->idcuenta->EditCustomAttributes = "";
			$this->idcuenta->EditValue = ew_HtmlEncode($this->idcuenta->CurrentValue);
			$this->idcuenta->PlaceHolder = ew_RemoveHtml($this->idcuenta->FldCaption());

			// idbanco
			$this->idbanco->EditAttrs["class"] = "form-control";
			$this->idbanco->EditCustomAttributes = "";
			if ($this->idbanco->getSessionValue() <> "") {
				$this->idbanco->CurrentValue = $this->idbanco->getSessionValue();
			$this->idbanco->ViewValue = $this->idbanco->CurrentValue;
			$this->idbanco->ViewCustomAttributes = "";
			} else {
			$this->idbanco->EditValue = ew_HtmlEncode($this->idbanco->CurrentValue);
			$this->idbanco->PlaceHolder = ew_RemoveHtml($this->idbanco->FldCaption());
			}

			// idsucursal
			$this->idsucursal->EditAttrs["class"] = "form-control";
			$this->idsucursal->EditCustomAttributes = "";
			$this->idsucursal->EditValue = ew_HtmlEncode($this->idsucursal->CurrentValue);
			$this->idsucursal->PlaceHolder = ew_RemoveHtml($this->idsucursal->FldCaption());

			// idmoneda
			$this->idmoneda->EditAttrs["class"] = "form-control";
			$this->idmoneda->EditCustomAttributes = "";
			$this->idmoneda->EditValue = ew_HtmlEncode($this->idmoneda->CurrentValue);
			$this->idmoneda->PlaceHolder = ew_RemoveHtml($this->idmoneda->FldCaption());

			// numero
			$this->numero->EditAttrs["class"] = "form-control";
			$this->numero->EditCustomAttributes = "";
			$this->numero->EditValue = ew_HtmlEncode($this->numero->CurrentValue);
			$this->numero->PlaceHolder = ew_RemoveHtml($this->numero->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// saldo
			$this->saldo->EditAttrs["class"] = "form-control";
			$this->saldo->EditCustomAttributes = "";
			$this->saldo->EditValue = ew_HtmlEncode($this->saldo->CurrentValue);
			$this->saldo->PlaceHolder = ew_RemoveHtml($this->saldo->FldCaption());
			if (strval($this->saldo->EditValue) <> "" && is_numeric($this->saldo->EditValue)) $this->saldo->EditValue = ew_FormatNumber($this->saldo->EditValue, -2, -1, -2, 0);

			// debito
			$this->debito->EditAttrs["class"] = "form-control";
			$this->debito->EditCustomAttributes = "";
			$this->debito->EditValue = ew_HtmlEncode($this->debito->CurrentValue);
			$this->debito->PlaceHolder = ew_RemoveHtml($this->debito->FldCaption());
			if (strval($this->debito->EditValue) <> "" && is_numeric($this->debito->EditValue)) $this->debito->EditValue = ew_FormatNumber($this->debito->EditValue, -2, -1, -2, 0);

			// credito
			$this->credito->EditAttrs["class"] = "form-control";
			$this->credito->EditCustomAttributes = "";
			$this->credito->EditValue = ew_HtmlEncode($this->credito->CurrentValue);
			$this->credito->PlaceHolder = ew_RemoveHtml($this->credito->FldCaption());
			if (strval($this->credito->EditValue) <> "" && is_numeric($this->credito->EditValue)) $this->credito->EditValue = ew_FormatNumber($this->credito->EditValue, -2, -1, -2, 0);

			// estado
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			$this->estado->EditValue = $arwrk;

			// fecha_insercio
			$this->fecha_insercio->EditAttrs["class"] = "form-control";
			$this->fecha_insercio->EditCustomAttributes = "";
			$this->fecha_insercio->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_insercio->CurrentValue, 7));
			$this->fecha_insercio->PlaceHolder = ew_RemoveHtml($this->fecha_insercio->FldCaption());

			// Edit refer script
			// idcuenta

			$this->idcuenta->HrefValue = "";

			// idbanco
			$this->idbanco->HrefValue = "";

			// idsucursal
			$this->idsucursal->HrefValue = "";

			// idmoneda
			$this->idmoneda->HrefValue = "";

			// numero
			$this->numero->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// saldo
			$this->saldo->HrefValue = "";

			// debito
			$this->debito->HrefValue = "";

			// credito
			$this->credito->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// fecha_insercio
			$this->fecha_insercio->HrefValue = "";
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
		if (!$this->idcuenta->FldIsDetailKey && !is_null($this->idcuenta->FormValue) && $this->idcuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta->FldCaption(), $this->idcuenta->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcuenta->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcuenta->FldErrMsg());
		}
		if (!$this->idbanco->FldIsDetailKey && !is_null($this->idbanco->FormValue) && $this->idbanco->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idbanco->FldCaption(), $this->idbanco->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idbanco->FormValue)) {
			ew_AddMessage($gsFormError, $this->idbanco->FldErrMsg());
		}
		if (!$this->idsucursal->FldIsDetailKey && !is_null($this->idsucursal->FormValue) && $this->idsucursal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsucursal->FldCaption(), $this->idsucursal->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idsucursal->FormValue)) {
			ew_AddMessage($gsFormError, $this->idsucursal->FldErrMsg());
		}
		if (!$this->idmoneda->FldIsDetailKey && !is_null($this->idmoneda->FormValue) && $this->idmoneda->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idmoneda->FldCaption(), $this->idmoneda->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idmoneda->FormValue)) {
			ew_AddMessage($gsFormError, $this->idmoneda->FldErrMsg());
		}
		if (!$this->saldo->FldIsDetailKey && !is_null($this->saldo->FormValue) && $this->saldo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->saldo->FldCaption(), $this->saldo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->saldo->FormValue)) {
			ew_AddMessage($gsFormError, $this->saldo->FldErrMsg());
		}
		if (!$this->debito->FldIsDetailKey && !is_null($this->debito->FormValue) && $this->debito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->debito->FldCaption(), $this->debito->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->debito->FormValue)) {
			ew_AddMessage($gsFormError, $this->debito->FldErrMsg());
		}
		if (!$this->credito->FldIsDetailKey && !is_null($this->credito->FormValue) && $this->credito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->credito->FldCaption(), $this->credito->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->credito->FormValue)) {
			ew_AddMessage($gsFormError, $this->credito->FldErrMsg());
		}
		if ($this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha_insercio->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_insercio->FldErrMsg());
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

		// idcuenta
		$this->idcuenta->SetDbValueDef($rsnew, $this->idcuenta->CurrentValue, 0, FALSE);

		// idbanco
		$this->idbanco->SetDbValueDef($rsnew, $this->idbanco->CurrentValue, 0, strval($this->idbanco->CurrentValue) == "");

		// idsucursal
		$this->idsucursal->SetDbValueDef($rsnew, $this->idsucursal->CurrentValue, 0, strval($this->idsucursal->CurrentValue) == "");

		// idmoneda
		$this->idmoneda->SetDbValueDef($rsnew, $this->idmoneda->CurrentValue, 0, FALSE);

		// numero
		$this->numero->SetDbValueDef($rsnew, $this->numero->CurrentValue, NULL, FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, FALSE);

		// saldo
		$this->saldo->SetDbValueDef($rsnew, $this->saldo->CurrentValue, 0, strval($this->saldo->CurrentValue) == "");

		// debito
		$this->debito->SetDbValueDef($rsnew, $this->debito->CurrentValue, 0, strval($this->debito->CurrentValue) == "");

		// credito
		$this->credito->SetDbValueDef($rsnew, $this->credito->CurrentValue, 0, strval($this->credito->CurrentValue) == "");

		// estado
		$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", strval($this->estado->CurrentValue) == "");

		// fecha_insercio
		$this->fecha_insercio->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_insercio->CurrentValue, 7), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['idcuenta']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
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
			if ($sMasterTblVar == "banco") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idbanco"] <> "") {
					$GLOBALS["banco"]->idbanco->setQueryStringValue($_GET["fk_idbanco"]);
					$this->idbanco->setQueryStringValue($GLOBALS["banco"]->idbanco->QueryStringValue);
					$this->idbanco->setSessionValue($this->idbanco->QueryStringValue);
					if (!is_numeric($GLOBALS["banco"]->idbanco->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "banco") {
				if ($this->idbanco->QueryStringValue == "") $this->idbanco->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "cuentalist.php", "", $this->TableVar, TRUE);
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
if (!isset($cuenta_add)) $cuenta_add = new ccuenta_add();

// Page init
$cuenta_add->Page_Init();

// Page main
$cuenta_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var cuenta_add = new ew_Page("cuenta_add");
cuenta_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cuenta_add.PageID; // For backward compatibility

// Form object
var fcuentaadd = new ew_Form("fcuentaadd");

// Validate form
fcuentaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idcuenta->FldCaption(), $cuenta->idcuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->idcuenta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idbanco->FldCaption(), $cuenta->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->idbanco->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idsucursal->FldCaption(), $cuenta->idsucursal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsucursal");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->idsucursal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idmoneda");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idmoneda->FldCaption(), $cuenta->idmoneda->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmoneda");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->idmoneda->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->saldo->FldCaption(), $cuenta->saldo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->saldo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->debito->FldCaption(), $cuenta->debito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->debito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->credito->FldCaption(), $cuenta->credito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_credito");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->credito->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->estado->FldCaption(), $cuenta->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercio");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->fecha_insercio->FldErrMsg()) ?>");

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
fcuentaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuentaadd.ValidateRequired = true;
<?php } else { ?>
fcuentaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $cuenta_add->ShowPageHeader(); ?>
<?php
$cuenta_add->ShowMessage();
?>
<form name="fcuentaadd" id="fcuentaadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($cuenta->idcuenta->Visible) { // idcuenta ?>
	<div id="r_idcuenta" class="form-group">
		<label id="elh_cuenta_idcuenta" for="x_idcuenta" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->idcuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->idcuenta->CellAttributes() ?>>
<span id="el_cuenta_idcuenta">
<input type="text" data-field="x_idcuenta" name="x_idcuenta" id="x_idcuenta" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->idcuenta->PlaceHolder) ?>" value="<?php echo $cuenta->idcuenta->EditValue ?>"<?php echo $cuenta->idcuenta->EditAttributes() ?>>
</span>
<?php echo $cuenta->idcuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->idbanco->Visible) { // idbanco ?>
	<div id="r_idbanco" class="form-group">
		<label id="elh_cuenta_idbanco" for="x_idbanco" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->idbanco->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->idbanco->CellAttributes() ?>>
<?php if ($cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el_cuenta_idbanco">
<span<?php echo $cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idbanco" name="x_idbanco" value="<?php echo ew_HtmlEncode($cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cuenta_idbanco">
<input type="text" data-field="x_idbanco" name="x_idbanco" id="x_idbanco" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->idbanco->PlaceHolder) ?>" value="<?php echo $cuenta->idbanco->EditValue ?>"<?php echo $cuenta->idbanco->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $cuenta->idbanco->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->idsucursal->Visible) { // idsucursal ?>
	<div id="r_idsucursal" class="form-group">
		<label id="elh_cuenta_idsucursal" for="x_idsucursal" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->idsucursal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->idsucursal->CellAttributes() ?>>
<span id="el_cuenta_idsucursal">
<input type="text" data-field="x_idsucursal" name="x_idsucursal" id="x_idsucursal" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->idsucursal->PlaceHolder) ?>" value="<?php echo $cuenta->idsucursal->EditValue ?>"<?php echo $cuenta->idsucursal->EditAttributes() ?>>
</span>
<?php echo $cuenta->idsucursal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->idmoneda->Visible) { // idmoneda ?>
	<div id="r_idmoneda" class="form-group">
		<label id="elh_cuenta_idmoneda" for="x_idmoneda" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->idmoneda->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->idmoneda->CellAttributes() ?>>
<span id="el_cuenta_idmoneda">
<input type="text" data-field="x_idmoneda" name="x_idmoneda" id="x_idmoneda" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->idmoneda->PlaceHolder) ?>" value="<?php echo $cuenta->idmoneda->EditValue ?>"<?php echo $cuenta->idmoneda->EditAttributes() ?>>
</span>
<?php echo $cuenta->idmoneda->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group">
		<label id="elh_cuenta_numero" for="x_numero" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->numero->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->numero->CellAttributes() ?>>
<span id="el_cuenta_numero">
<input type="text" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->numero->PlaceHolder) ?>" value="<?php echo $cuenta->numero->EditValue ?>"<?php echo $cuenta->numero->EditAttributes() ?>>
</span>
<?php echo $cuenta->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_cuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->nombre->CellAttributes() ?>>
<span id="el_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->PlaceHolder) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $cuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->saldo->Visible) { // saldo ?>
	<div id="r_saldo" class="form-group">
		<label id="elh_cuenta_saldo" for="x_saldo" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->saldo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->saldo->CellAttributes() ?>>
<span id="el_cuenta_saldo">
<input type="text" data-field="x_saldo" name="x_saldo" id="x_saldo" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->saldo->PlaceHolder) ?>" value="<?php echo $cuenta->saldo->EditValue ?>"<?php echo $cuenta->saldo->EditAttributes() ?>>
</span>
<?php echo $cuenta->saldo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->debito->Visible) { // debito ?>
	<div id="r_debito" class="form-group">
		<label id="elh_cuenta_debito" for="x_debito" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->debito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->debito->CellAttributes() ?>>
<span id="el_cuenta_debito">
<input type="text" data-field="x_debito" name="x_debito" id="x_debito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->debito->PlaceHolder) ?>" value="<?php echo $cuenta->debito->EditValue ?>"<?php echo $cuenta->debito->EditAttributes() ?>>
</span>
<?php echo $cuenta->debito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->credito->Visible) { // credito ?>
	<div id="r_credito" class="form-group">
		<label id="elh_cuenta_credito" for="x_credito" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->credito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->credito->CellAttributes() ?>>
<span id="el_cuenta_credito">
<input type="text" data-field="x_credito" name="x_credito" id="x_credito" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->credito->PlaceHolder) ?>" value="<?php echo $cuenta->credito->EditValue ?>"<?php echo $cuenta->credito->EditAttributes() ?>>
</span>
<?php echo $cuenta->credito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_cuenta_estado" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->estado->CellAttributes() ?>>
<span id="el_cuenta_estado">
<div id="tp_x_estado" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_estado" id="x_estado" value="{value}"<?php echo $cuenta->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cuenta->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cuenta->estado->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $cuenta->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->fecha_insercio->Visible) { // fecha_insercio ?>
	<div id="r_fecha_insercio" class="form-group">
		<label id="elh_cuenta_fecha_insercio" for="x_fecha_insercio" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->fecha_insercio->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->fecha_insercio->CellAttributes() ?>>
<span id="el_cuenta_fecha_insercio">
<input type="text" data-field="x_fecha_insercio" name="x_fecha_insercio" id="x_fecha_insercio" placeholder="<?php echo ew_HtmlEncode($cuenta->fecha_insercio->PlaceHolder) ?>" value="<?php echo $cuenta->fecha_insercio->EditValue ?>"<?php echo $cuenta->fecha_insercio->EditAttributes() ?>>
</span>
<?php echo $cuenta->fecha_insercio->CustomMsg ?></div></div>
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
fcuentaadd.Init();
</script>
<?php
$cuenta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$cuenta_add->Page_Terminate();
?>
