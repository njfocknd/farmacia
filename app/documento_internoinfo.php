<?php

// Global variable for table object
$documento_interno = NULL;

//
// Table class for documento_interno
//
class cdocumento_interno extends cTable {
	var $iddocumento_interno;
	var $idtipo_documento;
	var $idserie_documento;
	var $serie;
	var $correlativo;
	var $fecha;
	var $observaciones;
	var $estado_documento;
	var $idsucursal_ingreso;
	var $idsucursal_egreso;
	var $estado;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'documento_interno';
		$this->TableName = 'documento_interno';
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

		// iddocumento_interno
		$this->iddocumento_interno = new cField('documento_interno', 'documento_interno', 'x_iddocumento_interno', 'iddocumento_interno', '`iddocumento_interno`', '`iddocumento_interno`', 3, -1, FALSE, '`iddocumento_interno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->iddocumento_interno->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['iddocumento_interno'] = &$this->iddocumento_interno;

		// idtipo_documento
		$this->idtipo_documento = new cField('documento_interno', 'documento_interno', 'x_idtipo_documento', 'idtipo_documento', '`idtipo_documento`', '`idtipo_documento`', 3, -1, FALSE, '`idtipo_documento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idtipo_documento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idtipo_documento'] = &$this->idtipo_documento;

		// idserie_documento
		$this->idserie_documento = new cField('documento_interno', 'documento_interno', 'x_idserie_documento', 'idserie_documento', '`idserie_documento`', '`idserie_documento`', 3, -1, FALSE, '`idserie_documento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idserie_documento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idserie_documento'] = &$this->idserie_documento;

		// serie
		$this->serie = new cField('documento_interno', 'documento_interno', 'x_serie', 'serie', '`serie`', '`serie`', 200, -1, FALSE, '`serie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['serie'] = &$this->serie;

		// correlativo
		$this->correlativo = new cField('documento_interno', 'documento_interno', 'x_correlativo', 'correlativo', '`correlativo`', '`correlativo`', 3, -1, FALSE, '`correlativo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['correlativo'] = &$this->correlativo;

		// fecha
		$this->fecha = new cField('documento_interno', 'documento_interno', 'x_fecha', 'fecha', '`fecha`', 'DATE_FORMAT(`fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;

		// observaciones
		$this->observaciones = new cField('documento_interno', 'documento_interno', 'x_observaciones', 'observaciones', '`observaciones`', '`observaciones`', 200, -1, FALSE, '`observaciones`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['observaciones'] = &$this->observaciones;

		// estado_documento
		$this->estado_documento = new cField('documento_interno', 'documento_interno', 'x_estado_documento', 'estado_documento', '`estado_documento`', '`estado_documento`', 202, -1, FALSE, '`estado_documento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado_documento'] = &$this->estado_documento;

		// idsucursal_ingreso
		$this->idsucursal_ingreso = new cField('documento_interno', 'documento_interno', 'x_idsucursal_ingreso', 'idsucursal_ingreso', '`idsucursal_ingreso`', '`idsucursal_ingreso`', 3, -1, FALSE, '`idsucursal_ingreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idsucursal_ingreso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idsucursal_ingreso'] = &$this->idsucursal_ingreso;

		// idsucursal_egreso
		$this->idsucursal_egreso = new cField('documento_interno', 'documento_interno', 'x_idsucursal_egreso', 'idsucursal_egreso', '`idsucursal_egreso`', '`idsucursal_egreso`', 3, -1, FALSE, '`idsucursal_egreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idsucursal_egreso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idsucursal_egreso'] = &$this->idsucursal_egreso;

		// estado
		$this->estado = new cField('documento_interno', 'documento_interno', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('documento_interno', 'documento_interno', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentDetailTable() == "detalle_documento_interno") {
			$sDetailUrl = $GLOBALS["detalle_documento_interno"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_iddocumento_interno=" . urlencode($this->iddocumento_interno->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "documento_internolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`documento_interno`";
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
	var $UpdateTable = "`documento_interno`";

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
			if (array_key_exists('iddocumento_interno', $rs))
				ew_AddFilter($where, ew_QuotedName('iddocumento_interno') . '=' . ew_QuotedValue($rs['iddocumento_interno'], $this->iddocumento_interno->FldDataType));
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
		return "`iddocumento_interno` = @iddocumento_interno@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->iddocumento_interno->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@iddocumento_interno@", ew_AdjustSql($this->iddocumento_interno->CurrentValue), $sKeyFilter); // Replace key value
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
			return "documento_internolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "documento_internolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("documento_internoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("documento_internoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "documento_internoadd.php?" . $this->UrlParm($parm);
		else
			return "documento_internoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("documento_internoedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("documento_internoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("documento_internoadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("documento_internoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("documento_internodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->iddocumento_interno->CurrentValue)) {
			$sUrl .= "iddocumento_interno=" . urlencode($this->iddocumento_interno->CurrentValue);
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
			$arKeys[] = @$_GET["iddocumento_interno"]; // iddocumento_interno

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
			$this->iddocumento_interno->CurrentValue = $key;
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
		$this->iddocumento_interno->setDbValue($rs->fields('iddocumento_interno'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->idserie_documento->setDbValue($rs->fields('idserie_documento'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->correlativo->setDbValue($rs->fields('correlativo'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->observaciones->setDbValue($rs->fields('observaciones'));
		$this->estado_documento->setDbValue($rs->fields('estado_documento'));
		$this->idsucursal_ingreso->setDbValue($rs->fields('idsucursal_ingreso'));
		$this->idsucursal_egreso->setDbValue($rs->fields('idsucursal_egreso'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// iddocumento_interno
		// idtipo_documento
		// idserie_documento
		// serie
		// correlativo
		// fecha
		// observaciones
		// estado_documento
		// idsucursal_ingreso
		// idsucursal_egreso
		// estado
		// fecha_insercion
		// iddocumento_interno

		$this->iddocumento_interno->ViewValue = $this->iddocumento_interno->CurrentValue;
		$this->iddocumento_interno->ViewCustomAttributes = "";

		// idtipo_documento
		if (strval($this->idtipo_documento->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idtipo_documento->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
			}
		} else {
			$this->idtipo_documento->ViewValue = NULL;
		}
		$this->idtipo_documento->ViewCustomAttributes = "";

		// idserie_documento
		if (strval($this->idserie_documento->CurrentValue) <> "") {
			$sFilterWrk = "`idserie_documento`" . ew_SearchString("=", $this->idserie_documento->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idserie_documento`, `serie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `serie_documento`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idserie_documento, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idserie_documento->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idserie_documento->ViewValue = $this->idserie_documento->CurrentValue;
			}
		} else {
			$this->idserie_documento->ViewValue = NULL;
		}
		$this->idserie_documento->ViewCustomAttributes = "";

		// serie
		$this->serie->ViewValue = $this->serie->CurrentValue;
		$this->serie->ViewCustomAttributes = "";

		// correlativo
		$this->correlativo->ViewValue = $this->correlativo->CurrentValue;
		$this->correlativo->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// observaciones
		$this->observaciones->ViewValue = $this->observaciones->CurrentValue;
		$this->observaciones->ViewCustomAttributes = "";

		// estado_documento
		if (strval($this->estado_documento->CurrentValue) <> "") {
			switch ($this->estado_documento->CurrentValue) {
				case $this->estado_documento->FldTagValue(1):
					$this->estado_documento->ViewValue = $this->estado_documento->FldTagCaption(1) <> "" ? $this->estado_documento->FldTagCaption(1) : $this->estado_documento->CurrentValue;
					break;
				case $this->estado_documento->FldTagValue(2):
					$this->estado_documento->ViewValue = $this->estado_documento->FldTagCaption(2) <> "" ? $this->estado_documento->FldTagCaption(2) : $this->estado_documento->CurrentValue;
					break;
				default:
					$this->estado_documento->ViewValue = $this->estado_documento->CurrentValue;
			}
		} else {
			$this->estado_documento->ViewValue = NULL;
		}
		$this->estado_documento->ViewCustomAttributes = "";

		// idsucursal_ingreso
		if (strval($this->idsucursal_ingreso->CurrentValue) <> "") {
			$sFilterWrk = "`idsucursal`" . ew_SearchString("=", $this->idsucursal_ingreso->CurrentValue, EW_DATATYPE_NUMBER);
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
		$this->Lookup_Selecting($this->idsucursal_ingreso, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idsucursal_ingreso->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idsucursal_ingreso->ViewValue = $this->idsucursal_ingreso->CurrentValue;
			}
		} else {
			$this->idsucursal_ingreso->ViewValue = NULL;
		}
		$this->idsucursal_ingreso->ViewCustomAttributes = "";

		// idsucursal_egreso
		if (strval($this->idsucursal_egreso->CurrentValue) <> "") {
			$sFilterWrk = "`idsucursal`" . ew_SearchString("=", $this->idsucursal_egreso->CurrentValue, EW_DATATYPE_NUMBER);
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
		$this->Lookup_Selecting($this->idsucursal_egreso, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idsucursal_egreso->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idsucursal_egreso->ViewValue = $this->idsucursal_egreso->CurrentValue;
			}
		} else {
			$this->idsucursal_egreso->ViewValue = NULL;
		}
		$this->idsucursal_egreso->ViewCustomAttributes = "";

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

		// iddocumento_interno
		$this->iddocumento_interno->LinkCustomAttributes = "";
		$this->iddocumento_interno->HrefValue = "";
		$this->iddocumento_interno->TooltipValue = "";

		// idtipo_documento
		$this->idtipo_documento->LinkCustomAttributes = "";
		$this->idtipo_documento->HrefValue = "";
		$this->idtipo_documento->TooltipValue = "";

		// idserie_documento
		$this->idserie_documento->LinkCustomAttributes = "";
		$this->idserie_documento->HrefValue = "";
		$this->idserie_documento->TooltipValue = "";

		// serie
		$this->serie->LinkCustomAttributes = "";
		$this->serie->HrefValue = "";
		$this->serie->TooltipValue = "";

		// correlativo
		$this->correlativo->LinkCustomAttributes = "";
		$this->correlativo->HrefValue = "";
		$this->correlativo->TooltipValue = "";

		// fecha
		$this->fecha->LinkCustomAttributes = "";
		$this->fecha->HrefValue = "";
		$this->fecha->TooltipValue = "";

		// observaciones
		$this->observaciones->LinkCustomAttributes = "";
		$this->observaciones->HrefValue = "";
		$this->observaciones->TooltipValue = "";

		// estado_documento
		$this->estado_documento->LinkCustomAttributes = "";
		$this->estado_documento->HrefValue = "";
		$this->estado_documento->TooltipValue = "";

		// idsucursal_ingreso
		$this->idsucursal_ingreso->LinkCustomAttributes = "";
		$this->idsucursal_ingreso->HrefValue = "";
		$this->idsucursal_ingreso->TooltipValue = "";

		// idsucursal_egreso
		$this->idsucursal_egreso->LinkCustomAttributes = "";
		$this->idsucursal_egreso->HrefValue = "";
		$this->idsucursal_egreso->TooltipValue = "";

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

		// iddocumento_interno
		$this->iddocumento_interno->EditAttrs["class"] = "form-control";
		$this->iddocumento_interno->EditCustomAttributes = "";
		$this->iddocumento_interno->EditValue = $this->iddocumento_interno->CurrentValue;
		$this->iddocumento_interno->ViewCustomAttributes = "";

		// idtipo_documento
		$this->idtipo_documento->EditAttrs["class"] = "form-control";
		$this->idtipo_documento->EditCustomAttributes = "";

		// idserie_documento
		$this->idserie_documento->EditAttrs["class"] = "form-control";
		$this->idserie_documento->EditCustomAttributes = "";

		// serie
		$this->serie->EditAttrs["class"] = "form-control";
		$this->serie->EditCustomAttributes = "";
		$this->serie->EditValue = ew_HtmlEncode($this->serie->CurrentValue);
		$this->serie->PlaceHolder = ew_RemoveHtml($this->serie->FldCaption());

		// correlativo
		$this->correlativo->EditAttrs["class"] = "form-control";
		$this->correlativo->EditCustomAttributes = "";
		$this->correlativo->EditValue = ew_HtmlEncode($this->correlativo->CurrentValue);
		$this->correlativo->PlaceHolder = ew_RemoveHtml($this->correlativo->FldCaption());

		// fecha
		$this->fecha->EditAttrs["class"] = "form-control";
		$this->fecha->EditCustomAttributes = "";
		$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
		$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

		// observaciones
		$this->observaciones->EditAttrs["class"] = "form-control";
		$this->observaciones->EditCustomAttributes = "";
		$this->observaciones->EditValue = ew_HtmlEncode($this->observaciones->CurrentValue);
		$this->observaciones->PlaceHolder = ew_RemoveHtml($this->observaciones->FldCaption());

		// estado_documento
		$this->estado_documento->EditAttrs["class"] = "form-control";
		$this->estado_documento->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado_documento->FldTagValue(1), $this->estado_documento->FldTagCaption(1) <> "" ? $this->estado_documento->FldTagCaption(1) : $this->estado_documento->FldTagValue(1));
		$arwrk[] = array($this->estado_documento->FldTagValue(2), $this->estado_documento->FldTagCaption(2) <> "" ? $this->estado_documento->FldTagCaption(2) : $this->estado_documento->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->estado_documento->EditValue = $arwrk;

		// idsucursal_ingreso
		$this->idsucursal_ingreso->EditAttrs["class"] = "form-control";
		$this->idsucursal_ingreso->EditCustomAttributes = "";

		// idsucursal_egreso
		$this->idsucursal_egreso->EditAttrs["class"] = "form-control";
		$this->idsucursal_egreso->EditCustomAttributes = "";

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
					if ($this->iddocumento_interno->Exportable) $Doc->ExportCaption($this->iddocumento_interno);
					if ($this->idtipo_documento->Exportable) $Doc->ExportCaption($this->idtipo_documento);
					if ($this->idserie_documento->Exportable) $Doc->ExportCaption($this->idserie_documento);
					if ($this->serie->Exportable) $Doc->ExportCaption($this->serie);
					if ($this->correlativo->Exportable) $Doc->ExportCaption($this->correlativo);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->observaciones->Exportable) $Doc->ExportCaption($this->observaciones);
					if ($this->estado_documento->Exportable) $Doc->ExportCaption($this->estado_documento);
					if ($this->idsucursal_ingreso->Exportable) $Doc->ExportCaption($this->idsucursal_ingreso);
					if ($this->idsucursal_egreso->Exportable) $Doc->ExportCaption($this->idsucursal_egreso);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->iddocumento_interno->Exportable) $Doc->ExportCaption($this->iddocumento_interno);
					if ($this->idtipo_documento->Exportable) $Doc->ExportCaption($this->idtipo_documento);
					if ($this->idserie_documento->Exportable) $Doc->ExportCaption($this->idserie_documento);
					if ($this->serie->Exportable) $Doc->ExportCaption($this->serie);
					if ($this->correlativo->Exportable) $Doc->ExportCaption($this->correlativo);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->observaciones->Exportable) $Doc->ExportCaption($this->observaciones);
					if ($this->estado_documento->Exportable) $Doc->ExportCaption($this->estado_documento);
					if ($this->idsucursal_ingreso->Exportable) $Doc->ExportCaption($this->idsucursal_ingreso);
					if ($this->idsucursal_egreso->Exportable) $Doc->ExportCaption($this->idsucursal_egreso);
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
						if ($this->iddocumento_interno->Exportable) $Doc->ExportField($this->iddocumento_interno);
						if ($this->idtipo_documento->Exportable) $Doc->ExportField($this->idtipo_documento);
						if ($this->idserie_documento->Exportable) $Doc->ExportField($this->idserie_documento);
						if ($this->serie->Exportable) $Doc->ExportField($this->serie);
						if ($this->correlativo->Exportable) $Doc->ExportField($this->correlativo);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->observaciones->Exportable) $Doc->ExportField($this->observaciones);
						if ($this->estado_documento->Exportable) $Doc->ExportField($this->estado_documento);
						if ($this->idsucursal_ingreso->Exportable) $Doc->ExportField($this->idsucursal_ingreso);
						if ($this->idsucursal_egreso->Exportable) $Doc->ExportField($this->idsucursal_egreso);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->iddocumento_interno->Exportable) $Doc->ExportField($this->iddocumento_interno);
						if ($this->idtipo_documento->Exportable) $Doc->ExportField($this->idtipo_documento);
						if ($this->idserie_documento->Exportable) $Doc->ExportField($this->idserie_documento);
						if ($this->serie->Exportable) $Doc->ExportField($this->serie);
						if ($this->correlativo->Exportable) $Doc->ExportField($this->correlativo);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->observaciones->Exportable) $Doc->ExportField($this->observaciones);
						if ($this->estado_documento->Exportable) $Doc->ExportField($this->estado_documento);
						if ($this->idsucursal_ingreso->Exportable) $Doc->ExportField($this->idsucursal_ingreso);
						if ($this->idsucursal_egreso->Exportable) $Doc->ExportField($this->idsucursal_egreso);
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
