<?php

// Global variable for table object
$detalle_documento_movimiento = NULL;

//
// Table class for detalle_documento_movimiento
//
class cdetalle_documento_movimiento extends cTable {
	var $iddetalle_documento_movimiento;
	var $iddocumento_movimiento;
	var $idproducto;
	var $idbodega_ingreso;
	var $idbodega_egreso;
	var $cantidad;
	var $estado;
	var $fecha_insercion;
	var $monto;
	var $precio;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'detalle_documento_movimiento';
		$this->TableName = 'detalle_documento_movimiento';
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

		// iddetalle_documento_movimiento
		$this->iddetalle_documento_movimiento = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_iddetalle_documento_movimiento', 'iddetalle_documento_movimiento', '`iddetalle_documento_movimiento`', '`iddetalle_documento_movimiento`', 3, -1, FALSE, '`iddetalle_documento_movimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->iddetalle_documento_movimiento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['iddetalle_documento_movimiento'] = &$this->iddetalle_documento_movimiento;

		// iddocumento_movimiento
		$this->iddocumento_movimiento = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_iddocumento_movimiento', 'iddocumento_movimiento', '`iddocumento_movimiento`', '`iddocumento_movimiento`', 3, -1, FALSE, '`iddocumento_movimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->iddocumento_movimiento->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['iddocumento_movimiento'] = &$this->iddocumento_movimiento;

		// idproducto
		$this->idproducto = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_idproducto', 'idproducto', '`idproducto`', '`idproducto`', 3, -1, FALSE, '`idproducto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto'] = &$this->idproducto;

		// idbodega_ingreso
		$this->idbodega_ingreso = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_idbodega_ingreso', 'idbodega_ingreso', '`idbodega_ingreso`', '`idbodega_ingreso`', 3, -1, FALSE, '`idbodega_ingreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbodega_ingreso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbodega_ingreso'] = &$this->idbodega_ingreso;

		// idbodega_egreso
		$this->idbodega_egreso = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_idbodega_egreso', 'idbodega_egreso', '`idbodega_egreso`', '`idbodega_egreso`', 3, -1, FALSE, '`idbodega_egreso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbodega_egreso->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbodega_egreso'] = &$this->idbodega_egreso;

		// cantidad
		$this->cantidad = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_cantidad', 'cantidad', '`cantidad`', '`cantidad`', 3, -1, FALSE, '`cantidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->cantidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cantidad'] = &$this->cantidad;

