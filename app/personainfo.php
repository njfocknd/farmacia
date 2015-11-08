<?php

// Global variable for table object
$persona = NULL;

//
// Table class for persona
//
class cpersona extends cTable {
	var $idpersona;
	var $tipo_persona;
	var $nombre;
	var $apellido;
	var $direccion;
	var $cui;
	var $idpais;
	var $fecha_nacimiento;
	var $_email;
	var $sexo;
	var $estado;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'persona';
		$this->TableName = 'persona';
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

		// idpersona
		$this->idpersona = new cField('persona', 'persona', 'x_idpersona', 'idpersona', '`idpersona`', '`idpersona`', 3, -1, FALSE, '`idpersona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idpersona->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idpersona'] = &$this->idpersona;

		// tipo_persona
		$this->tipo_persona = new cField('persona', 'persona', 'x_tipo_persona', 'tipo_persona', '`tipo_persona`', '`tipo_persona`', 202, -1, FALSE, '`tipo_persona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['tipo_persona'] = &$this->tipo_persona;

		// nombre
		$this->nombre = new cField('persona', 'persona', 'x_nombre', 'nombre', '`nombre`', '`nombre`', 200, -1, FALSE, '`nombre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nombre'] = &$this->nombre;

		// apellido
		$this->apellido = new cField('persona', 'persona', 'x_apellido', 'apellido', '`apellido`', '`apellido`', 200, -1, FALSE, '`apellido`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['apellido'] = &$this->apellido;

		// direccion
		$this->direccion = new cField('persona', 'persona', 'x_direccion', 'direccion', '`direccion`', '`direccion`', 200, -1, FALSE, '`direccion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['direccion'] = &$this->direccion;

		// cui
		$this->cui = new cField('persona', 'persona', 'x_cui', 'cui', '`cui`', '`cui`', 200, -1, FALSE, '`cui`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cui'] = &$this->cui;

		// idpais
		$this->idpais = new cField('persona', 'persona', 'x_idpais', 'idpais', '`idpais`', '`idpais`', 3, -1, FALSE, '`idpais`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->idpais->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idpais'] = &$this->idpais;

		// fecha_nacimiento
		$this->fecha_nacimiento = new cField('persona', 'persona', 'x_fecha_nacimiento', 'fecha_nacimiento', '`fecha_nacimiento`', 'DATE_FORMAT(`fecha_nacimiento`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha_nacimiento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fecha_nacimiento->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_nacimiento'] = &$this->fecha_nacimiento;

		// email
		$this->_email = new cField('persona', 'persona', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->_email->FldDefaultErrMsg = $Language->Phrase("IncorrectEmail");
		$this->fields['email'] = &$this->_email;

		// sexo
		$this->sexo = new cField('persona', 'persona', 'x_sexo', 'sexo', '`sexo`', '`sexo`', 202, -1, FALSE, '`sexo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sexo'] = &$this->sexo;

		// estado
		$this->estado = new cField('persona', 'persona', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('persona', 'persona', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentDetailTable() == "cliente") {
			$sDetailUrl = $GLOBALS["cliente"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&fk_idpersona=" . urlencode($this->idpersona->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "personalist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`persona`";
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
	var $UpdateTable = "`persona`";

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
			if (array_key_exists('idpersona', $rs))
				ew_AddFilter($where, ew_QuotedName('idpersona') . '=' . ew_QuotedValue($rs['idpersona'], $this->idpersona->FldDataType));
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
		return "`idpersona` = @idpersona@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idpersona->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idpersona@", ew_AdjustSql($this->idpersona->CurrentValue), $sKeyFilter); // Replace key value
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
			return "personalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "personalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personaview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			return "personaadd.php?" . $this->UrlParm($parm);
		else
			return "personaadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personaedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personaedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personaadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personaadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("personadelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idpersona->CurrentValue)) {
			$sUrl .= "idpersona=" . urlencode($this->idpersona->CurrentValue);
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
			$arKeys[] = @$_GET["idpersona"]; // idpersona

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
			$this->idpersona->CurrentValue = $key;
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
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->tipo_persona->setDbValue($rs->fields('tipo_persona'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->apellido->setDbValue($rs->fields('apellido'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->cui->setDbValue($rs->fields('cui'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->fecha_nacimiento->setDbValue($rs->fields('fecha_nacimiento'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->sexo->setDbValue($rs->fields('sexo'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idpersona
		// tipo_persona
		// nombre
		// apellido
		// direccion
		// cui
		// idpais
		// fecha_nacimiento
		// email
		// sexo
		// estado
		// fecha_insercion
		// idpersona

		$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
		$this->idpersona->ViewCustomAttributes = "";

		// tipo_persona
		if (strval($this->tipo_persona->CurrentValue) <> "") {
			switch ($this->tipo_persona->CurrentValue) {
				case $this->tipo_persona->FldTagValue(1):
					$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(1) <> "" ? $this->tipo_persona->FldTagCaption(1) : $this->tipo_persona->CurrentValue;
					break;
				case $this->tipo_persona->FldTagValue(2):
					$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(2) <> "" ? $this->tipo_persona->FldTagCaption(2) : $this->tipo_persona->CurrentValue;
					break;
				default:
					$this->tipo_persona->ViewValue = $this->tipo_persona->CurrentValue;
			}
		} else {
			$this->tipo_persona->ViewValue = NULL;
		}
		$this->tipo_persona->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// apellido
		$this->apellido->ViewValue = $this->apellido->CurrentValue;
		$this->apellido->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

		// cui
		$this->cui->ViewValue = $this->cui->CurrentValue;
		$this->cui->ViewCustomAttributes = "";

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

		// fecha_nacimiento
		$this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
		$this->fecha_nacimiento->ViewValue = ew_FormatDateTime($this->fecha_nacimiento->ViewValue, 7);
		$this->fecha_nacimiento->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// sexo
		if (strval($this->sexo->CurrentValue) <> "") {
			switch ($this->sexo->CurrentValue) {
				case $this->sexo->FldTagValue(1):
					$this->sexo->ViewValue = $this->sexo->FldTagCaption(1) <> "" ? $this->sexo->FldTagCaption(1) : $this->sexo->CurrentValue;
					break;
				case $this->sexo->FldTagValue(2):
					$this->sexo->ViewValue = $this->sexo->FldTagCaption(2) <> "" ? $this->sexo->FldTagCaption(2) : $this->sexo->CurrentValue;
					break;
				default:
					$this->sexo->ViewValue = $this->sexo->CurrentValue;
			}
		} else {
			$this->sexo->ViewValue = NULL;
		}
		$this->sexo->ViewCustomAttributes = "";

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

		// idpersona
		$this->idpersona->LinkCustomAttributes = "";
		$this->idpersona->HrefValue = "";
		$this->idpersona->TooltipValue = "";

		// tipo_persona
		$this->tipo_persona->LinkCustomAttributes = "";
		$this->tipo_persona->HrefValue = "";
		$this->tipo_persona->TooltipValue = "";

		// nombre
		$this->nombre->LinkCustomAttributes = "";
		$this->nombre->HrefValue = "";
		$this->nombre->TooltipValue = "";

		// apellido
		$this->apellido->LinkCustomAttributes = "";
		$this->apellido->HrefValue = "";
		$this->apellido->TooltipValue = "";

		// direccion
		$this->direccion->LinkCustomAttributes = "";
		$this->direccion->HrefValue = "";
		$this->direccion->TooltipValue = "";

		// cui
		$this->cui->LinkCustomAttributes = "";
		$this->cui->HrefValue = "";
		$this->cui->TooltipValue = "";

		// idpais
		$this->idpais->LinkCustomAttributes = "";
		$this->idpais->HrefValue = "";
		$this->idpais->TooltipValue = "";

		// fecha_nacimiento
		$this->fecha_nacimiento->LinkCustomAttributes = "";
		$this->fecha_nacimiento->HrefValue = "";
		$this->fecha_nacimiento->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// sexo
		$this->sexo->LinkCustomAttributes = "";
		$this->sexo->HrefValue = "";
		$this->sexo->TooltipValue = "";

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

		// idpersona
		$this->idpersona->EditAttrs["class"] = "form-control";
		$this->idpersona->EditCustomAttributes = "";
		$this->idpersona->EditValue = $this->idpersona->CurrentValue;
		$this->idpersona->ViewCustomAttributes = "";

		// tipo_persona
		$this->tipo_persona->EditAttrs["class"] = "form-control";
		$this->tipo_persona->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->tipo_persona->FldTagValue(1), $this->tipo_persona->FldTagCaption(1) <> "" ? $this->tipo_persona->FldTagCaption(1) : $this->tipo_persona->FldTagValue(1));
		$arwrk[] = array($this->tipo_persona->FldTagValue(2), $this->tipo_persona->FldTagCaption(2) <> "" ? $this->tipo_persona->FldTagCaption(2) : $this->tipo_persona->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->tipo_persona->EditValue = $arwrk;

		// nombre
		$this->nombre->EditAttrs["class"] = "form-control";
		$this->nombre->EditCustomAttributes = "";
		$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
		$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

		// apellido
		$this->apellido->EditAttrs["class"] = "form-control";
		$this->apellido->EditCustomAttributes = "";
		$this->apellido->EditValue = ew_HtmlEncode($this->apellido->CurrentValue);
		$this->apellido->PlaceHolder = ew_RemoveHtml($this->apellido->FldCaption());

		// direccion
		$this->direccion->EditAttrs["class"] = "form-control";
		$this->direccion->EditCustomAttributes = "";
		$this->direccion->EditValue = ew_HtmlEncode($this->direccion->CurrentValue);
		$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

		// cui
		$this->cui->EditAttrs["class"] = "form-control";
		$this->cui->EditCustomAttributes = "";
		$this->cui->EditValue = ew_HtmlEncode($this->cui->CurrentValue);
		$this->cui->PlaceHolder = ew_RemoveHtml($this->cui->FldCaption());

		// idpais
		$this->idpais->EditAttrs["class"] = "form-control";
		$this->idpais->EditCustomAttributes = "";

		// fecha_nacimiento
		$this->fecha_nacimiento->EditAttrs["class"] = "form-control";
		$this->fecha_nacimiento->EditCustomAttributes = "";
		$this->fecha_nacimiento->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_nacimiento->CurrentValue, 7));
		$this->fecha_nacimiento->PlaceHolder = ew_RemoveHtml($this->fecha_nacimiento->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// sexo
		$this->sexo->EditAttrs["class"] = "form-control";
		$this->sexo->EditCustomAttributes = "";
		$arwrk = array();
		$arwrk[] = array($this->sexo->FldTagValue(1), $this->sexo->FldTagCaption(1) <> "" ? $this->sexo->FldTagCaption(1) : $this->sexo->FldTagValue(1));
		$arwrk[] = array($this->sexo->FldTagValue(2), $this->sexo->FldTagCaption(2) <> "" ? $this->sexo->FldTagCaption(2) : $this->sexo->FldTagValue(2));
		array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
		$this->sexo->EditValue = $arwrk;

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
					if ($this->idpersona->Exportable) $Doc->ExportCaption($this->idpersona);
					if ($this->tipo_persona->Exportable) $Doc->ExportCaption($this->tipo_persona);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->apellido->Exportable) $Doc->ExportCaption($this->apellido);
					if ($this->direccion->Exportable) $Doc->ExportCaption($this->direccion);
					if ($this->cui->Exportable) $Doc->ExportCaption($this->cui);
					if ($this->idpais->Exportable) $Doc->ExportCaption($this->idpais);
					if ($this->fecha_nacimiento->Exportable) $Doc->ExportCaption($this->fecha_nacimiento);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->sexo->Exportable) $Doc->ExportCaption($this->sexo);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idpersona->Exportable) $Doc->ExportCaption($this->idpersona);
					if ($this->tipo_persona->Exportable) $Doc->ExportCaption($this->tipo_persona);
					if ($this->nombre->Exportable) $Doc->ExportCaption($this->nombre);
					if ($this->apellido->Exportable) $Doc->ExportCaption($this->apellido);
					if ($this->direccion->Exportable) $Doc->ExportCaption($this->direccion);
					if ($this->cui->Exportable) $Doc->ExportCaption($this->cui);
					if ($this->idpais->Exportable) $Doc->ExportCaption($this->idpais);
					if ($this->fecha_nacimiento->Exportable) $Doc->ExportCaption($this->fecha_nacimiento);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->sexo->Exportable) $Doc->ExportCaption($this->sexo);
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
						if ($this->idpersona->Exportable) $Doc->ExportField($this->idpersona);
						if ($this->tipo_persona->Exportable) $Doc->ExportField($this->tipo_persona);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->apellido->Exportable) $Doc->ExportField($this->apellido);
						if ($this->direccion->Exportable) $Doc->ExportField($this->direccion);
						if ($this->cui->Exportable) $Doc->ExportField($this->cui);
						if ($this->idpais->Exportable) $Doc->ExportField($this->idpais);
						if ($this->fecha_nacimiento->Exportable) $Doc->ExportField($this->fecha_nacimiento);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->sexo->Exportable) $Doc->ExportField($this->sexo);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idpersona->Exportable) $Doc->ExportField($this->idpersona);
						if ($this->tipo_persona->Exportable) $Doc->ExportField($this->tipo_persona);
						if ($this->nombre->Exportable) $Doc->ExportField($this->nombre);
						if ($this->apellido->Exportable) $Doc->ExportField($this->apellido);
						if ($this->direccion->Exportable) $Doc->ExportField($this->direccion);
						if ($this->cui->Exportable) $Doc->ExportField($this->cui);
						if ($this->idpais->Exportable) $Doc->ExportField($this->idpais);
						if ($this->fecha_nacimiento->Exportable) $Doc->ExportField($this->fecha_nacimiento);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->sexo->Exportable) $Doc->ExportField($this->sexo);
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
