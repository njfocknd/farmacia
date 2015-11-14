<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$nexthor_transaction_php = NULL; // Initialize page object first

class cnexthor_transaction_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = "{1A346828-9C43-47DA-9AFE-A30923F5B814}";

	// Table name
	var $TableName = 'nexthor_transaction.php';

	// Page object name
	var $PageObjName = 'nexthor_transaction_php';

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

		// User table object (user)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'nexthor_transaction.php', TRUE);

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
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

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

		// Export
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb();
		$url = ew_CurrentUrl();
		$Breadcrumb->Add("custom", "nexthor_transaction_php", $url, "", "nexthor_transaction_php", TRUE);
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($nexthor_transaction_php)) $nexthor_transaction_php = new cnexthor_transaction_php();

// Page init
$nexthor_transaction_php->Page_Init();

// Page main
$nexthor_transaction_php->Page_Main();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<?php if (!@$gbSkipHeaderFooter) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transacciones</title>
<meta name="generator" content="PHPMaker v11.0.3">
</head>
<?php 
include "nexthor_header.php";   
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$query="select box_id id, name from box a where state = 'Enable';";
$box_id = "<form class='form-horizontal' role='form'><div class='form-group'><label for='box_id' >Caja</label>".fncDesignCombo($MyOps, $query,'box_id','class="form-control"','','',0, 'Caja')."</div></form>";
date_default_timezone_set("America/Guatemala");
$hoy = date (Ymd);
$first_date = date("01/m/Y", strtotime("$hoy -0 day"));
$end_date = date("t/m/Y", strtotime("$hoy +0 day"));	
?>
<script type="text/javascript" src="nexthor/my_js/nexthor_transaction.js"></script>
<body>
	<form name="nexthor" id="nexthor" >
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="container show-top-margin separate-rows tall-rows">
					<div class="row show-grid">
						<div class="col-xs-12 col-sm-3"><?php echo $box_id;?></div>
						<div class="col-xs-12 col-sm-3">
							<div id='div_first_date'>
								<label for="first_date" >Fecha Inicio</label>	
								<input type="text" name="first_date" id="first_date" value="<?php echo $first_date;?>" class="form-control">
								<script type="text/javascript">ew_CreateCalendar("nexthor", "first_date", "%d/%m/%Y");</script>
							</div>
						</div>
						<div class="col-xs-12 col-sm-3">
							<div id='div_end_date'>
								<label for="end_date" >Fecha Fin</label>	
								<input type="text" name="end_date" id="end_date" value="<?php echo $end_date;?>" class="form-control">
								<script type="text/javascript">ew_CreateCalendar("nexthor", "end_date", "%d/%m/%Y");</script>
							</div>
						</div><div class="col-xs-12 col-sm-3" align="center"><br/>
							<div class="btn-toolbar" role="toolbar">
								<div class="btn-group btn-group-lg">
									<button type="button" class="btn btn-default" onclick = "fncNewTransaction('Credit');">
									  <span class="glyphicon glyphicon-plus-sign"></span>
									</button>
									<button type="button" class="btn btn-default" onclick = "fncNewTransaction('Transfer');">
									  <span class="glyphicon glyphicon-random"></span>
									</button>
									<button type="button" class="btn btn-default" onclick = "fncNewTransaction('Debit');">
									  <span class="glyphicon glyphicon-minus-sign"></span>
									</button>
									<button type="button" class="btn btn-default" onclick = "fncViewTransactionTable(1);">
									  <span class="glyphicon glyphicon-list-alt"></span>
									</button>
									<button type="button" class="btn btn-default" onclick = "fncViewTransactionTable(4);">
									  <span class="glyphicon glyphicon-list"></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="container show-top-margin separate-rows tall-rows">
					<div class="row show-grid">
						<div class="col-xs-12 col-sm-12"><div id='div_msg' ></div><div id='div_table' ></div></div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="container show-top-margin separate-rows tall-rows">
					<div class="row show-grid">
						<div class="col-xs-12 col-sm-12"><div id='div_button' ></div></div>
					</div>
				</div></div>
		</div>
	</form>
</body>
<SCRIPT LANGUAGE="JavaScript">fncViewTransactionTable(1);</SCRIPT>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$nexthor_transaction_php->Page_Terminate();
?>
