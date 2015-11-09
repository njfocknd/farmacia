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
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$producto_historial_add = NULL; // Initialize page object first

class cproducto_historial_add extends cproducto_historial {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'producto_historial';

	// Page object name
	var $PageObjName = 'producto_historial_add';

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
	var $AuditTrailOnAdd = TRUE;

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

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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
			$this->Page_Terminate(ew_GetUrl("producto_historiallist.php"));
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
			if (@$_GET["idproducto_historial"] != "") {
				$this->idproducto_historial->setQueryStringValue($_GET["idproducto_historial"]);
				$this->setKey("idproducto_historial", $this->idproducto_historial->CurrentValue); // Set up key
			} else {
				$this->setKey("idproducto_historial", ""); // Clear key
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
					$this->Page_Terminate("producto_historiallist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "producto_historialview.php")
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
		$this->idproducto->CurrentValue = 1;
		$this->idbodega->CurrentValue = 1;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->unidades_ingreso->CurrentValue = 0;
		$this->unidades_salida->CurrentValue = 0;
		$this->idrelacion->CurrentValue = 1;
		$this->tabla_relacion->CurrentValue = "detalle_documento_debito";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idproducto->FldIsDetailKey) {
			$this->idproducto->setFormValue($objForm->GetValue("x_idproducto"));
		}
		if (!$this->idbodega->FldIsDetailKey) {
			$this->idbodega->setFormValue($objForm->GetValue("x_idbodega"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->unidades_ingreso->FldIsDetailKey) {
			$this->unidades_ingreso->setFormValue($objForm->GetValue("x_unidades_ingreso"));
		}
		if (!$this->unidades_salida->FldIsDetailKey) {
			$this->unidades_salida->setFormValue($objForm->GetValue("x_unidades_salida"));
		}
		if (!$this->idrelacion->FldIsDetailKey) {
			$this->idrelacion->setFormValue($objForm->GetValue("x_idrelacion"));
		}
		if (!$this->tabla_relacion->FldIsDetailKey) {
			$this->tabla_relacion->setFormValue($objForm->GetValue("x_tabla_relacion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idproducto->CurrentValue = $this->idproducto->FormValue;
		$this->idbodega->CurrentValue = $this->idbodega->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->unidades_ingreso->CurrentValue = $this->unidades_ingreso->FormValue;
		$this->unidades_salida->CurrentValue = $this->unidades_salida->FormValue;
		$this->idrelacion->CurrentValue = $this->idrelacion->FormValue;
		$this->tabla_relacion->CurrentValue = $this->tabla_relacion->FormValue;
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
		$this->idproducto_historial->setDbValue($rs->fields('idproducto_historial'));
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idbodega->setDbValue($rs->fields('idbodega'));
		$this->idproducto_bodega->setDbValue($rs->fields('idproducto_bodega'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->unidades_ingreso->setDbValue($rs->fields('unidades_ingreso'));
		$this->unidades_salida->setDbValue($rs->fields('unidades_salida'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->idrelacion->setDbValue($rs->fields('idrelacion'));
		$this->tabla_relacion->setDbValue($rs->fields('tabla_relacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idproducto_historial->DbValue = $row['idproducto_historial'];
		$this->idproducto->DbValue = $row['idproducto'];
		$this->idbodega->DbValue = $row['idbodega'];
		$this->idproducto_bodega->DbValue = $row['idproducto_bodega'];
		$this->fecha->DbValue = $row['fecha'];
		$this->unidades_ingreso->DbValue = $row['unidades_ingreso'];
		$this->unidades_salida->DbValue = $row['unidades_salida'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->idrelacion->DbValue = $row['idrelacion'];
		$this->tabla_relacion->DbValue = $row['tabla_relacion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idproducto_historial")) <> "")
			$this->idproducto_historial->CurrentValue = $this->getKey("idproducto_historial"); // idproducto_historial
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

			// idproducto
			$this->idproducto->LinkCustomAttributes = "";
			$this->idproducto->HrefValue = "";
			$this->idproducto->TooltipValue = "";

			// idbodega
			$this->idbodega->LinkCustomAttributes = "";
			$this->idbodega->HrefValue = "";
			$this->idbodega->TooltipValue = "";

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

			// idrelacion
			$this->idrelacion->LinkCustomAttributes = "";
			$this->idrelacion->HrefValue = "";
			$this->idrelacion->TooltipValue = "";

			// tabla_relacion
			$this->tabla_relacion->LinkCustomAttributes = "";
			$this->tabla_relacion->HrefValue = "";
			$this->tabla_relacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// unidades_ingreso
			$this->unidades_ingreso->EditAttrs["class"] = "form-control";
			$this->unidades_ingreso->EditCustomAttributes = "";
			$this->unidades_ingreso->EditValue = ew_HtmlEncode($this->unidades_ingreso->CurrentValue);
			$this->unidades_ingreso->PlaceHolder = ew_RemoveHtml($this->unidades_ingreso->FldCaption());

			// unidades_salida
			$this->unidades_salida->EditAttrs["class"] = "form-control";
			$this->unidades_salida->EditCustomAttributes = "";
			$this->unidades_salida->EditValue = ew_HtmlEncode($this->unidades_salida->CurrentValue);
			$this->unidades_salida->PlaceHolder = ew_RemoveHtml($this->unidades_salida->FldCaption());

			// idrelacion
			$this->idrelacion->EditAttrs["class"] = "form-control";
			$this->idrelacion->EditCustomAttributes = "";
			$this->idrelacion->EditValue = ew_HtmlEncode($this->idrelacion->CurrentValue);
			$this->idrelacion->PlaceHolder = ew_RemoveHtml($this->idrelacion->FldCaption());

			// tabla_relacion
			$this->tabla_relacion->EditAttrs["class"] = "form-control";
			$this->tabla_relacion->EditCustomAttributes = "";
			$this->tabla_relacion->EditValue = ew_HtmlEncode($this->tabla_relacion->CurrentValue);
			$this->tabla_relacion->PlaceHolder = ew_RemoveHtml($this->tabla_relacion->FldCaption());

			// Edit refer script
			// idproducto

			$this->idproducto->HrefValue = "";

			// idbodega
			$this->idbodega->HrefValue = "";

			// fecha
			$this->fecha->HrefValue = "";

			// unidades_ingreso
			$this->unidades_ingreso->HrefValue = "";

			// unidades_salida
			$this->unidades_salida->HrefValue = "";

			// idrelacion
			$this->idrelacion->HrefValue = "";

			// tabla_relacion
			$this->tabla_relacion->HrefValue = "";
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
		if (!$this->idproducto->FldIsDetailKey && !is_null($this->idproducto->FormValue) && $this->idproducto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idproducto->FldCaption(), $this->idproducto->ReqErrMsg));
		}
		if (!$this->idbodega->FldIsDetailKey && !is_null($this->idbodega->FormValue) && $this->idbodega->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idbodega->FldCaption(), $this->idbodega->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->unidades_ingreso->FldIsDetailKey && !is_null($this->unidades_ingreso->FormValue) && $this->unidades_ingreso->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->unidades_ingreso->FldCaption(), $this->unidades_ingreso->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->unidades_ingreso->FormValue)) {
			ew_AddMessage($gsFormError, $this->unidades_ingreso->FldErrMsg());
		}
		if (!$this->unidades_salida->FldIsDetailKey && !is_null($this->unidades_salida->FormValue) && $this->unidades_salida->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->unidades_salida->FldCaption(), $this->unidades_salida->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->unidades_salida->FormValue)) {
			ew_AddMessage($gsFormError, $this->unidades_salida->FldErrMsg());
		}
		if (!$this->idrelacion->FldIsDetailKey && !is_null($this->idrelacion->FormValue) && $this->idrelacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idrelacion->FldCaption(), $this->idrelacion->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idrelacion->FormValue)) {
			ew_AddMessage($gsFormError, $this->idrelacion->FldErrMsg());
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

		// idproducto
		$this->idproducto->SetDbValueDef($rsnew, $this->idproducto->CurrentValue, 0, strval($this->idproducto->CurrentValue) == "");

		// idbodega
		$this->idbodega->SetDbValueDef($rsnew, $this->idbodega->CurrentValue, 0, strval($this->idbodega->CurrentValue) == "");

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// unidades_ingreso
		$this->unidades_ingreso->SetDbValueDef($rsnew, $this->unidades_ingreso->CurrentValue, 0, strval($this->unidades_ingreso->CurrentValue) == "");

		// unidades_salida
		$this->unidades_salida->SetDbValueDef($rsnew, $this->unidades_salida->CurrentValue, 0, strval($this->unidades_salida->CurrentValue) == "");

		// idrelacion
		$this->idrelacion->SetDbValueDef($rsnew, $this->idrelacion->CurrentValue, 0, strval($this->idrelacion->CurrentValue) == "");

		// tabla_relacion
		$this->tabla_relacion->SetDbValueDef($rsnew, $this->tabla_relacion->CurrentValue, NULL, strval($this->tabla_relacion->CurrentValue) == "");

		// idproducto_bodega
		if ($this->idproducto_bodega->getSessionValue() <> "") {
			$rsnew['idproducto_bodega'] = $this->idproducto_bodega->getSessionValue();
		}

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
			$this->idproducto_historial->setDbValue($conn->Insert_ID());
			$rsnew['idproducto_historial'] = $this->idproducto_historial->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
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
			if ($sMasterTblVar == "producto_bodega") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idproducto_bodega"] <> "") {
					$GLOBALS["producto_bodega"]->idproducto_bodega->setQueryStringValue($_GET["fk_idproducto_bodega"]);
					$this->idproducto_bodega->setQueryStringValue($GLOBALS["producto_bodega"]->idproducto_bodega->QueryStringValue);
					$this->idproducto_bodega->setSessionValue($this->idproducto_bodega->QueryStringValue);
					if (!is_numeric($GLOBALS["producto_bodega"]->idproducto_bodega->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "producto_bodega") {
				if ($this->idproducto_bodega->QueryStringValue == "") $this->idproducto_bodega->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "producto_historiallist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'producto_historial';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'producto_historial';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['idproducto_historial'];

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
if (!isset($producto_historial_add)) $producto_historial_add = new cproducto_historial_add();

// Page init
$producto_historial_add->Page_Init();

// Page main
$producto_historial_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_historial_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var producto_historial_add = new ew_Page("producto_historial_add");
producto_historial_add.PageID = "add"; // Page ID
var EW_PAGE_ID = producto_historial_add.PageID; // For backward compatibility

// Form object
var fproducto_historialadd = new ew_Form("fproducto_historialadd");

// Validate form
fproducto_historialadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idproducto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idproducto->FldCaption(), $producto_historial->idproducto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbodega");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idbodega->FldCaption(), $producto_historial->idbodega->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_unidades_ingreso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->unidades_ingreso->FldCaption(), $producto_historial->unidades_ingreso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_unidades_ingreso");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_ingreso->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_unidades_salida");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->unidades_salida->FldCaption(), $producto_historial->unidades_salida->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_unidades_salida");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->unidades_salida->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idrelacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto_historial->idrelacion->FldCaption(), $producto_historial->idrelacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idrelacion");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto_historial->idrelacion->FldErrMsg()) ?>");

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
fproducto_historialadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproducto_historialadd.ValidateRequired = true;
<?php } else { ?>
fproducto_historialadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproducto_historialadd.Lists["x_idproducto"] = {"LinkField":"x_idproducto","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproducto_historialadd.Lists["x_idbodega"] = {"LinkField":"x_idbodega","Ajax":true,"AutoFill":false,"DisplayFields":["x_descripcion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $producto_historial_add->ShowPageHeader(); ?>
<?php
$producto_historial_add->ShowMessage();
?>
<form name="fproducto_historialadd" id="fproducto_historialadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($producto_historial_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $producto_historial_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="producto_historial">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($producto_historial->idproducto->Visible) { // idproducto ?>
	<div id="r_idproducto" class="form-group">
		<label id="elh_producto_historial_idproducto" for="x_idproducto" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->idproducto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->idproducto->CellAttributes() ?>>
<span id="el_producto_historial_idproducto">
<select data-field="x_idproducto" id="x_idproducto" name="x_idproducto"<?php echo $producto_historial->idproducto->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idproducto->EditValue)) {
	$arwrk = $producto_historial->idproducto->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idproducto->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $producto_historial->idproducto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idbodega->Visible) { // idbodega ?>
	<div id="r_idbodega" class="form-group">
		<label id="elh_producto_historial_idbodega" for="x_idbodega" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->idbodega->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->idbodega->CellAttributes() ?>>
<span id="el_producto_historial_idbodega">
<select data-field="x_idbodega" id="x_idbodega" name="x_idbodega"<?php echo $producto_historial->idbodega->EditAttributes() ?>>
<?php
if (is_array($producto_historial->idbodega->EditValue)) {
	$arwrk = $producto_historial->idbodega->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto_historial->idbodega->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $producto_historial->idbodega->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_producto_historial_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->fecha->CellAttributes() ?>>
<span id="el_producto_historial_fecha">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($producto_historial->fecha->PlaceHolder) ?>" value="<?php echo $producto_historial->fecha->EditValue ?>"<?php echo $producto_historial->fecha->EditAttributes() ?>>
<?php if (!$producto_historial->fecha->ReadOnly && !$producto_historial->fecha->Disabled && @$producto_historial->fecha->EditAttrs["readonly"] == "" && @$producto_historial->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fproducto_historialadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $producto_historial->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->unidades_ingreso->Visible) { // unidades_ingreso ?>
	<div id="r_unidades_ingreso" class="form-group">
		<label id="elh_producto_historial_unidades_ingreso" for="x_unidades_ingreso" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->unidades_ingreso->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->unidades_ingreso->CellAttributes() ?>>
<span id="el_producto_historial_unidades_ingreso">
<input type="text" data-field="x_unidades_ingreso" name="x_unidades_ingreso" id="x_unidades_ingreso" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_ingreso->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_ingreso->EditValue ?>"<?php echo $producto_historial->unidades_ingreso->EditAttributes() ?>>
</span>
<?php echo $producto_historial->unidades_ingreso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->unidades_salida->Visible) { // unidades_salida ?>
	<div id="r_unidades_salida" class="form-group">
		<label id="elh_producto_historial_unidades_salida" for="x_unidades_salida" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->unidades_salida->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->unidades_salida->CellAttributes() ?>>
<span id="el_producto_historial_unidades_salida">
<input type="text" data-field="x_unidades_salida" name="x_unidades_salida" id="x_unidades_salida" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->unidades_salida->PlaceHolder) ?>" value="<?php echo $producto_historial->unidades_salida->EditValue ?>"<?php echo $producto_historial->unidades_salida->EditAttributes() ?>>
</span>
<?php echo $producto_historial->unidades_salida->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->idrelacion->Visible) { // idrelacion ?>
	<div id="r_idrelacion" class="form-group">
		<label id="elh_producto_historial_idrelacion" for="x_idrelacion" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->idrelacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->idrelacion->CellAttributes() ?>>
<span id="el_producto_historial_idrelacion">
<input type="text" data-field="x_idrelacion" name="x_idrelacion" id="x_idrelacion" size="30" placeholder="<?php echo ew_HtmlEncode($producto_historial->idrelacion->PlaceHolder) ?>" value="<?php echo $producto_historial->idrelacion->EditValue ?>"<?php echo $producto_historial->idrelacion->EditAttributes() ?>>
</span>
<?php echo $producto_historial->idrelacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto_historial->tabla_relacion->Visible) { // tabla_relacion ?>
	<div id="r_tabla_relacion" class="form-group">
		<label id="elh_producto_historial_tabla_relacion" for="x_tabla_relacion" class="col-sm-2 control-label ewLabel"><?php echo $producto_historial->tabla_relacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $producto_historial->tabla_relacion->CellAttributes() ?>>
<span id="el_producto_historial_tabla_relacion">
<input type="text" data-field="x_tabla_relacion" name="x_tabla_relacion" id="x_tabla_relacion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto_historial->tabla_relacion->PlaceHolder) ?>" value="<?php echo $producto_historial->tabla_relacion->EditValue ?>"<?php echo $producto_historial->tabla_relacion->EditAttributes() ?>>
</span>
<?php echo $producto_historial->tabla_relacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($producto_historial->idproducto_bodega->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_idproducto_bodega" id="x_idproducto_bodega" value="<?php echo ew_HtmlEncode(strval($producto_historial->idproducto_bodega->getSessionValue())) ?>">
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fproducto_historialadd.Init();
</script>
<?php
$producto_historial_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$producto_historial_add->Page_Terminate();
?>
