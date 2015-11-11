<?php

// Global variable for table object
$boleta_deposito = NULL;

//
// Table class for boleta_deposito
//
class cboleta_deposito extends cTable {
	var $idboleta_deposito;
	var $idbanco;
	var $idcuenta;
	var $numero;
	var $fecha;
	var $efectivo;
	var $cheque;
	var $cheque_otro;
	var $monto;
	var $descripcion;
	var $estado;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'boleta_deposito';
		$this->TableName = 'boleta_deposito';
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

		// idboleta_deposito
		$this->idboleta_deposito = new cField('boleta_deposito', 'boleta_deposito', 'x_idboleta_deposito', 'idboleta_deposito', '`idboleta_deposito`', '`idboleta_deposito`', 3, -1, FALSE, '`idboleta_deposito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idboleta_deposito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idboleta_deposito'] = &$this->idboleta_deposito;

		// idbanco
		$this->idbanco = new cField('boleta_deposito', 'boleta_deposito', 'x_idbanco', 'idbanco', '`idbanco`', '`idbanco`', 3, -1, FALSE, '`idbanco`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbanco->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbanco'] = &$this->idbanco;

		// idcuenta
		$this->idcuenta = new cField('boleta_deposito', 'boleta_deposito', 'x_idcuenta', 'idcuenta', '`idcuenta`', '`idcuenta`', 3, -1, FALSE, '`idcuenta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idcuenta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcuenta'] = &$this->idcuenta;

