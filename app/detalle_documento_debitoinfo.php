<?php

// Global variable for table object
$detalle_documento_debito = NULL;

//
// Table class for detalle_documento_debito
//
class cdetalle_documento_debito extends cTable {
	var $iddetalle_documento_debito;
	var $iddocumento_debito;
	var $idproducto;
	var $idbodega;
	var $cantidad;
	var $precio;
	var $monto;
	var $estado;
	var $fecha_insercion;
	var $importe_descuento;
	var $importe_bruto;
	var $importe_exento;
	var $importe_neto;
	var $importe_iva;
	var $importe_otros_impuestos;
	var $importe_total;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'detalle_documento_debito';
		$this->TableName = 'detalle_documento_debito';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// iddetalle_documento_debito
		$this->iddetalle_documento_debito = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_iddetalle_documento_debito', 'iddetalle_documento_debito', '`iddetalle_documento_debito`', '`iddetalle_documento_debito`', 3, -1, FALSE, '`iddetalle_documento_debito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->iddetalle_documento_debito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['iddetalle_documento_debito'] = &$this->iddetalle_documento_debito;

		// iddocumento_debito
		$this->iddocumento_debito = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_iddocumento_debito', 'iddocumento_debito', '`iddocumento_debito`', '`iddocumento_debito`', 3, -1, FALSE, '`iddocumento_debito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->iddocumento_debito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['iddocumento_debito'] = &$this->iddocumento_debito;

		// idproducto
		$this->idproducto = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_idproducto', 'idproducto', '`idproducto`', '`idproducto`', 3, -1, FALSE, '`idproducto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idproducto->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idproducto'] = &$this->idproducto;

		// idbodega
		$this->idbodega = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_idbodega', 'idbodega', '`idbodega`', '`idbodega`', 3, -1, FALSE, '`idbodega`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idbodega->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbodega'] = &$this->idbodega;

		// cantidad
		$this->cantidad = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_cantidad', 'cantidad', '`cantidad`', '`cantidad`', 3, -1, FALSE, '`cantidad`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->cantidad->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cantidad'] = &$this->cantidad;

		// precio
		$this->precio = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_precio', 'precio', '`precio`', '`precio`', 131, -1, FALSE, '`precio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->precio->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['precio'] = &$this->precio;

		// monto
		$this->monto = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_monto', 'monto', '`monto`', '`monto`', 131, -1, FALSE, '`monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto'] = &$this->monto;

		// estado
		$this->estado = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// importe_descuento
		$this->importe_descuento = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_descuento', 'importe_descuento', '`importe_descuento`', '`importe_descuento`', 131, -1, FALSE, '`importe_descuento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_descuento->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_descuento'] = &$this->importe_descuento;

		// importe_bruto
		$this->importe_bruto = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_bruto', 'importe_bruto', '`importe_bruto`', '`importe_bruto`', 131, -1, FALSE, '`importe_bruto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_bruto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_bruto'] = &$this->importe_bruto;

		// importe_exento
		$this->importe_exento = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_exento', 'importe_exento', '`importe_exento`', '`importe_exento`', 131, -1, FALSE, '`importe_exento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_exento->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_exento'] = &$this->importe_exento;

		// importe_neto
		$this->importe_neto = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_neto', 'importe_neto', '`importe_neto`', '`importe_neto`', 131, -1, FALSE, '`importe_neto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_neto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_neto'] = &$this->importe_neto;

		// importe_iva
		$this->importe_iva = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_iva', 'importe_iva', '`importe_iva`', '`importe_iva`', 131, -1, FALSE, '`importe_iva`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_iva->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_iva'] = &$this->importe_iva;

		// importe_otros_impuestos
		$this->importe_otros_impuestos = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_otros_impuestos', 'importe_otros_impuestos', '`importe_otros_impuestos`', '`importe_otros_impuestos`', 131, -1, FALSE, '`importe_otros_impuestos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_otros_impuestos->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_otros_impuestos'] = &$this->importe_otros_impuestos;

