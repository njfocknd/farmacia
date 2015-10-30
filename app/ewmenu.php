<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(10, "mci_Cate1logos", $Language->MenuPhrase("10", "MenuText"), "", -1, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mi_pais", $Language->MenuPhrase("6", "MenuText"), "paislist.php", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(1, "mi_departamento", $Language->MenuPhrase("1", "MenuText"), "departamentolist.php?cmd=resetall", 6, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mi_municipio", $Language->MenuPhrase("5", "MenuText"), "municipiolist.php?cmd=resetall", 1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, "mi_empresa", $Language->MenuPhrase("2", "MenuText"), "empresalist.php", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(9, "mi_sucursal", $Language->MenuPhrase("9", "MenuText"), "sucursallist.php?cmd=resetall", 2, "", TRUE, FALSE);
$RootMenu->AddMenuItem(14, "mi_producto_sucursal", $Language->MenuPhrase("14", "MenuText"), "producto_sucursallist.php?cmd=resetall", 9, "", TRUE, FALSE);
$RootMenu->AddMenuItem(11, "mi_bodega", $Language->MenuPhrase("11", "MenuText"), "bodegalist.php?cmd=resetall", 9, "", TRUE, FALSE);
$RootMenu->AddMenuItem(13, "mi_producto_bodega", $Language->MenuPhrase("13", "MenuText"), "producto_bodegalist.php?cmd=resetall", 11, "", TRUE, FALSE);
$RootMenu->AddMenuItem(15, "mi_producto_historial", $Language->MenuPhrase("15", "MenuText"), "producto_historiallist.php?cmd=resetall", 13, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mi_fabricante", $Language->MenuPhrase("3", "MenuText"), "fabricantelist.php", 10, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_marca", $Language->MenuPhrase("4", "MenuText"), "marcalist.php?cmd=resetall", 3, "", TRUE, FALSE);
$RootMenu->AddMenuItem(7, "mi_producto", $Language->MenuPhrase("7", "MenuText"), "productolist.php?cmd=resetall", 4, "", TRUE, FALSE);
$RootMenu->AddMenuItem(8, "mi_registro_sanitario", $Language->MenuPhrase("8", "MenuText"), "registro_sanitariolist.php?cmd=resetall", 7, "", TRUE, FALSE);
$RootMenu->AddMenuItem(12, "mi_tipo_bodega", $Language->MenuPhrase("12", "MenuText"), "tipo_bodegalist.php", 10, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
