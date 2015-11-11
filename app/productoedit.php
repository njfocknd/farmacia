<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "productoinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "marcainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "usuarioinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "categoriainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "registro_sanitariogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_bodegagridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_sucursalgridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "producto_precio_historialgridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$producto_edit = NULL; // Initialize page object first

class cproducto_edit extends cproducto {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'producto';

	// Page object name
	var $PageObjName = 'producto_edit';

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
	var $AuditTrailOnEdit = TRUE;

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

		// Table object (producto)
		if (!isset($GLOBALS["producto"]) || get_class($GLOBALS["producto"]) == "cproducto") {
			$GLOBALS["producto"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["producto"];
		}

		// Table object (marca)
		if (!isset($GLOBALS['marca'])) $GLOBALS['marca'] = new cmarca();

		// Table object (usuario)
		if (!isset($GLOBALS['usuario'])) $GLOBALS['usuario'] = new cusuario();

		// Table object (categoria)
		if (!isset($GLOBALS['categoria'])) $GLOBALS['categoria'] = new ccategoria();

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'producto', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("productolist.php"));
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

			// Process auto fill for detail table 'registro_sanitario'
			if (@$_POST["grid"] == "fregistro_sanitariogrid") {
				if (!isset($GLOBALS["registro_sanitario_grid"])) $GLOBALS["registro_sanitario_grid"] = new cregistro_sanitario_grid;
				$GLOBALS["registro_sanitario_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'producto_bodega'
			if (@$_POST["grid"] == "fproducto_bodegagrid") {
				if (!isset($GLOBALS["producto_bodega_grid"])) $GLOBALS["producto_bodega_grid"] = new cproducto_bodega_grid;
				$GLOBALS["producto_bodega_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'producto_sucursal'
			if (@$_POST["grid"] == "fproducto_sucursalgrid") {
				if (!isset($GLOBALS["producto_sucursal_grid"])) $GLOBALS["producto_sucursal_grid"] = new cproducto_sucursal_grid;
				$GLOBALS["producto_sucursal_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'producto_precio_historial'
			if (@$_POST["grid"] == "fproducto_precio_historialgrid") {
				if (!isset($GLOBALS["producto_precio_historial_grid"])) $GLOBALS["producto_precio_historial_grid"] = new cproducto_precio_historial_grid;
				$GLOBALS["producto_precio_historial_grid"]->Page_Init();
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
		global $EW_EXPORT, $producto;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($producto);
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["idproducto"] <> "") {
			$this->idproducto->setQueryStringValue($_GET["idproducto"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->idproducto->CurrentValue == "")
			$this->Page_Terminate("productolist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("productolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
					else
						$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idcategoria->FldIsDetailKey) {
			$this->idcategoria->setFormValue($objForm->GetValue("x_idcategoria"));
		}
		if (!$this->idmarca->FldIsDetailKey) {
			$this->idmarca->setFormValue($objForm->GetValue("x_idmarca"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->idpais->FldIsDetailKey) {
			$this->idpais->setFormValue($objForm->GetValue("x_idpais"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->precio_venta->FldIsDetailKey) {
			$this->precio_venta->setFormValue($objForm->GetValue("x_precio_venta"));
		}
		if (!$this->precio_compra->FldIsDetailKey) {
			$this->precio_compra->setFormValue($objForm->GetValue("x_precio_compra"));
		}
		if (!$this->idproducto->FldIsDetailKey)
			$this->idproducto->setFormValue($objForm->GetValue("x_idproducto"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idproducto->CurrentValue = $this->idproducto->FormValue;
		$this->idcategoria->CurrentValue = $this->idcategoria->FormValue;
		$this->idmarca->CurrentValue = $this->idmarca->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idpais->CurrentValue = $this->idpais->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->precio_venta->CurrentValue = $this->precio_venta->FormValue;
		$this->precio_compra->CurrentValue = $this->precio_compra->FormValue;
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
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idcategoria->setDbValue($rs->fields('idcategoria'));
		$this->idmarca->setDbValue($rs->fields('idmarca'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->existencia->setDbValue($rs->fields('existencia'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->precio_venta->setDbValue($rs->fields('precio_venta'));
		$this->precio_compra->setDbValue($rs->fields('precio_compra'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idproducto->DbValue = $row['idproducto'];
		$this->idcategoria->DbValue = $row['idcategoria'];
		$this->idmarca->DbValue = $row['idmarca'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idpais->DbValue = $row['idpais'];
		$this->existencia->DbValue = $row['existencia'];
		$this->estado->DbValue = $row['estado'];
		$this->precio_venta->DbValue = $row['precio_venta'];
		$this->precio_compra->DbValue = $row['precio_compra'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->precio_venta->FormValue == $this->precio_venta->CurrentValue && is_numeric(ew_StrToFloat($this->precio_venta->CurrentValue)))
			$this->precio_venta->CurrentValue = ew_StrToFloat($this->precio_venta->CurrentValue);

		// Convert decimal values if posted back
		if ($this->precio_compra->FormValue == $this->precio_compra->CurrentValue && is_numeric(ew_StrToFloat($this->precio_compra->CurrentValue)))
			$this->precio_compra->CurrentValue = ew_StrToFloat($this->precio_compra->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idproducto
		// idcategoria
		// idmarca
		// nombre
		// idpais
		// existencia
		// estado
		// precio_venta
		// precio_compra
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idproducto
			$this->idproducto->ViewValue = $this->idproducto->CurrentValue;
			$this->idproducto->ViewCustomAttributes = "";

			// idcategoria
			if (strval($this->idcategoria->CurrentValue) <> "") {
				$sFilterWrk = "`idcategoria`" . ew_SearchString("=", $this->idcategoria->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcategoria, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcategoria->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idcategoria->ViewValue = $this->idcategoria->CurrentValue;
				}
			} else {
				$this->idcategoria->ViewValue = NULL;
			}
			$this->idcategoria->ViewCustomAttributes = "";

			// idmarca
			if (strval($this->idmarca->CurrentValue) <> "") {
				$sFilterWrk = "`idmarca`" . ew_SearchString("=", $this->idmarca->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idmarca, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idmarca->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idmarca->ViewValue = $this->idmarca->CurrentValue;
				}
			} else {
				$this->idmarca->ViewValue = NULL;
			}
			$this->idmarca->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// idpais
			if (strval($this->idpais->CurrentValue) <> "") {
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpais->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idpais->ViewValue = $this->idpais->CurrentValue;
				}
			} else {
				$this->idpais->ViewValue = NULL;
			}
			$this->idpais->ViewCustomAttributes = "";

			// existencia
			$this->existencia->ViewValue = $this->existencia->CurrentValue;
			$this->existencia->ViewCustomAttributes = "";

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

			// precio_venta
			$this->precio_venta->ViewValue = $this->precio_venta->CurrentValue;
			$this->precio_venta->ViewValue = ew_FormatCurrency($this->precio_venta->ViewValue, 2, -2, -2, -2);
			$this->precio_venta->ViewCustomAttributes = "";

			// precio_compra
			$this->precio_compra->ViewValue = $this->precio_compra->CurrentValue;
			$this->precio_compra->ViewValue = ew_FormatCurrency($this->precio_compra->ViewValue, 0, -2, -2, -2);
			$this->precio_compra->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// idcategoria
			$this->idcategoria->LinkCustomAttributes = "";
			$this->idcategoria->HrefValue = "";
			$this->idcategoria->TooltipValue = "";

			// idmarca
			$this->idmarca->LinkCustomAttributes = "";
			$this->idmarca->HrefValue = "";
			$this->idmarca->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";
			$this->idpais->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// precio_venta
			$this->precio_venta->LinkCustomAttributes = "";
			$this->precio_venta->HrefValue = "";
			$this->precio_venta->TooltipValue = "";

			// precio_compra
			$this->precio_compra->LinkCustomAttributes = "";
			$this->precio_compra->HrefValue = "";
			$this->precio_compra->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idcategoria
			$this->idcategoria->EditAttrs["class"] = "form-control";
			$this->idcategoria->EditCustomAttributes = "";
			if ($this->idcategoria->getSessionValue() <> "") {
				$this->idcategoria->CurrentValue = $this->idcategoria->getSessionValue();
			if (strval($this->idcategoria->CurrentValue) <> "") {
				$sFilterWrk = "`idcategoria`" . ew_SearchString("=", $this->idcategoria->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcategoria, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcategoria->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idcategoria->ViewValue = $this->idcategoria->CurrentValue;
				}
			} else {
				$this->idcategoria->ViewValue = NULL;
			}
			$this->idcategoria->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idcategoria->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcategoria`" . ew_SearchString("=", $this->idcategoria->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categoria`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcategoria, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcategoria->EditValue = $arwrk;
			}

			// idmarca
			$this->idmarca->EditAttrs["class"] = "form-control";
			$this->idmarca->EditCustomAttributes = "";
			if ($this->idmarca->getSessionValue() <> "") {
				$this->idmarca->CurrentValue = $this->idmarca->getSessionValue();
			if (strval($this->idmarca->CurrentValue) <> "") {
				$sFilterWrk = "`idmarca`" . ew_SearchString("=", $this->idmarca->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idmarca, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idmarca->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idmarca->ViewValue = $this->idmarca->CurrentValue;
				}
			} else {
				$this->idmarca->ViewValue = NULL;
			}
			$this->idmarca->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idmarca->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idmarca`" . ew_SearchString("=", $this->idmarca->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `marca`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idmarca, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idmarca->EditValue = $arwrk;
			}

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idpais
			$this->idpais->EditAttrs["class"] = "form-control";
			$this->idpais->EditCustomAttributes = "";
			if (trim(strval($this->idpais->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpais->EditValue = $arwrk;

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// precio_venta
			$this->precio_venta->EditAttrs["class"] = "form-control";
			$this->precio_venta->EditCustomAttributes = "";
			$this->precio_venta->EditValue = ew_HtmlEncode($this->precio_venta->CurrentValue);
			$this->precio_venta->PlaceHolder = ew_RemoveHtml($this->precio_venta->FldCaption());
			if (strval($this->precio_venta->EditValue) <> "" && is_numeric($this->precio_venta->EditValue)) $this->precio_venta->EditValue = ew_FormatNumber($this->precio_venta->EditValue, -2, -2, -2, -2);

			// precio_compra
			$this->precio_compra->EditAttrs["class"] = "form-control";
			$this->precio_compra->EditCustomAttributes = "";
			$this->precio_compra->EditValue = ew_HtmlEncode($this->precio_compra->CurrentValue);
			$this->precio_compra->PlaceHolder = ew_RemoveHtml($this->precio_compra->FldCaption());
			if (strval($this->precio_compra->EditValue) <> "" && is_numeric($this->precio_compra->EditValue)) $this->precio_compra->EditValue = ew_FormatNumber($this->precio_compra->EditValue, -2, -2, -2, -2);

			// Edit refer script
			// idcategoria

			$this->idcategoria->HrefValue = "";

			// idmarca
			$this->idmarca->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// idpais
			$this->idpais->HrefValue = "";

			// estado
			$this->estado->HrefValue = "";

			// precio_venta
			$this->precio_venta->HrefValue = "";

			// precio_compra
			$this->precio_compra->HrefValue = "";
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
		if (!$this->idcategoria->FldIsDetailKey && !is_null($this->idcategoria->FormValue) && $this->idcategoria->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcategoria->FldCaption(), $this->idcategoria->ReqErrMsg));
		}
		if (!$this->idmarca->FldIsDetailKey && !is_null($this->idmarca->FormValue) && $this->idmarca->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idmarca->FldCaption(), $this->idmarca->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idpais->FldIsDetailKey && !is_null($this->idpais->FormValue) && $this->idpais->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpais->FldCaption(), $this->idpais->ReqErrMsg));
		}
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}
		if (!$this->precio_venta->FldIsDetailKey && !is_null($this->precio_venta->FormValue) && $this->precio_venta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->precio_venta->FldCaption(), $this->precio_venta->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->precio_venta->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio_venta->FldErrMsg());
		}
		if (!$this->precio_compra->FldIsDetailKey && !is_null($this->precio_compra->FormValue) && $this->precio_compra->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->precio_compra->FldCaption(), $this->precio_compra->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->precio_compra->FormValue)) {
			ew_AddMessage($gsFormError, $this->precio_compra->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("registro_sanitario", $DetailTblVar) && $GLOBALS["registro_sanitario"]->DetailEdit) {
			if (!isset($GLOBALS["registro_sanitario_grid"])) $GLOBALS["registro_sanitario_grid"] = new cregistro_sanitario_grid(); // get detail page object
			$GLOBALS["registro_sanitario_grid"]->ValidateGridForm();
		}
		if (in_array("producto_bodega", $DetailTblVar) && $GLOBALS["producto_bodega"]->DetailEdit) {
			if (!isset($GLOBALS["producto_bodega_grid"])) $GLOBALS["producto_bodega_grid"] = new cproducto_bodega_grid(); // get detail page object
			$GLOBALS["producto_bodega_grid"]->ValidateGridForm();
		}
		if (in_array("producto_sucursal", $DetailTblVar) && $GLOBALS["producto_sucursal"]->DetailEdit) {
			if (!isset($GLOBALS["producto_sucursal_grid"])) $GLOBALS["producto_sucursal_grid"] = new cproducto_sucursal_grid(); // get detail page object
			$GLOBALS["producto_sucursal_grid"]->ValidateGridForm();
		}
		if (in_array("producto_precio_historial", $DetailTblVar) && $GLOBALS["producto_precio_historial"]->DetailEdit) {
			if (!isset($GLOBALS["producto_precio_historial_grid"])) $GLOBALS["producto_precio_historial_grid"] = new cproducto_precio_historial_grid(); // get detail page object
			$GLOBALS["producto_precio_historial_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// idcategoria
			$this->idcategoria->SetDbValueDef($rsnew, $this->idcategoria->CurrentValue, 0, $this->idcategoria->ReadOnly);

			// idmarca
			$this->idmarca->SetDbValueDef($rsnew, $this->idmarca->CurrentValue, 0, $this->idmarca->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", $this->nombre->ReadOnly);

			// idpais
			$this->idpais->SetDbValueDef($rsnew, $this->idpais->CurrentValue, 0, $this->idpais->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

			// precio_venta
			$this->precio_venta->SetDbValueDef($rsnew, $this->precio_venta->CurrentValue, 0, $this->precio_venta->ReadOnly);

			// precio_compra
			$this->precio_compra->SetDbValueDef($rsnew, $this->precio_compra->CurrentValue, 0, $this->precio_compra->ReadOnly);

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("registro_sanitario", $DetailTblVar) && $GLOBALS["registro_sanitario"]->DetailEdit) {
						if (!isset($GLOBALS["registro_sanitario_grid"])) $GLOBALS["registro_sanitario_grid"] = new cregistro_sanitario_grid(); // Get detail page object
						$EditRow = $GLOBALS["registro_sanitario_grid"]->GridUpdate();
					}
					if (in_array("producto_bodega", $DetailTblVar) && $GLOBALS["producto_bodega"]->DetailEdit) {
						if (!isset($GLOBALS["producto_bodega_grid"])) $GLOBALS["producto_bodega_grid"] = new cproducto_bodega_grid(); // Get detail page object
						$EditRow = $GLOBALS["producto_bodega_grid"]->GridUpdate();
					}
					if (in_array("producto_sucursal", $DetailTblVar) && $GLOBALS["producto_sucursal"]->DetailEdit) {
						if (!isset($GLOBALS["producto_sucursal_grid"])) $GLOBALS["producto_sucursal_grid"] = new cproducto_sucursal_grid(); // Get detail page object
						$EditRow = $GLOBALS["producto_sucursal_grid"]->GridUpdate();
					}
					if (in_array("producto_precio_historial", $DetailTblVar) && $GLOBALS["producto_precio_historial"]->DetailEdit) {
						if (!isset($GLOBALS["producto_precio_historial_grid"])) $GLOBALS["producto_precio_historial_grid"] = new cproducto_precio_historial_grid(); // Get detail page object
						$EditRow = $GLOBALS["producto_precio_historial_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if ($sMasterTblVar == "marca") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idmarca"] <> "") {
					$GLOBALS["marca"]->idmarca->setQueryStringValue($_GET["fk_idmarca"]);
					$this->idmarca->setQueryStringValue($GLOBALS["marca"]->idmarca->QueryStringValue);
					$this->idmarca->setSessionValue($this->idmarca->QueryStringValue);
					if (!is_numeric($GLOBALS["marca"]->idmarca->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "categoria") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcategoria"] <> "") {
					$GLOBALS["categoria"]->idcategoria->setQueryStringValue($_GET["fk_idcategoria"]);
					$this->idcategoria->setQueryStringValue($GLOBALS["categoria"]->idcategoria->QueryStringValue);
					$this->idcategoria->setSessionValue($this->idcategoria->QueryStringValue);
					if (!is_numeric($GLOBALS["categoria"]->idcategoria->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "marca") {
				if ($this->idmarca->QueryStringValue == "") $this->idmarca->setSessionValue("");
			}
			if ($sMasterTblVar <> "categoria") {
				if ($this->idcategoria->QueryStringValue == "") $this->idcategoria->setSessionValue("");
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
			if (in_array("registro_sanitario", $DetailTblVar)) {
				if (!isset($GLOBALS["registro_sanitario_grid"]))
					$GLOBALS["registro_sanitario_grid"] = new cregistro_sanitario_grid;
				if ($GLOBALS["registro_sanitario_grid"]->DetailEdit) {
					$GLOBALS["registro_sanitario_grid"]->CurrentMode = "edit";
					$GLOBALS["registro_sanitario_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["registro_sanitario_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["registro_sanitario_grid"]->setStartRecordNumber(1);
					$GLOBALS["registro_sanitario_grid"]->idproducto->FldIsDetailKey = TRUE;
					$GLOBALS["registro_sanitario_grid"]->idproducto->CurrentValue = $this->idproducto->CurrentValue;
					$GLOBALS["registro_sanitario_grid"]->idproducto->setSessionValue($GLOBALS["registro_sanitario_grid"]->idproducto->CurrentValue);
				}
			}
			if (in_array("producto_bodega", $DetailTblVar)) {
				if (!isset($GLOBALS["producto_bodega_grid"]))
					$GLOBALS["producto_bodega_grid"] = new cproducto_bodega_grid;
				if ($GLOBALS["producto_bodega_grid"]->DetailEdit) {
					$GLOBALS["producto_bodega_grid"]->CurrentMode = "edit";
					$GLOBALS["producto_bodega_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["producto_bodega_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["producto_bodega_grid"]->setStartRecordNumber(1);
					$GLOBALS["producto_bodega_grid"]->idproducto->FldIsDetailKey = TRUE;
					$GLOBALS["producto_bodega_grid"]->idproducto->CurrentValue = $this->idproducto->CurrentValue;
					$GLOBALS["producto_bodega_grid"]->idproducto->setSessionValue($GLOBALS["producto_bodega_grid"]->idproducto->CurrentValue);
				}
			}
			if (in_array("producto_sucursal", $DetailTblVar)) {
				if (!isset($GLOBALS["producto_sucursal_grid"]))
					$GLOBALS["producto_sucursal_grid"] = new cproducto_sucursal_grid;
				if ($GLOBALS["producto_sucursal_grid"]->DetailEdit) {
					$GLOBALS["producto_sucursal_grid"]->CurrentMode = "edit";
					$GLOBALS["producto_sucursal_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["producto_sucursal_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["producto_sucursal_grid"]->setStartRecordNumber(1);
					$GLOBALS["producto_sucursal_grid"]->idproducto->FldIsDetailKey = TRUE;
					$GLOBALS["producto_sucursal_grid"]->idproducto->CurrentValue = $this->idproducto->CurrentValue;
					$GLOBALS["producto_sucursal_grid"]->idproducto->setSessionValue($GLOBALS["producto_sucursal_grid"]->idproducto->CurrentValue);
				}
			}
			if (in_array("producto_precio_historial", $DetailTblVar)) {
				if (!isset($GLOBALS["producto_precio_historial_grid"]))
					$GLOBALS["producto_precio_historial_grid"] = new cproducto_precio_historial_grid;
				if ($GLOBALS["producto_precio_historial_grid"]->DetailEdit) {
					$GLOBALS["producto_precio_historial_grid"]->CurrentMode = "edit";
					$GLOBALS["producto_precio_historial_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["producto_precio_historial_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["producto_precio_historial_grid"]->setStartRecordNumber(1);
					$GLOBALS["producto_precio_historial_grid"]->idproducto->FldIsDetailKey = TRUE;
					$GLOBALS["producto_precio_historial_grid"]->idproducto->CurrentValue = $this->idproducto->CurrentValue;
					$GLOBALS["producto_precio_historial_grid"]->idproducto->setSessionValue($GLOBALS["producto_precio_historial_grid"]->idproducto->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "productolist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'producto';
	  $usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'producto';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['idproducto'];

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
if (!isset($producto_edit)) $producto_edit = new cproducto_edit();

// Page init
$producto_edit->Page_Init();

// Page main
$producto_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$producto_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var producto_edit = new ew_Page("producto_edit");
producto_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = producto_edit.PageID; // For backward compatibility

// Form object
var fproductoedit = new ew_Form("fproductoedit");

// Validate form
fproductoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcategoria");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idcategoria->FldCaption(), $producto->idcategoria->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmarca");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idmarca->FldCaption(), $producto->idmarca->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->nombre->FldCaption(), $producto->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->idpais->FldCaption(), $producto->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->estado->FldCaption(), $producto->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->precio_venta->FldCaption(), $producto->precio_venta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_venta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto->precio_venta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_precio_compra");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $producto->precio_compra->FldCaption(), $producto->precio_compra->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_precio_compra");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($producto->precio_compra->FldErrMsg()) ?>");

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
fproductoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproductoedit.ValidateRequired = true;
<?php } else { ?>
fproductoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproductoedit.Lists["x_idcategoria"] = {"LinkField":"x_idcategoria","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproductoedit.Lists["x_idmarca"] = {"LinkField":"x_idmarca","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fproductoedit.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $producto_edit->ShowPageHeader(); ?>
<?php
$producto_edit->ShowMessage();
?>
<form name="fproductoedit" id="fproductoedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($producto_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $producto_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="producto">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($producto->idcategoria->Visible) { // idcategoria ?>
	<div id="r_idcategoria" class="form-group">
		<label id="elh_producto_idcategoria" for="x_idcategoria" class="col-sm-2 control-label ewLabel"><?php echo $producto->idcategoria->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->idcategoria->CellAttributes() ?>>
<?php if ($producto->idcategoria->getSessionValue() <> "") { ?>
<span id="el_producto_idcategoria">
<span<?php echo $producto->idcategoria->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idcategoria->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcategoria" name="x_idcategoria" value="<?php echo ew_HtmlEncode($producto->idcategoria->CurrentValue) ?>">
<?php } else { ?>
<span id="el_producto_idcategoria">
<select data-field="x_idcategoria" id="x_idcategoria" name="x_idcategoria"<?php echo $producto->idcategoria->EditAttributes() ?>>
<?php
if (is_array($producto->idcategoria->EditValue)) {
	$arwrk = $producto->idcategoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idcategoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$producto->Lookup_Selecting($producto->idcategoria, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idcategoria" id="s_x_idcategoria" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcategoria` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $producto->idcategoria->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->idmarca->Visible) { // idmarca ?>
	<div id="r_idmarca" class="form-group">
		<label id="elh_producto_idmarca" for="x_idmarca" class="col-sm-2 control-label ewLabel"><?php echo $producto->idmarca->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->idmarca->CellAttributes() ?>>
<?php if ($producto->idmarca->getSessionValue() <> "") { ?>
<span id="el_producto_idmarca">
<span<?php echo $producto->idmarca->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $producto->idmarca->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idmarca" name="x_idmarca" value="<?php echo ew_HtmlEncode($producto->idmarca->CurrentValue) ?>">
<?php } else { ?>
<span id="el_producto_idmarca">
<select data-field="x_idmarca" id="x_idmarca" name="x_idmarca"<?php echo $producto->idmarca->EditAttributes() ?>>
<?php
if (is_array($producto->idmarca->EditValue)) {
	$arwrk = $producto->idmarca->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idmarca->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$producto->Lookup_Selecting($producto->idmarca, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idmarca" id="s_x_idmarca" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmarca` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $producto->idmarca->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_producto_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $producto->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->nombre->CellAttributes() ?>>
<span id="el_producto_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($producto->nombre->PlaceHolder) ?>" value="<?php echo $producto->nombre->EditValue ?>"<?php echo $producto->nombre->EditAttributes() ?>>
</span>
<?php echo $producto->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->idpais->Visible) { // idpais ?>
	<div id="r_idpais" class="form-group">
		<label id="elh_producto_idpais" for="x_idpais" class="col-sm-2 control-label ewLabel"><?php echo $producto->idpais->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->idpais->CellAttributes() ?>>
<span id="el_producto_idpais">
<select data-field="x_idpais" id="x_idpais" name="x_idpais"<?php echo $producto->idpais->EditAttributes() ?>>
<?php
if (is_array($producto->idpais->EditValue)) {
	$arwrk = $producto->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$producto->Lookup_Selecting($producto->idpais, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
?>
<input type="hidden" name="s_x_idpais" id="s_x_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php echo $producto->idpais->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_producto_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $producto->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->estado->CellAttributes() ?>>
<span id="el_producto_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $producto->estado->EditAttributes() ?>>
<?php
if (is_array($producto->estado->EditValue)) {
	$arwrk = $producto->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($producto->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php echo $producto->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->precio_venta->Visible) { // precio_venta ?>
	<div id="r_precio_venta" class="form-group">
		<label id="elh_producto_precio_venta" for="x_precio_venta" class="col-sm-2 control-label ewLabel"><?php echo $producto->precio_venta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->precio_venta->CellAttributes() ?>>
<span id="el_producto_precio_venta">
<input type="text" data-field="x_precio_venta" name="x_precio_venta" id="x_precio_venta" size="30" placeholder="<?php echo ew_HtmlEncode($producto->precio_venta->PlaceHolder) ?>" value="<?php echo $producto->precio_venta->EditValue ?>"<?php echo $producto->precio_venta->EditAttributes() ?>>
</span>
<?php echo $producto->precio_venta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($producto->precio_compra->Visible) { // precio_compra ?>
	<div id="r_precio_compra" class="form-group">
		<label id="elh_producto_precio_compra" for="x_precio_compra" class="col-sm-2 control-label ewLabel"><?php echo $producto->precio_compra->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $producto->precio_compra->CellAttributes() ?>>
<span id="el_producto_precio_compra">
<input type="text" data-field="x_precio_compra" name="x_precio_compra" id="x_precio_compra" size="30" placeholder="<?php echo ew_HtmlEncode($producto->precio_compra->PlaceHolder) ?>" value="<?php echo $producto->precio_compra->EditValue ?>"<?php echo $producto->precio_compra->EditAttributes() ?>>
</span>
<?php echo $producto->precio_compra->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_idproducto" name="x_idproducto" id="x_idproducto" value="<?php echo ew_HtmlEncode($producto->idproducto->CurrentValue) ?>">
<?php
	if (in_array("registro_sanitario", explode(",", $producto->getCurrentDetailTable())) && $registro_sanitario->DetailEdit) {
?>
<?php if ($producto->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("registro_sanitario", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "registro_sanitariogrid.php" ?>
<?php } ?>
<?php
	if (in_array("producto_bodega", explode(",", $producto->getCurrentDetailTable())) && $producto_bodega->DetailEdit) {
?>
<?php if ($producto->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("producto_bodega", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "producto_bodegagrid.php" ?>
<?php } ?>
<?php
	if (in_array("producto_sucursal", explode(",", $producto->getCurrentDetailTable())) && $producto_sucursal->DetailEdit) {
?>
<?php if ($producto->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("producto_sucursal", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "producto_sucursalgrid.php" ?>
<?php } ?>
<?php
	if (in_array("producto_precio_historial", explode(",", $producto->getCurrentDetailTable())) && $producto_precio_historial->DetailEdit) {
?>
<?php if ($producto->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("producto_precio_historial", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "producto_precio_historialgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fproductoedit.Init();
</script>
<?php
$producto_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$producto_edit->Page_Terminate();
?>
