<?php

// Global variable for table object
$pago_cliente = NULL;

//
// Table class for pago_cliente
//
class cpago_cliente extends cTable {
	var $idpago_cliente;
	var $idtipo_pago;
	var $idcliente;
	var $monto;
	var $fecha;
	var $estado;
	var $fecha_insercion;
	var $idsucursal;
	var $idboleta_deposito;
	var $idvoucher_tarjeta;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pago_cliente';
		$this->TableName = 'pago_cliente';
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

		// idpago_cliente
		$this->idpago_cliente = new cField('pago_cliente', 'pago_cliente', 'x_idpago_cliente', 'idpago_cliente', '`idpago_cliente`', '`idpago_cliente`', 3, -1, FALSE, '`idpago_cliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idpago_cliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idpago_cliente'] = &$this->idpago_cliente;

		// idtipo_pago
		$this->idtipo_pago = new cField('pago_cliente', 'pago_cliente', 'x_idtipo_pago', 'idtipo_pago', '`idtipo_pago`', '`idtipo_pago`', 3, -1, FALSE, '`idtipo_pago`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idtipo_pago->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idtipo_pago'] = &$this->idtipo_pago;

		// idcliente
		$this->idcliente = new cField('pago_cliente', 'pago_cliente', 'x_idcliente', 'idcliente', '`idcliente`', '`idcliente`', 3, -1, FALSE, '`idcliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idcliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcliente'] = &$this->idcliente;

		// monto
		$this->monto = new cField('pago_cliente', 'pago_cliente', 'x_monto', 'monto', '`monto`', '`monto`', 131, -1, FALSE, '`monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto'] = &$this->monto;

