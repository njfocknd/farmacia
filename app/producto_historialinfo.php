<?php

// Global variable for table object
$producto_historial = NULL;

//
// Table class for producto_historial
//
class cproducto_historial extends cTable {
	var $idproducto_historial;
	var $idproducto;
	var $idbodega;
	var $idproducto_bodega;
	var $fecha;
	var $unidades_ingreso;
	var $unidades_salida;
	var $estado;
	var $fecha_insercion;
	var $idrelacion;
	var $tabla_relacion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'producto_historial';
		$this->TableName = 'producto_historial';
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

		// idproducto_historial
		$this->idproducto_historial = new cField('producto_historial', 'producto_historial', 'x_idproducto_historial', 'idproducto_historial', '`idproducto_historial`', '`idproducto_historial`', 3, -1, FALSE, '`idproducto_historial`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto_historial->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto_historial'] = &$this->idproducto_historial;

		// idproducto
		$this->idproducto = new cField('producto_historial', 'producto_historial', 'x_idproducto', 'idproducto', '`idproducto`', '`idproducto`', 3, -1, FALSE, '`idproducto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto'] = &$this->idproducto;

		// idbodega
		$this->idbodega = new cField('producto_historial', 'producto_historial', 'x_idbodega', 'idbodega', '`idbodega`', '`idbodega`', 3, -1, FALSE, '`idbodega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbodega->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbodega'] = &$this->idbodega;

		// idproducto_bodega
		$this->idproducto_bodega = new cField('producto_historial', 'producto_historial', 'x_idproducto_bodega', 'idproducto_bodega', '`idproducto_bodega`', '`idproducto_bodega`', 3, -1, FALSE, '`idproducto_bodega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto_bodega->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto_bodega'] = &$this->idproducto_bodega;

