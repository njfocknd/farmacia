<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_historialinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_bodegainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$producto_historial_search = NULL; // Initialize page object first

class cproducto_historial_search extends cproducto_historial {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'producto_historial';

	// Page object name
	var $PageObjName = 'producto_historial_search';

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

		// Table object (producto_historial)
		if (!isset($GLOBALS["producto_historial"]) || get_class($GLOBALS["producto_historial"]) == "cproducto_historial") {
			$GLOBALS["producto_historial"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["producto_historial"];
		}

		// Table object (producto_bodega)
		if (!isset($GLOBALS['producto_bodega'])) $GLOBALS['producto_bodega'] = new cproducto_bodega();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'producto_historial', TRUE);

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
		$this->idproducto_historial->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $producto_historial;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($producto_historial);
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
						$sSrchStr = "producto_historiallist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->idproducto_historial); // idproducto_historial
		$this->BuildSearchUrl($sSrchUrl, $this->idproducto); // idproducto
		$this->BuildSearchUrl($sSrchUrl, $this->idbodega); // idbodega
		$this->BuildSearchUrl($sSrchUrl, $this->idproducto_bodega); // idproducto_bodega
		$this->BuildSearchUrl($sSrchUrl, $this->fecha); // fecha
		$this->BuildSearchUrl($sSrchUrl, $this->unidades_ingreso); // unidades_ingreso
		$this->BuildSearchUrl($sSrchUrl, $this->unidades_salida); // unidades_salida
		$this->BuildSearchUrl($sSrchUrl, $this->estado); // estado
		$this->BuildSearchUrl($sSrchUrl, $this->fecha_insercion); // fecha_insercion
		$this->BuildSearchUrl($sSrchUrl, $this->idrelacion); // idrelacion
		$this->BuildSearchUrl($sSrchUrl, $this->tabla_relacion); // tabla_relacion
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
		// idproducto_historial

		$this->idproducto_historial->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idproducto_historial"));
		$this->idproducto_historial->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idproducto_historial");

		// idproducto
		$this->idproducto->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idproducto"));
		$this->idproducto->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idproducto");

		// idbodega
		$this->idbodega->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idbodega"));
		$this->idbodega->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idbodega");

		// idproducto_bodega
		$this->idproducto_bodega->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idproducto_bodega"));
		$this->idproducto_bodega->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idproducto_bodega");

		// fecha
		$this->fecha->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fecha"));
		$this->fecha->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fecha");

		// unidades_ingreso
		$this->unidades_ingreso->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_unidades_ingreso"));
		$this->unidades_ingreso->AdvancedSearch->SearchOperator = $objForm->GetValue("z_unidades_ingreso");

		// unidades_salida
		$this->unidades_salida->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_unidades_salida"));
		$this->unidades_salida->AdvancedSearch->SearchOperator = $objForm->GetValue("z_unidades_salida");

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado"));
		$this->estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado");

		// fecha_insercion
		$this->fecha_insercion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_fecha_insercion"));
		$this->fecha_insercion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_fecha_insercion");

		// idrelacion
		$this->idrelacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idrelacion"));
		$this->idrelacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idrelacion");

		// tabla_relacion
		$this->tabla_relacion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_tabla_relacion"));
		$this->tabla_relacion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tabla_relacion");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idproducto_historial
		// idproducto
		// idbodega
		// idproducto_bodega
		// fecha
		// unidades_ingreso
		// unidades_salida
		// estado
		// fecha_insercion
		// idrelacion
		// tabla_relacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idproducto_historial
			$this->idproducto_historial->ViewValue = $this->idproducto_historial->CurrentValue;
			$this->idproducto_historial->ViewCustomAttributes = "";

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