		// fecha
		$this->fecha = new cField('pago_cliente', 'pago_cliente', 'x_fecha', 'fecha', '`fecha`', 'DATE_FORMAT(`fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;

		// estado
		$this->estado = new cField('pago_cliente', 'pago_cliente', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('pago_cliente', 'pago_cliente', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// idsucursal
		$this->idsucursal = new cField('pago_cliente', 'pago_cliente', 'x_idsucursal', 'idsucursal', '`idsucursal`', '`idsucursal`', 3, -1, FALSE, '`idsucursal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idsucursal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idsucursal'] = &$this->idsucursal;

		// idboleta_deposito
		$this->idboleta_deposito = new cField('pago_cliente', 'pago_cliente', 'x_idboleta_deposito', 'idboleta_deposito', '`idboleta_deposito`', '`idboleta_deposito`', 3, -1, FALSE, '`idboleta_deposito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idboleta_deposito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idboleta_deposito'] = &$this->idboleta_deposito;

		// idvoucher_tarjeta
		$this->idvoucher_tarjeta = new cField('pago_cliente', 'pago_cliente', 'x_idvoucher_tarjeta', 'idvoucher_tarjeta', '`idvoucher_tarjeta`', '`idvoucher_tarjeta`', 3, -1, FALSE, '`idvoucher_tarjeta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idvoucher_tarjeta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idvoucher_tarjeta'] = &$this->idvoucher_tarjeta;
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
		if ($this->getCurrentMasterTable() == "cliente") {
			if ($this->idcliente->getSessionValue() <> "")
				$sMasterFilter .= "`idcliente`=" . ew_QuotedValue($this->idcliente->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "tipo_pago") {
			if ($this->idtipo_pago->getSessionValue() <> "")
				$sMasterFilter .= "`idtipo_pago`=" . ew_QuotedValue($this->idtipo_pago->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "boleta_deposito") {
			if ($this->idboleta_deposito->getSessionValue() <> "")
				$sMasterFilter .= "`idboleta_deposito`=" . ew_QuotedValue($this->idboleta_deposito->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "voucher_tarjeta") {
			if ($this->idvoucher_tarjeta->getSessionValue() <> "")
				$sMasterFilter .= "`idvoucher_tarjeta`=" . ew_QuotedValue($this->idvoucher_tarjeta->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "cliente") {
			if ($this->idcliente->getSessionValue() <> "")
				$sDetailFilter .= "`idcliente`=" . ew_QuotedValue($this->idcliente->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "tipo_pago") {
			if ($this->idtipo_pago->getSessionValue() <> "")
				$sDetailFilter .= "`idtipo_pago`=" . ew_QuotedValue($this->idtipo_pago->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "boleta_deposito") {
			if ($this->idboleta_deposito->getSessionValue() <> "")
				$sDetailFilter .= "`idboleta_deposito`=" . ew_QuotedValue($this->idboleta_deposito->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "voucher_tarjeta") {
			if ($this->idvoucher_tarjeta->getSessionValue() <> "")
				$sDetailFilter .= "`idvoucher_tarjeta`=" . ew_QuotedValue($this->idvoucher_tarjeta->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_cliente() {
		return "`idcliente`=@idcliente@";
	}

	// Detail filter
	function SqlDetailFilter_cliente() {
		return "`idcliente`=@idcliente@";
	}

	// Master filter
	function SqlMasterFilter_tipo_pago() {
		return "`idtipo_pago`=@idtipo_pago@";
	}

	// Detail filter
	function SqlDetailFilter_tipo_pago() {
		return "`idtipo_pago`=@idtipo_pago@";
	}

	// Master filter
	function SqlMasterFilter_boleta_deposito() {
		return "`idboleta_deposito`=@idboleta_deposito@";
	}

	// Detail filter
	function SqlDetailFilter_boleta_deposito() {
		return "`idboleta_deposito`=@idboleta_deposito@";
	}

	// Master filter
	function SqlMasterFilter_voucher_tarjeta() {
		return "`idvoucher_tarjeta`=@idvoucher_tarjeta@";
	}

	// Detail filter
	function SqlDetailFilter_voucher_tarjeta() {
		return "`idvoucher_tarjeta`=@idvoucher_tarjeta@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pago_cliente`";
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
	var $UpdateTable = "`pago_cliente`";

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
			if (array_key_exists('idpago_cliente', $rs))
				ew_AddFilter($where, ew_QuotedName('idpago_cliente') . '=' . ew_QuotedValue($rs['idpago_cliente'], $this->idpago_cliente->FldDataType));
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
		return "`idpago_cliente` = @idpago_cliente@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idpago_cliente->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idpago_cliente@", ew_AdjustSql($this->idpago_cliente->CurrentValue), $sKeyFilter); // Replace key value
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
			return "pago_clientelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pago_clientelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("pago_clienteview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("pago_clienteview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "pago_clienteadd.php?" . $this->UrlParm($parm);
		else
			return "pago_clienteadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("pago_clienteedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("pago_clienteadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pago_clientedelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idpago_cliente->CurrentValue)) {
			$sUrl .= "idpago_cliente=" . urlencode($this->idpago_cliente->CurrentValue);
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
			$arKeys[] = @$_GET["idpago_cliente"]; // idpago_cliente

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
			$this->idpago_cliente->CurrentValue = $key;
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
		$this->idpago_cliente->setDbValue($rs->fields('idpago_cliente'));
		$this->idtipo_pago->setDbValue($rs->fields('idtipo_pago'));
		$this->idcliente->setDbValue($rs->fields('idcliente'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->idboleta_deposito->setDbValue($rs->fields('idboleta_deposito'));
		$this->idvoucher_tarjeta->setDbValue($rs->fields('idvoucher_tarjeta'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idpago_cliente
		// idtipo_pago
		// idcliente
		// monto
		// fecha
		// estado
		// fecha_insercion
		// idsucursal
		// idboleta_deposito
		// idvoucher_tarjeta
		// idpago_cliente

		$this->idpago_cliente->ViewValue = $this->idpago_cliente->CurrentValue;
		$this->idpago_cliente->ViewCustomAttributes = "";

		// idtipo_pago
		if (strval($this->idtipo_pago->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_pago`" . ew_SearchString("=", $this->idtipo_pago->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_pago`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idtipo_pago, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idtipo_pago->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idtipo_pago->ViewValue = $this->idtipo_pago->CurrentValue;
			}
		} else {
			$this->idtipo_pago->ViewValue = NULL;
		}
		$this->idtipo_pago->ViewCustomAttributes = "";

		// idcliente
		if (strval($this->idcliente->CurrentValue) <> "") {
			$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcliente, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `codigo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcliente->ViewValue = $rswrk->fields('DispFld');
				$this->idcliente->ViewValue .= ew_ValueSeparator(1,$this->idcliente) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
			}
		} else {
			$this->idcliente->ViewValue = NULL;
		}
		$this->idcliente->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -2, 0, -1);
		$this->monto->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

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

		// idboleta_deposito
		if (strval($this->idboleta_deposito->CurrentValue) <> "") {
			$sFilterWrk = "`idboleta_deposito`" . ew_SearchString("=", $this->idboleta_deposito->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idboleta_deposito`, `numero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `boleta_deposito`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idboleta_deposito, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `numero`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idboleta_deposito->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idboleta_deposito->ViewValue = $this->idboleta_deposito->CurrentValue;
			}
		} else {
			$this->idboleta_deposito->ViewValue = NULL;
		}
		$this->idboleta_deposito->ViewCustomAttributes = "";

		// idvoucher_tarjeta
		if (strval($this->idvoucher_tarjeta->CurrentValue) <> "") {
			$sFilterWrk = "`idvoucher_tarjeta`" . ew_SearchString("=", $this->idvoucher_tarjeta->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idvoucher_tarjeta`, `marca` AS `DispFld`, `marca` AS `Disp2Fld`, `ultimos_cuatro_digitos` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `voucher_tarjeta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idvoucher_tarjeta, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idvoucher_tarjeta->ViewValue = $rswrk->fields('DispFld');
				$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(1,$this->idvoucher_tarjeta) . $rswrk->fields('Disp2Fld');
				$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(2,$this->idvoucher_tarjeta) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->idvoucher_tarjeta->ViewValue = $this->idvoucher_tarjeta->CurrentValue;
			}
		} else {
			$this->idvoucher_tarjeta->ViewValue = NULL;
		}
		$this->idvoucher_tarjeta->ViewCustomAttributes = "";

		// idpago_cliente
		$this->idpago_cliente->LinkCustomAttributes = "";
		$this->idpago_cliente->HrefValue = "";
		$this->idpago_cliente->TooltipValue = "";

		// idtipo_pago
		$this->idtipo_pago->LinkCustomAttributes = "";
		$this->idtipo_pago->HrefValue = "";
		$this->idtipo_pago->TooltipValue = "";

		// idcliente
		$this->idcliente->LinkCustomAttributes = "";
		$this->idcliente->HrefValue = "";
		$this->idcliente->TooltipValue = "";

		// monto
		$this->monto->LinkCustomAttributes = "";
		$this->monto->HrefValue = "";
		$this->monto->TooltipValue = "";

		// fecha
		$this->fecha->LinkCustomAttributes = "";
		$this->fecha->HrefValue = "";
		$this->fecha->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// idsucursal
		$this->idsucursal->LinkCustomAttributes = "";
		$this->idsucursal->HrefValue = "";
		$this->idsucursal->TooltipValue = "";

		// idboleta_deposito
		$this->idboleta_deposito->LinkCustomAttributes = "";
		$this->idboleta_deposito->HrefValue = "";
		$this->idboleta_deposito->TooltipValue = "";

		// idvoucher_tarjeta
		$this->idvoucher_tarjeta->LinkCustomAttributes = "";
		$this->idvoucher_tarjeta->HrefValue = "";
		$this->idvoucher_tarjeta->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idpago_cliente
		$this->idpago_cliente->EditAttrs["class"] = "form-control";
		$this->idpago_cliente->EditCustomAttributes = "";
		$this->idpago_cliente->EditValue = $this->idpago_cliente->CurrentValue;
		$this->idpago_cliente->ViewCustomAttributes = "";

		// idtipo_pago
		$this->idtipo_pago->EditAttrs["class"] = "form-control";
		$this->idtipo_pago->EditCustomAttributes = "";
		if ($this->idtipo_pago->getSessionValue() <> "") {
			$this->idtipo_pago->CurrentValue = $this->idtipo_pago->getSessionValue();
		if (strval($this->idtipo_pago->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_pago`" . ew_SearchString("=", $this->idtipo_pago->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idtipo_pago`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_pago`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idtipo_pago, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idtipo_pago->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idtipo_pago->ViewValue = $this->idtipo_pago->CurrentValue;
			}
		} else {
			$this->idtipo_pago->ViewValue = NULL;
		}
		$this->idtipo_pago->ViewCustomAttributes = "";
		} else {
		}

		// idcliente
		$this->idcliente->EditAttrs["class"] = "form-control";
		$this->idcliente->EditCustomAttributes = "";
		if ($this->idcliente->getSessionValue() <> "") {
			$this->idcliente->CurrentValue = $this->idcliente->getSessionValue();
		if (strval($this->idcliente->CurrentValue) <> "") {
			$sFilterWrk = "`idcliente`" . ew_SearchString("=", $this->idcliente->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcliente`, `codigo` AS `DispFld`, `nombre_factura` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cliente`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcliente, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `codigo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcliente->ViewValue = $rswrk->fields('DispFld');
				$this->idcliente->ViewValue .= ew_ValueSeparator(1,$this->idcliente) . $rswrk->fields('Disp2Fld');
				$rswrk->Close();
			} else {
				$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
			}
		} else {
			$this->idcliente->ViewValue = NULL;
		}
		$this->idcliente->ViewCustomAttributes = "";
		} else {
		}

		// monto
		$this->monto->EditAttrs["class"] = "form-control";
		$this->monto->EditCustomAttributes = "";
		$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
		$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
		if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -2, 0, -1);

		// fecha
		$this->fecha->EditAttrs["class"] = "form-control";
		$this->fecha->EditCustomAttributes = "";
		$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
		$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

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

		// idsucursal
		$this->idsucursal->EditAttrs["class"] = "form-control";
		$this->idsucursal->EditCustomAttributes = "";

		// idboleta_deposito
		$this->idboleta_deposito->EditAttrs["class"] = "form-control";
		$this->idboleta_deposito->EditCustomAttributes = "";
		if ($this->idboleta_deposito->getSessionValue() <> "") {
			$this->idboleta_deposito->CurrentValue = $this->idboleta_deposito->getSessionValue();
		if (strval($this->idboleta_deposito->CurrentValue) <> "") {
			$sFilterWrk = "`idboleta_deposito`" . ew_SearchString("=", $this->idboleta_deposito->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idboleta_deposito`, `numero` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `boleta_deposito`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idboleta_deposito, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `numero`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idboleta_deposito->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idboleta_deposito->ViewValue = $this->idboleta_deposito->CurrentValue;
			}
		} else {
			$this->idboleta_deposito->ViewValue = NULL;
		}
		$this->idboleta_deposito->ViewCustomAttributes = "";
		} else {
		}

		// idvoucher_tarjeta
		$this->idvoucher_tarjeta->EditAttrs["class"] = "form-control";
		$this->idvoucher_tarjeta->EditCustomAttributes = "";
		if ($this->idvoucher_tarjeta->getSessionValue() <> "") {
			$this->idvoucher_tarjeta->CurrentValue = $this->idvoucher_tarjeta->getSessionValue();
		if (strval($this->idvoucher_tarjeta->CurrentValue) <> "") {
			$sFilterWrk = "`idvoucher_tarjeta`" . ew_SearchString("=", $this->idvoucher_tarjeta->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idvoucher_tarjeta`, `marca` AS `DispFld`, `marca` AS `Disp2Fld`, `ultimos_cuatro_digitos` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `voucher_tarjeta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idvoucher_tarjeta, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idvoucher_tarjeta->ViewValue = $rswrk->fields('DispFld');
				$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(1,$this->idvoucher_tarjeta) . $rswrk->fields('Disp2Fld');
				$this->idvoucher_tarjeta->ViewValue .= ew_ValueSeparator(2,$this->idvoucher_tarjeta) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->idvoucher_tarjeta->ViewValue = $this->idvoucher_tarjeta->CurrentValue;
			}
		} else {
			$this->idvoucher_tarjeta->ViewValue = NULL;
		}
		$this->idvoucher_tarjeta->ViewCustomAttributes = "";
		} else {
		}

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
					if ($this->idtipo_pago->Exportable) $Doc->ExportCaption($this->idtipo_pago);
					if ($this->idcliente->Exportable) $Doc->ExportCaption($this->idcliente);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->idsucursal->Exportable) $Doc->ExportCaption($this->idsucursal);
					if ($this->idboleta_deposito->Exportable) $Doc->ExportCaption($this->idboleta_deposito);
					if ($this->idvoucher_tarjeta->Exportable) $Doc->ExportCaption($this->idvoucher_tarjeta);
				} else {
					if ($this->idpago_cliente->Exportable) $Doc->ExportCaption($this->idpago_cliente);
					if ($this->idtipo_pago->Exportable) $Doc->ExportCaption($this->idtipo_pago);
					if ($this->idcliente->Exportable) $Doc->ExportCaption($this->idcliente);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->idsucursal->Exportable) $Doc->ExportCaption($this->idsucursal);
					if ($this->idboleta_deposito->Exportable) $Doc->ExportCaption($this->idboleta_deposito);
					if ($this->idvoucher_tarjeta->Exportable) $Doc->ExportCaption($this->idvoucher_tarjeta);
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
						if ($this->idtipo_pago->Exportable) $Doc->ExportField($this->idtipo_pago);
						if ($this->idcliente->Exportable) $Doc->ExportField($this->idcliente);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->idsucursal->Exportable) $Doc->ExportField($this->idsucursal);
						if ($this->idboleta_deposito->Exportable) $Doc->ExportField($this->idboleta_deposito);
						if ($this->idvoucher_tarjeta->Exportable) $Doc->ExportField($this->idvoucher_tarjeta);
					} else {
						if ($this->idpago_cliente->Exportable) $Doc->ExportField($this->idpago_cliente);
						if ($this->idtipo_pago->Exportable) $Doc->ExportField($this->idtipo_pago);
						if ($this->idcliente->Exportable) $Doc->ExportField($this->idcliente);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->idsucursal->Exportable) $Doc->ExportField($this->idsucursal);
						if ($this->idboleta_deposito->Exportable) $Doc->ExportField($this->idboleta_deposito);
						if ($this->idvoucher_tarjeta->Exportable) $Doc->ExportField($this->idvoucher_tarjeta);
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
