<?php

// Global variable for table object
$producto = NULL;

//
// Table class for producto
//
class cproducto extends cTable {
	var $idproducto;
	var $idcategoria;
	var $idmarca;
	var $nombre;
	var $idpais;
	var $existencia;
	var $estado;
	var $precio_venta;
	var $precio_compra;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'producto';
		$this->TableName = 'producto';
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

		// idproducto
		$this->idproducto = new cField('producto', 'producto', 'x_idproducto', 'idproducto', '`idproducto`', '`idproducto`', 3, -1, FALSE, '`idproducto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto'] = &$this->idproducto;

		// idcategoria
		$this->idcategoria = new cField('producto', 'producto', 'x_idcategoria', 'idcategoria', '`idcategoria`', '`idcategoria`', 3, -1, FALSE, '`idcategoria`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idcategoria->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcategoria'] = &$this->idcategoria;

		// idmarca
		$this->idmarca = new cField('producto', 'producto', 'x_idmarca', 'idmarca', '`idmarca`', '`idmarca`', 3, -1, FALSE, '`idmarca`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idmarca->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idmarca'] = &$this->idmarca;

		// nombre
		$this->nombre = new cField('producto', 'producto', 'x_nombre', 'nombre', '`nombre`', '`nombre`', 200, -1, FALSE, '`nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nombre'] = &$this->nombre;

		// idpais
		$this->idpais = new cField('producto', 'producto', 'x_idpais', 'idpais', '`idpais`', '`idpais`', 3, -1, FALSE, '`idpais`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idpais->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idpais'] = &$this->idpais;