			// idproducto_bodega
			if (strval($this->idproducto_bodega->CurrentValue) <> "") {
				$sFilterWrk = "`idproducto_bodega`" . ew_SearchString("=", $this->idproducto_bodega->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idproducto_bodega`, `idproducto_bodega` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto_bodega`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproducto_bodega, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idproducto_bodega->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idproducto_bodega->ViewValue = $this->idproducto_bodega->CurrentValue;
				}
			} else {
				$this->idproducto_bodega->ViewValue = NULL;
			}
			$this->idproducto_bodega->ViewCustomAttributes = "";

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// unidades_ingreso
			$this->unidades_ingreso->ViewValue = $this->unidades_ingreso->CurrentValue;
			$this->unidades_ingreso->ViewCustomAttributes = "";

			// unidades_salida
			$this->unidades_salida->ViewValue = $this->unidades_salida->CurrentValue;
			$this->unidades_salida->ViewCustomAttributes = "";

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

			// idrelacion
			$this->idrelacion->ViewValue = $this->idrelacion->CurrentValue;
			$this->idrelacion->ViewCustomAttributes = "";

			// tabla_relacion
			$this->tabla_relacion->ViewValue = $this->tabla_relacion->CurrentValue;
			$this->tabla_relacion->ViewCustomAttributes = "";

			// idproducto_historial
			$this->idproducto_historial->LinkCustomAttributes = "";
			$this->idproducto_historial->HrefValue = "";
			$this->idproducto_historial->TooltipValue = "";

			// idproducto
			$this->idproducto->LinkCustomAttributes = "";
			$this->idproducto->HrefValue = "";
			$this->idproducto->TooltipValue = "";

			// idbodega
			$this->idbodega->LinkCustomAttributes = "";
			$this->idbodega->HrefValue = "";
			$this->idbodega->TooltipValue = "";

			// idproducto_bodega
			$this->idproducto_bodega->LinkCustomAttributes = "";
			$this->idproducto_bodega->HrefValue = "";
			$this->idproducto_bodega->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// unidades_ingreso
			$this->unidades_ingreso->LinkCustomAttributes = "";
			$this->unidades_ingreso->HrefValue = "";
			$this->unidades_ingreso->TooltipValue = "";

			// unidades_salida
			$this->unidades_salida->LinkCustomAttributes = "";
			$this->unidades_salida->HrefValue = "";
			$this->unidades_salida->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// idrelacion
			$this->idrelacion->LinkCustomAttributes = "";
			$this->idrelacion->HrefValue = "";
			$this->idrelacion->TooltipValue = "";

			// tabla_relacion
			$this->tabla_relacion->LinkCustomAttributes = "";
			$this->tabla_relacion->HrefValue = "";
			$this->tabla_relacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idproducto_historial
			$this->idproducto_historial->EditAttrs["class"] = "form-control";
			$this->idproducto_historial->EditCustomAttributes = "";
			$this->idproducto_historial->EditValue = ew_HtmlEncode($this->idproducto_historial->AdvancedSearch->SearchValue);
			$this->idproducto_historial->PlaceHolder = ew_RemoveHtml($this->idproducto_historial->FldCaption());

