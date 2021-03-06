<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(10, "mci_Cate1logos", $Language->MenuPhrase("10", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(107, "mci_Administracif3n_de_Aplicacif3n", $Language->MenuPhrase("107", "MenuText"), "", 10, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(69, "mi_userlevels", $Language->MenuPhrase("69", "MenuText"), "userlevelslist.php", 107, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE);
$RootMenu->AddMenuItem(70, "mi_audittrail", $Language->MenuPhrase("70", "MenuText"), "audittraillist.php", 107, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}audittrail'), FALSE);
$RootMenu->AddMenuItem(67, "mi_usuario", $Language->MenuPhrase("67", "MenuText"), "usuariolist.php", 107, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}usuario'), FALSE);
$RootMenu->AddMenuItem(117, "mi_parametros_sistema", $Language->MenuPhrase("117", "MenuText"), "parametros_sistemalist.php", 107, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}parametros_sistema'), FALSE);
$RootMenu->AddMenuItem(6, "mi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pais'), FALSE);
$RootMenu->AddMenuItem(1, "mi_departamento", $Language->MenuPhrase("1", "MenuText"), "departamentolist.php?cmd=resetall", 6, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}departamento'), FALSE);
$RootMenu->AddMenuItem(5, "mi_municipio", $Language->MenuPhrase("5", "MenuText"), "municipiolist.php?cmd=resetall", 1, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}municipio'), FALSE);
$RootMenu->AddMenuItem(65, "mi_moneda", $Language->MenuPhrase("65", "MenuText"), "monedalist.php?cmd=resetall", 6, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}moneda'), FALSE);
$RootMenu->AddMenuItem(2, "mi_empresa", $Language->MenuPhrase("2", "MenuText"), "empresalist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}empresa'), FALSE);
$RootMenu->AddMenuItem(9, "mi_sucursal", $Language->MenuPhrase("9", "MenuText"), "sucursallist.php?cmd=resetall", 2, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}sucursal'), FALSE);
$RootMenu->AddMenuItem(14, "mi_producto_sucursal", $Language->MenuPhrase("14", "MenuText"), "producto_sucursallist.php?cmd=resetall", 9, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_sucursal'), FALSE);
$RootMenu->AddMenuItem(11, "mi_bodega", $Language->MenuPhrase("11", "MenuText"), "bodegalist.php?cmd=resetall", 9, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}bodega'), FALSE);
$RootMenu->AddMenuItem(13, "mi_producto_bodega", $Language->MenuPhrase("13", "MenuText"), "producto_bodegalist.php?cmd=resetall", 11, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_bodega'), FALSE);
$RootMenu->AddMenuItem(15, "mi_producto_historial", $Language->MenuPhrase("15", "MenuText"), "producto_historiallist.php?cmd=resetall", 13, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_historial'), FALSE);
$RootMenu->AddMenuItem(3, "mi_fabricante", $Language->MenuPhrase("3", "MenuText"), "fabricantelist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}fabricante'), FALSE);
$RootMenu->AddMenuItem(4, "mi_marca", $Language->MenuPhrase("4", "MenuText"), "marcalist.php?cmd=resetall", 3, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}marca'), FALSE);
$RootMenu->AddMenuItem(12, "mi_tipo_bodega", $Language->MenuPhrase("12", "MenuText"), "tipo_bodegalist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_bodega'), FALSE);
$RootMenu->AddMenuItem(18, "mi_tipo_documento", $Language->MenuPhrase("18", "MenuText"), "tipo_documentolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_documento'), FALSE);
$RootMenu->AddMenuItem(17, "mi_serie_documento", $Language->MenuPhrase("17", "MenuText"), "serie_documentolist.php", 18, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}serie_documento'), FALSE);
$RootMenu->AddMenuItem(111, "mi_tipo_pago", $Language->MenuPhrase("111", "MenuText"), "tipo_pagolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_pago'), FALSE);
$RootMenu->AddMenuItem(63, "mi_banco", $Language->MenuPhrase("63", "MenuText"), "bancolist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}banco'), FALSE);
$RootMenu->AddMenuItem(64, "mi_cuenta", $Language->MenuPhrase("64", "MenuText"), "cuentalist.php?cmd=resetall", 63, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cuenta'), FALSE);
$RootMenu->AddMenuItem(109, "mi_boleta_deposito", $Language->MenuPhrase("109", "MenuText"), "boleta_depositolist.php?cmd=resetall", 64, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}boleta_deposito'), FALSE);
$RootMenu->AddMenuItem(110, "mi_voucher_tarjeta", $Language->MenuPhrase("110", "MenuText"), "voucher_tarjetalist.php?cmd=resetall", 64, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}voucher_tarjeta'), FALSE);
$RootMenu->AddMenuItem(112, "mi_cheque_cliente", $Language->MenuPhrase("112", "MenuText"), "cheque_clientelist.php", 63, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cheque_cliente'), FALSE);
$RootMenu->AddMenuItem(108, "mi_categoria", $Language->MenuPhrase("108", "MenuText"), "categorialist.php", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}categoria'), FALSE);
$RootMenu->AddMenuItem(118, "mi_periodo_contable", $Language->MenuPhrase("118", "MenuText"), "periodo_contablelist.php?cmd=resetall", 10, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}periodo_contable'), FALSE);
$RootMenu->AddMenuItem(116, "mi_meta", $Language->MenuPhrase("116", "MenuText"), "metalist.php?cmd=resetall", 118, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}meta'), FALSE);
$RootMenu->AddMenuItem(114, "mi_fecha_contable", $Language->MenuPhrase("114", "MenuText"), "fecha_contablelist.php?cmd=resetall", 118, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}fecha_contable'), FALSE);
$RootMenu->AddMenuItem(7, "mi_producto", $Language->MenuPhrase("7", "MenuText"), "productolist.php?cmd=resetall", -1, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto'), FALSE);
$RootMenu->AddMenuItem(8, "mi_registro_sanitario", $Language->MenuPhrase("8", "MenuText"), "registro_sanitariolist.php?cmd=resetall", 7, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}registro_sanitario'), FALSE);
$RootMenu->AddMenuItem(113, "mi_producto_precio_historial", $Language->MenuPhrase("113", "MenuText"), "producto_precio_historiallist.php?cmd=resetall", 7, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_precio_historial'), FALSE);
$RootMenu->AddMenuItem(62, "mci_Documentos", $Language->MenuPhrase("62", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(23, "mi_documento_movimiento", $Language->MenuPhrase("23", "MenuText"), "documento_movimientolist.php", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_movimiento'), FALSE);
$RootMenu->AddMenuItem(20, "mi_documento_credito", $Language->MenuPhrase("20", "MenuText"), "documento_creditolist.php", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_credito'), FALSE);
$RootMenu->AddMenuItem(16, "mi_documento_debito", $Language->MenuPhrase("16", "MenuText"), "documento_debitolist.php?cmd=resetall", 62, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_debito'), FALSE);
$RootMenu->AddMenuItem(29, "mi_persona", $Language->MenuPhrase("29", "MenuText"), "personalist.php", -1, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}persona'), FALSE);
$RootMenu->AddMenuItem(25, "mi_cliente", $Language->MenuPhrase("25", "MenuText"), "clientelist.php?cmd=resetall", 29, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cliente'), FALSE);
$RootMenu->AddMenuItem(30, "mi_proveedor", $Language->MenuPhrase("30", "MenuText"), "proveedorlist.php?cmd=resetall", 29, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}proveedor'), FALSE);
$RootMenu->AddMenuItem(60, "mci_Pagos", $Language->MenuPhrase("60", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(27, "mi_pago_cliente", $Language->MenuPhrase("27", "MenuText"), "pago_clientelist.php?cmd=resetall", 60, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_cliente'), FALSE);
$RootMenu->AddMenuItem(28, "mi_pago_proveedor", $Language->MenuPhrase("28", "MenuText"), "pago_proveedorlist.php?cmd=resetall", 60, "", AllowListMenu('{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_proveedor'), FALSE);
$RootMenu->AddMenuItem(167, "mci_Reportes", $Language->MenuPhrase("167", "MenuText"), "reporte_cuenta_por_cobrar.php", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(168, "mci_Venta_Mostrador", $Language->MenuPhrase("168", "MenuText"), "factura.php", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
