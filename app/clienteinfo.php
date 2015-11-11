<?php

// Global variable for table object
$cliente = NULL;

//
// Table class for cliente
//
class ccliente extends cTable {
	var $idcliente;
	var $idpersona;
	var $codigo;
	var $nit;
	var $nombre_factura;
	var $direccion_factura;
	var $debito;
	var $credito;
	var $_email;
	var $fecha_insercion;
	var $estado;
	var $telefono;
	var $tributa;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cliente';
		$this->TableName = 'cliente';
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

		// idcliente
		$this->idcliente = new cField('cliente', 'cliente', 'x_idcliente', 'idcliente', '`idcliente`', '`idcliente`', 3, -1, FALSE, '`idcliente`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idcliente->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcliente'] = &$this->idcliente;

		// idpersona
		$this->idpersona = new cField('cliente', 'cliente', 'x_idpersona', 'idpersona', '`idpersona`', '`idpersona`', 3, -1, FALSE, '`idpersona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idpersona->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idpersona'] = &$this->idpersona;

		// codigo
		$this->codigo = new cField('cliente', 'cliente', 'x_codigo', 'codigo', '`codigo`', '`codigo`', 200, -1, FALSE, '`codigo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['codigo'] = &$this->codigo;

		// nit
		$this->nit = new cField('cliente', 'cliente', 'x_nit', 'nit', '`nit`', '`nit`', 200, -1, FALSE, '`nit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nit'] = &$this->nit;

		// nombre_factura
		$this->nombre_factura = new cField('cliente', 'cliente', 'x_nombre_factura', 'nombre_factura', '`nombre_factura`', '`nombre_factura`', 200, -1, FALSE, '`nombre_factura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nombre_factura'] = &$this->nombre_factura;

		// direccion_factura
		$this->direccion_factura = new cField('cliente', 'cliente', 'x_direccion_factura', 'direccion_factura', '`direccion_factura`', '`direccion_factura`', 200, -1, FALSE, '`direccion_factura`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['direccion_factura'] = &$this->direccion_factura;

		// debito
		$this->debito = new cField('cliente', 'cliente', 'x_debito', 'debito', '`debito`', '`debito`', 131, -1, FALSE, '`debito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->debito->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['debito'] = &$this->debito;

		// credito
		$this->credito = new cField('cliente', 'cliente', 'x_credito', 'credito', '`credito`', '`credito`', 131, -1, FALSE, '`credito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->credito->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['credito'] = &$this->credito;

		// email
		$this->_email = new cField('cliente', 'cliente', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->_email->FldDefaultErrMsg = $Language->Phrase("IncorrectEmail");
		$this->fields['email'] = &$this->_email;

		// fecha_insercion
		$this->fecha_insercion = new cField('cliente', 'cliente', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// estado
		$this->estado = new cField('cliente', 'cliente', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// telefono
		$this->telefono = new cField('cliente', 'cliente', 'x_telefono', 'telefono', '`telefono`', '`telefono`', 200, -1, FALSE, '`telefono`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['telefono'] = &$this->telefono;

		// tributa
		$this->tributa = new cField('cliente', 'cliente', 'x_tributa', 'tributa', '`tributa`', '`tributa`', 202, -1, FALSE, '`tributa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['tributa'] = &$this->tributa;
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
		if ($this->getCurrentMasterTable() == "persona") {
			if ($this->idpersona->getSessionValue() <> "")
				$sMasterFilter .= "`idpersona`=" . ew_QuotedValue($this->idpersona->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "persona") {
			if ($this->idpersona->getSessionValue() <> "")
				$sDetailFilter .= "`idpersona`=" . ew_QuotedValue($this->idpersona->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_persona() {
		return "`idpersona`=@idpersona@";
	}

	// Detail filter
	function SqlDetailFilter_persona() {
		return "`idpersona`=@idpersona@";
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
			$sDetailUrl .= "&fk_idcliente=" . urlencode($this->idcliente->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "clientelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cliente`";
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
	var $UpdateTable = "`cliente`";

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

		// Cascade update detail field 'idcliente'
		if (!is_null($rsold) && (isset($rs['idcliente']) && $rsold['idcliente'] <> $rs['idcliente'])) {
			if (!isset($GLOBALS["pago_cliente"])) $GLOBALS["pago_cliente"] = new cpago_cliente();
			$rscascade = array();
			$rscascade['idcliente'] = $rs['idcliente']; 
			$GLOBALS["pago_cliente"]->Update($rscascade, "`idcliente` = " . ew_QuotedValue($rsold['idcliente'], EW_DATATYPE_NUMBER));
		}
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('idcliente', $rs))
				ew_AddFilter($where, ew_QuotedName('idcliente') . '=' . ew_QuotedValue($rs['idcliente'], $this->idcliente->FldDataType));
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

		// Cascade delete detail table 'pago_cliente'
		if (!isset($GLOBALS["pago_cliente"])) $GLOBALS["pago_cliente"] = new cpago_cliente();
		$rscascade = array();
		$GLOBALS["pago_cliente"]->Delete($rscascade, "`idcliente` = " . ew_QuotedValue($rs['idcliente'], EW_DATATYPE_NUMBER));
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`idcliente` = @idcliente@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idcliente->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idcliente@", ew_AdjustSql($this->idcliente->CurrentValue), $sKeyFilter); // Replace key value
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
			return "clientelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "clientelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("clienteview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("clienteview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "clienteadd.php?" . $this->UrlParm($parm);
		else
			return "clienteadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("clienteedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("clienteedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("clienteadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("clienteadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("clientedelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idcliente->CurrentValue)) {
			$sUrl .= "idcliente=" . urlencode($this->idcliente->CurrentValue);
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
			$arKeys[] = @$_GET["idcliente"]; // idcliente

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
			$this->idcliente->CurrentValue = $key;
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
		$this->idcliente->setDbValue($rs->fields('idcliente'));
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->codigo->setDbValue($rs->fields('codigo'));
		$this->nit->setDbValue($rs->fields('nit'));
		$this->nombre_factura->setDbValue($rs->fields('nombre_factura'));
		$this->direccion_factura->setDbValue($rs->fields('direccion_factura'));
		$this->debito->setDbValue($rs->fields('debito'));
		$this->credito->setDbValue($rs->fields('credito'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->telefono->setDbValue($rs->fields('telefono'));
		$this->tributa->setDbValue($rs->fields('tributa'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idcliente
		// idpersona
		// codigo
		// nit
		// nombre_factura
		// direccion_factura
		// debito
		// credito
		// email
		// fecha_insercion
		// estado
		// telefono
		// tributa
		// idcliente

		$this->idcliente->ViewValue = $this->idcliente->CurrentValue;
		$this->idcliente->ViewCustomAttributes = "";

		// idpersona
		if (strval($this->idpersona->CurrentValue) <> "") {
			$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, `apellido` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idpersona, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idpersona->ViewValue = $rswrk->fields('DispFld');
				$this->idpersona->ViewValue .= ew_ValueSeparator(2,$this->idpersona) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			}
		} else {
			$this->idpersona->ViewValue = NULL;
		}
		$this->idpersona->ViewCustomAttributes = "";

		// codigo
		$this->codigo->ViewValue = $this->codigo->CurrentValue;
		$this->codigo->ViewCustomAttributes = "";

		// nit
		$this->nit->ViewValue = $this->nit->CurrentValue;
		$this->nit->ViewCustomAttributes = "";

		// nombre_factura
		$this->nombre_factura->ViewValue = $this->nombre_factura->CurrentValue;
		$this->nombre_factura->ViewCustomAttributes = "";

		// direccion_factura
		$this->direccion_factura->ViewValue = $this->direccion_factura->CurrentValue;
		$this->direccion_factura->ViewCustomAttributes = "";

		// debito
		$this->debito->ViewValue = $this->debito->CurrentValue;
		$this->debito->ViewCustomAttributes = "";

		// credito
		$this->credito->ViewValue = $this->credito->CurrentValue;
		$this->credito->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

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

		// telefono
		$this->telefono->ViewValue = $this->telefono->CurrentValue;
		$this->telefono->ViewCustomAttributes = "";

		// tributa
		if (strval($this->tributa->CurrentValue) <> "") {
			switch ($this->tributa->CurrentValue) {
				case $this->tributa->FldTagValue(1):
					$this->tributa->ViewValue = $this->tributa->FldTagCaption(1) <> "" ? $this->tributa->FldTagCaption(1) : $this->tributa->CurrentValue;
					break;
				case $this->tributa->FldTagValue(2):
					$this->tributa->ViewValue = $this->tributa->FldTagCaption(2) <> "" ? $this->tributa->FldTagCaption(2) : $this->tributa->CurrentValue;
					break;
				default:
					$this->tributa->ViewValue = $this->tributa->CurrentValue;
			}
		} else {
			$this->tributa->ViewValue = NULL;
		}
		$this->tributa->ViewCustomAttributes = "";

		// idcliente
		$this->idcliente->LinkCustomAttributes = "";
		$this->idcliente->HrefValue = "";
		$this->idcliente->TooltipValue = "";

		// idpersona
		$this->idpersona->LinkCustomAttributes = "";
		$this->idpersona->HrefValue = "";
		$this->idpersona->TooltipValue = "";

		// codigo
		$this->codigo->LinkCustomAttributes = "";
		$this->codigo->HrefValue = "";
		$this->codigo->TooltipValue = "";

		// nit
		$this->nit->LinkCustomAttributes = "";
		$this->nit->HrefValue = "";
		$this->nit->TooltipValue = "";

		// nombre_factura
		$this->nombre_factura->LinkCustomAttributes = "";
		$this->nombre_factura->HrefValue = "";
		$this->nombre_factura->TooltipValue = "";

		// direccion_factura
		$this->direccion_factura->LinkCustomAttributes = "";
		$this->direccion_factura->HrefValue = "";
		$this->direccion_factura->TooltipValue = "";

		// debito
		$this->debito->LinkCustomAttributes = "";
		$this->debito->HrefValue = "";
		$this->debito->TooltipValue = "";

		// credito
		$this->credito->LinkCustomAttributes = "";
		$this->credito->HrefValue = "";
		$this->credito->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// telefono
		$this->telefono->LinkCustomAttributes = "";
		$this->telefono->HrefValue = "";
		$this->telefono->TooltipValue = "";

		// tributa
		$this->tributa->LinkCustomAttributes = "";
		$this->tributa->HrefValue = "";
		$this->tributa->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idcliente
		$this->idcliente->EditAttrs["class"] = "form-control";
		$this->idcliente->EditCustomAttributes = "";
		$this->idcliente->EditValue = $this->idcliente->CurrentValue;
		$this->idcliente->ViewCustomAttributes = "";

		// idpersona
		$this->idpersona->EditAttrs["class"] = "form-control";
		$this->idpersona->EditCustomAttributes = "";
		if ($this->idpersona->getSessionValue() <> "") {
			$this->idpersona->CurrentValue = $this->idpersona->getSessionValue();
		if (strval($this->idpersona->CurrentValue) <> "") {
			$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, `apellido` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		if (strval($lookuptblfilter) <> "") {
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
		}
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->idpersona, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->idpersona->ViewValue = $rswrk->fields('DispFld');
				$this->idpersona->ViewValue .= ew_ValueSeparator(2,$this->idpersona) . $rswrk->fields('Disp3Fld');
				$rswrk->Close();
			} else {
				$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			}
		} else {
			$this->idpersona->ViewValue = NULL;
		}
		$this->idpersona->ViewCustomAttributes = "";
		} else {
		}

		// codigo
		$this->codigo->EditAttrs["class"] = "form-control";
		$this->codigo->EditCustomAttributes = "";
		$this->codigo->EditValue = ew_HtmlEncode($this->codigo->CurrentValue);
		$this->codigo->PlaceHolder = ew_RemoveHtml($this->codigo->FldCaption());

		// nit
		$this->nit->EditAttrs["class"] = "form-control";
		$this->nit->EditCustomAttributes = "";
		$this->nit->EditValue = ew_HtmlEncode($this->nit->CurrentValue);
		$this->nit->PlaceHolder = ew_RemoveHtml($this->nit->FldCaption());

		// nombre_factura
		$this->nombre_factura->EditAttrs["class"] = "form-control";
		$this->nombre_factura->EditCustomAttributes = "";
		$this->nombre_factura->EditValue = ew_HtmlEncode($this->nombre_factura->CurrentValue);
		$this->nombre_factura->PlaceHolder = ew_RemoveHtml($this->nombre_factura->FldCaption());

		// direccion_factura
		$this->direccion_factura->EditAttrs["class"] = "form-control";
		$this->direccion_factura->EditCustomAttributes = "";
		$this->direccion_factura->EditValue = ew_HtmlEncode($this->direccion_factura->CurrentValue);
		$this->direccion_factura->PlaceHolder = ew_RemoveHtml($this->direccion_factura->FldCaption());

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

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// fecha_insercion
		$this->fecha_insercion->EditAttrs["class"] = "form-control";
		$this->fecha_insercion->EditCustomAttributes = "";
		$this->fecha_insercion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_insercion->CurrentValue, 7));
		$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
		$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->estado->EditValue = $arwrk;

		// telefono
		$this->telefono->EditAttrs["class"] = "form-control";
		$this->telefono->EditCustomAttributes = "";
		$this->telefono->EditValue = ew_HtmlEncode($this->telefono->CurrentValue);
		$this->telefono->PlaceHolder = ew_RemoveHtml($this->telefono->FldCaption());

		// tributa
		$this->tributa->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->tributa->FldTagValue(1), $this->tributa->FldTagCaption(1) <> "" ? $this->tributa->FldTagCaption(1) : $this->tributa->FldTagValue(1));
		$arwrk[] = array($this->tributa->FldTagValue(2), $this->tributa->FldTagCaption(2) <> "" ? $this->tributa->FldTagCaption(2) : $this->tributa->FldTagValue(2));
		$this->tributa->EditValue = $arwrk;

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
					if ($this->idcliente->Exportable) $Doc->ExportCaption($this->idcliente);
					if ($this->idpersona->Exportable) $Doc->ExportCaption($this->idpersona);
					if ($this->codigo->Exportable) $Doc->ExportCaption($this->codigo);
					if ($this->nit->Exportable) $Doc->ExportCaption($this->nit);
					if ($this->nombre_factura->Exportable) $Doc->ExportCaption($this->nombre_factura);
					if ($this->direccion_factura->Exportable) $Doc->ExportCaption($this->direccion_factura);
					if ($this->debito->Exportable) $Doc->ExportCaption($this->debito);
					if ($this->credito->Exportable) $Doc->ExportCaption($this->credito);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->telefono->Exportable) $Doc->ExportCaption($this->telefono);
					if ($this->tributa->Exportable) $Doc->ExportCaption($this->tributa);
				} else {
					if ($this->idcliente->Exportable) $Doc->ExportCaption($this->idcliente);
					if ($this->idpersona->Exportable) $Doc->ExportCaption($this->idpersona);
					if ($this->codigo->Exportable) $Doc->ExportCaption($this->codigo);
					if ($this->nit->Exportable) $Doc->ExportCaption($this->nit);
					if ($this->nombre_factura->Exportable) $Doc->ExportCaption($this->nombre_factura);
					if ($this->direccion_factura->Exportable) $Doc->ExportCaption($this->direccion_factura);
					if ($this->debito->Exportable) $Doc->ExportCaption($this->debito);
					if ($this->credito->Exportable) $Doc->ExportCaption($this->credito);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->telefono->Exportable) $Doc->ExportCaption($this->telefono);
					if ($this->tributa->Exportable) $Doc->ExportCaption($this->tributa);
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
						if ($this->idcliente->Exportable) $Doc->ExportField($this->idcliente);
						if ($this->idpersona->Exportable) $Doc->ExportField($this->idpersona);
						if ($this->codigo->Exportable) $Doc->ExportField($this->codigo);
						if ($this->nit->Exportable) $Doc->ExportField($this->nit);
						if ($this->nombre_factura->Exportable) $Doc->ExportField($this->nombre_factura);
						if ($this->direccion_factura->Exportable) $Doc->ExportField($this->direccion_factura);
						if ($this->debito->Exportable) $Doc->ExportField($this->debito);
						if ($this->credito->Exportable) $Doc->ExportField($this->credito);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->telefono->Exportable) $Doc->ExportField($this->telefono);
						if ($this->tributa->Exportable) $Doc->ExportField($this->tributa);
					} else {
						if ($this->idcliente->Exportable) $Doc->ExportField($this->idcliente);
						if ($this->idpersona->Exportable) $Doc->ExportField($this->idpersona);
						if ($this->codigo->Exportable) $Doc->ExportField($this->codigo);
						if ($this->nit->Exportable) $Doc->ExportField($this->nit);
						if ($this->nombre_factura->Exportable) $Doc->ExportField($this->nombre_factura);
						if ($this->direccion_factura->Exportable) $Doc->ExportField($this->direccion_factura);
						if ($this->debito->Exportable) $Doc->ExportField($this->debito);
						if ($this->credito->Exportable) $Doc->ExportField($this->credito);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->telefono->Exportable) $Doc->ExportField($this->telefono);
						if ($this->tributa->Exportable) $Doc->ExportField($this->tributa);
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
