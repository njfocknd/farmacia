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

$fecha_contable_search = NULL; // Initialize page object first

class cfecha_contable_search extends cfecha_contable {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'fecha_contable';

	// Page object name
	var $PageObjName = 'fecha_contable_search';

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

		// Table object (fecha_contable)
		if (!isset($GLOBALS["fecha_contable"]) || get_class($GLOBALS["fecha_contable"]) == "cfecha_contable") {
			$GLOBALS["fecha_contable"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["fecha_contable"];
		}

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'fecha_contable', TRUE);

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("fecha_contablelist.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "fecha_contablelist.php" . "?" . $sSrchStr;
						if ($this->IsModal) {
							$row = array();
							$row["url"] = $sSrchStr;
							echo ew_ArrayToJson(array($row));
							$this->Page_Terminate();
							exit();
						} else {
							$this->Page_Terminate($sSrchStr); // Go to list page
						}
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->idfecha_contable); // idfecha_contable
		$this->BuildSearchUrl($sSrchUrl, $this->idperiodo_contable); // idperiodo_contable
		$this->BuildSearchUrl($sSrchUrl, $this->fecha); // fecha
		$this->BuildSearchUrl($sSrchUrl, $this->estado_documento_debito); // estado_documento_debito
		$this->BuildSearchUrl($sSrchUrl, $this->estado_documento_credito); // estado_documento_credito
		$this->BuildSearchUrl($sSrchUrl, $this->estado_pago_cliente); // estado_pago_cliente
		$this->BuildSearchUrl($sSrchUrl, $this->estado_pago_proveedor); // estado_pago_proveedor
		$this->BuildSearchUrl($sSrchUrl, $this->idempresa); // idempresa
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// idfecha_contable

		$this->idfecha_contable->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idfecha_contable"));
		$this->idfecha_contable->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idfecha_contable");

		// idperiodo_contable
		$this->idperiodo_contable->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idperiodo_contable"));
		$this->idperiodo_contable->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idperiodo_contable");

		// fecha
		$this->fecha->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fecha"));
		$this->fecha->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fecha");

		// estado_documento_debito
		$this->estado_documento_debito->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado_documento_debito"));
		$this->estado_documento_debito->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado_documento_debito");

		// estado_documento_credito
		$this->estado_documento_credito->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado_documento_credito"));
		$this->estado_documento_credito->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado_documento_credito");

		// estado_pago_cliente
		$this->estado_pago_cliente->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado_pago_cliente"));
		$this->estado_pago_cliente->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado_pago_cliente");

		// estado_pago_proveedor
		$this->estado_pago_proveedor->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado_pago_proveedor"));
		$this->estado_pago_proveedor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado_pago_proveedor");