		// importe_total
		$this->importe_total = new cField('detalle_documento_debito', 'detalle_documento_debito', 'x_importe_total', 'importe_total', '`importe_total`', '`importe_total`', 131, -1, FALSE, '`importe_total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->importe_total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['importe_total'] = &$this->importe_total;
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
		if ($this->getCurrentMasterTable() == "documento_debito") {
			if ($this->iddocumento_debito->getSessionValue() <> "")
				$sMasterFilter .= "`iddocumento_debito`=" . ew_QuotedValue($this->iddocumento_debito->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "documento_debito") {
			if ($this->iddocumento_debito->getSessionValue() <> "")
				$sDetailFilter .= "`iddocumento_debito`=" . ew_QuotedValue($this->iddocumento_debito->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_documento_debito() {
		return "`iddocumento_debito`=@iddocumento_debito@";
	}

	// Detail filter
	function SqlDetailFilter_documento_debito() {
		return "`iddocumento_debito`=@iddocumento_debito@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`detalle_documento_debito`";
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
	var $UpdateTable = "`detalle_documento_debito`";

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
			if (array_key_exists('iddetalle_documento_debito', $rs))
				ew_AddFilter($where, ew_QuotedName('iddetalle_documento_debito') . '=' . ew_QuotedValue($rs['iddetalle_documento_debito'], $this->iddetalle_documento_debito->FldDataType));
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
		return "`iddetalle_documento_debito` = @iddetalle_documento_debito@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->iddetalle_documento_debito->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@iddetalle_documento_debito@", ew_AdjustSql($this->iddetalle_documento_debito->CurrentValue), $sKeyFilter); // Replace key value
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
			return "detalle_documento_debitolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "detalle_documento_debitolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("detalle_documento_debitoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("detalle_documento_debitoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "detalle_documento_debitoadd.php?" . $this->UrlParm($parm);
		else
			return "detalle_documento_debitoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("detalle_documento_debitoedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("detalle_documento_debitoadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("detalle_documento_debitodelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->iddetalle_documento_debito->CurrentValue)) {
			$sUrl .= "iddetalle_documento_debito=" . urlencode($this->iddetalle_documento_debito->CurrentValue);
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
			$arKeys[] = @$_GET["iddetalle_documento_debito"]; // iddetalle_documento_debito

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
			$this->iddetalle_documento_debito->CurrentValue = $key;
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
		$this->iddetalle_documento_debito->setDbValue($rs->fields('iddetalle_documento_debito'));
		$this->iddocumento_debito->setDbValue($rs->fields('iddocumento_debito'));
		$this->idproducto->setDbValue($rs->fields('idproducto'));
		$this->idbodega->setDbValue($rs->fields('idbodega'));
		$this->cantidad->setDbValue($rs->fields('cantidad'));
		$this->precio->setDbValue($rs->fields('precio'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->importe_descuento->setDbValue($rs->fields('importe_descuento'));
		$this->importe_bruto->setDbValue($rs->fields('importe_bruto'));
		$this->importe_exento->setDbValue($rs->fields('importe_exento'));
		$this->importe_neto->setDbValue($rs->fields('importe_neto'));
		$this->importe_iva->setDbValue($rs->fields('importe_iva'));
		$this->importe_otros_impuestos->setDbValue($rs->fields('importe_otros_impuestos'));
		$this->importe_total->setDbValue($rs->fields('importe_total'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// iddetalle_documento_debito
		// iddocumento_debito
		// idproducto
		// idbodega
		// cantidad
		// precio
		// monto
		// estado
		// fecha_insercion
		// importe_descuento
		// importe_bruto
		// importe_exento
		// importe_neto
		// importe_iva
		// importe_otros_impuestos
		// importe_total
		// iddetalle_documento_debito

		$this->iddetalle_documento_debito->ViewValue = $this->iddetalle_documento_debito->CurrentValue;
		$this->iddetalle_documento_debito->ViewCustomAttributes = "";

		// iddocumento_debito
		if (strval($this->iddocumento_debito->CurrentValue) <> "") {
			$sFilterWrk = "`iddocumento_debito`" . ew_SearchString("=", $this->iddocumento_debito->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->iddocumento_debito, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `correlativo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->iddocumento_debito->ViewValue = $rswrk->fields('DispFld');
				$this->iddocumento_debito->ViewValue .= ew_ValueSeparator(2,$this->iddocumento_debito) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->iddocumento_debito->ViewValue = $this->iddocumento_debito->CurrentValue;
			}
		} else {
			$this->iddocumento_debito->ViewValue = NULL;
		}
		$this->iddocumento_debito->ViewCustomAttributes = "";

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

		// cantidad
		$this->cantidad->ViewValue = $this->cantidad->CurrentValue;
		$this->cantidad->ViewCustomAttributes = "";

		// precio
		$this->precio->ViewValue = $this->precio->CurrentValue;
		$this->precio->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

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

		// importe_descuento
		$this->importe_descuento->ViewValue = $this->importe_descuento->CurrentValue;
		$this->importe_descuento->ViewCustomAttributes = "";

		// importe_bruto
		$this->importe_bruto->ViewValue = $this->importe_bruto->CurrentValue;
		$this->importe_bruto->ViewCustomAttributes = "";

		// importe_exento
		$this->importe_exento->ViewValue = $this->importe_exento->CurrentValue;
		$this->importe_exento->ViewCustomAttributes = "";

		// importe_neto
		$this->importe_neto->ViewValue = $this->importe_neto->CurrentValue;
		$this->importe_neto->ViewCustomAttributes = "";

		// importe_iva
		$this->importe_iva->ViewValue = $this->importe_iva->CurrentValue;
		$this->importe_iva->ViewCustomAttributes = "";

		// importe_otros_impuestos
		$this->importe_otros_impuestos->ViewValue = $this->importe_otros_impuestos->CurrentValue;
		$this->importe_otros_impuestos->ViewCustomAttributes = "";

		// importe_total
		$this->importe_total->ViewValue = $this->importe_total->CurrentValue;
		$this->importe_total->ViewCustomAttributes = "";

		// iddetalle_documento_debito
		$this->iddetalle_documento_debito->LinkCustomAttributes = "";
		$this->iddetalle_documento_debito->HrefValue = "";
		$this->iddetalle_documento_debito->TooltipValue = "";

		// iddocumento_debito
		$this->iddocumento_debito->LinkCustomAttributes = "";
		$this->iddocumento_debito->HrefValue = "";
		$this->iddocumento_debito->TooltipValue = "";

		// idproducto
		$this->idproducto->LinkCustomAttributes = "";
		$this->idproducto->HrefValue = "";
		$this->idproducto->TooltipValue = "";

		// idbodega
		$this->idbodega->LinkCustomAttributes = "";
		$this->idbodega->HrefValue = "";
		$this->idbodega->TooltipValue = "";

		// cantidad
		$this->cantidad->LinkCustomAttributes = "";
		$this->cantidad->HrefValue = "";
		$this->cantidad->TooltipValue = "";

		// precio
		$this->precio->LinkCustomAttributes = "";
		$this->precio->HrefValue = "";
		$this->precio->TooltipValue = "";

		// monto
		$this->monto->LinkCustomAttributes = "";
		$this->monto->HrefValue = "";
		$this->monto->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// importe_descuento
		$this->importe_descuento->LinkCustomAttributes = "";
		$this->importe_descuento->HrefValue = "";
		$this->importe_descuento->TooltipValue = "";

		// importe_bruto
		$this->importe_bruto->LinkCustomAttributes = "";
		$this->importe_bruto->HrefValue = "";
		$this->importe_bruto->TooltipValue = "";

		// importe_exento
		$this->importe_exento->LinkCustomAttributes = "";
		$this->importe_exento->HrefValue = "";
		$this->importe_exento->TooltipValue = "";

		// importe_neto
		$this->importe_neto->LinkCustomAttributes = "";
		$this->importe_neto->HrefValue = "";
		$this->importe_neto->TooltipValue = "";

		// importe_iva
		$this->importe_iva->LinkCustomAttributes = "";
		$this->importe_iva->HrefValue = "";
		$this->importe_iva->TooltipValue = "";

		// importe_otros_impuestos
		$this->importe_otros_impuestos->LinkCustomAttributes = "";
		$this->importe_otros_impuestos->HrefValue = "";
		$this->importe_otros_impuestos->TooltipValue = "";

		// importe_total
		$this->importe_total->LinkCustomAttributes = "";
		$this->importe_total->HrefValue = "";
		$this->importe_total->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// iddetalle_documento_debito
		$this->iddetalle_documento_debito->EditAttrs["class"] = "form-control";
		$this->iddetalle_documento_debito->EditCustomAttributes = "";
		$this->iddetalle_documento_debito->EditValue = $this->iddetalle_documento_debito->CurrentValue;
		$this->iddetalle_documento_debito->ViewCustomAttributes = "";

		// iddocumento_debito
		$this->iddocumento_debito->EditAttrs["class"] = "form-control";
		$this->iddocumento_debito->EditCustomAttributes = "";
		if ($this->iddocumento_debito->getSessionValue() <> "") {
			$this->iddocumento_debito->CurrentValue = $this->iddocumento_debito->getSessionValue();
		if (strval($this->iddocumento_debito->CurrentValue) <> "") {
			$sFilterWrk = "`iddocumento_debito`" . ew_SearchString("=", $this->iddocumento_debito->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `iddocumento_debito`, `serie` AS `DispFld`, '' AS `Disp2Fld`, `correlativo` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `documento_debito`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->iddocumento_debito, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `correlativo`";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->iddocumento_debito->ViewValue = $rswrk->fields('DispFld');
				$this->iddocumento_debito->ViewValue .= ew_ValueSeparator(2,$this->iddocumento_debito) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->iddocumento_debito->ViewValue = $this->iddocumento_debito->CurrentValue;
			}
		} else {
			$this->iddocumento_debito->ViewValue = NULL;
		}
		$this->iddocumento_debito->ViewCustomAttributes = "";
		} else {
		}

		// idproducto
		$this->idproducto->EditAttrs["class"] = "form-control";
		$this->idproducto->EditCustomAttributes = "";

		// idbodega
		$this->idbodega->EditAttrs["class"] = "form-control";
		$this->idbodega->EditCustomAttributes = "";

		// cantidad
		$this->cantidad->EditAttrs["class"] = "form-control";
		$this->cantidad->EditCustomAttributes = "";
		$this->cantidad->EditValue = ew_HtmlEncode($this->cantidad->CurrentValue);
		$this->cantidad->PlaceHolder = ew_RemoveHtml($this->cantidad->FldCaption());

		// precio
		$this->precio->EditAttrs["class"] = "form-control";
		$this->precio->EditCustomAttributes = "";
		$this->precio->EditValue = ew_HtmlEncode($this->precio->CurrentValue);
		$this->precio->PlaceHolder = ew_RemoveHtml($this->precio->FldCaption());
		if (strval($this->precio->EditValue) <> "" && is_numeric($this->precio->EditValue)) $this->precio->EditValue = ew_FormatNumber($this->precio->EditValue, -2, -1, -2, 0);

		// monto
		$this->monto->EditAttrs["class"] = "form-control";
		$this->monto->EditCustomAttributes = "";
		$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
		$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
		if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

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

		// importe_descuento
		$this->importe_descuento->EditAttrs["class"] = "form-control";
		$this->importe_descuento->EditCustomAttributes = "";
		$this->importe_descuento->EditValue = ew_HtmlEncode($this->importe_descuento->CurrentValue);
		$this->importe_descuento->PlaceHolder = ew_RemoveHtml($this->importe_descuento->FldCaption());
		if (strval($this->importe_descuento->EditValue) <> "" && is_numeric($this->importe_descuento->EditValue)) $this->importe_descuento->EditValue = ew_FormatNumber($this->importe_descuento->EditValue, -2, -1, -2, 0);

		// importe_bruto
		$this->importe_bruto->EditAttrs["class"] = "form-control";
		$this->importe_bruto->EditCustomAttributes = "";
		$this->importe_bruto->EditValue = ew_HtmlEncode($this->importe_bruto->CurrentValue);
		$this->importe_bruto->PlaceHolder = ew_RemoveHtml($this->importe_bruto->FldCaption());
		if (strval($this->importe_bruto->EditValue) <> "" && is_numeric($this->importe_bruto->EditValue)) $this->importe_bruto->EditValue = ew_FormatNumber($this->importe_bruto->EditValue, -2, -1, -2, 0);

		// importe_exento
		$this->importe_exento->EditAttrs["class"] = "form-control";
		$this->importe_exento->EditCustomAttributes = "";
		$this->importe_exento->EditValue = ew_HtmlEncode($this->importe_exento->CurrentValue);
		$this->importe_exento->PlaceHolder = ew_RemoveHtml($this->importe_exento->FldCaption());
		if (strval($this->importe_exento->EditValue) <> "" && is_numeric($this->importe_exento->EditValue)) $this->importe_exento->EditValue = ew_FormatNumber($this->importe_exento->EditValue, -2, -1, -2, 0);

		// importe_neto
		$this->importe_neto->EditAttrs["class"] = "form-control";
		$this->importe_neto->EditCustomAttributes = "";
		$this->importe_neto->EditValue = ew_HtmlEncode($this->importe_neto->CurrentValue);
		$this->importe_neto->PlaceHolder = ew_RemoveHtml($this->importe_neto->FldCaption());
		if (strval($this->importe_neto->EditValue) <> "" && is_numeric($this->importe_neto->EditValue)) $this->importe_neto->EditValue = ew_FormatNumber($this->importe_neto->EditValue, -2, -1, -2, 0);

		// importe_iva
		$this->importe_iva->EditAttrs["class"] = "form-control";
		$this->importe_iva->EditCustomAttributes = "";
		$this->importe_iva->EditValue = ew_HtmlEncode($this->importe_iva->CurrentValue);
		$this->importe_iva->PlaceHolder = ew_RemoveHtml($this->importe_iva->FldCaption());
		if (strval($this->importe_iva->EditValue) <> "" && is_numeric($this->importe_iva->EditValue)) $this->importe_iva->EditValue = ew_FormatNumber($this->importe_iva->EditValue, -2, -1, -2, 0);

		// importe_otros_impuestos
		$this->importe_otros_impuestos->EditAttrs["class"] = "form-control";
		$this->importe_otros_impuestos->EditCustomAttributes = "";
		$this->importe_otros_impuestos->EditValue = ew_HtmlEncode($this->importe_otros_impuestos->CurrentValue);
		$this->importe_otros_impuestos->PlaceHolder = ew_RemoveHtml($this->importe_otros_impuestos->FldCaption());
		if (strval($this->importe_otros_impuestos->EditValue) <> "" && is_numeric($this->importe_otros_impuestos->EditValue)) $this->importe_otros_impuestos->EditValue = ew_FormatNumber($this->importe_otros_impuestos->EditValue, -2, -1, -2, 0);

		// importe_total
		$this->importe_total->EditAttrs["class"] = "form-control";
		$this->importe_total->EditCustomAttributes = "";
		$this->importe_total->EditValue = ew_HtmlEncode($this->importe_total->CurrentValue);
		$this->importe_total->PlaceHolder = ew_RemoveHtml($this->importe_total->FldCaption());
		if (strval($this->importe_total->EditValue) <> "" && is_numeric($this->importe_total->EditValue)) $this->importe_total->EditValue = ew_FormatNumber($this->importe_total->EditValue, -2, -1, -2, 0);

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
					if ($this->iddocumento_debito->Exportable) $Doc->ExportCaption($this->iddocumento_debito);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega->Exportable) $Doc->ExportCaption($this->idbodega);
					if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
					if ($this->precio->Exportable) $Doc->ExportCaption($this->precio);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->importe_descuento->Exportable) $Doc->ExportCaption($this->importe_descuento);
					if ($this->importe_bruto->Exportable) $Doc->ExportCaption($this->importe_bruto);
					if ($this->importe_exento->Exportable) $Doc->ExportCaption($this->importe_exento);
					if ($this->importe_neto->Exportable) $Doc->ExportCaption($this->importe_neto);
					if ($this->importe_iva->Exportable) $Doc->ExportCaption($this->importe_iva);
					if ($this->importe_otros_impuestos->Exportable) $Doc->ExportCaption($this->importe_otros_impuestos);
					if ($this->importe_total->Exportable) $Doc->ExportCaption($this->importe_total);
				} else {
					if ($this->iddetalle_documento_debito->Exportable) $Doc->ExportCaption($this->iddetalle_documento_debito);
					if ($this->iddocumento_debito->Exportable) $Doc->ExportCaption($this->iddocumento_debito);
					if ($this->idproducto->Exportable) $Doc->ExportCaption($this->idproducto);
					if ($this->idbodega->Exportable) $Doc->ExportCaption($this->idbodega);
					if ($this->cantidad->Exportable) $Doc->ExportCaption($this->cantidad);
					if ($this->precio->Exportable) $Doc->ExportCaption($this->precio);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->importe_descuento->Exportable) $Doc->ExportCaption($this->importe_descuento);
					if ($this->importe_bruto->Exportable) $Doc->ExportCaption($this->importe_bruto);
					if ($this->importe_exento->Exportable) $Doc->ExportCaption($this->importe_exento);
					if ($this->importe_neto->Exportable) $Doc->ExportCaption($this->importe_neto);
					if ($this->importe_iva->Exportable) $Doc->ExportCaption($this->importe_iva);
					if ($this->importe_otros_impuestos->Exportable) $Doc->ExportCaption($this->importe_otros_impuestos);
					if ($this->importe_total->Exportable) $Doc->ExportCaption($this->importe_total);
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
						if ($this->iddocumento_debito->Exportable) $Doc->ExportField($this->iddocumento_debito);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega->Exportable) $Doc->ExportField($this->idbodega);
						if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
						if ($this->precio->Exportable) $Doc->ExportField($this->precio);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->importe_descuento->Exportable) $Doc->ExportField($this->importe_descuento);
						if ($this->importe_bruto->Exportable) $Doc->ExportField($this->importe_bruto);
						if ($this->importe_exento->Exportable) $Doc->ExportField($this->importe_exento);
						if ($this->importe_neto->Exportable) $Doc->ExportField($this->importe_neto);
						if ($this->importe_iva->Exportable) $Doc->ExportField($this->importe_iva);
						if ($this->importe_otros_impuestos->Exportable) $Doc->ExportField($this->importe_otros_impuestos);
						if ($this->importe_total->Exportable) $Doc->ExportField($this->importe_total);
					} else {
						if ($this->iddetalle_documento_debito->Exportable) $Doc->ExportField($this->iddetalle_documento_debito);
						if ($this->iddocumento_debito->Exportable) $Doc->ExportField($this->iddocumento_debito);
						if ($this->idproducto->Exportable) $Doc->ExportField($this->idproducto);
						if ($this->idbodega->Exportable) $Doc->ExportField($this->idbodega);
						if ($this->cantidad->Exportable) $Doc->ExportField($this->cantidad);
						if ($this->precio->Exportable) $Doc->ExportField($this->precio);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->importe_descuento->Exportable) $Doc->ExportField($this->importe_descuento);
						if ($this->importe_bruto->Exportable) $Doc->ExportField($this->importe_bruto);
						if ($this->importe_exento->Exportable) $Doc->ExportField($this->importe_exento);
						if ($this->importe_neto->Exportable) $Doc->ExportField($this->importe_neto);
						if ($this->importe_iva->Exportable) $Doc->ExportField($this->importe_iva);
						if ($this->importe_otros_impuestos->Exportable) $Doc->ExportField($this->importe_otros_impuestos);
						if ($this->importe_total->Exportable) $Doc->ExportField($this->importe_total);
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