		// existencia
		$this->existencia = new cField('producto', 'producto', 'x_existencia', 'existencia', '`existencia`', '`existencia`', 3, -1, FALSE, '`existencia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->existencia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['existencia'] = &$this->existencia;

		// estado
		$this->estado = new cField('producto', 'producto', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// precio_venta
		$this->precio_venta = new cField('producto', 'producto', 'x_precio_venta', 'precio_venta', '`precio_venta`', '`precio_venta`', 131, -1, FALSE, '`precio_venta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->precio_venta->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio_venta'] = &$this->precio_venta;

		// precio_compra
		$this->precio_compra = new cField('producto', 'producto', 'x_precio_compra', 'precio_compra', '`precio_compra`', '`precio_compra`', 131, -1, FALSE, '`precio_compra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->precio_compra->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio_compra'] = &$this->precio_compra;

		// fecha_insercion
		$this->fecha_insercion = new cField('producto', 'producto', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentMasterTable() == "marca") {
			if ($this->idmarca->getSessionValue() <> "")
				$sMasterFilter .= "`idmarca`=" . ew_QuotedValue($this->idmarca->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "categoria") {
			if ($this->idcategoria->getSessionValue() <> "")
				$sMasterFilter .= "`idcategoria`=" . ew_QuotedValue($this->idcategoria->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "marca") {
			if ($this->idmarca->getSessionValue() <> "")
				$sDetailFilter .= "`idmarca`=" . ew_QuotedValue($this->idmarca->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "categoria") {
			if ($this->idcategoria->getSessionValue() <> "")
				$sDetailFilter .= "`idcategoria`=" . ew_QuotedValue($this->idcategoria->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_marca() {
		return "`idmarca`=@idmarca@";
	}

	// Detail filter
	function SqlDetailFilter_marca() {
		return "`idmarca`=@idmarca@";
	}

	// Master filter
	function SqlMasterFilter_categoria() {
		return "`idcategoria`=@idcategoria@";
	}

	// Detail filter
	function SqlDetailFilter_categoria() {
		return "`idcategoria`=@idcategoria@";
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
		if ($this->getCurrentDetailTable() == "registro_sanitario") {
			$sDetailUrl = $GLOBALS["registro_sanitario"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idproducto=" . urlencode($this->idproducto->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "producto_bodega") {
			$sDetailUrl = $GLOBALS["producto_bodega"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idproducto=" . urlencode($this->idproducto->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "producto_sucursal") {
			$sDetailUrl = $GLOBALS["producto_sucursal"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idproducto=" . urlencode($this->idproducto->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "producto_precio_historial") {
			$sDetailUrl = $GLOBALS["producto_precio_historial"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idproducto=" . urlencode($this->idproducto->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "productolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`producto`";
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
	var $UpdateTable = "`producto`";

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
			if (array_key_exists('idproducto', $rs))
				ew_AddFilter($where, ew_QuotedName('idproducto') . '=' . ew_QuotedValue($rs['idproducto'], $this->idproducto->FldDataType));
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
		return "`idproducto` = @idproducto@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idproducto->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idproducto@", ew_AdjustSql($this->idproducto->CurrentValue), $sKeyFilter); // Replace key value
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
			return "productolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "productolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("productoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("productoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "productoadd.php?" . $this->UrlParm($parm);
		else
			return "productoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("productoedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("productoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("productoadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("productoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("productodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idproducto->CurrentValue)) {
			$sUrl .= "idproducto=" . urlencode($this->idproducto->CurrentValue);
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
			$arKeys[] = @$_GET["idproducto"]; // idproducto

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
			$this->idproducto->CurrentValue = $key;
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
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idcategoria->setDbValue($rs->fields('idcategoria'));
		$this->idmarca->setDbValue($rs->fields('idmarca'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->existencia->setDbValue($rs->fields('existencia'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->precio_venta->setDbValue($rs->fields('precio_venta'));
		$this->precio_compra->setDbValue($rs->fields('precio_compra'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idproducto
		// idcategoria
		// idmarca
		// nombre
		// idpais
		// existencia
		// estado
		// precio_venta
		// precio_compra
		// fecha_insercion
		// idproducto

		$this->idproducto->ViewValue = $this->idproducto->CurrentValue;
		$this->idproducto->ViewCustomAttributes = "";

		// idcategoria
		if (strval($this->idcategoria->CurrentValue) <> "") {
			$sFilterWrk = "`idcategoria`" . ew_SearchString("=", $this->idcategoria->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcategoria, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcategoria->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idcategoria->ViewValue = $this->idcategoria->CurrentValue;
			}
		} else {
			$this->idcategoria->ViewValue = NULL;
		}
		$this->idcategoria->ViewCustomAttributes = "";

		// idmarca
		if (strval($this->idmarca->CurrentValue) <> "") {
			$sFilterWrk = "`idmarca`" . ew_SearchString("=", $this->idmarca->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idmarca, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idmarca->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idmarca->ViewValue = $this->idmarca->CurrentValue;
			}
		} else {
			$this->idmarca->ViewValue = NULL;
		}
		$this->idmarca->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// idpais
		if (strval($this->idpais->CurrentValue) <> "") {
			$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idpais, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idpais->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idpais->ViewValue = $this->idpais->CurrentValue;
			}
		} else {
			$this->idpais->ViewValue = NULL;
		}
		$this->idpais->ViewCustomAttributes = "";

		// existencia
		$this->existencia->ViewValue = $this->existencia->CurrentValue;
		$this->existencia->ViewCustomAttributes = "";

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

		// precio_venta
		$this->precio_venta->ViewValue = $this->precio_venta->CurrentValue;
		$this->precio_venta->ViewValue = ew_FormatCurrency($this->precio_venta->ViewValue, 2, -2, -2, -2);
		$this->precio_venta->ViewCustomAttributes = "";

		// precio_compra
		$this->precio_compra->ViewValue = $this->precio_compra->CurrentValue;
		$this->precio_compra->ViewValue = ew_FormatCurrency($this->precio_compra->ViewValue, 0, -2, -2, -2);
		$this->precio_compra->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

		// idproducto
		$this->idproducto->LinkCustomAttributes = "";
		$this->idproducto->HrefValue = "";
		$this->idproducto->TooltipValue = "";

		// idcategoria
		$this->idcategoria->LinkCustomAttributes = "";
		$this->idcategoria->HrefValue = "";
		$this->idcategoria->TooltipValue = "";

		// idmarca
		$this->idmarca->LinkCustomAttributes = "";
		$this->idmarca->HrefValue = "";
		$this->idmarca->TooltipValue = "";

		// nombre
		$this->nombre->LinkCustomAttributes = "";
		$this->nombre->HrefValue = "";
		$this->nombre->TooltipValue = "";

		// idpais
		$this->idpais->LinkCustomAttributes = "";
		$this->idpais->HrefValue = "";
		$this->idpais->TooltipValue = "";

		// existencia
		$this->existencia->LinkCustomAttributes = "";
		$this->existencia->HrefValue = "";
		$this->existencia->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// precio_venta
		$this->precio_venta->LinkCustomAttributes = "";
		$this->precio_venta->HrefValue = "";
		$this->precio_venta->TooltipValue = "";

		// precio_compra
		$this->precio_compra->LinkCustomAttributes = "";
		$this->precio_compra->HrefValue = "";
		$this->precio_compra->TooltipValue = "";

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

		// idproducto
		$this->idproducto->EditAttrs["class"] = "form-control";
		$this->idproducto->EditCustomAttributes = "";
		$this->idproducto->EditValue = $this->idproducto->CurrentValue;
		$this->idproducto->ViewCustomAttributes = "";

		// idcategoria
		$this->idcategoria->EditAttrs["class"] = "form-control";
		$this->idcategoria->EditCustomAttributes = "";
		if ($this->idcategoria->getSessionValue() <> "") {
			$this->idcategoria->CurrentValue = $this->idcategoria->getSessionValue();
		if (strval($this->idcategoria->CurrentValue) <> "") {
			$sFilterWrk = "`idcategoria`" . ew_SearchString("=", $this->idcategoria->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idcategoria`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categoria`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idcategoria, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idcategoria->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idcategoria->ViewValue = $this->idcategoria->CurrentValue;
			}
		} else {
			$this->idcategoria->ViewValue = NULL;
		}
		$this->idcategoria->ViewCustomAttributes = "";
		} else {
		}

		// idmarca
		$this->idmarca->EditAttrs["class"] = "form-control";
		$this->idmarca->EditCustomAttributes = "";
		if ($this->idmarca->getSessionValue() <> "") {
			$this->idmarca->CurrentValue = $this->idmarca->getSessionValue();
		if (strval($this->idmarca->CurrentValue) <> "") {
			$sFilterWrk = "`idmarca`" . ew_SearchString("=", $this->idmarca->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idmarca`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `marca`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idmarca, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idmarca->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->idmarca->ViewValue = $this->idmarca->CurrentValue;
			}
		} else {
			$this->idmarca->ViewValue = NULL;
		}
		$this->idmarca->ViewCustomAttributes = "";
		} else {
		}

		// nombre
		$this->nombre->EditAttrs["class"] = "form-control";
		$this->nombre->EditCustomAttributes = "";
		$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
		$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

		// idpais
		$this->idpais->EditAttrs["class"] = "form-control";
		$this->idpais->EditCustomAttributes = "";

		// existencia
		$this->existencia->EditAttrs["class"] = "form-control";
		$this->existencia->EditCustomAttributes = "";
		$this->existencia->EditValue = ew_HtmlEncode($this->existencia->CurrentValue);
		$this->existencia->PlaceHolder = ew_RemoveHtml($this->existencia->FldCaption());

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
		$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->estado->EditValue = $arwrk;

		// precio_venta
		$this->precio_venta->EditAttrs["class"] = "form-control";
		$this->precio_venta->EditCustomAttributes = "";
		$this->precio_venta->EditValue = ew_HtmlEncode($this->precio_venta->CurrentValue);
		$this->precio_venta->PlaceHolder = ew_RemoveHtml($this->precio_venta->FldCaption());
		if (strval($this->precio_venta->EditValue) <> "" && is_numeric($this->precio_venta->EditValue)) $this->precio_venta->EditValue = ew_FormatNumber($this->precio_venta->EditValue, -2, -2, -2, -2);

		// precio_compra
		$this->precio_compra->EditAttrs["class"] = "form-control";
		$this->precio_compra->EditCustomAttributes = "";
		$this->precio_compra->EditValue = ew_HtmlEncode($this->precio_compra->CurrentValue);
		$this->precio_compra->PlaceHolder = ew_RemoveHtml($this->precio_compra->FldCaption());
		if (strval($this->precio_compra->EditValue) <> "" && is_numeric($this->precio_compra->EditValue)) $this->precio_compra->EditValue = ew_FormatNumber($this->precio_compra->EditValue, -2, -2, -2, -2);

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
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idcategoria->Exportable) $Doc->ExportCaption($this->idcategoria);
					if ($this->idmarca->Exportable) $Doc->ExportCaption($this->idmarca);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->idpais->Exportable) $Doc->ExportCaption($this->idpais);
					if ($this->existencia->Exportable) $Doc->ExportCaption($this->existencia);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->precio_venta->Exportable) $Doc->ExportCaption($this->precio_venta);
					if ($this->precio_compra->Exportable) $Doc->ExportCaption($this->precio_compra);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idcategoria->Exportable) $Doc->ExportCaption($this->idcategoria);
					if ($this->idmarca->Exportable) $Doc->ExportCaption($this->idmarca);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->idpais->Exportable) $Doc->ExportCaption($this->idpais);
					if ($this->existencia->Exportable) $Doc->ExportCaption($this->existencia);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->precio_venta->Exportable) $Doc->ExportCaption($this->precio_venta);
					if ($this->precio_compra->Exportable) $Doc->ExportCaption($this->precio_compra);
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
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idcategoria->Exportable) $Doc->ExportField($this->idcategoria);
						if ($this->idmarca->Exportable) $Doc->ExportField($this->idmarca);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->idpais->Exportable) $Doc->ExportField($this->idpais);
						if ($this->existencia->Exportable) $Doc->ExportField($this->existencia);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->precio_venta->Exportable) $Doc->ExportField($this->precio_venta);
						if ($this->precio_compra->Exportable) $Doc->ExportField($this->precio_compra);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idcategoria->Exportable) $Doc->ExportField($this->idcategoria);
						if ($this->idmarca->Exportable) $Doc->ExportField($this->idmarca);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->idpais->Exportable) $Doc->ExportField($this->idpais);
						if ($this->existencia->Exportable) $Doc->ExportField($this->existencia);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->precio_venta->Exportable) $Doc->ExportField($this->precio_venta);
						if ($this->precio_compra->Exportable) $Doc->ExportField($this->precio_compra);
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
