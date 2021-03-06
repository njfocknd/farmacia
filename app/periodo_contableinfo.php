<?php

// Global variable for table object
$periodo_contable = NULL;

//
// Table class for periodo_contable
//
class cperiodo_contable extends cTable {
	var $idperiodo_contable;
	var $idempresa;
	var $mes;
	var $anio;
	var $estado;
	var $fecha_cierre;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'periodo_contable';
		$this->TableName = 'periodo_contable';
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

		// idperiodo_contable
		$this->idperiodo_contable = new cField('periodo_contable', 'periodo_contable', 'x_idperiodo_contable', 'idperiodo_contable', '`idperiodo_contable`', '`idperiodo_contable`', 3, -1, FALSE, '`idperiodo_contable`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idperiodo_contable->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idperiodo_contable'] = &$this->idperiodo_contable;

		// idempresa
		$this->idempresa = new cField('periodo_contable', 'periodo_contable', 'x_idempresa', 'idempresa', '`idempresa`', '`idempresa`', 3, -1, FALSE, '`idempresa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idempresa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idempresa'] = &$this->idempresa;

		// mes
		$this->mes = new cField('periodo_contable', 'periodo_contable', 'x_mes', 'mes', '`mes`', '`mes`', 202, -1, FALSE, '`mes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['mes'] = &$this->mes;

		// anio
		$this->anio = new cField('periodo_contable', 'periodo_contable', 'x_anio', 'anio', '`anio`', '`anio`', 202, -1, FALSE, '`anio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['anio'] = &$this->anio;

		// estado
		$this->estado = new cField('periodo_contable', 'periodo_contable', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_cierre
		$this->fecha_cierre = new cField('periodo_contable', 'periodo_contable', 'x_fecha_cierre', 'fecha_cierre', '`fecha_cierre`', 'DATE_FORMAT(`fecha_cierre`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha_cierre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_cierre->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_cierre'] = &$this->fecha_cierre;

		// fecha_insercion
		$this->fecha_insercion = new cField('periodo_contable', 'periodo_contable', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentMasterTable() == "empresa") {
			if ($this->idempresa->getSessionValue() <> "")
				$sMasterFilter .= "`idempresa`=" . ew_QuotedValue($this->idempresa->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "empresa") {
			if ($this->idempresa->getSessionValue() <> "")
				$sDetailFilter .= "`idempresa`=" . ew_QuotedValue($this->idempresa->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_empresa() {
		return "`idempresa`=@idempresa@";
	}

	// Detail filter
	function SqlDetailFilter_empresa() {
		return "`idempresa`=@idempresa@";
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
		if ($this->getCurrentDetailTable() == "fecha_contable") {
			$sDetailUrl = $GLOBALS["fecha_contable"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idperiodo_contable=" . urlencode($this->idperiodo_contable->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "meta") {
			$sDetailUrl = $GLOBALS["meta"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idperiodo_contable=" . urlencode($this->idperiodo_contable->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "periodo_contablelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`periodo_contable`";
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
		$this->TableFilter = "";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`anio` DESC,`mes` DESC";
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
	var $UpdateTable = "`periodo_contable`";

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
			if (array_key_exists('idperiodo_contable', $rs))
				ew_AddFilter($where, ew_QuotedName('idperiodo_contable') . '=' . ew_QuotedValue($rs['idperiodo_contable'], $this->idperiodo_contable->FldDataType));
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
		return "`idperiodo_contable` = @idperiodo_contable@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idperiodo_contable->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idperiodo_contable@", ew_AdjustSql($this->idperiodo_contable->CurrentValue), $sKeyFilter); // Replace key value
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
			return "periodo_contablelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "periodo_contablelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("periodo_contableview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("periodo_contableview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "periodo_contableadd.php?" . $this->UrlParm($parm);
		else
			return "periodo_contableadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("periodo_contableedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("periodo_contableedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("periodo_contableadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("periodo_contableadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("periodo_contabledelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idperiodo_contable->CurrentValue)) {
			$sUrl .= "idperiodo_contable=" . urlencode($this->idperiodo_contable->CurrentValue);
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
			$arKeys[] = @$_GET["idperiodo_contable"]; // idperiodo_contable

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
			$this->idperiodo_contable->CurrentValue = $key;
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
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->mes->setDbValue($rs->fields('mes'));
		$this->anio->setDbValue($rs->fields('anio'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_cierre->setDbValue($rs->fields('fecha_cierre'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idperiodo_contable
		// idempresa
		// mes
		// anio
		// estado
		// fecha_cierre
		// fecha_insercion
		// idperiodo_contable

		$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->CurrentValue;
		$this->idperiodo_contable->ViewCustomAttributes = "";

		// idempresa
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idempresa, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idempresa->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
			}
		} else {
			$this->idempresa->ViewValue = NULL;
		}
		$this->idempresa->ViewCustomAttributes = "";

		// mes
		if (strval($this->mes->CurrentValue) <> "") {
			switch ($this->mes->CurrentValue) {
				case $this->mes->FldTagValue(1):
					$this->mes->ViewValue = $this->mes->FldTagCaption(1) <> "" ? $this->mes->FldTagCaption(1) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(2):
					$this->mes->ViewValue = $this->mes->FldTagCaption(2) <> "" ? $this->mes->FldTagCaption(2) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(3):
					$this->mes->ViewValue = $this->mes->FldTagCaption(3) <> "" ? $this->mes->FldTagCaption(3) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(4):
					$this->mes->ViewValue = $this->mes->FldTagCaption(4) <> "" ? $this->mes->FldTagCaption(4) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(5):
					$this->mes->ViewValue = $this->mes->FldTagCaption(5) <> "" ? $this->mes->FldTagCaption(5) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(6):
					$this->mes->ViewValue = $this->mes->FldTagCaption(6) <> "" ? $this->mes->FldTagCaption(6) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(7):
					$this->mes->ViewValue = $this->mes->FldTagCaption(7) <> "" ? $this->mes->FldTagCaption(7) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(8):
					$this->mes->ViewValue = $this->mes->FldTagCaption(8) <> "" ? $this->mes->FldTagCaption(8) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(9):
					$this->mes->ViewValue = $this->mes->FldTagCaption(9) <> "" ? $this->mes->FldTagCaption(9) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(10):
					$this->mes->ViewValue = $this->mes->FldTagCaption(10) <> "" ? $this->mes->FldTagCaption(10) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(11):
					$this->mes->ViewValue = $this->mes->FldTagCaption(11) <> "" ? $this->mes->FldTagCaption(11) : $this->mes->CurrentValue;
					break;
				case $this->mes->FldTagValue(12):
					$this->mes->ViewValue = $this->mes->FldTagCaption(12) <> "" ? $this->mes->FldTagCaption(12) : $this->mes->CurrentValue;
					break;
				default:
					$this->mes->ViewValue = $this->mes->CurrentValue;
			}
		} else {
			$this->mes->ViewValue = NULL;
		}
		$this->mes->ViewCustomAttributes = "";

		// anio
		if (strval($this->anio->CurrentValue) <> "") {
			switch ($this->anio->CurrentValue) {
				case $this->anio->FldTagValue(1):
					$this->anio->ViewValue = $this->anio->FldTagCaption(1) <> "" ? $this->anio->FldTagCaption(1) : $this->anio->CurrentValue;
					break;
				case $this->anio->FldTagValue(2):
					$this->anio->ViewValue = $this->anio->FldTagCaption(2) <> "" ? $this->anio->FldTagCaption(2) : $this->anio->CurrentValue;
					break;
				default:
					$this->anio->ViewValue = $this->anio->CurrentValue;
			}
		} else {
			$this->anio->ViewValue = NULL;
		}
		$this->anio->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			switch ($this->estado->CurrentValue) {
				case $this->estado->FldTagValue(1):
					$this->estado->ViewValue = $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->CurrentValue;
					break;
				case $this->estado->FldTagValue(2):
					$this->estado->ViewValue = $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->CurrentValue;
					break;
				case $this->estado->FldTagValue(3):
					$this->estado->ViewValue = $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->CurrentValue;
					break;
				case $this->estado->FldTagValue(4):
					$this->estado->ViewValue = $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->CurrentValue;
					break;
				default:
					$this->estado->ViewValue = $this->estado->CurrentValue;
			}
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fecha_cierre
		$this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
		$this->fecha_cierre->ViewValue = ew_FormatDateTime($this->fecha_cierre->ViewValue, 7);
		$this->fecha_cierre->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

		// idperiodo_contable
		$this->idperiodo_contable->LinkCustomAttributes = "";
		$this->idperiodo_contable->HrefValue = "";
		$this->idperiodo_contable->TooltipValue = "";

		// idempresa
		$this->idempresa->LinkCustomAttributes = "";
		$this->idempresa->HrefValue = "";
		$this->idempresa->TooltipValue = "";

		// mes
		$this->mes->LinkCustomAttributes = "";
		$this->mes->HrefValue = "";
		$this->mes->TooltipValue = "";

		// anio
		$this->anio->LinkCustomAttributes = "";
		$this->anio->HrefValue = "";
		$this->anio->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_cierre
		$this->fecha_cierre->LinkCustomAttributes = "";
		$this->fecha_cierre->HrefValue = "";
		$this->fecha_cierre->TooltipValue = "";

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

		// idperiodo_contable
		$this->idperiodo_contable->EditAttrs["class"] = "form-control";
		$this->idperiodo_contable->EditCustomAttributes = "";
		$this->idperiodo_contable->EditValue = $this->idperiodo_contable->CurrentValue;
		$this->idperiodo_contable->ViewCustomAttributes = "";

		// idempresa
		$this->idempresa->EditAttrs["class"] = "form-control";
		$this->idempresa->EditCustomAttributes = "";
		if ($this->idempresa->getSessionValue() <> "") {
			$this->idempresa->CurrentValue = $this->idempresa->getSessionValue();
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idempresa, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idempresa->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
			}
		} else {
			$this->idempresa->ViewValue = NULL;
		}
		$this->idempresa->ViewCustomAttributes = "";
		} else {
		}

		// mes
		$this->mes->EditAttrs["class"] = "form-control";
		$this->mes->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->mes->FldTagValue(1), $this->mes->FldTagCaption(1) <> "" ? $this->mes->FldTagCaption(1) : $this->mes->FldTagValue(1));
		$arwrk[] = array($this->mes->FldTagValue(2), $this->mes->FldTagCaption(2) <> "" ? $this->mes->FldTagCaption(2) : $this->mes->FldTagValue(2));
		$arwrk[] = array($this->mes->FldTagValue(3), $this->mes->FldTagCaption(3) <> "" ? $this->mes->FldTagCaption(3) : $this->mes->FldTagValue(3));
		$arwrk[] = array($this->mes->FldTagValue(4), $this->mes->FldTagCaption(4) <> "" ? $this->mes->FldTagCaption(4) : $this->mes->FldTagValue(4));
		$arwrk[] = array($this->mes->FldTagValue(5), $this->mes->FldTagCaption(5) <> "" ? $this->mes->FldTagCaption(5) : $this->mes->FldTagValue(5));
		$arwrk[] = array($this->mes->FldTagValue(6), $this->mes->FldTagCaption(6) <> "" ? $this->mes->FldTagCaption(6) : $this->mes->FldTagValue(6));
		$arwrk[] = array($this->mes->FldTagValue(7), $this->mes->FldTagCaption(7) <> "" ? $this->mes->FldTagCaption(7) : $this->mes->FldTagValue(7));
		$arwrk[] = array($this->mes->FldTagValue(8), $this->mes->FldTagCaption(8) <> "" ? $this->mes->FldTagCaption(8) : $this->mes->FldTagValue(8));
		$arwrk[] = array($this->mes->FldTagValue(9), $this->mes->FldTagCaption(9) <> "" ? $this->mes->FldTagCaption(9) : $this->mes->FldTagValue(9));
		$arwrk[] = array($this->mes->FldTagValue(10), $this->mes->FldTagCaption(10) <> "" ? $this->mes->FldTagCaption(10) : $this->mes->FldTagValue(10));
		$arwrk[] = array($this->mes->FldTagValue(11), $this->mes->FldTagCaption(11) <> "" ? $this->mes->FldTagCaption(11) : $this->mes->FldTagValue(11));
		$arwrk[] = array($this->mes->FldTagValue(12), $this->mes->FldTagCaption(12) <> "" ? $this->mes->FldTagCaption(12) : $this->mes->FldTagValue(12));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->mes->EditValue = $arwrk;

		// anio
		$this->anio->EditAttrs["class"] = "form-control";
		$this->anio->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->anio->FldTagValue(1), $this->anio->FldTagCaption(1) <> "" ? $this->anio->FldTagCaption(1) : $this->anio->FldTagValue(1));
		$arwrk[] = array($this->anio->FldTagValue(2), $this->anio->FldTagCaption(2) <> "" ? $this->anio->FldTagCaption(2) : $this->anio->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->anio->EditValue = $arwrk;

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
		$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
		$arwrk[] = array($this->estado->FldTagValue(3), $this->estado->FldTagCaption(3) <> "" ? $this->estado->FldTagCaption(3) : $this->estado->FldTagValue(3));
		$arwrk[] = array($this->estado->FldTagValue(4), $this->estado->FldTagCaption(4) <> "" ? $this->estado->FldTagCaption(4) : $this->estado->FldTagValue(4));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->estado->EditValue = $arwrk;

		// fecha_cierre
		$this->fecha_cierre->EditAttrs["class"] = "form-control";
		$this->fecha_cierre->EditCustomAttributes = "";
		$this->fecha_cierre->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_cierre->CurrentValue, 7));
		$this->fecha_cierre->PlaceHolder = ew_RemoveHtml($this->fecha_cierre->FldCaption());

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
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->mes->Exportable) $Doc->ExportCaption($this->mes);
					if ($this->anio->Exportable) $Doc->ExportCaption($this->anio);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_cierre->Exportable) $Doc->ExportCaption($this->fecha_cierre);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->mes->Exportable) $Doc->ExportCaption($this->mes);
					if ($this->anio->Exportable) $Doc->ExportCaption($this->anio);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_cierre->Exportable) $Doc->ExportCaption($this->fecha_cierre);
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
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->mes->Exportable) $Doc->ExportField($this->mes);
						if ($this->anio->Exportable) $Doc->ExportField($this->anio);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_cierre->Exportable) $Doc->ExportField($this->fecha_cierre);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->mes->Exportable) $Doc->ExportField($this->mes);
						if ($this->anio->Exportable) $Doc->ExportField($this->anio);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_cierre->Exportable) $Doc->ExportField($this->fecha_cierre);
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
