<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$usuario_search = NULL; // Initialize page object first

class cusuario_search extends cusuario {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'usuario';

	// Page object name
	var $PageObjName = 'usuario_search';

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

		// Table object (usuario)
		if (!isset($GLOBALS["usuario"]) || get_class($GLOBALS["usuario"]) == "cusuario") {
			$GLOBALS["usuario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuario"];
		}

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'usuario', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("usuariolist.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("usuariolist.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idusuario->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $usuario;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($usuario);
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
						$sSrchStr = "usuariolist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->idusuario); // idusuario
		$this->BuildSearchUrl($sSrchUrl, $this->userlevelid); // userlevelid
		$this->BuildSearchUrl($sSrchUrl, $this->usuario); // usuario
		$this->BuildSearchUrl($sSrchUrl, $this->contrasena); // contrasena
		$this->BuildSearchUrl($sSrchUrl, $this->estado); // estado
		$this->BuildSearchUrl($sSrchUrl, $this->fecha_insercion); // fecha_insercion
		$this->BuildSearchUrl($sSrchUrl, $this->session); // session
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
		// idusuario

		$this->idusuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idusuario"));
		$this->idusuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idusuario");

		// userlevelid
		$this->userlevelid->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_userlevelid"));
		$this->userlevelid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_userlevelid");

		// usuario
		$this->usuario->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_usuario"));
		$this->usuario->AdvancedSearch->SearchOperator = $objForm->GetValue("z_usuario");

		// contrasena
		$this->contrasena->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_contrasena"));
		$this->contrasena->AdvancedSearch->SearchOperator = $objForm->GetValue("z_contrasena");

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado"));
		$this->estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado");

		// fecha_insercion
		$this->fecha_insercion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fecha_insercion"));
		$this->fecha_insercion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fecha_insercion");

		// session
		$this->session->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_session"));
		$this->session->AdvancedSearch->SearchOperator = $objForm->GetValue("z_session");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idusuario
		// userlevelid
		// usuario
		// contrasena
		// estado
		// fecha_insercion
		// session

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idusuario
			$this->idusuario->ViewValue = $this->idusuario->CurrentValue;
			$this->idusuario->ViewCustomAttributes = "";

			// userlevelid
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->userlevelid->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->userlevelid->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->userlevelid, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->userlevelid->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->userlevelid->ViewValue = $this->userlevelid->CurrentValue;
				}
			} else {
				$this->userlevelid->ViewValue = NULL;
			}
			} else {
				$this->userlevelid->ViewValue = "********";
			}
			$this->userlevelid->ViewCustomAttributes = "";

			// usuario
			$this->usuario->ViewValue = $this->usuario->CurrentValue;
			$this->usuario->ViewCustomAttributes = "";

			// contrasena
			$this->contrasena->ViewValue = "********";
			$this->contrasena->ViewCustomAttributes = "";

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

			// session
			$this->session->ViewValue = $this->session->CurrentValue;
			$this->session->ViewCustomAttributes = "";

			// idusuario
			$this->idusuario->LinkCustomAttributes = "";
			$this->idusuario->HrefValue = "";
			$this->idusuario->TooltipValue = "";

			// userlevelid
			$this->userlevelid->LinkCustomAttributes = "";
			$this->userlevelid->HrefValue = "";
			$this->userlevelid->TooltipValue = "";

			// usuario
			$this->usuario->LinkCustomAttributes = "";
			$this->usuario->HrefValue = "";
			$this->usuario->TooltipValue = "";

			// contrasena
			$this->contrasena->LinkCustomAttributes = "";
			$this->contrasena->HrefValue = "";
			$this->contrasena->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// session
			$this->session->LinkCustomAttributes = "";
			$this->session->HrefValue = "";
			$this->session->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idusuario
			$this->idusuario->EditAttrs["class"] = "form-control";
			$this->idusuario->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("search")) { // Non system admin
			$sFilterWrk = "";
			$sFilterWrk = $GLOBALS["usuario"]->AddUserIDFilter("");
			$sSqlWrk = "SELECT `idusuario`, `idusuario` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `usuario`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idusuario, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idusuario->EditValue = $arwrk;
			} else {
			$this->idusuario->EditValue = ew_HtmlEncode($this->idusuario->AdvancedSearch->SearchValue);
			$this->idusuario->PlaceHolder = ew_RemoveHtml($this->idusuario->FldCaption());
			}

			// userlevelid
			$this->userlevelid->EditAttrs["class"] = "form-control";
			$this->userlevelid->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->userlevelid, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->userlevelid->EditValue = $arwrk;
			} elseif (!$Security->CanAdmin()) { // System admin
				$this->userlevelid->EditValue = "********";
			} else {
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->userlevelid, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->userlevelid->EditValue = $arwrk;
			}

			// usuario
			$this->usuario->EditAttrs["class"] = "form-control";
			$this->usuario->EditCustomAttributes = "";
			$this->usuario->EditValue = ew_HtmlEncode($this->usuario->AdvancedSearch->SearchValue);
			$this->usuario->PlaceHolder = ew_RemoveHtml($this->usuario->FldCaption());

			// contrasena
			$this->contrasena->EditAttrs["class"] = "form-control";
			$this->contrasena->EditCustomAttributes = "";
			$this->contrasena->EditValue = ew_HtmlEncode($this->contrasena->AdvancedSearch->SearchValue);
			$this->contrasena->PlaceHolder = ew_RemoveHtml($this->contrasena->FldCaption());

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// fecha_insercion
			$this->fecha_insercion->EditAttrs["class"] = "form-control";
			$this->fecha_insercion->EditCustomAttributes = "";
			$this->fecha_insercion->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fecha_insercion->AdvancedSearch->SearchValue, 7), 7));
			$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

			// session
			$this->session->EditAttrs["class"] = "form-control";
			$this->session->EditCustomAttributes = "";
			$this->session->EditValue = ew_HtmlEncode($this->session->AdvancedSearch->SearchValue);
			$this->session->PlaceHolder = ew_RemoveHtml($this->session->FldCaption());
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
		if (!ew_CheckInteger($this->idusuario->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idusuario->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha_insercion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fecha_insercion->FldErrMsg());
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
		$this->idusuario->AdvancedSearch->Load();
		$this->userlevelid->AdvancedSearch->Load();
		$this->usuario->AdvancedSearch->Load();
		$this->contrasena->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->fecha_insercion->AdvancedSearch->Load();
		$this->session->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "usuariolist.php", "", $this->TableVar, TRUE);
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
if (!isset($usuario_search)) $usuario_search = new cusuario_search();