		// idempresa
		$this->idempresa->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idempresa"));
		$this->idempresa->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idempresa");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idfecha_contable
			$this->idfecha_contable->EditAttrs["class"] = "form-control";
			$this->idfecha_contable->EditCustomAttributes = "";
			$this->idfecha_contable->EditValue = ew_HtmlEncode($this->idfecha_contable->AdvancedSearch->SearchValue);
			$this->idfecha_contable->PlaceHolder = ew_RemoveHtml($this->idfecha_contable->FldCaption());

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			if (trim(strval($this->idperiodo_contable->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fecha->AdvancedSearch->SearchValue, 7), 7));
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
			if (trim(strval($this->idempresa->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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
		if (!ew_CheckInteger($this->idfecha_contable->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idfecha_contable->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fecha->FldErrMsg());
		}

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "fecha_contablelist.php", "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, ew_CurrentUrl());
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
if (!isset($fecha_contable_search)) $fecha_contable_search = new cfecha_contable_search();

// Page init
$fecha_contable_search->Page_Init();

// Page main
$fecha_contable_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$fecha_contable_search->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var fecha_contable_search = new ew_Page("fecha_contable_search");
fecha_contable_search.PageID = "search"; // Page ID
var EW_PAGE_ID = fecha_contable_search.PageID; // For backward compatibility

// Form object
var ffecha_contablesearch = new ew_Form("ffecha_contablesearch");

// Form_CustomValidate event
ffecha_contablesearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffecha_contablesearch.ValidateRequired = true;
<?php } else { ?>
ffecha_contablesearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffecha_contablesearch.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_mes","x_anio","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ffecha_contablesearch.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
// Validate function for search

ffecha_contablesearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = this.GetElements("x" + infix + "_idfecha_contable");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($fecha_contable->idfecha_contable->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fecha");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($fecha_contable->fecha->FldErrMsg()) ?>");

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$fecha_contable_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $fecha_contable_search->ShowPageHeader(); ?>
<?php
$fecha_contable_search->ShowMessage();
?>
<form name="ffecha_contablesearch" id="ffecha_contablesearch" class="form-horizontal ewForm ewSearchForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($fecha_contable_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $fecha_contable_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="fecha_contable">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($fecha_contable_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($fecha_contable->idfecha_contable->Visible) { // idfecha_contable ?>
	<div id="r_idfecha_contable" class="form-group">
		<label for="x_idfecha_contable" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_idfecha_contable"><?php echo $fecha_contable->idfecha_contable->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idfecha_contable" id="z_idfecha_contable" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->idfecha_contable->CellAttributes() ?>>
			<span id="el_fecha_contable_idfecha_contable">
<input type="text" data-field="x_idfecha_contable" name="x_idfecha_contable" id="x_idfecha_contable" placeholder="<?php echo ew_HtmlEncode($fecha_contable->idfecha_contable->PlaceHolder) ?>" value="<?php echo $fecha_contable->idfecha_contable->EditValue ?>"<?php echo $fecha_contable->idfecha_contable->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<div id="r_idperiodo_contable" class="form-group">
		<label for="x_idperiodo_contable" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_idperiodo_contable"><?php echo $fecha_contable->idperiodo_contable->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idperiodo_contable" id="z_idperiodo_contable" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->idperiodo_contable->CellAttributes() ?>>
			<span id="el_fecha_contable_idperiodo_contable">
<select data-field="x_idperiodo_contable" id="x_idperiodo_contable" name="x_idperiodo_contable"<?php echo $fecha_contable->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idperiodo_contable->EditValue)) {
	$arwrk = $fecha_contable->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idperiodo_contable->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<input type="hidden" name="s_x_idperiodo_contable" id="s_x_idperiodo_contable" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idperiodo_contable` = {filter_value}"); ?>&amp;t0=3">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label for="x_fecha" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_fecha"><?php echo $fecha_contable->fecha->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fecha" id="z_fecha" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->fecha->CellAttributes() ?>>
			<span id="el_fecha_contable_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($fecha_contable->fecha->PlaceHolder) ?>" value="<?php echo $fecha_contable->fecha->EditValue ?>"<?php echo $fecha_contable->fecha->EditAttributes() ?>>
<?php if (!$fecha_contable->fecha->ReadOnly && !$fecha_contable->fecha->Disabled && @$fecha_contable->fecha->EditAttrs["readonly"] == "" && @$fecha_contable->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("ffecha_contablesearch", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_documento_debito->Visible) { // estado_documento_debito ?>
	<div id="r_estado_documento_debito" class="form-group">
		<label for="x_estado_documento_debito" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_estado_documento_debito"><?php echo $fecha_contable->estado_documento_debito->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado_documento_debito" id="z_estado_documento_debito" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->estado_documento_debito->CellAttributes() ?>>
			<span id="el_fecha_contable_estado_documento_debito">
<select data-field="x_estado_documento_debito" id="x_estado_documento_debito" name="x_estado_documento_debito"<?php echo $fecha_contable->estado_documento_debito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_debito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_debito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_debito->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_documento_credito->Visible) { // estado_documento_credito ?>
	<div id="r_estado_documento_credito" class="form-group">
		<label for="x_estado_documento_credito" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_estado_documento_credito"><?php echo $fecha_contable->estado_documento_credito->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado_documento_credito" id="z_estado_documento_credito" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->estado_documento_credito->CellAttributes() ?>>
			<span id="el_fecha_contable_estado_documento_credito">
<select data-field="x_estado_documento_credito" id="x_estado_documento_credito" name="x_estado_documento_credito"<?php echo $fecha_contable->estado_documento_credito->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_documento_credito->EditValue)) {
	$arwrk = $fecha_contable->estado_documento_credito->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_documento_credito->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_pago_cliente->Visible) { // estado_pago_cliente ?>
	<div id="r_estado_pago_cliente" class="form-group">
		<label for="x_estado_pago_cliente" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_estado_pago_cliente"><?php echo $fecha_contable->estado_pago_cliente->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado_pago_cliente" id="z_estado_pago_cliente" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->estado_pago_cliente->CellAttributes() ?>>
			<span id="el_fecha_contable_estado_pago_cliente">
<select data-field="x_estado_pago_cliente" id="x_estado_pago_cliente" name="x_estado_pago_cliente"<?php echo $fecha_contable->estado_pago_cliente->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_cliente->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_cliente->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_cliente->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->estado_pago_proveedor->Visible) { // estado_pago_proveedor ?>
	<div id="r_estado_pago_proveedor" class="form-group">
		<label for="x_estado_pago_proveedor" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_estado_pago_proveedor"><?php echo $fecha_contable->estado_pago_proveedor->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado_pago_proveedor" id="z_estado_pago_proveedor" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->estado_pago_proveedor->CellAttributes() ?>>
			<span id="el_fecha_contable_estado_pago_proveedor">
<select data-field="x_estado_pago_proveedor" id="x_estado_pago_proveedor" name="x_estado_pago_proveedor"<?php echo $fecha_contable->estado_pago_proveedor->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->estado_pago_proveedor->EditValue)) {
	$arwrk = $fecha_contable->estado_pago_proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->estado_pago_proveedor->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($fecha_contable->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label for="x_idempresa" class="<?php echo $fecha_contable_search->SearchLabelClass ?>"><span id="elh_fecha_contable_idempresa"><?php echo $fecha_contable->idempresa->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idempresa" id="z_idempresa" value="="></p>
		</label>
		<div class="<?php echo $fecha_contable_search->SearchRightColumnClass ?>"><div<?php echo $fecha_contable->idempresa->CellAttributes() ?>>
			<span id="el_fecha_contable_idempresa">
<select data-field="x_idempresa" id="x_idempresa" name="x_idempresa"<?php echo $fecha_contable->idempresa->EditAttributes() ?>>
<?php
if (is_array($fecha_contable->idempresa->EditValue)) {
	$arwrk = $fecha_contable->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($fecha_contable->idempresa->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$fecha_contable_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ffecha_contablesearch.Init();
</script>
<?php
$fecha_contable_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$fecha_contable_search->Page_Terminate();
?>