		// fecha
		$this->fecha = new cField('producto_historial', 'producto_historial', 'x_fecha', 'fecha', '`fecha`', 'DATE_FORMAT(`fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;

		// unidades_ingreso
		$this->unidades_ingreso = new cField('producto_historial', 'producto_historial', 'x_unidades_ingreso', 'unidades_ingreso', '`unidades_ingreso`', '`unidades_ingreso`', 3, -1, FALSE, '`unidades_ingreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->unidades_ingreso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unidades_ingreso'] = &$this->unidades_ingreso;

		// unidades_salida
		$this->unidades_salida = new cField('producto_historial', 'producto_historial', 'x_unidades_salida', 'unidades_salida', '`unidades_salida`', '`unidades_salida`', 3, -1, FALSE, '`unidades_salida`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->unidades_salida->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['unidades_salida'] = &$this->unidades_salida;

		// estado
		$this->estado = new cField('producto_historial', 'producto_historial', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('producto_historial', 'producto_historial', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// idrelacion
		$this->idrelacion = new cField('producto_historial', 'producto_historial', 'x_idrelacion', 'idrelacion', '`idrelacion`', '`idrelacion`', 3, -1, FALSE, '`idrelacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idrelacion->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idrelacion'] = &$this->idrelacion;

		// tabla_relacion
		$this->tabla_relacion = new cField('producto_historial', 'producto_historial', 'x_tabla_relacion', 'tabla_relacion', '`tabla_relacion`', '`tabla_relacion`', 200, -1, FALSE, '`tabla_relacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['tabla_relacion'] = &$this->tabla_relacion;
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
		if ($this->getCurrentMasterTable() == "producto_bodega") {
			if ($this->idproducto_bodega->getSessionValue() <> "")
				$sMasterFilter .= "`idproducto_bodega`=" . ew_QuotedValue($this->idproducto_bodega->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "producto_bodega") {
			if ($this->idproducto_bodega->getSessionValue() <> "")
				$sDetailFilter .= "`idproducto_bodega`=" . ew_QuotedValue($this->idproducto_bodega->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_producto_bodega() {
		return "`idproducto_bodega`=@idproducto_bodega@";
	}

	// Detail filter
	function SqlDetailFilter_producto_bodega() {
		return "`idproducto_bodega`=@idproducto_bodega@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`producto_historial`";
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
	var $UpdateTable = "`producto_historial`";

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
			if (array_key_exists('idproducto_historial', $rs))
				ew_AddFilter($where, ew_QuotedName('idproducto_historial') . '=' . ew_QuotedValue($rs['idproducto_historial'], $this->idproducto_historial->FldDataType));
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
		return "`idproducto_historial` = @idproducto_historial@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idproducto_historial->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idproducto_historial@", ew_AdjustSql($this->idproducto_historial->CurrentValue), $sKeyFilter); // Replace key value
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
			return "producto_historiallist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "producto_historiallist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("producto_historialview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("producto_historialview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "producto_historialadd.php?" . $this->UrlParm($parm);
		else
			return "producto_historialadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("producto_historialedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("producto_historialadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("producto_historialdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idproducto_historial->CurrentValue)) {
			$sUrl .= "idproducto_historial=" . urlencode($this->idproducto_historial->CurrentValue);
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
			$arKeys[] = @$_GET["idproducto_historial"]; // idproducto_historial

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
			$this->idproducto_historial->CurrentValue = $key;
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// idproducto_historial
		$this->idproducto_historial->LinkCustomAttributes = "";
		$this->idproducto_historial->HrefValue = "";
		$this->idproducto_historial->TooltipValue = "";

		// idproducto
		$this->idproducto->LinkCustomAttributes = "";
		$this->idproducto->HrefValue = "";
		$this->idproducto->TooltipValue = "";

		// idbodega
		$this->idbodega->LinkCustomAttributes = "";
		$this->idbodega->HrefValue = "";
		$this->idbodega->TooltipValue = "";

		// idproducto_bodega
		$this->idproducto_bodega->LinkCustomAttributes = "";
		$this->idproducto_bodega->HrefValue = "";
		$this->idproducto_bodega->TooltipValue = "";

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

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// idrelacion
		$this->idrelacion->LinkCustomAttributes = "";
		$this->idrelacion->HrefValue = "";
		$this->idrelacion->TooltipValue = "";

		// tabla_relacion
		$this->tabla_relacion->LinkCustomAttributes = "";
		$this->tabla_relacion->HrefValue = "";
		$this->tabla_relacion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idproducto_historial
		$this->idproducto_historial->EditAttrs["class"] = "form-control";
		$this->idproducto_historial->EditCustomAttributes = "";
		$this->idproducto_historial->EditValue = $this->idproducto_historial->CurrentValue;
		$this->idproducto_historial->ViewCustomAttributes = "";

		// idproducto
		$this->idproducto->EditAttrs["class"] = "form-control";
		$this->idproducto->EditCustomAttributes = "";

		// idbodega
		$this->idbodega->EditAttrs["class"] = "form-control";
		$this->idbodega->EditCustomAttributes = "";

		// idproducto_bodega
		$this->idproducto_bodega->EditAttrs["class"] = "form-control";
		$this->idproducto_bodega->EditCustomAttributes = "";
		if ($this->idproducto_bodega->getSessionValue() <> "") {
			$this->idproducto_bodega->CurrentValue = $this->idproducto_bodega->getSessionValue();
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
		} else {
		}

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
					if ($this->idproducto_historial->Exportable) $Doc->ExportCaption($this->idproducto_historial);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega->Exportable) $Doc->ExportCaption($this->idbodega);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->unidades_ingreso->Exportable) $Doc->ExportCaption($this->unidades_ingreso);
					if ($this->unidades_salida->Exportable) $Doc->ExportCaption($this->unidades_salida);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->idrelacion->Exportable) $Doc->ExportCaption($this->idrelacion);
					if ($this->tabla_relacion->Exportable) $Doc->ExportCaption($this->tabla_relacion);
				} else {
					if ($this->idproducto_historial->Exportable) $Doc->ExportCaption($this->idproducto_historial);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega->Exportable) $Doc->ExportCaption($this->idbodega);
					if ($this->idproducto_bodega->Exportable) $Doc->ExportCaption($this->idproducto_bodega);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->unidades_ingreso->Exportable) $Doc->ExportCaption($this->unidades_ingreso);
					if ($this->unidades_salida->Exportable) $Doc->ExportCaption($this->unidades_salida);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->idrelacion->Exportable) $Doc->ExportCaption($this->idrelacion);
					if ($this->tabla_relacion->Exportable) $Doc->ExportCaption($this->tabla_relacion);
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
						if ($this->idproducto_historial->Exportable) $Doc->ExportField($this->idproducto_historial);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega->Exportable) $Doc->ExportField($this->idbodega);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->unidades_ingreso->Exportable) $Doc->ExportField($this->unidades_ingreso);
						if ($this->unidades_salida->Exportable) $Doc->ExportField($this->unidades_salida);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->idrelacion->Exportable) $Doc->ExportField($this->idrelacion);
						if ($this->tabla_relacion->Exportable) $Doc->ExportField($this->tabla_relacion);
					} else {
						if ($this->idproducto_historial->Exportable) $Doc->ExportField($this->idproducto_historial);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega->Exportable) $Doc->ExportField($this->idbodega);
						if ($this->idproducto_bodega->Exportable) $Doc->ExportField($this->idproducto_bodega);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->unidades_ingreso->Exportable) $Doc->ExportField($this->unidades_ingreso);
						if ($this->unidades_salida->Exportable) $Doc->ExportField($this->unidades_salida);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->idrelacion->Exportable) $Doc->ExportField($this->idrelacion);
						if ($this->tabla_relacion->Exportable) $Doc->ExportField($this->tabla_relacion);
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
