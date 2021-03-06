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

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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

		// User table object (usuario)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuario();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

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

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadUserLevel(); // Load User Level
		if ($Security->AllowList(CurrentProjectID() . 'departamento'))
		$this->Page_Terminate("departamentolist.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . 'empresa'))
			$this->Page_Terminate("empresalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'fabricante'))
			$this->Page_Terminate("fabricantelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'marca'))
			$this->Page_Terminate("marcalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'municipio'))
			$this->Page_Terminate("municipiolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pais'))
			$this->Page_Terminate("paislist.php");
		if ($Security->AllowList(CurrentProjectID() . 'producto'))
			$this->Page_Terminate("productolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'registro_sanitario'))
			$this->Page_Terminate("registro_sanitariolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'sucursal'))
			$this->Page_Terminate("sucursallist.php");
		if ($Security->AllowList(CurrentProjectID() . 'bodega'))
			$this->Page_Terminate("bodegalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_bodega'))
			$this->Page_Terminate("tipo_bodegalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'producto_bodega'))
			$this->Page_Terminate("producto_bodegalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'producto_sucursal'))
			$this->Page_Terminate("producto_sucursallist.php");
		if ($Security->AllowList(CurrentProjectID() . 'producto_historial'))
			$this->Page_Terminate("producto_historiallist.php");
		if ($Security->AllowList(CurrentProjectID() . 'documento_debito'))
			$this->Page_Terminate("documento_debitolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'serie_documento'))
			$this->Page_Terminate("serie_documentolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_documento'))
			$this->Page_Terminate("tipo_documentolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detalle_documento_debito'))
			$this->Page_Terminate("detalle_documento_debitolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'documento_credito'))
			$this->Page_Terminate("documento_creditolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detalle_documento_credito'))
			$this->Page_Terminate("detalle_documento_creditolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detalle_documento_movimiento'))
			$this->Page_Terminate("detalle_documento_movimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'documento_movimiento'))
			$this->Page_Terminate("documento_movimientolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cliente'))
			$this->Page_Terminate("clientelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pago_cliente'))
			$this->Page_Terminate("pago_clientelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pago_proveedor'))
			$this->Page_Terminate("pago_proveedorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'persona'))
			$this->Page_Terminate("personalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'proveedor'))
			$this->Page_Terminate("proveedorlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'banco'))
			$this->Page_Terminate("bancolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cuenta'))
			$this->Page_Terminate("cuentalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'moneda'))
			$this->Page_Terminate("monedalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cuenta_transaccion'))
			$this->Page_Terminate("cuenta_transaccionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'usuario'))
			$this->Page_Terminate("usuariolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'userlevels'))
			$this->Page_Terminate("userlevelslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'audittrail'))
			$this->Page_Terminate("audittraillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'categoria'))
			$this->Page_Terminate("categorialist.php");
		if ($Security->AllowList(CurrentProjectID() . 'boleta_deposito'))
			$this->Page_Terminate("boleta_depositolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'voucher_tarjeta'))
			$this->Page_Terminate("voucher_tarjetalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tipo_pago'))
			$this->Page_Terminate("tipo_pagolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'cheque_cliente'))
			$this->Page_Terminate("cheque_clientelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'producto_precio_historial'))
			$this->Page_Terminate("producto_precio_historiallist.php");
		if ($Security->AllowList(CurrentProjectID() . 'fecha_contable'))
			$this->Page_Terminate("fecha_contablelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'meta'))
			$this->Page_Terminate("metalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'parametros_sistema'))
			$this->Page_Terminate("parametros_sistemalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'periodo_contable'))
			$this->Page_Terminate("periodo_contablelist.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage($Language->Phrase("NoPermission") . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$default->Page_Terminate();
?>