// Page init
$usuario_search->Page_Init();

// Page main
$usuario_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuario_search->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var usuario_search = new ew_Page("usuario_search");
usuario_search.PageID = "search"; // Page ID
var EW_PAGE_ID = usuario_search.PageID; // For backward compatibility

// Form object
var fusuariosearch = new ew_Form("fusuariosearch");

// Form_CustomValidate event
fusuariosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusuariosearch.ValidateRequired = true;
<?php } else { ?>
fusuariosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fusuariosearch.Lists["x_userlevelid"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
// Validate function for search

fusuariosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = this.GetElements("x" + infix + "_idusuario");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($usuario->idusuario->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fecha_insercion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($usuario->fecha_insercion->FldErrMsg()) ?>");

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
<?php if (!$usuario_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $usuario_search->ShowPageHeader(); ?>
<?php
$usuario_search->ShowMessage();
?>
<form name="fusuariosearch" id="fusuariosearch" class="form-horizontal ewForm ewSearchForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($usuario_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $usuario_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuario">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($usuario_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($usuario->idusuario->Visible) { // idusuario ?>
	<div id="r_idusuario" class="form-group">
		<label for="x_idusuario" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_idusuario"><?php echo $usuario->idusuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idusuario" id="z_idusuario" value="="></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->idusuario->CellAttributes() ?>>
			<span id="el_usuario_idusuario">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$usuario->UserIDAllow("search")) { // Non system admin ?>
<select data-field="x_idusuario" id="x_idusuario" name="x_idusuario"<?php echo $usuario->idusuario->EditAttributes() ?>>
<?php
if (is_array($usuario->idusuario->EditValue)) {
	$arwrk = $usuario->idusuario->EditValue;
	if ($arwrk[0][0] <> "") echo "<option value=\"\">" . $Language->Phrase("PleaseSelect") . "</option>";
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuario->idusuario->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php } else { ?>
<input type="text" data-field="x_idusuario" name="x_idusuario" id="x_idusuario" placeholder="<?php echo ew_HtmlEncode($usuario->idusuario->PlaceHolder) ?>" value="<?php echo $usuario->idusuario->EditValue ?>"<?php echo $usuario->idusuario->EditAttributes() ?>>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuario->userlevelid->Visible) { // userlevelid ?>
	<div id="r_userlevelid" class="form-group">
		<label for="x_userlevelid" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_userlevelid"><?php echo $usuario->userlevelid->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_userlevelid" id="z_userlevelid" value="="></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->userlevelid->CellAttributes() ?>>
			<span id="el_usuario_userlevelid">
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<?php if (strval($usuario->userlevelid->AdvancedSearch->SearchValue) == "") $usuario->userlevelid->AdvancedSearch->SearchValue = CurrentUserID() ?>
<select data-field="x_userlevelid" id="x_userlevelid" name="x_userlevelid"<?php echo $usuario->userlevelid->EditAttributes() ?>>
<?php
if (is_array($usuario->userlevelid->EditValue)) {
	$arwrk = $usuario->userlevelid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuario->userlevelid->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<script type="text/javascript">
fusuariosearch.Lists["x_userlevelid"].Options = <?php echo (is_array($usuario->userlevelid->EditValue)) ? ew_ArrayToJson($usuario->userlevelid->EditValue, 1) : "[]" ?>;
</script>
<?php } elseif (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<p class="form-control-static"><?php echo $usuario->userlevelid->EditValue ?></p>
<?php } else { ?>
<select data-field="x_userlevelid" id="x_userlevelid" name="x_userlevelid"<?php echo $usuario->userlevelid->EditAttributes() ?>>
<?php
if (is_array($usuario->userlevelid->EditValue)) {
	$arwrk = $usuario->userlevelid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuario->userlevelid->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<script type="text/javascript">
fusuariosearch.Lists["x_userlevelid"].Options = <?php echo (is_array($usuario->userlevelid->EditValue)) ? ew_ArrayToJson($usuario->userlevelid->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuario->usuario->Visible) { // usuario ?>
	<div id="r_usuario" class="form-group">
		<label for="x_usuario" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_usuario"><?php echo $usuario->usuario->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_usuario" id="z_usuario" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->usuario->CellAttributes() ?>>
			<span id="el_usuario_usuario">
<input type="text" data-field="x_usuario" name="x_usuario" id="x_usuario" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($usuario->usuario->PlaceHolder) ?>" value="<?php echo $usuario->usuario->EditValue ?>"<?php echo $usuario->usuario->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuario->contrasena->Visible) { // contrasena ?>
	<div id="r_contrasena" class="form-group">
		<label for="x_contrasena" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_contrasena"><?php echo $usuario->contrasena->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_contrasena" id="z_contrasena" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->contrasena->CellAttributes() ?>>
			<span id="el_usuario_contrasena">
<input type="password" data-field="x_contrasena" name="x_contrasena" id="x_contrasena" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($usuario->contrasena->PlaceHolder) ?>"<?php echo $usuario->contrasena->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuario->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label for="x_estado" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_estado"><?php echo $usuario->estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->estado->CellAttributes() ?>>
			<span id="el_usuario_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $usuario->estado->EditAttributes() ?>>
<?php
if (is_array($usuario->estado->EditValue)) {
	$arwrk = $usuario->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($usuario->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php if ($usuario->fecha_insercion->Visible) { // fecha_insercion ?>
	<div id="r_fecha_insercion" class="form-group">
		<label for="x_fecha_insercion" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_fecha_insercion"><?php echo $usuario->fecha_insercion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fecha_insercion" id="z_fecha_insercion" value="="></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->fecha_insercion->CellAttributes() ?>>
			<span id="el_usuario_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x_fecha_insercion" id="x_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($usuario->fecha_insercion->PlaceHolder) ?>" value="<?php echo $usuario->fecha_insercion->EditValue ?>"<?php echo $usuario->fecha_insercion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($usuario->session->Visible) { // session ?>
	<div id="r_session" class="form-group">
		<label for="x_session" class="<?php echo $usuario_search->SearchLabelClass ?>"><span id="elh_usuario_session"><?php echo $usuario->session->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_session" id="z_session" value="LIKE"></p>
		</label>
		<div class="<?php echo $usuario_search->SearchRightColumnClass ?>"><div<?php echo $usuario->session->CellAttributes() ?>>
			<span id="el_usuario_session">
<input type="text" data-field="x_session" name="x_session" id="x_session" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($usuario->session->PlaceHolder) ?>" value="<?php echo $usuario->session->EditValue ?>"<?php echo $usuario->session->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$usuario_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fusuariosearch.Init();
</script>
<?php
$usuario_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$usuario_search->Page_Terminate();
?>
