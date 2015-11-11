<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(107, "mmci_Administracif3n_de_Aplicacif3n", $Language->MenuPhrase("107", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(69, "mmi_userlevels", $Language->MenuPhrase("69", "MenuText"), "userlevelslist.php", 107, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(70, "mmi_audittrail", $Language->MenuPhrase("70", "MenuText"), "audittraillist.php", 107, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}audittrail'), FALSE);
$RootMenu->AddMenuItem(67, "mmi_usuario", $Language->MenuPhrase("67", "MenuText"), "usuariolist.php", 107, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}usuario'), FALSE);
$RootMenu->AddMenuItem(62, "mmci_Documentos", $Language->MenuPhrase("62", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(23, "mmi_documento_movimiento", $Language->MenuPhrase("23", "MenuText"), "documento_movimientolist.php", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_movimiento'), FALSE);
$RootMenu->AddMenuItem(20, "mmi_documento_credito", $Language->MenuPhrase("20", "MenuText"), "documento_creditolist.php", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_credito'), FALSE);
$RootMenu->AddMenuItem(16, "mmi_documento_debito", $Language->MenuPhrase("16", "MenuText"), "documento_debitolist.php?cmd=resetall", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_debito'), FALSE);
$RootMenu->AddMenuItem(10, "mmci_Cate1logos", $Language->MenuPhrase("10", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mmi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pais'), FALSE);
$RootMenu->AddMenuItem(1, "mmi_departamento", $Language->MenuPhrase("1", "MenuText"), "departamentolist.php?cmd=resetall", 6, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}departamento'), FALSE);
$RootMenu->AddMenuItem(5, "mmi_municipio", $Language->MenuPhrase("5", "MenuText"), "municipiolist.php?cmd=resetall", 1, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}municipio'), FALSE);
$RootMenu->AddMenuItem(65, "mmi_moneda", $Language->MenuPhrase("65", "MenuText"), "monedalist.php?cmd=resetall", 6, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}moneda'), FALSE);
$RootMenu->AddMenuItem(2, "mmi_empresa", $Language->MenuPhrase("2", "MenuText"), "empresalist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}empresa'), FALSE);
$RootMenu->AddMenuItem(9, "mmi_sucursal", $Language->MenuPhrase("9", "MenuText"), "sucursallist.php?cmd=resetall", 2, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}sucursal'), FALSE);
$RootMenu->AddMenuItem(14, "mmi_producto_sucursal", $Language->MenuPhrase("14", "MenuText"), "producto_sucursallist.php?cmd=resetall", 9, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_sucursal'), FALSE);
$RootMenu->AddMenuItem(11, "mmi_bodega", $Language->MenuPhrase("11", "MenuText"), "bodegalist.php?cmd=resetall", 9, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}bodega'), FALSE);
$RootMenu->AddMenuItem(13, "mmi_producto_bodega", $Language->MenuPhrase("13", "MenuText"), "producto_bodegalist.php?cmd=resetall", 11, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_bodega'), FALSE);
$RootMenu->AddMenuItem(15, "mmi_producto_historial", $Language->MenuPhrase("15", "MenuText"), "producto_historiallist.php?cmd=resetall", 13, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_historial'), FALSE);
$RootMenu->AddMenuItem(3, "mmi_fabricante", $Language->MenuPhrase("3", "MenuText"), "fabricantelist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}fabricante'), FALSE);
$RootMenu->AddMenuItem(4, "mmi_marca", $Language->MenuPhrase("4", "MenuText"), "marcalist.php?cmd=resetall", 3, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}marca'), FALSE);
$RootMenu->AddMenuItem(7, "mmi_producto", $Language->MenuPhrase("7", "MenuText"), "productolist.php?cmd=resetall", 4, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto'), FALSE);
$RootMenu->AddMenuItem(8, "mmi_registro_sanitario", $Language->MenuPhrase("8", "MenuText"), "registro_sanitariolist.php?cmd=resetall", 7, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}registro_sanitario'), FALSE);
$RootMenu->AddMenuItem(113, "mmi_producto_precio_historial", $Language->MenuPhrase("113", "MenuText"), "producto_precio_historiallist.php?cmd=resetall", 7, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_precio_historial'), FALSE);
$RootMenu->AddMenuItem(12, "mmi_tipo_bodega", $Language->MenuPhrase("12", "MenuText"), "tipo_bodegalist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_bodega'), FALSE);
$RootMenu->AddMenuItem(18, "mmi_tipo_documento", $Language->MenuPhrase("18", "MenuText"), "tipo_documentolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_documento'), FALSE);
$RootMenu->AddMenuItem(17, "mmi_serie_documento", $Language->MenuPhrase("17", "MenuText"), "serie_documentolist.php", 18, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}serie_documento'), FALSE);
$RootMenu->AddMenuItem(111, "mmi_tipo_pago", $Language->MenuPhrase("111", "MenuText"), "tipo_pagolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_pago'), FALSE);
$RootMenu->AddMenuItem(63, "mmi_banco", $Language->MenuPhrase("63", "MenuText"), "bancolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}banco'), FALSE);
$RootMenu->AddMenuItem(64, "mmi_cuenta", $Language->MenuPhrase("64", "MenuText"), "cuentalist.php?cmd=resetall", 63, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cuenta'), FALSE);
$RootMenu->AddMenuItem(109, "mmi_boleta_deposito", $Language->MenuPhrase("109", "MenuText"), "boleta_depositolist.php?cmd=resetall", 64, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}boleta_deposito'), FALSE);
$RootMenu->AddMenuItem(110, "mmi_voucher_tarjeta", $Language->MenuPhrase("110", "MenuText"), "voucher_tarjetalist.php?cmd=resetall", 64, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}voucher_tarjeta'), FALSE);
$RootMenu->AddMenuItem(112, "mmi_cheque_cliente", $Language->MenuPhrase("112", "MenuText"), "cheque_clientelist.php", 63, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cheque_cliente'), FALSE);
$RootMenu->AddMenuItem(108, "mmi_categoria", $Language->MenuPhrase("108", "MenuText"), "categorialist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}categoria'), FALSE);
$RootMenu->AddMenuItem(29, "mmi_persona", $Language->MenuPhrase("29", "MenuText"), "personalist.php", -1, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}persona'), FALSE);
$RootMenu->AddMenuItem(25, "mmi_cliente", $Language->MenuPhrase("25", "MenuText"), "clientelist.php?cmd=resetall", 29, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cliente'), FALSE);
$RootMenu->AddMenuItem(30, "mmi_proveedor", $Language->MenuPhrase("30", "MenuText"), "proveedorlist.php?cmd=resetall", 29, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}proveedor'), FALSE);
$RootMenu->AddMenuItem(60, "mmci_Pagos", $Language->MenuPhrase("60", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(27, "mmi_pago_cliente", $Language->MenuPhrase("27", "MenuText"), "pago_clientelist.php?cmd=resetall", 60, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_cliente'), FALSE);
$RootMenu->AddMenuItem(28, "mmi_pago_proveedor", $Language->MenuPhrase("28", "MenuText"), "pago_proveedorlist.php?cmd=resetall", 60, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_proveedor'), FALSE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
