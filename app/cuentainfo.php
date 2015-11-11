<?php

// Global variable for table object
$cuenta = NULL;

//
// Table class for cuenta
//
class ccuenta extends cTable {
	var $idcuenta;
	var $idbanco;
	var $idsucursal;
	var $numero;
	var $nombre;
	var $idmoneda;
	var $saldo;
	var $debito;
	var $credito;
	var $estado;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cuenta';
		$this->TableName = 'cuenta';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// idcuenta
		$this->idcuenta = new cField('cuenta', 'cuenta', 'x_idcuenta', 'idcuenta', '`idcuenta`', '`idcuenta`', 3, -1, FALSE, '`idcuenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idcuenta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcuenta'] = &$this->idcuenta;

		// idbanco
		$this->idbanco = new cField('cuenta', 'cuenta', 'x_idbanco', 'idbanco', '`idbanco`', '`idbanco`', 3, -1, FALSE, '`idbanco`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbanco->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbanco'] = &$this->idbanco;

		// idsucursal
		$this->idsucursal = new cField('cuenta', 'cuenta', 'x_idsucursal', 'idsucursal', '`idsucursal`', '`idsucursal`', 3, -1, FALSE, '`idsucursal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idsucursal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idsucursal'] = &$this->idsucursal;

		// numero
		$this->numero = new cField('cuenta', 'cuenta', 'x_numero', 'numero', '`numero`', '`numero`', 200, -1, FALSE, '`numero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['numero'] = &$this->numero;

		// nombre
		$this->nombre = new cField('cuenta', 'cuenta', 'x_nombre', 'nombre', '`nombre`', '`nombre`', 200, -1, FALSE, '`nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nombre'] = &$this->nombre;

		// idmoneda
		$this->idmoneda = new cField('cuenta', 'cuenta', 'x_idmoneda', 'idmoneda', '`idmoneda`', '`idmoneda`', 3, -1, FALSE, '`idmoneda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idmoneda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idmoneda'] = &$this->idmoneda;

		// saldo
		$this->saldo = new cField('cuenta', 'cuenta', 'x_saldo', 'saldo', '`saldo`', '`saldo`', 131, -1, FALSE, '`saldo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->saldo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['saldo'] = &$this->saldo;

		// debito
		$this->debito = new cField('cuenta', 'cuenta', 'x_debito', 'debito', '`debito`', '`debito`', 131, -1, FALSE, '`debito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->debito->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['debito'] = &$this->debito;

		// credito
		$this->credito = new cField('cuenta', 'cuenta', 'x_credito', 'credito', '`credito`', '`credito`', 131, -1, FALSE, '`credito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->credito->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['credito'] = &$this->credito;

		// estado
		$this->estado = new cField('cuenta', 'cuenta', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('cuenta', 'cuenta', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "banco") {
			if ($this->idbanco->getSessionValue() <> "")
				$sMasterFilter .= "`idbanco`=" . ew_QuotedValue($this->idbanco->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "banco") {
			if ($this->idbanco->getSessionValue() <> "")
				$sDetailFilter .= "`idbanco`=" . ew_QuotedValue($this->idbanco->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_banco() {
		return "`idbanco`=@idbanco@";
	}

	// Detail filter
	function SqlDetailFilter_banco() {
		return "`idbanco`=@idbanco@";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "cuenta_transaccion") {
			$sDetailUrl = $GLOBALS["cuenta_transaccion"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idcuenta=" . urlencode($this->idcuenta->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "boleta_deposito") {
			$sDetailUrl = $GLOBALS["boleta_deposito"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idcuenta=" . urlencode($this->idcuenta->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "voucher_tarjeta") {
			$sDetailUrl = $GLOBALS["voucher_tarjeta"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idcuenta=" . urlencode($this->idcuenta->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "cuentalist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cuenta`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`cuenta`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('idcuenta', $rs))
				ew_AddFilter($where, ew_QuotedName('idcuenta') . '=' . ew_QuotedValue($rs['idcuenta'], $this->idcuenta->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`idcuenta` = @idcuenta@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idcuenta->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idcuenta@", ew_AdjustSql($this->idcuenta->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "cuentalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cuentalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("cuentaview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("cuentaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "cuentaadd.php?" . $this->UrlParm($parm);
		else
			return "cuentaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("cuentaedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("cuentaedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("cuentaadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("cuentaadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cuentadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idcuenta->CurrentValue)) {
			$sUrl .= "idcuenta=" . urlencode($this->idcuenta->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["idcuenta"]; // idcuenta

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->idcuenta->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->idbanco->setDbValue($rs->fields('idbanco'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idmoneda->setDbValue($rs->fields('idmoneda'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idcuenta
		// idbanco
		// idsucursal
		// numero
		// nombre
		// idmoneda
		// saldo
		// debito
		// credito
		// estado
		// fecha_insercion
		// idcuenta

		$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
		$this->idcuenta->ViewCustomAttributes = "";

		// idbanco
		if (strval($this->idbanco->CurrentValue) <> "") {
			$sFilterWrk = "`idbanco`" . ew_SearchString("=", $this->idbanco->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idbanco, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idbanco->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idbanco->ViewValue = $this->idbanco->CurrentValue;
			}
		} else {
			$this->idbanco->ViewValue = NULL;
		}
		$this->idbanco->ViewCustomAttributes = "";

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

		// numero
		$this->numero->ViewValue = $this->numero->CurrentValue;
		$this->numero->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// idmoneda
		if (strval($this->idmoneda->CurrentValue) <> "") {
			$sFilterWrk = "`idmoneda`" . ew_SearchString("=", $this->idmoneda->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idmoneda`, `nombre` AS `DispFld`, `simbolo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `moneda`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idmoneda, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idmoneda->ViewValue = $rswrk->fields('DispFld');
				$this->idmoneda->ViewValue .= ew_ValueSeparator(1,$this->idmoneda) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->idmoneda->ViewValue = $this->idmoneda->CurrentValue;
			}
		} else {
			$this->idmoneda->ViewValue = NULL;
		}
		$this->idmoneda->ViewCustomAttributes = "";

		// saldo
		$this->saldo->ViewValue = $this->saldo->CurrentValue;
		$this->saldo->ViewValue = ew_FormatNumber($this->saldo->ViewValue, 2, -2, -2, -2);
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

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

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

		// numero
		$this->numero->LinkCustomAttributes = "";
		$this->numero->HrefValue = "";
		$this->numero->TooltipValue = "";

		// nombre
		$this->nombre->LinkCustomAttributes = "";
		$this->nombre->HrefValue = "";
		$this->nombre->TooltipValue = "";

		// idmoneda
		$this->idmoneda->LinkCustomAttributes = "";
		$this->idmoneda->HrefValue = "";
		$this->idmoneda->TooltipValue = "";

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

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idcuenta
		$this->idcuenta->EditAttrs["class"] = "form-control";
		$this->idcuenta->EditCustomAttributes = "";
		$this->idcuenta->EditValue = $this->idcuenta->CurrentValue;
		$this->idcuenta->ViewCustomAttributes = "";

		// idbanco
		$this->idbanco->EditAttrs["class"] = "form-control";
		$this->idbanco->EditCustomAttributes = "";
		if ($this->idbanco->getSessionValue() <> "") {
			$this->idbanco->CurrentValue = $this->idbanco->getSessionValue();
		if (strval($this->idbanco->CurrentValue) <> "") {
			$sFilterWrk = "`idbanco`" . ew_SearchString("=", $this->idbanco->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idbanco, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idbanco->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idbanco->ViewValue = $this->idbanco->CurrentValue;
			}
		} else {
			$this->idbanco->ViewValue = NULL;
		}
		$this->idbanco->ViewCustomAttributes = "";
		} else {
		}

		// idsucursal
		$this->idsucursal->EditAttrs["class"] = "form-control";
		$this->idsucursal->EditCustomAttributes = "";

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

		// idmoneda
		$this->idmoneda->EditAttrs["class"] = "form-control";
		$this->idmoneda->EditCustomAttributes = "";

		// saldo
		$this->saldo->EditAttrs["class"] = "form-control";
		$this->saldo->EditCustomAttributes = "";
		$this->saldo->EditValue = ew_HtmlEncode($this->saldo->CurrentValue);
		$this->saldo->PlaceHolder = ew_RemoveHtml($this->saldo->FldCaption());
		if (strval($this->saldo->EditValue) <> "" && is_numeric($this->saldo->EditValue)) $this->saldo->EditValue = ew_FormatNumber($this->saldo->EditValue, -2, -2, -2, -2);

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
		$this->fecha_insercion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_insercion->CurrentValue, 7));
		$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->idcuenta->Exportable) $Doc->ExportCaption($this->idcuenta);
					if ($this->idbanco->Exportable) $Doc->ExportCaption($this->idbanco);
					if ($this->idsucursal->Exportable) $Doc->ExportCaption($this->idsucursal);
					if ($this->numero->Exportable) $Doc->ExportCaption($this->numero);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->idmoneda->Exportable) $Doc->ExportCaption($this->idmoneda);
					if ($this->saldo->Exportable) $Doc->ExportCaption($this->saldo);
					if ($this->debito->Exportable) $Doc->ExportCaption($this->debito);
					if ($this->credito->Exportable) $Doc->ExportCaption($this->credito);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idcuenta->Exportable) $Doc->ExportCaption($this->idcuenta);
					if ($this->idbanco->Exportable) $Doc->ExportCaption($this->idbanco);
					if ($this->idsucursal->Exportable) $Doc->ExportCaption($this->idsucursal);
					if ($this->numero->Exportable) $Doc->ExportCaption($this->numero);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->idmoneda->Exportable) $Doc->ExportCaption($this->idmoneda);
					if ($this->saldo->Exportable) $Doc->ExportCaption($this->saldo);
					if ($this->debito->Exportable) $Doc->ExportCaption($this->debito);
					if ($this->credito->Exportable) $Doc->ExportCaption($this->credito);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->idcuenta->Exportable) $Doc->ExportField($this->idcuenta);
						if ($this->idbanco->Exportable) $Doc->ExportField($this->idbanco);
						if ($this->idsucursal->Exportable) $Doc->ExportField($this->idsucursal);
						if ($this->numero->Exportable) $Doc->ExportField($this->numero);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->idmoneda->Exportable) $Doc->ExportField($this->idmoneda);
						if ($this->saldo->Exportable) $Doc->ExportField($this->saldo);
						if ($this->debito->Exportable) $Doc->ExportField($this->debito);
						if ($this->credito->Exportable) $Doc->ExportField($this->credito);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idcuenta->Exportable) $Doc->ExportField($this->idcuenta);
						if ($this->idbanco->Exportable) $Doc->ExportField($this->idbanco);
						if ($this->idsucursal->Exportable) $Doc->ExportField($this->idsucursal);
						if ($this->numero->Exportable) $Doc->ExportField($this->numero);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->idmoneda->Exportable) $Doc->ExportField($this->idmoneda);
						if ($this->saldo->Exportable) $Doc->ExportField($this->saldo);
						if ($this->debito->Exportable) $Doc->ExportField($this->debito);
						if ($this->credito->Exportable) $Doc->ExportField($this->credito);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