		// numero
		$this->numero = new cField('boleta_deposito', 'boleta_deposito', 'x_numero', 'numero', '`numero`', '`numero`', 200, -1, FALSE, '`numero`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['numero'] = &$this->numero;

		// fecha
		$this->fecha = new cField('boleta_deposito', 'boleta_deposito', 'x_fecha', 'fecha', '`fecha`', 'DATE_FORMAT(`fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;

		// efectivo
		$this->efectivo = new cField('boleta_deposito', 'boleta_deposito', 'x_efectivo', 'efectivo', '`efectivo`', '`efectivo`', 131, -1, FALSE, '`efectivo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->efectivo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['efectivo'] = &$this->efectivo;

		// cheque
		$this->cheque = new cField('boleta_deposito', 'boleta_deposito', 'x_cheque', 'cheque', '`cheque`', '`cheque`', 131, -1, FALSE, '`cheque`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->cheque->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['cheque'] = &$this->cheque;

		// cheque_otro
		$this->cheque_otro = new cField('boleta_deposito', 'boleta_deposito', 'x_cheque_otro', 'cheque_otro', '`cheque_otro`', '`cheque_otro`', 131, -1, FALSE, '`cheque_otro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->cheque_otro->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['cheque_otro'] = &$this->cheque_otro;

		// monto
		$this->monto = new cField('boleta_deposito', 'boleta_deposito', 'x_monto', 'monto', '`monto`', '`monto`', 131, -1, FALSE, '`monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto'] = &$this->monto;

		// descripcion
		$this->descripcion = new cField('boleta_deposito', 'boleta_deposito', 'x_descripcion', 'descripcion', '`descripcion`', '`descripcion`', 200, -1, FALSE, '`descripcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['descripcion'] = &$this->descripcion;

		// estado
		$this->estado = new cField('boleta_deposito', 'boleta_deposito', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('boleta_deposito', 'boleta_deposito', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentMasterTable() == "cuenta") {
			if ($this->idcuenta->getSessionValue() <> "")
				$sMasterFilter .= "`idcuenta`=" . ew_QuotedValue($this->idcuenta->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "cuenta") {
			if ($this->idcuenta->getSessionValue() <> "")
				$sDetailFilter .= "`idcuenta`=" . ew_QuotedValue($this->idcuenta->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_cuenta() {
		return "`idcuenta`=@idcuenta@";
	}

	// Detail filter
	function SqlDetailFilter_cuenta() {
		return "`idcuenta`=@idcuenta@";
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
		if ($this->getCurrentDetailTable() == "pago_cliente") {
			$sDetailUrl = $GLOBALS["pago_cliente"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idboleta_deposito=" . urlencode($this->idboleta_deposito->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "boleta_depositolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`boleta_deposito`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`idboleta_deposito` DESC";
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
	var $UpdateTable = "`boleta_deposito`";

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
			if (array_key_exists('idboleta_deposito', $rs))
				ew_AddFilter($where, ew_QuotedName('idboleta_deposito') . '=' . ew_QuotedValue($rs['idboleta_deposito'], $this->idboleta_deposito->FldDataType));
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
		return "`idboleta_deposito` = @idboleta_deposito@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idboleta_deposito->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idboleta_deposito@", ew_AdjustSql($this->idboleta_deposito->CurrentValue), $sKeyFilter); // Replace key value
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
			return "boleta_depositolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "boleta_depositolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("boleta_depositoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("boleta_depositoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "boleta_depositoadd.php?" . $this->UrlParm($parm);
		else
			return "boleta_depositoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("boleta_depositoedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("boleta_depositoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("boleta_depositoadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("boleta_depositoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("boleta_depositodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idboleta_deposito->CurrentValue)) {
			$sUrl .= "idboleta_deposito=" . urlencode($this->idboleta_deposito->CurrentValue);
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
			$arKeys[] = @$_GET["idboleta_deposito"]; // idboleta_deposito

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
			$this->idboleta_deposito->CurrentValue = $key;
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
		$this->idboleta_deposito->setDbValue($rs->fields('idboleta_deposito'));
		$this->idbanco->setDbValue($rs->fields('idbanco'));
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->efectivo->setDbValue($rs->fields('efectivo'));
		$this->cheque->setDbValue($rs->fields('cheque'));
		$this->cheque_otro->setDbValue($rs->fields('cheque_otro'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idboleta_deposito
		// idbanco
		// idcuenta
		// numero
		// fecha
		// efectivo
		// cheque
		// cheque_otro
		// monto
		// descripcion
		// estado
		// fecha_insercion
		// idboleta_deposito

		$this->idboleta_deposito->ViewValue = $this->idboleta_deposito->CurrentValue;
		$this->idboleta_deposito->ViewCustomAttributes = "";

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
		$sSqlWrk .= " ORDER BY `nombre`";
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

		// idcuenta
		if (strval($this->idcuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `numero`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcuenta->ViewValue = $rswrk->fields('DispFld');
				$this->idcuenta->ViewValue .= ew_ValueSeparator(1,$this->idcuenta) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
			}
		} else {
			$this->idcuenta->ViewValue = NULL;
		}
		$this->idcuenta->ViewCustomAttributes = "";

		// numero
		$this->numero->ViewValue = $this->numero->CurrentValue;
		$this->numero->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// efectivo
		$this->efectivo->ViewValue = $this->efectivo->CurrentValue;
		$this->efectivo->ViewCustomAttributes = "";

		// cheque
		$this->cheque->ViewValue = $this->cheque->CurrentValue;
		$this->cheque->ViewCustomAttributes = "";

		// cheque_otro
		$this->cheque_otro->ViewValue = $this->cheque_otro->CurrentValue;
		$this->cheque_otro->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// descripcion
		$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
		$this->descripcion->ViewCustomAttributes = "";

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

		// idboleta_deposito
		$this->idboleta_deposito->LinkCustomAttributes = "";
		$this->idboleta_deposito->HrefValue = "";
		$this->idboleta_deposito->TooltipValue = "";

		// idbanco
		$this->idbanco->LinkCustomAttributes = "";
		$this->idbanco->HrefValue = "";
		$this->idbanco->TooltipValue = "";

		// idcuenta
		$this->idcuenta->LinkCustomAttributes = "";
		$this->idcuenta->HrefValue = "";
		$this->idcuenta->TooltipValue = "";

		// numero
		$this->numero->LinkCustomAttributes = "";
		$this->numero->HrefValue = "";
		$this->numero->TooltipValue = "";

		// fecha
		$this->fecha->LinkCustomAttributes = "";
		$this->fecha->HrefValue = "";
		$this->fecha->TooltipValue = "";

		// efectivo
		$this->efectivo->LinkCustomAttributes = "";
		$this->efectivo->HrefValue = "";
		$this->efectivo->TooltipValue = "";

		// cheque
		$this->cheque->LinkCustomAttributes = "";
		$this->cheque->HrefValue = "";
		$this->cheque->TooltipValue = "";

		// cheque_otro
		$this->cheque_otro->LinkCustomAttributes = "";
		$this->cheque_otro->HrefValue = "";
		$this->cheque_otro->TooltipValue = "";

		// monto
		$this->monto->LinkCustomAttributes = "";
		$this->monto->HrefValue = "";
		$this->monto->TooltipValue = "";

		// descripcion
		$this->descripcion->LinkCustomAttributes = "";
		$this->descripcion->HrefValue = "";
		$this->descripcion->TooltipValue = "";

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

		// idboleta_deposito
		$this->idboleta_deposito->EditAttrs["class"] = "form-control";
		$this->idboleta_deposito->EditCustomAttributes = "";
		$this->idboleta_deposito->EditValue = $this->idboleta_deposito->CurrentValue;
		$this->idboleta_deposito->ViewCustomAttributes = "";

		// idbanco
		$this->idbanco->EditAttrs["class"] = "form-control";
		$this->idbanco->EditCustomAttributes = "";

		// idcuenta
		$this->idcuenta->EditAttrs["class"] = "form-control";
		$this->idcuenta->EditCustomAttributes = "";
		if ($this->idcuenta->getSessionValue() <> "") {
			$this->idcuenta->CurrentValue = $this->idcuenta->getSessionValue();
		if (strval($this->idcuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcuenta`, `numero` AS `DispFld`, `nombre` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `numero`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcuenta->ViewValue = $rswrk->fields('DispFld');
				$this->idcuenta->ViewValue .= ew_ValueSeparator(1,$this->idcuenta) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
			}
		} else {
			$this->idcuenta->ViewValue = NULL;
		}
		$this->idcuenta->ViewCustomAttributes = "";
		} else {
		}

		// numero
		$this->numero->EditAttrs["class"] = "form-control";
		$this->numero->EditCustomAttributes = "";
		$this->numero->EditValue = ew_HtmlEncode($this->numero->CurrentValue);
		$this->numero->PlaceHolder = ew_RemoveHtml($this->numero->FldCaption());

		// fecha
		$this->fecha->EditAttrs["class"] = "form-control";
		$this->fecha->EditCustomAttributes = "";
		$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
		$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

		// efectivo
		$this->efectivo->EditAttrs["class"] = "form-control";
		$this->efectivo->EditCustomAttributes = "";
		$this->efectivo->EditValue = ew_HtmlEncode($this->efectivo->CurrentValue);
		$this->efectivo->PlaceHolder = ew_RemoveHtml($this->efectivo->FldCaption());
		if (strval($this->efectivo->EditValue) <> "" && is_numeric($this->efectivo->EditValue)) $this->efectivo->EditValue = ew_FormatNumber($this->efectivo->EditValue, -2, -1, -2, 0);

		// cheque
		$this->cheque->EditAttrs["class"] = "form-control";
		$this->cheque->EditCustomAttributes = "";
		$this->cheque->EditValue = ew_HtmlEncode($this->cheque->CurrentValue);
		$this->cheque->PlaceHolder = ew_RemoveHtml($this->cheque->FldCaption());
		if (strval($this->cheque->EditValue) <> "" && is_numeric($this->cheque->EditValue)) $this->cheque->EditValue = ew_FormatNumber($this->cheque->EditValue, -2, -1, -2, 0);

		// cheque_otro
		$this->cheque_otro->EditAttrs["class"] = "form-control";
		$this->cheque_otro->EditCustomAttributes = "";
		$this->cheque_otro->EditValue = ew_HtmlEncode($this->cheque_otro->CurrentValue);
		$this->cheque_otro->PlaceHolder = ew_RemoveHtml($this->cheque_otro->FldCaption());
		if (strval($this->cheque_otro->EditValue) <> "" && is_numeric($this->cheque_otro->EditValue)) $this->cheque_otro->EditValue = ew_FormatNumber($this->cheque_otro->EditValue, -2, -1, -2, 0);

		// monto
		$this->monto->EditAttrs["class"] = "form-control";
		$this->monto->EditCustomAttributes = "";
		$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
		$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
		if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

		// descripcion
		$this->descripcion->EditAttrs["class"] = "form-control";
		$this->descripcion->EditCustomAttributes = "";
		$this->descripcion->EditValue = ew_HtmlEncode($this->descripcion->CurrentValue);
		$this->descripcion->PlaceHolder = ew_RemoveHtml($this->descripcion->FldCaption());

		// estado
		$this->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
		$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
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
					if ($this->idboleta_deposito->Exportable) $Doc->ExportCaption($this->idboleta_deposito);
					if ($this->idbanco->Exportable) $Doc->ExportCaption($this->idbanco);
					if ($this->idcuenta->Exportable) $Doc->ExportCaption($this->idcuenta);
					if ($this->numero->Exportable) $Doc->ExportCaption($this->numero);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->efectivo->Exportable) $Doc->ExportCaption($this->efectivo);
					if ($this->cheque->Exportable) $Doc->ExportCaption($this->cheque);
					if ($this->cheque_otro->Exportable) $Doc->ExportCaption($this->cheque_otro);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idboleta_deposito->Exportable) $Doc->ExportCaption($this->idboleta_deposito);
					if ($this->idbanco->Exportable) $Doc->ExportCaption($this->idbanco);
					if ($this->idcuenta->Exportable) $Doc->ExportCaption($this->idcuenta);
					if ($this->numero->Exportable) $Doc->ExportCaption($this->numero);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->efectivo->Exportable) $Doc->ExportCaption($this->efectivo);
					if ($this->cheque->Exportable) $Doc->ExportCaption($this->cheque);
					if ($this->cheque_otro->Exportable) $Doc->ExportCaption($this->cheque_otro);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
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
						if ($this->idboleta_deposito->Exportable) $Doc->ExportField($this->idboleta_deposito);
						if ($this->idbanco->Exportable) $Doc->ExportField($this->idbanco);
						if ($this->idcuenta->Exportable) $Doc->ExportField($this->idcuenta);
						if ($this->numero->Exportable) $Doc->ExportField($this->numero);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->efectivo->Exportable) $Doc->ExportField($this->efectivo);
						if ($this->cheque->Exportable) $Doc->ExportField($this->cheque);
						if ($this->cheque_otro->Exportable) $Doc->ExportField($this->cheque_otro);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idboleta_deposito->Exportable) $Doc->ExportField($this->idboleta_deposito);
						if ($this->idbanco->Exportable) $Doc->ExportField($this->idbanco);
						if ($this->idcuenta->Exportable) $Doc->ExportField($this->idcuenta);
						if ($this->numero->Exportable) $Doc->ExportField($this->numero);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->efectivo->Exportable) $Doc->ExportField($this->efectivo);
						if ($this->cheque->Exportable) $Doc->ExportField($this->cheque);
						if ($this->cheque_otro->Exportable) $Doc->ExportField($this->cheque_otro);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
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