		// estado
		$this->estado = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// monto
		$this->monto = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_monto', 'monto', '`monto`', '`monto`', 131, -1, FALSE, '`monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto'] = &$this->monto;

		// precio
		$this->precio = new cField('detalle_documento_movimiento', 'detalle_documento_movimiento', 'x_precio', 'precio', '`precio`', '`precio`', 131, -1, FALSE, '`precio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->precio->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio'] = &$this->precio;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`detalle_documento_movimiento`";
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
	var $UpdateTable = "`detalle_documento_movimiento`";

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
			if (array_key_exists('iddetalle_documento_movimiento', $rs))
				ew_AddFilter($where, ew_QuotedName('iddetalle_documento_movimiento') . '=' . ew_QuotedValue($rs['iddetalle_documento_movimiento'], $this->iddetalle_documento_movimiento->FldDataType));
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
		return "`iddetalle_documento_movimiento` = @iddetalle_documento_movimiento@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->iddetalle_documento_movimiento->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@iddetalle_documento_movimiento@", ew_AdjustSql($this->iddetalle_documento_movimiento->CurrentValue), $sKeyFilter); // Replace key value
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
			return "detalle_documento_movimientolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "detalle_documento_movimientolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("detalle_documento_movimientoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("detalle_documento_movimientoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "detalle_documento_movimientoadd.php?" . $this->UrlParm($parm);
		else
			return "detalle_documento_movimientoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("detalle_documento_movimientoedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("detalle_documento_movimientoadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("detalle_documento_movimientodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->iddetalle_documento_movimiento->CurrentValue)) {
			$sUrl .= "iddetalle_documento_movimiento=" . urlencode($this->iddetalle_documento_movimiento->CurrentValue);
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
			$arKeys[] = @$_GET["iddetalle_documento_movimiento"]; // iddetalle_documento_movimiento

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
			$this->iddetalle_documento_movimiento->CurrentValue = $key;
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
		$this->iddetalle_documento_movimiento->setDbValue($rs->fields('iddetalle_documento_movimiento'));
		$this->iddocumento_movimiento->setDbValue($rs->fields('iddocumento_movimiento'));
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idbodega_ingreso->setDbValue($rs->fields('idbodega_ingreso'));
		$this->idbodega_egreso->setDbValue($rs->fields('idbodega_egreso'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->precio->setDbValue($rs->fields('precio'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// iddetalle_documento_movimiento
		// iddocumento_movimiento
		// idproducto
		// idbodega_ingreso
		// idbodega_egreso
		// cantidad
		// estado
		// fecha_insercion
		// monto
		// precio
		// iddetalle_documento_movimiento

		$this->iddetalle_documento_movimiento->ViewValue = $this->iddetalle_documento_movimiento->CurrentValue;
		$this->iddetalle_documento_movimiento->ViewCustomAttributes = "";

		// iddocumento_movimiento
		$this->iddocumento_movimiento->ViewValue = $this->iddocumento_movimiento->CurrentValue;
		$this->iddocumento_movimiento->ViewCustomAttributes = "";

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

		// idbodega_ingreso
		if (strval($this->idbodega_ingreso->CurrentValue) <> "") {
			$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega_ingreso->CurrentValue, EW_DATATYPE_NUMBER);
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
		$this->Lookup_Selecting($this->idbodega_ingreso, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `descripcion`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idbodega_ingreso->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idbodega_ingreso->ViewValue = $this->idbodega_ingreso->CurrentValue;
			}
		} else {
			$this->idbodega_ingreso->ViewValue = NULL;
		}
		$this->idbodega_ingreso->ViewCustomAttributes = "";

		// idbodega_egreso
		if (strval($this->idbodega_egreso->CurrentValue) <> "") {
			$sFilterWrk = "`idbodega`" . ew_SearchString("=", $this->idbodega_egreso->CurrentValue, EW_DATATYPE_NUMBER);
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
		$this->Lookup_Selecting($this->idbodega_egreso, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `descripcion`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idbodega_egreso->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idbodega_egreso->ViewValue = $this->idbodega_egreso->CurrentValue;
			}
		} else {
			$this->idbodega_egreso->ViewValue = NULL;
		}
		$this->idbodega_egreso->ViewCustomAttributes = "";

		// cantidad
		$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
		$this->cantidad->ViewCustomAttributes = "";

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

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// precio
		$this->precio->ViewValue = $this->precio->CurrentValue;
		$this->precio->ViewCustomAttributes = "";

		// iddetalle_documento_movimiento
		$this->iddetalle_documento_movimiento->LinkCustomAttributes = "";
		$this->iddetalle_documento_movimiento->HrefValue = "";
		$this->iddetalle_documento_movimiento->TooltipValue = "";

		// iddocumento_movimiento
		$this->iddocumento_movimiento->LinkCustomAttributes = "";
		$this->iddocumento_movimiento->HrefValue = "";
		$this->iddocumento_movimiento->TooltipValue = "";

		// idproducto
		$this->idproducto->LinkCustomAttributes = "";
		$this->idproducto->HrefValue = "";
		$this->idproducto->TooltipValue = "";

		// idbodega_ingreso
		$this->idbodega_ingreso->LinkCustomAttributes = "";
		$this->idbodega_ingreso->HrefValue = "";
		$this->idbodega_ingreso->TooltipValue = "";

		// idbodega_egreso
		$this->idbodega_egreso->LinkCustomAttributes = "";
		$this->idbodega_egreso->HrefValue = "";
		$this->idbodega_egreso->TooltipValue = "";

		// cantidad
		$this->cantidad->LinkCustomAttributes = "";
		$this->cantidad->HrefValue = "";
		$this->cantidad->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// monto
		$this->monto->LinkCustomAttributes = "";
		$this->monto->HrefValue = "";
		$this->monto->TooltipValue = "";

		// precio
		$this->precio->LinkCustomAttributes = "";
		$this->precio->HrefValue = "";
		$this->precio->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// iddetalle_documento_movimiento
		$this->iddetalle_documento_movimiento->EditAttrs["class"] = "form-control";
		$this->iddetalle_documento_movimiento->EditCustomAttributes = "";
		$this->iddetalle_documento_movimiento->EditValue = $this->iddetalle_documento_movimiento->CurrentValue;
		$this->iddetalle_documento_movimiento->ViewCustomAttributes = "";

		// iddocumento_movimiento
		$this->iddocumento_movimiento->EditAttrs["class"] = "form-control";
		$this->iddocumento_movimiento->EditCustomAttributes = "";
		$this->iddocumento_movimiento->EditValue = ew_HtmlEncode($this->iddocumento_movimiento->CurrentValue);
		$this->iddocumento_movimiento->PlaceHolder = ew_RemoveHtml($this->iddocumento_movimiento->FldCaption());

		// idproducto
		$this->idproducto->EditAttrs["class"] = "form-control";
		$this->idproducto->EditCustomAttributes = "";

		// idbodega_ingreso
		$this->idbodega_ingreso->EditAttrs["class"] = "form-control";
		$this->idbodega_ingreso->EditCustomAttributes = "";

		// idbodega_egreso
		$this->idbodega_egreso->EditAttrs["class"] = "form-control";
		$this->idbodega_egreso->EditCustomAttributes = "";

		// cantidad
		$this->cantidad->EditAttrs["class"] = "form-control";
		$this->cantidad->EditCustomAttributes = "";
		$this->cantidad->EditValue = ew_HtmlEncode($this->cantidad->CurrentValue);
		$this->cantidad->PlaceHolder = ew_RemoveHtml($this->cantidad->FldCaption());

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

		// monto
		$this->monto->EditAttrs["class"] = "form-control";
		$this->monto->EditCustomAttributes = "";
		$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
		$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
		if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

		// precio
		$this->precio->EditAttrs["class"] = "form-control";
		$this->precio->EditCustomAttributes = "";
		$this->precio->EditValue = ew_HtmlEncode($this->precio->CurrentValue);
		$this->precio->PlaceHolder = ew_RemoveHtml($this->precio->FldCaption());
		if (strval($this->precio->EditValue) <> "" && is_numeric($this->precio->EditValue)) $this->precio->EditValue = ew_FormatNumber($this->precio->EditValue, -2, -1, -2, 0);

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
					if ($this->iddetalle_documento_movimiento->Exportable) $Doc->ExportCaption($this->iddetalle_documento_movimiento);
					if ($this->iddocumento_movimiento->Exportable) $Doc->ExportCaption($this->iddocumento_movimiento);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega_ingreso->Exportable) $Doc->ExportCaption($this->idbodega_ingreso);
					if ($this->idbodega_egreso->Exportable) $Doc->ExportCaption($this->idbodega_egreso);
					if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->precio->Exportable) $Doc->ExportCaption($this->precio);
				} else {
					if ($this->iddetalle_documento_movimiento->Exportable) $Doc->ExportCaption($this->iddetalle_documento_movimiento);
					if ($this->iddocumento_movimiento->Exportable) $Doc->ExportCaption($this->iddocumento_movimiento);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega_ingreso->Exportable) $Doc->ExportCaption($this->idbodega_ingreso);
					if ($this->idbodega_egreso->Exportable) $Doc->ExportCaption($this->idbodega_egreso);
					if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->precio->Exportable) $Doc->ExportCaption($this->precio);
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
						if ($this->iddetalle_documento_movimiento->Exportable) $Doc->ExportField($this->iddetalle_documento_movimiento);
						if ($this->iddocumento_movimiento->Exportable) $Doc->ExportField($this->iddocumento_movimiento);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega_ingreso->Exportable) $Doc->ExportField($this->idbodega_ingreso);
						if ($this->idbodega_egreso->Exportable) $Doc->ExportField($this->idbodega_egreso);
						if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->precio->Exportable) $Doc->ExportField($this->precio);
					} else {
						if ($this->iddetalle_documento_movimiento->Exportable) $Doc->ExportField($this->iddetalle_documento_movimiento);
						if ($this->iddocumento_movimiento->Exportable) $Doc->ExportField($this->iddocumento_movimiento);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega_ingreso->Exportable) $Doc->ExportField($this->idbodega_ingreso);
						if ($this->idbodega_egreso->Exportable) $Doc->ExportField($this->idbodega_egreso);
						if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->precio->Exportable) $Doc->ExportField($this->precio);
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