			// idproducto
			$this->idproducto->EditAttrs["class"] = "form-control";
			$this->idproducto->EditCustomAttributes = "";
			if (trim(strval($this->idproducto->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idproducto`" . ew_SearchString("=", $this->idproducto->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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
			if (trim(strval($this->idbodega->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
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

			// idproducto_bodega
			$this->idproducto_bodega->EditAttrs["class"] = "form-control";
			$this->idproducto_bodega->EditCustomAttributes = "";
			if (trim(strval($this->idproducto_bodega->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idproducto_bodega`" . ew_SearchString("=", $this->idproducto_bodega->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idproducto_bodega`, `idproducto_bodega` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `producto_bodega`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idproducto_bodega, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idproducto_bodega->EditValue = $arwrk;

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fecha->AdvancedSearch->SearchValue, 7), 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// unidades_ingreso
			$this->unidades_ingreso->EditAttrs["class"] = "form-control";
			$this->unidades_ingreso->EditCustomAttributes = "";
			$this->unidades_ingreso->EditValue = ew_HtmlEncode($this->unidades_ingreso->AdvancedSearch->SearchValue);
			$this->unidades_ingreso->PlaceHolder = ew_RemoveHtml($this->unidades_ingreso->FldCaption());

			// unidades_salida
			$this->unidades_salida->EditAttrs["class"] = "form-control";
			$this->unidades_salida->EditCustomAttributes = "";
			$this->unidades_salida->EditValue = ew_HtmlEncode($this->unidades_salida->AdvancedSearch->SearchValue);
			$this->unidades_salida->PlaceHolder = ew_RemoveHtml($this->unidades_salida->FldCaption());

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

			// idrelacion
			$this->idrelacion->EditAttrs["class"] = "form-control";
			$this->idrelacion->EditCustomAttributes = "";
			$this->idrelacion->EditValue = ew_HtmlEncode($this->idrelacion->AdvancedSearch->SearchValue);
			$this->idrelacion->PlaceHolder = ew_RemoveHtml($this->idrelacion->FldCaption());

			// tabla_relacion
			$this->tabla_relacion->EditAttrs["class"] = "form-control";
			$this->tabla_relacion->EditCustomAttributes = "";
			$this->tabla_relacion->EditValue = ew_HtmlEncode($this->tabla_relacion->AdvancedSearch->SearchValue);
			$this->tabla_relacion->PlaceHolder = ew_RemoveHtml($this->tabla_relacion->FldCaption());
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
		if (!ew_CheckInteger($this->idproducto_historial->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idproducto_historial->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fecha->FldErrMsg());
		}
		if (!ew_CheckInteger($this->unidades_ingreso->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->unidades_ingreso->FldErrMsg());
		}
		if (!ew_CheckInteger($this->unidades_salida->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->unidades_salida->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha_insercion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->fecha_insercion->FldErrMsg());
		}
		if (!ew_CheckInteger($this->idrelacion->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idrelacion->FldErrMsg());
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
		$this->idproducto_historial->AdvancedSearch->Load();
		$this->idproducto->AdvancedSearch->Load();
		$this->idbodega->AdvancedSearch->Load();
		$this->idproducto_bodega->AdvancedSearch->Load();
		$this->fecha->AdvancedSearch->Load();
		$this->unidades_ingreso->AdvancedSearch->Load();
		$this->unidades_salida->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->fecha_insercion->AdvancedSearch->Load();
		$this->idrelacion->AdvancedSearch->Load();
		$this->tabla_relacion->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "producto_historiallist.php", "", $this->TableVar, TRUE);
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
if (!isset($producto_historial_search)) $producto_historial_search = new cproducto_historial_search();

// Page init
$producto_historial_search->Page_Init();

// Page main
$producto_historial_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_historial_search->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var producto_historial_search = new ew_Page("producto_historial_search");
producto_historial_search.PageID = "search"; // Page ID
var EW_PAGE_ID = producto_historial_search.PageID; // For backward compatibility

// Form object
var fproducto_historialsearch = new ew_Form("fproducto_historialsearch");

// Form_CustomValidate event
fproducto_historialsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_historialsearch.ValidateRequired = true;
<?php } else { ?>
fproducto_historialsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_historialsearch.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_historialsearch.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_historialsearch.Lists["x_idproducto_bodega"] = {"LinkField":"x_idproducto_bodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_idproducto_bodega","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
// Validate function for search

fproducto_historialsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";
	elm = this.GetElements("x" + infix + "_idproducto_historial");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->idproducto_historial->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fecha");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->fecha->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_unidades_ingreso");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_ingreso->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_unidades_salida");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_salida->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_fecha_insercion");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->fecha_insercion->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_idrelacion");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->idrelacion->FldErrMsg()) ?>");

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
<?php if (!$producto_historial_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $producto_historial_search->ShowPageHeader(); ?>
<?php
$producto_historial_search->ShowMessage();
?>
<form name="fproducto_historialsearch" id="fproducto_historialsearch" class="form-horizontal ewForm ewSearchForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($producto_historial_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $producto_historial_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="producto_historial">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($producto_historial_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($producto_historial->idproducto_historial->Visible) { // idproducto_historial ?>
	<div id="r_idproducto_historial" class="form-group">
		<label for="x_idproducto_historial" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_idproducto_historial"><?php echo $producto_historial->idproducto_historial->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idproducto_historial" id="z_idproducto_historial" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->idproducto_historial->CellAttributes() ?>>
			<span id="el_producto_historial_idproducto_historial">
<input type="text" data-field="x_idproducto_historial" name="x_idproducto_historial" id="x_idproducto_historial" placeholder="<?php echo ew_HtmlEncode($producto_historial->idproducto_historial->PlaceHolder) ?>" value="<?php echo $producto_historial->idproducto_historial->EditValue ?>"<?php echo $producto_historial->idproducto_historial->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idproducto->Visible) { // idproducto ?>
	<div id="r_idproducto" class="form-group">
		<label for="x_idproducto" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_idproducto"><?php echo $producto_historial->idproducto->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idproducto" id="z_idproducto" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->idproducto->CellAttributes() ?>>
			<span id="el_producto_historial_idproducto">
<select data-field="x_idproducto" id="x_idproducto" name="x_idproducto"<?php echo $producto_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto->EditValue)) {
	$arwrk = $producto_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idproducto`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$producto_historial->Lookup_Selecting($producto_historial->idproducto, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idproducto" id="s_x_idproducto" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto` = {filter_value}"); ?>&amp;t0=3">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idbodega->Visible) { // idbodega ?>
	<div id="r_idbodega" class="form-group">
		<label for="x_idbodega" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_idbodega"><?php echo $producto_historial->idbodega->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idbodega" id="z_idbodega" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->idbodega->CellAttributes() ?>>
			<span id="el_producto_historial_idbodega">
<select data-field="x_idbodega" id="x_idbodega" name="x_idbodega"<?php echo $producto_historial->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idbodega->EditValue)) {
	$arwrk = $producto_historial->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idbodega->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idbodega`, `descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bodega`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$producto_historial->Lookup_Selecting($producto_historial->idbodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `descripcion`";
?>
<input type="hidden" name="s_x_idbodega" id="s_x_idbodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idbodega` = {filter_value}"); ?>&amp;t0=3">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idproducto_bodega->Visible) { // idproducto_bodega ?>
	<div id="r_idproducto_bodega" class="form-group">
		<label for="x_idproducto_bodega" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_idproducto_bodega"><?php echo $producto_historial->idproducto_bodega->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idproducto_bodega" id="z_idproducto_bodega" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->idproducto_bodega->CellAttributes() ?>>
			<span id="el_producto_historial_idproducto_bodega">
<select data-field="x_idproducto_bodega" id="x_idproducto_bodega" name="x_idproducto_bodega"<?php echo $producto_historial->idproducto_bodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto_bodega->EditValue)) {
	$arwrk = $producto_historial->idproducto_bodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto_bodega->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idproducto_bodega`, `idproducto_bodega` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `producto_bodega`";
$sWhereWrk = "";

// Call Lookup selecting
$producto_historial->Lookup_Selecting($producto_historial->idproducto_bodega, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idproducto_bodega" id="s_x_idproducto_bodega" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idproducto_bodega` = {filter_value}"); ?>&amp;t0=3">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label for="x_fecha" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_fecha"><?php echo $producto_historial->fecha->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fecha" id="z_fecha" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->fecha->CellAttributes() ?>>
			<span id="el_producto_historial_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha->EditValue ?>"<?php echo $producto_historial->fecha->EditAttributes() ?>>
<?php if (!$producto_historial->fecha->ReadOnly && !$producto_historial->fecha->Disabled && @$producto_historial->fecha->EditAttrs["readonly"] == "" && @$producto_historial->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fproducto_historialsearch", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->unidades_ingreso->Visible) { // unidades_ingreso ?>
	<div id="r_unidades_ingreso" class="form-group">
		<label for="x_unidades_ingreso" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_unidades_ingreso"><?php echo $producto_historial->unidades_ingreso->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_unidades_ingreso" id="z_unidades_ingreso" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->unidades_ingreso->CellAttributes() ?>>
			<span id="el_producto_historial_unidades_ingreso">
<input type="text" data-field="x_unidades_ingreso" name="x_unidades_ingreso" id="x_unidades_ingreso" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_ingreso->EditValue ?>"<?php echo $producto_historial->unidades_ingreso->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->unidades_salida->Visible) { // unidades_salida ?>
	<div id="r_unidades_salida" class="form-group">
		<label for="x_unidades_salida" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_unidades_salida"><?php echo $producto_historial->unidades_salida->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_unidades_salida" id="z_unidades_salida" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->unidades_salida->CellAttributes() ?>>
			<span id="el_producto_historial_unidades_salida">
<input type="text" data-field="x_unidades_salida" name="x_unidades_salida" id="x_unidades_salida" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_salida->EditValue ?>"<?php echo $producto_historial->unidades_salida->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label for="x_estado" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_estado"><?php echo $producto_historial->estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->estado->CellAttributes() ?>>
			<span id="el_producto_historial_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $producto_historial->estado->EditAttributes() ?>>
<?php
if (is_array($producto_historial->estado->EditValue)) {
	$arwrk = $producto_historial->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php if ($producto_historial->fecha_insercion->Visible) { // fecha_insercion ?>
	<div id="r_fecha_insercion" class="form-group">
		<label for="x_fecha_insercion" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_fecha_insercion"><?php echo $producto_historial->fecha_insercion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fecha_insercion" id="z_fecha_insercion" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->fecha_insercion->CellAttributes() ?>>
			<span id="el_producto_historial_fecha_insercion">
<input type="text" data-field="x_fecha_insercion" name="x_fecha_insercion" id="x_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha_insercion->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha_insercion->EditValue ?>"<?php echo $producto_historial->fecha_insercion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idrelacion->Visible) { // idrelacion ?>
	<div id="r_idrelacion" class="form-group">
		<label for="x_idrelacion" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_idrelacion"><?php echo $producto_historial->idrelacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idrelacion" id="z_idrelacion" value="="></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->idrelacion->CellAttributes() ?>>
			<span id="el_producto_historial_idrelacion">
<input type="text" data-field="x_idrelacion" name="x_idrelacion" id="x_idrelacion" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->idrelacion->PlaceHolder) ?>" value="<?php echo $producto_historial->idrelacion->EditValue ?>"<?php echo $producto_historial->idrelacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->tabla_relacion->Visible) { // tabla_relacion ?>
	<div id="r_tabla_relacion" class="form-group">
		<label for="x_tabla_relacion" class="<?php echo $producto_historial_search->SearchLabelClass ?>"><span id="elh_producto_historial_tabla_relacion"><?php echo $producto_historial->tabla_relacion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_tabla_relacion" id="z_tabla_relacion" value="LIKE"></p>
		</label>
		<div class="<?php echo $producto_historial_search->SearchRightColumnClass ?>"><div<?php echo $producto_historial->tabla_relacion->CellAttributes() ?>>
			<span id="el_producto_historial_tabla_relacion">
<input type="text" data-field="x_tabla_relacion" name="x_tabla_relacion" id="x_tabla_relacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->PlaceHolder) ?>" value="<?php echo $producto_historial->tabla_relacion->EditValue ?>"<?php echo $producto_historial->tabla_relacion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$producto_historial_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fproducto_historialsearch.Init();
</script>
<?php
$producto_historial_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$producto_historial_search->Page_Terminate();
?>
