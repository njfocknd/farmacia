<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "proveedorinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$proveedor_delete = NULL; // Initialize page object first

class cproveedor_delete extends cproveedor {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Table name
	var $TableName = 'proveedor';

	// Page object name
	var $PageObjName = 'proveedor_delete';

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

		// Table object (proveedor)
		if (!isset($GLOBALS["proveedor"]) || get_class($GLOBALS["proveedor"]) == "cproveedor") {
			$GLOBALS["proveedor"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["proveedor"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'proveedor', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idproveedor->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $proveedor;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($proveedor);
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("proveedorlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in proveedor class, proveedorinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		$this->idproveedor->setDbValue($rs->fields('idproveedor'));
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->codigo->setDbValue($rs->fields('codigo'));
		$this->nit->setDbValue($rs->fields('nit'));
		$this->nombre_factura->setDbValue($rs->fields('nombre_factura'));
		$this->direccion_factura->setDbValue($rs->fields('direccion_factura'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->proveedorcol->setDbValue($rs->fields('proveedorcol'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idproveedor->DbValue = $row['idproveedor'];
		$this->idpersona->DbValue = $row['idpersona'];
		$this->codigo->DbValue = $row['codigo'];
		$this->nit->DbValue = $row['nit'];
		$this->nombre_factura->DbValue = $row['nombre_factura'];
		$this->direccion_factura->DbValue = $row['direccion_factura'];
		$this->debito->DbValue = $row['debito'];
		$this->credito->DbValue = $row['credito'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->_email->DbValue = $row['email'];
		$this->estado->DbValue = $row['estado'];
		$this->proveedorcol->DbValue = $row['proveedorcol'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->debito->FormValue == $this->debito->CurrentValue && is_numeric(ew_StrToFloat($this->debito->CurrentValue)))
			$this->debito->CurrentValue = ew_StrToFloat($this->debito->CurrentValue);

		// Convert decimal values if posted back
		if ($this->credito->FormValue == $this->credito->CurrentValue && is_numeric(ew_StrToFloat($this->credito->CurrentValue)))
			$this->credito->CurrentValue = ew_StrToFloat($this->credito->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idproveedor
		// idpersona
		// codigo
		// nit
		// nombre_factura
		// direccion_factura
		// debito
		// credito
		// fecha_insercion
		// email
		// estado
		// proveedorcol

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idproveedor
			$this->idproveedor->ViewValue = $this->idproveedor->CurrentValue;
			$this->idproveedor->ViewCustomAttributes = "";

			// idpersona
			$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			$this->idpersona->ViewCustomAttributes = "";

			// codigo
			$this->codigo->ViewValue = $this->codigo->CurrentValue;
			$this->codigo->ViewCustomAttributes = "";

			// nit
			$this->nit->ViewValue = $this->nit->CurrentValue;
			$this->nit->ViewCustomAttributes = "";

			// nombre_factura
			$this->nombre_factura->ViewValue = $this->nombre_factura->CurrentValue;
			$this->nombre_factura->ViewCustomAttributes = "";

			// direccion_factura
			$this->direccion_factura->ViewValue = $this->direccion_factura->CurrentValue;
			$this->direccion_factura->ViewCustomAttributes = "";

			// debito
			$this->debito->ViewValue = $this->debito->CurrentValue;
			$this->debito->ViewCustomAttributes = "";

			// credito
			$this->credito->ViewValue = $this->credito->CurrentValue;
			$this->credito->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

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

			// proveedorcol
			$this->proveedorcol->ViewValue = $this->proveedorcol->CurrentValue;
			$this->proveedorcol->ViewCustomAttributes = "";

			// idproveedor
			$this->idproveedor->LinkCustomAttributes = "";
			$this->idproveedor->HrefValue = "";
			$this->idproveedor->TooltipValue = "";

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";
			$this->idpersona->TooltipValue = "";

			// codigo
			$this->codigo->LinkCustomAttributes = "";
			$this->codigo->HrefValue = "";
			$this->codigo->TooltipValue = "";

			// nit
			$this->nit->LinkCustomAttributes = "";
			$this->nit->HrefValue = "";
			$this->nit->TooltipValue = "";

			// nombre_factura
			$this->nombre_factura->LinkCustomAttributes = "";
			$this->nombre_factura->HrefValue = "";
			$this->nombre_factura->TooltipValue = "";

			// direccion_factura
			$this->direccion_factura->LinkCustomAttributes = "";
			$this->direccion_factura->HrefValue = "";
			$this->direccion_factura->TooltipValue = "";

			// debito
			$this->debito->LinkCustomAttributes = "";
			$this->debito->HrefValue = "";
			$this->debito->TooltipValue = "";

			// credito
			$this->credito->LinkCustomAttributes = "";
			$this->credito->HrefValue = "";
			$this->credito->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// proveedorcol
			$this->proveedorcol->LinkCustomAttributes = "";
			$this->proveedorcol->HrefValue = "";
			$this->proveedorcol->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
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
		$conn->BeginTrans();

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
				$sThisKey .= $row['idproveedor'];
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
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "proveedorlist.php", "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, ew_CurrentUrl());
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($proveedor_delete)) $proveedor_delete = new cproveedor_delete();

// Page init
$proveedor_delete->Page_Init();

// Page main
$proveedor_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$proveedor_delete->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var proveedor_delete = new ew_Page("proveedor_delete");
proveedor_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = proveedor_delete.PageID; // For backward compatibility

// Form object
var fproveedordelete = new ew_Form("fproveedordelete");

// Form_CustomValidate event
fproveedordelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproveedordelete.ValidateRequired = true;
<?php } else { ?>
fproveedordelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($proveedor_delete->Recordset = $proveedor_delete->LoadRecordset())
	$proveedor_deleteTotalRecs = $proveedor_delete->Recordset->RecordCount(); // Get record count
if ($proveedor_deleteTotalRecs <= 0) { // No record found, exit
	if ($proveedor_delete->Recordset)
		$proveedor_delete->Recordset->Close();
	$proveedor_delete->Page_Terminate("proveedorlist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $proveedor_delete->ShowPageHeader(); ?>
<?php
$proveedor_delete->ShowMessage();
?>
<form name="fproveedordelete" id="fproveedordelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($proveedor_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $proveedor_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="proveedor">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($proveedor_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $proveedor->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($proveedor->idproveedor->Visible) { // idproveedor ?>
		<th><span id="elh_proveedor_idproveedor" class="proveedor_idproveedor"><?php echo $proveedor->idproveedor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
		<th><span id="elh_proveedor_idpersona" class="proveedor_idpersona"><?php echo $proveedor->idpersona->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->codigo->Visible) { // codigo ?>
		<th><span id="elh_proveedor_codigo" class="proveedor_codigo"><?php echo $proveedor->codigo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->nit->Visible) { // nit ?>
		<th><span id="elh_proveedor_nit" class="proveedor_nit"><?php echo $proveedor->nit->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
		<th><span id="elh_proveedor_nombre_factura" class="proveedor_nombre_factura"><?php echo $proveedor->nombre_factura->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
		<th><span id="elh_proveedor_direccion_factura" class="proveedor_direccion_factura"><?php echo $proveedor->direccion_factura->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->debito->Visible) { // debito ?>
		<th><span id="elh_proveedor_debito" class="proveedor_debito"><?php echo $proveedor->debito->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->credito->Visible) { // credito ?>
		<th><span id="elh_proveedor_credito" class="proveedor_credito"><?php echo $proveedor->credito->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->fecha_insercion->Visible) { // fecha_insercion ?>
		<th><span id="elh_proveedor_fecha_insercion" class="proveedor_fecha_insercion"><?php echo $proveedor->fecha_insercion->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->_email->Visible) { // email ?>
		<th><span id="elh_proveedor__email" class="proveedor__email"><?php echo $proveedor->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->estado->Visible) { // estado ?>
		<th><span id="elh_proveedor_estado" class="proveedor_estado"><?php echo $proveedor->estado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($proveedor->proveedorcol->Visible) { // proveedorcol ?>
		<th><span id="elh_proveedor_proveedorcol" class="proveedor_proveedorcol"><?php echo $proveedor->proveedorcol->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$proveedor_delete->RecCnt = 0;
$i = 0;
while (!$proveedor_delete->Recordset->EOF) {
	$proveedor_delete->RecCnt++;
	$proveedor_delete->RowCnt++;

	// Set row properties
	$proveedor->ResetAttrs();
	$proveedor->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$proveedor_delete->LoadRowValues($proveedor_delete->Recordset);

	// Render row
	$proveedor_delete->RenderRow();
?>
	<tr<?php echo $proveedor->RowAttributes() ?>>
<?php if ($proveedor->idproveedor->Visible) { // idproveedor ?>
		<td<?php echo $proveedor->idproveedor->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_idproveedor" class="form-group proveedor_idproveedor">
<span<?php echo $proveedor->idproveedor->ViewAttributes() ?>>
<?php echo $proveedor->idproveedor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
		<td<?php echo $proveedor->idpersona->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_idpersona" class="form-group proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<?php echo $proveedor->idpersona->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->codigo->Visible) { // codigo ?>
		<td<?php echo $proveedor->codigo->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_codigo" class="form-group proveedor_codigo">
<span<?php echo $proveedor->codigo->ViewAttributes() ?>>
<?php echo $proveedor->codigo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->nit->Visible) { // nit ?>
		<td<?php echo $proveedor->nit->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_nit" class="form-group proveedor_nit">
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<?php echo $proveedor->nit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->nombre_factura->Visible) { // nombre_factura ?>
		<td<?php echo $proveedor->nombre_factura->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_nombre_factura" class="form-group proveedor_nombre_factura">
<span<?php echo $proveedor->nombre_factura->ViewAttributes() ?>>
<?php echo $proveedor->nombre_factura->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->direccion_factura->Visible) { // direccion_factura ?>
		<td<?php echo $proveedor->direccion_factura->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_direccion_factura" class="form-group proveedor_direccion_factura">
<span<?php echo $proveedor->direccion_factura->ViewAttributes() ?>>
<?php echo $proveedor->direccion_factura->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->debito->Visible) { // debito ?>
		<td<?php echo $proveedor->debito->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_debito" class="form-group proveedor_debito">
<span<?php echo $proveedor->debito->ViewAttributes() ?>>
<?php echo $proveedor->debito->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->credito->Visible) { // credito ?>
		<td<?php echo $proveedor->credito->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_credito" class="form-group proveedor_credito">
<span<?php echo $proveedor->credito->ViewAttributes() ?>>
<?php echo $proveedor->credito->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->fecha_insercion->Visible) { // fecha_insercion ?>
		<td<?php echo $proveedor->fecha_insercion->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_fecha_insercion" class="form-group proveedor_fecha_insercion">
<span<?php echo $proveedor->fecha_insercion->ViewAttributes() ?>>
<?php echo $proveedor->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->_email->Visible) { // email ?>
		<td<?php echo $proveedor->_email->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor__email" class="form-group proveedor__email">
<span<?php echo $proveedor->_email->ViewAttributes() ?>>
<?php echo $proveedor->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->estado->Visible) { // estado ?>
		<td<?php echo $proveedor->estado->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_estado" class="form-group proveedor_estado">
<span<?php echo $proveedor->estado->ViewAttributes() ?>>
<?php echo $proveedor->estado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($proveedor->proveedorcol->Visible) { // proveedorcol ?>
		<td<?php echo $proveedor->proveedorcol->CellAttributes() ?>>
<span id="el<?php echo $proveedor_delete->RowCnt ?>_proveedor_proveedorcol" class="form-group proveedor_proveedorcol">
<span<?php echo $proveedor->proveedorcol->ViewAttributes() ?>>
<?php echo $proveedor->proveedorcol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$proveedor_delete->Recordset->MoveNext();
}
$proveedor_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fproveedordelete.Init();
</script>
<?php
$proveedor_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$proveedor_delete->Page_Terminate();
?>
